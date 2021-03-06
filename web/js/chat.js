//--- VARIABLES GLOBALES -----
var box = null;
var boxTab = [];
var $margeDroiteDesBox = 10;
var $espaceEntreBox = 20;
//---------------------------

//*************************************
// Communication avec le serveur
// SOCKET
// on récupère le message de l'emetteur et on le transmet au recepteur
//----
function clientApp() {
    var client = new Faye.Client('http://localhost:3000/');
    var pseudo = ($("#pseudo").data("pseudo"));
    var messB = [];
    var tab = [];

    client.subscribe('/messages', function(message) {
        //alert('message de ' + message.emetteur + ' à ' + message.recepteur + ' : ' + message.message);
        //
        // reconstruction du tableau messB au bon format
        messB.length = 0;
        tab.length = 0;
        tab.push(message.emetteur);
        tab.push(message.recepteur);
        tab.push(message.message);
        messB.push(tab);
        //---
        // si le recepteur est l'utilisateur connecté
        if (pseudo == message.recepteur) {
            //alert('pseudo: ' + pseudo + ' ---- recepteur: ' + message.recepteur);
            //alert('emetteur: ' + messB[0][0] + ' --- recepteur: ' + messB[0][1] + ' --- message: ' + messB[0][2]);

            // on affiche la box et le message qu'elle vient de recevoir
            afficheBox(message.emetteur);
            $('#' + message.emetteur).chatbox("option", "boxManager").addMsg(messB[0][1], messB[0][0], messB[0][2]);

            // on verifie que la valeur (id de Box) n'existe pas déjà dans le tableau boxTab
            // si ce n'est pas le cas on la rajoute
            existe = $.inArray(message.emetteur, boxTab);
            if (existe == -1) {
                boxTab.push(message.emetteur);
            }

        }
    });
}


//*************************************
// Affiche la Box dont l'id est "id"
//----
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
                $('#' + $username).chatbox("option", "boxManager").addMsgBase(id, pseudo, msg);
            }});
    }
}

//**************************************
// Affiche les messages de la box
// dont l'id est "id"
//
// messBox[][0] -> emetteur
// messBox[][1] -> recepteur
// messBox[][2] -> message
//
//---
function afficheMessagesBox(id, messBox) {
    for (j = 0; j < messBox.length; j++) {
        if (messBox[j][1] == id) {
            $('#' + id).chatbox("option", "boxManager").addMsg(messBox[j][1], messBox[j][0], messBox[j][2]);
        }
    }
}

//-------------------------------------------------------------------------------------------------------------------------------
$(document).ready(function() {
//var box = null;
    clientApp();
    // ----------------------------
    // si la page est réactualisée
    // ----------------------------
    window.onload = recupInfosBox;
    window.onbeforeunload = enregistreInfosBox;
    //***********************************************************************
    // Après avoir réactualisé ou rechargé la page
    // cette fonction récupère le contenu de la variable session "infosbox"
    // à savoir le tableau boxTab
    //---
    function recupInfosBox() {
        $.ajax({
            type: "POST",
            url: Routing.generate('ws_chat_recupSession'),
            async: false,
            cache: false,
            success: function(data) {
                $data = JSON.parse(data);
            }
        });
        // je recupère un tableau d'id des Box
        var idBox = [];
        idBox = $data[0];
        // je recupère un tableau des messages des Box
        var messBox = [];
        messBox = $data[1];
        // on affecte à boxTabJSON le tableau JSON $idBox
        if (idBox != null) {
            var boxTabJSON = [];
            var existe = 0;
            for (i = 0; i < idBox.length; i++) {
                // on verifie que la valeur (id de Box) n'existe pas déjà dans le tableau
                existe = $.inArray(idBox[i], boxTabJSON);
                if (existe == -1) {
                    boxTabJSON.push(idBox[i]);
                }
            }
        }

        boxTab.length = 0;
        // si le tableau JSON a un contenu alors boxTab le récupère
        // c'est à dire que l'on ne récupère uniquement les données en session
        if (boxTabJSON.length !== 0) {
            boxTab = boxTabJSON;
        }
        //----
        // Affichage des box après réactualisation de la page
        //---
        if (boxTab.length > 0) {
            // on crée les box
            for (i = 0; i < boxTab.length; i++) {
                afficheBox(boxTab[i]);
                afficheMessagesBox(boxTab[i], messBox);
            }
        }
    }


    //************************************************
    // Cette fonction envoi le tableau
    // boxTab (contenant les id des boites ouvertes)
    // dans une variable session avant de
    // réactualiser ou recharger la page
    //---
    function enregistreInfosBox() {
        $.ajax({
            type: "POST",
            async: false,
            url: Routing.generate('ws_chat_varSession'),
            data: {infosbox: boxTab},
            cache: false
        });
    }


    //************************************
    // Dans l'historique des chats
    // si on clic sur un utilisateur
    // le div s'affiche ou disparait
    //---
    $("#listchats li").click(function() {
        var idDiv = $(this).text() + '_chat'
        $("#" + idDiv).toggle();
    });


    //****************************************
    // Si passe la souris sur un utilisateur
    // le curseur change de forme
    //---

    //-- Liste des utilisateur connectés
    $("#userclick li").mouseover(function() {
        $("span", this).addClass("aspectcurseur");
    });
    //-- Liste des utilisateurs (Historique des chats)
    $("#listchats li").mouseover(function() {
        $("span", this).addClass("aspectcurseur");
    });

    //*********************************
    // Si on clic sur un utilisateur
    //---
    $("#userclick li").click(function() {
        var $username = $(this).text();
        var pseudo = ($("#pseudo").data("pseudo"));
        var $container = $("#chat_div");
        var $divexiste = false;
        //---
        var $nbBox = $('div.chatbox').length;
        var $marge = $nbBox * (300 + $espaceEntreBox) + $margeDroiteDesBox;
        // si le nombre de boites affichées est supérieur à 5
        // on ne peut plus en ouvrir d'autres
        if ($nbBox > 4) {
            alert('Vous avez trop de fenêtres Chat ouvertes !');
        }
        else {
            //
            //---
            // j'envoie l'id de la box au controleur
            //---
            var idTab = [];
            idTab.push($username);
            $.ajax({
                type: "POST",
                url: Routing.generate('ws_chat_recupSession'),
                async: false,
                cache: false,
                data: {idbox: idTab},
                success: function(data) {
                    $datamess = JSON.parse(data);
                }

            });
            //---
            // je recupère l'historique des messages
            //---
            var messBox = [];
            messBox = $datamess[1];
            // ---
            // Affichage
            // ---
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
                        $('#' + $username).chatbox("option", "boxManager").addMsgBase(id, pseudo, msg);
                    }});
            }

            //---
            // on affiche les x derniers messages s'il y en a
            // et surtout si la box n'est pas déjà ouverte
            //---
            if (length.messBox != 0 && !$divexiste) {
                afficheMessagesBox($username, messBox);
            }
        }
    });
});
