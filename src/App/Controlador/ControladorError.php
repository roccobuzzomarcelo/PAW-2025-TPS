<?php

namespace PAW\src\App\Controlador;

class ControladorError{
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

    public function notFound()
    {
        http_response_code(404);
        require $this->viewsDir . '404.view.php';
    }
}