<?php
check_access(2);
$title = "Rétablir les droits du surveillant";

if (!empty($params)) {
    $id = $params["id"];
}

$st = get_user_if_dead($id);

if (!$st) {
    notFound();
}

$title = "DéBloquer compte";
//dd($st);
?>


<!--contenue principal debut-->
<section id="main-content">
    <section class="wrapper">

        <h1>Êtes vous sûr de vouloir Débloquer ce compte ?</h1>
        <h3>Nom : <?php echo $st["Nom"] ?></h3>
        <h3>Matricule : <?php echo $st["Matricule"] ?></h3>

        <form method="post">
            <?php echo csrf() ?>
            <?php echo action_input('unlock_account') ?>
            <?php echo param_input('id', $id) ?>


            <div class="row">
                <a style="margin-left: 16px; margin-top: 20px;" role="reset" class="btn btn-primary"
                   href="<?php echo url('admin/accounts.php') ?>">Annuler</a>
                <input style="margin-left: 16px; margin-top: 20px;" role="button" class="btn btn-danger" type="submit"
                       value="Valider">
            </div>
        </form>
    </section>
</section>
<!--contenue principal fin-->
