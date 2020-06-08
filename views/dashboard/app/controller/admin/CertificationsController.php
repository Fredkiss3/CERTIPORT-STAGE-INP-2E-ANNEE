<?php


namespace App\Controller\Admin;


use App\Model\Certification;
use Core\HTML\BootstrapForm;

class CertificationsController extends AppController {
    public function index() {
        $cert_location = true;
        $title = "Liste des Certifications";
        $certifications = Certification::all();
        $msg = session()->flash("msg");
        $this->render("certifications.index", compact("cert_location", "title", "certifications", 'msg'));
    }

    public function add() {
        // Error for Form
        $err = array();

        if (!empty($_POST)) {
            try {
                if (Certification::create(
                    array(
                        "NomCertification" => $_POST["NomCertification"],
                        "ScoreReussite" => $_POST["ScoreReussite"],
                    )
                )) {
                    $cert = Certification::find(Certification::table()->lastID());
                    session()->set("msg", "Certification ajoutée avec succès !");
                    $this->redirect("?p=admin.certifications.edit&id=" . $cert->idCert);
                } else {
                    $err = array(
                        "type" => "error",
                        "msg" => "Une erreur est survenue !",
                    );
                }
            } catch (\Exception $e) {
                $err = array(
                    "type" => "error",
                    "msg" => $e->getMessage()
                );
            }
        }
        $form = new BootstrapForm($_POST, $err);
        $title = "Ajouter certification";
        $this->render("certifications.edit", compact('form', "title"));
    }

    public function edit() {
        // Articles
        $cert = Certification::find($_GET["id"]);
        // Error for Form
        $err = array();

        if (!$cert) {
            $this->notFound();
        }

        if (!empty($_POST)) {
            $cert->NomCertification = $_POST["NomCertification"];
            $cert->ScoreReussite = $_POST["ScoreReussite"];

            if ($cert->save()) {
                $err = array(
                    "type" => "success",
                    "msg" => "Salle enregistrée avec succès !",
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

        $form = new BootstrapForm($cert, $err);
        $title = "Editer certification";
        $this->render("certifications.edit", compact('form', 'cert', "title"));
    }

    public function delete() {
        // User
        $cert = Certification::find($_GET["id"]);

        // Error for Form
        $err = array();

        if (!$cert) {
            $this->notFound();
        }

        if (!empty($_POST)) {
            if ($cert->delete()) {
                session()->set("msg", "Certification supprimée avec succès !");
                $this->redirect("index.php?p=admin.certifications.index");
                return;
            } else {
                $err = array(
                    'type' => "error",
                    "msg" => "Une erreur est survenue !"
                );
            }
        }


        $form = new BootstrapForm($cert, $err);
        $title = "Supprimer Certification";
        $this->render("certifications.delete", compact('form', 'cert', "title"));
    }
}