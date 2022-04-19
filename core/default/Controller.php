<?php
namespace Core\Default;
class Controller{
    protected $errors = array();
    //Contstructor 
    public function __construct(){
        global $process;
        global $db;
        $this->process = $process; 
        $this->db = $db;
    }

        
    /*  Check error
    //  Return bool
    //  False if error, else True
    */  
    protected function status(){
        if(count($this->errors)>0){
            return False;
        }
        else{
            return True;
        }
    }

    public function errors(){
        return $this->errors;
    }

}