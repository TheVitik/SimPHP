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
            $stmt = $this->db->prepare("INSERT INTO users VALUES(null,?,?,?,?,NOW())");
            $stmt->bind_param("ssss",$_POST['firstname'],$_POST['lastname'],$_POST['email'],md5($_POST['password']));
            $stmt->execute();
            if($this->db->error){
                array_push($this->errors, "?????????????? ??????????????, ?????????????????? ??????????????");
                return False;
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
            array_push($this->errors, "???????????? ???? ??????????????????????");
        }
        if(strlen($_POST['password'])<8){
            array_push($this->errors, "?????????????? ???????????? ?????? ???????? ???????????? 8 ????????????????");
        }
        /*if(!filter_val($_POST['email'],FILTER_VALIDATE_EMAIL)){
            array_push($this->errors, "???????????? ?????????? ????????????????????????");
        }*/
        $stmt = $this->db->prepare("SELECT id FROM users WHERE email=?");
        $stmt->bind_param("s",$_POST['email']);
        $stmt->execute();
        $response = $stmt->get_result();
        if($user = $response->fetch_array()){
            array_push($this->errors, "?????????? ?????? ??????????????");
        }
    }

    //Check user data
    private function checkLogin(){
        if(strlen($_POST['password'])<8){
            array_push($this->errors, "?????????????? ???????????? ?????? ???????? ???????????? 8 ????????????????");
            return;
        }
        /*if(!filter_val($_POST['email'],FILTER_VALIDATE_EMAIL)){
            array_push($this->errors, "???????????? ?????????? ????????????????????????");
        }*/
        
        if($_POST['email']===ADMIN_USERNAME && $_POST['password']===ADMIN_PASSWORD){
            $this->isAdmin = True;
            return;
        }
        $user = null;
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email=?");
        $stmt->bind_param("s",$_POST['email']);
        $stmt->execute();
        $response = $stmt->get_result();
        if(!$user = $response->fetch_array()){
            array_push($this->errors, "???????????? ???? ??????????");
        }
        else{
            if(md5($_POST['password'])!==$user['password']){
                array_push($this->errors, "???????????? ????????????????????????");
            }
            else{
                $this->data = $user;
            }
        }
    }

    //Exit from account
    public function logout(){
        session_destroy();
        $this->process->redirect("login");
    }
}