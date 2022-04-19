<?php
namespace Core;
class Process{
    private $route;
    //View
    protected $view_dir = ROOT."/app/views/";
    protected $controller_dir = ROOT."/app/controllers/";
    protected $access_dir = ROOT."/app/access/";
    protected $error_page = ROOT."/app/views/404.template.php";



    public $redirect_to = "";
    public function __construct($route){
        $this->route = $route;
    }
    //Return view
    public function show($name,$scope=[]){
        $view = $this->view_dir.$name.".template.php";
        if(file_exists($view)){

            require_once($view);
        }
        else{
            require_once($this->error_page);
        }
    }

    public function call($name,$action){
        $file = $this->controller_dir.$name.".php";
        if(file_exists($file)){
            require_once($file);
        }
        else{
            echo "Controller not found";
            return;
        }
        $path = "\\App\\Controllers\\$name";
        $instance = new $path();
        if(is_callable(array($instance, $action))){
            $instance->$action();
        }else{
            echo "Function <b>$action()</b> not found in <i>$path</i>";
        }
    }

    public function access($name){
        $name = ucfirst($name)."Access";
        $file = $this->access_dir.$name.".php";
        if(file_exists($file)){
            require_once($file);
        }
        else{
            echo "Access file not found";
            return;
        }
        $path = "\\App\\Access\\$name";
        $action = "check";
        $instance = new $path();
        if(is_callable(array($instance, $action))){
            $this->redirect_to = $instance->getURL();
            return $instance->$action();
        }else{
            return False;
        }
    }

    public function redirect($url){
        header("Location: $url");
    }

    public function getRoute(){
        return $this->route;
    }
}