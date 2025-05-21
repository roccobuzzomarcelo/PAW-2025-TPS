<?php include 'parts/head.php'?>
<body class="<?= htmlspecialchars($htmlClass ?? 'index') ?>">
<?php include "parts/header.php"; ?>
    <main>
        <!-- BREADCRUMB -->
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a class="breadcrumb-link" href="/">Home</a></li>
            <li class="breadcrumb-item"><a class="breadcrumb-link" href="/catalogo">Catálogo</a></li>
            <li class="breadcrumb-item" aria-current="page"><?= htmlspecialchars($libro['titulo']) ?></li>
        </ul>
        <section class="detalle-libro">
            <figure>
                <img class="img-detalle" src="<?= htmlspecialchars($libro['img']) ?>" alt="portada del libro">
            </figure>

            <section class="descripcion-libro">
                <h2><?= htmlspecialchars($libro['titulo']) ?></h2>
                <p><span>Descripción: </span><?= htmlspecialchars($libro['descripcion']) ?></p>
                <p class="autor">Autor: <?= htmlspecialchars($libro['autor']) ?>.</p>
                <p class="precio">$ <?= number_format((float)$libro['precio'], 0, ',', '.') ?></p>
                <a class="boton-link" href="/carrito?id=<?= urlencode($libro['id']) ?>">Agregar al carrito</a>
                <a class="boton-link" href="/reservar?id=<?= urlencode($libro['id']) ?>">Reservar libro</a>
            </section>
        </section>

        <!-- Similares -->
        <h2 class="subtitulo"> Similares a este: </h2>

        <section class="cont-libros">
            <?php $libros = $mismoAutorLibros; include 'parts/mostrarLibros.php'; ?>
        </section>
    </main>
    <?php include 'parts/footer.php'; ?>
</body>

</html>