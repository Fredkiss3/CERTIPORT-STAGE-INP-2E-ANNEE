<?php


namespace App\Controller\Admin;


use App\Model\Student;
use App\Model\Surveillant;

class AccountsController extends AppController {
    public function index() {
        $title = "Comptes";
        $accounts = true;

        $surveillants = Surveillant::table()->getAll();
        $students = Student::table()->getAll();

        $this->render("accounts.index", compact("surveillants", 'title', 'students', 'accounts'));
    }
}