<?php
// lancer la session
session_start();
function getPDO()
{

	// configuration de la BD
	$config = require(dirname(__DIR__) . '/views/dashboard/config/config.php');

	try {
		$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
		$db = new PDO('mysql:host=' . $config["db_host"] . ';dbname=' . $config["db_name"], $config["db_user"], $config["db_password"], $pdo_options);
		return $db;
	} catch (Exception $e) {
		die("Erreur  : " . $e->getMessage());
	}
}
