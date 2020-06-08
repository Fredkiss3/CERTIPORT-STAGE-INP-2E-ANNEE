<?php
$title = "Connexion";
?>
    <style type="text/css">
        body {
            padding-top: 0;
        }
        body {
            height: 100%;
        }
    </style>
    <div class="bg-connexion img-fluid">
        <div class="overlay"></div>
    </div>
    <!-- <div class="main"> -->
    <div class="d-table w-100 h-100 pb-5 pt-5" style="position: absolute">
        <div class="row mb-5 d-table-cell m-auto w-100 align-middle">
            <div class="card col-md-6 col-9 col-lg-5 m-auto justify-content-center">
                <div class="card-body m-lg-5 m-sm-5 m-2">
                    <div class="row">
                        <div class="col">

                            <div class="card-title pb-3">
                                <h5 class="text-center"><b>CONNEXION
                                        <hr>
                                    </b></h5>
                            </div>
                            <?php
                            if (!empty($_SESSION["error"])) :
                                ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <?php
                                    echo $_SESSION["error"];
                                    unset($_SESSION["error"]); ?>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            <?php
                            endif;
                            ?>
                            <form method="POST" action="<?php echo url('connectivity/login.php') ?>">
                                <?php echo csrf() ?>
                                <?php echo action_input("login") ?>

                                <?php if (!empty($_GET["next"]))  : ?>
                                    <input type="hidden" name="next" value="<?php echo $_GET["next"] ?>">
                                <?php endif; ?>

                                <div style="padding-bottom: 2rem;" class="form-group">
                                    <label for="matri">Matricule INP-HB <span style="color: red">*</span></label>
                                    <input type="text" class="form-control" name="matri" id="matri"
                                           placeholder="<?php echo date("y") ?>INP00XXX"
                                           value="<?php if (!empty($_GET["matricule"])): echo $_GET["matricule"]; endif; ?>"
                                           required>
                                </div>
                                <div style="padding-bottom: 2rem;" class="form-group ">
                                    <label for="mail">Mot de passe <span style="color: red">*</span></label>
                                    <input type="password" class="form-control" name="password"
                                           placeholder="" required>
                                </div>
                                <div class="row justify-content-center">
                                    <button type="submit" class="btn btn-outline-primary col-9 col-md-7">SE CONNECTER
                                    </button>
                                </div>
                            </form>
                            <div style="padding-top: 1rem" class="row justify-content-center">
                                <ul class="justify-content-center">
                                    <?php
                                    if (empty($_GET["matricule"])) {
                                        ?>

                                        <li style="list-style: none">Pas encore enregistré ? <a href="<?php echo url('connectivity/register.php') ?>">
                                                veuillez vous enregistrer</a>
                                        </li>

                                        <?php
                                    }
                                    ?>
                                    <!--                            <li style="list-style: none"><a href="#">Mot de passe oublié</a>-->
                                    <!--                            </li>-->
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php

if (!empty($_SESSION["msg"])) :

    ?>

    <script src="<?php echo static_('connectivity/js/sweetalert.min.js') ?>">

    </script>
    <script type="text/javascript">
        swal({
            type: "warning",
            title: "Alerte",
            text: "<?php echo $_SESSION["msg"] ?>",
            closeOnConfirm: false,
            confirmButtonClass: "btn-outline-primary",
            confirmButtonText: "ENREGISTREZ-VOUS"
        }, function () {
            window.location = "<?php echo url('connectivity/register.php') ?>?matricule=" + "<?php echo $_SESSION["matricule"] ?>";
        });
    </script>
    <?php
    unset($_SESSION["msg"]);
    unset($_SESSION["matricule"]);
endif;
?>