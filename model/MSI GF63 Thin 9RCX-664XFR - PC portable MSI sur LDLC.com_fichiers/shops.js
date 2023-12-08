var nearbyShops = [];
var myPosition = [];

function Shop(obj) {
    this.id = obj.id;
    this.title = obj.title;
    this.city = obj.address.family_name;

    routeName = 'shops.shop_page_';
    if (i18n.locale === 'fr' && i18n.country === "fr") {
        this.url = Routing.generate(routeName + i18n.locale, {
                'shopId': obj.id,
                'slug': obj.standardUrl
            }
        );
    } else {
        if (i18n.locale === 'fr'){
            routeName += 'with_country_';
        }
        this.url = Routing.generate(routeName + i18n.locale, {
                'shopId': obj.id,
                'slug': obj.standardUrl,
                'country': i18n.country,
                '_locale': i18n.locale
            }
        );
    }
}
function displayViewMode() {
    if (typeof offerListing !== 'undefined' && offerListing.type === 'shop') {
        return;
    }

    if (typeof favoriteShopId == "undefined") {
        return;
    }

    if (favoriteShopId >= 0){
        $('.product-listing #listingSelectWrapper').prepend(viewModeSelect);
        $('#stock-option option[value="'+stockViewMode+'"]').attr('selected', 'selected');
        favoriteShopChoiceSetUp();
    } else {
        $('.product-listing #listingSelectWrapper').prepend(viewModeBtn);
    }
}
function setViewMode(viewMode) {
    var url = Routing.generate('set_stock_view_mode',{
        'viewMode' : viewMode,
        'country': i18n.country,
        '_locale': i18n.locale
    });
    stockViewMode = viewMode;

    $('.ajaxWait').show();
    $.ajax({
        url : url,
        method: 'POST',
        data : {"productIds" : getListingProductIds()},
        statusCode: {
            200: function(response) {
                $('.ajaxWait').hide();
                if (response.status === 'OK') {
                    $('#category').attr('data-stock-option', $('#stock-option option:selected:selected').val());
                    //excluded disponibilityFilter
                    var data =
                        viewMode !== '0' ? $('#filterProduct *').not('#filter_fdi__0,#filter_fdi__1').serialize() :
                            $('#filterProduct').serialize();
                    updateFilterProduct(
                        $('#category').attr('data-category-filter'), $('#category').attr('data-sort'), data
                    );
                } else {
                    displaySimpleErrorModal(i18n.error);
                }
            },
            500: function() {
                displaySimpleErrorModal(i18n.error);
            }
        }
    });
}
function setFavoriteShop(shopId, from) {
    if (shopId === undefined) {
        return;
    }

    //4 cas existants pour le "from" : "listing", "product", "shop" et "shops_map" (appelé dans le fichier "shop-map.min.js")
    shopId = parseInt(shopId);
    var url = Routing.generate('set_favorite_shop_' + from + '_page', {
        'shopId': shopId,
        'country': i18n.country,
        '_locale': i18n.locale
    });

    if (from === 'product' || from === 'listing') {
        $('.ajaxWait').show();
    }

    $.ajax({
        url : url,
        method: 'POST',
        data : getPostParams(from),
        statusCode: {
            200: function(response) {
                $('.ajaxWait').hide();
                if (response.status === 'OK') {
                    var formerFavoriteShop = favoriteShopId;
                    favoriteShopId = shopId;
                    if (from === 'shop'){
                        favoriteShopSetUp();
                        window.location = response.url;
                    }
                    if (from === 'product') {
                        $('.stock-info').replaceWith(response.content);
                        disableSoldOutItems();
                        favoriteShopSetUp();
                    }
                    if (from === 'listing') {
                        updateFilterProduct($('#category').attr('data-category-filter'), $('#category').attr('data-sort'), $('#filterProduct').serialize());
                        if(formerFavoriteShop === -1){
                            stockViewMode = 2;
                            displayViewMode();
                        }
                    }
                    if (from == 'shops_map') {
                        $('.main .list-shop-result').data('favorite-shop-id', shopId);
                        sentence = $('#map').data('sentence-remove-shop-favorite');
                        $('#map .save-favorite-shop').attr('title', sentence)
                    }
                } else {
                    displaySimpleErrorModal(i18n.error);
                }
            },
            500: function() {
                if (from === 'product' || from === 'listing') {
                    $('.ajaxWait').hide();
                }
                displaySimpleErrorModal(i18n.error);
            }
        }
    });
}

