<?php


namespace App\Model;


use Core\Model\Model;

class User extends Model {
    protected static $idField = "idUtilisateur";
    protected $fieldsToSave = array(
        "Matricule", "Nom", "Contact", "Mail", "MotDePass"
    );
}