<?php

namespace PAW\src\Core;

class Request
{
    public function url(){
        return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }

    public function method(){
        return $_SERVER['REQUEST_METHOD'];
    }

    public function route(){
        return [
            $this->url(),
            $this->method(),
        ];
    }

    public function get($clave){
        return $_POST[$clave] ?? $_GET[$clave] ?? null;
    }
}