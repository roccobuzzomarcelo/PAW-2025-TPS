<?php foreach ($libros as $libro): ?>
    <article class="libro-portada">
        <a href="/detalle-libro?id=<?= urlencode($libro['id']) ?>">
            <figure>
                <img src="<?= htmlspecialchars($libro['ruta_a_imagen']) ?>" alt="portada-libro">
            </figure>
            <h3><?= htmlspecialchars($libro['titulo']) ?></h3>
        </a>
        <p>$ <?= number_format((float)$libro['precio'], 0, ',', '.') ?></p>
    </article>
<?php endforeach; ?>