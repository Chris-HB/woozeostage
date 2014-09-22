$(document).ready(function() {
    var box = null;
    $("#userclick span").click(function() {
        var $username = $(this).text();
        //var $username = $("#userclick li").data("userclick");
        //var $username = event.srcElement;
        //alert($username);
        var pseudo = ($("#pseudo").data("pseudo"));
        if (box) {
            box.chatbox("option", "boxManager").toggleBox();
        }
        else {
            box = $("#chat_div").chatbox({id: "chat_div",
                user: {key: "value"},
                title: "woozeostage chat : " + $username,
                messageSent: function(id, user, msg) {
                    $("#log").append(id + " said: " + msg + "<br/>");
                    $("#chat_div").chatbox("option", "boxManager").addMsg(pseudo, msg);
                }});
        }
    });
});