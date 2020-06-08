<?php
$title = "Page de réservation";
?>


<style type="text/css">
    h1 {
        color: #F55F25;
        text-shadow: 1px 1px 10px black;
        margin-top: 10px;
        margin-bottom: 25px;
    }

    .name {
        display: inline-block;
        max-width: 200px;
        white-space: nowrap;
        text-overflow: ellipsis;
        overflow: hidden;
    }


</style>

<div class="overlay" style="z-index: -1"></div>

<!--Navbar -->
<nav class="navbar w-100 navbar-dark default-color">
    <div class="row w-100">
        <div class="col-sm-10">
            <a class="navbar-brand align-baseline " href="<?php echo url("accueil/") ?>">RESERVE CERTIPORT</a>

        </div>
        <ul class="align-baseline col-sm-2" style="justify-content: right">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-light name" href="#" id="navbarDropdownMenuLink"
                   role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php echo $_SESSION["name"] ?>
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="<?php echo url("/") ?>"><i class="fa fa-user"></i>
                        Profil</a>
                    <a class="dropdown-item" href="<?php echo url("connectivity/logout.php") ?>"><i
                                class="fa fa-sign-out"></i> Se
                        déconnecter</a>
                </div>
            </li>
        </ul>
    </div>
</nav>
<!--/.Navbar -->

