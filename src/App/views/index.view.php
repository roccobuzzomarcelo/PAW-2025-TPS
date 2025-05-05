<?php include 'parts/head.php'?>
<body>        

    <?php include 'parts/header.php'; ?>
    
    <main>
        <!-- BREADCRUMB -->

        <ul class="breadcrumb">
            <li class="breadcrumb-item" aria-current="page">Home</li>
        </ul>

        <!-- NOVEDADES -->
        <h2 class="subtitulo">Novedades</h2>
        <section class="cont-libros">
            <?php $libros = $novedades; include 'parts/mostrarLibros.php'; ?>
        </section>

        <!-- MÁS VENDIDOS -->
        <h2 class="subtitulo">Más Vendidos</h2>

        <section class="cont-libros">
            <?php $libros = $masVendidos; include 'parts/mostrarLibros.php'; ?>
        </section>

        <!-- Recomendados -->
        <h2 class="subtitulo">Recomendados</h2>

        <section class="cont-libros">
            <?php $libros = $recomendados; include 'parts/mostrarLibros.php'; ?>
        </section>
    </main>

   <?php include 'parts/footer.php'; ?> 
</body>

</html>