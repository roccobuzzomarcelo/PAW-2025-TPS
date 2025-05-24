<?php

namespace PAW\src\App\Controlador;

use PAW\src\Core\Controlador;

class ControladorPagina extends Controlador
{
    public function comoComprar()
    {
        $titulo = "PAWPrints - Cómo comprar";
        $htmlClass = "preguntas-pages";
        require $this->viewsDir . 'como-comprar.view.php';
    }

    public function quienesSomos()
    {
        $titulo = 'PAWPrints - Quiénes somos';
        $htmlClass = "preguntas-pages";
        require $this->viewsDir . 'quienes-somos.view.php';
    }

    public function locales()
    {
        $titulo = 'PAWPrints - Locales';
        $htmlClass = "preguntas-pages";
        require $this->viewsDir . 'locales.view.php';
    }
}