<?php include 'parts/head.php' ?>

<?php if (!isset($libro) || !is_object($libro) || !isset($libro->campos)): ?>
    <p>Error: libro no encontrado.</p>
    <?php return; ?>
<?php endif; ?>

<body class="<?= htmlspecialchars($htmlClass ?? 'index') ?>">
    <?php include "parts/header.php"; ?>
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
                <a class="breadcrumb-link" href="/catalogo" itemprop="item">
                    <span itemprop="name">Catálogo</span>
                </a>
                <meta itemprop="position" content="2" />
            </li>
            <li class="breadcrumb-item" aria-current="page" itemprop="itemListElement" itemscope
                itemtype="https://schema.org/ListItem">
                <span itemprop="name"><?= htmlspecialchars($libro->campos['titulo']) ?></span>
                <meta itemprop="position" content="3" />
            </li>
        </ul>
        <!-- Información del Libro -->
        <section class="detalle-libro" itemscope itemtype="https://schema.org/Book">
            <figure>
                <img class="img-detalle" src="<?= htmlspecialchars($libro->campos['ruta_a_imagen']) ?>"
                    alt="portada del libro" itemprop="image">
            </figure>

            <section class="descripcion-libro">
                <h2 itemprop="name"><?= htmlspecialchars($libro->campos['titulo']) ?></h2>

                <p><span><strong>Descripción: </strong></span><span
                        itemprop="description"><?= htmlspecialchars($libro->campos['descripcion']) ?></span></p>

                <p class="autor"><strong>Autor: </strong><span
                        itemprop="author"><?= htmlspecialchars($libro->campos['autor']) ?></span>
                </p>

                <section itemprop="offers" itemscope itemtype="https://schema.org/Offer">
                    <p class="precio">
                        <strong>Precio:</strong> <span itemprop="price"
                            content="<?= (float) $libro->campos['precio'] ?>">
                            $ <?= number_format((float) $libro->campos['precio'], 0, ',', '.') ?>
                        </span>
                        <meta itemprop="priceCurrency" content="ARS" />
                    </p>
                </section>

                <link itemprop="url" href="<?= "https://tusitio.com/libro?id=" . urlencode($libro->campos['id']) ?>" />

                <a class="boton-link" href="/agregar-carrito?id=<?= urlencode($libro->campos['id']) ?>">Agregar al
                    carrito</a>
                <a class="boton-link" href="/reservar?id=<?= urlencode($libro->campos['id']) ?>">Reservar libro</a>
            </section>
        </section>


        <!-- Similares -->
        <h2 class="subtitulo"> Similares a este: </h2>

        <section class="cont-libros">
            <?php $libros = $mismoAutorLibros;
            include 'parts/mostrarLibros.php'; ?>
        </section>
    </main>
    <?php include 'parts/footer.php'; ?>
</body>

</html>