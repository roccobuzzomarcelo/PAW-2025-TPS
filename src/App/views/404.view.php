<?php
http_response_code(400);
include "parts/head.php";
?>

<body class="<?= htmlspecialchars($htmlClass ?? 'index') ?>">
    <?php include "parts/header.php"; ?>
    <main>
        <!-- BREADCRUMB -->
        <ul class="breadcrumb" itemscope itemtype="https://schema.org/BreadcrumbList">
            <li class="breadcrumb-item" aria-current="page" itemprop="itemListElement" itemscope
                itemtype="https://schema.org/ListItem">
                <span itemprop="name">No encontrada</span>
                <meta itemprop="position" content="1" />
        </ul>

        <h1 class="error-titulo">¡Página no encontrada!</h1>
        <p class="error-descripcion">Lo sentimos, la página que buscas no existe o ha sido movida.</p>
        <a href="/" class="boton-volver">Volver al inicio</a>
    </main>
    <?php include 'parts/footer.php'; ?>
</body>

</html>