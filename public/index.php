<?php

require __DIR__ . '/../src/bootstrap.php';

use PAW\src\Core\Exceptions\RouteNotFoundException;

$path = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

$log->info("Petición a: {$path}");

try{
    $router->dirigir($path);
    $log->info("Código: 200 - Página encontrada",["Ruta" => $path]);
}catch(RouteNotFoundException $e){
    $router->dirigir("not-found");
    $log->info("Codigo: 404 - Página no encontrada",["Error" => $e->getMessage()]);
}catch(Exception $e){
    $router->dirigir("error-interno");
    $log->error("Codigo: 500 - Error interno del Servidor",["Error" => $e->getMessage()]);
}

/*var_dump($path);
exit;*/
