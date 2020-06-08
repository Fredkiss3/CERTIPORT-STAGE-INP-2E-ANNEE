<?php
require "../../homestead/homestead.php";
require "../../src/functions.php";
require "../../src/handler.php";

check_access(2);

if (empty($_GET) and empty($_POST)) {
    notFound();
} else {
    if (!is_ajax()) {
        launch("lock_content.php", $_GET);
    }
}

?>
