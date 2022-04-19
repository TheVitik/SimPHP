<?php
namespace App\Controllers;
use Core\Default\Controller;
use App\Models\User;
require_once("app/models/User.php");
class AccountController extends Controller{
    protected $data;
    
    //Return account view
    public function account(){
        $user = unserialize($_SESSION['user']);
        $id = $user->id;
        $applications = array();
        /* MYSQL
        $res = $this->db->query("SELECT concat(users.firstname,' ',users.lastname) as username, applications.visit_date, doctors.type FROM applications INNER JOIN users ON users.id=applications.user_id INNER JOIN doctors ON doctors.id=applications.doctor_id WHERE users.id=$id ORDER BY applications.id DESC");
        while($application = $res->fetch_array()){
            array_push($applications,$application);
        }
        */
        // ODBC
        $res = odbc_exec($this->db,"SELECT concat(users.firstname,' ',users.lastname) as username, applications.visit_date, doctors.type FROM applications INNER JOIN users ON users.id=applications.user_id INNER JOIN doctors ON doctors.id=applications.doctor_id WHERE users.id=$id ORDER BY applications.id DESC");
        while($application = odbc_fetch_array($res)){
            array_push($applications,$application);
        }
        $this->process->show("account",[
            "applications"=>$applications
        ]);
    }

    //Return register view
    public function create(){
        $doctors = array();
        /* MYSQL
        $res = $this->db->query("SELECT * FROM doctors ORDER BY type");
        while($doctor = $res->fetch_array()){
            array_push($doctors,$doctor);
        }
        */
        // ODBC
        $res = odbc_exec($this->db,"SELECT * FROM doctors ORDER BY type");
        while($doctor = odbc_fetch_array($res)){
            array_push($doctors,$doctor);
        }
        $this->process->show("create",[
            "doctors"=>$doctors
        ]);
    }

    public function newApplication(){
        $doctors = array();
        /* MYSQL
        $res = $this->db->query("SELECT * FROM doctors ORDER BY type");
        
        while($doctor = $res->fetch_array()){
            array_push($doctors,$doctor);
        }
        */
        // ODBC
        $res = odbc_exec($this->db,"SELECT * FROM doctors ORDER BY type");
        while($doctor = odbc_fetch_array($res)){
            array_push($doctors,$doctor);
        }
        if(!$this->makeApplication()){
        $this->process->show("create",[
            "doctors"=>$doctors,
            "errors"=>$this->errors
        ]);
        }
        else{
            $this->process->show("create",[
                "doctors"=>$doctors,
                "message"=>"Заявку успішно створено"
            ]);
        }
    }

    /*  Login user, create session
    //  Return bool
    //  False if error, else True
    */
    private function doLogin(){
        $this->checkLogin();
        $u = $this->data;
        if($this->isAdmin==False){
            if($this->status()){
                $user = new User($u['id'],$u['firstname'],$u['lastname'],$u['email'],$u['password'],$u['created_at']);
                $_SESSION['user']=serialize($user);
                return True;
            }
            else{
                return False;
            }
        }
        else{
            $_SESSION['admin'] = True;
            return True;
        }
        
    }

    /*  Insert user into database 
    //  Return bool
    //  False if error, else True
    */
    private function makeApplication(){
        $this->checkApplication();
        if($this->status()){
            $user = unserialize($_SESSION['user']);
            /* MYSQL
            $stmt = $this->db->prepare("INSERT INTO applications VALUES(null,?,?,?,?,NOW())");
            $stmt->bind_param("ssss",$user->id,$_POST['doctor'],$_POST['phone'],$_POST['visit_date']);
            $stmt->execute();
            if($this->db->error){
                array_push($this->errors, "Помилка сервера, спробуйте пізніше");
                return False;
            }
            */
            // ODBC
            $stmt = odbc_prepare($this->db,"INSERT INTO applications VALUES(null,?,?,?,?,NOW())");
            if(!odbc_execute($stmt, array($user->id,$_POST['doctor'],$_POST['phone'],$_POST['visit_date']))) {
                array_push($this->errors, "Помилка сервера, спробуйте пізніше");
                return False;
            }
            return True;
        }
        else{
            return False;
        }
    }

    //Check user data
    private function checkApplication(){
        if(!is_numeric($_POST['doctor'])){
            array_push($this->errors, "Помилка ID лікаря");
        }
        /*if(preg_match("/^((\+380)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}$/",$_POST['phone'])){
            array_push($this->errors, "Формат номеру неправильний");
        }
        */
    }
}