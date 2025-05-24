<?php

namespace PAW\src\App\Controlador;

use PAW\src\Core\Controlador;
use PAW\src\App\Modelos\ColeccionCarritos;

class ControladorCarrito extends Controlador{

    public ?string $modelo = ColeccionCarritos::class;    
    
    
    public function carrito()
    {
        if(!isset($_SESSION['usuario'])){
            echo "<script>alert('⚠️ Debes iniciar sesion para acceder al carrito'); window.location.href = '/mi-cuenta'</script>";
        }
        $usuario_id = $_SESSION['usuario']["id"];
        $libros = $this->modeloInstancia->getItems($usuario_id);

        $titulo = 'PAWPrints - Carrito de compras';
        $htmlClass = "carrito-pages";
        require $this->viewsDir . 'carrito.view.php';
    }

    public function agregarCarrito()
    {
        if(!isset($_SESSION['usuario'])){
            echo "<script>alert('⚠️ Debes iniciar sesion para acceder al carrito'); window.location.href = '/mi-cuenta'</script>";
        }

        global $request;

        $id_libro = $request->get('id');
        $datos = [
            'libro_id' => (int) $id_libro,
            'usuario_id' => $_SESSION['usuario']['id'],
        ];
        if(!$this->modeloInstancia->agregar($datos)){
            echo '<script>alert("⚠️ No se pudo agregar el libro al carrito"); window.location.href = "/catalogo"</script>';
            return;
        }
        echo '<script>alert("✅ Libro agregado al carrito"); window.location.href = "/carrito"</script>';
    }
    
}