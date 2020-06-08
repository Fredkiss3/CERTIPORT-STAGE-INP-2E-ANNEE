<?php


namespace App\Model;

use Core\Model\Model;

class Certification extends Model {
    protected static $idField = "idCert";
    protected $fieldsToSave = array(
       "NomCertification", "ScoreReussite"
    );
}