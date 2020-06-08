<?php


namespace App\Controller\Student;


use App\Model\Salle;
use App\Model\Site;
use App\Model\Student;
use App\Model\Surveillant;
use Core\HTML\BootstrapForm;

class ProfileController extends AppController {

    public function show() {
        $err = array();
        $user = auth()->user();

        // student related
        $student_related = Student::where("Utilisateurs_idUtilisateur", "=", $user->idUtilisateur);

        // supervisor related
        $surv_related = Surveillant::where("Utilisateurs_idUtilisateur", "=", $user->idUtilisateur);
        
        if (!empty($_POST)) {
            $user->Nom = $_POST["Nom"];
            $user->Contact = $_POST["Contact"];

            if (auth()->is_admin()) {
                $user->Matricule = $_POST["Matricule"];
                $user->Mail = $_POST["Mail"];
            }

            try {
                if ($user->save()) {
                    if ($student_related) {
                        $student_related->Ecole = $_POST["Ecole"];
                        $student_related->Filiere = $_POST["Filiere"];
                        $student_related->Classe = $_POST["Classe"];

                        if ($student_related->save()) {
                            $err = array(
                                "type" => "success",
                                "msg" => "Informations Mises à jour avec succès"
                            );
                        } else {
                            $err = array(
                                "type" => "error",
                                "msg" => "Une erreur est survenue"
                            );
                        }

                    } else {
                        $err = array(
                            "type" => "success",
                            "msg" => "Informations Mises à jour avec succès"
                        );
                    }

                } else {
                    $err = array(
                        "type" => "error",
                        "msg" => "Une erreur est survenue"
                    );
                }
            } catch (\Exception $e) {
                $err = array(
                    "type" => "error",
                    "msg" => $e->getMessage()
                );
            }
        } else {
            $msg = session()->flash("msg");
            if ($msg) {
                $err = array(
                    "type" => "success",
                    "msg" => $msg
                );
            }
        }

        if ($student_related) {
            $user->Ecole = $student_related->Ecole;
            $user->Filiere = $student_related->Filiere;
            $user->Classe = $student_related->Classe;
        } if ($surv_related) {
            // room supervised & site affected
            $salle = Salle::find($surv_related->Salles_idSalle);
            $site = Site::find($salle->Sites_idSite);

            // set values
            $user->NomSite = $site->NomSite;
            $user->NumSalle = $salle->NumSalle;
        }

        // form
        $form = new BootstrapForm($user, $err);
        // dd($form);
        $title = "Mon profil";
        $profile_location = true;
        $this->render("users.show", compact("title", "form", "profile_location", "student_related", "user", "surv_related"));
    }

    public function change_password() {
        $err = array();
//        dd(auth()->user());
        if (!empty($_POST)) {
//            password_hash($password, PASSWORD_BCRYPT);
            $old_pass = $_POST["old_password"];
            $new_pass = $_POST["new_password"];
            $new_pass_confirm = $_POST["confirm_password"];
            $user = auth()->user();


            if (password_verify($old_pass, $user->MotDePass)) {
                if ($new_pass === $new_pass_confirm) {
                    if ($new_pass) {
                        if (
                            preg_match('/[0-9]+/', $new_pass) and
                            preg_match('/[A-Z]+/', $new_pass) and
                            preg_match('/[a-z]+/', $new_pass) and
                            strlen($new_pass) >= 8
                        ) {
                            $user->MotDePass = password_hash($new_pass, PASSWORD_BCRYPT);
                            if ($user->save()) {
                                session()->set("msg", "Mot de passe mis à jour avec succès !");
                                $this->redirect("?p=student.profile.show");
                                return;
                            } else {
                                $err = array(
                                    "type" => "error",
                                    "msg" => "Une erreur est survenue !"
                                );
                            }
                        } else {
                            $err = array(
                                "type" => "error",
                                "msg" => "Le mot de passe ne répond pas aux normes de sécurité :
                                 8 caractères minimum avec au moins  <b>1 chiffre et 1 lettre majuscule et 1 lettre minuscule</b>"
                            );
                        }
                    }
                } else {
                    $err = array(
                        "type" => "error",
                        "msg" => "Les Mots de passe ne correspondent pas !"
                    );
                }
            } else {
                $err = array(
                    "type" => "error",
                    "msg" => "Mot de passe incorrect !"
                );
            }
        }
        // form
        $form = new BootstrapForm($_POST, $err);
        $title = "Changer Mot de passe";
        $profile_location = true;
        $this->render("users.change_password", compact("title", "form", "profile_location"));
    }
}