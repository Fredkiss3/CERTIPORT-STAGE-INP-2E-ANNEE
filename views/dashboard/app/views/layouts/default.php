<!DOCTYPE >
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Tableau de bord">
    <meta name="author" content="TS-INFO-2">
    <title><?php echo(!empty($title) ? $title : "Accueil") ?> | Dashboard </title>

    <!-- Bootstrap  -->
    <link href="<?php echo static_("dashboard/lib/bootstrap/css/bootstrap.min.css") ?>" rel="stylesheet">
    <!--css externe-->
    <link href="<?php echo static_("dashboard/lib/font-awesome/css/font-awesome.css") ?>" rel="stylesheet"/>

    <!-- Styles individuel -->
    <link href="<?php echo static_("dashboard/css/style.css") ?>" rel="stylesheet">
    <link href="<?php echo static_("dashboard/css/style-responsive.css") ?>" rel="stylesheet">
    <link href="<?php echo static_("dashboard/css/datatables.min.css") ?>" rel="stylesheet">
    <link href="<?php echo static_("dashboard/css/selectize.bootstrap3.css") ?>" rel="stylesheet">
    <style type="text/css">
        @media (max-width: 600px) {
            #ellipsis {
                display: none;
            }
        }

        @media (max-width: 380px) {
           .logo {
                font-size: 5px;
                max-width: 160px;
                white-space: nowrap;
                text-overflow: ellipsis;
                overflow: hidden;
            }
        }

        @media screen and (min-width: 381px)  {
            .logo {
                font-size: 10px;
                max-width: 600px;
                white-space: nowrap;
                text-overflow: ellipsis;
                overflow: hidden;
            }
        }


    </style>

    <?php
    if (session()->get("error") or session()->get("msg")) :
        ?>
        <link rel="stylesheet" href="<?php echo static_("connectivity/css/sweetalert.css") ?>">
    <?php
    endif;
    ?>


</head>

<body>
<section id="container">
    <!-- **********************************************************************************************************************************************************
        BARRE DU HAUT
        *********************************************************************************************************************************************************** -->
    <!--Entete debut-->
    <header class="header black-bg">
        <div class="sidebar-toggle-box">
            <div class="fa fa-bars tooltips" data-placement="right" data-original-title="Basculer la Navigation"></div>
        </div>

        <a href="?p=<?php echo(auth()->is_surveillant() ? "surveillant.reservation.index" : "student.result.index") ?>"
           class="logo"><?php echo auth()->user()->Nom ?> <span
                    id="ellipsis"><?php echo " (" . session()->get("title") . ")" ?></span> 
                </a>

        <div class="top-menu">
            <ul class="nav pull-right top-menu">
                <li><a class="logout" style="" href="<?php echo url("connectivity/logout.php") ?>">Se déconnecter</a>
                </li>
            </ul>
        </div>
    </header>
    <!--Entete fin-->

    <!-- barre coté début-->
    <aside>
        <div id="sidebar" class="nav-collapse ">
            <!-- menu début-->
            <ul class="sidebar-menu" id="nav-accordion">
                <?php if (auth()->is_admin()) : ?>
                    <li class="mt">
                        <a class="<?php echo(!empty($dash) ? "active" : "") ?>"
                           href="?p=surveillant.reservation.index">
                            <i class="fa fa-dashboard"></i>
                            <span>Tableau de bord</span>
                        </a>
                    </li>

                    <li class="sub-menu">
                        <a class="<?php echo(!empty($accounts) ? "active" : "") ?>"
                           href="<?php echo "?p=admin.accounts.index" ?>">
                            <i class="fa fab fa-user"></i>
                            <span>COMPTES</span>
                        </a>
                    </li>

                    <li>
                        <a class="<?php echo(!empty($resultats) ? "active" : "") ?>"
                           href="?p=student.result.index">
                            <i class="fa fa-laptop"></i>
                            <span> Mes Réservations </span>
                        </a>
                    </li>

                    <li class="">
                        <a class="<?php echo(!empty($profile_location) ? "active" : "") ?>"
                           href="?p=student.profile.show">
                            <i class="fa fa-user-circle"></i>
                            <span> Mon profil </span>
                        </a>
                    </li>

                    <hr style="margin: 0 10px;"/>

                    <li class="mt">
                        <a class="<?php echo(!empty($user_location) ? "active" : "") ?>"
                           href="?p=admin.users.index">
                            <i class="fa fa-star"></i>
                            <span> Utilisateurs </span>
                        </a>
                    </li>

                    <li class="">
                        <a class="<?php echo(!empty($salles_location) ? "active" : "") ?>"
                           href="?p=admin.salles.index">
                            <i class="fa fa-windows"></i>
                            <span> Salles </span>
                        </a>
                    </li>

                    <li class="">
                        <a class="<?php echo(!empty($machines_location) ? "active" : "") ?>"
                           href="?p=admin.machines.index">
                            <i class="fa fa-compress"></i>
                            <span> Postes </span>
                        </a>
                    </li>


                    <li class="">
                        <a class="<?php echo(!empty($cert_location) ? "active" : "") ?>"
                           href="?p=admin.certifications.index">
                            <i class="fa fa-file-excel-o"></i>
                            <span> Certifications </span>
                        </a>
                    </li>

                <?php elseif (auth()->is_surveillant()) : ?>
                    <li class="mt">
                        <a class="<?php echo(!empty($dash) ? "active" : "") ?>"
                           href="?p=surveillant.reservation.index">
                            <i class="fa fa-dashboard"></i>
                            <span>Tableau de bord</span>
                        </a>
                    </li>

                    <li>
                        <a class="<?php echo(!empty($resultats) ? "active" : "") ?>"
                           href="?p=student.result.index">
                            <i class="fa fa-laptop"></i>
                            <span> Mes Réservations </span>
                        </a>
                    </li>

                    <li class="mt">
                        <a class="<?php echo(!empty($profile_location) ? "active" : "") ?>"
                           href="?p=student.profile.show">
                            <i class="fa fa-user-circle"></i>
                            <span> Mon profil </span>
                        </a>
                    </li>

                <?php elseif (auth()->is_student()) : ?>
                    <li class="mt">
                        <a class="<?php echo(!empty($resultats) ? "active" : "") ?>"
                           href="?p=student.result.index">
                            <i class="fa fa-laptop"></i>
                            <span> Mes Réservations </span>
                        </a>
                    </li>

                    <li class="mt">
                        <a class="<?php echo(!empty($profile_location) ? "active" : "") ?>"
                           href="?p=student.profile.show">
                            <i class="fa fa-user-circle"></i>
                            <span> Mon profil </span>
                        </a>
                    </li>
                <?php endif; ?>

            </ul>
            <!--  menu fin-->
        </div>
    </aside>
    <!--barre coté fin-->


    <!-- **********************************************************************************************************************************************************
        MENU PRINCIPAL COTE
        *********************************************************************************************************************************************************** -->
    <?php echo(!empty($content) ? $content : "") ?>

