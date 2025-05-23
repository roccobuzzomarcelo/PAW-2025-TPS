<?php include 'parts/head.php'?>
<body class="<?= htmlspecialchars($htmlClass ?? 'index') ?>">
<?php include "parts/header.php"; ?>
    <main>
        <!-- BREADCRUMB -->
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a class="breadcrumb-link" href="/">Home</a></li>
            <li class="breadcrumb-item"><a class="breadcrumb-link" href="/catalogo">Catálogo</a></li>
            <li class="breadcrumb-item" aria-current="page"><?= htmlspecialchars($libro->campos['titulo']) ?></li>
        </ul>
        <section class="detalle-libro">
            <figure>
                <img class="img-detalle" src="<?= htmlspecialchars($libro->campos['ruta_a_imagen']) ?>" alt="portada del libro">
            </figure>

            <section class="descripcion-libro">
                <h2><?= htmlspecialchars($libro->campos['titulo']) ?></h2>
                <p><span>Descripción: </span><?= htmlspecialchars($libro->campos['descripcion']) ?></p>
                <p class="autor">Autor: <?= htmlspecialchars($libro->campos['autor']) ?>.</p>
                <p class="precio">$ <?= number_format((float)$libro->campos['precio'], 0, ',', '.') ?></p>
                <a class="boton-link" href="/carrito?id=<?= urlencode($libro->campos['id']) ?>">Agregar al carrito</a>
                <a class="boton-link" href="/reservar?id=<?= urlencode($libro->campos['id']) ?>">Reservar libro</a>
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