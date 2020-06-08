<?php

require '../../homestead/homestead.php';
require '../../src/functions.php';
require '../../src/handler.php';

destroy_session();
redirect(url("accueil/"));