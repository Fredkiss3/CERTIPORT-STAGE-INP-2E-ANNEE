<?php


namespace App\Controller\Admin;


use App\Model\Reservation;

class ReservationController extends AppController {
    public function delete() {
        $title = "Supprimer réservation";
        $this->render("dash.delete", compact("title"));
    }
}