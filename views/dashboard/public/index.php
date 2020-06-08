<?php

session_start();
define("ROOT", dirname(__DIR__));
require ROOT . "/app/App.php";
require ROOT . "/app/helpers.php";


if (isset($_GET["p"])) {
    $p = $_GET["p"];
} else {
    if (auth()->is_surveillant() or auth()->is_admin()) :
        $p = 'surveillant.reservation.index';
    else:
        $p = 'student.result.index';
    endif;
}

// Contrôleurs
$page = explode(".", $p);


if ($p !== "403" and $p !== "404")  {
    if (count($page) > 2) {
        $controller = "\App\\Controller\\" . ucfirst($page[0]) . "\\" . ucfirst($page[1]) . "Controller";
        $action = $page[2];
    } else {
        $action = $page[1];
        $controller = "\App\\Controller\\" . ucfirst($page[0]) . "Controller";
    }
}


try {
    switch ($p) {
        case "403":
            $title = "OOPS !!";
            ob_start();
            require ROOT . "/app/views/errors/403.php";
            $content = ob_get_clean();
            require ROOT . "/app/views/layouts/default.php";
            break;
        case "404":
            $title = "OOPS !!";
            ob_start();
            require ROOT . "/app/views/errors/404.php";
            $content = ob_get_clean();
            require ROOT . "/app/views/layouts/default.php";
            break;
        default:
            // dd(array($action, $controller));
            $action = str_replace("-", "_", $action);
            $controller = new $controller();
            $controller->$action();
    }

} catch (Exception $e) {
    ob_start();
    $title = "Erreur !";
    ?>

    <section id="main-content">
        <section class="wrapper">
            <h1 class="text-center">Exception ! 😟</h1>
            <div class="alert alert-danger">
                <?php echo($e->getMessage()); ?>
            </div>
            <div class="text-center">
                <a href="../public/" class="btn btn-primary">Retour au site.</a>
            </div>
        </section>
    </section>
    <?php
    $content = ob_get_clean();
    require ROOT . "/app/views/layouts/default.php";
}