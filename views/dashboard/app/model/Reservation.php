<?php


namespace App\Model;


use Core\Model\Model;

class Reservation extends Model {
    protected static $idField = "idResult";
    protected $fieldsToSave = array("score", "Absence", "Certification_idCert", "Appreciation");
}