<?php
namespace App\Controllers;
use Core\Database;
use Core\Default\Controller;
use App\Models\User;
require_once("app/models/User.php");
class AdminController extends Controller{
    protected $data;
    
    //Return account view
    public function admin(){
        $pattern = "%";
        if(!empty($_GET['search'])){
            $pattern = "%".$_GET['search']."%";
        }
        $applications = Database::select("concat(users.firstname,' ',users.lastname) username, applications.visit_date, doctors.type")
            ->from("applications")->innerJoin("users")->on("users.id=applications.user_id")->innerJoin("doctors")->on("doctors.id=applications.doctor_id")->execute()->fetchArray();
        echo $applications::queryString();
        //$applications = Database::query("SELECT concat(users.firstname,' ',users.lastname) username, applications.visit_date, doctors.type FROM applications INNER JOIN users ON users.id=applications.user_id INNER JOIN doctors ON doctors.id=applications.doctor_id HAVING username LIKE '$pattern' ORDER BY applications.id DESC")->fetchArray();
        $this->process->show("admin",[
            "applications"=>$applications
        ]);
    }

    //Return account view - GET
    public function add(){
        $this->process->show("add");
    }
    //POST
    public function addDoctor(){
        $stmt = $this->db->prepare("INSERT INTO doctors VALUES(null,null,?,NOW())");
        $stmt->bind_param("s",$_POST['type']);
        $stmt->execute();
        if($this->db->error){
            array_push($this->errors, "Помилка сервера, спробуйте пізніше");
        }
        $this->process->redirect("admin");
    }
}