<?php

// charger les classes téléchargées
require "../vendor/autoload.php";

// la constante pour le chemin des vues
define("VIEW_PATH", dirname(__DIR__) . "/_views/");

// Plages horaires
define("PLAGES",  [
    "8h01-9h",
    "9h01-10h",
    "10h01-11h",
    "11h01-12h",
    "12h01-13h",
    "13h01-14h",
    "14h01-15h",
    "15h01-16h",
]);

// La base de données
require dirname(__DIR__) . "/homestead/db.php";

// les fonctions
require VIEW_PATH . "functions.php";

// Commencer la session
session_start();

$whoops = new \Whoops\Run;
$whoops->prependHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

// Notre router
$router = new AltoRouter();

// Mapper les urls avec les fichiers
try {
    // l'index
    $router->map("GET", "_/", "index.php");

    // Connexion
    $router->map("GET", "_/login","connexion/login.php");

    // Déconnexion
    $router->map("GET", "_/logout", "connexion/logout.php");

    // Contrôleur
    $router->map("POST", "_/handler", "handler.php");
    $router->map("POST", "_/handler/lock/[i:id]", "handler.php");
    $router->map("POST", "_/handler/unlock/[i:id]", "handler.php");
    $router->map("POST", "_/handler/remove_surveillant/[i:id]", "handler.php");
    $router->map("POST", "_/handler/reset_surveillant/[i:id]", "handler.php");
    $router->map("POST", "_/handler/reserve/get_machines", "handler.php");
    $router->map("POST", "_/handler/reserve/reserver_machine", "handler.php");

    // Routes Etudiant
    $router->map("GET", "_/student", "student/index.php");
    $router->map("GET", "_/student/register", "student/index.php");
    $router->map("GET", "_/student/reserve", "student/reserve.php");

    // Routes Surveillant
    $router->map("GET", "_/surveillant", "surveillant/index.php");
    $router->map("GET", "_/surveillant/dashboard", "surveillant/dashboard.php");

    // Routes Admin
    $router->map("GET", "_/admin", "admin/index.php");
    $router->map("GET", "_/admin/dashboard", "admin/dashboard.php");
    $router->map("GET", "_/admin/lock/[i:id]", "admin/lock_account.php");
    $router->map("GET", "_/admin/unlock/[i:id]", "admin/unlock_account.php");
    $router->map("GET", "_/admin/add_surveillant", "admin/add_surveillant.php");
    $router->map("GET", "_/admin/remove_surveillant/[i:id]", "admin/remove_surveillant.php");
    $router->map("GET", "_/admin/reset_surveillant/[i:id]", "admin/reset_surveillant.php");
} catch (Exception $e) {
    throw new Exception($e->getMessage());
}

// LANCER LE ROUTER
$match = $router->match();
launch($match['target'], $match["params"]);