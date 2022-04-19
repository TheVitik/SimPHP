<?php
namespace App\Models;
use Core\Default\Model;
class User extends Model{
    //Public variables
    public $id;
    public $firstname;
    public $lastname;
    public $email;
    public $created_at;

    //Private variables;
    private $password;

    public function __construct($id,$firstname,$lastname,$email,$password,$created_at){
        $this->id = $id;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->email = $email;
        $this->password = $password;
        $this->created_at = $created_at;
    }
    public function datetime(){
        $date = date_create($this->created_at);
        return date_format($date,'d-m-Y H:i');
    }
}