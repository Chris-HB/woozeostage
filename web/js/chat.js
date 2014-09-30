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
    window.onload = afficheBox;
    window.onbeforeunload = enregistreInfosBox;

    //--
    // cette fonction récupère le contenu de la variable session "infosbox"
    // à savoir le tableau boxTab
    // après avoir réactualisé ou rechargé la page
    //--
    function afficheBox() {
        alert('function afficheBox');
        $.ajax({
            type: "POST",
            url: Routing.generate('ws_chat_recupSession'),
            async: false,
            cache: false,
            success: function(data) {
                $data = JSON.parse(data);
            }
        });
        // on affecte à boxTab le tableau JSON $data
        if (boxTab == null && $data != null) {
            var boxTab = [];
            for (i = 0; i < $data.length; i++) {
                boxTab.push($data[i]);
            }
        }
        //---
        var message = '- Tableau boxTab - ' + " \n";
        for (j = 0; j < boxTab.length; j++) {
            message = message + j + ': ' + boxTab[j] + "  \n";
        }
        alert(message);
    }

    //--
    // cette fonction envoi le tableau boxTab (contenant les id des boites ouvertes) dans une variable session
    // avant de réactualiser ou recharger la page
    //--
    function enregistreInfosBox() {
        alert('function enregistreInfosBox');
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

        $("#chris").chatbox("option", "boxManager").addMsg("chris", "Bob", "Barrr!");
        $("#chris").chatbox("option", "boxManager").addMsg("Chris", "Chris", "mais t'es où Bob!");
    });
});
