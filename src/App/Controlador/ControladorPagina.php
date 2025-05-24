<?php

namespace PAW\src\App\Controlador;

use PAW\src\Core\Controlador;

class ControladorPagina extends Controlador
{
    public function obtenerLibros($consulta = null, $ids = null)
    {
        $ruta = __DIR__ . '/../../libros.txt';
        $libros = [];

        if (!file_exists($ruta))
            return [];

        $lineas = file($ruta, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($lineas as $linea) {
            [$id, $titulo, $autor, $descripcion, $precio, $imagen] = explode('|', $linea);

            // Filtro por IDs (si se pasaron)
            if ($ids !== null && !in_array($id, $ids))
                continue;

            // Filtro por búsqueda textual (si se pasó)
            if ($consulta !== null && stripos($titulo, $consulta) === false && stripos($autor, $consulta) === false) {
                continue;
            }

            $libros[] = [
                'id' => $id,
                'titulo' => $titulo,
                'autor' => $autor,
                'descripcion' => $descripcion,
                'precio' => $precio,
                'ruta_a_imagen' => $imagen
            ];
        }

        return $libros;
    }

    public function libroNoEncontrado()
    {
        http_response_code(404);
        require $this->viewsDir . '404.view.php';
    }

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

    public function carrito()
    {
        $titulo = 'PAWPrints - Carrito de compras';
        $htmlClass = "carrito-pages";
        $id = $_GET['id'] ?? null;
        $libros = $this->obtenerLibros(null, [$id]);
        if (empty($libros)) {
            $this->libroNoEncontrado();
            return;
        }
        $libro = $libros[0];
        require $this->viewsDir . 'carrito.view.php';
    }
}