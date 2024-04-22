<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket de compra</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            background-color: #ffffff; 
        }
        .ticket {
            background-color: #ffffff;
            border: 3px solid #DF3B3B;
            border-radius: 10px;
            padding: 30px;
            margin-top: 50px;
        }
        .ticket-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .ticket-logo {
            width: 60px; 
            height: auto;
            margin-bottom: 10px; 
        }
        .ticket-heading {
            margin-bottom: 5px;
        }
        .ticket-detail span {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="ticket">
                    <div class="ticket-header">
                        <img src="<?= base_url()?>/img/icono.png" alt="Logo del cine" class="ticket-logo">
                        <h1 class="ticket-heading">BenVani Cinplex</h1>
                        <h2 class="ticket-heading">Ticket de Compra</h2>
                    </div>
                    <div class="ticket-detail">
                        <span>Folio:</span> <?= $ticket['folio'] ?>
                    </div>
                    <div class="ticket-detail">
                        <span>Nombre del Cliente:</span> <?= $ticket['nombre_cliente'] ?>
                    </div>
                    <div class="ticket-detail">
                        <span>Película:</span> <?= $pelicula['titulo_pelicula'] ?>
                    </div>
                    <div class="ticket-detail">
                        <span>Sala:</span> <?= $ticket['id_sala'] ?>
                    </div>
                    <div class="ticket-detail">
                        <span>Horario:</span> <?= $horario['horario_inicio'] ?> - <?= $horario['horario_final'] ?>
                    </div>
                    <div class="ticket-detail">
                        <span>Número de Asientos:</span> <?= $ticket['numero_asientos'] ?>
                    </div>
                    <div class="ticket-detail">
                        <span>Fecha de Compra:</span> <?= $ticket['fecha_compra'] ?>
                    </div>
                    <div class="ticket-detail">
                        <span>Total:</span> <?= $ticket['total'] ?>
                    </div>
                    <div class="ticket-detail">
                        <span>Vendido por:</span> <?= $usuario['nombre_usuario'] ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
