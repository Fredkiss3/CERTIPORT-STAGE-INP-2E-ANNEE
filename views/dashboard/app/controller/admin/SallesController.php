<?php


namespace App\Controller\Admin;


use App\Model\Machine;
use App\Model\Salle;
use App\Model\Site;
use App\Model\Surveillant;
use App\Model\User;
use Core\HTML\BootstrapForm;

class SallesController extends AppController {
    public function index() {
        $salles = Salle::all("Sites_idSite");


        foreach ($salles as $sa) {
            $su = Surveillant::where("Salles_idSalle", "=", $sa->idSalle);
            if ($su) {
                $u = User::find($su->Utilisateurs_idUtilisateur);
                $sa->NomSurveillant = $u->Nom;
            } else {
                $sa->NomSurveillant = null;
            }

            $sa->NomSite = Site::find($sa->Sites_idSite)->NomSite;
        }

        $title = "Liste des salles";
        $salles_location = true;

        $msg = session()->flash("msg");
        $this->render("rooms.index", compact("salles", 'title', 'salles_location', "msg"));
    }

    public function add() {
        // Error for Form
        $err = array();
        $sites = Site::table()->extract("idSite", "NomSite");

        if (!empty($_POST)) {
           try {
               if (Salle::create(
                   array(
                       "NumSalle" => $_POST["NumSalle"],
                       "Sites_idSite" => $_POST["Sites_idSite"],
                   )
               )) {
                   $salle = Salle::find(Salle::table()->lastID());
                   session()->set("msg", "Salle ajoutée avec succès !");
                   $this->redirect("?p=admin.salles.edit&id=" . $salle->idSalle);
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
        $title = "Ajouter Salle";
        $this->render("rooms.edit", compact('form', "title", "sites"));
    }

    public function edit() {
        // Articles
        $salle = Salle::find($_GET["id"]);
        // Error for Form
        $err = array();

        if (!$salle) {
            $this->notFound();
        }

        // Sites
        $sites = Site::table()->extract("idSite", "NomSite");

        if (!empty($_POST)) {
            $salle->NumSalle = $_POST["NumSalle"];
            $salle->Sites_idSite = $_POST["Sites_idSite"];

            if ($salle->save()) {
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

        $form = new BootstrapForm($salle, $err);
        $title = "Editer Salle";
        $this->render("rooms.edit", compact('form', 'salle', "title", "sites"));
    }

    public function delete() {
        // User
        $salle = Salle::find($_GET["id"]);

        // Error for Form
        $err = array();

        if (!$salle) {
            $this->notFound();
        } else {
            $salle->NomSite = Site::find($salle->Sites_idSite)->NomSite;

            $all_machines = Machine::where("Salles_idSalle", "=", $salle->idSalle, true);
        }

        if (!empty($_POST)) {
            $no_err = true;
            foreach ($all_machines as $machine) {
                if (!$machine->delete()) {
                    $err = array(
                        "type" => "error",
                        "msg" => "Une erreur est survenue lors de la suppression de la machine n° {$machine->NumMachine} !",
                    );
                    break;
                }
            }

            if ($no_err) {
                if ($salle->delete()) {
                    session()->set("msg", "Salle supprimée avec succès !");
                    $this->redirect("index.php?p=admin.salles.index");
                    return;
                } else {
                    $err = array(
                        'type' => "error",
                        "msg" => "Une erreur est survenue !"
                    );
                }
            }
        }


        $form = new BootstrapForm($salle, $err);
        $title = "Supprimer Salle";
        $this->render("rooms.delete", compact('form', 'salle', "title", "all_machines"));

    }
}