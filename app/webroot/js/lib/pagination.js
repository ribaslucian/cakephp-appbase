(function($) {

    if ($(".pagination").length) {

        var element = '.jPaginatorSubmit';
        var current = $(".pagination .current").text();
        var url = $(".pagination .url").text();
        var count = $(".pagination .count").text();
        
        $('input', $(element)).val(current);
        
        $(element).on('keypress', function(e) {
            var value = parseInt($('input', $(this)).val())

            if (e.which == 13) {
                if (value == current) {
                    $(element).removeClass('error')
                    $(element).css('border', '2px solid #d9edf7').css('top', '-1px');
                } else if (!$.isNumeric(value) || value == "" || value < 1 || value > count) {                     
                    $(element).css('border', '2px solid #f2dede').css('top', '-1px');
                    $(this).addClass('error');
                } else {
                    window.location.href = url.replace('{page}', 'page:' + value);
                }
            }
        });

//            var $SetCustomPage = {
//        element: ".jPaginatorSubmit",
//        page: "<?php echo $this->Paginator->param('page'); ?>",
//        url: "<?php echo $url; ?>",
//        count: "<?php echo $this->Paginator->param('pageCount'); ?>",
//        //
//        initialize: function() {
//            $('input', $($SetCustomPage.element)).val($SetCustomPage.page)
//        },
//        role: function() {
//            Validate.input.onlyNumber($($SetCustomPage.element))
//        },
//        fail: function($on, $function) {
//            $($SetCustomPage.element).on($on, $function)
//        }
//    }
//
//    $SetCustomPage.initialize()
//    $SetCustomPage.role()
//    $SetCustomPage.fail("keypress", function($e) {
//        $value = parseInt($('input', $(this)).val())
//        if ($e.which == 13) {
//            if ($value == $SetCustomPage.page) {
//                $($SetCustomPage.element).removeClass('error')
//                $($SetCustomPage.element).css('border', '2px solid #d9edf7')
//            } else if (!$.isNumeric($value) || $value == "" || $value < 1 || $value > $SetCustomPage.count) { //Validation.empty($value) ||
//                $($SetCustomPage.element).css('border', '2px solid #f2dede')
//                $(this).addClass('error')
//            } else {
//                window.location.href = $SetCustomPage.url.replace('{page}', 'page:' + $value)
//            }
//        }
//    })

    }

})(jQuery);