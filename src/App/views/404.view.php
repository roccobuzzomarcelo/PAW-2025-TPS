<?php include "parts/head.php"; ?>
<body class="<?= htmlspecialchars($htmlClass ?? 'index') ?>">
<?php include "parts/header.php"; ?>
    <main>
        <!-- BREADCRUMB -->

        <ul class="breadcrumb">
            <li class="breadcrumb-item" aria-current="page">No encontrada</li>
        </ul>
        <h1 class="error-titulo">¡Página no encontrada!</h1>
        <p class="error-descripcion">Lo sentimos, la página que buscas no existe o ha sido movida.</p>
        <a href="/" class="boton-volver">Volver al inicio</a>
    </main>
    <?php include 'parts/footer.php'; ?>
</body>
</html>
