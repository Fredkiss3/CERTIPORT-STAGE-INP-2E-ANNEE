<?php
//
//
//$array = [1,2,3,4,5,6,7];
//$a2 = [];
//
//$a2 = array_splice($array, array_search(4, $array));
//
//print_r($a2);
//print_r($array);
//function getPDO( ) {
//
//    try {
//        $db = new PDO('mysql:host=localhost;dbname=mydb', 'root', '', [
//            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
//        ]);
//        return $db;
//    } catch (Exception $e) {
//        die("Erreur  : ".$e->getMessage());
//    }
//}
//
//$idUser = 137;
//
//
//$db = getPDO();
//$st= $db->prepare("SELECT count(*) as c from reservations as re
//                                        where re.Date=CURRENT_DATE() and re.Utilisateurs_idUtilisateur=?
//                                           ");
//
//$st->execute([$idUser,]);
//
//print_r($st->fetch());
////die($idUser);
//
//
//// Récupérer l'objet PDO
//$db = getPDO();
//
//$st = $db->prepare("SELECT CURRENT_TIME() > TIME_FORMAT(CURRENT_TIME() , \"%H:01:%s\") as next");
//$st->execute();
//
//$next = $st->fetch()["next"];
//
//$format = $next.":00:00";
//
//$st = $db->prepare("SELECT TIME_FORMAT((SELECT ADDTIME(CURRENT_TIME(), ?)), \"%Hh01\") as current_plage;");
//
////var_dump($st);
//$st->execute([$format]);
//
//$plage_debut = $st->fetch();
////
////print_r($next);
////echo (int)(date("G")) + (int) $next["next"] + 1;
////print_r($plage_debut);
//
//$end = (int)(date("G")) + (int) $next + 1;
//
//$plage = $plage_debut["current_plage"] ."-".$end."h";
//
//echo $plage;
//
//define("PLAGES",  [
//    "8h01-9h",
//    "9h01-10h",
//    "10h01-11h",
//    "11h01-12h",
//    "12h01-13h",
//    "13h01-14h",
//    "14h01-15h",
//    "15h01-16h",
//]);
//
//
//
//$pl = PLAGES[0];
//$pieces = explode("-", $pl);
//
//$pld = $pieces[0];
//
//print_r($pieces);
//
//echo $pld;
//
//$pieces = explode("h", $pld);
//
//print_r($pieces);
//
//$hd = $pieces[0];
//
//echo $hd;

$request_uri = explode( "/", "/res_stage/login");

//unset($request_uri[0]);

print_r($request_uri);
$request_uri = explode( "/", "/login");

unset($request_uri[0]);
var_dump(array_search("", $request_uri));

//echo $request_uri[1];
//print_r($request_uri);
var_dump(null or 5);

$ar = array(
    "fred"=> 56,
    "freddy"
);

var_dump($ar);

$ar = 0;

var_dump($ar);
