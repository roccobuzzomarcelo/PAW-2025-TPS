<?php

require __DIR__ . '/../vendor/autoload.php';

use PAW\src\Core\Database\ConnectionBuilder;
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

$connectionBuilder = new ConnectionBuilder;
$connectionBuilder->setLogger($log);
$connection = $connectionBuilder->make($config);

$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

$request = new Request;

$router = new Router([$config]);
$router->setLogger($log);
$router->get("/", "ControladorLibro@index");
$router->get("/catalogo", "ControladorLibro@catalogo");
$router->get("/descargar_catalogo", "ControladorLibro@descargarCatalogo");
$router->get("/mas-vendidos", "ControladorLibro@masVendidos");
$router->get("/novedades", "ControladorLibro@novedades");
$router->get("/recomendados", "ControladorLibro@recomendados");
$router->get("/promociones", "ControladorLibro@promociones");
$router->get("/subir-libro", "ControladorLibro@subirLibro");
$router->post("/subir-libro", "ControladorLibro@procesarSubirLibro");
$router->get("/libro", "ControladorLibro@get");
$router->get("/como-comprar", "ControladorPagina@comoComprar");
$router->get("/quienes-somos", "ControladorPagina@quienesSomos");
$router->get("/locales", "ControladorPagina@locales");
$router->get("/carrito", "ControladorPagina@carrito");
$router->get("/mi-cuenta", "ControladorUsuario@login");
$router->post("/mi-cuenta", "ControladorUsuario@procesarLogin");
$router->get("/editar-usuario", "ControladorUsuario@editarUsuario");
$router->post("/editar-usuario", "ControladorUsuario@procesarEditarUsuario");
$router->get("/logout", "ControladorUsuario@logout");
$router->get("/recuperar-contraseña", "ControladorUsuario@recuperarContraseña");
$router->post("/recuperar-contraseña", "ControladorUsuario@procesarRecuperarContraseña");
$router->get("/registro", "ControladorUsuario@registro");
$router->post("/registro", "ControladorUsuario@procesarRegistro");
$router->get("/reservar", "ControladorReserva@reservarLibro");
$router->post("/reservar", "ControladorReserva@procesarReservarLibro");