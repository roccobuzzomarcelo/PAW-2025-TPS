<?php
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="stylesheet" href="styles/print.css" media="print">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Archivo+Black&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <title>PAW Prints | Home</title>
</head>

<body>        

    <?php include 'parts/header.php'; ?>
    
    <main>
        <!-- BREADCRUMB -->

        <ul class="breadcrumb">
            <li class="breadcrumb-item" aria-current="page">Home</li>
        </ul>

        <!-- NOVEDADES -->
        <h2 class="subtitulo">Novedades</h2>
        <section class="cont-libros">
            <?php $libros = $novedades; include 'parts/mostrarLibros.php'; ?>
        </section>

        <!-- MÁS VENDIDOS -->
        <h2 class="subtitulo">Más Vendidos</h2>

        <section class="cont-libros">
            <?php $libros = $masVendidos; include 'parts/mostrarLibros.php'; ?>
        </section>

        <!-- Recomendados -->
        <h2 class="subtitulo">Recomendados</h2>

        <section class="cont-libros">
            <?php $libros = $recomendados; include 'parts/mostrarLibros.php'; ?>
        </section>
    </main>

   <?php include 'parts/footer.php'; ?> 
</body>

</html>