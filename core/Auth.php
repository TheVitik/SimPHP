<?php
namespace Core;
use App\Models\User;
class Auth{

    public static function isLogged(){
        if(isset($_SESSION['user'])){
            return True;
        }
        return False;
    }
    
    public static function user(){
        if(self::isLogged()){
            return unserialize($_SESSION['user']);
        }
        return null;
    }
    public static function isAdmin(){
        if(isset($_SESSION['admin'])){
            return True;
        }
        return False;
    }
}