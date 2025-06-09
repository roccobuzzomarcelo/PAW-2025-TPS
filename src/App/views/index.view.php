<!DOCTYPE html>
<html class="<?= htmlspecialchars($htmlClass ?? '') ?>" lang="es">
<?php include 'parts/head.php' ?>

<body class="<?= htmlspecialchars($htmlClass ?? 'index') ?>" itemscope itemtype="https://schema.org/WebSite">
    <meta itemprop="name" content="PAW Prints" url="https://paw-2025-tps.onrender.com/">

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
        </ul>

        <!-- CAROUSEL -->
        <div class="carousel-container">
            <img src="/images/carousel/imagen1.jpg" />
            <img src="/images/carousel/imagen2.jpg" />
            <img src="/images/carousel/imagen3.jpg" />
            <img src="/images/carousel/imagen4.jpg" />
        </div>

        <!-- NOVEDADES -->
        <h2 class="subtitulo">Novedades</h2>
        <section class="cont-libros" itemscope itemtype="https://schema.org/ItemList">
            <?php $libros = $novedades;
            include 'parts/mostrarLibros.php'; ?>
        </section>

        <!-- MÁS VENDIDOS -->
        <h2 class="subtitulo">Más Vendidos</h2>

        <section class="cont-libros" itemscope itemtype="https://schema.org/ItemList">
            <?php $libros = $masVendidos;
            include 'parts/mostrarLibros.php'; ?>
        </section>

        <!-- RECOMENDADOS -->
        <h2 class="subtitulo">Recomendados</h2>

        <section class="cont-libros" itemscope itemtype="https://schema.org/ItemList">
            <?php $libros = $recomendados;
            include 'parts/mostrarLibros.php'; ?>
        </section>
    </main>

    <?php include 'parts/footer.php'; ?>
</body>

</html>