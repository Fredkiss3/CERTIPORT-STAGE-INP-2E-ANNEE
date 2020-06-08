<?php

require '../../homestead/homestead.php';
require '../../src/functions.php';
require '../../src/handler.php';


check_access(2, url('admin/dashboard.php'));

redirect(url("admin/dashboard.php"));

