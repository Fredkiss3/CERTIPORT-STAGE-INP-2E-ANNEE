<?php

// Gerer les requetes 'POST'
if (!empty($_POST["action"])) {

    // Retirer les caractères spéciaux pour la sécurité
    foreach ($_POST as $i => $pvar) {
        $_POST[$i] = htmlspecialchars($pvar);
    }

    switch ($_POST["action"]) {
        case "login":
            login();
            break;
        case "get_machines":
            echo get_machines();
            break;
        case "note_student":
            // au moins le surveillant
            check_access(1);
            noter_student();
            break;
        case "add_surveillant":
            add_surveillant();
            break;
        case "remove_surveillant":
            $id = $_POST["id"];
            check_access(2);
            remove_surveillant($id);
            break;
        case "reset_surveillant":
            $id = $_POST["id"];
            check_access(2);
            reset_surveillant($id);
            break;
        case "lock_account":
            $id = $_POST["id"];
            check_access(2);
            lock_account($id);
            break;
        case "unlock_account":
            $id = $_POST["id"];
            check_access(2);
            unlock_account($id);
            break;
        case "reserver_machine":
            reserver_machine();
            break;
        case "register_etape_1":
            echo register_etape_1();
            break;
        case "register_etape_2":
            try {
                echo register_etape_3();
            } catch (Exception $e) {
                echo json_encode(array(
                    "data" => null,
                    "error" => true,
                    "msg" => "Une erreur est survenue :" . $e->getMessage(),
                ));
            }
            break;
        case "cancel_reservation":
            cancel_reservation();
            break;
        default:
            Forbidden();
            break;
    }
}

function verifytoken($token) {
    $session_token = $_SESSION['token'];
    unset($_SESSION["token"]);
    return hash_equals($token, $session_token);
}

function lock_account($id) {
    if (!empty($_POST["_token"])) {
        if (verifytoken($_POST["_token"])) {

            if (!f_lock_account($id)) {
                $_SESSION["error"] = "Une erreur est survenue lors de cette opération";
            }
            redirect(url("admin/accounts.php"));
        } else {
            Forbidden();
        }
    } else {
        Forbidden();
    }
}

function unlock_account($id) {
    if (!empty($_POST["_token"])) {
        if (verifytoken($_POST["_token"])) {
            if (!f_unlock_account($id)) {
                $_SESSION["error"] = "Une erreur est survenue lors de cette opération";
            }
            redirect(url("admin/accounts.php"));
        } else {
            Forbidden();
        }
    } else {
        Forbidden();
    }
}

function reset_surveillant($id) {
    if (!empty($_POST["_token"])) {
        if (verifytoken($_POST["_token"])) {
            f_reset_surveillant($id);
        } else {
            Forbidden();
        }
    } else {
        Forbidden();
    }
}

function remove_surveillant($id) {
    if (!empty($_POST["_token"])) {
        if (verifytoken($_POST["_token"])) {
            f_remove_surveillant($id);
        } else {
            Forbidden();
        }
    }
}

function login() {
    if (!empty($_POST["matri"]) and !empty($_POST["password"])) {
        if (!empty($_POST["_token"])) {

            if (verifytoken($_POST["_token"])) {

                if (login_user(htmlspecialchars($_POST["matri"]), htmlspecialchars($_POST["password"]))) {
                    if (!empty($_POST["next"])) :
                        redirect(url($_POST["next"]));
                    else :
                        redirect(url(""));
                    endif;
                } else {
                    // Erreur : rediriger vers la page de connexion
                    redirect(url("connectivity/login.php"));
                }

            } else {
                Forbidden();
            }
        } else {
            Forbidden();
        }
    } else {
        Forbidden();
    }
}

function add_surveillant() {
    if (!empty($_POST["matri"]) and !empty($_POST["salle"])) {
        if (verifytoken($_POST["_token"])) {
            $data = f_add_surveillant($_POST["matri"], $_POST["salle"]);
            if ($data["error"] === "") {
                if ($data["msg"] !== "") {
                    $_SESSION["msg"] = $data["msg"];
                }
                redirect(url("admin/accounts.php"));
            } else {
                $_SESSION["error"] = $data["error"];
                redirect(url("admin/add_surveillant.php"));
            }
        } else {
            Forbidden();
        }
    } else {
        Forbidden();
    }
}

function get_machines() {
    if (($_POST["_token"] === $_SESSION["token"])) {
        if (isset($_POST["day"]) and isset($_POST["salle"])) {
            header('Content-type: application/json');
            return f_get_machines($_POST["salle"], $_POST["day"]);
        } else {
            Forbidden();
        }
    } else {
        Forbidden();
    }

    return json_encode(null);
}

function reserver_machine() {
    if (verifytoken($_POST["_token"])) {
        if (isset($_POST["today"]) and !empty($_POST["plage"]) and !empty($_POST["idMachine"])) {
            echo f_reserver_machine($_POST["idMachine"], $_POST["plage"], $_POST["today"]);
        } else {
            Forbidden();
        }
    } else {
        Forbidden();
    }
}

function register_etape_1() {
    if ($_SESSION["token"] === $_POST["_token"]) {
        if (!empty($_POST["matri"]) and !empty($_POST["mail"])) {
            return f_register_etape_1($_POST["matri"], $_POST["mail"]);
        } else {
            Forbidden();
        }
    } else {
        Forbidden();
    }
    return null;
}

function register_etape_3() {
    if (verifytoken($_POST["_token"])) {
        if (!empty($_POST["classe"]) and
            !empty($_POST["id"]) and
            !empty($_POST["ecole"]) and
            !empty($_POST["filiere"]) and
            !empty($_POST["password"]) and
            !empty($_POST["phone"]) and
            !(empty($_POST['g-recaptcha-response']))
        ) {

            // C'est un humain
            return f_register_etape_3($_POST["id"],
                $_POST["classe"],
                $_POST["ecole"],
                $_POST["filiere"],
                $_POST["phone"],
                $_POST["password"]
            );

        } else {
            return json_encode(array(
                "data" => null,
                "error" => true,
                "msg" => "Action interdite !"
            ));
        }
    }
    return null;
}

function noter_student() {
    if (verifytoken($_POST["_token"])) {
        if (isset($_POST["id"]) and isset($_POST["score"]) and isset($_POST["certification"])) {
            f_note_student($_POST["id"], $_POST["score"], $_POST["certification"]);
            return;
        }
    }

    Forbidden();
}

function cancel_reservation() {
    if (verifytoken($_POST["_token"])) {
        if (isset($_POST["id"])) {
            f_cancel_reservation($_POST["id"]);
            return;
        }
    }

    Forbidden();
}