//appelé dans le ficher "shop-map.min;js"
function removeFavoriteShop(from) {
    if (from === 'product' || from === 'listing') {
        $('.ajaxWait').show();
    }

    var url = Routing.generate('remove_favorite_shop_' + from + '_page', {
        'country': i18n.country,
        '_locale': i18n.locale
    });

    $.ajax({
        url: url,
        method: 'POST',
        data : getPostParams(from),
        statusCode: {
            200: function (response) {
                if (from === 'product' || from === 'listing') {
                    $('.ajaxWait').hide();
                }

                if (response.status === 'OK') {
                    if (from == 'shops_map') {
                        $('.main .list-shop-result').data('favorite-shop-id', -1);
                        sentence = $('#map').data('sentence-set-shop-favorite');
                        $('#map .save-favorite-shop').attr('title', sentence)
                    }
                }
            },
            500: function () {
                //do nothing
            }
        }
    });
}

/* fonction appelée au clic sur le bouton "choisir ma boutique" (présent sur la fiche produit) */
function getStockForShops() {
    var url = Routing.generate('get_stock_for_shops',{
        'productId' : $('div.main').data('product-id'),
        'country': i18n.country,
        '_locale': i18n.locale
    });

    $('.ajaxWait').show();
    $.ajax({
        url : url,
        method: 'POST',
        data : {"shopIds" : getOpenedShopIds()},
        statusCode: {
            200: function(response) {
                $('.ajaxWait').hide();
                //"data-stocktext" et "data-class" utile uniquement sur les fiches produits car on affiche le stock
                for (i in openedShops) {
                    var option = $('#shopOption' + openedShops[i].id);
                    option.attr('data-stocktext', $('select#shopSelection').data('unavailable'));
                    option.attr('data-class', 'no-stock');

                    if (response.stock != undefined && response.stock < 3 ) {
                        option.attr('data-stocktext', $('select#shopSelection').data('ondemand'));
                    }

                    if (response.stockShop.indexOf(parseInt(openedShops[i].id)) >= 0) {
                        option.attr('data-stocktext', $('select#shopSelection').data('available'));
                        option.attr('data-class', '');
                    }
                }
                //on tri par disponibilité
                $('select#shopSelection').html($('select#shopSelection').children('option').sort(compareByStock));

                $('#shop-choice-multiple').modal('show');
            },
            500: function() {
                displaySimpleErrorModal(i18n.error);
            }
        }
    });
}

function reinitModalToChooseFavoriteShop() {
    $('select#shopSelection').val(favoriteShopId);
    $('select').val(favoriteShopId).trigger('change.select2');
    if (favoriteShopId > 0) {
        //initialise le bouton de soumission "choisir cette boutique" avec la valeur shop-data de la boutique sélectionnée dans le menu déroulant
        setDataShopOnSubmitButton($('select#shopSelection').val());
        refreshBlocShopChosen();
    } else {
        /* pas de favoriteId => donc on réinitialise les données de la modale */
        //boutiques de proximité
        $('#shop-choice-multiple .result').hide();
        //suppression de  la donnée data-shop du bouton de soumission
        $('#shop-choice-multiple .modal-content .modal-body > div.button-shop-choice').removeData('shop');
        //affichage et désactivation du bouton de soumission
        $('#shop-choice-multiple .modal-content .modal-body > div.button-shop-choice').show();
        $('#shop-choice-multiple .modal-content .modal-body > div.button-shop-choice .button').attr('disabled', 'disabled');
    }
}

