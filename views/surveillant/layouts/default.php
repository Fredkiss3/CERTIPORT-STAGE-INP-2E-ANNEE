<!DOCTYPE >
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Tableau de bord">
    <meta name="author" content="TS-INFO-2">
    <title><?php echo(!empty($title) ? $title : "Tableau de bord") ?> | Reserve Certiport</title>

    <!-- Bootstrap  -->
    <link href="<?php echo static_("dashboard/lib/bootstrap/css/bootstrap.min.css") ?>" rel="stylesheet">
    <!--css externe-->
    <link href="<?php echo static_("dashboard/lib/font-awesome/css/font-awesome.css") ?>" rel="stylesheet"/>

    <!-- Styles individuel -->
    <link href="<?php echo static_("dashboard/css/style.css") ?>" rel="stylesheet">
    <link href="<?php echo static_("dashboard/css/style-responsive.css") ?>" rel="stylesheet">
    <link href="<?php echo static_("dashboard/css/datatables.min.css") ?>" rel="stylesheet">
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
    if (!empty($_SESSION["error"])) :
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

        <a href="<?php echo url("/") ?>" class="logo"><?php $u = get_user_if_alive($_SESSION["uid"]);
            echo $u["Nom"]?> <span
                    id="ellipsis"><?php echo " (" . $_SESSION["title"] . ")" ?></span> </a>

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

                <li class="mt">
                    <a class="<?php echo(!empty($dash) ? $dash : "") ?>"
                       href="<?php echo url("surveillant/dashboard.php") ?>">
                        <i class="fa fa-dashboard"></i>
                        <span>Tableau de bord</span>
                    </a>
                </li>

                <li>
                    <a class="<?php echo(!empty($resultats) ? $resultats : "") ?>"
                       href="<?php echo url("surveillant/resultats.php") ?>">
                        <i class="fa fa-laptop"></i>
                        <span> Mes Réservations </span>
                    </a>
                </li>

                <li class="">
                    <a class="<?php echo(!empty($profile_location) ? "active" : "") ?>"
                       href="<?php echo url("dashboard/public/?p=student.profile.show") ?>">
                        <i class="fa fa-user-circle"></i>
                        <span> Mon profil </span>
                    </a>
                </li>

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
<script src="<?php echo static_("dashboard/js/main.js") ?>"></script>
<?php
if (!empty($_SESSION["error"])) :
    ?>

    <script src="<?php echo static_("connectivity/js/sweetalert.min.js") ?>"></script>

    <script type="text/javascript">
        swal({
            type: "error",
            title: "Erreur",
            text: "<?php echo $_SESSION["error"] ?>",
            confirmButtonClass: "btn-primary",
        });
    </script>
    <?php
    unset($_SESSION["error"]);
endif;
?>

<script type="text/javascript">
    $("table").DataTable();
    $('.dataTables_length').addClass('bs-select');

    function goto(to) {
        window.location.href = to;
    }

</script>
<!--common script for all pages-->
</body>

</html>
