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
    <title>PAW Prints | Novedades</title>
</head>

<body>
    <?php include __DIR__ . '/App/views/parts/header.php'; ?>
    <main>
        <!-- BREADCRUMB -->
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a class="breadcrumb-link" href="../">Home</a></li>
            <li class="breadcrumb-item"><a class="breadcrumb-link" href="./catalogo.html">Catálogo</a></li>
            <li class="breadcrumb-item" aria-current="page">Novedades</li>
        </ul>
        <h2 class="subtitulo">Novedades</h2>
        <section class="cont-libros">
            <?php
                include __DIR__ . "/App/views/parts/mostrarLibros.php";
            ?>
        </section>
    </main>
    <?php include __DIR__ . '/App/views/parts/footer.php'; ?> 
</body>

</html>