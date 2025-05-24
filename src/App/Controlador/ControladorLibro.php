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
        $archivoLibros = __DIR__ . '/../../libros.txt';
        $carpetaImagenes = __DIR__ . '/../../../public/images/libros/';

        if (!file_exists($carpetaImagenes)) {
            mkdir($carpetaImagenes, 0755, true);
        }

        // Validar que la petición sea POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo "Método no permitido";
            exit;
        }

        // Validaciones básicas
        $titulo = trim($_POST["titulo"] ?? "");
        $autor = trim($_POST["autor"] ?? "");
        $descripcion = trim($_POST["descripcion"] ?? "");
        $precio = trim($_POST["precio"] ?? "");
        $imagen = $_FILES["imagen"] ?? null;

        if ($titulo === "" || $autor === "" || $descripcion === "" || $precio === "" || !$imagen) {
            echo "<script>alert('Faltan campos requeridos'); window.history.back();</script>";
            return;
        }

        if ($imagen["error"] !== UPLOAD_ERR_OK) {
            echo "<script>alert('Error al subir la imagen'); window.history.back();</script>";
            return;
        }

        // Guardar imagen
        $nombreImagenSeguro = uniqid() . "_" . basename($imagen["name"]);
        $rutaImagen = $carpetaImagenes . $nombreImagenSeguro;
        $rutaRelativa = "/images/libros/" . $nombreImagenSeguro; // Usar ruta relativa web correcta

        if (!move_uploaded_file($imagen["tmp_name"], $rutaImagen)) {
            echo "<script>alert('Error al guardar la imagen'); window.history.back();</script>";
            return;
        }

        $nuevoId = 1;
        if (file_exists($archivoLibros)) {
            $lineas = file($archivoLibros, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            if (!empty($lineas)) {
                $ultimaLinea = end($lineas);
                $partes = explode("|", $ultimaLinea);
                if (is_numeric($partes[0])) {
                    $nuevoId = intval($partes[0]) + 1;
                }
            }
        }

        // Armar línea para guardar
        $linea = implode("|", [
            $nuevoId,
            $titulo,
            $autor,
            $descripcion,
            $precio,
            $rutaRelativa
        ]) . PHP_EOL;

        // Guardar línea
        if (file_put_contents($archivoLibros, $linea, FILE_APPEND) === false) {
            echo "<script>alert('Error al guardar el libro'); window.history.back();</script>";
            return;
        }

        // Éxito: redirigir a página principal u otra
        echo "<script>
            alert('✅ Libro guardado exitosamente');
            window.location.href = '/';
        </script>";
    }
}