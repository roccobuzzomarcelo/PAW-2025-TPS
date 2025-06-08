<?php

namespace PAW\src\App\Controlador;

use PAW\src\Core\Controlador;
use PAW\src\App\Modelos\ColeccionLibros;

class ControladorLibro extends Controlador{

    public ?string $modelo = ColeccionLibros::class;

    public function index()
    {
        $titulo = "PAWPrints - Inicio";
        $novedadesResultado = $this->modeloInstancia->getLibrosPaginados(null, [5, 7]); // IDs de los libros nuevos
        $masVendidosResultado = $this->modeloInstancia->getLibrosPaginados(null, [1, 3, 6]); // IDs de los libros más vendidos
        $recomendadosResultado = $this->modeloInstancia->getLibrosPaginados(null, [1, 2, 3, 4, 5]); // IDs de los libros recomendados
        $novedades = $novedadesResultado['libros'];
        $masVendidos = $masVendidosResultado['libros'];
        $recomendados = $recomendadosResultado['libros'];
        require $this->viewsDir . 'index.view.php';
    }

    public function catalogo(){
        $rol = $_SESSION['usuario']['rol'] ?? null;
        $permiso = false;
        if($rol == 'admin'){
            $permiso = true;
        }
        global $request;
        $titulo = "PAWPrints - Catálogo";
        $htmlClass = "catalogo-pages";

        // Capturar parámetros GET
        $valorPag = $request->get('pagina');
        $pagina = isset($valorPag) ? max(1, (int) $valorPag) : 1;
        $libPorPag = $request->get('libros_por_pagina');
        $librosPorPagina = isset($libPorPag) ? (int)$libPorPag : 10;
        $valorConsulta = $request->get('consulta');
        if (isset($valorConsulta)) {
            $consulta = trim($valorConsulta);
            $consulta = preg_replace('/[^\p{L}\p{N}\s]/u', '', $consulta);
        } else {
            $consulta = '';
        }
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

    public function masVendidos()
    {
        $titulo = "PAWPrints - Más vendidos";
        $htmlClass = "catalogo-pages";
        $resultado = $this->modeloInstancia->getLibrosPaginados(null, [1, 3, 6]); // IDs de los libros más vendidos
        $libros = $resultado['libros'];
        require $this->viewsDir . 'mas-vendidos.view.php';
    }

    public function novedades()
    {
        $titulo = "PAWPrints - Novedades";
        $htmlClass = "catalogo-pages";
        $resultado = $this->modeloInstancia->getLibrosPaginados(null, [5, 7]); // IDs de los libros nuevos
        $libros = $resultado['libros'];
        require $this->viewsDir . 'novedades.view.php';
    }

    public function recomendados()
    {
        $titulo = "PAWPrints - Recomendados";
        $htmlClass = "catalogo-pages";
        $resultado = $this->modeloInstancia->getLibrosPaginados(null, [1, 2, 3, 4, 5]); // IDs de los libros recomendados
        $libros = $resultado['libros'];
        require $this->viewsDir . 'recomendados.view.php';
    }

    public function promociones()
    {
        $titulo = "PAWPrints - Promociones";
        $htmlClass = "catalogo-pages";
        $resultado = $this->modeloInstancia->getLibrosPaginados(null, [2, 3, 4]); // IDs de los libros en promoción
        $libros = $resultado['libros'];
        require $this->viewsDir . 'promociones.view.php';
    }

    public function get(){
        global $request;
        $htmlClass = "libro-pages";
        $id = filter_var($request->get('id'), FILTER_VALIDATE_INT, ['options'=>['min_range'=>1]]);
        if (!$id) {
            return $this->libroNoEncontrado();
        }
        $libro = $this->modeloInstancia->get([$id]);
        $mismoAutor = $this->modeloInstancia->getLibrosPaginados($libro->campos['autor']);
        $mismoAutorLibros = $mismoAutor['libros'];
        $titulo = htmlspecialchars($libro->campos['titulo']);

        require $this->viewsDir . 'libro.view.php';
    }

    public function subirLibro()
    {
        $rol = $_SESSION['usuario']['rol'] ?? null;
        if($rol !== 'admin'){
            echo "<script>alert('⚠️ No tienes permiso para acceder a esta página.'); window.location.href = '/';</script>";
            return;
        }
        $titulo = "PAWPrints - Subir Libro";
        $htmlClass = "mi-cuenta-pages";
        require $this->viewsDir . 'subir-libro.view.php';
    }

    // Procesar formulario POST para subir libro
    public function procesarSubirLibro()
    {
        global $request;
        $query = trim($request->get('query'));
        $carpetaImagenes = __DIR__ . '/../../../public/images/libros/';

        if (!file_exists($carpetaImagenes)) {
            mkdir($carpetaImagenes, 0755, true);
        }

        // Validaciones básicas
        $titulo = trim($request->get("titulo") ?? "");
        $autor = trim($request->get("autor") ?? "");
        $descripcion = trim($request->get("descripcion") ?? "");
        $precio = trim($request->get("precio") ?? "");
        $rutaApi = trim($request->get('ruta_a_imagen_api') ?? '');
        $imagenFile = $_FILES['imagen'] ?? null;

        if ($titulo === "" || $autor === "" || $descripcion === "" || $precio === "" 
            || (empty($rutaApi) && (!$imagenFile || $imagenFile['error'] === UPLOAD_ERR_NO_FILE))) {
            echo "<script>alert('⚠️ Faltan campos requeridos'); window.history.back();</script>";
            return;
        }


        if ($imagen["error"] !== UPLOAD_ERR_OK) {
            echo "<script>alert('⚠️ Error al subir la imagen'); window.history.back();</script>";
            return;
        }

        // Manejo de imagen
        $imagenFile = $_FILES['imagen'] ?? null;
        $rutaRelativa = '';
        if ($imagenFile && $imagenFile['error'] === UPLOAD_ERR_OK) {
            $safeName = uniqid() . '_' . basename($imagenFile['name']);
            $dest = $carpetaImagenes . $safeName;
            if (move_uploaded_file($imagenFile['tmp_name'], $dest)) {
                $rutaRelativa = '/images/libros/' . $safeName;
            }
        }
        elseif (!empty($rutaApi)) {
            $rutaRelativa = $rutaApi;
        }

        // Si no hay imagen, buscar cover en API OpenLibrary
        if (!$rutaRelativa && $query) {
            $url = 'https://openlibrary.org/search.json?title=' . urlencode($query) . '&limit=1';
            $resp = @file_get_contents($url);
            if ($resp) {
                $data = json_decode($resp, true);
                if (!empty($data['docs'][0]['cover_i'])) {
                    $rutaRelativa = 'https://covers.openlibrary.org/b/id/' . $data['docs'][0]['cover_i'] . '-L.jpg';
                }
            }
        }

        if (empty($rutaRelativa)) {
            echo "<script>alert('⚠️ No se pudo obtener la portada del libro'); window.history.back();</script>";
            return;
        }

        $datos = [
            'titulo' => $titulo,
            'autor' => $autor,
            'descripcion' => $descripcion,
            'precio' => $precio,
            'ruta_a_imagen' => $rutaRelativa
        ];

        // Guardar línea
        if (!$this->modeloInstancia->crear($datos)) {
            echo "<script>alert('⚠️ Error al guardar el libro'); window.history.back();</script>";
            return;
        }

        // Éxito: redirigir a página principal u otra
        echo "<script>
            alert('✅ Libro guardado exitosamente');
            window.location.href = '/subir-libro';
        </script>";
    }
}