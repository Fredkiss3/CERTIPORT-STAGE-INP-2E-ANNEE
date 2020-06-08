<?php
if (!defined("VIEW_PATH")) {
    header($_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
    exit();
}
?>

<div class="container">
    <!--Navbar -->
    <nav class="navbar navbar-dark default-color">
        <div class="row w-100">
            <div class="col-sm-10">
                <a class="navbar-brand align-baseline " href="<?= BASE_URL ?>/">RESERVE CERTIPORT</a>

            </div>
            <?php if (!empty($_SESSION["uid"])) : ?>
                <ul class="align-baseline col-sm-2" style="justify-content: right">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-light" href="#" id="navbarDropdownMenuLink"
                           role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-user-circle"></i>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="<?= BASE_URL ?>/home"><i class="fa fa-user"></i>
                                Profil</a>
                            <a class="dropdown-item" href="<?= BASE_URL ?>/logout"><i class="fa fa-sign-out"></i> Se
                                déconnecter</a>
                        </div>
                    </li>
                </ul>
            <?php endif; ?>
        </div>


    </nav>
    <!--/.Navbar -->
</div>

<header class="vue">
    <div class="overlay"></div> <!--pour rendre l'image noire -->
    <div class="container mb-5">
        <!--Navbar -->
        <!--/.Navbar -->

        <h1 class="mt-1">ERREUR 404</h1>
        <p>Il semblerait que vous soyez perdus.</p>
        <a href="<?= BASE_URL ?>/" class="button" style="text-decoration: none">Retour au site</a>
    </div>
</header>
