<?php
namespace App\Controllers;
use Core\Default\Controller;
use App\Models\User;
require_once("app/models/User.php");
class AuthController extends Controller{
    protected $isAdmin = False;
    protected $data;
    //Return login view
    public function login(){
        $this->process->show("login");
    }

    //Return register view
    public function register(){
        $this->process->show("register");
    }

    public function signin(){
        if(!$this->doLogin())
        $this->process->show("login",[
            "errors"=>$this->errors
        ]);
        else{
            if($this->isAdmin){
                $this->process->redirect("admin");
            }
            else{
                $this->process->redirect("account");
            }
        }
    }

    public function signup(){
        if(!$this->doRegister())
        $this->process->show("register",[
            "errors"=>$this->errors
        ]);
        else{
            $this->process->redirect("login");
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
    private function doRegister(){
        $this->checkRegister();
        if($this->status()){
            /* MYSQL
            $stmt = $this->db->prepare("INSERT INTO users VALUES(null,?,?,?,?,NOW())");
            $stmt->bind_param("ssss",$_POST['firstname'],$_POST['lastname'],$_POST['email'],md5($_POST['password']));
            $stmt->execute();
            if($this->db->error){
                array_push($this->errors, "Помилка сервера, спробуйте пізніше");
                return False;
            }
            */
            // ODBC
            $stmt = odbc_prepare($this->db,"INSERT INTO users VALUES(null,?,?,?,?,NOW())");
            if(!odbc_execute($stmt, array($_POST['firstname'],$_POST['lastname'],$_POST['email'],md5($_POST['password'])))) {
                array_push($this->errors, "Помилка сервера, спробуйте пізніше");
            }
            return True;
        }
        else{
            return False;
        }
    }

    //Check user data
    private function checkRegister(){
        if($_POST['password']!=$_POST['repassword']){
            array_push($this->errors, "Паролі не співпадають");
        }
        if(strlen($_POST['password'])<8){
            array_push($this->errors, "Довжина пароля має бути більше 8 символів");
        }
        /*if(!filter_val($_POST['email'],FILTER_VALIDATE_EMAIL)){
            array_push($this->errors, "Формат пошти неправильний");
        }*/
        /* MYSQL
        $stmt = $this->db->prepare("SELECT id FROM users WHERE email=?");
        $stmt->bind_param("s",$_POST['email']);
        $stmt->execute();
        $response = $stmt->get_result();
        if($user = $response->fetch_array()){
            array_push($this->errors, "Пошта вже зайнята");
        }
        */
        // ODBC
        $stmt = odbc_prepare($this->db,"SELECT id FROM users WHERE email=?");
        if(!odbc_execute($stmt, array($_POST['email']))) {
            array_push($this->errors, "Помилка сервера, спробуйте пізніше");
        }
        else{
            if($user = odbc_fetch_array($stmt)){
                array_push($this->errors, "Пошта вже зайнята");
            }
        }
    }

    //Check user data
    private function checkLogin(){
        if(strlen($_POST['password'])<8){
            array_push($this->errors, "Довжина пароля має бути більше 8 символів");
            return;
        }
        /*if(!filter_val($_POST['email'],FILTER_VALIDATE_EMAIL)){
            array_push($this->errors, "Формат пошти неправильний");
        }*/
        
        if($_POST['email']===ADMIN_USERNAME && $_POST['password']===ADMIN_PASSWORD){
            $this->isAdmin = True;
            return;
        }
        $user = null;
        /* MYSQL
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email=?");
        $stmt->bind_param("s",$_POST['email']);
        $stmt->execute();
        $response = $stmt->get_result();
        if(!$user = $response->fetch_array()){
            array_push($this->errors, "Акаунт не існує");
        }
        else{
            if(md5($_POST['password'])!==$user['password']){
                array_push($this->errors, "Пароль неправильний");
            }
            else{
                $this->data = $user;
            }
        }
        */
        // ODBC
        $stmt = odbc_prepare($this->db,"SELECT * FROM users WHERE email=?");
        if(!odbc_execute($stmt, array($_POST['email']))) {
            array_push($this->errors, "Помилка сервера, спробуйте пізніше");
        }
        else{
            if(!$user = odbc_fetch_array($stmt)){
                array_push($this->errors, "Акаунт не існує");
            }
            else{
                if(md5($_POST['password'])!==$user['password']){
                    array_push($this->errors, "Пароль неправильний");
                }
                else{
                    $this->data = $user;
                }
            }
        }
    }

    //Exit from account
    public function logout(){
        session_destroy();
        $this->process->redirect("login");
    }
}