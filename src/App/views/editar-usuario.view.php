<?php include "parts/head.php"; ?>

<body class="<?= htmlspecialchars($htmlClass ?? 'index') ?>">
    <?php include "parts/header.php"; ?>
    <main role="main" aria-label="Editar perfil de usuario">
        <!-- BREADCRUMB -->
        <ul class="breadcrumb" itemscope itemtype="https://schema.org/BreadcrumbList">
            <li class="breadcrumb-item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                <a class="breadcrumb-link" href="../" itemprop="item">
                    <span itemprop="name">Home</span>
                </a>
                <meta itemprop="position" content="1" />
            </li>
            <li class="breadcrumb-item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                <a class="breadcrumb-link" href="./mi-cuenta" itemprop="item">
                    <span itemprop="name">Mi Cuenta</span>
                </a>
                <meta itemprop="position" content="2" />
            </li>
            <li class="breadcrumb-item" aria-current="page" itemprop="itemListElement" itemscope
                itemtype="https://schema.org/ListItem">
                <span itemprop="name">Editar Datos</span>
                <meta itemprop="position" content="3" />
            </li>
        </ul>
        <h1>Editar Mis Datos</h1>
        <section class="registrarse">
            <form method="POST" action="/editar-usuario" class="registro-form">

                <label for="inputNombre">Nombre</label>
                <input id="inputNombre" type="nombre" name="inputNombre"
                    value="<?= htmlspecialchars($datos['nombre']) ?>" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?= htmlspecialchars($datos['email']) ?>" required>

                <!-- Podés permitir cambiar contraseña -->
                <label for="password">Nueva Contraseña (opcional):</label>
                <input type="password" id="password" name="password" placeholder="Nueva Contraseña">

                <label for="confirmar_password">Confirmar Contraseña:</label>
                <input type="password" id="confirmar_password" name="confirmar_password"
                    placeholder="Confirmar Contraseña">

                <input type="submit" name="submit" value="Confirmar">
            </form>
        </section>
        <a href="/mi-cuenta" class="btn-volver">Volver a Mi Cuenta</a>
    </main>
    <?php include 'parts/footer.php'; ?>
</body>

</html>