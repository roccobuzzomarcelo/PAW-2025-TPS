<!DOCTYPE html>
<html class="not-found" lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/styles.css">
    <link rel="stylesheet" href="../styles/print.css" media="print">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Archivo+Black&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <title><?= htmlspecialchars($libro['titulo']) ?></title>
</head>
<body>
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
                <a class="boton-link" href="/carrito.php?agregar=<?= urlencode($libro['id']) ?>">Agregar al carrito</a>
                <a class="boton-link" href="/reserva.php?id=<?= urlencode($libro['id']) ?>">Reservar libro</a>
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