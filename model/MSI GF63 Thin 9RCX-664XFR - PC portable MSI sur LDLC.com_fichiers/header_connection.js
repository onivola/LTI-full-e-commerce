$(function () {

    $(".wrap-header").hoverIntent({
        over: openMiniBox,
        out: closeMiniBox,
        timeout: 0,
        selector: ".account"
    });

    function openMiniBox() {
        if ($(window).width() >= 1024) {
            $('.mini-box').removeClass("open");
            if(!$(this).hasClass('logged') && !$('#secure-login-form').length){
                getLoginForm(function(data) {
                    $('#compte').after('<div id="secure-login-form" class="mini-box mini-account open">' + data + '</div>');
                });
            } else {
                $('.mini-box.mini-account').addClass('open');
                $('#VerificationToken').ldlcvc();
            }
        }
    }
    function closeMiniBox(e) {
        if(!$(this).find('input').is(":focus")) {
            $(this).find('.mini-box').removeClass("open");
        }
    }

    $(document).on('submit', '#secure-login-form #loginForm', function (event) {
        event.preventDefault();
        postLoginForm($(this), false);
    });

    $(document).on('click touchstart', function (e) {
        var $clicked = $(e.target);
        if (!$clicked.parents().attr('id') !== 'header-user-resume') {
            $('#header-user-resume').removeClass('open');
        }
    });

    $(document).on('click', '#header-logout-button', function() {
        $.ajax({
            method: 'GET',
            url : Routing.generate('logout',{
                'country': $('body').attr('data-country'),
                "_locale": $('body').attr('data-language')
            }, true),
            success: function(data) {
                $('#logged-user-icon').addClass('hidden');
                $('#account-menu-item').removeClass('logged');
                $('#compte').removeClass('logged');
                $('#header-user-resume').remove();
            }
        });
    });
});
