<?php include 'parts/head.php'?>
<body class="<?= htmlspecialchars($htmlClass ?? 'index') ?>">
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
                <?php include "parts/mostrarLibros.php"?>
            </article>
        </section>
        <section class="subtotal">
            <h2>Subtotal</h2>
            <p class="precio">
                <?php
                    $subtotal = array_sum(array_map(fn($libro) => $libro->campos['precio'], $libros));
                    $subtotalFormateado = number_format((float)$subtotal, 0, ',', '.');
                    echo "$ ".htmlspecialchars($subtotalFormateado);
                ?>
            </p>
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