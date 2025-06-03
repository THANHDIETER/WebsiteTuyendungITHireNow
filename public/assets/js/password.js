$('.show-hide').show();
$('.show-hide span').addClass('show');

$('.show-hide span').on('click', function () {
    var $input = $(this).parent().parent().find('input');
    if ($(this).hasClass('show')) {
        $input.attr('type', 'text');
        $(this).removeClass('show');
    } else {
        $input.attr('type', 'password');
        $(this).addClass('show');
    }
});

$('form button[type="submit"]').on('click', function () {
    $('.show-hide span').addClass('show');
    $('input[id="login[password]"]').attr('type', 'password');
    $('input[id="login[confirm_password]"]').attr('type', 'password');
});