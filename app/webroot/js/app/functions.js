/**
 * Verifica se uma determinada variável está ou não vazia.
 * 
 * @param {?} value
 * @returns {Boolean}
 */
function isEmpty(value) {
    return !$.trim(value)
}

/**
 * Efetua a união dos valores não vazios de um Array ou Object Jquery;
 * 
 * @param {object|Array} object: Array ou Objeto que deseja unir os valores
 * @param {type} separator: Caracter que será utilizado para separar os valores
 * 
 * @returns {string} join: União dos valores.
 */
function array_join(object, separator) {
    var join = '';

    $.each(object, function (key, value) {
        if ($.trim(value))
            join += value + separator;
    });

    return join.slice(0, -(separator.length));
}

/**
 * Efetua a união das chaves não vazias de um Array ou Object Jquery.
 * 
 * @param {object|Array} object: Array ou Objeto que deseja unir as chaves.
 * @param {type} separator: Caracter que será utilizado para separar os valores.
 * 
 * @returns {string} join: União das chaves.
 */
function key_join(object, separator) {
    var join = '';

    $.each(object, function (key, value) {
        if ($.trim(value))
            join += key + separator;
    });

    return join.slice(0, -(separator.length));
}

/**
 * Selecionador de vários registro para uma determinada ação
 */
function multiSelected($options) {
    $form = $($options.form)
    $selector = $($options.selector)
    $submit = $("[type=submit]", $form)
    $totalSelected = $("span", $submit)
    $selected = $("[type=hidden]", $form).attr("value", "")

    // definindo aspecto inicial do registros
    $selector.html($options.unselected)

    // clicando no elemento de seleção
    $selector.click(function () {
        $tr = $(this).parents("tr")
        $recordId = $tr.attr("jRecord-id") + ""

        // alterando aspecto da linha clicada e do botão de submit
        if ($tr.attr("jIsSelected") == "true") {
            $tr.attr("jIsSelected", "false")
            $(this).html($options.unselected)
            $totalSelected.html(parseInt($totalSelected.html()) - 1)
            $selected.attr("value", ($selected.attr("value")).replace($recordId, ""))
            $tr.attr("style", "background-color: none")
        } else {
            $tr.attr("jIsSelected", "true")
            $(this).html($options.selected)
            $totalSelected.html(parseInt($totalSelected.html()) + 1)
            $selected.attr("value", $selected.attr("value") + $recordId)
            $tr.attr("style", "background-color: #fcf8e3 !important")
        }

        // alterar aspector do botão de submit
        $submitClass = $submit.attr("class")
        if (parseInt($totalSelected.html()) <= 0) {
            //$submit.fadeOut("fast")
            $submit.attr("class", $submitClass.replace("active", "disabled"))
        } else {
            //$submit.fadeIn("fast")
            $submit.attr("class", $submitClass.replace("disabled", "active"))
        }
    })
}

/**
 * Clicando em um botão de um determinado item, inserir o valor 
 * ID em um input invisível que irá conter todos os selecionados
 */
function adder() {
    $('.__adder').click(function () {
        container = '.__container';
        $this = jQuery(this)
        if ($this.attr('status') == 0) {
            $this.attr('status', 1).html('<i class="icon minus"></i>').removeClass('basic').addClass('red')
            product = $this.attr('product')
            products = $('.__container').attr('value')
            $('.__container').val(products + '' + product + ';')
        } else {
            $this.attr('status', 0).html('<i class="icon add"></i>').removeClass('red').addClass('basic')
            product = $this.attr('product')
            products = $('.__container').attr('value')
            $('.__container').val(products.replace(product + ';', ''))
        }
    })
}

/**
 * 
 * Efetua uma requisição HTTP utilizando o método POST (AJAX)
 * como padrão. Tem como objetivo preencher valores básicos,
 * deixando assim a referência da função mais clara e limpa.
 * 
 * @param {String} route
 * @param {ObjectJquery} options
 */
function post(route, options) {
    $.ajax($.extend({
        url: url(route),
        type: 'POST',
        dataType: 'JSON',
    }, options));
}

