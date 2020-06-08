<?php


namespace App\Table;


use Core\Table\Table;

class StudentTable extends Table {
    protected $table = "etudiants";


    public function getAll() {
        $students = $this->query(
            "SELECT u.Matricule,
                             u.StatutCompte,
                             u.idUtilisateur,
                             u.Nom,
                             e.idEtudiant 
                            FROM etudiants as e, 
                                utilisateurs as u 
                            where e.Utilisateurs_idUtilisateur=u.idUtilisateur");

        foreach ($students as $student) {
            if ($this->locked($student)) {
                $student->StatutCompte = 0;
            }
        }
        return $students;
    }

    /**
     * @param $idUser
     * @return bool
     */
    public function locked($student) {
        return false;
    }
}