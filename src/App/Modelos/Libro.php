<?php

namespace PAW\src\App\Modelos;

use PAW\src\Core\Exceptions\InvalidValueFormatException;
use PAW\src\Core\Modelo;

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

    public function setId($id)
    {
        if (!is_numeric($id) || intval($id) < 0) {
            throw new InvalidValueFormatException("El ID debe ser un número entero positivo.");
        }
        $this->campos['id'] = intval($id);
    }

    public function setTitulo(string $titulo){
        if(strlen($titulo) > 100){
            throw new InvalidValueFormatException("El título no puede tener mas de 100 caracteres.");
        }
        $this->campos['titulo'] = $titulo;
    }

    public function setAutor(string $autor){
        if(strlen($autor) > 50){
            throw new InvalidValueFormatException("El nombre del autor no puede tener mas de 50 caracteres.");
        }
        $this->campos['autor'] = $autor;
    }

    public function setDescripcion(string $descripcion){
        $this->campos['descripcion'] = $descripcion;
    }

    public function setPrecio(string $precio){
        // Validar que sea numérico y con dos decimales como máximo
        if (!is_numeric($precio)) {
            throw new InvalidValueFormatException("El precio debe ser un número.");
        }
        $precio = number_format((float)$precio, 2, '.', '');

        if ($precio >= 1000000000) { // 10^10 (10 dígitos antes del punto decimal)
            throw new InvalidValueFormatException("El precio excede el límite permitido.");
        }

        $this->campos['precio'] = $precio;
    }

    public function setRuta_a_imagen(string $ruta_a_imagen){
        if(strlen($ruta_a_imagen) > 255){
            throw new InvalidValueFormatException("La ruta no puede tener mas de 255 caracteres.");
        }
        $this->campos['ruta_a_imagen'] = $ruta_a_imagen;
    }

    public function set(array $valores){
        foreach(array_keys($this->campos) as $campo){
            if(!isset($valores[$campo])){
                continue;
            }
            $metodo = "set".ucfirst($campo);
            $this->$metodo($valores[$campo]);
        }
    }

    public function getCampos(){
        return $this->campos;
    }

    public function load($id){
        $parametros = ['id' => $id];
        $record = current($this->queryBuilder->select($this->table, $parametros));
        $this->set($record);
    }
}