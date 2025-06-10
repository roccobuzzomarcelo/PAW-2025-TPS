<?php

namespace PAW\src\App\Controlador;

use PAW\src\Core\Controlador;

class ControladorError extends Controlador{

    public function notFound()
    {
        if (!headers_sent()) {
            http_response_code(404);
        }
        global $twig;
        echo $twig->render('404.view.twig', [
            "titulo" => "Pagina no Encontrada",
            "menu" => $this->menu,
        ]);
    }

    public function errorInterno(){
        if (!headers_sent()) {
            http_response_code(500);
        }
        global $twig;
        echo $twig->render('500.view.twig', [
            "titulo" => "Error Interno",
            "menu" => $this->menu,
        ]);
    }
}