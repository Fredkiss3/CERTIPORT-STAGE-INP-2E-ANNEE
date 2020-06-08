<?php


namespace App\Model;


use Core\Model\Model;

class Student extends Model {
    protected static $idField = "idEtudiant";
    protected $fieldsToSave = array(
        "Ecole", "Classe", "Filiere"
    );
}