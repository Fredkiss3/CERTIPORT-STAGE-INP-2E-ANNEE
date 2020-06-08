<?php


namespace App\Table;


use Core\Table\Table;

class ReservationTable extends Table {
    public function getAll($notees = false) {
        if (!$notees) {
            return $this->query("SELECT r.idResult,
       r.score, 
       r.Apreciation, 
       r.Plage,
       DATE_FORMAT(r.Date, '%d/%m/%Y') as dt,
       DATEDIFF(r.Date, CURRENT_DATE()) as datedif, 
       m.Salles_idSalle , 
       u.Matricule,
       u.Nom
            FROM reservations as r, 
                 utilisateurs as u, 
                 machines as m"
                . (auth()->is_admin() ? "" :
                    ",surveillants as su") .
                "
        WHERE score = -1 
        AND r.Utilisateurs_idUtilisateur=u.idUtilisateur 
        AND r.Machines_idMachine=m.idMachine"
                . (auth()->is_admin() ? "" :
                    "
        AND m.Salles_idSalle=su.Salles_idSalle
        AND su.Utilisateurs_idUtilisateur=? ")
                , array(auth()->user()->idUtilisateur));
        } else {
            return $this->query("SELECT r.idResult,
       r.score, 
       r.Apreciation, 
       c.NomCertification,
       DATEDIFF(r.Date, CURRENT_DATE()) as datedif,
       c.ScoreReussite,
       r.Plage,
       DATE_FORMAT(r.Date, '%d/%m/%Y') as dt,
       u.Matricule,
       u.Nom
            FROM reservations as r, 
                 utilisateurs as u, 
                 machines as m,
                 certifications as c"
                . (auth()->is_admin() ? "" :
                    ",surveillants as su") .
                "
        WHERE score > -1 
        AND r.Utilisateurs_idUtilisateur=u.idUtilisateur 
        AND r.Certifications_idCert=c.idCert
        AND r.Machines_idMachine=m.idMachine"
                . (auth()->is_admin() ? "" :
                    "
        AND m.Salles_idSalle=su.Salles_idSalle
        AND su.Utilisateurs_idUtilisateur=? ")
                , array(auth()->user()->idUtilisateur));
        }
    }

    public function getUserResults($uid, $notees = false) {
        if (!$notees) {
            return $this->query("SELECT r.idResult,
       r.score, 
       r.Apreciation, 
       r.Certifications_idCert,
       r.Absence,
       r.Plage, 
       DATE_FORMAT(r.Date, '%d/%m/%Y') as dt,
       DATEDIFF(r.Date, NOW()) as datedif, 
       m.NumMachine, 
       si.NomSite, 
       sa.NumSalle
            FROM reservations as r, 
                 utilisateurs as u, 
                 machines as m,
                 sites as si,
                 salles as sa
        WHERE score = -1 
        AND r.Utilisateurs_idUtilisateur=u.idUtilisateur 
        AND r.Machines_idMachine=m.idMachine
        AND m.Salles_idSalle=sa.idSalle
        AND sa.Sites_idSite=si.idSite
        AND u.idUtilisateur=? ", array($uid));
        } else {
            return $this->query("SELECT r.idResult,
       r.score, 
       r.Apreciation, 
       c.NomCertification,
       c.ScoreReussite,
       r.Plage, 
       DATE_FORMAT(r.Date, '%d/%m/%Y') as dt,
       DATEDIFF(r.Date, NOW()) as datedif 
            FROM reservations as r, 
                 utilisateurs as u, 
                 certifications as c
        WHERE score > -1 
        AND r.Utilisateurs_idUtilisateur=u.idUtilisateur 
        AND r.Certifications_idCert=c.idCert 
        AND u.idUtilisateur=? ", array($uid));
        }
    }
}