<?php include 'parts/head.php' ?>

<body class="<?= htmlspecialchars($htmlClass ?? 'index') ?>">
    <?php include 'parts/header.php'; ?>
    <main>
        <!-- BREADCRUMB -->
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a class="breadcrumb-link" href="../">Home</a></li>
            <li class="breadcrumb-item"><a class="breadcrumb-link" href="../libro/detalle-libro.html">Libro</a></li>
            <li class="breadcrumb-item" aria-current="page">Reserva</li>
        </ul>
        <h1 class="subtitulo">Reserva de libro</h1>
        <section class="detalle-libro">
            <figure>
                <img class="img-detalle" src="<?= htmlspecialchars($libro->campos['ruta_a_imagen']) ?>" alt="portada del libro">
            </figure>

            <section class="descripcion-libro">
                <h2><?= htmlspecialchars($libro->campos['titulo']) ?></h2>
                <p class="precio">$ <?= number_format((float) $libro->campos['precio'], 0, ',', '.') ?></p>
                <form class="Reserva" action="/reservar" method="post">
                    <input type="hidden" name="libro_id" value="<?= htmlspecialchars($libro->campos['id']) ?>">

                    <label for="inputNombre">Nombre<span class="requerido"> *</span></label>
                    <input id="inputNombre" type="text" name="inputNombre" value="<?= htmlspecialchars($datos['nombre']) ?>" required
                        title="Este campo es obligatorio">

                    <label for="inputEmail">Email<span class="requerido"> *</span></label>
                    <input id="inputEmail" type="email" name="inputEmail" value="<?= htmlspecialchars($datos['email']) ?>" required
                        title="Este campo es obligatorio">

                    <label for="inputCalle">Calle</label>
                    <input id="inputCalle" type="text" name="inputCalle" placeholder="Calle">

                    <label for="inputNumero">N°</label>
                    <input id="inputNumero" type="number" name="inputNumero" placeholder="N°">

                    <label for="inputCiudad">Ciudad</label>
                    <input id="inputCiudad" type="text" name="inputCiudad" placeholder="Ciudad">

                    <label for="inputProvincia">Provincia</label>
                    <input id="inputProvincia" type="text" name="inputProvincia" placeholder="Provincia">

                    <label for="inputCodigoPostal">Código Postal</label>
                    <input id="inputCodigoPostal" type="number" name="inputCodigoPostal" placeholder="Código Postal">

                    <label for="inputEnvio">
                        <input type="radio" id="inputEnvio" name="inputEnvio" value="envío" required> Envío a domicilio
                    </label>
                    <label for="inputRetiro">
                        <input type="radio" id="inputRetiro" name="inputEnvio" value="retira" required> Retiro en tienda
                    </label>

                    <input type="submit" name="Reservar" value="Reservar">
                </form>
            </section>
        </section>
    </main>
    <?php include 'parts/footer.php' ?>
</body>

</html>