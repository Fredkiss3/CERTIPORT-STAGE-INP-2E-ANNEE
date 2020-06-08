<?php

/**
 * A Compatibility library with PHP 5.5's simplified password hashing API.
 *
 * @author Anthony Ferrara <ircmaxell@php.net>
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2012 The Authors
 */

if (!defined('PASSWORD_BCRYPT')) {

    define('PASSWORD_BCRYPT', 1);
    define('PASSWORD_DEFAULT', PASSWORD_BCRYPT);
    http://polytech.inphb.ci/V007/assets/accueil/img/home.png
    if (version_compare(PHP_VERSION, '5.3.7', '<')) {
        define('PASSWORD_PREFIX', '$2a$');
    } else {

        define('PASSWORD_PREFIX', '$2y$');
    }

    /**
     * Hash the password using the specified algorithm
     *
     * @param string $password The password to hash
     * @param int $algo The algorithm to use (Defined by PASSWORD_* constants)
     * @param array $options The options for the algorithm to use
     *
     * @return string|false The hashed password, or false on error.
     */
    function password_hash($password, $algo, array $options = array())
    {
        if (!function_exists('crypt')) {
            trigger_error("Crypt must be loaded for password_hash to function", E_USER_WARNING);
            return null;
        }
        if (!is_string($password)) {
            trigger_error("password_hash(): Password must be a string", E_USER_WARNING);
            return null;
        }
        if (!is_int($algo)) {
            trigger_error("password_hash() expects parameter 2 to be long, " . gettype($algo) . " given", E_USER_WARNING);
            return null;
        }
        switch ($algo) {
            case PASSWORD_BCRYPT:
                // Note that this is a C constant, but not exposed to PHP, so we don't define it here.
                $cost = 10;
                if (isset($options['cost'])) {
                    $cost = $options['cost'];
                    if ($cost < 4 || $cost > 31) {
                        trigger_error(sprintf("password_hash(): Invalid bcrypt cost parameter specified: %d", $cost), E_USER_WARNING);
                        return null;
                    }
                }
                $required_salt_len = 22;
                $hash_format = sprintf("%s%02d$", PASSWORD_PREFIX, $cost);
                break;
            default:
                trigger_error(sprintf("password_hash(): Unknown password hashing algorithm: %s", $algo), E_USER_WARNING);
                return null;
        }
        if (isset($options['salt'])) {
            switch (gettype($options['salt'])) {
                case 'NULL':
                case 'boolean':
                case 'integer':
                case 'double':
                case 'string':
                    $salt = (string)$options['salt'];
                    break;
                case 'object':
                    if (method_exists($options['salt'], '__tostring')) {
                        $salt = (string)$options['salt'];
                        break;
                    }
                case 'array':
                case 'resource':
                default:
                    trigger_error('password_hash(): Non-string salt parameter supplied', E_USER_WARNING);
                    return null;
            }
            if (strlen($salt) < $required_salt_len) {
                trigger_error(sprintf("password_hash(): Provided salt is too short: %d expecting %d", strlen($salt), $required_salt_len), E_USER_WARNING);
                return null;
            } elseif (0 == preg_match('#^[a-zA-Z0-9./]+$#D', $salt)) {
                $salt = str_replace('+', '.', base64_encode($salt));
            }
        } else {
            $buffer = '';
            $raw_length = (int)($required_salt_len * 3 / 4 + 1);
            $buffer_valid = false;
            if (function_exists('mcrypt_create_iv') && !defined('PHALANGER')) {
                $buffer = mcrypt_create_iv($raw_length, MCRYPT_DEV_URANDOM);
                if ($buffer) {
                    $buffer_valid = true;
                }
            }
            if (!$buffer_valid && function_exists('openssl_random_pseudo_bytes')) {
                $buffer = openssl_random_pseudo_bytes($raw_length);
                if ($buffer) {
                    $buffer_valid = true;
                }
            }
            if (!$buffer_valid && is_readable('/dev/urandom')) {
                $f = fopen('/dev/urandom', 'r');
                $read = strlen($buffer);
                while ($read < $raw_length) {
                    $buffer .= fread($f, $raw_length - $read);
                    $read = strlen($buffer);
                }
                fclose($f);
                if ($read >= $raw_length) {
                    $buffer_valid = true;
                }
            }
            if (!$buffer_valid || strlen($buffer) < $raw_length) {
                $bl = strlen($buffer);
                for ($i = 0; $i < $raw_length; $i++) {
                    if ($i < $bl) {
                        $buffer[$i] = $buffer[$i] ^ chr(mt_rand(0, 255));
                    } else {
                        $buffer .= chr(mt_rand(0, 255));
                    }
                }
            }
            $salt = str_replace('+', '.', base64_encode($buffer));

        }
        $salt = substr($salt, 0, $required_salt_len);

        $hash = $hash_format . $salt;

        $ret = crypt($password, $hash);

        if (!is_string($ret) || strlen($ret) <= 13) {
            return false;
        }

        return $ret;
    }

    /**
     * Get information about the password hash. Returns an array of the information
     * that was used to generate the password hash.
     *
     * array(
     *    'algo' => 1,
     *    'algoName' => 'bcrypt',
     *    'options' => array(
     *        'cost' => 10,
     *    ),
     * )
     *
     * @param string $hash The password hash to extract info from
     *
     * @return array The array of information about the hash.
     */
    function password_get_info($hash)
    {
        $return = array(
            'algo' => 0,
            'algoName' => 'unknown',
            'options' => array(),
        );
        if (substr($hash, 0, 4) == PASSWORD_PREFIX && strlen($hash) == 60) {
            $return['algo'] = PASSWORD_BCRYPT;
            $return['algoName'] = 'bcrypt';
            list($cost) = sscanf($hash, PASSWORD_PREFIX . "%d$");
            $return['options']['cost'] = $cost;
        }
        return $return;
    }

    /**
     * Determine if the password hash needs to be rehashed according to the options provided
     *
     * If the answer is true, after validating the password using password_verify, rehash it.
     *
     * @param string $hash The hash to test
     * @param int $algo The algorithm used for new password hashes
     * @param array $options The options array passed to password_hash
     *
     * @return boolean True if the password needs to be rehashed.
     */
    function password_needs_rehash($hash, $algo, array $options = array())
    {
        $info = password_get_info($hash);
        if ($info['algo'] != $algo) {
            return true;
        }
        switch ($algo) {
            case PASSWORD_BCRYPT:
                $cost = isset($options['cost']) ? $options['cost'] : 10;
                if ($cost != $info['options']['cost']) {
                    return true;
                }
                break;
        }
        return false;
    }

    /**
     * Verify a password against a hash using a timing attack resistant approach
     *
     * @param string $password The password to verify
     * @param string $hash The hash to verify against
     *
     * @return boolean If the password matches the hash
     */
    function password_verify($password, $hash)
    {
        if (!function_exists('crypt')) {
            trigger_error("Crypt must be loaded for password_verify to function", E_USER_WARNING);
            return false;
        }
        $ret = crypt($password, $hash);
        if (!is_string($ret) || strlen($ret) != strlen($hash) || strlen($ret) <= 13) {
            return false;
        }

        $status = 0;
        for ($i = 0; $i < strlen($ret); $i++) {
            $status |= (ord($ret[$i]) ^ ord($hash[$i]));
        }

        return $status === 0;
    }
}

