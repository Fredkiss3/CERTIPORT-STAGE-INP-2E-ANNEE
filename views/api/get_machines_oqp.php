<?php
require '../../homestead/homestead.php';
require '../../src/functions.php';
if (!empty($_GET["id"])) {
    $id = $_GET["id"];
    echo get_nb_machines_oqp($id);
} else {
    header("HTTP/1.0 403 Forbidden");
    exit();
}

