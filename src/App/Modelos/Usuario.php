<?php

namespace PAW\src\App\Modelos;

use PAW\src\Core\Exceptions\InvalidValueFormatException;
use PAW\src\Core\Modelo;

class Usuario extends Modelo{
    public $table = 'usuarios';
    public $campos = [
        "id" => null,
        "email" => null,
        "password" => null,
        "nombre" => null,
        "apellido" => null,
    ];

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

    public function setPassword(string $password)
    {
        if (strlen($password) > 255) {
            throw new InvalidValueFormatException("La contraseña no puede tener más de 255 caracteres.");
        }
        // Validación mínima sugerida
        if (strlen($password) < 8) {
            throw new InvalidValueFormatException("La contraseña debe tener al menos 8 caracteres.");
        }
        // Se puede hashear acá o en otro paso, depende del flujo de la app
        $this->campos['password'] = password_hash($password, PASSWORD_DEFAULT);
    }

    public function setNombre(string $nombre)
    {
        if (strlen($nombre) > 50) {
            throw new InvalidValueFormatException("El nombre no puede tener más de 50 caracteres.");
        }
        $this->campos['nombre'] = $nombre;
    }

    public function setApellido(string $apellido)
    {
        if (strlen($apellido) > 50) {
            throw new InvalidValueFormatException("El apellido no puede tener más de 50 caracteres.");
        }
        $this->campos['apellido'] = $apellido;
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