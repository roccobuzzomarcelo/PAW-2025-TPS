<?php include 'parts/head.php'?>
<body>
    
    <?php include 'parts/header.php'; ?>

    <main>
        <!-- BREADCRUMB -->
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a class="breadcrumb-link" href="../">Home</a></li>
            <li class="breadcrumb-item" aria-current="page">Catálogo</li>
        </ul>
        <nav class="nav-categoria">
            <label for="categorias">
                Categorías:
                <select name="categorias" id="categorias">
                    <option value="Ficción">Ficción</option>
                    <option value="Novela">Novela</option>
                    <option value="Infantil">Infantil</option>
                </select>
            </label>
        </nav>
        <h2 class="subtitulo">Libros Disponibles</h2>
        <section class="cont-libros">
            <?php
                include "parts/mostrarLibros.php";
            ?>
        </section>
        <!-- Paginación -->
        <nav class="paginacion">
            <?php if ($pagina > 1): ?>
                <a href="?pagina=<?= $pagina - 1 ?>&libros_por_pagina=<?= $librosPorPagina ?>&consulta=<?= htmlspecialchars($consulta) ?>" class="flecha">&#8592;</a>
            <?php endif; ?>

            <span>Página <?= $pagina ?> de <?= $totalPaginas ?></span>

            <?php if ($pagina < $totalPaginas): ?>
                <a href="?pagina=<?= $pagina + 1 ?>&libros_por_pagina=<?= $librosPorPagina ?>&consulta=<?= htmlspecialchars($consulta) ?>" class="flecha">&#8594;</a>
            <?php endif; ?>
        </nav>
    </main>
    <?php include 'parts/footer.php'; ?> 
</body>

</html>