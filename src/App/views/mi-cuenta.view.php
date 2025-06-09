<?php include "parts/head.php"; ?>

<body class="<?= htmlspecialchars($htmlClass ?? 'index') ?>">
    <?php include "parts/header.php"; ?>
    <main>
        <!-- BREADCRUMB -->

        <ul class="breadcrumb" itemscope itemtype="https://schema.org/BreadcrumbList">
            <li class="breadcrumb-item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                <a class="breadcrumb-link" href="../" itemprop="item">
                    <span itemprop="name">Home</span>
                </a>
                <meta itemprop="position" content="1" />
            </li>
            <li class="breadcrumb-item" aria-current="page" itemprop="itemListElement" itemscope
                itemtype="https://schema.org/ListItem">
                <span itemprop="name">Mi cuenta</span>
                <meta itemprop="position" content="2" />
            </li>
        </ul>
        <h2>Mi Cuenta</h2>

        <section class="datos-usuario" itemscope itemtype="https://schema.org/Person">
            <p><strong>Nombre:</strong> <span itemprop="name"><?= htmlspecialchars($datos['nombre']) ?></span></p>
            <p><strong>Email:</strong> <a href="mailto:<?= htmlspecialchars($datos['email']) ?>"
                    itemprop="email"><?= htmlspecialchars($datos['email']) ?></a></p>
            <p><strong>Rol:</strong> <span><?= htmlspecialchars($datos['rol']) ?></span></p>
            <p><strong>Estado:</strong> <span><?= $datos['activo'] ? 'Activo' : 'Inactivo' ?></span></p>
        </section>

        <nav class="acciones-cuenta">
            <a href="/editar-usuario" class="btn">Editar mis datos</a>
            <a href="/logout" class="btn btn-logout">Cerrar sesión</a>
        </nav>
    </main>
    <?php include 'parts/footer.php'; ?>
</body>

</html>