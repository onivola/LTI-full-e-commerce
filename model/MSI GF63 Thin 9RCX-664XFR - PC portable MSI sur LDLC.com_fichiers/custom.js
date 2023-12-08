function ajaxCall(url, target, replace, callback){
    $.ajax({
        url : url,
        statusCode: {
            200: function(response) {
                if ($(target).length > 0) {
                    if (replace) {
                        $(target).replaceWith(response);
                    } else {
                        $(target).html(response);
                    }
                    $('.ajaxWait').hide();
                    if (typeof callback === "function") {
                        callback();
                    }
                }
            },
            404: function() {
                $('.ajaxWait').hide();
            },
            500: function() {
                $('.ajaxWait').hide();
            }
        }
    });
}
function ajaxCallWithData(url, target, replace, data, callback){
    $.ajax({
        url : url,
        data: data,
        method: 'POST',
        success : function(response, textStatus, xhr) {
            if (xhr.status === 200 && $(target).length > 0) {
                if (replace) {
                    $(target).replaceWith(response);
                } else {
                    $(target).html(response);
                }

                if (typeof callback === "function") {
                    callback();
                }
            }

            $('.ajaxWait').hide();
        },
        error: function() {
            $('.ajaxWait').hide();
        }
    });
}

function getParameterByName(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}

function disableSoldOutItems() {
    //bouton de mise au panier sur les listings produits
    $(".listing-product .add-to-cart").each(function(){
        var item = $(this);
        item.removeClass('disabled');

        var productStock = $("#pdt-" + item.attr('data-product-id'));
        var outOfStockStore = productStock.find('.stock-shop .dispob.nok').eq(0).length > 0;
        var outOfStockWeb = productStock.find('.stock-web a[data-stock=9]').eq(0).length > 0;
        var displayStore = productStock.find('.stock-shop').is(':visible');
        var displayWeb = productStock.find('.stock-web').is(':visible');

        if (hadToHideAddToCartButton(displayStore, displayWeb, outOfStockStore, outOfStockWeb)) {
            item.addClass('disabled');
        }
    });

    //bouton de mise au panier sur la fiche produit
    $(".product-info .saleBlock .add-to-cart").each(function(){
        var item = $(this);
        item.closest('.saleBlock').removeClass('hide');

        var stockInfo = item.closest('aside').find('.stock-info');
        var stockInfoWeb = stockInfo.find('.website');
        var stockInfoShop = stockInfo.find('.shop');

        var outOfStockStore = stockInfoShop.find('.dispob.nok').eq(0).length > 0;
        var outOfStockWeb = stockInfoWeb.find('a[data-stock=9]').eq(0).length > 0;
        var displayStore = stockInfoShop.find('.info').length > 0;
        var displayWeb = stockInfoWeb.length > 0;

        if (hadToHideAddToCartButton(displayStore, displayWeb, outOfStockStore, outOfStockWeb)) {
            item.closest('.saleBlock').addClass('hide');
        }
    });
}

function hadToHideAddToCartButton(displayStore, displayWeb, outOfStockStore, outOfStockWeb) {
    if (!displayStore && outOfStockWeb) {
       return true;
    } else if ( !displayWeb && outOfStockStore) {
        return true;
    } else if (outOfStockWeb && outOfStockStore) {
        return true;
    }

    return false;
}

function userHeader(url) {
    $.ajax({
        url: url,
        statusCode: {
            200: function (response) {
                if (false !== response.login) {
                    $('#account-menu-item').addClass('logged');
                    $('#compte').addClass('logged');
                    $('#compte').after(response.user_resume);
                }
                if(parseInt(response.cartItemCount) > 0) {
                    $('#panier').append('<span class="nb-pdt">' + response.cartItemCount + '</span>');
                    return;
                }
            }
        }
    });
}

function ajaxForm(form, container, callback){
    $(form).submit(function( e ) {
        e.preventDefault();
        // Use Ajax to submit form data
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                $(container).html(response);
                ajaxForm(form, container);
                if (callback !== undefined) {
                    callback();
                }
            }
        });
    });
}

function removeFilter(filterUrl, obj){
    var filter = obj.data('tag');
    if (filter === undefined) {
        return;
    }

    var filterPart = filter.split('-');
    var filterStart = filter.substr(0, 2);
    var urlPart = filterUrl.split('+');
    var newUrlPart = [];

    for (var i in urlPart) {
        var part = urlPart[i];
        if (part === '') {
            continue;
        }

        if ((filterStart === 'fv' || filterStart === 'fb' || filterStart === 'fa' || filterStart === 'fc')
            && part.substr(0, filterPart[0].length) === filterPart[0]) {
            var urlPartValue = part.replace(filterPart[0] + '-', '').split(',');
            if (urlPartValue.length > 1) {
                var newUrlPartValue = [];
                for (var j in urlPartValue) {
                    if (urlPartValue[j] !== filterPart[1]) {
                        newUrlPartValue.push(urlPartValue[j])
                    }
                }
                newUrlPart.push(filterPart[0] + '-' + newUrlPartValue.join());
            }
        } else {
            if (part !== filter || filterStart !== part.substr(0, 2)) {
                newUrlPart.push(part);
            }
        }
    }

    var newFilterUrl = newUrlPart.join('+');
    if (newFilterUrl.length > 0) {
        newFilterUrl = '+' + newFilterUrl;
    }

    return newFilterUrl;
}

