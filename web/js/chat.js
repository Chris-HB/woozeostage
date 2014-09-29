var boxTab = [];
var messTab = [];
var $margeDroiteDesBox = 10;
var $espaceEntreBox = 20;

$(document).ready(function() {
    var box = null;

    // si la page est réactualisée
    window.onload = afficheBox;

    function afficheBox() {
        //alert('toto');
        $("#chris").chatbox("option", "boxManager").addMsg("Bob", "Barrr!");
        $("#chris").chatbox("option", "boxManager").addMsg("Chris", "mais t'es où Bob!");
    }

    $("#userclick li").click(function() {
        var $username = $(this).text();
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

        //---
        // TEST messTab
        var message = '';
        for (j = 0; j < messTab.length; j++) {
            message = message + j + ': ' + messTab[j] + "  \n";
        }
        alert(message);
//        $("#chris").chatbox("option", "boxManager").addMsg("Bob", "Barrr!");
//        $("#chris").chatbox("option", "boxManager").addMsg("Chris", "mais t'es où Bob!");
    });
});
