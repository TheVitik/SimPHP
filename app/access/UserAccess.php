<?php
namespace App\Access;
use Core\Default\Access;
class UserAccess extends Access{
    //access name
    protected $name = "user";

    //Redirect to url, if no access
    protected $url  = "/login";
    /*
    / Return Boolean
    */
    public function check(){
        if(isset($_SESSION['user'])){
            return True;
        }
        return False;
    }
    public function getURL(){
        return $this->url;
    }
}