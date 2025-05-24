<?php include "parts/head.php"; ?>
<body class="<?= htmlspecialchars($htmlClass ?? 'index') ?>">
<?php include "parts/header.php"; ?>
    <main>
        <!-- BREADCRUMB -->

        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a class="breadcrumb-link" href="../">Home</a></li>
            <li class="breadcrumb-item" aria-current="page">Mi cuenta</li>
        </ul>
        <h2>Mi Cuenta</h2>

        <section class="datos-usuario">
            <p><strong>Nombre:</strong> <?= htmlspecialchars($datos['nombre']) ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($datos['email']) ?></p>
            <p><strong>Rol:</strong> <?= htmlspecialchars($datos['rol']) ?></p>
            <p><strong>Estado:</strong> <?= $datos['activo'] ? 'Activo' : 'Inactivo' ?></p>
        </section>

        <nav class="acciones-cuenta">
            <a href="/editar-usuario" class="btn">Editar mis datos</a>
            <a href="/logout" class="btn btn-logout">Cerrar sesión</a>
        </nav>
    </main>
    <?php include 'parts/footer.php'; ?>
</body>
</html>
