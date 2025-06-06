<?php include "parts/head.php" ?>

<body class="<?= htmlspecialchars($htmlClass ?? 'index') ?>">
    <?php include "parts/header.php"; ?>
    <main>
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a class="breadcrumb-link" href="../">Home</a></li>
            <li class="breadcrumb-item">Mi Cuenta</li>
            <li class="breadcrumb-item" aria-current="page">Registro</li>
        </ul>

        <section class="registrarse">
            <form class="registro-form" action="/registro" method="post">
                <h3 class="subtitulo">Registrarse</h3>

                <label for="inputNombre">Nombre</label>
                <input id="inputNombre" type="nombre" name="inputNombre" placeholder="Nombre" required>

                <label for="inputEmail">Email</label>
                <input id="inputEmail" type="email" name="inputEmail" placeholder="Email" required>

                <label for="inputPassword">Contraseña</label>
                <input id="inputPassword" type="password" name="inputPassword" placeholder="Contraseña" required>

                <label for="inputConfirmarPassword">Confirmar Contraseña</label>
                <input id="inputConfirmarPassword" type="password" name="inputConfirmarPassword"
                    placeholder="Confirmar Contraseña" required>

                <label for="inputAceptoTerminos">
                    <input type="checkbox" id="inputAceptoTerminos" name="inputAceptoTerminos" value="AceptoTerminos"
                        required>
                    Acepto los términos y condiciones
                </label>

                <input type="submit" name="submit" value="Registrarse">
                <p>¿Ya tienes cuenta creada?</p>
                <a class="login-link" href="/mi-cuenta">Iniciar Sesión</a>
            </form>

        </section>
    </main>
    <?php include "parts/footer.php"; ?>
</body>

</html>