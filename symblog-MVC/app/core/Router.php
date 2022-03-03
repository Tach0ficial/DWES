<?php

namespace App\Core;

class Router{
/** @var Route[] /
    /contiene nombre, ruta y array con controlador y accioón*/ 
    private $routes = array();

    public function add($route){
        $this->routes[] = $route;
    }

    public function matcher (string $request){
        $matches=array();
        foreach ($this->routes as $route) {
            $patron=$route['path'];
            if (preg_match($patron, $request)){
                $matches = $route;
            }
        }
        return $matches;
    }

}

