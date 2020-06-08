<?php

require '../../homestead/homestead.php';
require '../../src/functions.php';
require '../../src/handler.php';

if (!is_ajax()) {
    launch("register_content.php");
}

?>
