<section id="main-content">
    <section class="wrapper">
        <h1 class="mt-3">
            <?php echo !empty($user) ? "Editer un utilisateur" : "Ajouter un utilisateur" ?>
        </h1>


        <form method="post">
            <div style="margin-top: 50px;" class="row mt">
                <div class="col-md-9">
                    <?php
                    /**
                     * @var $form \Core\HTML\BootstrapForm
                     */
                    echo $form->errors();
                    ?>
                    <div class="form-row">
                        <div class="col-md-6">
                            <?php
                            echo $form->input("Matricule", "Matricule", array(
                                    "maxlength" => 10
                            ));
                            ?>
                        </div>
                        <div class="col-md-6">
                            <?php
                            echo $form->input("Nom", "Nom & Prénoms");
                            ?>
                        </div>
                    </div>

                    <div style="">
                        <div class="col-md-6">
                            <?php
                            echo $form->input("Mail", "Email Institutionnel", array(
                                    "type" => "email"
                            ));
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
                    <div style="padding-left: 15px;padding-right: 15px;">
                        <?php
                        echo $form->submit("Enregistrer", "success");
                        ?>
                        <a href="?p=admin.users.index" class="btn btn-primary">Retour</a>
                    </div>
                </div>
            </div>

        </form>

    </section>
</section>