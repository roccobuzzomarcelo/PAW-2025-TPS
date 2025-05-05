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
$router->cargarRutas("/", "ControladorPagina@index");
$router->cargarRutas("/catalogo", "ControladorPagina@catalogo");
$router->cargarRutas("/mas-vendidos", "ControladorPagina@masVendidos");
$router->cargarRutas("/novedades", "ControladorPagina@novedades");
$router->cargarRutas("/recomendados", "ControladorPagina@recomendados");
$router->cargarRutas("/promociones", "ControladorPagina@promociones");
$router->cargarRutas("/como-comprar", "ControladorPagina@comoComprar");
$router->cargarRutas("/mi-cuenta", "ControladorPagina@miCuenta");
$router->cargarRutas("/quienes-somos", "ControladorPagina@quienesSomos");
$router->cargarRutas("/locales", "ControladorPagina@locales");
$router->cargarRutas("/carrito", "ControladorPagina@carrito");
$router->cargarRutas("not-found","ControladorError@notFound");
$router->cargarRutas("error-interno","ControladorError@errorInterno");