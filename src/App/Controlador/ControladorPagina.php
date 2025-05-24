<?php

namespace PAW\src\App\Controlador;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PAW\src\Core\config;
use PAW\src\Core\Controlador;

class ControladorPagina extends Controlador
{
    public function obtenerLibros($consulta = null, $ids = null)
    {
        $ruta = __DIR__ . '/../../libros.txt';
        $libros = [];

        if (!file_exists($ruta))
            return [];

        $lineas = file($ruta, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($lineas as $linea) {
            [$id, $titulo, $autor, $descripcion, $precio, $imagen] = explode('|', $linea);

            // Filtro por IDs (si se pasaron)
            if ($ids !== null && !in_array($id, $ids))
                continue;

            // Filtro por búsqueda textual (si se pasó)
            if ($consulta !== null && stripos($titulo, $consulta) === false && stripos($autor, $consulta) === false) {
                continue;
            }

            $libros[] = [
                'id' => $id,
                'titulo' => $titulo,
                'autor' => $autor,
                'descripcion' => $descripcion,
                'precio' => $precio,
                'ruta_a_imagen' => $imagen
            ];
        }

        return $libros;
    }

    public function libroNoEncontrado()
    {
        http_response_code(404);
        require $this->viewsDir . '404.view.php';
    }

    public function comoComprar()
    {
        $titulo = "PAWPrints - Cómo comprar";
        $htmlClass = "preguntas-pages";
        require $this->viewsDir . 'como-comprar.view.php';
    }

    public function quienesSomos()
    {
        $titulo = 'PAWPrints - Quiénes somos';
        $htmlClass = "preguntas-pages";
        require $this->viewsDir . 'quienes-somos.view.php';
    }

    public function locales()
    {
        $titulo = 'PAWPrints - Locales';
        $htmlClass = "preguntas-pages";
        require $this->viewsDir . 'locales.view.php';
    }

    public function carrito()
    {
        $titulo = 'PAWPrints - Carrito de compras';
        $htmlClass = "carrito-pages";
        $id = $_GET['id'] ?? null;
        $libros = $this->obtenerLibros(null, [$id]);
        if (empty($libros)) {
            $this->libroNoEncontrado();
            return;
        }
        $libro = $libros[0];
        require $this->viewsDir . 'carrito.view.php';
    }

    public function reservarLibro()
    {
        $titulo = 'PAWPrints - Reservar';
        $htmlClass = "libro-pages";
        $id = $_GET['id'] ?? null;
        $libros = $this->obtenerLibros(null, [$id]);
        if (empty($libros)) {
            $this->libroNoEncontrado();
            return;
        }
        $libro = $libros[0];
        require $this->viewsDir . 'reservar-libro.view.php';
    }

    public function procesarReservarLibro()
    {
        $requeridos = ['libro_id', 'inputNombre', 'inputApellido', 'inputEmail', 'inputTel', 'inputEnvio'];
        foreach ($requeridos as $campo) {
            if (!isset($_POST[$campo]) || trim($_POST[$campo]) === '') {
                echo "⚠️ Faltan datos obligatorios.";
                return;
            }
        }

        // Recoger los datos del formulario y sanitizarlos
        $id = filter_var($_POST['libro_id'], FILTER_VALIDATE_INT);
        $nombre = htmlspecialchars(trim($_POST['inputNombre']));
        $apellido = htmlspecialchars(trim($_POST['inputApellido']));
        $email = filter_var(trim($_POST['inputEmail']), FILTER_VALIDATE_EMAIL);
        $telefono = htmlspecialchars(trim($_POST['inputTel']));
        $calle = htmlspecialchars(trim($_POST['inputCalle'] ?? ''));
        $numero = htmlspecialchars(trim($_POST['inputNumero'] ?? ''));
        $ciudad = htmlspecialchars(trim($_POST['inputCiudad'] ?? ''));
        $provincia = htmlspecialchars(trim($_POST['inputProvincia'] ?? ''));
        $codigoPostal = htmlspecialchars(trim($_POST['inputCodigoPostal'] ?? ''));
        $envio = ($_POST['inputEnvio'] === 'envío' || $_POST['inputEnvio'] === 'retira') ? $_POST['inputEnvio'] : 'desconocido';

        if (!$id || !$email) {
            echo "⚠️ El ID del libro o el email no son válidos.";
            return;
        } else if (!preg_match("/^(?:(?:00)?549?)?0?(?:11|[2368]\d)(?:(?=\d{0,2}15)\d{2})??\d{8}$/", $telefono)) {
            echo "⚠️ El teléfono no es válido.";
            return;
        }
        // Formatear los datos en un texto legible
        $datos = "Id Libro: $id|Nombre: $nombre|Apellido: $apellido|Email: $email|Teléfono: $telefono|Calle: $calle|Número: $numero|Ciudad: $ciudad|Provincia: $provincia|Código Postal: $codigoPostal|Envío o Retiro: $envio\n";

        // Ruta del archivo de texto donde se guardarán los datos
        $archivo = __DIR__ . "/../../reservas.txt";

        // Guardar los datos en el archivo de texto
        file_put_contents($archivo, $datos, FILE_APPEND); // FILE_APPEND agrega los datos al final del archivo

        $datos = [
            'libro_id' => $id,
            'nombre' => $nombre,
            'apellido' => $apellido,
            'email' => $email,
            'telefono' => $telefono,
            'calle' => $calle,
            'numero' => $numero,
            'ciudad' => $ciudad,
            'provincia' => $provincia,
            'codigo_postal' => $codigoPostal,
            'envio' => $envio
        ];


        // 2. Enviar mail al usuario
        $this->enviarMailReserva($datos);

        // 3. Armar texto para el personal (string simple)
        $datosReserva = <<<EOD
        Reserva realizada:
        Libro ID: {$datos['libro_id']}
        Nombre: {$datos['nombre']} {$datos['apellido']}
        Email: {$datos['email']}
        Teléfono: {$datos['telefono']}
        Dirección: {$datos['calle']} {$datos['numero']}, {$datos['ciudad']}, {$datos['provincia']}, CP: {$datos['codigo_postal']}
        Modalidad: {$datos['envio']}
        EOD;

        // 4. Enviar mail al personal
        $this->enviarMailReservaPersonal($datosReserva);

        $this->index();
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
            $mail->addAddress($datos['email'], $datos['nombre'] . ' ' . $datos['apellido']); // destinatario real

            $mail->isHTML(true);
            $mail->Subject = 'Reserva de libro';

            $mail->Body = "
                <p>Hola <strong>{$datos['nombre']}</strong>,</p>
                <p>Tu reserva ha sido registrada correctamente.</p>
                <p><strong>Detalles:</strong></p>
                <ul>
                    <li><strong>Libro ID:</strong> {$datos['libro_id']}</li>
                    <li><strong>Nombre:</strong> {$datos['nombre']} {$datos['apellido']}</li>
                    <li><strong>Email:</strong> {$datos['email']}</li>
                    <li><strong>Teléfono:</strong> {$datos['telefono']}</li>
                    <li><strong>Dirección:</strong> {$datos['calle']} {$datos['numero']}, {$datos['ciudad']}, {$datos['provincia']}, CP: {$datos['codigo_postal']}</li>
                    <li><strong>Tipo de entrega:</strong> {$datos['envio']}</li>
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