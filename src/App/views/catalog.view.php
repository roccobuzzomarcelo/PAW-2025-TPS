<?php include 'parts/head.php' ?>

<body class="<?= htmlspecialchars($htmlClass ?? 'index') ?>">
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
        <form method="GET" class="form-cantidad">
            <label for="librosPorPagina">Libros por página:</label>
            <select name="libros_por_pagina" id="librosPorPagina" onchange="this.form.submit()">
                <?php
                $opciones = [5, 10, 20, 50];
                foreach ($opciones as $opcion) {
                    $selected = ($librosPorPagina == $opcion) ? 'selected' : '';
                    echo "<option value=\"$opcion\" $selected>$opcion</option>";
                }
                ?>
            </select>
            <!-- Conservamos la consulta si la hubiera -->
            <?php if ($consulta): ?>
                <input type="hidden" name="consulta" value="<?= htmlspecialchars($consulta) ?>">
            <?php endif; ?>
            <input type="hidden" name="pagina" value="<?= $pagina ?>">
        </form>
        <a href="/descargar_catalogo?pagina=<?= $pagina ?>&libros_por_pagina=<?= $librosPorPagina ?>&consulta=<?= urlencode($consulta) ?>"
            class="btn-descargar">
            Descargar Catalogo
        </a>
        <h2 class="subtitulo">Libros Disponibles</h2>
        <section class="cont-libros">
            <?php
            include "parts/mostrarLibros.php";
            ?>
        </section>
        <!-- Paginación -->
        <nav class="paginacion">
            <?php if ($pagina > 1): ?>
                <a href="?pagina=<?= $pagina - 1 ?>&libros_por_pagina=<?= $librosPorPagina ?>&consulta=<?= htmlspecialchars($consulta) ?>"
                    class="flecha">&#8592;</a>
            <?php endif; ?>

            <span>Página <?= $pagina ?> de <?= $totalPaginas ?></span>

            <?php if ($pagina < $totalPaginas): ?>
                <a href="?pagina=<?= $pagina + 1 ?>&libros_por_pagina=<?= $librosPorPagina ?>&consulta=<?= htmlspecialchars($consulta) ?>"
                    class="flecha">&#8594;</a>
            <?php endif; ?>
        </nav>
    </main>
    <?php include 'parts/footer.php'; ?>
</body>

</html>