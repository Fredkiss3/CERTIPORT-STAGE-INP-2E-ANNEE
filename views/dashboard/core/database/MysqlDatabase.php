<?php


namespace Core\Database;
use PDO;

class MysqlDatabase implements Database {
    private $dbname;
    private $db_user;
    private $db_pass;
    private $db_host;
    private $pdo;


    public function __construct($dbname, $db_user = "root", $db_pass = "", $db_host = "localhost") {
        $this->dbname = $dbname;
        $this->db_user = $db_user;
        $this->db_pass = $db_pass;
        $this->db_host = $db_host;
    }

    private function getPDO() {
        if ($this->pdo === null) {
           try {
               $this->pdo = new PDO("mysql:dbname={$this->dbname};host={$this->db_host}", $this->db_user, $this->db_pass, array(
                   PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
               ));
           } catch (\Exception $e) {
               echo $e->getMessage();
            }
        }
        return $this->pdo;
    }


    /**
     * Make a sql query without prepare
     * @param $statement
     * @param $class_name
     * @param bool $multiple
     * @return array|mixed
     */
    public function query($statement, $class_name = null, $multiple = true) {
        $st = $this->getPDO()->query($statement);

        if(
            strpos($statement,"UPDATE") === 0 OR
            strpos($statement,"INSERT") === 0 OR
            strpos($statement,"DELETE") === 0
        ) {
            return $st;
        }

        if (is_null($class_name)) {
            $st->setFetchMode(PDO::FETCH_OBJ);
        } else {
            $st->setFetchMode(PDO::FETCH_CLASS, $class_name);
        }

        if (!$multiple) {
            return $st->fetch();
        } else {
            return $st->fetchAll();
        }
    }

    /**
     * @param $statement
     * @param $attributes
     * @param $class_name
     * @param bool $one if one result expected or multiple
     * @return array|mixed
     */
    public function prepare($statement, $attributes, $class_name = null, $multiple = false) {
        $st = $this->getPDO()->prepare($statement);
        $st->execute($attributes);

        if(
            strpos($statement,"UPDATE") === 0 OR
            strpos($statement,"INSERT") === 0 OR
            strpos($statement,"DELETE") === 0
        ) {
            return $st;
        }

        // Mode de récupération des éléments
        if (is_null($class_name)) {
            $st->setFetchMode(PDO::FETCH_OBJ);
        } else {
            $st->setFetchMode(PDO::FETCH_CLASS, $class_name);
        }

        if (!$multiple) {
            return $st->fetch();
        } else {
            return $st->fetchAll();
        }
    }

    /**
     * Get last ID inserted
     * @return mixed|string
     */
    public function lastID() {
        return $this->getPDO()->lastInsertId();
    }
}