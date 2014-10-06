$(document).ready(function () {
//    var addresspicker = $("#ws_ovsbundle_evenement_adresse").addresspicker({
//        componentsFilter: 'country:FR'
//    });

    var addresspickerMap = $("#ws_ovsbundle_evenement_adresse").addresspicker({
        regionBias: "fr",
        language: "fr",
        componentsFilter: 'country:FR',
        updateCallback: showCallback,
        mapOptions: {
            zoom: 4,
            center: new google.maps.LatLng(46, 2),
            scrollwheel: false,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        },
        elements: {
            map: '#map_canvas',
            locality: '#ws_ovsbundle_evenement_ville',
            postal_code: '#ws_ovsbundle_evenement_codePostal',
        }
    });

    var gmarker = addresspickerMap.addresspicker("marker");
    gmarker.setVisible(true);
    addresspickerMap.addresspicker("updatePosition");

    $('#reverseGeocode').change(function () {
        $("#addresspicker_map").addresspicker("option", "reverseGeocode", ($(this).val() === 'true'));
    });

    function showCallback(geocodeResult, parsedGeocodeResult) {
        $('#callback_result').text(JSON.stringify(parsedGeocodeResult, null, 4));
    }
    // Update zoom field
    var map = $("#addresspicker_map").addresspicker("map");
    google.maps.event.addListener(map, 'idle', function () {
        $('#zoom').val(map.getZoom());
    });

});

