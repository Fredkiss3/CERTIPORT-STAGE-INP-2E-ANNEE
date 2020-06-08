<?php


namespace App\Controller\Admin;


use App\Model\Reservation;
use App\Model\Student;
use App\Model\Surveillant;
use App\Model\User;
use Core\HTML\BootstrapForm;
use Core\Model\Model;

class UsersController extends AppController {
    public function index() {
        $users = User::where("Matricule", "!=", "17INP0001", true);
        $user_location = true;
        $title = "Liste des utilisateurs";
        $msg = session()->flash("msg");
        $this->render("users.index", compact('users', "user_location", "title", "msg"));
    }

    public function add() {
        $title = "Ajouter Utilisateur";
        // Error for Form
        $err = array();

        if (!empty($_POST)) {

            if (User::create(
                array(
                    "Matricule" => $_POST["Matricule"],
                    "Nom" => $_POST["Nom"],
                    "Contact" => $_POST["Contact"],
                    "Mail" => $_POST["Mail"]
                )
            )) {
                $user = User::find(User::table()->lastID());
                session()->set("msg", "Utilisateur ajouté avec succès !");
                $this->redirect("?p=admin.users.edit&id=" . $user->idUtilisateur);
            } else {
                $err = array(
                    "type" => "error",
                    "msg" => "Une erreur est survenue !",
                );
            }
        }

        $form = new BootstrapForm($_POST, $err);
        $this->render("users.edit", compact('form', "title"));
    }

    public function delete() {
        // User
        $user = User::find($_GET["id"]);

        // Error for Form
        $err = array();

        if (!$user) {
            $this->notFound();
        } else {
            $surv_related = Surveillant::where("Utilisateurs_idUtilisateur", "=", $user->idUtilisateur);
            $student_related = Student::where("Utilisateurs_idUtilisateur", "=", $user->idUtilisateur);
            $all_reservations = Reservation::where(
                "Utilisateurs_idUtilisateur", "=", $user->idUtilisateur,
                true);
        }

        if (!empty($_POST)) {
            $err_student = true;
            $err_surv = true;
            $err_res = true;
            if ($student_related) {
                $err_student = $student_related->delete();
            }

            if ($surv_related) {
                $err_surv = $surv_related->delete();
            }

            /**
             * @var $res Reservation
             */
            foreach ($all_reservations as $res) {
                if (!$res->delete()) {
                    $err_res = true;
                    break;
                }
            }

            $no_err = $user->delete();

            if ($no_err && $err_surv && $err_student && $err_res) {
                session()->set("msg", "Utilisateur supprimé avec succès !");
                $this->redirect("index.php?p=admin.users.index");
                return;
            } else {
                $err = array(
                    'type' => "error",
                    "msg" => "Une erreur est survenue !"
                );
            }
        }


        $form = new BootstrapForm($user, $err);
        $title = "Supprimer Utilisateur";
        $this->render("users.delete", compact('form', 'user', "student_related", "surv_related",
            "all_reservations", "title"));
    }

    public function edit() {
        // Articles
        $user = User::find($_GET["id"]);
        // Error for Form
        $err = array();

        if (!$user) {
            $this->notFound();
        }

        if (!empty($_POST)) {
            $user->Matricule = $_POST["Matricule"];
            $user->Nom = $_POST["Nom"];
            $user->Contact = $_POST["Contact"];
            $user->Mail = $_POST["Mail"];

            if ($user->save()) {
                $err = array(
                    "type" => "success",
                    "msg" => "Utilisateur enregistré avec succès !",
                );
            } else {
                $err = array(
                    "type" => "error",
                    "msg" => "Une erreur est survenue !",
                );
            }
        } else {
            $msg = session()->flash("msg");
            if ($msg) {
                $err = array(
                    'type' => "success",
                    "msg" => $msg
                );
            }
        }

        $form = new BootstrapForm($user, $err);
        $title = "Editer Utilisateur";
        $this->render("users.edit", compact('form', 'user', "title"));
    }

    public function import() {
        $err = null;
        $success = null;
        $title = "Importer Base de données";

        if (!empty($_FILES)) {
//            dd($_FILES["file"], false);

            $file = $_FILES["file"];
            $f_exploded = explode(".", $file["name"]);
            $ext = end($f_exploded);

            if ($ext != "csv") {
                $err = "Fichier non valide : Seuls les fichiers de type <b>CSV</b> sont acceptés";
            } else {
                $path = ROOT . "/public/tmp/tmp.csv";
                # Move file to tmp location
                move_uploaded_file($file["tmp_name"], $path);

                $tmp_file = fopen($path, 'r');
                $first_line = fgets($tmp_file);

                // check the header
                if ($first_line !== "Matricule;Nom;Mail;Contact\n") {
                    $err = "Fichier invalide : l'entête doit contenir dans l'ordre, les colonnes <b>Matricule, Nom, Mail et Contact</b>";
                } else {
                    // Add users
                    $users = array();
                    while (!feof($tmp_file)) {
                        $line = explode(";", fgets($tmp_file));
//                        dd($line, false);
                        if (count($line) != 4) {
                            $err = "Fichier Invalide : Chaque ligne doit contenir 4 valeurs !";
                            break;
                        } else {
                            array_push(
                                $users, array(
                                    "Matricule" => $line[0],
                                    "Nom" => $line[1],
                                    "Mail" => $line[2],
                                    "Contact" => $line[3],
                                )
                            );
                        }
                    }

                    // Create users
                    if (is_null($err)) {
                        foreach ($users as $user) {
                            try {
                                if (!User::create($user)) {
                                    $err = "Une erreur est survenue lors de l'ajout de l'utilisateur : {$user["Nom"]}";
                                    break;
                                }
                            } catch (\Exception  $e) {
                                $err = $e->getMessage();
                                break;
                            }
                        }
                    }

                    if (is_null($err)) {
                        $success = "Opération effectuée avec succès !";
                    }
                }
                // close file & delete it
                fclose($tmp_file);
                unlink($path);
            }
        }

        $this->render("users.import", compact("title", 'err', "success"));
    }

    public function export() {
        header("Content-type: application/octet-stream");
        header("Content-Disposition: attachment; filename=\"users.csv\"");
        $data = "Matricule;Nom;Mail;Contact";

        $users = User::where("Matricule", "!=", "17INP0001", true);

        foreach ($users as $user) {
            $data .= "\n{$user->Matricule};{$user->Nom};{$user->Mail};{$user->Contact}";
        }

        echo $data;
    }

}