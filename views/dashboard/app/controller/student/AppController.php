<?php


namespace App\Controller\Student;


class AppController extends \App\Controller\AppController {
    public function __construct() {
        parent::__construct();
        if (!auth()->is_student()) {
            session()->set("error", "Vous n'avez pas l'autorisation d'acceder à cette partie du site");
            redirect(url("connectivity/login.php"));
        }
    }
}