<section id="main-content">
    <section class="wrapper">
        <h1>Changer le mot de passe</h1>
        <form method="post">
            <div style="margin-top: 50px;" class="row mt">
                <div style="margin: 0 15px">
                    <?php
                    /**
                     * @var $form \Core\HTML\BootstrapForm
                     */
                    echo $form->errors();
                    ?>
                </div>
                <div class="col-md-6">
                    <div class="form-row">
                        <div class="col-md-12">
                            <?php
                                echo $form->input("old_password", "Mot de Passe actuel", array(
                                    "type" => "password"
                                ));
                            ?>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-12">
                            <?php
                                echo $form->input("new_password", "Nouveau Mot de Passe", array(
                                    "type" => "password"
                                ));
                            ?>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-12">
                            <?php
                                echo $form->input("confirm_password", "Confirmation du Mot de Passe", array(
                                    "type" => "password"
                                ));
                            ?>
                        </div>
                    </div>


                    <div style="padding-left: 15px;padding-right: 15px;">
                        <?php
                        echo $form->submit("Valider", "success");
                        ?>
                        <a href="?p=student.profile.show" class="btn btn-primary">Annuler</a>
                    </div>
                </div>
            </div>
        </form>
    </section>
</section>