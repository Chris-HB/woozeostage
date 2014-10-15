$(document).ready(function () {
    var $adresse = $('#adresse').text();
    var $lat = $('#lat').text();
    var $lon = $('#lon').text();
    var geocoder, map;
    //codeAddress($adresse);
    testMap($lat, $lon);

    /**
     *
     * @param {type} $adresse
     * @returns {undefined}
     *
     * affiche la map centrer sur l'adresse
     */
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

    /**
     *
     * @param {type} $lat
     * @param {type} $lon
     * @returns {undefined}
     *
     * affiche la map centrer sur la latitude longitude
     */
    function testMap($lat, $lon) {
        var latlng = new google.maps.LatLng($lat, $lon);
        //objet contenant des propriétés avec des identificateurs prédéfinis dans Google Maps permettant
        //de définir des options d'affichage de notre carte
        var options = {
            center: latlng,
            zoom: 15,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };

        //constructeur de la carte qui prend en paramêtre le conteneur HTML
        //dans lequel la carte doit s'afficher et les options
        map = new google.maps.Map(document.getElementById("map_canvas"), options);

        var marker = new google.maps.Marker({
            map: map,
            position: latlng
        });
    }
});

