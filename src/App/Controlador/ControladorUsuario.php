<?php

namespace PAW\src\App\Controlador;

use PAW\src\Core\Controlador;
use PAW\src\App\Modelos\ColeccionUsuarios;

class ControladorUsuario extends Controlador
{
    public ?string $modelo = ColeccionUsuarios::class;

    public function login()
    {
        $titulo = 'PAWPrints - Mi cuenta';
        $htmlClass = "mi-cuenta-pages";
        require $this->viewsDir . 'mi-cuenta.view.php';
    }

    public function procesarLogin()
    {
        global $request;
        // Recoger los datos del formulario
        $email = $request->get('inputEmail');
        $password = $request->get('inputPassword');
        // Validación mínima de formato
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo("Email no válido.");
        }
        if (empty($password)) {
            echo("La contraseña no puede estar vacía.");
        }
        if(strlen($password) < 8){
            echo("La contraseña debe tener al menos 8 caracteres.");
        }
        // Lógica de autenticación delegada
        $usuario = $this->modeloInstancia->autenticar($email, $password);
        if (empty($usuario)) {
            echo("Email o contraseña incorrectos.");
            return;
        }
        // Guardar datos de sesión
        $_SESSION['usuario'] = $usuario->campos;
        $_SESSION['usuario']['rol'] = $usuario->campos['rol'];
        $_SESSION['usuario']['activo'] = $usuario->campos['activo'];
        header('Location: /');
        exit();
    }


    public function registro()
    {
        $titulo = 'PAWPrints - Registro';
        $htmlClass = "mi-cuenta-pages";
        require $this->viewsDir . 'registro.view.php';
    }

    public function procesarRegistro()
    {
        global $request;
        if (
            empty($request->get('inputNombre')) ||
            empty($request->get('inputEmail')) ||
            empty($request->get('inputPassword')) ||
            empty($request->get('inputConfirmarPassword'))
        ) {
            echo "⚠️ Todos los campos obligatorios deben estar completos.";
            return;
        }
        // Recoger los datos del formulario
        $nombre = $request->get('inputNombre');
        $email = $request->get('inputEmail');
        $password = $request->get('inputPassword');
        $confirmarPassword = $request->get('inputConfirmarPassword');
        $datos = [
            'nombre' => $nombre,
            'email' => $email,
            'password' => $password,
        ];

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "⚠️ Email inválido.";
            return;
        }

        if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/", $nombre)) {
            echo "⚠️ Nombre inválido.";
            return;
        }

        if(strlen($password) < 8){
            echo "⚠️ La contraseña debe tener al menos 8 caracteres.";
            return;
        }

        if ($password !== $confirmarPassword) {
            echo "⚠️ Las contraseñas no coinciden.";
            return;
        }

        if($this->modeloInstancia->existeEmail($email)){
            echo "⚠️ El email ya está registrado.";
            return;
        }

        // Crear un nuevo usuario
        if(!$this->modeloInstancia->crear($datos)){
            echo "⚠️ Error al crear el usuario.";
            return;
        }

        $this->login();
    }
}