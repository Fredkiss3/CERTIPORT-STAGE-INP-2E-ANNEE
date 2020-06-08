<?php
require "../../homestead/homestead.php";
require "../../src/functions.php";
require "../../src/handler.php";

check_access(2);
if(!is_ajax()) {
    launch("accounts_content.php");
}
?>




