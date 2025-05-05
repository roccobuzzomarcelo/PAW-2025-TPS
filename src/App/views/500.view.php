<!DOCTYPE html>
<html class="error-500" lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/styles.css">
    <link rel="stylesheet" href="../styles/print.css" media="print">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Archivo+Black&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <title>Error 500 - Problema interno</title>
</head>

<body>
<?php include 'parts/header.php'; ?>
    <main>
        <!-- BREADCRUMB -->
        <ul class="breadcrumb">
            <li class="breadcrumb-item" aria-current="page">Error del servidor</li>
        </ul>

        <h1 class="error-titulo">¡Algo salió mal!</h1>
        <p class="error-descripcion">Estamos teniendo problemas técnicos. Intenta nuevamente más tarde.</p>
        <a href="/" class="boton-volver">Volver al inicio</a>
    </main>
<?php include 'parts/footer.php'; ?>
</body>
</html>
