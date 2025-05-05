<?php

namespace PAW\src\App\Controlador;

class ControladorError{
    public string $viewsDir;

    public function __construct(){
        $this->viewsDir = __DIR__ ."/../views/";
        $this->menu = [
            [
                "href" => "/catalogo",
                "name" => "Catálogo"
            ],
            [
                "href" => "/mas-vendidos",
                "name" => "Más vendidos"
            ],
            [
                "href" => "/novedades",
                "name" => "Novedades"
            ],
            [
                "href" => "/recomendados",
                "name" => "Recomendados"
            ],
            [
                "href" => "/promociones",
                "name" => "Promociones"
            ],
            [
                "href" => "/como-comprar",
                "name" => "Como comprar"
            ],
            [
                "href" => "/mi-cuenta",
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