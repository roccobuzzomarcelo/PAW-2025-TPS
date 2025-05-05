<?php include "parts/head.php"?>
<body>
    <?php include "parts/header.php"; ?>
    <main>
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a class="breadcrumb-link" href="../">Home</a></li>
            <li class="breadcrumb-item" aria-current="page">Recuperar contraseña</li>
        </ul>
        <section class="iniciar-sesion">
            <form class="login-form" action="/recuperar-contraseña" method="post">
                <h2 class="subtitulo">¿Perdiste tu contraseña? </h2>
                <p>Por favor, introduce tu correo electrónico. Recibirás un enlace para crear una
                    contraseña nueva por correo electrónico.</p>
                <label for="inputEmail">Email</label>
                <input id="inputEmail" type="email" name="inputEmail" placeholder="Email" required>
                <button type="submit" value="Enviar">Enviar</button>
            </form>
        </section>
    </main>
    <?php include "parts/footer.php"; ?>
</body>
</html>