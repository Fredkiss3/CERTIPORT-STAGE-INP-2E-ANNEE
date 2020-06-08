<?php


namespace App\Controller\Admin;


use App\Model\Machine;
use App\Model\Salle;
use App\Model\Site;
use Core\HTML\BootstrapForm;

class MachinesController extends AppController {
    public function index() {
        $machines_location = true;
        $title = "Liste des Postes";
        $machines = Machine::all();

        foreach ($machines as $machine) {
            $salle = Salle::find($machine->Salles_idSalle);
            $machine->NumSalle = $salle->NumSalle;
            $site = Site::where("idSite", "=", $salle->Sites_idSite);
            $machine->NomSite = $site->NomSite;
        }
        $msg = session()->flash("msg");
        $this->render("machines.index", compact("machines_location", "title", "machines", "msg"));
    }

    public function add() {
        // Error for Form
        $err = array();

        if (!empty($_POST)) {
            try {
                if (Machine::create(
                    array(
                        "Salles_idSalle" => $_POST["Salles_idSalle"],
                        "NumMachine" => $_POST["NumMachine"]
                    )
                )) {
                    session()->set("msg", "Poste de certification ajouté avec succès !");
                    $this->redirect("index.php?p=admin.machines.edit&id=" . Machine::table()->lastID());
                } else {
                    $err = array(
                        "type" => "error",
                        "msg" => "Une erreur est survenue !",
                    );
                }
            } catch (\Exception $e) {
                $err = array(
                    "type" => "error",
                    "msg" => $e->getMessage(),
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

        // Sites & salles to show
        $first = Site::first();

        $salles = Salle::table()->extract("idSalle", "NumSalle", Salle::where(
            "Sites_idSite", "=", $first->idSite, true));

        $sites = Site::table()->extract("idSite", "NomSite");

        // Sites & salles to work with
        $all_sites = Site::all();
        $all_salles = Salle::all();

        $form = new BootstrapForm($_POST, $err);
        $title = "Ajouter Machine";
        $this->render("machines.edit", compact('form', "all_salles", "all_sites", "title", "sites", "salles"));
    }

    public function edit() {
        // Articles
        $machine = Machine::find($_GET["id"]);
        // Error for Form
        $err = array();

        if (!$machine) {
            $this->notFound();
        }

        if (!empty($_POST)) {
            $machine->Salles_idSalle = $_POST["Salles_idSalle"];
            $machine->NumMachine = $_POST["NumMachine"];

            if ($machine->save()) {
                $err = array(
                    "type" => "success",
                    "msg" => "Poste de certification enregistré avec succès !",
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

        // Set attributes
        $machine->NumSalle = Salle::find($machine->Salles_idSalle)->NumSalle;
        $site = Site::find(Salle::find($machine->Salles_idSalle)->Sites_idSite);
        $machine->idSite = $site->idSite;
        $machine->NomSite = $site->NomSite;


        // Sites & salles to show
        $salles = Salle::table()->extract("idSalle", "NumSalle", Salle::where(
            "Sites_idSite", "=", $site->idSite, true));


        $sites = Site::table()->extract("idSite", "NomSite");

        // Sites & salles to work with
        $all_sites = Site::all();
        $all_salles = Salle::all();

        $form = new BootstrapForm($machine, $err);
        $title = "Editer Machine";
        $this->render("machines.edit", compact('form', "all_salles", "all_sites", 'machine', "title", "sites", "salles"));
    }

    public function delete() {
        // User
        $machine = Machine::find($_GET["id"]);

        // Error for Form
        $err = array();

        if (!$machine) {
            $this->notFound();
        } else {
            $machine->NumSalle = Salle::find($machine->Salles_idSalle)->NumSalle;
            $machine->NomSite = Site::find(Salle::find($machine->Salles_idSalle)->Sites_idSite)->NomSite;
        }

        if (!empty($_POST)) {
            if ($machine->delete()) {
                session()->set("msg", "Machine supprimée avec succès !");
                $this->redirect("index.php?p=admin.machines.index");
                return;
            } else {
                $err = array(
                    'type' => "error",
                    "msg" => "Une erreur est survenue !"
                );
            }
        }


        $form = new BootstrapForm($machine, $err);
        $title = "Supprimer Poste de certification";
        $this->render("machines.delete", compact('form', 'machine', "title"));
    }
}