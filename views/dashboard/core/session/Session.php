<?php


namespace Core\Session;


class Session {
    private static $_instance;

    /**
     * @return mixed
     */
    public static function getInstance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new Session();
        }

        return self::$_instance;
    }

    /**
     * Destroy session
     */
    public function destroy() {
        session_destroy();
    }

    /**
     * @param $key
     * @return mixed|null
     */
    public function get($key) {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }
        return null;
    }

    /**
     * @param $key
     */
    public function set($key, $val) {
        $_SESSION[$key] = $val;
    }

    /**
     * Get session value
     * @return array
     */
    public function val() {
        return $_SESSION;
    }

    /**
     * Flash Message for session
     * @param $key
     * @return mixed | string
     */
    public function flash($key) {
        $val = $this->get($key);
        if (!is_null($val)) {
            $this->remove($key);
        }
        return $val;
    }

    /**
     * Remove key from session
     * @param $key
     */
    public function remove($key) {
        unset($_SESSION[$key]);
    }
}