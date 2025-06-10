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
        $subtotal = 0;
        $libros = $this->modeloInstancia->getItems($usuario_id);
        foreach ($libros as $libro) {
            $subtotal += $libro->campos['precio'];
        }
        $subtotalFormateado = number_format($subtotal, 0, ',', '.');
        global $twig;
        echo $twig->render('carrito.view.twig', [
            "titulo" => "PAWPrints - Carrito de compras",
            "menu" => $this->menu,
            "libros" => $libros,
            "htmlClass" => "carrito-pages",
            "subtotalFormateado" => $subtotalFormateado
        ]);
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