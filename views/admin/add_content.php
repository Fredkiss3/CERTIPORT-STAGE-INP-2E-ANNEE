<?php
$title = "Ajouter un surveillant";
$matris = get_all_matri();
$sites = get_all_sites();
$salles = get_all_Salles();

?>

<!--contenue principal debut-->
<section id="main-content">

    <section class="wrapper">
        <div>
            <h1>AJOUTER UN SURVEILLANT</h1>
        </div>

        <form method="post">
            <?php echo csrf() ?>
            <?php echo action_input('add_surveillant') ?>
            <div style="margin-top: 50px;" class="row mt">
                <div class="col-md-9">

                    <div class="form-row">
                        <div class="form-group col-md-5">
                            <label for="matri">Matricule</label>
                            <select id="matri" name="matri" class="form-control" required>
                                <option aria-label=""></option>
                                <?php
                                foreach ($matris as $row):
                                    ?>
                                    <option id="matri-<?php echo $row["idUtilisateur"] ?>"
                                            value="<?php echo $row["idUtilisateur"] ?>"
                                            aria-label="<?php echo $row["Nom"] ?>"><?php echo $row["Matricule"] ?></option>
                                <?php
                                endforeach;
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-md-5">
                            <label for="name">Nom</label>
                            <input id="name" type="text" class="form-control" disabled readonly>
                        </div>
                        <div class="form-group col-md-5">
                            <label for="sites">Site affecté</label>
                            <select id="sites" class="form-control" name="site" required>
                                <option></option>
                                <?php
                                foreach ($sites as $site) :
                                    ?>
                                    <option value="<?php echo $site["idSite"] ?>"><?php echo $site["NomSite"] ?></option>
                                <?php
                                endforeach;
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-md-5">
                            <label for="salles">Salle surveillée</label>
                            <select id="salles" class="form-control" name="salle" required>
                                <option></option>
                            </select>
                            <p style="font-weight: bolder;">
                                <span id="nbreSurv">0 surveillants affectés</span> à cette salle
                            </p>
                        </div>
                    </div>


                </div>

            </div>
            <a href="<?php echo url("/") ?>" class="btn btn-primary" style="margin-left: 16px;">Annuler</a>
            <button type="submit" class="btn btn-success">Enregistrer</button>
        </form>
    </section>
</section>
<!--contenue principal fin-->

<script type="text/javascript">
    var salles = <?php echo json_encode($salles) ?>;
    var matris = <?php echo json_encode($matris) ?>;
    // console.log(matris);
</script>


