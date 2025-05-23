<?php

namespace PAW\src\App\Controlador;

use PAW\src\Core\Controlador;
use PAW\src\App\Modelos\ColeccionLibros;

class ControladorLibro extends Controlador{

    public ?string $modelo = ColeccionLibros::class;

    public function index(){
        $titulo = "PAWPrints - Catálogo";
        $htmlClass = "catalogo-pages";

        // Capturar parámetros GET
        $pagina = isset($_GET['pagina']) ? max(1, (int)$_GET['pagina']) : 1;
        $librosPorPagina = isset($_GET['libros_por_pagina']) ? (int)$_GET['libros_por_pagina'] : 10;
        $consulta = isset($_GET['consulta']) ? trim($_GET['consulta']) : '';

        // Obtener resultados paginados
        $resultado = $this->modeloInstancia->getLibrosPaginados($consulta, null, $pagina, $librosPorPagina);
        $libros = $resultado['libros'];
        $totalPaginas = $resultado['totalPaginas'];

        // Recalcular si se pidió una página inválida
        if ($pagina > $totalPaginas) {
            $pagina = $totalPaginas;
            $resultado = $this->modeloInstancia->getLibrosPaginados($consulta, null, $pagina, $librosPorPagina);
            $libros = $resultado['libros'];
        }

        // Renderizar vista
        require $this->viewsDir . 'catalog.view.php';
    }

    public function get(){

    }

    public function edit(){

    }

    public function set(){

    }
}