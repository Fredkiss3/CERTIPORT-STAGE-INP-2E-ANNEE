<?php 
// lancer la session
session_start();


function getPDO() {
	$config = array();

	if ($_SERVER["HTTP_HOST"] == "localhost" or $_SERVER["HTTP_HOST"] == "127.0.0.1" or
	    $_SERVER["HTTP_HOST"] == "res.test") {
	    $config = array(
	        "db_name" => "mydb",
	        "db_user" => "root",
	        "db_password" => "",
	        "db_host" => "localhost",
	    );
	} else {
	    $config = array(
	        "db_name" => "moodle",
	        "db_user" => "inpadmin55",
	        "db_password" => "AAAdHHbLYXecunW9",
	        "db_host" => "localhost",
	    );
	}

	
    try {
        $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
        $db = new PDO('mysql:host='.$config["db_host"].';dbname='.$config["db_name"], $config["db_user"], $config["db_password"], $pdo_options);
        return $db;
    } catch (Exception $e) {
        die("Erreur  : ".$e->getMessage());
    }
}

