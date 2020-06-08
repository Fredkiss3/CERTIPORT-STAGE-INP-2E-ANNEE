<section id="main-content">
    <section class="wrapper">
        <h1>Supprimer cette certification ?</h1>


        <pre style="font-size: 18px;margin-top: 50px;">
<?php
echo "
    Nom de la certification : <b style='color: red'>{$cert->NomCertification}</b>
    ";
?>

        </pre>

        <form method="post">
            <div style="visibility:hidden">
                <?php
                echo $form->input("idCert", null, array(
                    "type" => "hidden",
                ));
                ?>
            </div>

            <?php
            echo $form->Submit("Confirmer", "danger");
            ?>
            <a href="?p=admin.certifications.index" class="btn btn-primary">Annuler</a>
        </form>
    </section>
</section>