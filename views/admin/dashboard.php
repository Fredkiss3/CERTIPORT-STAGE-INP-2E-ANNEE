<?php
require '../../homestead/homestead.php';
require '../../src/functions.php';
require '../../src/handler.php';


check_access(2, 'admin/dashboard.php');

if (!is_ajax()) {
    launch("dash_content.php");
}
?>





