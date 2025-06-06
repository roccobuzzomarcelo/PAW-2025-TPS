<?php include 'parts/head.php'?>
<body class="<?= htmlspecialchars($htmlClass ?? 'index') ?>">
<?php include 'parts/header.php'; ?>
<main>
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a class="breadcrumb-link" href="../">Home</a></li>
            <li class="breadcrumb-item" aria-current="page">Login</li>
        </ul>
        <section class="iniciar-sesion">
            <form class="login-form" action="/mi-cuenta" method="post">
                <h2 class="subtitulo">Iniciar Sesión</h2>
                <a class="register-link" href="/registro">Registrarse</a>
                <label for="inputEmail">Email</label>
                <input id="inputEmail" type="email" name="inputEmail" placeholder="Email" required>

                <label for="inputPassword">Contraseña</label>
                <input id="inputPassword" type="password" name="inputPassword" placeholder="Contraseña" required>
                <label for="inputRecuerdame">
                    <input type="checkbox" name="recuerdame">
                    Recuérdame
                </label>
                <button type="submit">Acceder</button>
                <a href="/recuperar-contraseña">¿Has olvidado tu contraseña?</a>
            </form>
        </section>
    </main>

    <?php include 'parts/footer.php'; ?> 

</body>

</html>
