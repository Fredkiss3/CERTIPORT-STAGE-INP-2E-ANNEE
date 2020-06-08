<?php
require "../../homestead/homestead.php";
require "../../src/functions.php";
require "../../src/handler.php";

check_access(1);

if (empty($_GET) and empty($_POST)) {
    notFound();
} else {
    if (!is_ajax()) {
        launch("note_content.php", $_GET);
    }
}

?>
