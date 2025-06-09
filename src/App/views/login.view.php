<?php include 'parts/head.php' ?>

<body class="<?= htmlspecialchars($htmlClass ?? 'index') ?>">
    <?php include 'parts/header.php'; ?>
    <main>
        <ul class="breadcrumb" itemscope itemtype="https://schema.org/BreadcrumbList">
            <li class="breadcrumb-item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                <a class="breadcrumb-link" href="../" itemprop="item">
                    <span itemprop="name">Home</span>
                </a>
                <meta itemprop="position" content="1" />
            </li>
            <li class="breadcrumb-item" aria-current="page" itemprop="itemListElement" itemscope
                itemtype="https://schema.org/ListItem">
                <span itemprop="name">Login</span>
                <meta itemprop="position" content="2" />
            </li>
        </ul>
        <section class="iniciar-sesion" itemscope itemtype="https://schema.org/LoginPage">
            <form class="login-form" action="/mi-cuenta" method="post" itemprop="mainEntity">
                <h2 class="subtitulo">Iniciar Sesión</h2>
                <a class="register-link" href="/registro">Registrarse</a>

                <label for="inputEmail">Email</label>
                <input id="inputEmail" type="email" name="inputEmail" placeholder="Email" required
                    value="<?= htmlspecialchars($_COOKIE['email'] ?? '') ?>" itemprop="identifier">

                <label for="inputPassword">Contraseña</label>
                <input id="inputPassword" type="password" name="inputPassword" placeholder="Contraseña" required
                    itemprop="password">

                <label for="inputRecuerdame">
                    <input type="checkbox" name="recuerdame">
                    Recuérdame
                </label>

                <button type="submit">Acceder</button>
                <a href="/recuperar-contraseña">¿Has olvidado tu contraseña?</a>
            </form>
        </section>
    </main>
    <?php include 'parts/footer.php'; ?>
</body>

</html>