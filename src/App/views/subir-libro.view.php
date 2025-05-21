<?php include "parts/head.php" ?>

<body class="<?= htmlspecialchars($htmlClass ?? 'subir-libro') ?>">
    <?php include "parts/header.php"; ?>

    <main>
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a class="breadcrumb-link" href="../">Home</a></li>
            <li class="breadcrumb-item">Administración</li>
            <li class="breadcrumb-item" aria-current="page">Subir Libro</li>
        </ul>

        <section class="subir-libro">
            <form id="formSubirLibro" class="subir-libro-form" action="/procesar-libro" method="post"
                enctype="multipart/form-data">
                <h3 class="subtitulo">Cargar nuevo libro</h3>

                <label for="titulo">Título*</label>
                <input id="titulo" type="text" name="titulo" placeholder="Título del libro" required>
                <span id="error-titulo" class="error-message" aria-live="polite"></span>

                <label for="autor">Autor*</label>
                <input id="autor" type="text" name="autor" placeholder="Autor" required>
                <span id="error-autor" class="error-message" aria-live="polite"></span>

                <label for="descripcion">Descripción*</label>
                <textarea id="descripcion" name="descripcion" placeholder="Resumen del libro" required></textarea>
                <span id="error-descripcion" class="error-message" aria-live="polite"></span>

                <label for="precio">Precio (ARS)*</label>
                <input id="precio" type="number" name="precio" placeholder="Ej: 25000" required>
                <span id="error-precio" class="error-message" aria-live="polite"></span>

                <label for="imagen">Portada del libro*</label>
                <input id="imagen" type="file" name="imagen" accept="image/*" required>
                <span id="error-imagen" class="error-message" aria-live="polite" ></span>

                <input type="submit" name="submit" value="Subir libro" disabled>
            </form>
        </section>
    </main>

    <?php include "parts/footer.php"; ?>
</body>

</html>