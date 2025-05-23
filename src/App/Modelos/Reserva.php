<?php

namespace PAW\src\App\Modelos;

use PAW\src\Core\Exceptions\InvalidValueFormatException;
use PAW\src\Core\Modelo;

class Reserva extends Modelo{
    public $table = 'reservas';
    public $campos = [
        "id" => null,
        "id_usuario" => null,
        "id_libro" => null,
        "telefono" => null,
        "calle" => null,
        "numero" => null,
        "ciudad" => null,
        "provincia" => null,
        "codigo_postal" => null,
        "envio_o_retiro" => null,
        "fecha_reserva" => null,
    ];

    public function setIdUsuario(int $id_usuario)
    {
        if ($id_usuario <= 0) {
            throw new InvalidValueFormatException("El ID de usuario debe ser un número positivo.");
        }
        $this->campos['id_usuario'] = $id_usuario;
    }

    public function setIdLibro(int $id_libro)
    {
        if ($id_libro <= 0) {
            throw new InvalidValueFormatException("El ID del libro debe ser un número positivo.");
        }
        $this->campos['id_libro'] = $id_libro;
    }

    public function setTelefono(string $telefono)
    {
        if (strlen($telefono) > 15) {
            throw new InvalidValueFormatException("El teléfono no puede tener más de 15 caracteres.");
        }
        if (!preg_match('/^\+?[0-9\s\-()]+$/', $telefono)) {
            throw new InvalidValueFormatException("El formato del teléfono no es válido.");
        }
        $this->campos['telefono'] = $telefono;
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
        if ($numero <= 0) {
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

    public function setCodigoPostal(string $codigo_postal)
    {
        if (strlen($codigo_postal) > 10) {
            throw new InvalidValueFormatException("El código postal no puede tener más de 10 caracteres.");
        }
        if (!preg_match('/^[A-Za-z0-9\s\-]+$/', $codigo_postal)) {
            throw new InvalidValueFormatException("El formato del código postal no es válido.");
        }
        $this->campos['codigo_postal'] = $codigo_postal;
    }

    public function setEnvioORetiro(string $envio_o_retiro)
    {
        if (!in_array($envio_o_retiro, ['envio', 'retiro'])) {
            throw new InvalidValueFormatException("El valor de 'envio_o_retiro' debe ser 'envio' o 'retiro'.");
        }
        $this->campos['envio_o_retiro'] = $envio_o_retiro;
    }

    public function setFechaReserva(string $fecha_reserva)
    {
        if (!strtotime($fecha_reserva)) {
            throw new InvalidValueFormatException("La fecha de reserva no es válida.");
        }
        $this->campos['fecha_reserva'] = $fecha_reserva;
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