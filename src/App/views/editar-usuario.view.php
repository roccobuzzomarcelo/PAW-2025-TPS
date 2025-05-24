<?php include "parts/head.php"; ?>
<body class="<?= htmlspecialchars($htmlClass ?? 'index') ?>">
<?php include "parts/header.php"; ?>
    <main>
        <!-- BREADCRUMB -->

        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a class="breadcrumb-link" href="../">Home</a></li>
            <li class="breadcrumb-item"><a class="breadcrumb-link" href="/mi-cuenta">Mi Cuenta</a></li>
            <li class="breadcrumb-item" aria-current="page">Editar Datos</li>
        </ul>
        <h1>Editar Mis Datos</h1>
        <section class="registrarse">
            <form method="POST" action="/editar-usuario" class="registro-form">

                <label for="inputNombre">Nombre</label>
                <input id="inputNombre" type="nombre"  name="inputNombre"
                    value="<?= htmlspecialchars($datos['nombre']) ?>" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email"
                    value="<?= htmlspecialchars($datos['email']) ?>" required>

                <!-- Podés permitir cambiar contraseña -->
                <label for="password">Nueva Contraseña (opcional):</label>
                <input type="password" id="password" name="password" placeholder="Nueva Contraseña">

                <label for="confirmar_password">Confirmar Contraseña:</label>
                <input type="password" id="confirmar_password" name="confirmar_password" placeholder="Confirmar Contraseña">

                <input type="submit" name="submit" value="Confirmar">
            </form>
        </section>
        <a href="/mi-cuenta" class="btn-volver">Volver a Mi Cuenta</a>
    </main>
    <?php include 'parts/footer.php'; ?>
</body>
</html>
