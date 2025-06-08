<?php

namespace PAW\src\App\Modelos;

use PAW\src\Core\Exceptions\InvalidValueFormatException;
use PAW\src\Core\Modelo;

class Reserva extends Modelo{
    public $table = 'reservas';
    public $campos = [
        "id" => null,
        "usuario_id" => null,
        "libro_id" => null,
        "nombre" => null,
        "email" => null,
        "calle" => null,
        "numero" => null,
        "ciudad" => null,
        "provincia" => null,
        "codigo_postal" => null,
        "metodo_entrega" => null,
        "created_at" => null,
        "updated_at"=> null
    ];

    public function setId(int $id)
    {
        if ($id <= 0) {
            throw new InvalidValueFormatException("El ID debe ser un número positivo.");
        }
        $this->campos['id'] = $id;
    }

    public function setUsuario_id(int $id_usuario)
    {
        if ($id_usuario <= 0) {
            throw new InvalidValueFormatException("El ID de usuario debe ser un número positivo.");
        }
        $this->campos['id_usuario'] = $id_usuario;
    }

    public function setLibro_id(int $id_libro)
    {
        if ($id_libro <= 0) {
            throw new InvalidValueFormatException("El ID del libro debe ser un número positivo.");
        }
        $this->campos['id_libro'] = $id_libro;
    }

    public function setNombre(string $nombre)
    {
        if (strlen($nombre) > 50) {
            throw new InvalidValueFormatException("El nombre no puede tener más de 50 caracteres.");
        }
        $this->campos['nombre'] = $nombre;
    }

    public function setEmail(string $email)
    {
        if (strlen($email) > 100) {
            throw new InvalidValueFormatException("El email no puede tener más de 100 caracteres.");
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidValueFormatException("El formato del email no es válido.");
        }
        $this->campos['email'] = $email;
    }

    public function setCalle(string $calle)
    {
        if (strlen($calle) > 50) {
            throw new InvalidValueFormatException("La calle no puede tener más de 50 caracteres.");
        }
        $this->campos['calle'] = $calle;
    }

    public function setNumero(int $numero)
    {
        if ($numero < 0) {
            throw new InvalidValueFormatException("El número de la dirección debe ser positivo.");
        }
        $this->campos['numero'] = $numero;
    }

    public function setCiudad(string $ciudad)
    {
        if (strlen($ciudad) > 50) {
            throw new InvalidValueFormatException("La ciudad no puede tener más de 50 caracteres.");
        }
        $this->campos['ciudad'] = $ciudad;
    }

    public function setProvincia(string $provincia)
    {
        if (strlen($provincia) > 50) {
            throw new InvalidValueFormatException("La provincia no puede tener más de 50 caracteres.");
        }
        $this->campos['provincia'] = $provincia;
    }

    public function setCodigo_postal(string $codigo_postal)
    {
        if (strlen($codigo_postal) > 10) {
            throw new InvalidValueFormatException("El código postal no puede tener más de 10 caracteres.");
        }
        if (!preg_match('/^[A-Za-z0-9\s\-]+$/', $codigo_postal) && $codigo_postal != "") {
            throw new InvalidValueFormatException("El formato del código postal no es válido.");
        }
        $this->campos['codigo_postal'] = $codigo_postal;
    }

    public function setMetodo_entrega(string $envio_o_retiro)
    {
        if (!in_array($envio_o_retiro, ['envío', 'retira'])) {
            throw new InvalidValueFormatException("El valor de 'envio_o_retiro' debe ser 'envío' o 'retira'.");
        }
        $this->campos['metodo_entrega'] = $envio_o_retiro;
    }

    public function setCreated_at(string $created_at)
    {
        if (!strtotime($created_at)) {
            throw new InvalidValueFormatException("La fecha de creación no es válida.");
        }
        $this->campos['created_at'] = $created_at;
    }

    public function setUpdated_at(string $updated_at)
    {
        if (!strtotime($updated_at)) {
            throw new InvalidValueFormatException("La fecha de actualización no es válida.");
        }
        $this->campos['updated_at'] = $updated_at;
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