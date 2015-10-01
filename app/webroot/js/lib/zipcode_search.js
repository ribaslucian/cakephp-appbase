var ZipcodeSearch = function () {

    /**
     * Identificador do elemento que ao ser clicado 
     * buscará os dados e enviará para seus elementos destinos.
     * 
     * @type string
     */
    this.submit = config.zipcode_search.submit;

    /**
     * Identificador do elemento que o usuário irá entrar o CEP.
     * 
     * @type string
     */
    this.cep = config.zipcode_search.cep;

    /**
     * Identificador do elemento que receberá a rua.
     * 
     * @type string
     */
    this.street = config.zipcode_search.street;

    /**
     * Identificador do elemento que receberá a bairro.
     * 
     * @type string
     */
    this.neighborhood = config.zipcode_search.neighborhood;

    /**
     * Identificador do elemento que receberá a cidade.
     * 
     * @type string
     */
    this.city = config.zipcode_search.city;

    /**
     * Identificador do elemento que receberá o estado.
     * 
     * @type string
     */
    this.state = config.zipcode_search.state;

    /**
     * URL que será requisitada para obter os dados stringdo endereço.
     * 
     * @type url
     */
    this.url = config.zipcode_search.url;

    /**
     * Mensagens que será retornado para o usuário caso ocarra algum erro.
     * not_count: CEP não identificado.
     * connection: Cliente sem conexão com a internet.
     */
    this.message = {
        not_fount: config.zipcode_search.message.not_found,
        connection: config.zipcode_search.message.connection,
    };

    /**
     * Evento click no elemento de submit do CEP.
     */
    $(this.submit).click(function () {
        $.ajax({
            dataType: 'JSON',
            url: zcsearch.url + "" + $(zcsearch.cep).val(),
            success: function (data) {
                
                // Cep não encontrado
                if (data == 0)
                    return alert(zcsearch.message.not_fount);

                // preenchendo valores
                data.endereco = data.endereco.replace('Rua ', '');
                $(zcsearch.street).val(data.endereco);
                $(zcsearch.neighborhood).val(data.bairro);
                $(zcsearch.city).val(data.cidade);
                $(zcsearch.state).val(data.uf);
            },
            // Sem conexão com a internet, ou algum erro desconhecido.
            error: function () {
                alert(zcsearch.message.connection);
            }
        });
    });
}

var zcsearch = new ZipcodeSearch();
