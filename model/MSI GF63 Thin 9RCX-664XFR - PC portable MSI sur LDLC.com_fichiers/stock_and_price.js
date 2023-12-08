$(document).ready(function () {
    var currentUrl = window.location.href;

    if ($('.main').attr('data-product-is-clearance') === "1"){
        $('.product-info .add-to-cart').addClass('disabled');
    }

    if (null != currentUrl.match('priceAlertModal=true')) {
        displayModalPriceAlertForm();
    }

    $('#price-alert').click(function( e ) {
        e.preventDefault();
        $('.ajaxWait').show();
        displayModalPriceAlertForm();

    });

    function displayModalPriceAlertForm() {
        var url = Routing.generate('form_alert_price_subscribe', {
            'productId' : $('.main').attr('data-product-id'),
            'country': $('body').attr('data-country'),
            "_locale": $('body').attr('data-language')
        });
        $.ajax({
            url: url,
            statusCode: {
                200: function (response) {
                    $('#modal-default').modal('show');
                    $('#modal-default .modal-content').html(response);
                    $('#price-alert').addClass('authentication-required');
                    ajaxForm('#subscribePriceAlert','#modal-default .modal-content');
                    $('.ajaxWait').hide();
                },
                403: function () {
                    $('.ajaxWait').hide();
                    displayModalLoginForm(function() {
                        $('#price-alert').removeClass('authentication-required');
                        displayModalPriceAlertForm(url);
                    },
                        window.location.href + '?priceAlertModal=true'
                    );
                }
            }
        });
    }

    $('#availability-alert').on('click', function(e) {
        e.preventDefault();
        $.ajax({
            url: Routing.generate( 'form_alert_availability_subscribe', {
                'productId': $('.main').attr('data-product-id'),
                'country': $('body').attr('data-country'),
                "_locale": $('body').attr('data-language')
            }),
            success: function(response) {
                $('#modal-default').modal('show');
                $('#modal-default .modal-content').html(response);
                ajaxForm('#subscribeAvailabilityAlert','#modal-default .modal-content')
            }
        });
    })
});
