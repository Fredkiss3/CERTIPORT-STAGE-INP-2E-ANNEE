<?php


namespace App\Model;


use Core\Model\Model;

class Salle extends Model {
    protected static $idField = "idSalle";
    protected $fieldsToSave = array(
        "NumSalle", "Sites_idSite"
    );
}