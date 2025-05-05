<!DOCTYPE html>
<html class="carrito-pages" lang="es">

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
    <title>PAW Prints | Carrito</title>
</head>

<body>
<?php include 'parts/header.php'; ?>
<main>
        <!-- BREADCRUMB -->

        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a class="breadcrumb-link" href="../">Home</a></li>
            <li class="breadcrumb-item"><a class="breadcrumb-link" href="./mi-cuenta.html">Mi Cuenta</a></li>
            <li class="breadcrumb-item" aria-current="page">Carrito</li>
        </ul>

        <section>
            <h2 class="subtitulo">Productos en tu carrito</h2>
            <article class="libro-carrito">
                <figure>
                    <img src="../images/libro.png" alt="Portada de Libro">
                </figure>
                <section class="descripcion-libro">
                    <h3>Título del Libro</h3>
                    <p>$ XXXXXX</p>
                    <button class="btn-eliminarCarrito" type="submit"><i class="fas fa-trash"></i></button>
                </section>
            </article>
        </section>
        <section class="subtotal">
            <h2>Subtotal</h2>
            <p class="precio">$ XXXX</p>
            <a href="https://pawprints/finalizar-compra/" class="boton-link">
                Finalizar compra
            </a>
            <a href="../" class="boton-link">
                Ver más productos
            </a>
        </section>
    </main>
    <?php include 'parts/footer.php'; ?> 
    </body>

</html>