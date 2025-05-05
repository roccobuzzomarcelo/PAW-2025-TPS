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
    </main>
    <?php include 'parts/footer.php'; ?> 
</body>

</html>