<?php include 'parts/head.php' ?>

<?php if (!isset($libro) || !is_object($libro) || !isset($libro->campos)): ?>
    <p>Error: libro no encontrado.</p>
    <?php return; ?>
<?php endif; ?>

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
                <a class="breadcrumb-link" href="../libro/detalle-libro.html" itemprop="item">
                    <span itemprop="name">Libro</span>
                </a>
                <meta itemprop="position" content="2" />
            </li>
            <li class="breadcrumb-item" aria-current="page" itemprop="itemListElement" itemscope
                itemtype="https://schema.org/ListItem">
                <span itemprop="name">Reserva</span>
                <meta itemprop="position" content="3" />
            </li>
        </ul>

        <h1 class="subtitulo">Reserva de libro</h1>

        <section class="detalle-libro" itemscope itemtype="https://schema.org/Book">
            <meta itemprop="isbn" content="<?= htmlspecialchars($libro->campos['isbn'] ?? '') ?>" />
            <figure>
                <img class="img-detalle" src="<?= htmlspecialchars($libro->campos['ruta_a_imagen']) ?>"
                    alt="portada del libro" itemprop="image">
            </figure>

            <section class="descripcion-libro">
                <h2 itemprop="name"><?= htmlspecialchars($libro->campos['titulo']) ?></h2>

                <div itemprop="offers" itemscope itemtype="https://schema.org/Offer">
                    <p class="precio">
                        $ <span
                            itemprop="price"><?= number_format((float) $libro->campos['precio'], 0, ',', '.') ?></span>
                        <meta itemprop="priceCurrency" content="ARS" />
                    </p>
                </div>

                <form class="Reserva" action="/reservar" method="post" itemscope
                    itemtype="https://schema.org/ReserveAction">
                    <meta itemprop="object" content="<?= htmlspecialchars($libro->campos['titulo']) ?>" />

                    <input type="hidden" name="libro_id" value="<?= htmlspecialchars($libro->campos['id']) ?>">

                    <label for="inputNombre">Nombre<span class="requerido"> *</span></label>
                    <input id="inputNombre" type="text" name="inputNombre"
                        value="<?= htmlspecialchars($datos['nombre']) ?>" required title="Este campo es obligatorio"
                        itemprop="agent">

                    <label for="inputEmail">Email<span class="requerido"> *</span></label>
                    <input id="inputEmail" type="email" name="inputEmail"
                        value="<?= htmlspecialchars($datos['email']) ?>" required title="Este campo es obligatorio">

                    <!-- Dirección -->
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

                    <!-- Método de entrega -->
                    <label for="inputEnvio">
                        <input type="radio" id="inputEnvio" name="inputEnvio" value="envío" required> Envío a domicilio
                    </label>
                    <label for="inputRetiro">
                        <input type="radio" id="inputRetiro" name="inputEnvio" value="retira" required> Retiro en tienda
                    </label>

                    <input type="submit" name="Reservar" value="Reservar" itemprop="actionStatus">
                </form>
            </section>
        </section>
    </main>
    <?php include 'parts/footer.php' ?>
</body>

</html>