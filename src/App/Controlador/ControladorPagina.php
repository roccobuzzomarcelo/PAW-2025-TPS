<?php

namespace PAW\src\App\Controlador;

class ControladorPagina{
    public string $viewsDir;

    public function __construct(){
        $this->viewsDir = __DIR__ ."/../views/";
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

    public function obtenerLibros($consulta = null, $ids = null) {
        $ruta = __DIR__ . '/../../libros.txt';
        $libros = [];
    
        if (!file_exists($ruta)) return [];
    
        $lineas = file($ruta, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    
        foreach ($lineas as $linea) {
            [$id, $titulo, $autor, $descripcion, $precio, $imagen] = explode('|', $linea);
    
            // Filtro por IDs (si se pasaron)
            if ($ids !== null && !in_array($id, $ids)) continue;
    
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
                'img' => $imagen
            ];
        }
    
        return $libros;
    }
    

    public function index(){
        $novedades = $this->obtenerLibros(null, [5, 7]); // IDs de los libros nuevos
        $masVendidos = $this->obtenerLibros(null, [1, 3, 6]); // IDs de los libros más vendidos
        $recomendados = $this->obtenerLibros(null, [1, 2, 3, 4, 5]); // IDs de los libros recomendados
        require $this->viewsDir . 'index.view.php';
    }

    public function catalogo(){
        $consulta = $_GET['consulta'] ?? null;
        $libros = $this->obtenerLibros($consulta);
        require $this->viewsDir .'catalog.view.php';
    }

    public function masVendidos(){
        $libros = $this->obtenerLibros(null, [1, 3, 6]); // IDs de los libros más vendidos
        require $this->viewsDir . 'mas-vendidos.view.php';
    }

    public function novedades(){
        $libros = $this->obtenerLibros(null, [5, 7]); // IDs de los libros nuevos
        require $this->viewsDir . 'novedades.view.php';
    }

    public function recomendados(){
        $libros = $this->obtenerLibros(null, [1, 2, 3, 4, 5]); // IDs de los libros recomendados
        require $this->viewsDir . 'recomendados.view.php';
    }

    public function promociones(){
        $libros = $this->obtenerLibros(null, [2, 3, 4]); // IDs de los libros en promoción
        require $this->viewsDir . 'promociones.view.php';
    }

    public function comoComprar(){
        require $this->viewsDir . 'como-comprar.view.php';
    }

    public function miCuenta(){
        require $this->viewsDir . 'mi-cuenta.view.php';
    }

    public function quienesSomos(){
        require $this->viewsDir . 'quienes-somos.view.php';
    }

    public function locales(){
        require $this->viewsDir . 'locales.view.php';
    }

    public function carrito(){
        require $this->viewsDir . 'carrito.view.php';
    }


}