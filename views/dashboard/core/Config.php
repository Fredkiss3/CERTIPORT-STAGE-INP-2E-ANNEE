<?php


namespace Core;


class Config {
    private $setttings = array();

    /**
     * @var Config
     */
    private static $_instance = null;


    private function __construct($file) {
        $this->setttings = require($file);
    }

    /**
     * For singleton Design Pattern
     * @return Config
     */
    public static function getInstance($file) {
        if (is_null(self::$_instance)) {
            self::$_instance = new Config($file);
        }
        return self::$_instance;
    }

    /**
     * Get key
     * @param $name
     * @return mixed
     */
    public function get($key) {
        if(!isset($this->setttings[$key])) {
            return null;
        }

        return $this->setttings[$key];
    }

}