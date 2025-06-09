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
                <a class="breadcrumb-link" href="./catalogo" itemprop="item">
                    <span itemprop="name">Catálogo</span>
                </a>
                <meta itemprop="position" content="2" />
            </li>
            <li class="breadcrumb-item" aria-current="page" itemprop="itemListElement" itemscope
                itemtype="https://schema.org/ListItem">
                <span itemprop="name">Promociones</span>
                <meta itemprop="position" content="3" />
            </li>
        </ul>
        <h2 class="subtitulo">Promociones</h2>
        <section class="cont-libros" itemscope itemtype="https://schema.org/ItemList">
            <?php
            include 'parts/mostrarLibros.php';
            ?>
        </section>
    </main>

    <?php include 'parts/footer.php'; ?>

</body>

</html>