<section id="main-content">
    <section class="wrapper">
        <h1>Supprimer cette salle ainsi que les données qui lui sont liées ?</h1>


        <pre style="font-size: 18px;margin-top: 50px;">
<?php
            echo "
Salle n° <b style='color: red'>{$salle->NumSalle}</b> affectée au site <b style='color: blue'>{$salle->NomSite}</b>
";


            if (count($all_machines) > 0) {
                echo <<<HTML

Les Machines ci-dessous seront aussi supprimées :
<ol>
HTML;
                foreach ($all_machines as $machine) {
                    echo <<<HTML
<li>La Machine n° <b style="color: red">{$machine->NumMachine}</b></li>
HTML;
                }

                echo <<<HTML
            </ol>
HTML;
            }
            ?>

        </pre>

        <form method="post">
            <div style="visibility:hidden">
                <?php
                echo $form->input("idSalle", null, array(
                    "type" => "hidden",
                ));
                ?>
            </div>

            <?php
            echo $form->Submit("Confirmer", "danger");
            ?>
            <a href="?p=admin.salles.index" class="btn btn-primary">Annuler</a>
        </form>
    </section>
</section>