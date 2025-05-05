<?php

require __DIR__ . '/../src/bootstrap.php';

use PAW\src\App\Controlador\ControladorPagina;
use PAW\src\App\Controlador\ControladorError;

$path = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

$log->info("Petición a: {$path}");

$controller = new ControladorPagina;

/*var_dump($path);
exit;*/


if($path == "/"){
    $controller->index();
    $log->info("Respuesta exitosa:200");
}else if($path == '/catalogo'){
    $controller->catalogo();
    $log->info("Respuesta exitosa:200");
}else if($path == '/mas-vendidos'){
    $controller->masvendidos();
    $log->info("Respuesta exitosa:200");
}else if($path == '/novedades'){
    $controller->novedades();
    $log->info("Respuesta exitosa:200");
}else if($path == '/recomendados'){
    $controller->recomendados();
    $log->info("Respuesta exitosa:200");
}else if($path == '/promociones'){
    $controller->promociones();
    $log->info("Respuesta exitosa:200");
}elseif($path == '/como-comprar' || $path == '/como-comprar'){
    $controller->comocomprar();
    $log->info("Respuesta exitosa:200");
}elseif($path == '/mi-cuenta'){
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