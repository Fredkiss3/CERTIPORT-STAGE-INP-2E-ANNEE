<?php

namespace App;

/**
 * Class Autoloader cette classe charge automatiquement les classes
 * @package App
 */
class Autoloader {
    /**
     * @param $class string nom de la classe
     */
    static function autoload($absolute) {
        if (strpos($absolute, __NAMESPACE__ . "\\") === 0) {
            # Remplacer le namespace par la casse
            $absolute = str_replace(__NAMESPACE__ . "\\", "", $absolute);
            $absolute = str_replace("\\", DIRECTORY_SEPARATOR, $absolute);

            $path = explode(DIRECTORY_SEPARATOR, $absolute);
            $class = array_pop($path);
            $path = implode(DIRECTORY_SEPARATOR, $path);
            
            # Récupérer le fichier
            require_once ROOT . strtolower("/app" . DIRECTORY_SEPARATOR. $path) .DIRECTORY_SEPARATOR. $class  . ".php";
        }
    }

    /**
     * Enregistrer les classes
     */
    static function register() {
        spl_autoload_register(array(__CLASS__, "autoload"));
    }
}
