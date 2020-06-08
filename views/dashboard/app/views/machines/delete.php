<section id="main-content">
    <section class="wrapper">
        <h1>Supprimer ce poste de certification ?</h1>


        <pre style="font-size: 18px;margin-top: 50px;">
<?php
echo "
    Machine n° <b style='color: red'>{$machine->NumMachine}</b> située dans la salle n° <b style='color:red'>{$machine->NumSalle}</b> du site <b style='color: blue'>{$machine->NomSite}</b>.
";
?>

        </pre>

        <form method="post">
            <div style="visibility:hidden">
                <?php
                echo $form->input("idMachine", null, array(
                    "type" => "hidden",
                ));
                ?>
            </div>

            <?php
            echo $form->Submit("Confirmer", "danger");
            ?>
            <a href="?p=admin.machines.index" class="btn btn-primary">Annuler</a>
        </form>
    </section>
</section>