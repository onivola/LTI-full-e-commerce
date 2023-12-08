var preloadedImages = [];

$(document).ready(function () {
    var $main = $('.main');

    var hasZoom = !$("#productphoto").hasClass('no-zoom');

    if ($main.attr('data-category-id') != ''){
        var common_route_params = {
            "productId": $main.attr('data-product-id'),
            "categoryId": $main.attr('data-category-id'),
            "country": i18n.country,
            "_locale": i18n.locale
        };

        if ($main.attr('data-offer-is-master') === '1') {
            ajaxCall(
                Routing.generate(
                    'data_compare_products',
                    common_route_params
                ),
                '#compare_product',
                true
            );
        }

        ajaxCall(
            Routing.generate(
                'data_product_page_viewed',
                common_route_params
            )
        );
    }

    $(document).on('click', '#product-parameters td input', function (e) {
        var filteredProductPageUrl = generateFilteredProductPageUrl();
        $("#filter-product").attr('href', filteredProductPageUrl);
    });

    $(document).on('click', '.compare-category-product', function (e) {
        e.preventDefault();
        window.location.href = Routing.generate(
            'compare_from_list',
            {
                "categoryId": $main.attr('data-category-id'),
                "productIds": $(this).attr('data-product-ids'),
                "country": i18n.country,
                "_locale": i18n.locale
            }
        );
    });

    $("#filter-product").click(function (e) {
        e.preventDefault();
        var url = generateFilteredProductPageUrl();
        window.location.href = decodeURIComponent(url);
    });

    if($('.specsTech').find('.checkbox input:checked').length) {
        $('.wrap-compare-product').removeClass('hidden').addClass('active');
        var filteredProductPageUrl = generateFilteredProductPageUrl();
        $("#filter-product").attr('href', filteredProductPageUrl);
    }

    function generateFilteredProductPageUrl()
    {
        var filterUrl = '';
        $("#product-parameters input").each(function () {
            if ($(this).is(':checked')) {
                filterUrl += $(this).attr('id');
            }
        });

        if (filterUrl == '') {
            return window.location.href;
        } else {
            var listing_filtered_route_params = {
                "slug": $main.attr('data-category-slug'),
                "categoryId": $main.attr('data-category-id'),
                "filterUrl": filterUrl
            };
            if (i18n.country !== 'fr') {
                listing_filtered_route_params["country"] = i18n.country;
            }

            return Routing.generate($main.attr('data-category-route'), listing_filtered_route_params, true);
        }
    }

    // Nouvelle galerie
    var zoom = new ZoomBox($('#previews')[0], $('#zoom')[0]);
    // Add image items and preload big images
    $("#productphoto .zoom a[rel='photopopup']").each(function () {
        var itemLink = $(this).prop('href');
        var $thumbItem = $(this).children('img').prop('src')
        zoom.addItem(new ZoomItem($thumbItem, itemLink, 'image'));
    });
    // Add flixmedia items
    $("a[rel='flixpopup']").each(function () {
        var $itemLink = $(this).prop('href');
        //var $thumbItem = "/img/ico-flixmedia.png";
        var $thumbItem = $("a[rel='photopopup']:first").children('img').prop('src');
        zoom.addItem(new ZoomItem($thumbItem, $itemLink, 'frame'));
    });
    // affichage de la galerie au clic
    $(".zoom ul li").click(function (e) {
        e.preventDefault();
        preloadBigImages();
        if(hasZoom === false && $(e.currentTarget).hasClass('special') == false) {
            return false;
        }

        clicOnProductThumbnail($(this).index());
    });
    //affichage de la galerie au clic en mobile
    $(".swiper-product .swiper-wrapper .swiper-slide").click(function (e) {
        e.preventDefault();

        if(hasZoom === false){
            return false;
        }

        clicOnProductThumbnail($(this).index());
    });
    // affichage de la galerie si clic sur l'image principale
    if ($(".zoom").length) {
        $(".product .photodefault").click(function (e) {
            e.preventDefault();
            preloadBigImages();

            if(hasZoom === false){
                return false;
            }

            var index = $(".zoom li.selected").attr("id").split("_").pop();
            clicOnProductThumbnail(index);
        });
    }

    $("#productphoto .zoom a[rel='photopopup']").hover(function () {
        preloadImage($(this));
    }, function() { return false });

    $('a[data-decode="true"]').each(function () {
        var $this = $(this);
        var params = {
            'categoryId': $this.data('cat-id'),
            'slug': $this.data('cat-slug'),
            'filterUrl': $this.data('cat-filter-url'),
        };

        var country = $this.data('country');
        if (country !== 'fr') {
            params['country'] = country;
        }
        var url = Routing.generate($main.attr('data-category-route'), params, true);
        $this.attr('href', decodeURIComponent(url));
        $this.attr('target', '_blank');
    });

    $('.link-offer[data-offer-id]').each(function () {
        var $this = $(this);
        var routeName = 'product_page_';

        if (i18n.locale === 'fr' && i18n.country === "fr") {
            var productUrl = Routing.generate(routeName + i18n.locale, {
                    "urlId": $this.data('url-id'),
                    "offerId": $this.data('offer-id'),
                }
            );
        } else {
            if (i18n.locale === 'fr'){
                routeName += 'with_country_';
            }
            var productUrl = Routing.generate(routeName + i18n.locale, {
                    "urlId": $this.data('url-id'),
                    "offerId": $this.data('offer-id'),
                    'country': i18n.country,
                    '_locale': i18n.locale
                }
            );
        }

        $this.attr('href', decodeURIComponent(productUrl));
    });

    $('#share-product').on('click', function(e) {
        e.preventDefault();
        var $this = $(this);
        var productId = $this.attr('data-product-id');
        var offerId = $this.attr('data-offer-id');
        var callBack = undefined;
        $.ajax({
            url: Routing.generate('form_share_product',
                {
                    "productId": productId,
                    "offerId": offerId,
                    "country" : request_country,
                    "_locale" : request_locale
                }
            ),

            success: function(response) {
                $('#modal_simple').modal('show');
                $('#modal_simple .modal-content').html(response);
                if (response.indexOf('g-recaptcha') !== -1){
                    renderCaptcha();
                    callBack = renderCaptcha;
                }
                ajaxForm('#shareProduct','#modal_simple .modal-content', callBack);
            }
        });
    })

    $('#description_translation .original').on('click', function(e) {
        e.preventDefault();
        $('#description_translation').hide();
        $('.translationOriginal').show();

    });

    var stock = parseInt($('.stock-info .website .stock a').data('stock'));
    if (stock > 7) {
        $('.productToConfig').remove();
    } else {
        $('.productToConfig').on('click', function(e) {
            e.preventDefault();
            window.location.href = Routing.generate('get_configuration_from_item',
                {
                    "productId": $main.attr('data-product-id'),
                    "categoryId" : $main.attr('data-category-id'),
                    "_locale" : i18n.locale,
                    "country" : i18n.country
                }
            );
        });
    }
});

