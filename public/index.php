<?php

$menu = [
    [
        "href" => "/catalogo/catalogo.html",
        "name" => "Catálogo"
    ],
    [
        "href" => "/catalogo/mas-vendidos.html",
        "name" => "Más vendidos"
    ],
    [
        "href" => "/catalogo/novedades.html",
        "name" => "Novedades"
    ],
    [
        "href" => "/catalogo/recomendados.html",
        "name" => "Recomendados"
    ],
    [
        "href" => "/catalogo/promociones.html",
        "name" => "Promociones"
    ],
    [
        "href" => "preguntas/como-comprar.html",
        "name" => "Como comprar"
    ],
    [
        "href" => "mi-cuenta/mi-cuenta.html",
        "name" => "Mi cuenta"
    ]
];

require '../src/includes/header.php';
require '../src/index.view.php';
require '../src/includes/footer.php';

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if($path == "/"){
    require '../src/index.view.php';
}else if($path == 'about'){
    require '../src/about.view.php';
}elseif($path == 'catalogo'){
    require '../src/catalog.view.php';
}elseif($path == 'preguntas'){
    require '../src/faq.view.php';
}elseif($path == 'mi-cuenta'){
    require '../src/account.view.php';
}else{
    http_response_code(404);
    require '../src/404.view.php';
}