<?php

require __DIR__ . '/../vendor/autoload.php';

use PAW\src\App\Controlador\ControladorPagina;

$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();



$path = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

$controller = new ControladorPagina;

/*var_dump($path);
exit;*/


if($path == "/"){
    $controller->index();
}else if($path == '/Catálogo'){
    $controller->catalogo();
}else if($path == '/Más vendidos'){
    $controller->masvendidos();
}else if($path == '/Novedades'){
    $controller->novedades();
}else if($path == '/Recomendados'){
    $controller->recomendados();
}else if($path == '/Promociones'){
    $controller->promociones();
}elseif($path == '/Como comprar' || $path == '/como-comprar'){
    $controller->comocomprar();
}elseif($path == '/Mi cuenta'){
    $controller->micuenta();
}else if($path == '/quienes-somos'){
    $controller->quienessomos();
}else if($path == '/locales'){
    $controller->locales();
}else if($path == '/carrito'){
    $controller->carrito();
}else{
    http_response_code(404);
    require '../src/404.view.php';
}

/*require '../src/includes/header.php';
require '../src/index.view.php';
require '../src/includes/footer.php';*/