$(document).ready(function () {
    var $name = $("input#name");
    var $matri = $("select#matri");
    var $sites = $("select#sites");
    var $salles = $("select#salles");
    var $counter = $("b#counter");
    var $nbrSurv = $("#nbreSurv");

    // events
    $matri.selectize();

    // FUNCTIONS
    function getTimeRemaining() {
        $.ajax({
            url: api_url + "time_remaining.php",
            success: function (result, status, xhr) {

                if (result === "00:00:00" || result.startsWith("-")) {
                    window.location.reload();
                } else {
                    $counter.html(result);
                }
            }
        });
    }

    if ($name.length > 0) {
        $matri.change(function () {
            if ($matri.val() !== "") {
                let current_mat = matris.find((c) => c.idUtilisateur === $matri.val());
                $name.val(current_mat.Nom);
            } else {
                $name.val("");
            }
        })
    }

    function getNbreSurvForSalle(idSalle) {
        $.ajax({
            url: api_url + "get_nbre_surv_for_salle.php",
            type: "get",
            data: {id: idSalle},
            success: function (res) {
                console.log(res);

                $nbrSurv.html(res === 1 ? res + " surveillant affecté" : res + " surveillants affectés");
            }
        })
    }

    if ($salles.length > 0) {
        $salles.change(function () {
            let val = $salles.val();
            if (val !== "") {
                getNbreSurvForSalle(val);
            }
        });
        $sites.change(function () {
            $salles.html("");
            $salles.append("<option></option>");
            if ($sites.val() !== "") {
                var ls_salles = salles.find(function (o) {
                    return o.idSite === $sites.val();
                }) ["salles"];

                for (let i = 0; i < ls_salles.length; i++) {
                    $salles.append("<option value='" + ls_salles[i]["idSalle"] + "'> Salle -" +
                        ls_salles[i]["NumSalle"] +
                        "</option>");
                }
            }
        })
    }

    // main code
    if ($counter.length > 0) {
        setInterval(() => {
            getTimeRemaining()
        }, 900);
    }
});