function getRelAlternates()
{
    var alternates = [];
    $('head>link').each( function(){
        if ($(this).attr('rel') === 'alternate') {
            alternates[$(this).attr('hreflang').toLowerCase()] = $(this).attr('href');
        }
    });
    return(alternates);
}
function updateCrossCountryLink()
{
    var alternates = getRelAlternates();
    var availability = Object.keys(alternates);
    var strLocale =  { 'fr-fr': 'France', 'fr-be': 'Belgique', 'fr-lu': 'Luxembourg', 'fr-ch': 'Suisse', 'es-es': 'Espagne'};
    if (availability.length > 0 ) {
        $('#cross-country-link li').each(function () {
            var link = $(this).find('a');
            if (availability.indexOf(link.attr('data-locale')) !== -1) {
                link.attr('href', alternates[link.attr('data-locale')]);
            } else {
                link.hide();
            }
        });
        $('li.langue').show();
        for (var locale in alternates){
            $('li.langue .country_switcher').append('<li><a href="' + alternates[locale] + '">' + strLocale[locale] +'</a></li>');
        }
    } else {
        $('li.langue').hide();
    }

}

function checkQuantityValidity(product_id)
{
    var qtyElement = $('#qty-for-'+product_id);
    var qty = qtyElement.val();
    var maxQty = qtyElement.data('max');
    if (qty > maxQty) {
        qtyElement.val(maxQty);
        $('.qty-selector').addClass('error');
        return false;
    } else {
        $('.qty-selector').removeClass('error');
    }

    return true;
}

function fetchTranslation(url, obj, callback){
    var field = obj.data('field');
    obj.hide();
    $('#translation_' + field + ' .loader').show();
    $.ajax({
        url: url,
        method : 'POST',
        data : {'locales' : obj.data('locales').split('-')},
        statusCode: {
            200: function (response) {
                $('#translation_' + field + ' .loader').hide();
                if (response.status === 'OK') {
                    callback(response, field);
                } else {
                    $('#translation_' + field).html(i18n.error);
                }
            },
            500 : function () {
                $('#translation_' + field).html(i18n.error);
            }
        }
    });
}

function displayOriginalTranslation(response, field) {
    var translation = eval("response." + field);
    if (translation !== undefined) {
        $('#translation_' + field).html(translation);
    }
}

function displayAutomaticTranslation(response, field) {
    if (response.status === 'OK' && response.translation !== '') {
        $('#translation_' + field).html(response.translation);
    } else {
        $('#translation_' + field).html(i18n.error);
    }
}

$(document).ready(function() {

    updateCrossCountryLink();

    $('.qty-selector input.qty').focusout(function () {
        var product_id = $(this).attr('id').replace('qty-for-', '');

        if (false === checkQuantityValidity(product_id)) {
            return false;
        }
    });

    //if country = 'es' => prevent click on stock label
    if (i18n.country === 'es') {
        $(document).find(".stock a").each(function() {
            this.style.pointerEvents = 'none';
        });

    }

    // Generic translation fallback
    $(document).on("click", ".translation_fallback .original", function (e) {
        e.preventDefault();
        var parent = $(this).parent();
        var url = Routing.generate('fallback_original_translation', { 'country' : i18n.country, '_locale': i18n.locale, 'productId' : parent.data('product-id') })
        fetchTranslation(url, parent, displayOriginalTranslation);
    });

    // Generic automatic translation
    $(document).on("click", ".translation_fallback .translation", function (e) {
        e.preventDefault();
        var parent = $(this).parent();
        var field = parent.data('field');
        var url = Routing.generate('fallback_automatic_translation', { 'country' : i18n.country, '_locale': i18n.locale, 'productId' : parent.data('product-id'), 'field' : field });
        fetchTranslation(url, parent, displayAutomaticTranslation);
    });

    // Stock label generic modal
    $(document).on("click", ".stock a", function (e) {
        e.preventDefault();
        $.ajax({
            url: Routing.generate('cms_stock', { 'country' : request_country, '_locale': request_locale, 'stock' : $(this).attr('data-stock') }),
            statusCode: {
                200: function (response) {
                    //condition 'if' add in order to not display popup if country = 'es'
                    if (response !== '') {
                        $('#modal-default').modal('show');
                        $('#modal-default .modal-content').html(response);
                    }
                }
            }
        });
    });

    // Add to cart generic button
    $(document).on("click", ".add-to-cart", function (e) {
        e.preventDefault();
        var product_id = $(this).data('product-id');
        var offer_id = $(this).data('offer-id');
        var idProductOffer = product_id + '-' + offer_id;
        var is_marketplace = $(this).data('is-marketplace');
        var qtyElement = $('#qty-for-'+product_id);

        if (!qtyElement.length) {
            qtyElement = $('#qty-for-'+idProductOffer);
        }

        var qty = qtyElement.val();
        if (false === checkQuantityValidity(idProductOffer)) {
            return false;
        }
        $('.ajaxWait').show();

        if (offer_id !== undefined && is_marketplace !== undefined){
            var cartUrl = Routing.generate('add_offer_to_cart', { 'country' : request_country, '_locale': request_locale, 'offerId' : offer_id, 'quantity' : qty, 'isMarketplace' : is_marketplace })
        } else {
            var cartUrl = Routing.generate('add_to_cart', { 'country' : request_country, '_locale': request_locale, 'productId' : product_id , 'quantity' : qty })
        }
        $.ajax({
            url: cartUrl,
            statusCode: {
                200: function (response) {
                    $('.ajaxWait').hide();
                    if (response.status === "OK") {
                        window.location.href = response.redirectUrl;
                    } else {
                        $('#modal-default').modal('show');
                        $('#modal-default .modal-content').html(response.modalContent);
                    }
                }
            }
        });
    });

    // Openads generic launch
    $("div.advertising-banner").each(function() {
        $(this).advertisingBanner(true);
    });

});
