<?php foreach ($libros as $libro): ?>
    <article class="libro-portada" itemscope itemtype="https://schema.org/Book"
        data-titulo="<?= htmlspecialchars($libro->campos['titulo']) ?>"
        data-autor="<?= htmlspecialchars($libro->campos['autor']) ?>" data-precio="<?= (float) $libro->campos['precio'] ?>">

        <a href="/libro?id=<?= $libro->campos["id"] ?>" itemprop="url">
            <figure>
                <img src="<?= $libro->campos["ruta_a_imagen"] ?>" alt="portada-libro" itemprop="image">
            </figure>
            <h3 itemprop="name"><?= $libro->campos['titulo'] ?></h3>
        </a>

        <p>Autor: <span itemprop="author"><?= $libro->campos['autor'] ?></span></p>

        <section itemprop="offers" itemscope itemtype="https://schema.org/Offer">
            <p>
                Precio: <span itemprop="price" content="<?= (float) $libro->campos['precio'] ?>">
                    $ <?= number_format((float) $libro->campos['precio'], 0, ',', '.') ?>
                </span>
                <meta itemprop="priceCurrency" content="ARS" />
            </p>
        </section>
    </article>
<?php endforeach; ?>