// Récupérer l'url de base
function getBaseUrl()
{
    $location = explode("/", $_SERVER["SCRIPT_NAME"]);
    $base_url_index = array_search("index.php", $location);

    unset($location[$base_url_index]);

    $base_url = join("/", $location);
    return $_SERVER["HTTP_HOST"] . $base_url;
}

// Connecter l'utilisateur
function login_user($matri, $password)
{
    $db = getPDO();

    $st = $db->prepare("SELECT idUtilisateur, Nom, MotDePass, Matricule, NiveauAcces, StatutCompte from `utilisateurs` where Matricule=?");

    if ($st->execute(array(htmlspecialchars($matri))
    )) {
        $row = $st->fetch();

//          dd($matri);

        if (!$row) {
            $_SESSION["error"] = "Ce matricule n'existe pas dans la base de données !";
            return false;
        } else {
            if ($row["StatutCompte"] == -1) {
                $_SESSION["msg"] = "Ce matricule n'a pas encore été enregistré.";
                $_SESSION["matricule"] = $matri;
                return false;
            } elseif ($row["StatutCompte"] == 1) {
                if (password_verify($password, $row["MotDePass"])) {
                    logout_user();
                    create_session($row["idUtilisateur"], $row["Nom"], $row["Matricule"], $row["NiveauAcces"]);
                    return true;
                } else {
                    $_SESSION["error"] = "Matricule ou mot de passe incorrect !";
                    return false;
                }
            } else {
                $_SESSION["error"] = "Désolé, votre compte a été bloqué. 
                veuillez contacter l'administrateur pour débloquer votre compte.";
                return false;
            }
        }
    }
    return false;
}

// Créer la session
function create_session($uid, $name, $matri, $niveauAccess)
{
    $_SESSION["uid"] = $uid;
    $_SESSION["name"] = $name;
    $_SESSION["matri"] = $matri;
    $_SESSION["niveau_acces"] = $niveauAccess;

    if ($niveauAccess == 0) {
        $title = "Membre de l'INP-HB";
    } elseif ($niveauAccess == 1) {
        $title = "Surveillant";
    } else {
        $title = "Administrateur";
    }

    $_SESSION["title"] = $title;
}

// Déconnecter l'utilisateur
function logout_user()
{
    destroy_session();
    session_start();
}

// Détruire la session
function destroy_session()
{
    session_destroy();
}

