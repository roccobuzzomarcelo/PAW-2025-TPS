<?php include 'parts/head.php' ?>

<body class="<?= htmlspecialchars($htmlClass ?? 'index') ?>">
    <?php include 'parts/header.php'; ?>
    <main>
        <!-- BREADCRUMB -->
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a class="breadcrumb-link" href="../">Home</a></li>
            <li class="breadcrumb-item"><a class="breadcrumb-link" href="./catalogo.html">Catálogo</a></li>
            <li class="breadcrumb-item" aria-current="page">Promociones</li>
        </ul>
        <h2 class="subtitulo">Promociones</h2>
        <section class="cont-libros">
            <?php
            include 'parts/mostrarLibros.php';
            ?>
        </section>
    </main>

    <?php include 'parts/footer.php'; ?>

</body>

</html>