</section>
<script src="<?php echo static_("dashboard/lib/jquery/jquery.min.js") ?>"></script>
<script class="include" type="text/javascript"
        src="<?php echo static_("dashboard/lib/jquery.dcjqaccordion.2.7.js") ?>"></script>
<script src="<?php echo static_("dashboard/lib/jquery.nicescroll.js") ?>" type="text/javascript"></script>
<script src="<?php echo static_("dashboard/lib/common-scripts.js") ?>"></script>
<script src="<?php echo static_("dashboard/lib/bootstrap/js/bootstrap.min.js") ?>"></script>
<script src="<?php echo static_("dashboard/lib/dataTable/js/datatables.min.js") ?>"></script>
<script src="<?php echo static_("dashboard/js/selectize.min.js") ?>"></script>
<script src="<?php echo static_("dashboard/js/main.js") ?>"></script>
<?php
if (session()->get("error")) :
    ?>

    <script src="<?php echo static_("connectivity/js/sweetalert.min.js") ?>"></script>

    <script type="text/javascript">
        swal({
            type: "error",
            title: "Erreur",
            text: "<?php echo session()->flash("error") ?>",
            confirmButtonClass: "btn-primary",
        });
    </script>
<?php
endif;

if (session()->get("msg")) :
    ?>

    <script src="<?php echo static_("connectivity/js/sweetalert.min.js") ?>"></script>

    <script type="text/javascript">
        swal({
            html: true,
            type: "info",
            title: "Information",
            text: "<?php echo session()->flash("msg") ?>",
            confirmButtonClass: "btn-primary",
        });
    </script>
<?php
endif;
?>

<script type="text/javascript">
    $("table").DataTable();
    $('.dataTables_length').addClass('bs-select');
    var api_url = "<?php echo url("api/") ?>";

    function goto(to) {
        window.location.href = to;
    }

    (function () {

        //
        var $ecole = $("#Ecole");
        var $filiere = $("#Filiere");
        var $classe = $("#Classe");
        var INP = {

            AUCUN: {
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

        // Remplir les écoles
        $ecole.html("<option></option>");
        $filiere.html("<option></option>");
        $classe.html("<option></option>");

        var selectedSchool = <?php echo json_encode(!empty($user) ? $user->Ecole : ""); ?>;
        var selectedFil = <?php echo json_encode(!empty($user) ? $user->Filiere : ""); ?>;
        var selectedClasse = <?php echo json_encode(!empty($user) ? $user->Classe : ""); ?>;

        for (let school in INP) {
            $ecole.append("<option value='" + school + "'>" + school + "</option>")
        }

        if ($ecole.length > 0 && $filiere.length > 0) {
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
        }

        // School, Filiere, Classe
        $ecole.val(selectedSchool).trigger("change");
        $filiere.val(selectedFil).trigger("change");
        $classe.val(selectedClasse).trigger("change");

    })()

</script>
<!--common script for all pages-->
</body>

</html>
