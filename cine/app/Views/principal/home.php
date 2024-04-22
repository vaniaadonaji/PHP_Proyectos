<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BenVani Cineplex</title>
    <link rel="icon" type="image/png" href="<?=base_url()?>/img/icono.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Alfa+Slab+One&family=Bangers&family=Bayon&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>/css/Estilos.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</head>
<body class="background3">
    <nav class="navbar navbar-expand-lg navbar-light bg-light"> 
        <div class="container-fluid">
            <a class="navbar-brand" href="<?= base_url('home/') ?>">BenVani Cineplex</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link btn btn-outline-info mx-2" href="<?= base_url('usuarios/') ?>">Usuarios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-outline-info mx-2" href="<?= base_url('peliculas/') ?>">Peliculas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-outline-info mx-2" href="<?= base_url('taquilla/') ?>">Taquilla</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-outline-info mx-2" href="<?= base_url('ventas/') ?>">Ventas BenVani Cineplex</a>
                    </li>
                </ul>
                <!-- Botones a la derecha -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link btn btn-outline-success mx-2" href="#">Perfil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-outline-danger" href="<?= base_url('salir/') ?>">Salir</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-4" style="height: 100vh; display: flex; justify-content: flex-end; align-items: center;">
        <h1 class="titulo-bienvenida">
            <span>¡Bienvenido a</span>
            <span>BenVani Cineplex!</span>
        </h1>
    </div>


</body>
</html>
