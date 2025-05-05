<?php

require __DIR__ . '/../vendor/autoload.php';

use PAW\src\Core\Router;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;


$log =new Logger('PawPrints-app');
$log->pushHandler(new StreamHandler(__DIR__ . '/../log/app.log', Logger::DEBUG));


$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();


$router = new Router;
$router->get("/", "ControladorPagina@index");
$router->get("/catalogo", "ControladorPagina@catalogo");
$router->get("/mas-vendidos", "ControladorPagina@masVendidos");
$router->get("/novedades", "ControladorPagina@novedades");
$router->get("/recomendados", "ControladorPagina@recomendados");
$router->get("/promociones", "ControladorPagina@promociones");
$router->get("/como-comprar", "ControladorPagina@comoComprar");
$router->get("/mi-cuenta", "ControladorPagina@miCuenta");
$router->get("/quienes-somos", "ControladorPagina@quienesSomos");
$router->get("/locales", "ControladorPagina@locales");
$router->get("/carrito", "ControladorPagina@carrito");
$router->get("/detalle-libro", "ControladorPagina@detalleLibro");
$router->get("/reservar", "ControladorPagina@reservarLibro");
$router->post("/reservar", "ControladorPagina@procesarReservarLibro");
$router->get("not-found","ControladorError@notFound");
$router->get("error-interno","ControladorError@errorInterno");