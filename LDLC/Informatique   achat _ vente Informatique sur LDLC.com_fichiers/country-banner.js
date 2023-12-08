$(function () {
    ajaxCallWithData(
        Routing.generate(
            'country_banner',
            {'_locale': request_locale, 'country': request_country},
            false
        ),
        '#country-banner',
        false,
        {'locationSearch': window.location.search},
         function() {
            $('body').addClass('alert-country');
            customMonoSelect();
        }

    );

    $(document).on('click', '#country-banner a.close', function (e) {
        e.preventDefault();
        var typeCookie = $(this).parents('.wrap-alert').parent('.container').attr('id');
        $.ajax(
            {
                url: Routing.generate(
                    'country_banner',
                    {
                        '_locale': i18n.locale,
                        'country': i18n.country,
                        'localeCountry': i18n.locale + '-' + i18n.country
                    },
                    false
                ),
                data: {'type': typeCookie},
                success: function () {
                    $('#country-banner').hide();
                    $('body').removeClass('alert-country');
                }
            }
        );
    });

    $(document).on('click', "#country-banner button[type='submit']", function (e) {
        e.preventDefault();

        //"isDenied" not manage for cookie "consent_country"
        var isDenied = false;
        var typeCookie = $(this).parents('.wrap-alert').parent('.container').attr('id');
        var localeCountry = $('select#localeCountry').val();

        //impossible to deny cookie "consent-cookie" currently
        if (typeCookie === 'consent-redirect') {
            localeCountry = 'fr-fr';
            //submit => back to France => denied cookie
            isDenied = true;
        }

        $.ajax(
            {
                url: Routing.generate(
                    'country_banner',
                    {
                        '_locale': i18n.locale,
                        'country': i18n.country,
                        'localeCountry': localeCountry
                    },
                    false
                ),
                data: {'type': typeCookie, 'isDenied': isDenied},
                success: function (response) {
                    //go to store selected
                    window.location.href = response.redirectUrl;
                }
            }
        );
    });


});
