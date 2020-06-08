<?php

namespace Core\Database;

interface Database {

    /**
     * Make a sql query without prepare
     * @param $statement
     * @param $class_name
     * @param bool $multiple
     * @return array|mixed
     */
    public function query($statement, $class_name = null, $multiple = true);

    /**
     * @param $statement
     * @param $attributes
     * @param $class_name
     * @param bool $multiple if one result expected or multiple
     * @return array|mixed
     */
    public function prepare($statement, $attributes, $class_name = null, $multiple = false);

    /**
     * @return mixed
     */
    public function lastID();
}

