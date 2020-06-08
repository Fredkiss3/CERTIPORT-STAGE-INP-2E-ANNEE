<section id="main-content">
    <section class="wrapper">
        <h1>Informations personnelles</h1>
        <form method="post">
            <div style="margin-top: 50px;" class="row mt">
                <div class="col-md-9">
                    <hr style="margin: 0 15px;">
                    <h2 style="padding: 0 15px;">Informations générales</h2>
                    <?php
                    /**
                     * @var $form \Core\HTML\BootstrapForm
                     */
                    echo $form->errors();

                    ?>
                    <div class="form-row">
                        <div class="col-md-6">
                            <?php
                            if (auth()->is_admin()) :
                                echo $form->input("Matricule", "Matricule", array(
                                        "maxlength" => 10
                                ));
                            else :
                                echo $form->input("Matricule", "Matricule", array(
                                    "disabled" => "disabled",
                                    "readonly" => "readonly",
                                ));
                            endif;
                            ?>
                        </div>
                        <div class="col-md-6">
                            <?php
                            echo $form->input("Nom", "Nom & Prénoms");
                            ?>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-6">
                            <?php
                            if (auth()->is_admin()) :
                                echo $form->input("Mail", "Email Institutionnel", array(
                                    "type" => "email",
                                ));
                            else :
                                echo $form->input("Mail", "Email Institutionnel", array(
                                    "type" => "email",
                                    "disabled" => "disabled",
                                    "readonly" => "readonly",
                                ));
                            endif;
                            ?>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="contact_">Contact</label>
                                <input type="text" class="form-control" id="contact_"
                                       name="Contact"
                                       value="<?php echo
                                       empty($user->Contact) ? (empty($_POST["Contact"]) ? (
                                       ""
                                       ) : $_POST["Contact"])
                                           : $user->Contact
                                       ?>"
                                >
                            </div>
                        </div>
                    </div>

                    <?php if ($student_related): ?>
                        <div class="form-row">
                            <div class="col-md-4">
                                <?php
                                echo $form->select("Ecole", "Ecole", array());
                                ?>
                            </div>
                            <div class="col-md-4">
                                <?php
                                echo $form->select("Filiere", "Filière", array());
                                ?>
                            </div>
                            <div class="col-md-4">
                                <?php
                                echo $form->select("Classe", "Classe", array());
                                ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if ($surv_related): ?>
                        <div class="form-row">
                            <div class="col-md-6">
                                <?php
                                echo $form->input("NomSite", "Site Affecté", array(
                                        "disabled" => "disabled",
                                        "readonly" => "readonly",
                                ));
                                ?>
                            </div>
                            <div class="col-md-6">
                                <?php
                                echo $form->input("NumSalle", "Salle affectée", array(
                                    "disabled" => "disabled",
                                    "readonly" => "readonly",
                                ));
                                ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div style="padding-left: 15px;padding-right: 15px;">
                        <?php
                        echo $form->submit("Changer");
                        ?>
                    </div>
                </div>
            </div>
        </form>

        <div class="row">
            <div class="col-md-9">
                <hr style="margin: 0 15px;margin-top: 25px;">
                <h2 style="padding: 0 15px;">Mot de passe</h2>
                <div style="padding: 0 15px;">
                    <a href="?p=student.profile.change_password" class="btn btn-warning">Changer le mot de passe</a>
                </div>
            </div>
        </div>


    </section>
</section>

