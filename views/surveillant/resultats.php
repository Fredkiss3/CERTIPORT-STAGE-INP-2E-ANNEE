<?php
require "../../homestead/homestead.php";
require "../../src/functions.php";
require "../../src/handler.php";

check_access(1);

if (!is_ajax()) {
    launch("results_content.php");
}

?>
