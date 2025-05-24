<?php

namespace PAW\src\App\Controlador;

use PAW\src\Core\Controlador;
use PAW\src\App\Modelos\ColeccionUsuarios;

class ControladorUsuario extends Controlador
{
    public ?string $modelo = ColeccionUsuarios::class;

    public function login()
    {
        global $request;
        $rol = $_SESSION['usuario']['rol'] ?? null;
        if(!is_null( $rol )) {
            $this->cuenta();
            return;
        }
        $titulo = 'PAWPrints - Login';
        $htmlClass = "mi-cuenta-pages";
        require $this->viewsDir . 'login.view.php';
    }

    public function cuenta(){
        $datos = $_SESSION['usuario'];
        $titulo = 'PAWPrints - Mi cuenta';
        $htmlClass = "mi-cuenta-pages";
        require $this->viewsDir . 'mi-cuenta.view.php';
    }

    public function logout(){
        session_unset();           // Limpiamos todas las variables de sesión
        session_destroy();         // Destruimos la sesión
        header("Location: /"); // Redirigimos al usuario al inicio (o login)
    }

    public function editarUsuario(){
        $datos = $_SESSION['usuario'];
        $titulo = 'PAWPrints - Editar usuario';
        $htmlClass = "mi-cuenta-pages";
        require $this->viewsDir . 'editar-usuario.view.php';
    }

    public function procesarEditarUsuario()
    {
        global $request;
        if (
            empty($request->get('password')) ||
            empty($request->get('confirmar_password'))
        ) {
            echo "⚠️ Todos los campos obligatorios deben estar completos.";
            return;
        }

        $nombre = $request->get('inputNombre');
        if(empty($nombre)){
            $nombre = $_SESSION['usuario']['nombre'];
        }
        $email = $request->get('inputEmail');
        if(empty($email)){
            $email = $_SESSION['usuario']['email'];
        }
        $password = $request->get('password');
        $confirmarPassword = $request->get('confirmar_password');
        $datos = [
            'nombre' => $nombre,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
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

        // Actualizar el usuario
        if(!$this->modeloInstancia->actualizar($_SESSION['usuario']['id'], $datos)){
            echo "⚠️ Error al actualizar el usuario.";
            return;
        }

        $_SESSION['usuario'] = array_merge($_SESSION['usuario'], $datos);
        header("Location: /mi-cuenta");
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

    public function recuperarContraseña()
    {
        $titulo = 'PAWPrints - Recuperar contraseña';
        $htmlClass = "mi-cuenta-pages";
        require $this->viewsDir . 'recuperar-contraseña.view.php';
    }

    public function procesarRecuperarContraseña()
    {
        // Recoger los datos del formulario
        $email = $_POST['inputEmail'];
        $archivo = __DIR__ . "/../../login.txt";

        if (!file_exists($archivo)) {
            echo "⚠️ Archivo de usuarios no encontrado.";
            return;
        }

        $lineas = file($archivo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $emailEncontrado = false;

        foreach ($lineas as $linea) {
            list($id, $emailArchivo, $passArchivo, $nombre, $apellido) = explode('|', trim($linea));
            if ($email === $emailArchivo) {
                $emailEncontrado = true;
                break;
            }
        }

        if ($emailEncontrado) {
            echo "✅ Se ha enviado un enlace para restablecer tu contraseña a tu correo electrónico.";
        } else {
            echo "❌ El email no está registrado.";
        }
    }
}