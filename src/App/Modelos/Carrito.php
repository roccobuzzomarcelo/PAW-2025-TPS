<?php

namespace PAW\src\App\Modelos;

use PAW\src\Core\Exceptions\InvalidValueFormatException;
use PAW\src\Core\Modelo;

class Carrito extends Modelo{

    public $table = 'carrito_items';
    public $campos = [
        "id" => null,
        "usuario_id" => null,
        "libro_id" => null,
        "cantidad"=> null,
        "agregado_en"=> null,
    ];

    public function setId($id)
    {
        if (!is_numeric($id) || intval($id) < 0) {
            throw new InvalidValueFormatException("El ID debe ser un número entero positivo.");
        }
        $this->campos['id'] = intval($id);
    }

    public function setUsuario_id($id_usuario)
    {
        if (!is_numeric($id_usuario) || intval($id_usuario) < 0) {
            throw new InvalidValueFormatException("El ID de usuario debe ser un número entero positivo.");
        }
        $this->campos['usuario_id'] = intval($id_usuario);
    }

    public function setLibro_id($id_libro)
    {
        if (!is_numeric($id_libro) || intval($id_libro) < 0) {
            throw new InvalidValueFormatException("El ID del libro debe ser un número entero positivo.");
        }
        $this->campos['libro_id'] = intval($id_libro);
    }

    public function setCantidad($cantidad)
    {
        if (!is_numeric($cantidad) || intval($cantidad) < 0) {
            throw new InvalidValueFormatException("La cantidad debe ser un número entero positivo.");
        }
        $this->campos['cantidad'] = intval($cantidad);
    }

    public function setAgregado_en($agregado_en)
    {
        if (!is_string($agregado_en)) {
            throw new InvalidValueFormatException("La fecha de agregado debe ser una cadena.");
        }
        $this->campos['agregado_en'] = $agregado_en;
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
}