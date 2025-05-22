<?php

namespace PAW\src\Core;

use PAW\src\Core\Exceptions\RouteNotFoundException;
use PAW\src\Core\Request;
use Exception;

class Router{
    public array $rutas = [
        "GET" => [],
        "POST" => [],
    ];

    public string $notFound = 'not-found';
    public string $errorInterno = 'error-interno';

    public array $dependencias = [];

    public function __construct(array $dependencias = []){
        $this->dependencias = $dependencias;
        $this->get($this->notFound, "ControladorError@notFound");
        $this->get($this->errorInterno, "ControladorError@errorInterno");
    }

    public function cargarRutas($path, $accion, $metodoHttp = "GET"){
        $this->rutas[$metodoHttp][$path] = $accion;
    }

    public function get($path, $accion){
        $this->cargarRutas($path, $accion, "GET");
    }

    public function post($path, $accion){
        $this->cargarRutas($path, $accion, "POST");
    }

    public function existeRuta($path, $metodoHttp){
        return array_key_exists($path, $this->rutas[$metodoHttp]);
    }

    public function getController($path, $metodoHttp){
        if(!$this->existeRuta($path, $metodoHttp)){
            throw new RouteNotFoundException("No existe la ruta {$path}");
        }
        return explode("@", $this->rutas[$metodoHttp][$path]);
    }

    public function call($controlador, $metodo){
        $nombreClase = "PAW\\src\\App\\Controlador\\{$controlador}";
        $controladorObjeto = new $nombreClase(...$this->dependencias);
        $controladorObjeto->$metodo();
    }

    public function dirigir(Request $request){
        try{
            list($path, $metodoHttp) = $request->route();
            list($controlador, $metodo) = $this->getController($path, $metodoHttp);
            $this->call($controlador, $metodo);
        }catch(RouteNotFoundException $e){
            list($controlador, $metodo) = $this->getController($this->notFound, "GET");
            $this->call($controlador, $metodo);
        }catch(Exception $e){
            list($controlador, $metodo) = $this->getController($this->errorInterno, "GET");
            $this->call($controlador, $metodo);
        }
    }
}