//Ajouter un surveillant
function f_remove_surveillant($id)
{
    $db = getPDO();

    // Vérifier qu'il n'a pas d'étudiant associé à se compte, si non -> bloquer
    $st = $db->prepare("SELECT  u.idUtilisateur from utilisateurs as u, etudiants as e 
                                    where u.idUtilisateur=(SELECT Utilisateurs_idUtilisateur from `surveillants` where idSurveillant=?)
                                     and u.idUtilisateur=e.Utilisateurs_idUtilisateur");
    $active = 0;
    if ($st->execute(array($id,))) {
        $active = (count($st->fetchAll()) > 0) ? 1 : 0;
    }

    // désactiver le compte
    $st = $db->prepare("UPDATE `utilisateurs` set NiveauAcces=0, StatutCompte=? 
                                    where idUtilisateur=
                                          (SELECT Utilisateurs_idUtilisateur from `surveillants` where idSurveillant=?)");

    if ($st->execute(array($active, $id,))) {
        // return true ?
        redirect(url("admin/accounts.php"));
    } else {
        $_SESSION["error"] = "Modification des accès non effectuée,
         veuillez contacter l'administrateur du site si cette erreur persiste.";
        redirect(url("admin/accounts.php"));
    }
}

// Remettre le surveillant
function f_reset_surveillant($id)
{
    $db = getPDO();

    $st = $db->prepare("UPDATE `utilisateurs` set NiveauAcces=1, StatutCompte=1 
                                    where idUtilisateur=
                                          (SELECT Utilisateurs_idUtilisateur from `surveillants` where idSurveillant=?)");
    if ($st->execute(array($id,))) {
        // return true ?
        redirect(url("admin/accounts.php"));
    } else {
        $_SESSION["error"] = "Modification des accès non effectuée";
        redirect(url("admin/accounts.php"));
    }
}

// Fontion pour vérifier le hash csrf
if (!function_exists('hash_equals')) {
    function hash_equals($str1, $str2)
    {
        if (strlen($str1) != strlen($str2)) {
            return false;
        } else {
            $res = $str1 ^ $str2;
            $ret = 0;
            for ($i = strlen($res) - 1; $i >= 0; $i--) $ret |= ord($res[$i]);
            return !$ret;
        }
    }
}

// Fonction de redirection
function redirect($url)
{
    echo "<script type='text/javascript'>document.location.href = '" . $url . "';</script>";
    exit();
}

// Fonction qui redirige l'utilisateur vers la page 'Connexion'
// lorsque celui-ci n'est pas connecté
function login_required($next = null)
{
    if ((
        !empty($_SESSION["uid"]) and
        !empty($_SESSION["name"]) and
        !empty($_SESSION["title"]) and
        !empty($_SESSION["matri"]) and
        isset($_SESSION["niveau_acces"])
    )) {
        // si le nombre de réservations n'a pas été respecté (2 réservations non venus)
        if ($_SESSION["niveau_acces"] < 2) {
            if (get_nbre_reserve_non_respecte($_SESSION["uid"]) >= 2) {
                f_lock_account($_SESSION["uid"]);
            }
        }
        $st = get_user_if_alive($_SESSION["uid"]);
        if ($st["NiveauAcces"] == $_SESSION["niveau_acces"]) {
            return;
        };
    }
    redirect(url("connectivity/login.php") . ("?next=" . ($next === null ? "" : $next)));
}

// Récupérer le token csrf
function get_token()
{
    return $_SESSION['token'];
}

// Générer le token csrf
function set_csrf_token()
{
    //Generate a secure token using openssl_random_pseudo_bytes.
    $myToken = bin2hex(openssl_random_pseudo_bytes(24));
    //Store the token as a session variable.
    $_SESSION['token'] = $myToken;
}

// Vérifier si l'utilisateur a accès à cette page
function check_access($level, $next = null, $msg = "Vous n'êtes pas autorisé à accéder à cette page")
{
    // Doit être connecté
    login_required($next);

    if (!((int)$_SESSION["niveau_acces"] >= $level)) {
        $_SESSION["error"] = $msg;
        redirect(url("connectivity/login.php"));
    }
}

// Récupérer tous les matricules (Ajout d'un surveillant)
function get_all_matri()
{
    $db = getPDO();

    $st = $db->prepare("SELECT idUtilisateur, Matricule, Nom from `utilisateurs` where NiveauAcces < 1");

    $rows = array();
    if ($st->execute()) {
        $rows = $st->fetchAll();
    }

    return $rows;
}

// Récupérer tous les sites
function get_all_sites()
{
    $db = getPDO();

    $st = $db->prepare("SELECT * from `sites`");

    $rows = array();
    if ($st->execute()) {
        $rows = $st->fetchAll();
    }

    return $rows;
}

// Récupérer toutes les salles
function get_all_Salles()
{
    $db = getPDO();
    $st = $db->prepare("SELECT idSite, NomSite from `sites`");
    $rows = array();
    if ($st->execute()) {
        $rows = $st->fetchAll();
    }

    foreach ($rows as &$row) {

        // Récupérer toutes les salles
        $st = $db->prepare("SELECT idSalle, NumSalle from `salles` where Sites_idSite=? order by NumSalle");
        $salles = array();

        if ($st->execute(array($row["idSite"]))) {
            if ($st->execute(array($row["idSite"]))) {
                $salles = $st->fetchAll();
            }
            $row["salles"] = $salles;
        }
    }
    return $rows;
}

function generateRandomString($length = 8) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

// Ajouter un surveillant
function f_add_surveillant($idUser, $idSalle)
{
    $db = getPDO();
    $msg = "";

    // Vérifier si le surveillant ne surveille pas déjà une salle
    $st = $db->prepare("SELECT Utilisateurs_idUtilisateur from `surveillants` where Utilisateurs_idUtilisateur=? ");

    if ($st->execute(array($idUser,))) {
        // dd($rows);
        if ($st->fetch()) {
            return "Ce surveillant est déjà affecté à une salle";
        }
    }

    // Ajouter le surveillant
    $st = $db->prepare("INSERT INTO `surveillants`(Salles_idSalle, Utilisateurs_idUtilisateur) values (?, ?)");
    $added = $st->execute(array($idSalle, $idUser));

    $st = $db->prepare("SELECT * FROM utilisateurs where idUtilisateur=?");
    $st->execute(array($idUser));

    $user = $st->fetch();
    if (!($user["MotDePass"])) {
        $mdp = generateRandomString();
        // générer un mot de passe pour le nouveau surveillant (s'il n'en a pas)
        $st = $db->prepare("UPDATE `utilisateurs` SET `utilisateurs`.MotDePass=? where idUtilisateur=?");
        $st->execute(array(password_hash($mdp, PASSWORD_BCRYPT), $idUser));
        $msg = "Le mot de passe qui sera associé au compte <b>" . $user["Nom"] .
            "</b><br> est : <b>" . $mdp . "</b> <br> Notez le bien !";
    }

    if ($added) {
        $st = $db->prepare("UPDATE `utilisateurs` SET `utilisateurs`.`NiveauAcces`=1, StatutCompte=1 
                                        WHERE `utilisateurs`.`idUtilisateur`=?");
        $added = $st->execute(array($idUser,));
        // dd($added);
    }

    return array(
        "error" => ($added == true) ? "" : "Erreur : surveillant non ajouté !",
        "msg" => $msg,
    );
}

// Récupérer tous les surveillants
function get_all_surv()
{
    $db = getPDO();

    $st = $db->prepare("SELECT u.Matricule, u.Nom, su.Salles_idSalle, su.idSurveillant, u.NiveauAcces 
                                    FROM `surveillants` as su, utilisateurs as u 
                                        where u.idUtilisateur=su.Utilisateurs_idUtilisateur ORDER BY u.Matricule");

    if ($st->execute()) {
        $rows = $st->fetchAll();
        // dd($rows);
        foreach ($rows as &$row) {
            $st = $db->prepare("SELECT sa.NumSalle, si.NomSite,sa.idSalle from salles as sa, sites as si
                                        where sa.idSalle=? and si.idSite=sa.Sites_idSite");

            if ($st->execute(array($row["Salles_idSalle"]))) {
                $attr = $st->fetchAll();
                foreach ($attr as $a) {
                    $row["NumSalle"] = $a["NumSalle"];
                    $row["NomSite"] = $a["NomSite"];
                }
            }
        }

        // dd($rsows);
        return $rows;
    } else {
        throw new Exception("ERROR");
    }
}

// Récupérer tous les étudiants
function get_all_students()
{
    $db = getPDO();
    $st = $db->prepare("SELECT u.Matricule, u.StatutCompte, u.idUtilisateur, u.Nom, e.idEtudiant 
                            FROM etudiants as e, utilisateurs as u 
                                where e.Utilisateurs_idUtilisateur=u.idUtilisateur");
    $rows = array();

    if ($st->execute()) {
        $rows = $st->fetchAll();
    }
    foreach ($rows as $i => $row) {
        // Si le compte est bloqué
        // Indiquer que le statut du compte est à zéro
        if (compte_bloque($row["idUtilisateur"])) {
            $rows[$i]["StatutCompte"] = 0;
        }
    }

    return $rows;
}

// Générer l'input csrf
function csrf()
{
    set_csrf_token();
    return "<input type=\"hidden\" id='csrftoken' name=\"_token\" value='" . get_token() . "'>";
}

// Générer l'input 'action'
function action_input($action)
{
    return "<input type=\"hidden\" id=\"action\" name=\"action\" value='" . $action . "'>";
}

function param_input($name, $value)
{
    return "<input type=\"hidden\" name=\"" . $name . "\" value='" . $value . "'>";
}

/**
 *  Récuperer le contenu d'une vue
 * @param $view_path : le chemin de la vue
 * @param $params : les paramètres passés à l'url
 */
function launch($view_path, $params = null)
{
    // La vue
    $v = $view_path;

    if (!is_ajax()) {
        // La vue
        ob_start();
        require $v;
        $content = ob_get_clean();
        require "layouts/default.php";
    } else {
        require $v;
    }
}

function endsWith($string, $endString)
{
    $len = strlen($endString);
    if ($len == 0) {
        return true;
    }
    return (substr($string, -$len) === $endString);
}

// Le chemin des urls
function url($path)
{
    if ($path === "/") {
        return "../../views/";
    }
    return "../../views/" . $path;
}

// le chemin des fichiers statiques
function static_($path)
{
    return "../../assets/" . $path;
}

// Vérifier qu'un serveillant existe
function verify_surv_id($id)
{
    $db = getPDO();
    $st = $db->prepare("SELECT * from `surveillants` as su, utilisateurs as u 
                        where su.idSurveillant=? 
                          and su.Utilisateurs_idUtilisateur=u.idUtilisateur 
                          ");

    if ($st->execute(array($id,))) {
        $rows = $st->fetchAll();
        if (count($rows) > 0) {
            return $rows[0];
        }
    }

    return false;
}

// Récupérer les données d'un user dont le compte est non bloqué
function get_user_if_alive($id)
{
    $db = getPDO();
    $st = $db->prepare("SELECT * from `utilisateurs` where idUtilisateur=? and StatutCompte=1");

    if ($st->execute(array($id,))) {
        $row = $st->fetch();

        if ($row)
            return $row;
    }

    return false;
}

// Récupérer les données d'un user dont le compte est bloqué
function get_user_if_dead($id)
{
    $db = getPDO();
    $st = $db->prepare("SELECT * from `utilisateurs` where idUtilisateur=? and StatutCompte=0");

    if ($st->execute(array($id))) {
        $rows = $st->fetchAll();

        if (count($rows) > 0)
            return $rows[0];
    }

    return false;
}

// Bloquer un compte
function f_lock_account($id)
{
    $db = getPDO();

    $st = $db->prepare("UPDATE utilisateurs set StatutCompte=0 where idUtilisateur=?");

    if ($st->execute(array($id))) {
        // Annuler toutes les réservations de l'étudiant qui n'ont pas été notées
        $res = get_user_reservations($id);

        foreach ($res as $re) {
            f_cancel_reservation($re["idResult"], false);
        }


        if ($id == $_SESSION["uid"]) {
            logout_user();
        }
        return true;
    }
    return false;
}

// Débloquer un compte
function f_unlock_account($id)
{
    $db = getPDO();

    $st = $db->prepare("UPDATE utilisateurs set StatutCompte=1 where idUtilisateur=?");

    if ($st->execute(array($id))) {
        return true;
    }

    return false;
}

// Vérifier si la requête est ajax
function is_ajax()
{
    return (!empty($_SERVER['HTTP_X_REQUESTED_WITH'])
        and strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest');
}

// Récupérer les machines occupées
function get_nb_machines_oqp($idSite)
{
    $db = getPDO();

    $plages = array("8h01-9h",
        "9h01-10h",
        "10h01-11h",
        "11h01-12h",
        "12h01-13h",
        "13h01-14h",
        "14h01-15h",
        "15h01-16h"
    );
    // Les plages horaires
    $st = $db->prepare("SELECT * FROM machines as m, salles as sa, sites as si  
            where si.idSite=? and sa.Sites_idSite=si.idSite and m.Salles_idSalle=sa.idSalle");

    if ($st->execute(array($idSite))) {
        $machines = $st->fetchAll();

        // OCCUPES & LIBRES
        $oqp = 0;
        $free = count($machines);
        foreach ($machines as $m) {
            $st = $db->prepare("SELECT re.Plage, m.NumMachine FROM machines as m, reservations as re 
                                where re.Machines_idMachine=? 
                                  and re.Machines_idMachine=m.idMachine
                                           and re.Date=(SELECT CURDATE())");

            if ($st->execute(array($m["idMachine"]))) {
                if (count($st->fetchAll()) >= count($plages)) {
                    $oqp++;
                    $free--;
                }
            }
        }

        return json_encode(array('free' => $free, 'busy' => $oqp));
    }

    return json_encode(array('free' => 0, 'busy' => 0));
}

function startsWith($haystack, $needle)
{
    $length = strlen($needle);
    return (substr($haystack, 0, $length) === $needle);
}


function get_current_plage()
{
    $db = getPDO();
    // récupérer l'écart d'heure
    // Si elle est la suivante (= 1)
    $st = $db->prepare("SELECT CURRENT_TIME() > TIME_FORMAT(CURRENT_TIME() , \"%H:01:%s\") as next");
    $st->execute();

    $next = $st->fetch();
    $next = $next["next"];

    // Formatter le temps
    $format = $next . ":00:00";

    // récupérer le temps courant
    $st = $db->prepare("SELECT TIME_FORMAT((SELECT ADDTIME(CURRENT_TIME(), ?)), \"%Hh01\") as current_plage;");

    $st->execute(array($format));

    $plage_debut = $st->fetch();

    // Ajouter un zéro si xh1 => xh01
    $plage_debut["current_plage"]  = (substr($plage_debut["current_plage"], 0, 1) == "0") ? (substr($plage_debut["current_plage"], 1)): $plage_debut["current_plage"] ;

    // récupérer l'heure courante
    $st = $db->prepare("SELECT TIME_FORMAT(CURRENT_TIME(), '%H') as my_time;");
    $st->execute();
    
    // stockage dans une variable intermédiaire
    $my_time = $st->fetch();
    $my_time = $my_time["my_time"]; 

    // Calcul de la plage de fin
    $plage_end = (int)($my_time) + (int)$next + 1;

    $plage = $plage_debut["current_plage"] . "-" . $plage_end . "h";

    return $plage;
}

// Récupérer les machines disponibles pour la salle et le jour
function f_get_machines($idSalle, $day)
{
    $data = null;
    $msg = "";
    $can = false;
    $error = false;
    if (!salles_fermees() and can_reserve() and !max_reserve_atteint()) {
        $db = getPDO();

        // Récupérer la plage courante
        $current_plage = get_current_plage();
        $plages = array("8h01-9h",
            "9h01-10h",
            "10h01-11h",
            "11h01-12h",
            "12h01-13h",
            "13h01-14h",
            "14h01-15h",
            "15h01-16h");

        if ($day == 0) {
            $plages = array_splice($plages, array_search($current_plage, $plages));
        }

        // Récupérer toutes les machines de la salle choisie
        $st = $db->prepare("SELECT m.idMachine, m.NumMachine from machines as m 
                                 where m.Salles_idSalle=?");

        if ($st->execute(array($idSalle))) {
            $machines = $st->fetchAll();

            foreach ($machines as $m => $val) {
                $busy = array();

                // Ajouter les plages
                $machines[$m]["dispos"] = $plages;

                // Récupérer les réservations de chaque machine
                $st = $db->prepare("SELECT re.Machines_idMachine, re.Plage from reservations as re 
                                            where re.Date=DATE_ADD(CURDATE(), INTERVAL :days DAY) 
                                            and re.Machines_idMachine=:idMachine");

                if ($st->execute(array(
                    "days" => $day,
                    "idMachine" => $val["idMachine"]
                ))) {

                    $res = $st->fetchAll();

                    foreach ($res as $r) {
                        // Retirer la plage horaire
                        $index = array_search($r["Plage"], $machines[$m]["dispos"]);
                        array_splice($machines[$m]["dispos"], $index, 1);
                        if (count($machines[$m]["dispos"]) === 0) {
                            $busy[] = array_search($machines[$m], $machines);
                        }
                    }
                }

            }

            foreach ($busy as $b) {
                unset($machines[$b]);
            }
            $data = $machines;
            $can = true;
        }
    } elseif (salles_fermees()) {
        $error = true;
        $msg = "Vous ne pouvez plus réserver car les salles sont fermées";
    } elseif (can_reserve()) {
        $msg = "Vous ne pouvez pas réserver pour l'instant, veuillez attendre " . lastReserveTimeRemaining();
    } elseif (max_reserve_atteint()) {
        $msg = "Vous avez atteint votre maximum de réservations pour aujourd'hui.";
    }

    return json_encode(array(
        "error" => $error,
        "can" => $can,
        "msg" => $msg,
        "data" => $data
    ));
}

// Récupérer la plage
function get_time_from_plage($pl)
{
    if (preg_match('/\d+/', $pl, $ar)) {
        return (int)($ar[0]);
    } else {
        return 0;
    }
}

// Réserver une machine
function f_reserver_machine($idMachine, $plage, $interval)
{
    $error = true;
    $msg = "Erreur !";
    $can = true;

    if (!salles_fermees()) {
        if (can_reserve()) {
            // Récupérer la plage courante
            $plages = array("8h01-9h",
                "9h01-10h",
                "10h01-11h",
                "11h01-12h",
                "12h01-13h",
                "13h01-14h",
                "14h01-15h",
                "15h01-16h");
            $plages = array_splice($plages, array_search(get_current_plage(), $plages));

            if (!(!array_search($plage, $plages) and !($interval >= 0 and $interval <= 1))) {
                $db = getPDO();

                $st = $db->prepare("SELECT * from reservations as re 
                                        where re.Date=DATE_ADD(
                                                    CURRENT_DATE(), 
                                                    INTERVAL :i DAY
                                                ) and re.Plage=:plage
                                        and re.Machines_idMachine=:idMachine
                                        ");

                if ($st->execute(array(
                    'idMachine' => $idMachine,
                    'i' => $interval,
                    'plage' => $plage
                ))) {
                    if (count($st->fetchAll()) > 0) {
                        $msg = "Cette machine a déjà été réservée";
                    } else {
                        $st = $db->prepare("INSERT INTO reservations(Date, Plage, Utilisateurs_idUtilisateur, Machines_idMachine, madeAt)
                                        VALUES (
                                                DATE_ADD(NOW(), INTERVAL :i DAY),
                                                :plage,
                                                :uid,
                                                :idMachine, 
                                                CURRENT_TIME()
                                        ) ");

                        if ($st->execute(array(
                            'idMachine' => $idMachine,
                            'i' => $interval,
                            'plage' => $plage,
                            'uid' => $_SESSION["uid"]
                        ))) {
                            $id = $db->lastInsertId();
                            $st = $db->prepare("SELECT re.Plage, m.NumMachine from reservations as re, machines as m
                              where re.idResult =? 
                                and re.Machines_idMachine=m.idMachine
                            ");
                            $error = false;

                            if ($st->execute(array($id))) {
                                $can = false;
                                $row = $st->fetch();
                                $msg = "Vous venez de réserver la Machine "
                                    . $row["NumMachine"] .
                                    " Pour " . ($interval === 1 ? " Demain" : " Aujourd'hui") .
                                    " Pour la plage horaire : <b>" .
                                    $row["Plage"] .
                                    "</b> Revenez dans <b>2 heures</b>
                                              pour refaire une nouvelle réservation.";

                                if (max_reserve_atteint()) {
                                    $msg = "Vous avez atteint votre nombre maximal de réservations pour aujourd'hui,
                                     Revenez demain.";
                                }
                            }
                        }
                    }
                }

            } else {
                $msg = "Format de données incorrect !";
            }
        }
    } else {
        $error = false;
        $can = false;
        $msg = "Vous ne pouvez plus réserver car les salles sont fermées.";
    }

    return json_encode(array("error" => $error, "msg" => $msg, "can_reserve" => $can));
}

// Dump and die
function dd($var)
{
    echo "<pre>";
    echo "<div style='
    display: inline-block;
    padding: 1.5rem;
    background-color: #0e2e42;
    color: #00e25b;
'>";
    print_r($var);
    echo "</div>";
    echo "</pre>";
    die();
}

// si les salles sont fermees
function salles_fermees()
{
    $db = getPDO();
    $st = $db->prepare(
        "SELECT CURRENT_TIME() < '15:01:00' and CURRENT_TIME() >= '07:01:00' as salles_ouvertes");
    $st->execute();
    $row = $st->fetch();

    //    dd($row);
    return $row["salles_ouvertes"] !== '1';
}

// L'utilisateur peut-il réserver maintenant ?
function can_reserve()
{
    $idUser = $_SESSION["uid"];

    $db = getPDO();
    $can_reserve = true;

    // Récupérer la dernière réservation de l'utilisateur pour aujourd'hui & demain
    $st = $db->prepare("SELECT  re.idResult, re.Plage, re.madeAt from reservations as re 
                                    where re.Utilisateurs_idUtilisateur=? 
                                        and re.Date >= CURRENT_DATE() 
                                            ORDER BY re.idResult DESC LIMIT 1");

    $st->execute(array($idUser));
    $lastReserve = $st->fetch();

    if ($lastReserve) {
        $st = $db->prepare("SELECT TIME_FORMAT(TIMEDIFF(CURRENT_TIME(), ?), '%H') as timedif");
        $st->execute(array($lastReserve["madeAt"]));
        $timedif = $st->fetch();
        $timedif = abs((int)$timedif["timedif"]);
        $can_reserve = $timedif >= 2;
    }

    return $can_reserve;
}

// Récupérer toutes les réservations d'un utilisateur (pour aujourd'hui)
function get_reservations()
{
    $idUser = $_SESSION["uid"];

    $db = getPDO();
    $st = $db->prepare("SELECT * from reservations 
                                    where Utilisateurs_idUtilisateur=?
                                    and Date >= CURRENT_DATE()");

    $st->execute(array($idUser));
    return $st->fetchAll();
}

// L'utilisateur a-t-il atteint son maximum de réservations ?
function max_reserve_atteint()
{
    $idUser = $_SESSION["uid"];

    $db = getPDO();
    $st = $db->prepare("SELECT count(*) as c from reservations as re
                                        where re.Date >= CURRENT_DATE()
                                          and re.Utilisateurs_idUtilisateur=?");

    $st->execute(array($idUser));

    $c = $st->fetch();
    $c = $c["c"];
    return (int)$c >= 2;
}

function get_nbre_reserve_non_respecte($idUser)
{
    $db = getPDO();

    // Le
    $st = $db->prepare("SELECT re.Plage, DATEDIFF(NOW(), re.Date) as datedif  from reservations as re
                                        where re.Absence=1
                                          and re.Date <= NOW() 
                                          and re.Utilisateurs_idUtilisateur=?");


    $st->execute(array($idUser));
    $res = $st->fetchAll();

    $count = 0;
    foreach ($res as $r) {
        // la différence de date
        $datedif = $r["datedif"];

        // Si la différence de date est supérieure à 0
        // (Hier ou avant-hier), veiller à compter le nombre
        // de fois où il n'a pas été absent
        if ($datedif < 1) {
            // le temps de la plage
            $time = get_time_from_plage($r["Plage"]);

            // le temps actuel
            $plage = get_time_from_plage(get_current_plage());

//            dd(array($plage, $time));
            if (($plage - $time) >= 2) {
                $count++;
            }
        } else {
            $count++;
        }
    }

//    dd($count);

    return $count;
}

// récupérer le temps restant pour la dernière réservation
function lastReserveTimeRemaining()
{
    $idUser = $_SESSION["uid"];

    $db = getPDO();
    $time_remaining = "00:00:00";

    // Récupérer la dernière réservation de l'utilisateur pour aujourd'hui & demain
    $st = $db->prepare("SELECT  re.idResult, re.Plage, re.madeAt from reservations as re 
                                    where re.Utilisateurs_idUtilisateur=? 
                                        and re.Date >= CURRENT_DATE()
                                            ORDER BY re.idResult DESC LIMIT 1");

    $st->execute(array($idUser));
    $lastReserve = $st->fetch();

    if ($lastReserve) {
        $st = $db->prepare("SELECT TIME_FORMAT(TIMEDIFF((SELECT ADDTIME(?, \"2:00:00\")), CURRENT_TIME()), '%H:%i:%s')  as time_remaining");
        $st->execute(array($lastReserve["madeAt"]));
        $el = $st->fetch();
        $time_remaining = $el["time_remaining"];
    }

    return $time_remaining;
}

// Le compte est-il bloqué ?
function compte_bloque($idUser)
{
    if (get_nbre_reserve_non_respecte($idUser) >= 2) {
        f_lock_account($idUser);
        return true;
    }

    return false;
}

function f_register_etape_1($matricule, $mail)
{
    $db = getPDO();
    $error = true;
    $msg = "Erreur !";
    $data = array();
    $is_registered = false;
    $matricule = strtoupper(htmlspecialchars($matricule));
    $mail = htmlspecialchars($mail);

    if (!empty($matricule) AND !empty($mail)) {
        try {
            # Vérifier que l'étudiant n'existe pas déjà
            $req = $db->prepare('SELECT * FROM super_administrateur WHERE Utilisateurs_idUtilisateur=
                              (SELECT idUtilisateur from utilisateurs where Matricule=:matri)');

            $req->execute(array(
                'matri' => $matricule,
            ));

            $verif_ad = $req->fetch();
            if ($verif_ad) {
                $msg = "Ce matricule ne peut s'inscrire en tant qu'étudiant.";
            } else {

                # Vérifier que l'étudiant n'existe pas déjà
                $req = $db->prepare('SELECT * FROM etudiants as e, utilisateurs as u 
                                                WHERE e.Utilisateurs_idUtilisateur=u.idUtilisateur 
                                                    AND u.Matricule=:matri');
                $req->execute(array(
                    'matri' => $matricule,
                ));

                $verif_et = $req->fetch();

                if ($verif_et) {
                    $is_registered = true;
                    $req = $db->prepare('SELECT * FROM utilisateurs WHERE Matricule = :mat');
                    $req->execute(array(
                        'mat' => $matricule
                    ));
                    $user = $req->fetch();
                    if ($user) {
                        $data = $user;
                    }

                    $msg = "Votre compte est déjà enregistré, veuillez vous connecter.";
                } else {
                    $req = $db->prepare('SELECT * FROM utilisateurs WHERE Mail = :mail AND Matricule = :mat');
                    $req->execute(array(
                        'mail' => htmlspecialchars($mail),
                        'mat' => htmlspecialchars($matricule)
                    ));
                    $user = $req->fetch();
                    if ($user) {
                        $data = $user;
                        $error = false;
                    } else {
                        $msg = "Ce matricule et ce mail institutionnel ne correspondent à aucun membre de l'INP-HB !";
                    }

                }
            }
        } catch (Exception $e) {
            $msg = "Erreur !";
        }
    }

    return json_encode(array(
        "data" => $data,
        "error" => $error,
        "is_registered" => $is_registered,
        "msg" => $msg
    ));
}

function f_register_etape_3($id, $classe, $ecole, $filiere, $phone, $password)
{
    // Initialisation des variables de base
    $db = getPDO();
    $error = true;
    $data = array();

    # VERIFICATION ROBOTS
    // Ma clé privée
    $secret = "6LfVn7EUAAAAAGXDU97KYNsqgxDuYn6WCIv8TuyX";

    // Paramètre renvoyé par le recaptcha
    $response = $_POST['g-recaptcha-response'];

    // On récupère l'IP de l'utilisateur
    $remoteip = $_SERVER['REMOTE_ADDR'];

    // L'url de vérification de captcha
    $api_url = "https://www.google.com/recaptcha/api/siteverify?secret="
        . $secret
        . "&response=" . $response
        . "&remoteip=" . $remoteip;

    $decode = json_decode(file_get_contents($api_url), true);

    if ($decode['success'] == true) :

        // Vérifier si l'étudiant existe déjà
        $req = $db->prepare('SELECT * FROM etudiants WHERE Utilisateurs_idUtilisateur = :id');
        $req->execute(array(
            'id' => $id
        ));
        $verif = $req->fetch();

        if ($verif) {
            $msg = "Etudiant deja existant";
        } else {

            // Mettre à jour l'utilisateur
            $req = $db->prepare('UPDATE utilisateurs SET Contact=:num,MotDePass=:mot, StatutCompte=1, NiveauAcces=0 WHERE idUtilisateur=:id');
            $req->execute(array(
                'num' => $phone,
                'mot' => password_hash($password, PASSWORD_BCRYPT),
                'id' => $id,
            ));

            // Ajouter l'étudiant
            $req = $db->prepare('INSERT INTO etudiants(Classe,Filiere,Ecole,Utilisateurs_idUtilisateur) VALUES(:class,:fili,:ecol,:id)');
            $insert = $req->execute(array(
                'class' => $classe,
                'fili' => $filiere,
                'ecol' => $ecole,
                'id' => $id
            ));

            if ($insert) {
                // Si tout s'est bien passé
                $error = false;
                $msg = "Insertion ok";

                $req = $db->prepare('SELECT * FROM utilisateurs WHERE idUtilisateur=:id');
                $req->execute(array(
                    "id" => $id
                ));
                $data = $req->fetch();
                session_destroy();
            } else {
                // Fluent
                // bd->select(table)->where(id, =, 5)->where(id, =, 5)->get()

                // ORM
                // Post::get(id, = ,5)
                // POst::all()
                // $p->category

                $msg = "Insertion pas ok";
            }
        }
    else:
        $error = true;
        $msg = "Vérification anti-robots échouée !";
    endif;
    return json_encode(array(
        "data" => $data,
        "error" => $error,
        "msg" => $msg
    ));
}

// Not found
function notFound()
{
    header("HTTP/1.0 404 Not Found");
    $root = url('/');
    echo <<< HTML
        <h1 style="color: red">ERREUR 404, page non trouvée. </h1>
            <button onclick="window.location.href='$root'">Retour au site.</button>
HTML;
    die();
}

// Action interdite
function Forbidden()
{
    header("HTTP/1.0 403 Forbidden");
    echo <<< HTML
        <h1 style="color: purple">ERREUR 403, la session a expirée. </h1>
            <button onclick="window.location.href = window.location">Recharger la page.</button>
HTML;
    die();
}

// annuler réservation
function f_cancel_reservation($idRes, $redirect = true)
{
    // Exécuter la requête
    getPDO()
        ->prepare("DELETE from reservations where idResult=?")
        ->execute(array($idRes));
    if ($redirect) {
        redirect(url("/"));
    }
}

// recuperer une reservation
function get_reservation($idRes)
{
    $db = getPDO();
    $st = $db->prepare("SELECT *, DATEDIFF(r.Date, NOW()) as date from reservations as r,
              salles as sa,
              machines as m,
              sites as si,
              utilisateurs as u
        where 
              r.Machines_idMachine=m.idMachine and
              r.Utilisateurs_idUtilisateur=u.idUtilisateur and 
              m.Salles_idSalle=sa.idSalle and
              sa.Sites_idSite=si.idSite and
              r.idResult=?");
    $st->execute(array($idRes));

    return $st->fetch();
}

// récupérer toutes les réservations de l'étudiant (notées ou pas)
function get_user_reservations($idUser, $notees = false)
{
    $db = getPDO();


    if (!$notees) {
        $st = $db->prepare("SELECT r.idResult,
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
        AND u.idUtilisateur=? ");
    } else {
        $st = $db->prepare("SELECT r.idResult,
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
        AND u.idUtilisateur=? ");
    }

    $st->execute(array($idUser));
    return $st->fetchAll();
}

// récupérer les réservations (selon que ça soit le surveillant ou l'admin)
function get_all_reservations($notees = false)
{
    $db = getPDO();

    if (!$notees) {
        $st = $db->prepare("SELECT r.idResult,
       r.score, 
       r.Apreciation, 
       r.Plage,
       DATE_FORMAT(r.Date, '%d/%m/%Y') as dt,
       DATEDIFF(r.Date, CURRENT_DATE()) as datedif, 
       m.Salles_idSalle"
            . ($_SESSION["niveau_acces"] > 1 ? "" :
                ",surveillants as su") .
            "
       ,u.Matricule,
       u.Nom
            FROM reservations as r, 
                 utilisateurs as u, 
                 machines as m"
            . ($_SESSION["niveau_acces"] > 1 ? "" :
                ",surveillants as su") .
            "
        WHERE score = -1 
        AND r.Utilisateurs_idUtilisateur=u.idUtilisateur 
        AND r.Machines_idMachine=m.idMachine"
            . ($_SESSION["niveau_acces"] > 1 ? "" :
                "
        AND m.Salles_idSalle=su.Salles_idSalle
        AND su.Utilisateurs_idUtilisateur=? ")
        );
    } else {
        $st = $db->prepare("SELECT r.idResult,
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
            . ($_SESSION["niveau_acces"] > 1 ? "" :
                ",surveillants as su") .
            "
        WHERE score > -1 
        AND r.Utilisateurs_idUtilisateur=u.idUtilisateur 
        AND r.Certifications_idCert=c.idCert
        AND r.Machines_idMachine=m.idMachine"
            . ($_SESSION["niveau_acces"] > 1 ? "" :
                "
        AND m.Salles_idSalle=su.Salles_idSalle
        AND su.Utilisateurs_idUtilisateur=? ")
        );
    }

    $st->execute(($_SESSION["niveau_acces"] > 1 ? array() : array($_SESSION["uid"])));

    return $st->fetchAll();
}

// Compte bloqué
function get_all_certifications()
{
    $db = getPDO();
    $st = $db->prepare("SELECT * FROM certifications");
    $st->execute();
    return $st->fetchAll();
}

// noter réservation
function f_note_student($id, $score, $idCert)
{
    if ($score > -1) {
        $db = getPDO();

        $st = $db->prepare("SELECT scoreReussite from certifications where idCert=?");
        $st->execute(array($idCert));

        $cert = $st->fetch();

        $appreciation = ((int)$cert["scoreReussite"] > $score) ? "Echec" : "Réussitte";


        $st = $db->prepare("UPDATE reservations as r 
        SET r.score=?,
            r.Absence=0,
            r.Apreciation=?,
            r.Certifications_idCert=?
    WHERE r.idResult=?
    ");
        $st->execute(array(
            $score,
            $appreciation,
            $idCert,
            $id
        ));

        redirect(url("/"));
    } else {
        $_SESSION["error"] = "Le score doit être un entier supérieur ou égal à zéro";
        redirect(url(($_SESSION["niveau_acces"] > 1) ? "admin" : "surveillant") . "/note_reservation.php?id=" . $id);
    }

}

// le nombre de surveillants affectés à une salle
function get_nbre_surv_for_salle($idSalle) {
    $db = getPDO();

    $st = $db->prepare("SELECT count(*) as nbre
                                 FROM surveillants as su,
                                      salles as sa
                                 WHERE su.Salles_idSalle=sa.idSalle
                                    and sa.idSalle=?
                                ");

    $st->execute(array($idSalle));
    $found = $st->fetch();
    return $found["nbre"];
}

function get_last_certfied_students() {
    $db = getPDO();

    $st = $db->query("
              SELECT u.Nom, c.NomCertification FROM
              utilisateurs as u, 
              reservations as r,
              etudiants as e, 
              certifications as c
                where 
                      e.Utilisateurs_idUtilisateur=u.idUtilisateur 
                      AND r.Utilisateurs_idUtilisateur=u.idUtilisateur
                      AND r.Absence=0
                      and r.Apreciation='Réussitte'
                      and r.Certifications_idCert=c.idCert
               ");


    return $st->fetchAll();
}