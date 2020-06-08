<section id="main-content">
    <section class="wrapper">
        <h1 class="mt-3">
            <?php echo (!empty($cert) ? "Editer" : "Ajouter") . " une certification" ?>
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
                            echo $form->input("NomCertification", "Nom de la certification");
                            ?>
                        </div>
                        <div class="col-md-6">
                            <?php
                            echo $form->input("ScoreReussite", "Score Minimum de réussite", array(
                                "type" => "number",
                                "min" => "10",
                            ));
                            ?>
                        </div>
                    </div>
                    <br>

                    <div style="padding-left: 15px;padding-right: 15px;">
                        <?php
                        echo $form->submit("Enregistrer", "success");
                        ?>
                        <a href="?p=admin.certifications.index" class="btn btn-primary">Retour</a>
                    </div>
                </div>
            </div>

        </form>

    </section>
</section>