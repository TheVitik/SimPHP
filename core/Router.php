<?php
namespace Core;
use Core\Process;
class Router{
    private $routes = [];
    private $error = False;
    public function __construct($routes){
        $this->routes = $routes;
    }

    public function run(){
        $count = 0;
        foreach($this->routes as $route){
            $count+=1;
            if(empty($route['method']) || empty($route['uri'])){
                echo "Route error: [data/routes.php][$count] - ".json_encode($route).". Required values are missing.";
                die();
            }
            if($route['uri']===$this->normalize($_SERVER['REQUEST_URI'])){
                if ($_SERVER['REQUEST_METHOD'] === $route['method']) {
                    return new Process($route);
                }
            }
        }
        return new Process(["method"=>"GET","uri"=>"/404","view"=>"404"]);
    }

    public function execute($process){
        $route = $process->getRoute();
        if(!empty($route['access'])){
            if(!$process->access($route['access'])){
                $process->redirect($process->redirect_to);
            }
        }
        if(!empty($route['view'])){
            $process->show($route['view']);
        }
        if(!empty($route['action'])){
            if(str_contains($route['action'],"/")){
                $arr = explode("/",$route['action']);
                $process->call($arr[0],$arr[1]);
            }
            
        }
    }

    public function normalize($uri){
        if(str_contains($uri,"?")){
            return substr($uri, 0, strpos($uri,"?"));
        }
        return $uri;
    }
}