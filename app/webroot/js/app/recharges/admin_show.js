$(document).ready(function () {

    $('.up_button').click(function () {
        $('.up_table, .down_table, .in_table, .null_table').hide();
        $('.up_table').fadeIn();
    });
    
    $('.down_button').click(function () {
        $('.up_table, .down_table, .in_table, .null_table').hide();
        $('.down_table').fadeIn();
    });
    
    $('.in_button').click(function () {
        $('.up_table, .down_table, .in_table, .null_table').hide();
        $('.in_table').fadeIn();
    });
    
    $('.null_button').click(function () {
        $('.up_table, .down_table, .in_table, .null_table').hide();
        $('.null_table').fadeIn();
    });

});