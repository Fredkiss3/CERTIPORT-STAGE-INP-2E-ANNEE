<?php


namespace App\Model;


use Core\Model\Model;

class Machine extends Model {
    protected static $idField = "idMachine";
    protected $fieldsToSave = array(
        "NumMachine", "Salles_idSalle"
    );
}