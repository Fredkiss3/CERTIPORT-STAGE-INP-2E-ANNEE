<?php


namespace App\Table;


use Core\Table\Table;

class SalleTable extends Table {
    public function all_closed() {
        $open = $this->query(
            "SELECT CURRENT_TIME() < '15:01:00' and CURRENT_TIME() >= '07:01:00' as open"
        ,null, false);
        return $open->open !== '1';
    }
}