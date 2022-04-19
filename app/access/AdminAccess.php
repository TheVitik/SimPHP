<?php
namespace App\Access;
use Core\Default\Access;
class AdminAccess extends Access{
    //access name
    protected $name = "admin";

    //Redirect to url, if no access
    protected $url  = "/";
    /*
    / Return Boolean
    */
    public function check(){
        if(isset($_SESSION['admin'])){
            return True;
        }
        return False;
    }
    public function getURL(){
        return $this->url;
    }
}