<div class="container">
    <?php
    if (!salles_fermees() and can_reserve() and !max_reserve_atteint()) :
        ?>
        <div class="mt-5">
            <div class="mt-5">
                <h1 class="text-center text-uppercase">RESERVER
                    UNE MACHINE
                </h1>
                <div id="sites">
                    <!-- /row -->
                    <div class="row" style="height: 400px">
                        <div class="col-md-3 mb-3">
                            <div class="pn rounded-top inp-sud">
                                <button class="btn btn-small" data-toggle="modal" data-open="#modal" data="1"
                                        style="background-color:#F55F25; color: white">INP SUD
                                </button>
                            </div>
                            <div class="rounded-bottom site-bas p-3">
                                <b style="color:green;" class="oqp1">Nombre de postes libres : 0 <i
                                            class="fa  fa-laptop"></i>
                                </b><br>
                                <b style="color:red;" class="free1">Nombre de postes occupés : 0 <i
                                            class="fa  fa-laptop"></i></b>
                            </div>

                        </div>
                        <!-- /col-md-4 -->

                        <!--  PROFILE 02 PANEL -->
                        <div class="col-md-3 mb-3">
                            <div class="inp-centre pn rounded-top">
                                <button class="btn btn-small" data-toggle="modal" data-open="#modal" data="2"
                                        style="background-color:#F55F25; color: white">INP CENTRE
                                </button>

                            </div>
                            <div class="rounded-bottom site-bas p-3">
                                <b style="color:green;" class="oqp2">Nombre de postes libres : 0 <i
                                            class="fa  fa-laptop"></i>
                                </b><br>
                                <b style="color:red;" class="free2">Nombre de postes occupés : 0 <i
                                            class="fa  fa-laptop"></i></b>
                            </div>
                        </div>

                        <!--/ col-md-4 -->
                        <div class="col-md-3  mb-3">
                            <div class="inp-nord pn rounded-top">
                                <button class="btn btn-small" data-toggle="modal" data-open="#modal" data="3"
                                        style="background-color:#F55F25; color: white">INP NORD
                                </button>
                            </div>

                            <div class="rounded-bottom site-bas p-3">
                                <b style="color:green;" class="oqp3">Nombre de postes libres : 0 <i
                                            class="fa  fa-laptop"></i>
                                </b><br>
                                <b style="color:red;" class="free3">Nombre de postes occupés : 0 <i
                                            class="fa  fa-laptop"></i></b>
                            </div>
                        </div>

                        <!-- /col-md-4 -->
                        <!--/ col-md-4 -->
                        <div class="col-md-3 rounded-top mb-3">
                            <div class="inp-abidjan pn">
                                <button class="btn btn-small" data-toggle="modal" data-open="#modal" data="4"
                                        data-update=""
                                        style="background-color:#F55F25; color: white">INP ABIDJAN
                                </button>
                            </div>
                            <div class="rounded-bottom site-bas p-3">
                                <b style="color:green;" class="oqp4">Nombre de postes libres : 0 <i
                                            class="fa  fa-laptop"></i>
                                </b><br>
                                <b style="color:red;" class="free4">Nombre de postes occupés : 0 <i
                                            class="fa  fa-laptop"></i></b>
                            </div>
                        </div>
                        <!-- /col-md-4 -->
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                         aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-light">
                                    <h2 class="modal-title text-dark" id="exampleModalLabel">SITE SUD</h2>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">

                                    Réservation pour <span id="name"
                                                           style="color: black"><?php echo $_SESSION["name"] ?></span> !
                                    <form method="post" id="form" class="top-margin container mb-5">
                                        <?php echo csrf() ?>
                                        <?php echo action_input("get_machines") ?>

                                        <div class="row">
                                            <div class="col-md-3">
                                                <label for="salle" style="color:black; font-size: 20px"> SALLE </label>
                                                <select name="salle" class="form-control form-control-lg"
                                                        style="height: 40px" id="salle">
                                                </select>
                                            </div>

                                            <div class="col-md-4">
                                                <label for="day" style="color:black; font-size: 20px"> DATE </label>
                                                <select name="day" class="form-control form-control-lg"
                                                        style="height: 40px" id="day">
                                                    <option value="0">Aujourd'hui</option>
                                                    <option value="1">Demain</option>
                                                </select>

                                            </div>
                                            <div class="col-md-2" style="margin-top: 35px;">
                                                <input type="submit" class="btn btn-warning btn-lg"
                                                       style="background-color: #F55F25"
                                                       value="VALIDER">
                                            </div>
                                        </div>
                                    </form>

                                    <div class="row mb-1">
                                        <div class="col-12">
                                            <div>
                                                <table style="border-collapse: collapse; box-shadow: 1px 1px 12px #555; background-color: white"
                                                       class="table table-striped table-advance table-responsive-md table-responsive-sm">
                                                    <hr>
                                                    <thead style="width: 100%">
                                                    <tr>
                                                        <th><i class="fa fa-laptop"></i> Machines</th>
                                                        <th class=""><i class="fa fa-clock-o"></i> Plages disponibles
                                                        </th>
                                                        <th class="text-right pr-4"><i class=" fa fa-edit"></i> Actions
                                                        </th>

                                                    </tr>
                                                    </thead>
                                                    <tbody id="tbody" style="width: 100%">
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!-- /content-panel -->
                                        </div>
                                        <!-- /col-md-12 -->
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <?php
    elseif (salles_fermees()):
        ?>
        <div class="h-100 d-table">
            <h1 class="text-center d-table-cell align-middle">DESOLE <span id="name"
                                                                           style="color: white"><?php echo $_SESSION["name"] ?> !</span>

                VOUS NE POUVEZ PAS RESERVER DE MACHINE A CETTE HEURE CAR LES
                SALLES DE CERTIFICATION SONT FERMEES.</h1>
        </div>
    <?php
    elseif (max_reserve_atteint()):
        ?>
        <div class="h-100 d-table">
            <h1 class="text-center text-uppercase d-table-cell align-middle">
                DESOLE <span id="name" style="color: white"> <?php echo $_SESSION["name"] ?>!</span>VOTRE MAXIMUM DE
                RESERVATIONS A ETE ATTEINT POUR AUJOURD'HUI,
                VEUILLEZ REVENIR DEMAIN POUR RESERVER UNE NOUVELLE MACHINE.
            </h1>
        </div>

    <?php
    elseif (!can_reserve()):
        ?>
        <div class="h-100 d-table">
            <h1 class="text-center text-uppercase align-middle d-table-cell">DESOLE <span id="name"
                                                                                          style="color: white"><?php echo $_SESSION["name"] ?>!</span>
                Vous ne pouvez pas encore réserver, attendez
                <span
                        id="counter" style="color: white"><?php echo lastReserveTimeRemaining() ?></span> avant de
                pouvoir refaire une
                nouvelle




            </h1>
        </div>

    <?php
    endif;
    ?>

</div>

<script type="text/javascript">
    var salles = <?php echo json_encode(get_all_Salles()) ?>;
</script>