function checkFavoriteShopAvailability() {
    for (i in openedShops){
        if (parseInt(openedShops[i].id) === favoriteShopId) {
            return true;
        }
    }
    return false;
}

function getPostParams(from){
    if (from === 'product') {
        return {'offerId' : $('.product-detail .add-to-cart').data('offer-id')};
    } else {
        return {};
    }
}

function getListingProductIds() {
    var productIds = [];
    $('.listing-product li').each(function(){
        if ($(this).attr('id') !== undefined && $(this).attr('id').length > 0) {
            var parts = ($(this).attr('id')).split('-');
            productIds.push(parts[1]);
        }
    });
    return productIds;
}

function getOpenedShopIds() {
    var shopIds = [];
    for (i in openedShops){
        shopIds.push(openedShops[i].id);
    }
    return shopIds;
}

/* initialisation de la modale (fait qu'une fois, à l'initialisation de la page) */
function initModalToChooseFavoriteShop() {
    //on insère nos boutiques dans le select (boutiques actives sauf celles en statut "prochainement"
    for (i in openedShops) {
        $('select#shopSelection').append(
            '<option id="shopOption' + openedShops[i].id + '" value="' + openedShops[i].id + '" data-shop="' + openedShops[i].id + '">' + openedShops[i].title + ' (' + openedShops[i].address.postal_code + ')</option>'
        );
    }

    initListenersModalToChooseFavoriteShop();

    if (favoriteShopId <= 0) {
        //permet de cacher le bloc bleu qui est vide car pas de boutique sélectionné
        $('#shop-choice-multiple .result').hide();
        $('#shop-choice-multiple .modal-content .modal-body > div.button-shop-choice .button').attr('disabled', 'disabled');
        return;
    }

    favoriteShopSetUp();
    $('select#shopSelection').val(favoriteShopId);
    //initialise le bouton de soumission "choisir cette boutique" avec la valeur shop-data de la boutique sélectionnée dans le menu déroulant
    setDataShopOnSubmitButton(getShopIdSelectedInSelect($('.shop-choice select option:selected')));
    refreshBlocShopChosen();
}

function initListenersModalToChooseFavoriteShop() {
    $(document).on('change', '#shop-choice-multiple select#shopSelection', function (e) {
        e.preventDefault();

        //si menu déroulant ré-initialiser, alors on ne fait rien
        if ($('.shop-choice select option:selected').length <=0) {
            return;
        }

        //vide la partie "boutiques à proximité" car on décide de repasser en mode "recherche via le menu déroulant"
        $('#shop-choice-multiple .geoloc-result').empty();
        //initialise le bouton de soumission "choisir cette boutique" avec la valeur shop-data de la boutique sélectionnée dans le menu déroulant
        setDataShopOnSubmitButton($('select#shopSelection').val());
        //une boutique a été sélectionnée dans le menu déroulant, on met donc à jour le bouton de soumission
        refreshBlocShopChosen();
    });

    //au clic sur le bouton "géolocalisez-moi" de la modale boutique
    $(document).on('click', '#shop-choice-multiple #shop-product-findme', function(e) {
        e.preventDefault();
        //me géolocalise et affiche les boutiques les plus proches (sur la modale boutique)
        setMyPositionWithMyCurrentPosition(displayNearbyShops, 'modal');
    });

    //évenements sur tous les boutons ".button-shop-choice"  de la modale (il y a des boutons de soumission en mobile)
    $(document).on('click', '#shop-choice-multiple div.button-shop-choice .button', function (e) {
        e.preventDefault();
        $('#shop-choice-multiple').modal('hide');
        var from = 'product';
        if($('#category').length > 0) {
            from = 'listing';
        }
        //enregistre le shop favori en indiquant si on vient d'une fiche produit ou d'un listing
        setFavoriteShop($(this).parent().data('shop'), from);
    });

    $(document).on('hidden.bs.modal', '#shop-choice-multiple', function() {
        //vide la partie "boutiques à proximité"
        $('#shop-choice-multiple .geoloc-result').empty();
    });

    $(document).on('show.bs.modal', '#shop-choice-multiple', function() {
        //réinitialise la modale
        reinitModalToChooseFavoriteShop();
    });
}

