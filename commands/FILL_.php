<?php

// La base de données
require dirname(__DIR__) . "/homestead/db.php";

// Récupérer l'objet PDO
$db = new PDO('mysql:host=localhost;dbname=mydb', 'root', '', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);
/*
 * Créer la bd
 * */

$path = dirname(__DIR__)."/commands/mydb.sql";

// die($path);

// Ouvrir le fichier
$monfichier = fopen($path, 'r');

// la requête sql
$sql = "";


// lire la requête sql
while(!feof($monfichier)) {
    $sql = $sql . fgets($monfichier);
}

// exécuter les requêtes
$db->exec("SET FOREIGN_KEY_CHECKS = 0");
$db->exec($sql);
$db->exec("SET FOREIGN_KEY_CHECKS = 1");

// fermer le fichier
fclose($monfichier);

// Récupérer l'objet PDO
$db = new PDO('mysql:host=localhost;dbname=mydb', 'root', '', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

// Rafraîchir les données
$db->exec("SET FOREIGN_KEY_CHECKS = 0");
$db->exec("delete from utilisateurs where 1=1");
$db->exec("delete from super_administrateur where 1=1");
$db->exec("delete from surveillants where 1=1");
$db->exec("delete from etudiants where 1=1");
$db->exec("delete from sites where 1=1");
$db->exec("delete from salles where 1=1");
$db->exec("delete from certifications where 1=1");
$db->exec("delete from reservations where 1=1");
$db->exec("SET FOREIGN_KEY_CHECKS = 1");

$c = 20;
$users = [];

// Ajouter les users
for ($i = 0; $i < $c; $i++) {
    # code...
    try {
        echo 'abcd' . $i . "\n";
        $db->exec("INSERT INTO utilisateurs (Matricule, Nom, Mail, MotDePass) values(
        '17INP000$i', 'User-$i', 'mail$i@inphb.ci', '" . password_hash('abcd' . $i, PASSWORD_BCRYPT) . "')");
    } catch (Exception $e) {
        die("Erreur  : " . $e->getMessage());
    }
}

# Ajouter l'admin
$idLastUser = $db->lastInsertId();
$db->exec("INSERT INTO super_administrateur(Utilisateurs_idUtilisateur) values($idLastUser)");
$db->exec("UPDATE utilisateurs set NiveauAcces=2, StatutCompte=1 where idUtilisateur=$idLastUser");


# Ajouter un étudiant (le 1er utilisateur)
$db->exec("INSERT INTO etudiants(Classe, Filiere, Ecole, Utilisateurs_idUtilisateur) VALUES (
           'INFO 2',
           'STIC',
           'ESI',
           (select idUtilisateur from utilisateurs limit 1)
       )");

# Mettre le statut du compte à 'actif'
$db->exec("update utilisateurs set StatutCompte=1 where idUtilisateur=(select Utilisateurs_idUtilisateur from etudiants limit 1)");

# Ajouter les sites
$sites = [];
for ($i = 1; $i <= 4; $i++) {
    $db->exec("INSERT INTO sites (NomSite) values('Site-$i')");
    $sites[] = $db->lastInsertId();
}

$salles = [];
foreach ($sites as $site) {
    # Ajouter les salles
    for ($i = 1; $i <= 2; $i++) {
        $db->exec("INSERT INTO salles (NumSalle, Sites_idSite) values($i, $site)");
        $salles[] = $db->lastInsertId();
    }
}

$machines = [];
foreach ($salles as $salle) {
    # Ajouter les machines
    for ($i = 1; $i <= 3; $i++) {
        $db->exec("INSERT INTO machines (NumMachine, Salles_idSalle) values($i, $salle)");
        $machines[] = $db->lastInsertId();
    }
}


// Ajouter les certifications
$db->exec("INSERT INTO certifications(NomCertification, ScoreReussite) values ('MOS WORD', 700)");
$db->exec("INSERT INTO certifications(NomCertification, ScoreReussite) values ('MOS EXCEL', 700)");
$db->exec("INSERT INTO certifications(NomCertification, ScoreReussite) values ('DECOUVRIR PYTHON', 70)");


$plages = [
    "8h01-9h",
    "9h01-10h",
    "10h01-11h",
    "11h01-12h",
    "12h01-13h",
    "13h01-14h",
    "14h01-15h",
    "15h01-16h",
];

foreach ($plages as $plage) {
    # Ajouter deux réservations pour l'étudiant (Aujourd'hui & demain)
    $db->exec("INSERT INTO reservations(Utilisateurs_idUtilisateur, Date, Plage,
                          Machines_idMachine)
        VALUES (
                   (select idUtilisateur from utilisateurs limit 1),
                       (SELECT  CURDATE()) ,
                    '".$plage."',
                    (select idMachine from  machines limit 1)
                )");
}

$db->exec("INSERT INTO reservations(Utilisateurs_idUtilisateur, Date, Plage,
                          Machines_idMachine)
        VALUES (
                   (select idUtilisateur from utilisateurs limit 1),
                       (SELECT  DATE_ADD(CURDATE(), INTERVAL 1 DAY)) ,
                    '".$plages[0]."',
                    (select idMachine from  machines limit 1)
                )");
