<?php

namespace PAW\src\App\Controlador;

use PAW\src\Core\Controlador;
use PAW\src\App\Modelos\ColeccionLibros;

class ControladorLibro extends Controlador{

    public ?string $modelo = ColeccionLibros::class;

    public function index(){
        global $request;
        $titulo = "PAWPrints - Catálogo";
        $htmlClass = "catalogo-pages";

        // Capturar parámetros GET
        $valorPag = $request->get('pagina');
        $pagina = isset($valorPag) ? max(1, (int) $valorPag) : 1;
        $libPorPag = $request->get('libros_por_pagina');
        $librosPorPagina = isset($libPorPag) ? (int)$libPorPag : 10;
        $valorConsulta = $request->get('consulta');
        $consulta = isset($valorConsulta) ? trim($valorConsulta) : '';

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

    public function descargarCatalogo(){
        global $request;
        $consulta = $request->get('consulta');
        $pagina = $request->get('pagina') ?? 1;
        $librosPorPagina = $request->get('libros_por_pagina') ?? 10;
        $resultado = $this->modeloInstancia->getLibrosPaginados($consulta, null, $pagina, $librosPorPagina);
        $libros = $resultado['libros'];
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="catalogo.csv"');

        $output = fopen('php://output', 'w');
        fputcsv($output, ['ID', 'Título', 'Autor', 'Descripción', 'Precio', 'Imagen']);

        foreach ($libros as $libro) {
            fputcsv($output, [
                $libro->campos['id'],
                $libro->campos['titulo'],
                $libro->campos['autor'],
                $libro->campos['descripcion'],
                $libro->campos['precio'],
                $libro->campos['ruta_a_imagen']
            ]);
        }
        fclose($output);
    }

    public function libroNoEncontrado()
    {
        http_response_code(404);
        require $this->viewsDir . '404.view.php';
    }

    public function get(){
        global $request;
        $htmlClass = "libro-pages";
        $id = $request->get('id');
        $libro = $this->modeloInstancia->get($id);
        if (empty($libro)) {
            $this->libroNoEncontrado();
            return;
        }
        $mismoAutor = $this->modeloInstancia->getLibrosPaginados($libro->campos['autor']);
        $mismoAutorLibros = $mismoAutor['libros'];
        $titulo = htmlspecialchars($libro->campos['titulo']);

        require $this->viewsDir . 'libro.view.php';
    }

    public function edit(){

    }

    public function set(){

    }
}