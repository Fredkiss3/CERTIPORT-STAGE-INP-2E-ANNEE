<?php
$title = "Annuler reservation";

if (!empty($params)) {
    $id = $params["id"];
}

$reservation = get_reservation($id);

if (!$reservation) {
    notFound();
}
?>

<!--contenue principal debut-->
<section id="main-content">
    <section class="wrapper">

        <h1>Êtes vous sûr de vouloir annuler cette réservation ?</h1>
        <form method="post">
            <h3>Date : <?php echo ($reservation["date"] > 0) ? "Demain" : "Aujourdh'hui" ?></h3>
            <h3>Plage Horaire : <?php echo $reservation["Plage"] ?></h3>
            <h3>Machine : poste n° <?php echo $reservation["NumMachine"] ?></h3>
            <h3>Salle : salle n° <?php echo $reservation["NumSalle"] ?></h3>
            <h3>Site : <?php echo $reservation["NomSite"] ?></h3>

            <?php echo csrf() ?>
            <?php echo action_input('cancel_reservation') ?>
            <?php echo param_input('id', $id) ?>

            <div class="row">
                <a style="margin-left: 16px; margin-top: 20px;" role="reset" class="btn btn-primary"
                   href="<?php echo url('/') ?>">Annuler</a>
                <input style="margin-left: 16px; margin-top: 20px;" role="button" class="btn btn-danger" type="submit"
                       value="Valider">
            </div>
        </form>
    </section>
</section>
<!--contenue principal fin-->
