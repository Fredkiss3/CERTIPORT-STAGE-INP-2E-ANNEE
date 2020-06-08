<?php


namespace App\Controller\Surveillant;


use App\Model\Reservation;

class ReservationController extends AppController {
    public function index() {
        $title = "Accueil";
        $dash = true;
        $res_notees = Reservation::table()->getAll(true);
        $res_non_notees = Reservation::table()->getAll(false);
        $this->render("dash.index", compact("title", "dash", "res_notees", 'res_non_notees'));
    }
}