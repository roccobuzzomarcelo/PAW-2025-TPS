<?php

namespace PAW\src\App\Controlador;

use PAW\src\Core\Controlador;

class ControladorPagina extends Controlador
{
    public function comoComprar()
    {
        global $twig;
        echo $twig->render('como-comprar.view.twig', [
            "titulo" => "PAWPrints - Cómo comprar",
            "menu" => $this->menu,
            "htmlClass" => "preguntas-pages",
        ]);
    }

    public function quienesSomos()
    {
        global $twig;
        echo $twig->render('quienes-somos.view.twig', [
            "titulo" => "PAWPrints - Quiénes somos",
            "menu" => $this->menu,
            "htmlClass" => "preguntas-pages",
        ]);
    }

    public function locales()
    {
        global $twig;
        echo $twig->render('locales.view.twig', [
            "titulo" => "PAWPrints - Locales",
            "menu" => $this->menu,
            "htmlClass" => "preguntas-pages",
        ]);
    }
}