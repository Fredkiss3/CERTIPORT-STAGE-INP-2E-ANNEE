<?php
$title = "Inscription";
?>

<div class="bg-inscription">

    <div class="overlay"></div>
</div>

<div class="mb-5">
    <!-- Breadcrumb -->
    <div class="row m-0">
        <div class="col-12">
            <div class="breadcrumb flat">
                <a href="#etape_1" id="S_etape1" class="active toogle" aria-expanded="false" aria-controls="etape_1">ETAPE
                    1</a>
                <a href="#etape_2" id="S_etape2" class="toogle" aria-expanded="false" aria-controls="etape_2">ETAPE
                    2</a>
                <a href="#etape_3" id="S_etape3" class="toogle" aria-expanded="false" aria-controls="etape_3">ETAPE
                    3</a>
            </div>
        </div>
    </div>

    <!-- ETAPE 1 -->
    <div class="row m-0">
        <div id="etape_1" class="slidable m-auto slide col-10 col-md-6 col-lg-5">
            <div class="card justify-content-center">
                <div class="card-body m-lg-5 m-sm-5 m-2 mt-5">
                    <div class="row">
                        <div class="col">
                            <h3> Enregistrement </h3>
                            <div id="alert"></div>
                            <hr>
                            <form method="post" id="etape_1_form">
                                <?php echo csrf() ?>
                                <?php echo action_input("register_etape_1") ?>
                                <div style="padding-bottom: 2rem;" class="form-group ">
                                    <label for="matri">Matricule INP-HB <span style="color: red">*</span></label>
                                    <input type="text" class="form-control" id="matri" name="matri"
                                           value="<?php if (!empty($_GET["matricule"])) echo $_GET["matricule"] ?>"
                                           placeholder="<?php echo date("y") ?>INP00XXX" required>
                                </div>
                                <div style="padding-bottom: 2rem;" class="form-group ">
                                    <label for="mail">Mail institutionnel <span style="color: red">*</span></label>

                                    <input type="email" class="form-control" id="mail" name="mail"
                                           placeholder="prenom.nom@inphb.ci" required>
                                </div>
                                <div class="row justify-content-center">
                                    <button type="submit" class="btn btn-outline-primary">VALIDER</button>
                                </div>
                            </form>
                            <div style="padding-top: 1rem" class="row justify-content-center">
                                <ul class="justify-content-center">

                                    <li style="list-style: none">Déjà enregistré ? <a href="<?php echo url('connectivity/login.php') ?>">
                                            Connectez-vous.</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ETAPE 2 -->
    <div class="row m-0">
        <div class="slidable collapse m-auto col-10 col-md-6 col-lg-5" id="etape_2">
            <div class="card justify-content-center">
                <div class="card-body m-lg-5 m-sm-5 m-2 mt-5">
                    <div class="row">
                        <div class="col">
                            <h3>Civilités </h3>
                            <hr>
                            <form method="get" id="etape_2_form">
                                <div style="padding-bottom: 2rem;" class="form-group ">
                                    <label for="input_matri">Matricule</label>
                                    <input type="text" class="form-control" id="input_matri" value="17INP00746" readonly
                                           disabled>
                                </div>
                                <div style="padding-bottom: 2rem;" class="form-group ">
                                    <label for="input_mail">Mail institutionnel</label>
                                    <input type="email" class="form-control" id="input_mail"
                                           value="nahagama.soro@inphb.ci" readonly disabled>
                                </div>
                                <div style="padding-bottom: 2rem;" class="form-group ">
                                    <label for="input_name">Nom & Prénoms</label>
                                    <input type="text" class="form-control" id="input_name" value="SORO Nahagama Lazeni"
                                           readonly disabled>
                                </div>
                                <button type="submit" class="btn btn-outline-primary">
                                    SUIVANT
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ETAPE 3 -->
    <div class="row m-0">
        <div class="slidable collapse m-auto col-10 col-md-6 col-lg-4" id="etape_3">
            <div class="card justify-content-center">
                <div class="card-body m-lg-5 m-sm-5 m-2 mt-5">
                    <div class="row">
                        <div class="col">
                            <h3>Informations Scolaires</h3>
                            <hr>
                            <form method="post" id="etape_3_form">
                                <input type="hidden" name="_token" value='<?php echo get_token() ?>'>
                                <?php echo action_input("register_etape_2") ?>
                                <div style="padding-bottom: 2rem;" class="form-group ">
                                    <label for="ecole">Ecole<span style="color: red">*</span></label>
                                    <select class="form-control" id="ecole" name="ecole" required>
                                        <option></option>
                                        <option value="ESI">ESI</option>
                                    </select>
                                </div>
                                <div style="padding-bottom: 2rem;" class="form-group ">
                                    <label for="filiere">Filiere<span style="color: red">*</span></label>
                                    <select class="form-control" name="filiere" id="filiere" required>
                                        <option></option>
                                        <option value="STIC">STIC</option>
                                    </select>
                                </div>
                                <div style="padding-bottom: 2rem;" class="form-group ">
                                    <label for="classe">Classe<span style="color: red">*</span></label>
                                    <select class="form-control" id="classe" name="classe" required>
                                        <option></option>
                                        <option value="INFO-2">INFO-2</option>
                                    </select>
                                </div>
                                <div style="padding-bottom: 2rem;" class="form-group ">
                                    <label for="inputTel">N° de téléphone<span style="color: red">*</span></label>
                                    <input type="text" class="form-control" name="phone" id="inputTel" required>
                                </div>
                                <div style="padding-bottom: 2rem;" class="form-group ">
                                    <label for="inputPassword">Créer un mot de passe<span
                                                style="color: red">*</span></label>
                                    <input type="password" class="form-control" name="password" id="inputPassword"
                                           required>
                                    <small>8 caractères minimum. (au moins 1 lettre Maj + 1 lettre Min + 1 chiffre) </small>
                                </div>
                                <div style="padding-bottom: 2rem;" class="form-group ">
                                    <label for="inputPasswordConfirm">Confirmation du mot de passe<span
                                                style="color: red">*</span></label>
                                    <input type="password" class="form-control" name="password_confirm"
                                           id="inputPasswordConfirm" placeholder="" required>
                                    <small>8 caractères minimum. (au moins 1 lettre Maj + 1 lettre Min + 1 chiffre) </small>
                                </div>

                                <div class="form-check row p-1">
                                    <div class="g-recaptcha"
                                         data-sitekey="6LfVn7EUAAAAADWWPq1LHql31v_UtsVn9eAW9Xub"></div>
                                </div>
                                <div class="row justify-content-center">
                                    <button type="submit" class="btn btn-outline-primary col-5">VALIDER</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
