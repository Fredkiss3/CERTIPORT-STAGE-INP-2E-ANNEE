<?php
$title = "Annuler reservation";

if (!empty($params)) {
    $id = $params["id"];
}

$reservation = get_reservation($id);

if (!$reservation) {
    notFound();
}

//dd($reservation);
?>

<!--contenue principal debut-->
<section id="main-content">
    <section class="wrapper">

        <h1>Êtes vous sûr de vouloir supprimer cette réservation ?</h1>
        <form method="post">
            <h3>Faite par : <b><?php echo($reservation["Nom"]) ?></b></h3>
            <h3>Date : <b><?php echo ($reservation["date"] > 0) ? "Demain" : "Aujourdh'hui" ?></b></h3>
            <h3>Plage Horaire : <b> <?php echo $reservation["Plage"] ?></b></h3>
            <h3>Machine : <b> poste n° <?php echo $reservation["NumMachine"] ?></b></h3>
            <h3>Salle : <b> salle n°  <?php echo $reservation["NumSalle"] ?></b></h3>
            <h3>Site : <b> <?php echo $reservation["NomSite"] ?></b></h3>

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
