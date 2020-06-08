<section id="main-content">
    <section class="wrapper">
        <h1 class="mt-3">
            <?php echo (!empty($machine) ? "Editer" : "Ajouter") . " un poste de certification" ?>
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
                        <div class="col-md-4">
                            <?php
                            echo $form->select("idSite", "Site", $sites);
                            ?>
                        </div>
                        <div class="col-md-4">
                            <?php
                            echo $form->select("Salles_idSalle", "Salle n°", $salles);
                            ?>
                        </div>
                        <div class="col-md-4">
                            <?php
                            echo $form->input("NumMachine", "Numéro de la machine", array(
                                "type" => "number",
                                "min" => 1
                            ));
                            ?>
                        </div>
                    </div>
                    <br>
                    <br>
                    <div style="padding-left: 15px;padding-right: 15px;">
                        <?php
                        echo $form->submit("Enregistrer", "success");
                        ?>
                        <a href="?p=admin.machines.index" class="btn btn-primary">Retour</a>
                    </div>
                </div>
            </div>

        </form>

    </section>
</section>

<script type="text/javascript">
    (function () {
        var salles = <?php  echo json_encode($all_salles)?>;

        var sitesEl = document.getElementById("idSite");
        var sallesEl = document.getElementById("Salles_idSalle");


        sitesEl.addEventListener("change", function () {
            sallesToShow = salles.filter(function (salle) {
                return  salle.Sites_idSite === sitesEl.value;
            });

            sallesEl.innerHTML = "";
            for (var i=0; i<sallesToShow.length; i++) {
                var salle = sallesToShow[i];
                sallesEl.innerHTML += "<option value='" + salle.idSalle +"'>"+ salle.NumSalle +"</option>";
            }
        });
    })()

</script>