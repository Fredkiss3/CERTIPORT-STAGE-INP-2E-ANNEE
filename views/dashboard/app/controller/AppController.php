<?php


namespace App\Controller;

use Core\Controller\Controller;

class AppController extends Controller {
    protected $layout  = "default";
    protected $Page404 = "index.php?p=404";
    protected $Page403 = "index.php?p=403";

    public function __construct() {
        if(auth()->logged()) {
            $this->viewPath  = ROOT . "/app/views/";
        } else {
            session()->set("error", "Veuillez vous connecter pour avoir accès à cette partie du site");
            redirect(url("connectivity/login.php"));
        }
    }
}