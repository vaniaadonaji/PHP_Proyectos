<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pruebas</title>
</head>
<body>
    <h2>Enviar Correo</h2>
    <form action="enviar_correo.php" method="post">
        <label for="destinatario">Destinatario:</label><br>
        <input type="email" id="destinatario" name="destinatario" required><br><br>
        <label for="asunto">Asunto:</label><br>
        <input type="text" id="asunto" name="asunto" required><br><br>
        <label for="mensaje">Mensaje:</label><br>
        <textarea id="mensaje" name="mensaje" rows="4" required></textarea><br><br>
        <input type="submit" value="Enviar">
    </form>
    
    <!-- Botón para descargar el reporte -->
    <form action="descargar_reporte.php" method="get">
        <button type="submit">Descargar Reporte</button>
    </form>
</body>
</html>