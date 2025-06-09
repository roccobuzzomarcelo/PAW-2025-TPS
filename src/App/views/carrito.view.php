<?php include 'parts/head.php' ?>

<body class="<?= htmlspecialchars($htmlClass ?? 'index') ?>">
    <?php include 'parts/header.php'; ?>
    <main>
        <!-- BREADCRUMB -->
        <ul class="breadcrumb" itemscope itemtype="https://schema.org/BreadcrumbList">
            <li class="breadcrumb-item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                <a class="breadcrumb-link" href="../" itemprop="item">
                    <span itemprop="name">Home</span>
                </a>
                <meta itemprop="position" content="1" />
            </li>
            <li class="breadcrumb-item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                <a class="breadcrumb-link" href="./mi-cuenta" itemprop="item">
                    <span itemprop="name">Mi Cuenta</span>
                </a>
                <meta itemprop="position" content="2" />
            </li>
            <li class="breadcrumb-item" aria-current="page" itemprop="itemListElement" itemscope
                itemtype="https://schema.org/ListItem">
                <span itemprop="name">Carrito</span>
                <meta itemprop="position" content="3" />
            </li>
        </ul>
        <section class="carrito" itemscope itemtype="https://schema.org/Order">
            <h2 class="subtitulo">Productos en tu carrito</h2>
            <section>
                <article class="libro-carrito">
                    <?php include "parts/mostrarLibros.php" ?>
                </article>
            </section>
            <section class="subtotal">
                <h2>Subtotal</h2>
                <p class="precio" itemprop="priceCurrency" content="ARS">
                    <?php
                    $subtotal = array_sum(array_map(fn($libro) => $libro->campos['precio'], $libros));
                    $subtotalFormateado = number_format((float) $subtotal, 0, ',', '.');
                    echo "$ " . htmlspecialchars($subtotalFormateado);
                    ?>
                </p>
                <a href="/finalizar-compra" class="boton-link" itemprop="potentialAction" itemscope
                    itemtype="https://schema.org/BuyAction">
                    <span itemprop="name">Finalizar compra</span>
                </a>
                <a href="../" class="boton-link">
                    Ver más productos
                </a>
            </section>
        </section>
    </main>
    <?php include 'parts/footer.php'; ?>
</body>

</html>