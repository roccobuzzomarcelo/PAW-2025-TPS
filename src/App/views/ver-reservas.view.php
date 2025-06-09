<?php include 'parts/head.php'; ?>

<body class="admin-reservas">
    <?php include 'parts/header.php'; ?>
    <main class="contenedor">
        <h1 class="subtitulo">Listado de reservas</h1>

        <form method="get" action="/reservas" class="form-busqueda">
            <input type="text" name="consulta" value="<?= htmlspecialchars($_GET['consulta'] ?? '') ?>"
                placeholder="Buscar por nombre, email o ID de libro">
            <button type="submit">Buscar</button>
        </form>

        <?php if (empty($reservas)): ?>
            <p>No se encontraron reservas.</p>
        <?php else: ?>
            <table class="tabla-reservas">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Libro ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Dirección</th>
                        <th>Método Entrega</th>
                        <th>Fecha Reserva</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reservas as $reserva): ?>
                        <tr>
                            <td><?= htmlspecialchars($reserva->campos['id']) ?></td>
                            <td><?= htmlspecialchars($reserva->campos['id_libro']) ?></td>
                            <td><?= htmlspecialchars($reserva->campos['nombre']) ?></td>
                            <td><?= htmlspecialchars($reserva->campos['email']) ?></td>
                            <td>
                                <?= htmlspecialchars($reserva->campos['calle']) ?>
                                <?= htmlspecialchars($reserva->campos['numero']) ?>,
                                <?= htmlspecialchars($reserva->campos['ciudad']) ?>,
                                <?= htmlspecialchars($reserva->campos['provincia']) ?>
                                (<?= htmlspecialchars($reserva->campos['codigo_postal']) ?>)
                            </td>
                            <td><?= htmlspecialchars($reserva->campos['metodo_entrega']) ?></td>
                            <td><?= htmlspecialchars($reserva->campos['created_at']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </main>
    <?php include 'parts/footer.php'; ?>
</body>

</html>