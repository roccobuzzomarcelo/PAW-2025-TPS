<?php

require __DIR__ . '/../vendor/autoload.php';

$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

$menu = [
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


$path = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

/*var_dump($path);
exit;*/


if($path == "/"){
    require '../src/index.view.php';
}else if($path == '/Catálogo'){
    require '../src/catalog.view.php';
}else if($path == '/Más vendidos'){
        require '../src/mas-vendidos.view.php';
}else if($path == '/Novedades'){
        require '../src/novedades.view.php';
}else if($path == '/Recomendados'){
        require '../src/recomendados.view.php';
}else if($path == '/Promociones'){
        require '../src/promociones.view.php';
}elseif($path == '/Como comprar'){
    require '../src/como-comprar.view.php';
}elseif($path == '/Mi cuenta'){
    require '../src/mi-cuenta.view.php';
}else if($path == '/quienes-somos'){
        require '../src/includes/quienes-somos.view.php';
}else{
    http_response_code(404);
    require '../src/404.view.php';
}

/*require '../src/includes/header.php';
require '../src/index.view.php';
require '../src/includes/footer.php';*/