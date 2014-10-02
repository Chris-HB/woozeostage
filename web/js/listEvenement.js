$(document).ready(function () {
    envoie();

    $('#actif').change(function () {
        envoie();
    });

    $('#tri').change(function () {
        envoie();
    });

    function envoie() {
        $.ajax({
            type: "POST",
            url: Routing.generate('ws_ovs_admin_listevenement'),
            cache: false,
            data: {actif: $('#actif').val(), tri: $('#tri').val()},
            success: function (data) {
                $('#resultats').html(data);
            }
        });
    }
});
