$(document).ready(function () {
    var $adresse = $('#adresse').text();
    var geocoder, map;
    codeAddress($adresse);

    function codeAddress($adresse) {
        geocoder = new google.maps.Geocoder();
        geocoder.geocode({
            'address': $adresse
        }, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                var myOptions = {
                    zoom: 15,
                    center: results[0].geometry.location,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                }
                map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);

                var marker = new google.maps.Marker({
                    map: map,
                    position: results[0].geometry.location
                });
            }
        });
    }
});

