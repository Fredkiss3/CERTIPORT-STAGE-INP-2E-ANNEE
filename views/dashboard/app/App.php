<?php

require ROOT . "/core/autoload.php";
require ROOT . "/app/autoload.php";

use Core\Config;
use Core\Database\MysqlDatabase;
use Core\Database\Database;
use Core\CoreApp;


/**
 * Class App La classe qui contient l'application
 * @package App
 */
class App implements CoreApp {

    private static $_instance = null;
    private $db_instance = null;

    public static function getInstance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new App();
        }
        return self::$_instance;
    }

    /**
     * Factory est un design pattern qui permet de générer des classes dynamiquement
     * @param $name
     * @return mixed
     */
    public function getTable($name) {
        $class_name = "\App\Table\\" . ucfirst($name) . "Table";
        return new $class_name($this->getDb());
    }

    /**
     * Factory for Database
     * @return Database
     */
    public function getDb() {
        $config = Config::getInstance(ROOT . "/config/config.php");
        if (is_null($this->db_instance)) {
            // Return only one instance
            $this->db_instance = new MysqlDatabase(
                $config->get("db_name"),
                $config->get("db_user"),
                $config->get("db_password"),
                $config->get("db_host")
            );
        }
        return $this->db_instance;
    }
}