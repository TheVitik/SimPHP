<?php
namespace App\Access;
use Core\Default\Access;
class GuestAccess extends Access{
    //access name
    protected $name = "guest";

    //Redirect to url, if no access
    protected $url  = "/account";
    /*
    / Return Boolean
    */
    public function check(){
        if(!isset($_SESSION['user'])){
            return True;
        }
        return False;
    }
    public function getURL(){
        return $this->url;
    }
}