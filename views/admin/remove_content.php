<?php
$title = "Retirer les droits du surveillant";

if (!empty($params)) {
    $id = $params["id"];
}

$surv = verify_surv_id($id);

if (!$surv) {
    throw new Exception("Ce surveillant n'existe pas !");
}
?>

<!--contenue principal debut-->
<section id="main-content">
    <section class="wrapper">

        <h1>Êtes vous sûr de vouloir retirer les droits de ce surveillant ?</h1>
        <form method="post">
            <h3>Nom : <?php echo $surv["Nom"] ?></h3>
            <h3>Matricule : <?php echo $surv["Matricule"] ?></h3>

            <?php echo csrf() ?>
            <?php echo action_input('remove_surveillant') ?>
            <?php echo param_input('id', $id) ?>

            <div class="row">
                <a style="margin-left: 16px; margin-top: 20px;" role="reset" class="btn btn-primary"
                   href="<?php echo url('dashboard/public/?p=admin.accounts.index') ?>">Annuler</a>
                <input style="margin-left: 16px; margin-top: 20px;" role="button" class="btn btn-danger" type="submit"
                       value="Valider">
            </div>
        </form>
    </section>
</section>
<!--contenue principal fin-->
