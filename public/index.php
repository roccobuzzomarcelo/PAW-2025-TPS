<?php

require __DIR__ . '/../vendor/autoload.php';

use PAW\src\App\Controlador\ControladorPagina;
use PAW\src\App\Controlador\ControladorError;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$log =new Logger('PawPrints-app');
$log->pushHandler(new StreamHandler(__DIR__ . '/../log/app.log', Logger::DEBUG));

$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();



$path = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

$log->info("Petición a: {$path}");

$controller = new ControladorPagina;

/*var_dump($path);
exit;*/


if($path == "/"){
    $controller->index();
    $log->info("Respuesta exitosa:200");
}else if($path == '/Catálogo'){
    $controller->catalogo();
    $log->info("Respuesta exitosa:200");
}else if($path == '/Más vendidos'){
    $controller->masvendidos();
    $log->info("Respuesta exitosa:200");
}else if($path == '/Novedades'){
    $controller->novedades();
    $log->info("Respuesta exitosa:200");
}else if($path == '/Recomendados'){
    $controller->recomendados();
    $log->info("Respuesta exitosa:200");
}else if($path == '/Promociones'){
    $controller->promociones();
    $log->info("Respuesta exitosa:200");
}elseif($path == '/Como comprar' || $path == '/como-comprar'){
    $controller->comocomprar();
    $log->info("Respuesta exitosa:200");
}elseif($path == '/Mi cuenta'){
    $controller->micuenta();
    $log->info("Respuesta exitosa:200");
}else if($path == '/quienes-somos'){
    $controller->quienessomos();
    $log->info("Respuesta exitosa:200");
}else if($path == '/locales'){
    $controller->locales();
    $log->info("Respuesta exitosa:200");
}else if($path == '/carrito'){
    $controller->carrito();
    $log->info("Respuesta exitosa:200");
}else{
    $controller= new ControladorError; 
    $controller->notFound();
    $log->info("Página no encontrada: 404");
}

/*require '../src/includes/header.php';
require '../src/index.view.php';
require '../src/includes/footer.php';*/