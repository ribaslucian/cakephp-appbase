Filter = function() {

    var filter = '.filter';
    var options = '.options';
    var active = '.active';
    var option = '.option';
    var inputs = '.inputs';
    var attr_name = 'name';

    this.construct = function() {
        this.showActive();
        this.reloadOptions();
        this.optionClick();
        this.submit();
    };

    this.getActive = function() {
        return $(filter + ' ' + active).html();
    };

    this.showActive = function() {
        $('div[' + attr_name + '="' + this.getActive() + '"]').show();
    };

    this.reloadOptions = function() {
        $(filter + ' ' + option + ':contains("' + this.getActive() + '")').hide();
    };

    this.optionClick = function() {
        $(option).click(function() {
            var act = $(filter + ' ' + active).html();

            $('div[' + attr_name + ']').hide();
            $('div[' + attr_name + '="' + act + '"]').show();

            $(filter + ' ' + option).show();
            $(filter + ' ' + option + ':contains("' + act + '")').hide();
        });
    };

    this.submit = function() {
        $('.filter input').keyup(function(e) {
            if (e.keyCode == 13) {
                var url = $(this).parents('.ui.form').attr('url') + '/';
                var args = jQuery.parseJSON($(this).parents('.ui.form').attr('args'));

                $.each($('.filter input'), function(key, input) {
                    args[input.name] = input.value;
                });

                var value = "";
                for (var key in args) {
                    if ($.trim(args[key])) {
                        value = args[key] + "";
                        url += key + ':' + (value.replace(/\//g, '')) + '/';
                    }
                }
                
                window.location.href = url;
            }
        })
    }

    this.construct();
}