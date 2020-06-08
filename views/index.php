<?php

session_start();

require '../src/functions.php';
require '../src/handler.php';

$title = "Accueil";


if (!empty($_SESSION["uid"]) and
    !empty($_SESSION["name"]) and
    !empty($_SESSION["matri"]) and
    isset($_SESSION["niveau_acces"]) and
    !empty($_SESSION["title"])
) {
    if ((int)$_SESSION["niveau_acces"] === 0) {
        redirect("dashboard/public/index.php?p=student.result.index");
    } elseif ((int)$_SESSION["niveau_acces"] === 1) {
        redirect("dashboard/public/index.php?p=surveillant.reservation.index");
    } elseif ((int)$_SESSION["niveau_acces"] > 1) {
        redirect("dashboard/public/index.php?p=surveillant.reservation.index");
    }
    elseif ((int)$_SESSION["niveau_acces"] < 0) {
        redirect("connectivity/login.php");
    }
} else {
    redirect("connectivity/login.php");
}
