$(function () {
    $(".wrap-header").hoverIntent({
        over: openMiniBox,
        out: closeMiniBox,
        timeout: 0,
        selector: " .basket"
    });
});

function openMiniBox() {
    if ($(window).width() >= 1024) {
        if ($('.mini-basket').length == 0) {
            $.ajax({
                method: 'GET',
                url : Routing.generate('cart_overview', {'_locale' : request_locale, 'country' : request_country}, true),
                success: function(data) {
                    $('#panier').after(data);
                    $('.basket').find('.mini-box').addClass('open');

                }
            });
        } else {
            $('.basket').find('.mini-box').addClass('open');
        }
    }
}
function closeMiniBox(e) {
    if (!$(e.target).is('input') && !$('input').is(':focus')) {
        $('.mini-box').removeClass('open');
    }
}
