<?php
require '../../homestead/homestead.php';
require '../../src/functions.php';

if(isset($_GET["id"])) {
    echo get_nbre_surv_for_salle($_GET["id"]);
} else {
    notFound();
}
