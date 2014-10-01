//--- VARIABLES GLOBALES -----

var boxTab = [];
var $margeDroiteDesBox = 10;
var $espaceEntreBox = 20;
//---------------------------



$(document).ready(function() {
    var box = null;

    // ----------------------------
    // si la page est réactualisée
    // ----------------------------
    window.onload = recupInfosBox;
    window.onbeforeunload = enregistreInfosBox;

    //--
    // cette fonction récupère le contenu de la variable session "infosbox"
    // à savoir le tableau boxTab
    // après avoir réactualisé ou rechargé la page
    //--
    function recupInfosBox() {
        /////////////alert('function recuptInfosBox');
        $.ajax({
            type: "POST",
            url: Routing.generate('ws_chat_recupSession'),
            async: false,
            cache: false,
            success: function(data) {
                $data = JSON.parse(data);
            }
        });
        // on affecte à boxTabJSON le tableau JSON $data
        /////////////alert('data : ' + $data);
        if ($data != null) {
            var boxTabJSON = [];
            var existe = 0;
            for (i = 0; i < $data.length; i++) {
                // on verifie que la valeur (id de Box) n'existe pas déjà dans le tableau
                existe = $.inArray($data[i], boxTabJSON);
                if (existe == -1) {
                    boxTabJSON.push($data[i]);
                }
            }
        }
        ////////////alert('json : ' + boxTabJSON);

        boxTab.length = 0;
//
        // si le tableau JSON a un contenu alors boxTab le récupère
        // c'est à dire que l'on ne récupère uniquement les données en session
        if (boxTabJSON.length !== 0) {
            boxTab = boxTabJSON;
        }
        //////////////alert('box --' + boxTab);
//        //---
//        var message = '';
//        message = '- Tableau boxTab - ' + " \n";
//        for (j = 0; j < boxTab.length; j++) {
//            message = message + j + ': ' + boxTab[j] + "  \n";
//        }
//        alert(message);
//
        // Affichage des box après réactualisation de la page
        /////////////////alert('taille du tableau : ' + boxTab.length);
        if (boxTab.length > 0) {
            for (i = 0; i < boxTab.length; i++) {
                afficheBox(boxTab[i]);
            }
        }

    }

    //--
    // cette fonction envoi le tableau boxTab (contenant les id des boites ouvertes) dans une variable session
    // avant de réactualiser ou recharger la page
    //--
    function enregistreInfosBox() {
        ////////////alert('function enregistreInfosBox');
        $.ajax({
            type: "POST",
            async: false,
            url: Routing.generate('ws_chat_varSession'),
            data: {infosbox: boxTab},
            cache: false
        });
    }
    //------------------------------


    $("#userclick li").click(function() {
        var $username = $(this).text();
        var pseudo = ($("#pseudo").data("pseudo"));
        var $container = $("#chat_div");
        var $divexiste = false;
//        //---
        var $nbBox = $('div.chatbox').length;
        var $marge = $nbBox * (300 + $espaceEntreBox) + $margeDroiteDesBox;

        // ----------
        // Affichage
        // ----------
        //
        // on teste si un div ayant un id du même nom que le username_box existe déjà
        $('div').each(function() {
            if ($(this).attr('id') == $username + '_box') {
                $divexiste = true;
            }
        });

        // ---
        // si il n'existe pas, je le créer (id=username)
        // ---
        if (!$divexiste) {
            $container.append('<div id="' + $username + '"></div>');
            //
            // on ajoute l'username à la fin du tableau boxTab
            boxTab.push($username);
            //
            // je crée une box
            box = $('#' + $username).chatbox({id: $username,
                title: "woozeostage chat : " + $username,
                offset: $marge,
                user: {key: "value"},
                messageSent: function(id, user, msg) {
                    $("#log").append(id + " said: " + msg + "<br/>");
                    $('#' + $username).chatbox("option", "boxManager").addMsg(id, pseudo, msg);
                }});
        }

        //-------------------
        // affichage des box
        //---
        //$("#chris").chatbox("option", "boxManager").addMsg("chris", "Bob", "Barrr!");
        //$("#chris").chatbox("option", "boxManager").addMsg("Chris", "Chris", "mais t'es où Bob!");

    });

    //
    // essai de simulation de clic
    //
    //$("#userclick li span").trigger("click");



    function afficheBox(id) {
        var $username = id;
        var pseudo = ($("#pseudo").data("pseudo"));
        var $container = $("#chat_div");
        var $divexiste = false;
        //---
        var $nbBox = $('div.chatbox').length;
        var $marge = $nbBox * (300 + $espaceEntreBox) + $margeDroiteDesBox;

        // ----------
        // Affichage
        // ----------
        //
        // on teste si un div ayant un id du même nom que le username_box existe déjà
        $('div').each(function() {
            if ($(this).attr('id') == $username + '_box') {
                $divexiste = true;
            }
        });

        // ---
        // si il n'existe pas, je le créer (id=username)
        // ---
        if (!$divexiste) {
            $container.append('<div id="' + $username + '"></div>');

            // je crée une box
            box = $('#' + $username).chatbox({id: $username,
                title: "woozeostage chat : " + $username,
                offset: $marge,
                user: {key: "value"},
                messageSent: function(id, user, msg) {
                    $("#log").append(id + " said: " + msg + "<br/>");
                    $('#' + $username).chatbox("option", "boxManager").addMsg(id, pseudo, msg);
                }});
        }
    }

});
