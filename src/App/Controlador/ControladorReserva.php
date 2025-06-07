<?php

namespace PAW\src\App\Controlador;

use PAW\src\Core\Controlador;
use PAW\src\App\Modelos\ColeccionReservas;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class ControladorReserva extends Controlador
{
    public ?string $modelo = ColeccionReservas::class;

    public function reservas(){
        $rol = $_SESSION['usuario']['rol'] ?? null;
        if($rol !== 'admin'){
            echo "<script>alert('⚠️ No tienes permiso para acceder a esta página.'); window.location.href = '/';</script>";
            return;
        }
        global $request;
        $valorConsulta = $request->get('consulta');
        $consulta = isset($valorConsulta) ? trim($valorConsulta) : '';        
        $reservas = $this->modeloInstancia->getReservas($consulta);
        $titulo = "Reservas - PawPrints";
        require $this->viewsDir . "ver-reservas.view.php";
    }

    public function reservarLibro()
    {
        if(!isset($_SESSION['usuario'])){
            echo "<script>alert('⚠️ Debes iniciar sesion para reservar un libro'); window.location.href = '/mi-cuenta'</script>";
        }
        global $request;
        $titulo = 'PAWPrints - Reservar';
        $htmlClass = "libro-pages";
        $id = $request->get('id') ?? null;
        $libro = $this->modeloInstancia->getLibro([$id]);
        $datos = $_SESSION['usuario'];
        if (empty($libro)) {
            echo "<script>alert('⚠️ No se encontró el libro'); window.location.href = '/catalogo'</script>";
        }
        require $this->viewsDir . 'reservar-libro.view.php';
    }

    public function procesarReservarLibro()
    {
        global $request;
        // $requeridos = ['libro_id', 'inputNombre', 'inputEmail', 'inputEnvio'];
        // foreach ($requeridos as $campo) {
        //     if (!isset($_POST[$campo]) || trim($_POST[$campo]) === '') {
        //         echo "<script>alert('⚠️ Faltan datos obligatorios'); window.history.back();</script>";
        //     return;
        //     }
        // }

        // Recoger los datos del formulario y sanitizarlos
        $usuario_id = $_SESSION['usuario']['id'];
        $libro_id = filter_var($request->get('libro_id'), FILTER_VALIDATE_INT);
        $nombre = htmlspecialchars(trim($request->get('inputNombre')));
        $email = filter_var(trim($request->get('inputEmail')), FILTER_VALIDATE_EMAIL);
        $calle = htmlspecialchars(trim($request->get('inputCalle') ?? ''));
        $numero = (int) htmlspecialchars(trim($request->get('inputNumero') ?? null));
        $ciudad = htmlspecialchars(trim($request->get('inputCiudad') ?? ''));
        $provincia = htmlspecialchars(trim($request->get('inputProvincia') ?? ''));
        $codigoPostal = htmlspecialchars(trim($request->get('inputCodigoPostal') ?? ''));
        $metodo_entrega = ($request->get('inputEnvio') === 'envío' || $request->get('inputEnvio') === 'retira') ? $request->get('inputEnvio') : 'desconocido';
        $libro = $this->modeloInstancia->getLibro([$libro_id]);
        $datos = [
            'usuario_id' => $usuario_id,
            'libro_id'=> $libro_id,
            'nombre' => $nombre,
            'email' => $email,
            'calle' => $calle,
            'numero' => $numero,
            'ciudad' => $ciudad,
            'provincia' => $provincia,
            'codigo_postal' => $codigoPostal,
            'metodo_entrega' => $metodo_entrega,
        ];

        if (!$this->modeloInstancia->crear($datos)) {
            echo "<script>alert('⚠️ Error al guardar la reserva'); window.history.back();</script>";
            return;
        }

        $datosMail = [
            'nombre_libro' => $libro->campos['titulo'],
            'precio' => $libro->campos['precio'],
            'nombre' => $nombre,
            'email' => $email,
            'calle' => $calle,
            'numero' => $numero,
            'ciudad' => $ciudad,
            'provincia' => $provincia,
            'codigo_postal' => $codigoPostal,
            'metodo_entrega' => $metodo_entrega,
        ];

        // 2. Enviar mail al usuario
        $this->enviarMailReserva($datosMail);

        // 3. Armar texto para el personal (string simple)
        $datosReserva = <<<EOD
        Reserva realizada:
        Usuario ID: {$usuario_id}
        Libro ID: {$datos['libro_id']}
        Nombre: {$datos['nombre']}
        Email: {$datos['email']}
        Dirección: {$datos['calle']} {$datos['numero']}, {$datos['ciudad']}, {$datos['provincia']}, CP: {$datos['codigo_postal']}
        Modalidad: {$datos['metodo_entrega']}
        EOD;

        // 4. Enviar mail al personal
        $this->enviarMailReservaPersonal($datosReserva);

        // Éxito: redirigir a página principal u otra
        echo "<script>
            alert('✅ Reserva generada exitosamente');
            window.location.href = '/catalogo';
        </script>";
    }

    public function enviarMailReserva($datos)
    {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = $this->config->get("SMTP_HOST");
            $mail->SMTPAuth = true;
            $mail->Username = $this->config->get("SMTP_USERNAME");
            $mail->Password = $this->config->get("SMTP_PASSWORD");
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = $this->config->get("SMTP_PORT");

            $mail->setFrom($this->config->get("SMTP_FROM_EMAIL"), $this->config->get("SMTP_FROM_NAME"));
            $mail->addAddress($datos['email'], $datos['nombre']); // destinatario real

            $mail->isHTML(true);
            $mail->Subject = 'Reserva de libro';

            $mail->Body = "
                <p>Hola <strong>{$datos['nombre']}</strong>,</p>
                <p>Tu reserva ha sido registrada correctamente.</p>
                <p><strong>Detalles:</strong></p>
                <ul>
                    <li><strong>Libro:</strong> {$datos['nombre_libro']}</li>
                    <li><strong>Precio:</strong> {$datos['precio']}</li>
                    <li><strong>Nombre:</strong> {$datos['nombre']}</li>
                    <li><strong>Email:</strong> {$datos['email']}</li>
                    <li><strong>Dirección:</strong> {$datos['calle']} {$datos['numero']}, {$datos['ciudad']}, {$datos['provincia']}, CP: {$datos['codigo_postal']}</li>
                    <li><strong>Tipo de entrega:</strong> {$datos['metodo_entrega']}</li>
                </ul>
                <p>Gracias por utilizar nuestro servicio.</p>
            ";

            $mail->send();
        } catch (Exception $e) {
            error_log("Error al enviar correo al usuario: {$mail->ErrorInfo}");
        }
    }

    public function enviarMailReservaPersonal($datosReserva)
    {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = $this->config->get("SMTP_HOST");
            $mail->SMTPAuth = true;
            $mail->Username = $this->config->get("SMTP_USERNAME");
            $mail->Password = $this->config->get("SMTP_PASSWORD");
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = $this->config->get("SMTP_PORT");

            $mail->setFrom($this->config->get("SMTP_FROM_EMAIL"), $this->config->get("SMTP_FROM_NAME"));
            $mail->addAddress($this->config->get("SMTP_FROM_EMAIL"), 'Personal Biblioteca');

            $mail->Subject = 'Nueva Reserva de Libro';
            $mail->Body = $datosReserva;

            $mail->send();
        } catch (Exception $e) {
            error_log("No se pudo enviar el correo: {$mail->ErrorInfo}");
        }
    }
}