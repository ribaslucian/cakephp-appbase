var config = {

    page: {
        loader: '.jq_page_loader'
    },

    path: {
        url_base: '/ti/sistemas/administrativo/'
    },

    close: {
        dimmer: '.jq_close_dimmer',
        modal: '.jq_close_modal',
    },

    show_hide: {
        block: '.jq_show_hide_block',
        '.jq_show_forget_password': '.jq_show_login'
    },

    zipcode_search: {
        submit: '.jq_zipcode_submit',
        cep: '.jq_zipcode',
        street: '.jq_zipcode_street',
        neighborhood: '.jq_zipcode_neighborhood',
        state: '.jq_zipcode_state',
        url: 'http://clareslab.com.br/ws/cep/json/',
        message: {
            not_found: 'O cep informado não foi localido. Por favor, preencha os dados manualmente.',
            connection: 'Não foi possível buscar os dados, verifique se o CEP informado é válido e se você está conectado na internet ou preencha manualmente os dados.'
        }
    },

    filter_local: {
        '.jq_filter_local_input_1': '.jq_filter_local_element_1',
        '.jq_filter_local_input_2': '.jq_filter_local_element_2'
        // others_inputs: others_entities...
    },

    cart: {
        attr_product_id: 'product',
        bt_product_insert: '.js_id_cart_product_insert',
        bt_product_remove: '.js_id_cart_product_remove',
        product_name: '.js_id_cart_product_name',
        product_value: '.js_id_cart_product_value',
        cart: '.js_id_cart',
        products: '.js_id_cart_products',
        product: '.js_id_cart_product',
        product_counter: '.js_id_cart_product_counter',
        total: '.js_id_cart_total',
        bt_finalize: '.js_id_cart_finalize',
        url_get_virtual_product: 'admin/html/product',
        url_send: 'admin/html/product'
    },

    icon_submit: '.jq_icon_submit'

};
