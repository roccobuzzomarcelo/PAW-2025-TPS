<?php
http_response_code(500);
include 'parts/head.php'
    ?>

<body class="<?= htmlspecialchars($htmlClass ?? 'index') ?>">
    <?php include 'parts/header.php'; ?>
    <main>
        <!-- BREADCRUMB -->
        <!-- BREADCRUMB -->
        <ul class="breadcrumb" itemscope itemtype="https://schema.org/BreadcrumbList">
            <li class="breadcrumb-item" aria-current="page" itemprop="itemListElement" itemscope
                itemtype="https://schema.org/ListItem">
                <span itemprop="name">Error del servidor</span>
                <meta itemprop="position" content="1" />
        </ul>

        <h1 class="error-titulo">¡Algo salió mal!</h1>
        <p class="error-descripcion">Estamos teniendo problemas técnicos. Intenta nuevamente más tarde.</p>
        <a href="/" class="boton-volver">Volver al inicio</a>
    </main>
    <?php include 'parts/footer.php'; ?>
</body>

</html>