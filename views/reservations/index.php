<?php

require '../../homestead/homestead.php';
require '../../src/functions.php';
require '../../src/handler.php';


//dd($_SESSION);
// doit être connecté
login_required("reservations/");

// si la requête n'est pas une requête "Ajax"
if(!is_ajax()) {
    launch("index_content.php");
}
?>






