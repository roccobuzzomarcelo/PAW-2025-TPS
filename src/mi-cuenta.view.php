<?php
?>
<!DOCTYPE html>
<html class="mi-cuenta-pages" lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/styles.css">
    <link rel="stylesheet" href="../styles/print.css" media="print">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Archivo+Black&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <title>PAW Prints | Mi Cuenta</title>
</head>

<body>
<?php include __DIR__ . '/App/views/parts/header.php'; ?>
<main>
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a class="breadcrumb-link" href="../">Home</a></li>
            <li class="breadcrumb-item" aria-current="page">Mi Cuenta</li>
        </ul>
        <section class="iniciar-sesion">
            <form class="login-form" action="/mi-pagina-de-formulario" method="post">
                <h2 class="subtitulo">Iniciar Sesión</h2>
                <a class="register-link" href="./registro.html">Registrarse</a>
                <label for="inputEmail">Email</label>
                <input id="inputEmail" type="email" name="inputEmail" placeholder="Email" required>

                <label for="inputPassword">Contraseña</label>
                <input id="inputPassword" type="password" name="inputPassword" placeholder="Contraseña" required>
                <label for="inputRecuerdame">
                    <input type="checkbox" name="recuerdame">
                    Recuérdame
                </label>
                <button type="submit">Acceder</button>
                <a href="./recuperar-contraseña.html">¿Has olvidado tu contraseña?</a>
            </form>
        </section>
    </main>

    <?php include __DIR__ . '/App/views/parts/footer.php'; ?> 

</body>

</html>
