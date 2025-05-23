<?php foreach ($libros as $libro): ?>
    <article class="libro-portada">
        <a href="/libro?id=<?= $libro->campos["id"] ?>">
            <figure>
                <img src="<?= $libro->campos["ruta_a_imagen"] ?>" alt="portada-libro">
            </figure>
            <h3><?= $libro->campos['titulo'] ?></h3>
        </a>
        <p>$ <?= number_format((float)$libro->campos['precio'], 0, ',', '.') ?></p>
    </article>
<?php endforeach; ?>