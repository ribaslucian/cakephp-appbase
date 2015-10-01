$('.button.show').click(function() {
    $('.modal', $(this).parents('tr')).show();

    $('.global .dimmer').addClass('active');
});

$(document).keyup(function(e) {
    if (e.keyCode == 27) {
        $('.global .dimmer').removeClass('active');
        $('.modal').hide();
    }
})

$('.close-modal').click(function() {
    $(this).parents('.modal').hide();
    $('.global .dimmer').removeClass('active');
});
