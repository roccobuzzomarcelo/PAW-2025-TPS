<?php

namespace PAW\src\Core;

use PAW\src\Core\Exceptions\RouteNotFoundException;

class Router{
    public array $rutas;
    public function cargarRutas($path, $accion){
        $this->rutas[$path] = $accion;
    }

    public function dirigir($path){
        if(!array_key_exists($path, $this->rutas)){
            throw new RouteNotFoundException("No existe la ruta {$path}");
        }
        list($controlador, $metodo) = explode("@", $this->rutas[$path]);
        $nombreClase = "PAW\\src\\App\\Controlador\\{$controlador}";
        $controladorObjeto = new $nombreClase();
        $controladorObjeto->$metodo();
    }
}
