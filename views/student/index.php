<?php

require '../../homestead/homestead.php';
require '../../src/functions.php';
require '../../src/handler.php';

login_required("student/");

if (!is_ajax()) {
    launch("index_content.php");
}
?>