/**
 * Gerador de URL apartir de um rota da aplicação.
 * Utilizado em quaisquer requisições HTTP.
 * 
 * @param {String} route
 */
function url(route) {
    return config.path.url_base + route;
    // return $('.base.url').attr('value') + route;
}



//var JFilter = {
//    filter: '[jFilterName="{name}"]',
//    selector: ".jFieldSelector",
//    selected: ".jFieldSelected",
//    form: ".jFilterForm",
//    submit: ".jFilterSubmit",
//    //
//    initialize: function () {
//        $(JFilter.getSelected()).show()
//        JFilter.alternator()
//        JFilter.send()
//    },
//    getSelected: function () {
//        $name = Validate.regex.replace($(JFilter.selected).html(), /[ \t\n\r\f\v]/ig).toLowerCase()
//        return JFilter.filter.replace("{name}", $name)
//    },
//    alternator: function () {
//        $(JFilter.selector).mousedown(function () {
//            current = JFilter.getSelected()
//        })
//        $(JFilter.selector).bind("click keyup", function () {
//            $(current).hide()
//            $(JFilter.getSelected()).show()
//        })
//    },
//    getParams: function () {
//        $params = $(JFilter.form).attr('url')
//
//        $("input", $(".jFilterForm")).each(function ($index, $value) {
//            if ($($value).val() != "") {
//                $fvalue = Validate.regex.replace($($value).val(), /[\/]/ig)
//                $params += $($value).attr("name") + ":" + $fvalue + "/"
//            }
//        })
//        return $params
//    },
//    send: function () {
//        $(JFilter.submit).click(function () {
//            $(window.document.location).attr('href', JFilter.getParams())
//        })
//
//        $(JFilter.form).keyup(function (e) {
//            if (e.which == 13) {
//                $(window.document.location).attr('href', JFilter.getParams())
//            }
//        })
//    }
//}
//
///**
// * Classe responsável por determinadas variadas validações.
// */
//var Validate = {
//    input: {
//        // defaults
//        alphabetic: function ($element) {
//            Validate.input.check($element, /[a-zçÇ A-Z]/)
//        },
//        alphanumeric: function ($element) {
//            Validate.input.check($element, /[a-zA-ZçÇ 0-9]/)
//        },
//        numeric: function ($element) {
//            Validate.input.check($element, /[0-9,.]/)
//        },
//        onlyNumber: function ($element) {
//            $element.keydown(function ($e) {
//                //teclas adicionais permitidas (tab,delete,backspace,setas direita e esquerda)
//                $keyCodesPermitidos = new Array(8, 9, 37, 39, 46, 13);
//
//                //numeros e 0 a 9 do teclado alfanumerico
//                for (x = 48; x <= 57; x++) {
//                    $keyCodesPermitidos.push(x);
//                }
//
//                //numeros e 0 a 9 do teclado numerico
//                for (x = 96; x <= 105; x++) {
//                    $keyCodesPermitidos.push(x);
//                }
//
//                //Pega a tecla digitada
//                $keyCode = $e.which;
//
//                //Verifica se a tecla digitada é permitida
//                if ($.inArray($keyCode, $keyCodesPermitidos) != -1) {
//                    return true;
//                }
//
//                return false;
//            })
//        },
//        // custom
//        name: function ($element) {
//            Validate.input.check($element, /^[a-z çÇA-Z0-9]*$/)
//        },
//        empty: function ($value) {
//            return $.trim($value)
//        },
//        // auxilidar
//        check: function ($element, $expression) {
//            $($element).keypress(function ($e) {
//                // 13, 8, 0, 46, 44
//                var $key = String.fromCharCode($e.which)
//                return $key.replace($expression, '') == '' ? true : false
//            });
//        }
//    },
//    removeTag: function ($text, $selector) {
//        var wrapped = $("<div>" + $text + "</div>");
//        wrapped.find($selector).remove();
//        return wrapped.html();
//    },
//    regex: {
//        //alert($string.replace(/[a-z]/ig,''))
//        replace: function ($value, $regex) {
//            return $value.replace($regex, '');
//        },
//        check: function ($value, $regex) {
//            return $value.replace($regex, '') == '' ? true : false;
//        }
//    }
//}
