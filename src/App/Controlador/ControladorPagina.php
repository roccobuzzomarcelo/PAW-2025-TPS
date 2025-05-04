<?php

namespace PAW\src\App\Controlador;

class ControladorPagina{
    public string $viewsDir;

    public function __construct(){
        $this->viewsDir = __DIR__ ."/../../";
        $this->menu = [
            [
                "href" => "/Catálogo",
                "name" => "Catálogo"
            ],
            [
                "href" => "/Más vendidos",
                "name" => "Más vendidos"
            ],
            [
                "href" => "/Novedades",
                "name" => "Novedades"
            ],
            [
                "href" => "/Recomendados",
                "name" => "Recomendados"
            ],
            [
                "href" => "/Promociones",
                "name" => "Promociones"
            ],
            [
                "href" => "/Como comprar",
                "name" => "Como comprar"
            ],
            [
                "href" => "/Mi cuenta",
                "name" => "Mi cuenta"
            ]
        ];
        
    }

    public function index(){
        require $this->viewsDir . 'index.view.php';
    }

    public function catalogo(){
        require $this->viewsDir .'catalog.view.php';
    }

    public function masvendidos(){
        require $this->viewsDir . 'mas-vendidos.view.php';
    }

    public function novedades(){
        require $this->viewsDir . 'novedades.view.php';
    }

    public function recomendados(){
        require $this->viewsDir . 'recomendados.view.php';
    }

    public function promociones(){
        require $this->viewsDir . 'promociones.view.php';
    }

    public function comocomprar(){
        require $this->viewsDir . 'como-comprar.view.php';
    }

    public function micuenta(){
        require $this->viewsDir . 'mi-cuenta.view.php';
    }

    public function quienessomos(){
        require $this->viewsDir . 'includes/quienes-somos.php';
    }

    public function locales(){
        require $this->viewsDir . 'locales.view.php';
    }

    public function carrito(){
        require $this->viewsDir . 'carrito.view.php';
    }


}