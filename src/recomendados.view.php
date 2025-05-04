<?php
?>
<!DOCTYPE html>
<html class="catalogo-pages" lang="es">

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
    <title>PAW Prints | Recomendados</title>
</head>

<body>
    <?php include __DIR__ . '/includes/header.php'; ?>
    <main>
        <!-- BREADCRUMB -->
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a class="breadcrumb-link" href="../">Home</a></li>
            <li class="breadcrumb-item"><a class="breadcrumb-link" href="./catalogo.html">Catálogo</a></li>
            <li class="breadcrumb-item" aria-current="page">Recomendados</li>
        </ul>
        <h2 class="subtitulo">Recomendados</h2>
        <section class="cont-libros">
            <?php foreach ($libros as $libro): ?>
                <article class="libro-portada">
                    <a href="detalle.php?id=<?= urlencode($libro['id']) ?>">
                        <figure>
                            <img src="<?= htmlspecialchars($libro['img']) ?>" alt="portada-libro">
                        </figure>
                        <h3><?= htmlspecialchars($libro['titulo']) ?></h3>
                    </a>
                    <p>$ <?= number_format((float)$libro['precio'], 0, ',', '.') ?></p>
                </article>
            <?php endforeach; ?>
        </section>
    </main>
    <?php include __DIR__ . '/includes/footer.php'; ?> 

</body>

</html>