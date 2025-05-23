<?php

namespace PAW\src\Core;

use PAW\src\Core\Modelo;
use PAW\src\Core\Database\QueryBuilder;

class Controlador{
    public string $viewsDir;

    protected Config $config;
    public array $menu;

    public ?string $modelo = null;
    protected ?Modelo $modeloInstancia = null;

    public function __construct(Config $config)
    {
        global $connection;
        $this->config = $config;
        $this->viewsDir = __DIR__ . "/../App/views/";
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
        if(!is_null($this->modelo)){
            $qb = new QueryBuilder($connection);
            $model = new $this->modelo;
            $model->setQueryBuilder($qb);
            $this->setModelo($model);
        }
    }
    public function setModelo(Modelo $modelo){
        $this->modeloInstancia = $modelo;
    }
}