function refreshBlocShopChosen() {
    var selectedShopId = $('select#shopSelection').val();
    var selectedShop = null;
    for (var key in openedShops) {
        if (openedShops[key]['id'] == selectedShopId) {
            selectedShop = openedShops[key];
        }
    }

    if (selectedShop != null) {
        ajaxCallWithData(
            Routing.generate(
                'get_selected_shop',
                {'_locale': i18n.locale, 'country': i18n.country},
                false
            ),
            '#shop-choice-multiple .result',
            false,
            {"selectedShop" : JSON.stringify(selectedShop)},
            function () {$('#shop-choice-multiple .result').show();}
        );
    }
}

function favoriteShopSetUp() {
    for (i in openedShops) {
        if (parseInt(openedShops[i].id) === favoriteShopId) {
            var favoriteShop = new Shop(openedShops[i]);
            $(".productLinkToShop").html(favoriteShop.title);
            $("a.linkToShop").attr('href', favoriteShop.url);
            $("div.title-2.linkToShop a").attr('href', favoriteShop.url);
            $('.h-shop .myShop strong').html(favoriteShop.city);
            $('.h-shop .myShop').show();
            $('.h-shop .findShop').hide();
        }
    }
}

//initialise le menu déroulant, présent sur le listing, pour changer de boutique
function favoriteShopChoiceSetUp() {
    $('#shop-choice-btn').hide();
    customMonoSelect();
    //bouton pour ouvrir la modale pour choisir sa boutique : à laisser ici car n'existe pas dans le DOM
    $('.product-listing #listingSelectWrapper .btn .button').on('click', function() {
        $('#shop-choice-multiple').modal('show');
    });
}

function displayGrpdForInputEmail() {
    //if check pas de date seoFooter et gpdr
    if ($('.seo-footer') || $('.gprd')) {
        var row = document.createElement("div");
        var p = document.createElement("p");
        row.classList.add("row");
        row.appendChild(p);
        row.innerHTML = $('.gpdr').html().concat($('.seo-footer').html());
        $('footer .top .container').prepend(row);
    }
}

function displayOrNotSentenceSetItYourFavoriteShop() {
    var shopId = $('#shopsPage').data('shop-id');
    if (shopId !== undefined && favoriteShopId == shopId) {
        $('#shopsPage .addFavoriteShop p:first').remove()
    }
}

function hideShopStockForUnavailableFavoriteShop() {
    favoriteShopId = -1;
    $('.stock-shop').fadeOut();
    $('.wrap-stock .stocks').removeClass('info-stock-shop');
    $('.stock-info .shop .content div').each(function(){$(this.remove())});
    $('.stock-info .shop .content a').addClass('hide');
    $('.stock-info .shop .content a.noShop').removeClass('hide');
}

function getInformationDistance(myPos, chunkPos) {
    var deferred = new $.Deferred();

    var service = new google.maps.DistanceMatrixService();
    service.getDistanceMatrix(
        {
            origins: [myPos],
            destinations: chunkPos,
            travelMode: 'DRIVING',
            unitSystem: google.maps.UnitSystem.METRIC,
            avoidHighways: false
        }, function(response, status) {
            if (status == google.maps.DistanceMatrixStatus.OK) {
                deferred.resolve(response);
            } else {
                deferred.reject(status);
            }
        });

    return deferred.promise();
}

