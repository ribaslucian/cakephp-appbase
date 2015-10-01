function Cart() {

    /**
     * ELEMENTO_IDENTIFICAÇÃO
     * Insira este atributo e preencha-o com o ID do produto nos elementos:
     * - Botão inserção do produto no carrinho;
     * - Elemento que representa o produto no carrinho;
     * ex: <... product="1" .../> (este elemento representa o produto 1)
     */
    this.attr_product_id = config.cart.attr_product_id;

    /**
     * ELEMENTO_INSERCAO
     * Insira este Identificador no elemento
     * que irá Inserir o produto do carrinho.
     */
    this.bt_product_insert = config.cart.bt_product_insert;

    /**
     * ELEMENTO_REMOÇÃO
     * Insira este Identificador no elemento
     * que irá Retirar o produto do carrinho.
     */
    this.bt_product_remove = config.cart.bt_product_remove;

    /**
     * ELEMENTO_NOME_PRODUTO
     * Insira este Identificador no elemento que conterá o nome de um
     * determinado produto.
     * - Este elemento deve ser irmão do ELEMENTO_IDENTIFICAÇÃO, ou seja, 
     * filho de uma mesma tag.
     */
    this.product_name = config.cart.product_name;

    /**
     * ELEMENTO_VALOR_PRODUTO
     * Insira este Identificador no elemento 
     * que conterá o nome de um determinado produto.
     * - Este elemento deve ser irmão do ELEMENTO_INSERCAO,
     * ou seja, filho de uma mesma tag.
     */
    this.product_value = config.cart.product_value;

    /**
     * ELEMENTO_CARRINHO
     * Insira este Identificador no elemento que representará o carrinho
     * de compras, onde conterá os produtos inseridos, totais, e opção
     * de finalização de compra.
     */
    this.cart = config.cart.cart;

    /**
     * ELEMENTO_PRODUTOS
     * Insira este Identificador no elemento que conterá os produtos inseridos.
     * - Este elemento deve ser filho do ELEMENTO CARRINHO.
     */
    this.products = config.cart.products;

    /**
     * ELEMENTO_PRODUTO
     * Insira este Identificador no elemento que representará um produto no
     * carrinho. 
     * - Este elemento deve ser filho do ELEMENTO_PRODUTOS.
     */
    this.product = config.cart.product;

    /**
     * ELEMENTO_QUANTIDADE
     * Insira este Identificador no elemento que representará a quantidade 
     * unitária de um produto inserido no carrinho. 
     * - Este elemento deve ser filho do ELEMENTO_PRODUTO.
     */
    this.product_counter = config.cart.product_counter;

    /**
     * ELEMENTO_TOTAL
     * Insira este Identificador no elemento que representará o valor total
     * da compra.
     * - Este elemento deve ser filho do ELEMENTO_CARRINHO.
     */
    this.total = config.cart.total;

    /**
     * ELEMENTO_FINALIZADOR
     * Insira este Identificador no elemento que será responsável pela 
     * finalização da compra.
     * - Este elemento deve ser filho do ELEMENTO_CARRINHO.
     */
    this.bt_finalize = config.cart.bt_finalize;

    /**
     * URL que será enviada a compra após sua finalização.
     */
    this.url_to_send = url(config.cart.url_send);

    /**
     * URL que será requisitada para capturar o HTML de um produto virtual.
     */
    this.url_get_virtual_product = config.cart.url_get_virtual_product;

    /**
     * Elemento virtual (HTML) genérico de um produto inserido no carrinho,
     * serve como base a cada inserção.
     */
    this.product_virtual;

    /**
     * Captura com uma requisição AJAX o elemento html que representará um 
     * produto inserido no carrinho, deixa em memória este HTML para cada
     * inserção de produto.
     * 
     * @returns {void}
     */
    this.set_product_virtual = function () {
        var html;

        post(this.url_get_virtual_product, {
            async: false,
            success: function (response) {
                html = response.html;
            },
        });

        this.product_virtual = html;
    }

    /**
     * Evendo de clique no botão de Inserção de um derterminado produto.
     */
    $(this.bt_product_insert).click(function () {
        var product_id = cart.get_product_id($(this));
        var product_name = cart.get_product_name(product_id);

        cart.show_bt_product_remove(product_id);
        cart.show_cart(true);
        cart.add_html_product_on_cart(product_id, product_name);
        cart.product_unit_add(product_id, 1);
    });

    /**
     * Evendo de clique no botão de Remoçao de um derterminado produto.
     */
    $(this.bt_product_remove).click(function () {
        var product_id = cart.get_product_id($(this));

        cart.show_bt_product_insert(product_id);
        cart.rm_html_product_on_cart(product_id);
        cart.product_unit_add(product_id, -1);

        if (cart.get_total_cart() == 0)
            cart.show_cart(false);
    });

    /**
     * Evento de clique no botão de finalização da compra.
     */
    $(this.bt_finalize).click(function () {
        alert(cart.url_to_send);
    });

    /**
     * Captura o ID do produto correspondente ao um determinado elemento.
     * 
     * @param {$} element: Objeto jQuery que se deseja obter o ID do produto.
     * @return {int} ID do produto.
     */
    this.get_product_id = function (element) {
        var product = element.parents('[' + cart.attr_product_id + ']');
        return product.attr(cart.attr_product_id);
    }

    /**
     * Captura o NOME de um produto apresentado na tabela.
     * 
     * @param {int} product_id: ID do produto que se deseja obter o nome.
     * @return {void}
     */
    this.get_product_name = function (product_id) {
        var column = $('[' + cart.attr_product_id + '="' + product_id + '"]');
        return $(cart.product_name, column).html();
    }

    /**
     * Apresenta o botão de Remoção de um dertminado produto do 
     * carrinho, em simultêneo Esconde o botão de Inserção do mesmo.
     * 
     * @param {int} product_id: ID do produto que deseja manipular os botões.
     * @return {void}
     */
    this.show_bt_product_insert = function (product_id) {
        $(cart.bt_product_remove, $('[' + cart.attr_product_id + '="' + product_id + '"]')).hide();
        $(cart.bt_product_insert, $('[' + cart.attr_product_id + '="' + product_id + '"]')).show();
    }

    /**
     * Apresenta o botão de Inserção de um dertminado produto no 
     * carrinho, em simultêneo Esconde o botão de Remoção do mesmo.
     * 
     * @param {int} product_id: ID do produto que deseja manipular os botões.
     * @return {void}
     */
    this.show_bt_product_remove = function (product_id) {
        $(cart.bt_product_insert, $('[' + cart.attr_product_id + '="' + product_id + '"]')).hide();
        $(cart.bt_product_remove, $('[' + cart.attr_product_id + '="' + product_id + '"]')).show();
    }

    /**
     * Apresenta ou esconde o carrinho de compras da Interface.
     * 
     * @param {bool} show: True para apresentar, False para esconder.
     * @return {void}
     */
    this.show_cart = function (show) {
        if (show) {
            if ($(cart.cart).is(':hidden'))
                $(cart.cart).show('fast');
        } else {
            $(cart.total).html(cart.money_format(0));
            $(cart.cart).hide('fast');
        }
    }

    /**
     * Cria o conteúdo de um novo produto e apresenta ele dentro do carrinho.
     * 
     * @param {int} id: ID do produto que deeja inserir no carrinho.
     * @param {string} name: Nome do produto que deseja inserir no carrinho.
     * @return {void}
     */
    this.add_html_product_on_cart = function (id, name) {
        var html = cart.product_virtual + "";

        html = html.replace(/\{id\}/g, id);
        html = html.replace(/\{name\}/g, name);

        $(cart.products).append(html);
        cart.get_product_element(id).show('fast');
    }

    /**
     * Remove o conteúdo de um produto e apresentado dentro do carrinho.
     * 
     * @param {int} id: ID do produto que deseja retirar no carrinho.
     * @return {void}
     */
    this.rm_html_product_on_cart = function (id) {
        var product = cart.get_product_element(id);
        product.hide('fast', function () {
            $(this).remove();
        });
    }

    /**
     * Captura o elemento correspondente a um 
     * determinado produto dentro do carrinho de compras.
     * 
     * @param {int} product_id: ID do produto que deseja capturar.
     * @returns {$}: Objeto jQuery do prouto.
     */
    this.get_product_element = function (product_id) {
        return $(cart.product + '[' + cart.attr_product_id + '="' + product_id + '"]');
    }

    /**
     * Diminui a quantidade unitária de um produto inserido no carrinho;
     * 
     * @param {int} product_id: ID do produto que se deseja alterar a quantidade.
     * @param {int} amount: Quantidade que deseja inserir ou remover.
     * @return {void}
     */
    this.product_unit_add = function (product_id, amount) {

        // Capturando produto e alterado sua quantidade unitária
        var product = cart.get_product_element(product_id);
        var counter = parseInt($(cart.product_counter, product).html()) + amount;
        $(cart.product_counter, product).html(counter);

        // Alterando valor total do carrinho, inserindo ou retirando valor R$
        var product_value = cart.get_product_value(product_id);
        if (amount < 1) {
            product_value = 0 - product_value;
        }
        cart.add_on_total_cart(product_value);

        // Caso a quantidade do produto zere, ele dever ser retirado do
        // carrinho. Seu botão de inserção deve ser liberado novamente.
        if (counter < 1) {
            cart.rm_html_product_on_cart(product_id);
            cart.show_bt_product_insert(product_id);
        }

        // Caso todos os produtos sejam retirados do 
        // carrinho, o mesmo deve ser escondido.
        if (cart.get_total_cart() == 0)
            cart.show_cart(false);

        // Atualizando Cookies de sistema
        post('/admin/cart/add', {
            data: {
                id: product_id,
                amount: amount,
                value: cart.get_product_value(product_id),
            },
            success: function (data) {
//                alert(data);
            }
        });
    }

    /**
     * Adicionar uma valor monetário no total acumulado do carrinho.
     * 
     * @param {int/float} value: Valor que se deseja adicionar
     * @return {void}
     */
    this.add_on_total_cart = function (value) {
        $(cart.total).fadeOut('fast');

        var current_value = $(cart.total).html();
        current_value = cart.money_unformat(current_value);
        current_value += value;

        $(cart.total).html(cart.money_format(current_value));

        $(cart.total).fadeIn('fast');
    }

    /**
     * Captura o valor total corrente do carrinho.
     * 
     * @returns {float} valor
     */
    this.get_total_cart = function () {
        var current_value = $(cart.total).html();
        return cart.money_unformat(current_value);
    }

    /**
     * Captura o valor de um determinado produto.
     * @param {int} product_id: ID do produto que se deseja obter o valor.
     * @returns {float} valor do produto.
     */
    this.get_product_value = function (product_id) {
        var value = " " + $(cart.product_value, $('[product="' + product_id + '"]')).html();
        return cart.money_unformat(value);
    }

    /**
     * Formata um valor Float/Integer para um aspecto monetário.
     * 
     * @param {int/float} value: Valor que se deseja formatar.
     * @returns {string} valor formatado.
     */
    this.money_format = function (value) {
        return accounting.formatMoney(value, "R$ ", 2, ".", ",")
    }

    /**
     * Retorna um valor formatado pelo 
     * médoto {money_format} para seu valor float.
     * 
     * @param {string} value: Valor que se deseja desformatar.
     * @returns {float} valor desformatado.
     */
    this.money_unformat = function (value) {
        return accounting.unformat(value, ",");
    }

    // Métodos de inicialização na instância
    this.set_product_virtual();
}

var cart = new Cart();