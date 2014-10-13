$(document).ready(function () {

    $('#createur input').attr('disabled', true);

    $('#ws_ovsbundle_evenementgerer input').click(function () {
        var $cal = calcul();
        $('#nombreValide').html('<strong>' + $cal + '</strong>');
        if ($cal > $('#inscrit').text()) {
            alert('vous avez trop d\'inscrit par rapport au nombre de place disponible');
            $(':submit').attr("disabled", true)
        }
        else {
            $(':submit').removeAttr("disabled")
        }
    });

    function calcul() {
        var $cal = 0;
        $('#ws_ovsbundle_evenementgerer input').each(function () {
            if ($(this).is(':checked') && $(this).val() == 1) {
                $cal++;
            }
        });
        return $cal;
    }
});