<?php

namespace PAW\App\Controlador;

class ControladorPagina{
    public string $viewsDir;

    public function __construct(){
        $this->viewsDir = __DIR__ ."";
    }
}