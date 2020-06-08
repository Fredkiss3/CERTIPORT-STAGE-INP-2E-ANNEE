<?php


// La base de données
require dirname(__DIR__) . "/homestead/homestead.php";

echo "GETPDO";
// Récupérer l'objet PDO
$db = getPDO();

echo "GETPDO";

// CREATION DE LA BDD
function create_db() {
    
    $path = dirname(__DIR__)."/commands/mydb.sql";

    // die($path);

    // Ouvrir le fichier
    $monfichier = fopen($path, 'r');

    // la requête sql
    $sql = file_get_contents($path);
//
//    echo $sql;
//    echo "\n\n\n";
    
    // exécuter les requêtes
    $db = getPDO();
    $db->exec("SET FOREIGN_KEY_CHECKS = 0");
    $db->exec($sql);
    $db->exec("SET FOREIGN_KEY_CHECKS = 1");
    $db->exec("commit");

    // fermer le fichier
    fclose($monfichier);
}

$db->exec("SET FOREIGN_KEY_CHECKS = 0");

create_db();
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
$users = array(
    array("17INP00212", "ERIC-SERGE Privat Temomande De sanzo", "privat.eric-serge@inphb.ci"),
    array("17INP00740", "COULIBALY Alassane", "alassane.coulibaly@inphb.ci"),
    array("17INP00227", "KROWY Djamby Stephane", "djamby.krowy@inphb.ci"),
    array("17INP00205", "ASSEKE N'Da Anzian Yann", "yann.asseke@inphb.ci"),
    array("17INP00223", "KOUAME Kouadio Dit Bakary", "bakary.kouame@inphb.ci"),
    array("17INP00741", "DIBY Akissi Valérie", "valerie.diby@inphb.ci"),
    array("17INP00229", "N'DA Vianney Anselme Ethy", "viannet.nda@inphb.ci"),
    array("17INP00213", "Flan Guelany Jean-Charles", "guelany.flan@inphb.ci"),
    array("17INP00994", "KISSIE Fredhel ", "fredhel.kissie@inphb.ci"),
    array("18INP00318", "MBALI-SAH Aube Nerisse", "aube.mbali-sah@inphb.ci"),
);

// Ajouter les users
//for ($i = 0; $i < $c; $i++) {
//    # code...
//    try {
//        $db->exec("INSERT INTO utilisateurs (Matricule, Nom, Mail) values(
//        '17INP000$i', 'User-$i', 'mail$i@inphb.ci')");
//    } catch (Exception $e) {
//        die("Erreur  : " . $e->getMessage());
//    }
//}

foreach ($users as $user) {
    try {
        $st = $db->prepare("INSERT INTO utilisateurs (Matricule, Nom, Mail) values(?, ?, ?)");

        $st->execute($user);
    } catch (Exception $e) {
        die("Erreur  : " . $e->getMessage());
    }
}

$db->exec("INSERT INTO utilisateurs (Matricule, Nom, Mail) values(
        '17INP0001', 'Admin', 'admin.inphb@inphb.ci')");

# Ajouter l'admin
$idLastUser = $db->lastInsertId();
$db->exec("INSERT INTO super_administrateur(Utilisateurs_idUtilisateur) values($idLastUser)");
$db->exec("UPDATE utilisateurs set NiveauAcces=2, StatutCompte=1,
                        MotDePass='" . password_hash('admin', PASSWORD_BCRYPT) . "' 
                         where idUtilisateur=$idLastUser");

# Ajouter un étudiant (le 1er utilisateur)
//$db->exec("INSERT INTO etudiants(Classe, Filiere, Ecole, Utilisateurs_idUtilisateur) VALUES (
//           'INFO 2',
//           'STIC',
//           'ESI',
//           (select idUtilisateur from utilisateurs limit 1)
//       )");
//
//# Mettre le statut du compte à 'actif'
//$db->exec("update utilisateurs set StatutCompte=1, NiveauAcces=0 where idUtilisateur=(select Utilisateurs_idUtilisateur from etudiants limit 1)");

# Ajouter les sites
// sites
$sites_= array(
    1 => 'INP SUD',
    2 => 'INP CENTRE',
    3 => 'INP NORD',
    4 => 'INP ABIDJAN'
);

$sites = array();
for ($i = 1; $i <= count($sites_); $i++) {
    $db->exec("INSERT INTO sites (idSite, NomSite) values($i, '" . $sites_[$i] . "')");
    $sites[] = $db->lastInsertId();
}

# Ajouter les salles
$salles = array();
$num = 0;
foreach ($sites as $site) {
    for ($i = 1; $i <= 2; $i++) {
        $num++;
        $sit = $sites[array_rand($sites)];
        $db->exec("INSERT INTO salles (NumSalle, Sites_idSite) values($num, $sit)");
        $salles[] = $db->lastInsertId();
    }
}

$machines = array();
$num = 0;
foreach ($salles as $salle) {
    # Ajouter les machines
    for ($i = 1; $i <= 3; $i++) {
        $num++;
        $sal = $salles[array_rand($salles)];
        $db->exec("INSERT INTO machines (NumMachine, Salles_idSalle) values($num, $sal)");
        $machinesarray[] = $db->lastInsertId();
    }
}


// Ajouter les certifications
$db->exec("INSERT INTO certifications(NomCertification, ScoreReussite) values ('MOS WORD', 700)");
$db->exec("INSERT INTO certifications(NomCertification, ScoreReussite) values ('MOS EXCEL', 700)");
$db->exec("INSERT INTO certifications(NomCertification, ScoreReussite) values ('DECOUVRIR PYTHON', 70)");

$plages = array(
    "8h01-9h",
    "9h01-10h",
    "10h01-11h",
    "11h01-12h",
    "12h01-13h",
    "13h01-14h",
    "14h01-15h",
    "15h01-16h",
);


echo "OK\n";
//foreach ($plages as $plage) {
//    # Ajouter deux réservations pour l'étudiant (Aujourd'hui & demain)
//    $db->exec("INSERT INTO reservations(Utilisateurs_idUtilisateur, Date, Plage,
//                          Machines_idMachine)
//        VALUES (
//                   (select idUtilisateur from utilisateurs limit 1),
//                       (SELECT  CURDATE()) ,
//                    '".$plage."',
//                    (select idMachine from  machines limit 1)
//                )");
//}
//
//$db->exec("INSERT INTO reservations(Utilisateurs_idUtilisateur, Date, Plage,
//                          Machines_idMachine)
//        VALUES (
//                   (select idUtilisateur from utilisateurs limit 1),
//                       (SELECT  DATE_ADD(CURDATE(), INTERVAL 1 DAY)) ,
//                    '".$plagesarray(0)."',
//                    (select idMachine from  machines limit 1)
//                )");
