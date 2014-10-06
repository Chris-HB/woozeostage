$(document).ready(function () {

//    var $adresse = $('#ws_ovsbundle_evenementedit_adresse').text();
//    var geocoder, map;
//    codeAddress($adresse);

    var $latitude = $('#ws_ovsbundle_evenementedit_latitude').val();
    var $longitude = $('#ws_ovsbundle_evenementedit_longitude').val()

    var addresspickerMap = $("#ws_ovsbundle_evenementedit_adresse").addresspicker({
        regionBias: "fr",
        language: "fr",
        componentsFilter: 'country:FR',
        updateCallback: showCallback,
        mapOptions: {
            zoom: 15,
            center: new google.maps.LatLng($latitude, $longitude),
            scrollwheel: false,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        },
        elements: {
            map: '#map_canvas',
            lat: '#ws_ovsbundle_evenementedit_latitude',
            lng: '#ws_ovsbundle_evenementedit_longitude',
            locality: '#ws_ovsbundle_evenementedit_ville',
            postal_code: '#ws_ovsbundle_evenementedit_codePostal',
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

//    function codeAddress($adresse) {
//        geocoder = new google.maps.Geocoder();
//        geocoder.geocode({
//            'address': $adresse
//        }, function (results, status) {
//            if (status == google.maps.GeocoderStatus.OK) {
//                var myOptions = {
//                    zoom: 15,
//                    center: results[0].geometry.location,
//                    mapTypeId: google.maps.MapTypeId.ROADMAP
//                }
//                map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
//
//                var marker = new google.maps.Marker({
//                    map: map,
//                    position: results[0].geometry.location
//                });
//            }
//        });
//    }

});

