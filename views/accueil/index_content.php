<?php
$certified = get_last_certfied_students();
$str ="";

foreach ($certified as $c) {
    $str .= $c["Nom"]. '(Certifié en '.$c["NomCertification"].")   &nbsp;&nbsp;&nbsp;";
}
?>

<style type="text/css">
    .name {
        display: inline-block;
        max-width: 200px;
        white-space: nowrap;
        text-overflow: ellipsis;
        overflow: hidden;
    }
</style>

<div class="container-fluid" style="z-index: 20">
    <!--Navbar -->
    <div class="overlay"></div>
    <nav class="navbar navbar-dark navbar-expand-lg default-color ">
        <a class="navbar-brand align-baseline " href="<?php echo url('accueil/') ?>">RESERVE CERTIPORT</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
            </ul>

            <div class="row">
                <?php if (!empty($_SESSION["uid"])) : ?>
                    <div class="dropdown">
                        <a class="nav-link dropdown-toggle text-light name" href="#" id="navbarDropdownMenuLink"
                           role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?php echo $_SESSION["name"] ?>
                        </a>

                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="<?php echo url("/") ?>"><i class="fa fa-user"></i>
                                Profil</a>
                            <a class="dropdown-item" href="<?php echo url('connectivity/logout.php') ?>"><i
                                        class="fa fa-sign-out"></i> Se
                                déconnecter</a>
                        </div>
                    </div>

                <?php else: ?>
                    <div class="dropdown">
                        <a class="nav-link dropdown-toggle text-light name" href="#" id="navbarDropdownMenuLink"
                           role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Non connecté
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="<?php echo url('connectivity/login.php') ?>"><i
                                        class="fa fa-sign-in"></i> Se
                                connecter</a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

    </nav>
    <!--/.Navbar -->
</div>

<header class="vue">
    <!--pour rendre l'image noire -->
    <div class="container d-table" style="z-index: 20">
        <div class="d-table-cell text-center align-middle">
            <h1>Bienvenue sur le site de réservation de Certiport</h1>
            <p>Faites vos reservations en toute simplicité</p>
            <a href="<?php echo url('reservations/') ?>" class="button" style="text-decoration: none">Reserver</a>
        </div>
    </div>
</header>


<div class="mb-4" id="certifications" >
    <div class="owl-carousel owl-theme" >
        <div id="img-access" style="height: 60px"></div>
        <div id="img-excel" style="height: 60px"></div>
        <div id="img-word" style="height: 60px"></div>
        <div id="img-powerpoint" style="height: 60px"></div>
        <div id="img-outlook" style="height: 60px"></div>
        <div id="img-w-s" style="height: 60px"></div>
        <div id="img-python" style="height: 60px"></div>
        <div id="img-3" style="height: 60px"></div>
    </div>
</div>

<?php if ($str !== ""): ?>
<footer class="mt-auto" style="overflow: hidden">
    <marquee class="d-table" style="background-color: rgba(0,0,0,0.5); height: 40px;">
        Félicitations aux étudiants : <?php echo $str ?>
    </marquee>
</footer>
<?php endif; ?>
