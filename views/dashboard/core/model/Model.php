<?php

namespace Core\Model;

use Core\CoreApp;
use Core\Table\Table;

class Model {

    /**
     * @var CoreApp -> The app related
     */
    protected static $app = "App";

    /**
     * @var array -> fields to update on save
     */
    protected $fieldsToSave = array();

    /**
     * @var string -> the column whic will represent the ID
     */
    protected static $idField = "id";


    /**
     * @param $name string de la méthode a appeler
     * @return mixed
     */
    public function __get($name) {
        // Exemple : this->url <==> this->getUrl()
        // ucfirst : 1er caractère en majuscule
        $method = "get" . ucfirst($name);

        // Appeler la méthode (en tant que châine de caractère)
        $this->$name = $this->$method();

        // Enregistrer l'attribut dans la bd
        return $this->$name;
    }

    /**
     * get related Table
     * @return Table
     */
    public static function table() {

        // Changer le namespace
        $class_name = str_replace("\Model", "\Table", get_called_class());

        // Ajouter le suffixe 'Table'
        $class_name .= "Table";

        // App
        $app = static::$app;

        return new $class_name($app::getInstance()->getDb());
    }

    /**
     * @return array|mixed
     */
    public static function all($orderBy=null) {
        if(is_null($orderBy)) {
            $orderBy = static::$idField;
        }
        return self::table()->all($orderBy);
    }

    /**
     * @return Model
     */
    public static function first($orderBy=null) {
        if(is_null($orderBy)) {
            $orderBy = static::$idField;
        }
        $all = self::table()->all($orderBy);
        if (count($all) > 0) {
            return $all[0];
        } else {
            return null;
        }
    }

    /**
     * @return Model
     */
    public static function last($orderBy=null) {
        if(is_null($orderBy)) {
            $orderBy = static::$idField;
        }
        $all = self::table()->all($orderBy. " DESC ");
        if (count($all) > 0) {
            return $all[0];
        } else {
            return null;
        }
    }

    /**
     * @param $id
     * @return Model
     */
    public static function find($id) {
        return self::table()->find($id, static::$idField);
    }

    /**
     * @param array $fields
     * @return bool
     */
    public static function create($fields = array()) {
        return self::table()->insert($fields);
    }

    /**
     * Find a specific column
     * @param $column string
     * @param $operator string
     * @param $value string
     * @param $multiple bool
     * @return Model|array
     */
    public static function where($column, $operator, $value, $multiple = false) {
        return self::table()->where($column, $operator, $value, $multiple);
    }


    /**
     * @return bool
     */
    public function save() {
        $args = array();
        foreach ($this->fieldsToSave as $f) {
            $args[$f] = $this->$f;
        }

        $id = static::$idField;
        return $this::table()->update($this->$id, $args, static::$idField);
    }

    /**
     * @return bool
     */
    public function delete() {
        $id = static::$idField;

        return $this::table()->delete($this->$id, static::$idField);
    }

}