<section id="main-content">
    <section class="wrapper">
        <h1>Supprimer cet utilisateur ainsi que les données qui lui sont liées ?</h1>


        <pre style="font-size: 18px;margin-top: 50px;">
<?php
/**
 * @var $user \App\Model\User
 */
echo <<<HTML

   Nom de l'étudiant : <b style="color: blue">$user->Nom</b> <br>
HTML;

/**
 * @var $student_related \App\Model\Student
 */
if ($student_related) {
    echo <<<HTML
    Vous allez supprimer aussi l'Etudiant : <b style="color: blue">{$user->Nom} <span style="color:red">(ID ={$student_related->idEtudiant})</span></b> <br>
HTML;
}

/**
 * @var $surv_related \App\Model\Surveillant
 */
if ($surv_related) {
    echo <<<HTML
    Vous allez supprimer aussi le surveillant : <b style="color: blue">{$user->Nom} <span style="color:red">(ID = {$surv_related->idSurveillant})</span></b> <br>
HTML;
}

/**
 * @var $all_reservations array
 */
if (count($all_reservations) > 0) {
    echo <<<HTML
    Les réservations ci-dessous seront aussi supprimées :
    <ol>
HTML;

    foreach ($all_reservations as $res) {
        echo <<<HTML
    <li>Effectuée le <b style="color: blue">{$res->Date}</b> pour la plage horaire de <b style="color: blue">{$res->Plage}</b></li>
HTML;
    }

    echo <<<HTML
    </ol>
HTML;

}


?>
        </pre>
        <form method="post">
            <?php
            /**
             * @var $form \Core\HTML\BootstrapForm
             */
            echo $form->errors();
            ?>

            <div style="visibility: hidden">
                <?php
                echo $form->input("idUtilisateur", "", array(
                    "type" => "hidden",
                ));
                ?>
            </div>

            <?php

            echo $form->submit("Confirmer", "danger");
            ?>
            <a href="?p=admin.users.index" class="btn btn-primary">Annuler</a>
        </form>

    </section>
</section>