/** initialiser la partie map de la page "magasins-ldlc" */
function shopsHomepageSetUp() {
    //on initialise la map avec les marqueurs
    initMapShop($('#map'), shopLocations);

    //on pose les écouteurs nécessaires à cette map (géolocalisation + recherche)
    initListenersMapShopsHomepage();
}

function shopsDepartmentPageSetUp() {
    //nous connaissons déjà les boutiques ('.list-shop-result li'), nous initialisons donc la carte
    initMapAndShopsListing();

    $.when(
        //on récupère la distance qui nous sépare de chaque boutique
        setMyPositionWithMyCurrentPosition(getInformationDistanceOfShops)
    ).done(function(res) {
        //do nothing
    });
}

function shopPageSetUp() {
    displayGrpdForInputEmail();
    displayOrNotSentenceSetItYourFavoriteShop();
    initMapOfShopPage();
}

/** initialise une map et son listing */
function initMapAndShopsListing() {
    relaysMarkersOptions = [];
    //remplace les éléments génériques des tooltip pour la map
    $('.main.shop-result .list-shop-result li').each(function(){
        currentFavoriteShopId = $('.main .list-shop-result').data('favorite-shop-id');
        shopId = $(this).data('shop');
        shopUrl = Routing.generate(
            'shops.shop_page_' + i18n.locale,
            { 'shopId' : shopId, 'slug': $(this).data('slug') }
        );
        dataImage = $(".main.shop-result .list-shop-result li[data-shop='".concat(shopId).concat("']")).data('image');
        tooltipContent = $('#shopGmapMarker').html().replace("#shop.url", shopUrl);
        tooltipContent = tooltipContent.replace(/#shop\.h1/g, $(this).data('h1'));
        tooltipContent = tooltipContent.replace(/#shop\.image/g, dataImage);
        tooltipContent = tooltipContent.replace(/#shop\.id/g, shopId);

        sentence = getSentenceForHeartTooltip(currentFavoriteShopId, shopId);
        tooltipContent = tooltipContent.replace(/#shop\.sentence/g, sentence);

        relaysMarkersOptions.push({
            'lat': $(this).data('lat'),
            'lng': $(this).data('lng'),
            'tooltipContent': tooltipContent,
            'markerLabel': $(this).find('.marker').html(),
            'shopId': $(this).data('shop')
        });
    });

    initMapShop($('#map'), relaysMarkersOptions, {'currentPosition': myPosition});
}

function initMapOfShopPage() {
    var mapElement = $('#map');
    var relaysMarkersOptions = [
        {
            'lat': mapElement.data('lat'),
            'lng': mapElement.data('lng'),
            'tooltipContent': mapElement.data('content')
        }
    ];
    initMapShop(mapElement, relaysMarkersOptions, {'currentPosition': myPosition, 'maxZoom': 16});
}

function initListenersMapShopsHomepage() {
    //on écoute les clics sur le bouton "géolocalisez-moi" de la recherche des boutiques (home boutiques)
    $(document).on('click', '#shopsHomepage #shop-gmap-findme', function(e) {
        e.preventDefault();

        //à la validation de la recherche, on vide le champ de recherche zipCode, ville (pour une prochaine recherche)
        $('#shopsHomepage #shop-gmap-findme-keyword-input').val('')
        //on renseigne la variable "myPosition" (géolocalisation) et on la passe à la fonction "displayNearbyShops" qui va s'occuper
        //d'afficher les boutiques les plus proches (dans la liste à côté de la map)
        setMyPositionWithMyCurrentPosition(displayNearbyShops, 'map');
    });

    //on écoute les clics sur le bouton "ok" de la recherche des boutiques par mot zipCode ou ville (home boutiques)
    $(document).on('submit', '#shopsHomepage #shop-gmap-findme-keyword', function(ev) {
        ev.preventDefault();

        //on renseigne la variable "myPosition" (recherche textuel) et on la passe à la fonction "displayNearbyShops" qui va s'occuper
        //d'afficher les boutiques les plus proches (dans la liste à côté de la map)
        setMyPositionWithZipCode(
            $('#shopsHomepage #shop-gmap-findme-keyword-input').val().concat(' ').concat(i18n.countryLabel),
            displayNearbyShops, 'map');
    });
}

function setDataShopOnSubmitButton(dataShop) {
    $('#shop-choice-multiple .modal-content .modal-body > div.button-shop-choice').data('shop', dataShop);
    //ré-active et ré-affiche, au besoin, le bouton "choisir cette boutique"
    $('#shop-choice-multiple .modal-content .modal-body > div.button-shop-choice .button').removeAttr('disabled');
    $('#shop-choice-multiple .modal-content .modal-body > div.button-shop-choice').show();
}

function getShopIdSelectedInNearbyShopsPane(inputChecked) {
    return inputChecked.parent().find('.button-shop-choice').data('shop');
}

function getShopIdSelectedInSelect(optionSelected) {
    return optionSelected.val();
}

//filtre les boutiques, en prenant toutes les boutiques à moins de 100 km d'apèrs GeoDataSource
function filterShopsWithJSCalcDistance(myPosition, shops) {
    nearbyShops = [];
    //recherche dans la liste "availableShops" ou "openedShops" suivant qu'on soit dans la modale ou dans le listing
    $.each(shops, function (i, shop) {
        var distance = calcDistance(parseFloat(shop.geolocation.lat), parseFloat(shop.geolocation.lng), myPosition.lat, myPosition.lng);
        if(distance < 100) {
            shop.displayStock = null;
            shop.hasStock = null;
            var maxResults = $('.list-shop-result .results').data('max-results');
            //si on est sur une map et qu'on est limité en nombre de résultats de boutique, alors on se limite
            if (maxResults == undefined || (maxResults != undefined && nearbyShops.length < maxResults)) {
                nearbyShops.push(shop);
            }
        }
    });
}

function getOnlyNearbyShops(myPosition, shops) {
    var deferred = new $.Deferred();

    //Premier filtre sur les boutiques pour n'en prendre, maximum; que 25 (ne pas changer car impacts)
    //C'est moins coûteux de faire un premier calcul (de distance) pour filtrer les boutiques dans un premier temps
    filterShopsWithJSCalcDistance(myPosition, shops);

    var distances = [];
    var positions = getShopsPositions(nearbyShops);
    //on ne passe que 25 boutiques à l'API (25 par appel max => imposé par l'API "Distance Matrix Service")
    //NB : qu'un seul appel à l'API car on a fait en sorte de bloquer à 25 boutiques max
    var chunk = positions.slice(0, 25);

    if (chunk.length == 0) {
        nearbyShops = [];
        deferred.resolve(nearbyShops);
    } else {
        $.when(
            getInformationDistance(myPosition, chunk)
        ).done(function(res) {
            distances = res['rows'][0]['elements'];
            $.each(nearbyShops, function (i, shop) {
                //pour chaque boutique "proche", on ajoute la donnée "distance" (calculée précisément via
                //l'API "Distance Matrix Service" de Google
                shop.distance =  distances[i]['distance']['text'];
            });

            //on trie les boutiques par distance
            nearbyShops.sort(compareDistanceInKm);

            deferred.resolve(nearbyShops);
        });
    }

    return deferred.promise();
}

//fonction appelée pour calculer les distances pour une liste de boutiques déjà présente dans le DOM (page département)
function getInformationDistanceOfShops() {
    var deferred = new $.Deferred();

    var distances = [];
    var positions = getShopsPositionsFromListing();
    //on ne passe que 25 boutiques à l'API (25 par appel max => imposé par l'API "Distance Matrix Service")
    //NB : qu'un seul appel à l'API car on a fait en sorte de bloquer à 25 boutiques max
    var chunk = positions.slice(0, 25);

    $.when(
        getInformationDistance(myPosition, chunk)
    ).done(function(res) {
        distances = res['rows'][0]['elements'];

        $.each(positions, function (i) {
            //on rajoute l'information "distance" aux boutiques déjà présentes dans le listing à l'initialisation
            $($('.list-shop-result .results li .distance')[i]).html(distances[i]['distance']['text']);
        });

        deferred.resolve(nearbyShops);
    });

    return deferred.promise();
}

function getShopsPositions(shops) {
    var shopPos = [];
    for (i in shops) {
        shopPos.push(new google.maps.LatLng(shops[i]['geolocation']['lat'], shops[i]['geolocation']['lng']));
    }

    return shopPos;
}

function getShopsPositionsFromListing() {
    var shopPos = [];
    $('.main.shop-result .list-shop-result li').each(function(){
        shopPos.push(new google.maps.LatLng($(this).data('lat'), $(this).data('lng')));
    });

    return shopPos;
}

function addStockInformationsForNearbyShopsModal() {
    $.each(nearbyShops, function (i, shop) {
        var shopOption = $('#shopOption' + shop.id);
        shop.displayStock = !(shopOption.data('class') === undefined);
        shop.hasStock = !(shopOption.data('class') === 'no-stock');
    });
}

function setMyPositionWithMyCurrentPosition(callback, parameterCallback) {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
            //on remplit la variabble "myPosition"
            myPosition = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };
            if (typeof callback === "function") {
                callback(parameterCallback);
            }
        }, function () {
            // error
        });
    }
}

