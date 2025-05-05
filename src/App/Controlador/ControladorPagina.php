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
    
    public function libroNoEncontrado(){
        http_response_code(404);
        require $this->viewsDir . '404.view.php';
    }

    public function index(){
        $titulo = "PawPrints - Inicio";
        $novedades = $this->obtenerLibros(null, [5, 7]); // IDs de los libros nuevos
        $masVendidos = $this->obtenerLibros(null, [1, 3, 6]); // IDs de los libros más vendidos
        $recomendados = $this->obtenerLibros(null, [1, 2, 3, 4, 5]); // IDs de los libros recomendados
        require $this->viewsDir . 'index.view.php';
    }

    public function catalogo(){
        $titulo = "PawPrints - Catálogo";
        $htmlClass = "catalogo-pages";
        $consulta = $_GET['consulta'] ?? null;
        $libros = $this->obtenerLibros($consulta);
        require $this->viewsDir .'catalog.view.php';
    }

    public function masVendidos(){
        $titulo = "PawPrints - Más vendidos";
        $htmlClass = "catalogo-pages";
        $libros = $this->obtenerLibros(null, [1, 3, 6]); // IDs de los libros más vendidos
        require $this->viewsDir . 'mas-vendidos.view.php';
    }

    public function novedades(){
        $titulo = "PawPrints - Novedades";
        $htmlClass = "catalogo-pages";
        $libros = $this->obtenerLibros(null, [5, 7]); // IDs de los libros nuevos
        require $this->viewsDir . 'novedades.view.php';
    }

    public function recomendados(){
        $titulo = "PawPrints - Recomendados";
        $htmlClass = "catalogo-pages";
        $libros = $this->obtenerLibros(null, [1, 2, 3, 4, 5]); // IDs de los libros recomendados
        require $this->viewsDir . 'recomendados.view.php';
    }

    public function promociones(){
        $titulo = "PawPrints - Promociones";
        $htmlClass = "catalogo-pages";
        $libros = $this->obtenerLibros(null, [2, 3, 4]); // IDs de los libros en promoción
        require $this->viewsDir . 'promociones.view.php';
    }

    public function comoComprar(){
        $titulo = "PawPrints - Cómo comprar";
        $htmlClass = "preguntas-pages";
        require $this->viewsDir . 'como-comprar.view.php';
    }

    public function miCuenta(){
        $titulo = 'PawPrints - Mi cuenta';
        $htmlClass = "mi-cuenta-pages";
        require $this->viewsDir . 'mi-cuenta.view.php';
    }

    public function registro(){
        $titulo = 'PawPrints - Registro';
        $htmlClass = "mi-cuenta-pages";
        require $this->viewsDir . 'registro.view.php';
    }

    public function quienesSomos(){
        $titulo = 'PawPrints - Quiénes somos';
        $htmlClass = "preguntas-pages";
        require $this->viewsDir . 'quienes-somos.view.php';
    }

    public function locales(){
        $titulo = 'PawPrints - Locales';
        $htmlClass = "preguntas-pages";
        require $this->viewsDir . 'locales.view.php';
    }

    public function carrito(){
        $titulo = 'PawPrints - Carrito de compras';
        $htmlClass = "carrito-pages";
        require $this->viewsDir . 'carrito.view.php';
    }

    public function detalleLibro(){;
        $htmlClass = "libro-pages";
        $id = $_GET['id'] ?? null;
        $libros = $this->obtenerLibros(null, [$id]);
        if (empty($libros)) {
            $this->libroNoEncontrado();
            return;
        }
        $libro = $libros[0];
        $mismoAutorLibros = $this->obtenerLibros($libro['autor']);
        $titulo = htmlspecialchars($libro['titulo']);
        require $this->viewsDir . 'detalle-libro.view.php';
    }

    public function reservarLibro(){
        $titulo = 'PawPrints - Reservar';
        $htmlClass = "libro-pages";
        $id = $_GET['id'] ?? null;
        $libros = $this->obtenerLibros(null, [$id]);
        if (empty($libros)) {
            $this->libroNoEncontrado();
            return;
        }
        $libro = $libros[0];
        require $this->viewsDir . 'reservar-libro.view.php';
    }

    public function procesarReservarLibro(){
        // Recoger los datos del formulario
        $id = $_POST['libro_id'];
        $nombre = $_POST['inputNombre'];
        $apellido = $_POST['inputApellido'];
        $email = $_POST['inputEmail'];
        $telefono = $_POST['inputTel'];
        $calle = $_POST['inputCalle'];
        $numero = $_POST['inputNumero'];
        $ciudad = $_POST['inputCiudad'];
        $provincia = $_POST['inputProvincia'];
        $codigoPostal = $_POST['inputCodigoPostal'];
        $envio = $_POST['inputEnvio'];  // Aquí recogemos el valor del envío o retiro
        
        // Formatear los datos en un texto legible
        $datos = "Id Libro: $id|Nombre: $nombre|Apellido: $apellido|Email: $email|Teléfono: $telefono|Calle: $calle|Número: $numero|Ciudad: $ciudad|Provincia: $provincia|Código Postal: $codigoPostal|Envío o Retiro: $envio\n";
        
        // Ruta del archivo de texto donde se guardarán los datos
        $archivo = __DIR__ . "/../../reservas.txt";
        
        // Guardar los datos en el archivo de texto
        file_put_contents($archivo, $datos, FILE_APPEND); // FILE_APPEND agrega los datos al final del archivo

        $this->index();
    }

    public function procesarLogin(){
        // Recoger los datos del formulario
        $email = $_POST['inputEmail'];
        $password = $_POST['inputPassword'];
        $archivo = __DIR__ . "/../../login.txt";

        if (!file_exists($archivo)) {
            echo "⚠️ Archivo de usuarios no encontrado.";
            return;
        }
    
        $lineas = file($archivo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $credencialesValidas = false;
    
        foreach ($lineas as $linea) {
            list($id, $emailArchivo, $passArchivo, $nombre, $apellido) = explode('|', trim($linea));
            if ($email === $emailArchivo && $password === $passArchivo) {
                $credencialesValidas = true;
                break;
            }
        }
    
        if ($credencialesValidas) {
            $this->index();
            exit;
        } else {
            echo "❌ Email o contraseña incorrectos.";
        }
    }

    public function procesarRegistro(){
        // Recoger los datos del formulario
        $nombre = $_POST['inputNombre'];
        $apellido = $_POST['inputApellido'];
        $email = $_POST['inputEmail'];
        $password = $_POST['inputPassword'];
        $confirmarPassword = $_POST['inputConfirmarPassword'];
        if($password !== $confirmarPassword){
            echo "⚠️ Las contraseñas no coinciden.";
            return;
        }

        // Ruta del archivo de texto donde se guardarán los datos
        $archivo = __DIR__ . "/../../login.txt";
        
        $id = 1; // Si es el primero
        if (file_exists($archivo)) {
            $lineas = file($archivo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            $id = count($lineas) + 1;
        }
        // Formatear los datos en un texto legible
        $datos = "$id|$email|$password|$nombre|$apellido\n";
        
        // Guardar los datos en el archivo de texto
        file_put_contents($archivo, $datos, FILE_APPEND); // FILE_APPEND agrega los datos al final del archivo

        $this->index();
    }
}