$(document).on('click', '.shipping #modal-verif-370090', function(e) {
    e.preventDefault();
    $.ajax({
        url: Routing.generate( 'form_delivery_evening_eligibility', {
            'productId': $('.main').attr('data-product-id'),
            'deliveryModeId': 370090,
            'country': $('body').attr('data-country'),
            "_locale": $('body').attr('data-language')
        }),
        success: function(response) {
            $('#modal-default').modal('show');
            $('#modal-default .modal-content').html(response);
            ajaxForm('#delivery_evening_check','#modal-default .modal-content');
        }
    });
});

$(document).on('keyup', '#modal-verif-sameday :text#delivery_evening_eligibility_zipCode', function() {
    if ($(this).val().length > 0) {
        $('#modal-verif-sameday :submit.button.disabled').removeClass('disabled');
        return;
    }

    $('#modal-verif-sameday :submit.button').addClass('disabled');
});

$(document).ajaxSuccess(function( event, xhr, settings ) {
    if (settings.url.indexOf('?zoneid=') === -1) {
        return;
    }

    if ($('#pubContentproductTop').children().length > 0 && $('#adsSpecialOfferProduct').children().length > 0) {
        var rnd = Math.floor(Math.random() * Math.floor(2));
        if (rnd === 0) {
            $('#adsSpecialOfferProduct').removeClass('hide');
            $('#pubContentproductTop').remove();
        }

        return;
    }

    $('#adsSpecialOfferProduct').removeClass('hide');
});

function clicOnProductThumbnail(index){
    $('#product-zoom').modal();
    // on lance le clic sur la vignette correspondante à celle cliquée dans la page
    $("#previews a").eq(index).click();
}

function preloadBigImages()
{
    $("#productphoto .zoom a[rel='photopopup']").each(function () {
        preloadImage($(this));
    });
}

function preloadImage(item)
{
    var itemLink = item.prop('href');

    if(preloadedImages[itemLink] === undefined)
    {
        var img = new Image();
        img.src = itemLink;
        preloadedImages[itemLink] = img;
    }
}
