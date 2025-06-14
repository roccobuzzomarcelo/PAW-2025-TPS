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
        global $twig;
        echo $twig->render('login.view.twig', [
            "titulo" => "PAWPrints - Login",
            "menu" => $this->menu,
            "htmlClass" => "mi-cuenta-pages",
        ]);
    }

    public function cuenta(){
        global $twig;
        echo $twig->render('mi-cuenta.view.twig', [
            "titulo" => "PAWPrints - Mi cuenta",
            "menu" => $this->menu,
            "htmlClass" => "mi-cuenta-pages",
            "datos" => $_SESSION['usuario'],
            "cookies" => $_COOKIE,
        ]);
    }

    public function logout(){
        session_unset();           // Limpiamos todas las variables de sesión
        session_destroy();         // Destruimos la sesión
        echo "<script>
            alert('✅ Sesión cerrada exitosamente');
            window.location.href = '/';
        </script>";
    }

    public function editarUsuario(){
        global $twig;
        echo $twig->render('editar-usuario.view.twig', [
            "titulo" => "PAWPrints - Editar usuario",
            "menu" => $this->menu,
            "htmlClass" => "mi-cuenta-pages",
            "datos" => $_SESSION['usuario'],
        ]);
    }

    public function procesarEditarUsuario()
    {
        global $request;
        if (
            empty($request->get('password')) ||
            empty($request->get('confirmar_password'))
        ) {
            echo "<script>alert('⚠️ Todos los campos obligatorios deben completarse'); window.history.back();</script>";
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
            echo "<script>alert('⚠️ Email no valido'); window.history.back();</script>";
            return;
        }

        if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/", $nombre)) {
            echo "<script>alert('⚠️ Nombre no valido'); window.history.back();</script>";
            return;
        }

        if(strlen($password) < 8){
            echo "<script>alert('⚠️ La contraseña debe tener al menos 8 caracteres'); window.history.back();</script>";
            return;
        }

        if ($password !== $confirmarPassword) {
            echo "<script>alert('⚠️ Las contraseña no coinciden'); window.history.back();</script>";
            return;
        }

        // Actualizar el usuario
        if(!$this->modeloInstancia->actualizar($_SESSION['usuario']['id'], $datos)){
            echo "<script>alert('⚠️ Error al actualizar el usuario'); window.history.back();</script>";
            return;
        }

        $_SESSION['usuario'] = array_merge($_SESSION['usuario'], $datos);
        // Éxito: redirigir a página principal u otra
        echo "<script>
            alert('✅ Usuario actualizado exitosamente');
            window.location.href = '/mi-cuenta';
        </script>";
    }

    public function procesarLogin()
    {
        global $request;
        // Recoger los datos del formulario
        $email = trim($request->get('inputEmail'));
        $password = trim($request->get('inputPassword'));
        // Validación mínima de formato
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "<script>alert('⚠️ Email no valido'); window.history.back();</script>";
            return;
        }
        if (empty($password)) {
            echo "<script>alert('⚠️ La contraseña no puede estar vacia'); window.history.back();</script>";
            return;
        }
        if(strlen($password) < 8){
            echo "<script>alert('⚠️ La contraseña debe tener al menos 8 caracteres'); window.history.back();</script>";
            return;
        }
        // Lógica de autenticación delegada
        $usuario = $this->modeloInstancia->autenticar($email, $password);
        if (empty($usuario)) {
            echo "<script>alert('⚠️ Email o contraseña incorrectos'); window.history.back();</script>";
            return;
        }
        if (!empty($request->get('recuerdame'))) {
            setcookie("email", $email, time() + (86400 * 30), "/"); // guarda por 30 días
        }
        // Guardar datos de sesión
        $_SESSION['usuario'] = $usuario->campos;
        // Éxito: redirigir a página principal u otra
        echo "<script>
            alert('✅ Sesion iniciada exitosamente');
            window.location.href = '/';
        </script>";
        exit();
    }


    public function registro()
    {
        global $twig;
        echo $twig->render('registro.view.twig', [
            "titulo" => "PAWPrints - Registro",
            "menu" => $this->menu,
            "htmlClass" => "mi-cuenta-pages",
        ]);
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
            echo "<script>alert('⚠️ Todos los campos obligatorios deben completarse'); window.history.back();</script>";
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
            echo "<script>alert('⚠️ Email no valido'); window.history.back();</script>";
            return;
        }

        if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/", $nombre)) {
            echo "<script>alert('⚠️ Nombre no valido'); window.history.back();</script>";
            return;
        }

        if(strlen($password) < 8){
            echo "<script>alert('⚠️ La contraseña debe tener al menos 8 caracteres'); window.history.back();</script>";
            return;
        }

        if ($password !== $confirmarPassword) {
            echo "<script>alert('⚠️ Las contraseña no coinciden'); window.history.back();</script>";
            return;
        }

        if($this->modeloInstancia->existeEmail($email)){
            echo "<script>alert('⚠️ El Email ya esta registrado'); window.history.back();</script>";
            return;
        }

        if (empty($request->get('inputAceptoTerminos'))) {
            echo "<script>alert('⚠️ Debes aceptar los términos y condiciones'); window.history.back();</script>";
            return;
        }


        // Crear un nuevo usuario
        if(!$this->modeloInstancia->crear($datos)){
            echo "<script>alert('⚠️ Error al crear el usuario'); window.history.back();</script>";
            return;
        }
        // Éxito: redirigir a página principal u otra
        echo "<script>
            alert('✅ Registro exitoso');
            window.location.href = '/mi-cuenta';
        </script>";
    }

    public function recuperarContraseña()
    {
        global $twig;
        echo $twig->render('recuperar-contraseña.view.twig', [
            "titulo" => "PAWPrints - Recuperar contraseña",
            "menu" => $this->menu,
            "htmlClass" => "mi-cuenta-pages",
        ]);
    }

    public function procesarRecuperarContraseña()
    {
        // Recoger los datos del formulario
        $email = $_POST['inputEmail'];
        $archivo = __DIR__ . "/../../login.txt";

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