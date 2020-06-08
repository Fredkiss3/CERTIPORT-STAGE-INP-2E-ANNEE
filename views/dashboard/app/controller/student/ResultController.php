<?php


namespace App\Controller\Student;


use App\Model\Reservation;
use App\Model\Salle;
use App\Model\User;

class ResultController extends AppController {
    public function index() {
        $title = "Mes Résultats";
        $resultats = true;
        $res_non_notees = Reservation::table()->getUserResults(session()->get("uid"));
        $res_notees = Reservation::table()->getUserResults(session()->get("uid"), true);
        $can_reserve = User::table()->can_reserve(session()->get("uid"));
        $max_res = User::table()->max_reserve_atteint(session()->get("uid"));
        $salles_fermees = Salle::table()->all_closed();

        $this->render("dash.result",
            compact("title",
                "resultats",
                "res_non_notees",
                "res_notees",
                "can_reserve", "max_res", "salles_fermees"));
    }
}