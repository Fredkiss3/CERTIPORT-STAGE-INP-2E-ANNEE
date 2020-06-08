<?php


namespace App\Table;


use Core\Table\Table;

class UserTable extends Table {
    protected $table = "utilisateurs";

    /**
     * User can make a reservation
     * @return bool
     */
    public function can_reserve($id) {
        $can = true;
        $lastReserve = $this->query(
            "SELECT  re.idResult,
                              re.Plage,
                              re.madeAt 
                              from reservations as re 
                              where re.Utilisateurs_idUtilisateur=? 
                                    and re.Date >= CURRENT_DATE() 
                                    ORDER BY re.idResult DESC", array($id),
            false);

        if ($lastReserve) {
            $timedif = $this->query(
                "SELECT TIME_FORMAT(TIMEDIFF(CURRENT_TIME(), ?), '%H') as timedif",
                array($lastReserve->madeAt), false);
            $timedif = abs((int)$timedif->timedif);
            $can = $timedif >= 2;
        }

        return $can;
    }

    /**
     * Max reservations reached for user
     * @param $id
     * @return bool
     */
    public function max_reserve_atteint($id) {
        $nbre_res = $this->query(
            "SELECT count(*) as count_
                             from reservations as re
                             where re.Date >= CURRENT_DATE()
                             and re.Utilisateurs_idUtilisateur=?",
            array($id), false);

        $count = $nbre_res->count_;
        return (int)$count >= 2;
    }
}