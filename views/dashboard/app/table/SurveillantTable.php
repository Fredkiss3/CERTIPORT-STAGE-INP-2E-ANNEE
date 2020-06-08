<?php


namespace App\Table;


use Core\Table\Table;

class SurveillantTable extends Table {
    public function getAll() {
        $surveillants = $this->query(
            "SELECT u.Matricule,
                             u.Nom, 
                             su.Salles_idSalle, 
                             su.idSurveillant,
                             u.NiveauAcces 
                             FROM `surveillants` as su, 
                                   utilisateurs as u 
                             where u.idUtilisateur=su.Utilisateurs_idUtilisateur 
                                   ORDER BY u.Matricule");

        foreach ($surveillants as $surv) {
            $salle = $this->query(
                "SELECT sa.NumSalle, 
                                 si.NomSite,
                                 sa.idSalle 
                                 from salles as sa, 
                                      sites as si
                                 where sa.idSalle=? 
                                      and si.idSite=sa.Sites_idSite",
                array($surv->Salles_idSalle), false);
            $surv->NumSalle = $salle->NumSalle;
            $surv->NomSite = $salle->NomSite;
        }

        return $surveillants;
    }
}