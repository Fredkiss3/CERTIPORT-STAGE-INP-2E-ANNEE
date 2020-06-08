<?php

namespace Core\Auth;

use Core\CoreApp;
use Core\Database\Database;
use Core\Session\Session;


class DBAuth {

    private $db;
    /**
     * @var Session
     */
    private $session;


    // auth instance
    private static $_instance;

    /**
     * @var CoreApp
     */
    protected static $app = "App";

    /**
     * @return DBAuth
     */
    public static function getInstance() {
        if (is_null(self::$_instance)) {
            $app = static::$app;
            self::$_instance = new DBAuth($app::getInstance()->getDb());
        }
        return self::$_instance;
    }

    private function __construct(Database $db) {
        $this->db = $db;
        $this->session = Session::getInstance();
    }

    /**
     * User is logged ?
     * @return bool
     */
    public function logged() {
        return (!is_null($this->session->get("uid")));
    }

    /**
     * Logout
     */
    public function logout() {
        $this->session->destroy();
    }

    /**
     * Get user from 'auth'
     * @param string $model : Le nom de la classe à assimiller
     * @return mixed|null
     */
    public function user($model = "App\\Model\\User") {
        if ($this->logged()) {
            return $this->db->prepare(
                'SELECT * FROM utilisateurs where idUtilisateur=?',
                array($this->session->get("uid")),
                $model,
                false
            );
        } else {
            return null;
        }
    }

    /**
     * Is current user student ?
     * @return bool
     */
    public function is_student() {
        return $this->session->get("niveau_acces") >= 0;
    }

    /**
     * Is current user surveillant ?
     * @return bool
     */
    public function is_surveillant() {
        return $this->session->get("niveau_acces") >= 1;
    }


    /**
     * Is current user admin ?
     * @return bool
     */
    public function is_admin() {
        return $this->session->get("niveau_acces") >= 2;
    }
}