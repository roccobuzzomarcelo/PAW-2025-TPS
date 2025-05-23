<?php

namespace PAW\src\App\Modelos;

use PAW\src\Core\Modelo;
use Exception;

class Libro extends Modelo{

    public $table = 'libros';
    public $campos = [
        "id" => null,
        "titulo" => null,
        "autor" => null,
        "descripcion"=> null,
        "precio"=> null,
        "ruta_a_imagen"=> null,
    ];

    public function setTitulo(string $titulo){
        if(strlen($titulo) > 100){
            throw new Exception("El título no puede tener mas de 100 caracteres.");
        }
        $this->campos['titulo'] = $titulo;
    }

    public function setAutor(string $autor){
        if(strlen($autor) > 50){
            throw new Exception("El nombre del autor no puede tener mas de 50 caracteres.");
        }
        $this->campos['autor'] = $autor;
    }

    public function setDescripcion(string $descripcion){
        if(strlen($descripcion) > 500){
            throw new Exception("La descripcion del libro no puede tener mas de 500 caracteres.");
        }
        $this->campos['descripcion'] = $descripcion;
    }

    public function setPrecio(string $precio){
        if(strlen($precio) > 15){
            throw new Exception("El precio del libro no puede tener mas de 15 caracteres.");
        }
        $this->campos['precio'] = $precio;
    }

    public function setRutaAImagen(string $ruta_a_imagen){
        if(strlen($ruta_a_imagen) > 100){
            throw new Exception("La rutano puede tener mas de 100 caracteres.");
        }
        $this->campos['ruta_a_imagen'] = $ruta_a_imagen;
    }


}