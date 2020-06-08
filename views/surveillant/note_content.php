<?php

$title = "Noter réservation";

if (!empty($params)) {
    $r = get_reservation($params["id"]);
}

$certifs = get_all_certifications();

//dd($r);
?>

<!--contenue principal debut-->
<section id="main-content">
    <section class="wrapper">
        <div class="row">
            <h1 style="" class="text-center">Noter la réservation passée. </h1>
        </div>

        <?php if (!empty($_SESSION["error"])) :
            $e = $_SESSION['error'];
            echo <<< HTML
<div class="alert alert-danger text-center">
                $e
            </div>
HTML;
            unset($_SESSION["error"]);
        endif; ?>
        <div class="row">
            <form method="post">
                <?php echo csrf() ?>
                <?php echo action_input("note_student") ?>
                <?php echo param_input("id", $r["idResult"]) ?>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="h4">Faite par </label>
                        <input type="text" class="form-control" value="<?php echo $r["Nom"] ?>" disabled readonly>
                    </div>
                    <div class="form-group">
                        <label class="h4">Date </label>
                        <input type="text" class="form-control"
                               value="<?php echo ($r["date"] > 0) ? "Demain" : "Aujourd'hui" ?>" disabled readonly>
                    </div>

                    <div class="form-group">
                        <label class="h4" for="cert">Certification pass&eacute;e : </label>
                        <select name="certification" class="form-control" id="cert" required>
                            <option></option>
                            <?php foreach ($certifs as $cert): ?>
                                <option value=<?php echo "'".$cert['idCert']."'";
                                echo ($cert['idCert'] == $r['Certifications_idCert']) ? " selected" : "" ?>> <?php echo $cert['NomCertification'] ?> </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="score" class="h4">Score </label>
                        <input type="number" id="score" name="score" class="form-control"
                               value="<?php echo $r["score"] ?>" min="0" max="1000"
                               required>
                    </div>

                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="h4">Site </label>
                        <input type="text" class="form-control" value="<?php echo $r["NomSite"] ?>" disabled readonly>
                    </div>
                    <div class="form-group">
                        <label class="h4">Salle </label>
                        <input type="text" class="form-control" value="salle n° <?php echo $r["NumSalle"] ?>" disabled
                               readonly>
                    </div>

                    <div class="form-group">
                        <label class="h4">Machine </label>
                        <input type="text" class="form-control" value="Poste n° <?php echo $r["NumMachine"] ?>" disabled
                               readonly>
                    </div>
                    <div class="form-group">
                        <label class="h4">Plage Horaire </label>
                        <input type="text" class="form-control" value="<?php echo $r["Plage"] ?>" disabled readonly>
                    </div>
                </div>
                <a href="<?php echo url("/") ?>" class="btn btn-primary" style="margin-left: 16px;">Annuler</a>
                <button type="submit" class="btn btn-success">Enregistrer</button>
            </form>
        </div>
    </section>
</section>