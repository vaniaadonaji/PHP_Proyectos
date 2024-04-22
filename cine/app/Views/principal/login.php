<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BenVani Cineplex</title>
    <link rel="icon" type="image/png" href="<?=base_url()?>/img/icono.png">
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>/css/Estilos.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</head>
<body class="background img-fluid container-fluid">
<?php 
            if(session('mensaje')){ 
        ?>

        <div class="alert alert-info" role="alert">
            <?php 
                echo session('mensaje');
            ?>
        </div>

        <?php
            }
        ?>
    <div class="container-fluid d-flex">
        <div class="row">
            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6  position-absolute top-50 start-50 translate-middle">
                <div class="card card3 text-bg-dark">
                    <form class="card-body" action="<?= base_url('login') ?>" method="post">
                        <h4 class="text-center"><strong>BenVani Cineplex</strong></h4>
                        <div class="mb-2">
                            <label for="nombre_usuario" class="form-label"><strong>Nombre de Usuario</strong></label>
                            <input type="text" class="form-control" id="nombre_usuario" name="nombre_usuario" placeholder="Ingresa tu Usuario" value="<?=old('nombre_usuario')?>" required>
                        </div>
                        <div class="mb-2">
                            <label for="password" class="form-label"><strong>Password</strong></label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Ingresa tu Password" required>
                        </div>
                        <button type="submit" class="btn btn-danger">Ingresar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
