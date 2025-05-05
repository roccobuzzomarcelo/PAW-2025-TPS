<?php

namespace PAW\src\App\Controlador;

class ControladorPagina{
    public string $viewsDir;

    public function __construct(){
        $this->viewsDir = __DIR__ ."/../../";
        $this->menu = [
            [
                "href" => "/catalogo",
                "name" => "Catálogo"
            ],
            [
                "href" => "/mas-vendidos",
                "name" => "Más vendidos"
            ],
            [
                "href" => "/novedades",
                "name" => "Novedades"
            ],
            [
                "href" => "/recomendados",
                "name" => "Recomendados"
            ],
            [
                "href" => "/promociones",
                "name" => "Promociones"
            ],
            [
                "href" => "/como-comprar",
                "name" => "Como comprar"
            ],
            [
                "href" => "/mi-cuenta",
                "name" => "Mi cuenta"
            ]
        ];
    }

    public function obtenerLibros($ids){
        $libros = file(__DIR__ . '/../../libros.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $resultado = [];

        foreach ($libros as $linea) {
            list($id, $titulo, $autor, $descripcion, $precio, $img) = explode("|", $linea);

            // Si hay filtro y este ID no está en la lista, se omite
            if ($ids && !in_array($id, $ids)) continue;

            $resultado[] = [
                'id' => $id,
                'titulo' => $titulo,
                'autor' => $autor,
                'descripcion' => $descripcion,
                'precio' => $precio,
                'img' => $img
            ];
        }
        return $resultado;
    }

    public function index(){
        $novedades = $this->obtenerLibros([5, 7]); // IDs de los libros nuevos
        $masVendidos = $this->obtenerLibros([1, 3, 6]); // IDs de los libros más vendidos
        $recomendados = $this->obtenerLibros([1, 2, 3, 4, 5]); // IDs de los libros recomendados
        require $this->viewsDir . 'index.view.php';
    }

    public function catalogo(){
        $libros = $this->obtenerLibros(null);
        require $this->viewsDir .'catalog.view.php';
    }

    public function masvendidos(){
        $libros = $this->obtenerLibros([1, 3, 6]); // IDs de los libros más vendidos
        require $this->viewsDir . 'mas-vendidos.view.php';
    }

    public function novedades(){
        $libros = $this->obtenerLibros([5, 7]); // IDs de los libros nuevos
        require $this->viewsDir . 'novedades.view.php';
    }

    public function recomendados(){
        $libros = $this->obtenerLibros([1, 2, 3, 4, 5]); // IDs de los libros recomendados
        require $this->viewsDir . 'recomendados.view.php';
    }

    public function promociones(){
        $libros = $this->obtenerLibros([2, 3, 4]); // IDs de los libros en promoción
        require $this->viewsDir . 'promociones.view.php';
    }

    public function comocomprar(){
        require $this->viewsDir . 'como-comprar.view.php';
    }

    public function micuenta(){
        require $this->viewsDir . 'mi-cuenta.view.php';
    }

    public function quienessomos(){
        require $this->viewsDir . 'quienes-somos.view.php';
    }

    public function locales(){
        require $this->viewsDir . 'locales.view.php';
    }

    public function carrito(){
        require $this->viewsDir . 'carrito.view.php';
    }


}