function setMyPositionWithZipCode(keyword, callback, parameterCallback) {
    var geocoder = new google.maps.Geocoder();

    geocoder.geocode({'address': keyword}, function(results, status) {
        if (status === 'OK') {
            if (results[0] != undefined && results[0].geometry != undefined && results[0].geometry.location != undefined) {
                myPosition = {
                    lat: results[0].geometry.location.lat(),
                    lng: results[0].geometry.location.lng()
                };
                if (typeof callback === "function") {
                    callback(parameterCallback);
                }
            }
        } else {
            //bad keyword
        }
    });
}

function displayNearbyShops(target) {
    $.when(
        //on récupère les boutiques à proximité d'une position donnée (à partir de la donnée "myPosition")
        getOnlyNearbyShops(myPosition, target === 'modal' ? openedShops : availableShops)
    ).done(function(res) {
        //si on est sur la modale des boutiques
        if (target === 'modal') {
            if ($('.main.product-detail').length > 0) {
                //complète les boutiques avec les informations de stock (si on est sur la fiche produit)
                addStockInformationsForNearbyShopsModal();
            }
            targetAjax = '.geoloc-result';
            callbackModalAjax = function callback() {
                //intialise le bouton de soumission ("choisir cette boutique" avec la valeur pré-selectionnée dans la liste des boutiques à proximité
                setDataShopOnSubmitButton(getShopIdSelectedInNearbyShopsPane($('.geoloc-result input:checked')));
                $(document).on('change', '#shop-choice-multiple #shop-geolocation-results .geoloc-result-content input', function(e) {
                    setDataShopOnSubmitButton(getShopIdSelectedInNearbyShopsPane($(e.target)));
                });
                //cache le bloc "vous avez sélectionné la boutique"
                $('#shop-choice-multiple .result').hide();
                //déselectionner la boutique préférée
                $('.shop-choice select').select2('val', '0')
                //cacher le bouton "choisir ma boutique" en mobile
                if (window.innerWidth < 768) {
                    $('#shop-choice-multiple .modal-content .modal-body > div.button-shop-choice').hide();
                }
            };

            //si on est sur une map (listing des boutiques les plus proches)
        } else if (target === 'map') {
            targetAjax = '.list-shop-result';
            callbackModalAjax = function callback() {
                //on ajoute une classe qui va permettre d'afficher le bloc'.list-shop-result'
                $('#shopsHomepage').addClass('shop-result');
                //on change la balise h1 car on passe en mode liste
                newH1 = $('.shop-finder-home .title-2')[0].innerText.replace('LDLC.COM', '');
                $('.shop-finder-home .title-2')[0].innerText=newH1;
                //on met à jour le nombre de boutiques à proximité
                $('.shop-finder-department .title-2 span.number')[0].innerText = $('.list-shop-result ul li').length;

                //on vient de demander les boutiques les plus proches (ou les plus proches d'une recherche textuelle)
                //alors on initialise la carte avec ces données (données présentes dans le listing '.list-shop-result')
                initMapAndShopsListing();

                var currentFavoriteShopId = $('.main .list-shop-result').data('favorite-shop-id');
                //on met le "coeur rouge" pour la boutique en favorite
                if (currentFavoriteShopId !== undefined && currentFavoriteShopId !== -1) {
                    toggleIconFavoriteShop($(".main .list-shop-result ul li[data-shop='".concat(currentFavoriteShopId.toString()).concat("'] .save-favorite-shop")));
                }
            }
        } else {
            return;
        }

        urlAjax = Routing.generate(
            'get_nearby_shops',
            {'_locale': i18n.locale, 'country': i18n.country},
            false
        );
        replaceAjax = false;
        dataAjax = {'nearbyShops': JSON.stringify(nearbyShops), 'applicant': target};
        $('.ajaxWait').show();
        //on injecte les nearbyShops dans le template voulu
        ajaxCallWithData(urlAjax, targetAjax, replaceAjax, dataAjax, callbackModalAjax);
    });
}

