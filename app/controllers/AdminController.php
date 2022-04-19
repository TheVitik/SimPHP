<?php
namespace App\Controllers;
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
        $applications = array();
        /* MYSQL
        $res = $this->db->query("SELECT concat(users.firstname,' ',users.lastname) username, applications.visit_date, doctors.type FROM applications INNER JOIN users ON users.id=applications.user_id INNER JOIN doctors ON doctors.id=applications.doctor_id HAVING username LIKE '$pattern' ORDER BY applications.id DESC");
        while($application = $res->fetch_array()){
            array_push($applications,$application);
        }
        */
        $res = odbc_exec($this->db,"SELECT concat(users.firstname,' ',users.lastname) username, applications.visit_date, doctors.type FROM applications INNER JOIN users ON users.id=applications.user_id INNER JOIN doctors ON doctors.id=applications.doctor_id HAVING username LIKE '$pattern' ORDER BY applications.id DESC");
        while($application = odbc_fetch_array($res)){
            array_push($applications,$application);
        }
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
        /* MYSQL
        $stmt = $this->db->prepare("INSERT INTO doctors VALUES(null,null,?,NOW())");
        $stmt->bind_param("s",$_POST['type']);
        $stmt->execute();
        */
        // ODBC
        $stmt = odbc_prepare($this->db,"INSERT INTO doctors VALUES(null,null,?,NOW())");
        if(!odbc_execute($stmt, array($_POST['type']))) {
            array_push($this->errors, "Помилка сервера, спробуйте пізніше");
        }
        $this->process->redirect("admin");
    }
}