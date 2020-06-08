$(document).ready(function () {

    // VARIABLES
    var $counter = $("#counter");

    // FUNCTIONS
    function getTimeRemaining() {
        $.ajax({
            url:  "../../views/api/time_remaining.php",
            success: function (result, status, xhr) {

                console.log((result));
                if (result === "00:00:00" || result.startsWith("-")) {
                    window.location.reload();
                } else {
                    $counter.html(result);
                }
            }
        });
    }

    function getFreeBusy(id) {
        $.ajax({
            url: "../../views/api/get_machines_oqp.php?id=" + id,
            success: function (result, status, xhr) {
                // // console.log(JSON.parse(result));

                var res = JSON.parse(result);


                $(".oqp" + id).html("Nombre de postes libres : " + res.free + "<i class=\"fa  fa-laptop\"></i>");
                $(".free" + id).html("Nombre de postes occupés : " + res.busy + "<i class=\"fa  fa-laptop\"></i>");

            }
        });
    }

    function get_machines() {
        $tbody = $("#tbody");
        $tbody.html("");
        var data = {
            _token: $("#csrftoken").val(),
            action: $("#action").val(),
            salle: ($("#salle").val() === "") ? "-1" : $("#salle").val(),
            day: $("#day").val(),
        };
        swal({
            title: "Récupération des machines...",
            html: true,
            text: "<div class=\"spinner-border text-primary\" role=\"status\">\n" +
                "  <span class=\"sr-only\">Loading...</span>\n" +
                "</div>",
            closeOnConfirm: false
        });

        // console.log(data);
        $.ajax({
            url: base_url + "index.php",
            type: "post",
            data: data,
            success: function (res) {
                console.log(res);
                var response = res;

                // console.log(!response.can || response.error);
                // console.log(response.error);
                // Ne peut pas réserver
                if (!response.can || response.error) {
                    swal({
                        title: "Erreur",
                        type: (response.error ? "error" : "warning"),
                        text: response.msg,
                        closeOnConfirm: false,
                    }, function () {
                        // Recharger la page
                        window.location.reload();
                    })
                } else {
                    update_ui(response.data);
                }
            },
            complete: function (xhr, status) {
                console.log(xhr.responseText);
                if (status === "error") {
                    console.log(xhr.status);
                    if (xhr.status === 0) {
                        swal({
                            title: "OOPS!",
                            html: true,
                            type: "error",
                            text: "Vous n'avez pas de connexion internet. &#x1F605;"
                        })
                    }
                } else {
                    swal.close();
                }
            }
        })
    }

    function update_ui(data) {
        $tbody = $("#tbody");
        $tbody.html("");

        // console.log(data);

        for (let i = 0; i < data.length; i++) {
            $tbody.append("<tr>\n" +
                "        <td>\n" +
                "        machine-" + data[i].NumMachine + "\n" +
                "        </td>\n" +
                "        <td>\n" +
                "        <select name=\"plage\" style=\"height: 35px; width: 130px; font-size: 15px\"\n" +
                "    class=\"form-control form-control-lg\" id='pl-" + +data[i].idMachine + "'> " +
                data[i].dispos.map(function (val) {
                    return "<option value='" + val + "'>" + val + "</option>";
                }) +
                "            </select>\n" +
                "            </td>\n" +
                "            <td class=\"text-right pr-4\">\n" +
                "            <button class=\"btn btn-success\" onclick=\"reserver('" + data[i].idMachine + "')\"><i class=\"fa fa-check\"></i>\n" +
                "        Réserver\n" +
                "        </button>\n" +
                "        </td>\n" +
                "        </tr>"
            )
        }
    }


    // EVENTS
    $("#form").submit(function (e) {
        e.preventDefault();
        e.stopPropagation();
        get_machines();
    });

    $(".slick").slick({
        centerMode: true,
        centerPadding: '60px',
        slidesToShow: 3,
        autoplay: true,
        autoplaySpeed: 5000,
        prevArrow: " <i class='slick-prev fa fa-arrow-circle-left'></i>",
        nextArrow: "<i class='slick-next fa fa-arrow-circle-right'></i>",
        responsive: [
            {
                breakpoint: 999,
                settings: {
                    centerMode: true,
                    centerPadding: '40px',
                    slidesToShow: 2
                }
            },
            {
                breakpoint: 800,
                settings: {
                    arrows: true,
                    centerMode: true,
                    centerPadding: '40px',
                    slidesToShow: 1
                }
            },
            {
                breakpoint: 480,
                settings: {
                    arrows: false,
                    centerMode: true,
                    centerPadding: '40px',
                    slidesToShow: 1
                }
            }
        ]
    });

    //----- OPEN MODAL
    $('[data-open]').on('click', function (e) {
        // console.log("here");
        var data = $(this).attr("data");

        var SITE = salles.find(function (site) {
            return site.idSite === data;
        });

        // console.log(SITE.NomSite);
        // console.log(SITE);

        $("#popup-title").html(SITE.NomSite);

        // Remplir les différentes salles
        $salle = $("#salle");

        $salle.html("");
        if (SITE.salles.length === 0) {
            $salle.html("<option></option>");
        }

        for (var salle in SITE.salles) {
            // console.log(SITE.salles);

            var sal = SITE.salles[salle];
            $salle.append("<option value='" + sal.idSalle + "'>Salle - " + sal.NumSalle + "</option>")
        }

        // récupérer les machines
        get_machines();
        e.preventDefault();
        e.stopPropagation();

        $("#modal").modal();
    });

    //----- CLOSE MODAL
    $('[pd-popup-close]').on('click', function (e) {
        var targeted_popup_class = $(this).attr('pd-popup-close');
        $('[pd-popup="' + targeted_popup_class + '"]').fadeOut(200);

        e.preventDefault();
    });

    // main code
    if ($counter.length > 0) {
        setInterval(() => {
            getTimeRemaining()
        }, 900);
    }

    for (let i = 1; i <= 4; i++) {
        if(($(".oqp" + i)).length > 0) {
            setInterval(() => {
                getFreeBusy(i)
            }, 1000);
        }

    }

});