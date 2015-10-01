(function($) {

    // Mostrar conteúdo da página e esconder o PageLoader
    $('.body').show();
    $(config.page.loader).fadeOut('fast');

    // Momentos em que o page_loader deve aparecer na tela.
//    $('form').submit(function() {
//        $(config.page.loader).fadeIn('fast');
//    });

    $(window).on("beforeunload", function() {

        $.ajax({
            url: url('/admin/app/closeDbConnections'),
            type: 'POST',
            dataType: 'JSON',
            async: true
        });
        
        $('.body').hide();
        $(config.page.loader).fadeIn('fast');
    });

    $(document).keydown(function(e) {
//        if (e.which == 116)
//            $(config.page.loader).fadeIn('fast');

        if (e.which == 27)
            $('.jq_father_modal').fadeOut('fast');
    });

    //--

    // Inicialização dos elementos SHOW_HIDE
    $.each(config.show_hide, function(show, hide) {
        if (show != 'block') {
            $(show).click(function() {
                $(this).parents(config.show_hide.block).hide();
                $(hide).parents(config.show_hide.block).fadeIn('fast');
            });

            $(hide).click(function() {
                $(this).parents(config.show_hide.block).hide();
                $(show).parents(config.show_hide.block).fadeIn('fast');
            });
        }
    });

    // Botões de fechamento de elementos
    $(config.close.dimmer).click(function() {
        $(this).parents('.dimmer').fadeOut('fast').done(function() {
            $(this).remove();
        });
    });

    $(config.close.modal).click(function() {
        $(this).parents('.modal').fadeOut('fast').done(function() {
            $(this).remove();
        });
    });

    // icon_submit: Submitar formulario com clique em um icon
    $(config.icon_submit).click(function() {
        if (confirm($(this).attr("message")))
            $(this).parent('form').submit();
    });

    // $('.page.content').fadeIn('fast');

    /**
     * Ativando comportamentos da aplicação
     */
    //$('.modal').modal('show');
    // $(".popup_hover").popup({on: "hover"});
    // $(".popup_focus").popup({on: "focus"});
    $(".ui.accordion").accordion();
    $(".ui.checkbox").checkbox();
    $(".ui.dropdown").dropdown({on: 'click', transition: 'scale'});
    $('.ui.dropdown.hover').dropdown({on: 'hover', transition: 'scale'});

//    $('.message').fadeIn('sslow');
    $('.message .close').on('click', function() {
        $(this).closest('.message').fadeOut('fast');
    });

    $(".disabled").click(function() {
        return false;
    });

    $("[confirm]").click(function() {
        return confirm($(this).attr("confirm"));
    });

    // Submitar formulário com o click de um elemento 
    // qualquer que possua o atributo type='submit'
    $('[type=submit').click(function() {
        if ($(this).is('[form-confirm]')) {
            if (confirm($(this).attr("form-confirm")))
                $(this).parent('form').submit();

            return false;
        }

        $(this).parent('form').submit();
    });

    // Maskarás da applicação
    $(".date.mask").mask("99/99/9999");
    $(".date_hour.mask").mask("99/99/9999 99:99");
    $(".hour.mask").mask("99:99");
    $(".cpf.mask").mask("999.999.999-99");
    $(".cnpj.mask").mask("99.999.999/9999-99");
    $(".rg.mask").mask("99.999.999-9");
    $(".phone.mask").mask("(99) 9999-9999");
    $(".cep.mask").mask("99999-999");

    // $('.mask.money').attr('data-prefix', 'R$ ');
    $('.mask.money').attr('data-thousands', '.');
    $('.mask.money').attr('data-decimal', ',');
    $('.mask.money').maskMoney();

    $('.mask.number').keydown(function(e) {
        allow_key_code = [
            8, 9, 13, 37, 38, 39, 40, 46, 48, 49, 50,
            51, 52, 53, 54, 55, 56, 57, 96, 97, 98, 99,
            100, 101, 102, 103, 104, 105, 116, 109, 189
        ];
        if ($.inArray(e.keyCode, allow_key_code) == -1)
            return false;
        return true;
    });

    $('.mask.natural.number').keydown(function(e) {
        allow_key_code = [
            8, 9, 13, 37, 38, 39, 40, 46, 48, 49, 50,
            51, 52, 53, 54, 55, 56, 57, 96, 97, 98, 99,
            100, 101, 102, 103, 104, 105, 116
        ];
        if ($.inArray(e.keyCode, allow_key_code) == -1)
            return false;
        return true;
    });

    $('table.hover tr').hover(
            function() {
                $('td', $(this)).attr('style', 'background-color: #fff !important; box-shadow: 6px 0px 8px #ccc !important;');
            },
            function() {
                $('td', $(this)).attr('style', '');
            }
    );

    $('[show-modal]').click(function() {
        var modal_id = $(this).attr('show-modal');

        $(modal_id).modal('show');
    });
    
})(jQuery);