// https://www.geodatasource.com/developers/javascript
function calcDistance(lat1, lng1, lat2, lng2) {
    // Convert degrees to radians
    var radlat1 = Math.PI * lat1/180;
    var radlat2 = Math.PI * lat2/180;
    var theta = lng1-lng2;
    var radtheta = Math.PI * theta/180;
    var dist = Math.sin(radlat1) * Math.sin(radlat2) + Math.cos(radlat1) * Math.cos(radlat2) * Math.cos(radtheta);
    if (dist > 1) {
        dist = 1;
    }
    dist = Math.acos(dist);
    dist = dist * 180/Math.PI;
    // multiply by 1.609344 to get kilometers
    dist = dist * 60 * 1.1515 * 1.609344;

    return dist;
}

function compareDistanceInKm(a, b) {
    var distanceA = parseFloat(a.distance.replace(" km", "").replace(",", "."));
    var distanceB = parseFloat(b.distance.replace(" km", "").replace(",", "."));
    return (distanceA > distanceB) ? 1 : (distanceA < distanceB) ? -1 : 0;
}

function compareByStock(a, b) {
    var stockA = $(a).data('class') || '';
    var stockB = $(b).data('class') || '';

    if (stockA == '' && stockB == 'no-stock') {
        //faire remonter la donnée dans la liste
        return -1;
    } else if (stockA == 'no-stock' && stockB == '') {
        //faire descendre la donnée dans la liste
        return 1;
    }
}

$(document).on('change', '#stock-option', function(e) {
    e.preventDefault();
    setViewMode(this.value);
});

$(document).on('click', '.product-shop-choice', function(e) {
    e.preventDefault();
    getStockForShops();
});

$(document).on('click', '.add-shop-to-user', function(e) {
    e.preventDefault();
    setFavoriteShop( $('.main').data('shop-id'), 'shop');
});

$(document).ready(function(){
    //si on est sur la page "magasins-ldlc" (homepage shops)
    if ($('#shopsHomepage').length > 0){
        shopsHomepageSetUp();
    }

    //si on est sur la page "departement"
    if ($('#shopsDepartment').length > 0){
        shopsDepartmentPageSetUp();
    }

    //si on est sur une page boutique
    if ($('#shopsPage').length > 0){
        shopPageSetUp();
    }
});
