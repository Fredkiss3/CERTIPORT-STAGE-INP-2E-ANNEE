<?php

namespace Core;

use Core\Database\Database;
use Core\Table\Table;

interface CoreApp {

    /**
     * @return CoreApp
     */
    public static function getInstance();

    /**
     * @param $name string
     * @return Table
     */
    public function getTable($name);

    /**
     * @return Database
     */
    public function getDb();

}
