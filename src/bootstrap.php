<?php

require __DIR__ . '/../vendor/autoload.php';

use PAW\src\Core\Router;
use PAW\src\Core\Config;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use PAW\src\Core\Request;

$config = new Config;

$log = new Logger('PawPrints-app');
$handler = new StreamHandler($config->get("LOG_PATH"));
$handler-> setLevel($config->get("LOG_LEVEL"));
$log->pushHandler($handler);


$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

$request = new Request;

$router = new Router([$config]);
$router->setLogger($log);
$router->get("/", "ControladorPagina@index");
$router->get("/catalogo", "ControladorPagina@catalogo");
$router->get("/descargar_catalogo", "ControladorPagina@descargarCatalogo");
$router->get("/mas-vendidos", "ControladorPagina@masVendidos");
$router->get("/novedades", "ControladorPagina@novedades");
$router->get("/recomendados", "ControladorPagina@recomendados");
$router->get("/promociones", "ControladorPagina@promociones");
$router->get("/como-comprar", "ControladorPagina@comoComprar");
$router->get("/mi-cuenta", "ControladorPagina@miCuenta");
$router->post("/mi-cuenta", "ControladorPagina@procesarLogin");
$router->get("/recuperar-contraseña", "ControladorPagina@recuperarContraseña");
$router->post("/recuperar-contraseña", "ControladorPagina@procesarRecuperarContraseña");
$router->get("/registro", "ControladorPagina@registro");
$router->post("/registro", "ControladorPagina@procesarRegistro");
$router->get("/quienes-somos", "ControladorPagina@quienesSomos");
$router->get("/locales", "ControladorPagina@locales");
$router->get("/carrito", "ControladorPagina@carrito");
$router->get("/detalle-libro", "ControladorPagina@detalleLibro");
$router->get("/reservar", "ControladorPagina@reservarLibro");
$router->post("/reservar", "ControladorPagina@procesarReservarLibro");
$router->get("/subir-libro", "ControladorPagina@subirLibro");
$router->post("/procesar-libro", "ControladorPagina@procesarSubirLibro");