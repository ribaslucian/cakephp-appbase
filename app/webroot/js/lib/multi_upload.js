function MultiUpload() {

    /**
     * Estenções de arquivo que será permitido o upload.
     */
    this.allow_extensions = ['gif', 'jpg', 'png'];

    /**
     * Extenções de arquivos e seus respectivos tipos.
     * Necessário para a classe entender o que está sendo enviado.
     */
    this.extensions = {
        image: ['gif', 'jpg', 'png']
    }

    /**
     * Ao enviar os arquivos para o servidor haverá dois indicies contendo
     * valores deste plugin:
     * - Array de Arquivos: Representa todos os arquivos 
     * selecionados incluindo os removidos.
     * - Arquivo Selecionados: Representa os arquivo que não foram removidos,
     * ou seja, os quais o usuário realmente deseja enviar. Estes valores 
     * estarão representados por uma string com os índices dos arquivos que
     * não foram removidos. Estes indices são references ao Array de Arquivos.
     * 
     * Este caracter separator é o caracter de join dos indices de arquivos que
     * não foram removidos, bastando dar um explode com ele no lado do servidor.
     */
    this.separator = '-';

    /**
     * Indice que será enviado a unidão dos arquivos não removidos.
     */
    this.post_key_selected = 'data[multi_upload_files_selected]';

    /**
     * Atributo explicito no elemento, contém o ID do mesmo: file="ID".
     */
    this.attr_id = 'file';

    /**
     * Identificador do elemento que servirá 
     * para selecionar e guardar todos os arquivos.
     */
    this.selector = '.jq_id_multi_upload_selector';

    /**
     * Identificador do elemento que ao ser clicado irá disparar um trigger 'click' no elemento
     * que contém o identificador do atributo this.selector.
     */
    this.loader = '.jq_id_multi_upload_loader';

    /**
     * Identificador do elemento que representará uma 
     * miniatura do arquivo enviado, caso o mesmo seja imagem.
     */
    this.mini = '.jq_id_multi_upload_mini';
    this.mini_class_image = 'jq_id_multi_upload_is_image';

    /**
     * Identificador do elemento que irá conter 
     * sub elementos HTML que representaram os arquivos.
     */
    this.container = '.jq_id_multi_upload_container';

    /**
     * Identificador do elemento que será apresentado
     * enquando os arquivos são carregador na página.
     */
    this.loading = '.jq_id_mup_loading';

    /**
     * Elemento virtual que contém o html de um arquivo 
     * será apresentado dentro do elemento this.container,
     * seu valor é iniciado na instância desta classe.
     */
    this.virtual_file = {
        url_for_get: 'admin/mup/html/file',
        reponse_key: 'html',
        html: '',
    };

    /**
     * Resumo dos arquivos enviados, deixando salvo apenas os valores 
     * nos indices: {id: '', name: '', extension: '', size: '', path: ''}
     */
    this.files_extract = {};

    /**
     * Contator ID virtual que será fornecido
     * para os arquivos durante duas inserções.
     */
    this.id = 0;

    /**
     * Evento de submit dos arquivos (considerando que está sendo feito atravéz
     * de um formulário 'pai'). Neste evento é necessário inserir um novo input
     * contendo os dados dos arquivos selecionador e não removidos, este que 
     * estão armazenador em this.files_extract e que serão agrupados pelo valor 
     * de this.separator;
     */
    $(this.selector).parents('form').submit(function () {
        var join = key_join(mup.files_extract, mup.separator);
        $(this).append('<input type="text" name="multi_upload_files_selected" value="' + join + '" />');
    });

    /**
     * Evento de clique no elemento de carregar um arquivo.
     */
    $(this.loader).click(function () {
        $(mup.selector).trigger('click');
    });

    /**
     * Evento que representa a inserção de um ou mais arquivos no formulário.
     */
    $(this.selector).change(function () {
        // Apresentar \loading enquando de arquivos processa o \upload
        $(mup.loading).fadeIn('fast');

        // Efetuando/Armazenando dados dos arquivos no Array files
        // e criando uma réplica resumida em Array files_extrapt
        $.each(this.files, function (key, file) {
            var extract = mup.get_file_extract(file);
            
            if (mup.allow(extract.extension)) {
                mup.files_extract[mup.id] = extract;
                mup.set_html_file_on_container();
                mup.set_mini(file);
                mup.id++;
            } else {
                alert('Insira apenas arquivos de extensão: ' + array_join(mup.allow_extensions, ' | '));
            }
        });

        // Ocultar \loading após arquivos serem 
        // concedidos, aguardar alguns instantes para isso.
        setTimeout(function () {
            $(mup.loading).fadeOut('fast');
        }, 500);
    });

    this.get_file_extract = function (file) {
        var extension = file.name.replace(/^.*\./, '');
    
        return {
            extension: extension,
            name: file.name.replace('.' + extension, ''),
            size: (file.size / (1024 * 1024)).toFixed(2),
            path: file.path
        };
    }

    /**
     * Remove um arquivo do elemento this.container e do array this.files_extract
     * 
     * @param {int} id: ID do arquivo que deseja remover.
     * 
     * @returns {void}
     */
    this.remove_file = function (id) {
        delete mup.files_extract[id];

        mup.get_element_file(id).hide('fast', function () {
            $(this).remove();
        });
    }

    /**
     * Apresenta ou esconde o elemento de um determinado arquivo da página.
     * 
     * @param {int} id: ID do arquivo correspondente ao elemento.
     * @param {bool} show: True para apresentar e False para esconder o elemento;
     * 
     * @returns {void}
     */
    this.show_element_file = function (id, show) {
        var file = mup.get_element_file(id);
        show ? file.show('fast') : file.hide('fast');
    }

    /**
     * Captura um elemento HTML correspondente a um arquivo.
     * 
     * @param {type} id: ID do arquivo correspondente ao elemento.
     * 
     * @returns {$} elemento jquery.
     */
    this.get_element_file = function (id) {
        return $('[' + mup.attr_id + '="' + id + '"]');
    }

    /**
     * Insere um novo arquivo resumido no array this.files_extract
     * 
     * @param {type} file: Arquivo de um determinado input
     * 
     * @returns {void}
     */
    this.set_file_extract = function (file) {
        var extension = file.name.replace(/^.*\./, '');

        mup.files_extract[mup.id] = {
            extension: extension,
            name: file.name.replace('.' + extension, ''),
            size: (file.size / (1024 * 1024)).toFixed(2),
            path: file.path
        };
    }

    /**
     * Define o modelo genérico HTML de um arquivo na página;
     * 
     * @returns {void}
     */
    this.set_virtual_file = function () {
        var _html, _mup = this;

        post(this.virtual_file.url_for_get, {
            async: false,
            success: function (response) {
                _html = response[_mup.virtual_file.reponse_key];
            }
        });

        this.virtual_file.html = _html;
    }

    /**
     * Atribui o HTML de um arquivo na página;
     * 
     * @returns {void}
     */
    this.set_html_file_on_container = function () {
        var html = mup.virtual_file.html + "";
        html = html.replace(/\{name\}/g, mup.files_extract[mup.id].name);
        html = html.replace(/\{extension\}/g, mup.files_extract[mup.id].extension);
        html = html.replace(/\{size\}/g, mup.files_extract[mup.id].size);
        html = html.replace(/\{id\}/g, mup.id);

        $(mup.container).append(html);
        mup.show_element_file(mup.id, true);
    }

    /**
     * Define e miniatura de um arquivo em seu respectivo elemento html.
     * 
     * @param {InputFile} file: Arquivo de input que deseja miniaturizar.
     * 
     * @return {void}
     */
    this.set_mini = function (file) {
        var mini = $(mup.mini, mup.get_element_file(mup.id));

        if (mup.is_img(mup.id)) {
            // Zerando contéudo do elemento que receberá a miniatura.
            mini.html('');

            // Efetuando a leitura do arquivo enviado e definindo-o na miniatura.
            var reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onloadend = function () {
                mini.attr('style', 'background-image: url(' + this.result + ');');
                mini.addClass(mup.mini_class_image);
            }
        }
    }

    /**
     * Especifica se um determinado arquivo enviado é uma imagem.
     * 
     * @param {int} id: ID do arquivo que deseja efetuar a verificação.
     * 
     * @returns {bool}: É ou Não uma imagem.
     */
    this.is_img = function (id) {
        var ext = mup.files_extract[id].extension;
        return $.inArray(ext, mup.extensions.image) > -1;
    }

    /**
     * Verifica se o arquivo que está sendo enviado possui um extensão válida.
     * 
     * @param {int} id: ID do arquivo que deseja efetuar a verificação.
     * 
     * @returns {bool}: É ou Não É válido.
     */
    this.allow = function (extension) {
        return $.inArray(extension, mup.allow_extensions) > -1;
    }

    this.set_virtual_file();
}

var mup = new MultiUpload();
