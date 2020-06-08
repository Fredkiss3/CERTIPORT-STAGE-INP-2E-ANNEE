$(document).ready(function () {
    // Les différents éléments
    var $elt1 = $('#S_etape1');
    var $elt2 = $('#S_etape2');
    var $elt3 = $('#S_etape3');
    var $etape_1 = $("#etape_1");
    var $etape_2 = $("#etape_2");
    var $etape_3 = $("#etape_3");
    var $ecole = $("#ecole");
    var $filiere = $("#filiere");
    var $classe = $("#classe");
    var $matri = $("#matri").attr("maxlength", 10).attr("placeholder", "19INP00XXX / XXXXXXXXXX");
    var $alert = $("#alert");

    $("#inputTel").inputmask("99 99 99 99");
    var matri = "";

    $matri.on('keyup', function (e) {
        if (($matri.val().length <= 10)) {
            matri = $matri.val();
            e.preventDefault();
            e.stopPropagation();
        } else {
            $matri.val(matri);
        }
    });

    // Les écoles de l'INP & leurs filières
    var INP = {

        AUCUN : {
            AUCUN: [
                "AUCUN"
            ],
        },
        ESI: {
            STIC: [
                "TS STIC",
                "TS E2IT",
                "TS INFO",
                "ING E2I",
                "ING INFO",
                "ING TR",
                "ING ELN",
            ],
            STGP: [
                "TS STGP",
                "TS EAI",
                "TS PMSI",
            ],
            STGI: [
                "TS STGI",
                "TS CI",
                "TS CA",
                "ING STGI",
                "ING GBP",
                "ING GPI",
            ],
        },
        ESCAE: {
            CAE: [
                "TS CAE",
                "TS GC",
                "TS FC",
                "TS LT",
                "ING ILT",
            ],
            HEA: [
                "TS HEA",
                "ING HEA",
            ],
        },
        ESTP: {
            "BATIMENT ET URBANISME": [
                "TS GC",
                "TS GEOMETRE",
            ],
        },
        ESMG: {
            MINES: [
                "MG",
            ],
            PETROLE: [
                "PETROCHIMIE"
            ],
        },
        ESA: {
            TSA: [
                "TSA",
            ],
            IGA: [
                "IGA",
            ],
        },
        EDP: {
            EDP: [
                "RECHERCHE",
            ]
        },
        'CLASSES PREPARATOIRES': {
            PREPA: [
                "PREPA BIO",
                "PREPA MPSI",
                "PREPA ECS",
            ]
        },
    };

    // Si les étapes ont été validées
    var etape_1_validated = false;
    var etape_2_validated = false;

    // Formulaire étape 1 & étape 2
    var $form_etape_1 = $("#etape_1_form");
    var $form_etape_2 = $("#etape_2_form");
    var $form_etape_3 = $("#etape_3_form");

    // Fonctions
    function getXhr() {
        var xhr;
        if (window.XMLHttpRequest) {
            xhr = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xhr = new ActiveXObject("Microsoft.XMLHTTP");
        }

        return xhr;
    }

    function valide_etape_1() {
        swal({
            html: true,
            text: "<div class=\"spinner-border text-primary\" role=\"status\">\n" +
                "  <span class=\"sr-only\">Loading...</span>\n" +
                "</div>",
            closeOnConfirm: false,
            showConfirmButton: false,
            showCancelButton: false,
            title: "Récupération de l'utilisateur..."
        });

        xhr = getXhr();

        var data = new FormData($form_etape_1[0]);

        xhr.open("POST", base_url + "register.php", true);
        xhr.setRequestHeader("X-Requested-With", "xmlhttprequest");
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                console.log(xhr.response);
                var response = JSON.parse(xhr.response);
                console.log(response);

                if (response.error) {
                    if (response.is_registered) {
                        swal({
                            type: "warning",
                            title: "Alerte",
                            text: response.msg,
                            closeOnConfirm: false,
                            confirmButtonClass: "btn-outline-primary",
                            confirmButtonText: "CONNEXION"
                        }, function () {
                            window.location = base_url + "login.php?matricule=" + response.data["Matricule"];
                        });

                    } else {
                        swal.close();
                        $alert.html("<div class=\"alert alert-danger alert-dismissible fade show \" role=\"alert\">\n"
                            + response.msg +
                            "                                <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">\n" +
                            "                                    <span aria-hidden=\"true\">&times;</span>\n" +
                            "                                </button>\n" +
                            "                            </div>")
                    }
                    etape_1_validated = false;
                } else {
                    etape_1_validated = true;
                    // console.log(response.data);
                    $("#input_name").val(response.data["Nom"]);
                    $("#input_matri").val(response.data["Matricule"]);
                    $("#input_mail").val(response.data["Mail"]);
                    $form_etape_3.append("<input type='hidden' name='id' value='" + response.data["idUtilisateur"] + "'>");
                    gotoEtape2();
                    swal.close();
                }

                // console.log(response);
            }
        };
        xhr.send(data);
    }

    function valide_etape_2() {
        gotoEtape3();
    }

    function valide_etape_3() {
        swal({
            html: true,
            text: "<div class=\"spinner-border text-primary\" role=\"status\">\n" +
                "  <span class=\"sr-only\">Loading...</span>\n" +
                "</div>",
            closeOnConfirm: false,
            showConfirmButton: false,
            showCancelButton: false,
            title: "Soumission du formulaire..."
        });

        xhr = getXhr();

        var data = new FormData($form_etape_3[0]);

        xhr.open("POST", base_url + "register.php", true);
        xhr.setRequestHeader("X-Requested-With", "xmlhttprequest");
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                console.log(xhr.response);
                console.log(JSON.parse(xhr.response));
                var response = JSON.parse(xhr.response);

                if (response.error) {
                    swal({
                        title: "Erreur",
                        type: "error",
                        text: response.msg,
                    });

                    etape_2_validated = false;
                } else {
                    etape_2_validated = true;
                    swal({
                            title: "Succès !",
                            html: true,
                            text: "<div style='text-align: left'>Votre compte a bien été créé avec ces informations :<br>" +
                                "Matricule INP : " + response.data["Matricule"] + "<br>" +
                                "Nom : " + response.data["Nom"] + "<br>" +
                                "Mail : " + response.data["Mail"] + "</div>",
                            type: "success",
                            closeOnConfirm: false,
                            confirmButtonClass: "btn-outline-primary",
                            confirmButtonText: "CONNECTEZ-VOUS"
                        },
                        function () {
                            window.location = base_url + "login.php?matricule=" + response.data["Matricule"];
                        }
                    );
                }

                // console.log(response);
            }
        };
        xhr.send(data);
    }

    function testString(str) {
        var re1 = /[0-9]+/;
        var re2 = /[A-Z]+/;
        var re3 = /[a-z]+/;
        return  re1.test(str) && re2.test(str) && re3.test(str) && str.length >= 8;
    }

    function gotoEtape1() {
        $elt2.removeClass('active');
        $elt3.removeClass('active');
        $elt1.addClass('active');

        if (!$etape_1.hasClass("slide")) {
            if ($etape_2.hasClass("slide")) {
                $etape_2.slideUp(function (e) {
                    $etape_2.removeClass("slide");
                    $etape_1.addClass("slide");
                    $etape_1.slideDown();
                });
            } else if ($etape_3.hasClass("slide")) {
                $etape_3.slideUp(function (e) {
                    $etape_3.removeClass("slide");
                    $etape_1.addClass("slide");
                    $etape_1.slideDown();
                });
            }
        }
    }

    function gotoEtape2() {
        $elt1.removeClass('active');
        $elt3.removeClass('active');
        $elt2.addClass('active');

        if (!$etape_2.hasClass("slide")) {
            cleanEtape3();
            if ($etape_1.hasClass("slide")) {
                $etape_1.slideUp(function (e) {
                    $etape_1.removeClass("slide");
                    $etape_2.addClass("slide");
                    $etape_2.slideDown();
                })
            } else if ($etape_3.hasClass("slide")) {
                $etape_3.slideUp(function (e) {
                    $etape_3.removeClass("slide");
                    $etape_2.addClass("slide");
                    $etape_2.slideDown();
                })
            }
        }
    }


    function gotoEtape3() {
        $elt1.removeClass('active');
        $elt2.removeClass('active');
        $elt3.addClass('active');

        if (!$etape_3.hasClass("slide")) {
            if ($etape_1.hasClass("slide")) {
                $etape_1.slideUp(function (e) {
                    $etape_1.removeClass("slide");
                    $etape_3.addClass("slide");
                    $etape_3.slideDown();
                });
            } else if ($etape_2.hasClass("slide")) {
                $etape_2.slideUp(function (e) {
                    $etape_2.removeClass("slide");
                    $etape_3.addClass("slide");
                    $etape_3.slideDown();
                });
            }
        }
    }

    function cleanEtape3() {

        // Remplir les écoles
        $ecole.html("<option></option>");
        $filiere.html("<option></option>");
        $classe.html("<option></option>");

        for (let school in INP) {
            $ecole.append("<option value='" + school + "'>" + school + "</option>")
        }
    }


    // Evènements
    $elt1.on('click', function (e) {
        e.preventDefault();
        e.stopPropagation();
        gotoEtape1(e);
    });
    $elt2.on('click', function (e) {
        e.preventDefault();
        e.stopPropagation();
        // 1 - VERIFIER QUE LE NOM ENTRE EST BIEN DANS LA BASE DE DONNEES
        if (etape_1_validated) {
            gotoEtape2(e);
        } else {
            swal({
                title: "Erreur",
                type: "error",
                icon: "error",
                text: "Veuillez d'abord valider l'étape 1"
            });
        }
    });
    $elt3.on('click', function (e) {
        e.preventDefault();
        e.stopPropagation();
        // 1 - VERIFIER QUE LE NOM ENTRE EST BIEN DANS LA BASE DE DONNEES
        if (etape_1_validated) {
            gotoEtape3(e);
        } else {
            swal({
                title: "Erreur",
                type: "error",
                icon: "error",
                text: "Veuillez d'abord valider l'étape 1"
            });
        }
    });

    // Valider la première étape
    $form_etape_1.on('submit', function (e) {
        e.preventDefault();
        e.stopPropagation();
        valide_etape_1();
    });
    $form_etape_2.on('submit', function (e) {
        e.preventDefault();
        e.stopPropagation();
        valide_etape_2();
    });

    // Valider la seconde étape
    $form_etape_3.on('submit', function (e) {
        e.preventDefault();
        e.stopPropagation();

        if ($("#inputPassword").val() === $("#inputPasswordConfirm").val()) {
            if (testString($("#inputPassword").val())) {
                valide_etape_3();
            } else {
                swal(
                    {
                        type: "warning",
                        text: "Le mot de passe ne répond pas aux normes de sécurité : " +
                            "8 caractères minimum avec au moins 1 chiffre et 1 lettre majuscule et 1 lettre" +
                            " minuscule",
                        title: "Alerte"
                    }
                )
            }
        } else {
            swal(
                {
                    type: "warning",
                    text: "Les mots de passe ne correspondent pas !",
                    title: "Alerte"
                }
            )
        }
    });

    // Mise à jour les filières
    $ecole.change(function () {
        $filiere.html("<option></option>");
        $classe.html("<option></option>");

        if ($ecole.val() !== "") {
            var ls_fil = INP[$ecole.val()];

            for (let fil in ls_fil) {
                $filiere.append("<option value='" + fil + "'>" + fil + "</option>");
            }
        }
    });

    // Mise à jour des classes
    $filiere.change(function () {
        $classe.html("<option></option>");

        if ($filiere.val() !== "") {
            // console.log(INP[$ecole.val()]);
            // console.log($filiere.val());
            var ls_cls = INP[$ecole.val()][$filiere.val()];

            ls_cls.forEach(function (cls) {
                $classe.append("<option value='" + cls + "'>" + cls + "</option>");
            });
        }
    });
});