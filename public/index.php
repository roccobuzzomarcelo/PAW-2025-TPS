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
    require './includes/header.php';
    require 'index.view.php';
    require './includes/footer.php';

?>
