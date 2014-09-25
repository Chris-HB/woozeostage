$(document).ready(function() {
    var box = null;
    var boxTab = [];
    $("#userclick li").click(function() {
        var $username = $(this).text();
        var pseudo = ($("#pseudo").data("pseudo"));
        var $container = $("#chat_div");
        var $divexiste = false;
        //---
        var $nbBox = $('div.chatbox').length;
        var $margeDroiteDesBox = 20;
        var $espaceEntreBox = 20;
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
                tab: boxTab,
                user: {key: "value"},
                messageSent: function(id, user, msg) {
                    $("#log").append(id + " said: " + msg + "<br/>");
                    $('#' + $username).chatbox("option", "boxManager").addMsg(pseudo, msg);
                }});
        }

        //---
        // Affiche le contenu de boxTab
        //--
        var result = '';
        for (i = 0; i < boxTab.length; i++) {
            result = result + boxTab[i] + "--";
        }
        alert(result);

    });
});
