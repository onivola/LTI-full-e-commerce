$(document).ready(function () {
    var currentLocation = window.location.href;
    sessionStorage .setItem('lastAjaxListingLocation', currentLocation);
    $(window).bind("popstate", function(e) {
        //if no anchor '#...' => do action 'back navigateur'
        if (window.location.hash == '' && window.location.href.indexOf('#') == -1) {
            e.preventDefault();
            var newLocation = window.location.href;
            if (sessionStorage.getItem('lastAjaxListingLocation') != newLocation) {
                $(".ajaxWait").show();
                sessionStorage .setItem('lastAjaxListingLocation', newLocation);
                currentLocation = newLocation;
                window.location = sessionStorage.getItem('lastAjaxListingLocation');
            } else {
                $(".ajaxWait").hide();
            }
        }
    });
});
