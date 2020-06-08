<?php

namespace Core\Table;

use Core\Database\Database;

class Table {
    protected $table;

    /**
     * Sachant que les tables font toujours des requêtes, elles ont besoin
     * de savoir la base de données
     * @var Database
     */
    protected $db;

    public function __construct(Database $db) {

        $this->db = $db;

        // Récupérer le nom de la table (s'il n'est pas défini)
        if (!$this->table) {
            // Diviser le nom de la classe du namespace
            $parts = explode("\\", get_class($this));

            // Récupérer le nom de la classe
            $class_name = end($parts);

            // Récupérer le nom de la table
            $this->table = strtolower(str_replace("Table", "", $class_name)) . "s";
        }
    }

    /**
     * Get all items from table
     * @return array|mixed
     */
    public function all($orderBy = null) {
        return $this->query("SELECT * FROM " . $this->table .
            (!is_null($orderBy) ? " ORDER BY {$orderBy}" : "")
        );
    }

    /**
     * Get one item
     * @param $id
     * @return mixed
     */
    public function find($id, $idColumn = "id") {
        return $this->query("SELECT * FROM {$this->table} WHERE {$idColumn}=?", array($id), false);
    }


    /**
     * @param $id
     * @param $fields
     * @return bool
     */
    public function update($id, $fields, $idColumn = "id") {
        $sql_parts = array();
        $attr = array();

        foreach ($fields as $k => $v) {
            $sql_parts[] = "$k=?";
            $attr[] = $v;
        }

        $sentence = implode(", ", $sql_parts);
        $attr[] = $id;

//        dd(array("UPDATE  {$this->table} SET {$sentence} WHERE id=?", $attr));
//        dd(array("UPDATE  {$this->table} SET {$sentence} WHERE {$idColumn}=?",  $attr), false);

        return $this->query("UPDATE  {$this->table} SET {$sentence} WHERE {$idColumn}=?", $attr, false);
    }

    /**
     * @param $id
     * @param $fields
     * @return bool
     */
    public function delete($id, $idColumn = "id") {
        return $this->query("DELETE FROM {$this->table} Where {$idColumn}=?", array($id));
    }


    /**
     * Make an SQL Query with prepare or not
     * @param $statement
     * @param $multiple bool : If multiple result expected
     * @param $args array
     * @return array|mixed
     */
    public function query($statement, $args = null, $multiple = true) {

        // Changer le namespace
        $class_name = str_replace("\Table", "\Model", get_class($this));

        // Retirer le suffixe 'Table'
        $class_name = str_replace("Table", "", $class_name);


        if ($args) {
            return $this->db->prepare(
                $statement,
                $args,
                $class_name,
                $multiple
            );
        } else {
            return $this->db->query(
                $statement,
                $class_name,
                $multiple);
        }
    }


    /**
     * Extraire une colonne de la table
     * @param $key
     * @param $val
     * @return array -> liste des éléments
     */
    public function extract($key, $val, $collection = null) {
        $records = (is_null($collection) ? $this->all() : $collection);
        $return = array();

        foreach ($records as $r) {
            $return[$r->$key] = $r->$val;
        }

        return $return;
    }


    /**
     * @param array $fields
     * @return bool
     */
    public function insert($fields = array()) {
        $sql_parts = array();
        $questions = array();
        $attr = array();

        foreach ($fields as $k => $v) {
            $sql_parts[] = "$k";
            $questions[] = "?";
            $attr[] = $v;
        }

        $sql = implode(", ", $sql_parts);
        $q = implode(", ", $questions);

//        dd(array($sql, $q, $attr), false);
        return $this->query("INSERT INTO {$this->table} ({$sql}) VALUES ({$q})", $attr);
    }

    /**
     * Select value from a column
     * @param $column string
     * @param $operator string
     * @param $value mixed
     * @param $multiple bool
     * @return mixed
     */
    public function where($column, $operator, $value, $multiple) {
        return $this->query("SELECT * FROM {$this->table} WHERE {$column} {$operator} ?",
            array($value),
            $multiple);
    }

    /**
     * @return mixed
     */
    public function lastID() {
        return $this->db->lastID();
    }
}