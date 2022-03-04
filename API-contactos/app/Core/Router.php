<?php
namespace App\Core;

class Router{

    private $routes = array();

    public function add($route){
        $this->routes[] = $route;
    }
    public function matchs(string $request){
        $matches=array();
        foreach ($this->routes as $route) {
            $patron = $route['path'];
            if (preg_match($patron, $request)){
                $matches = $route;
            }
        
        }
        return $matches;
    }
}



?>