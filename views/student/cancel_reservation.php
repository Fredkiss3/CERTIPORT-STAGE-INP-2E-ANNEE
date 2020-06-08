<?php
require "../../homestead/homestead.php";
require "../../src/functions.php";
require "../../src/handler.php";

if (empty($_GET) and empty($_POST)) {
    notFound();
} else {
    if (!is_ajax()) {
        launch("cancel_content.php", $_GET);
    }
}

?>
