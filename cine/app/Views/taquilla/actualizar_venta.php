<?=$cabecera?>

<div>
    <form action="<?=base_url('ticket/actualizar')?>" method="post" enctype="multipart/form-data"  class="row">
        <div class="col-md-4">
            <img id="imagenPelicula" src="<?= base_url() ?>/uploads/<?= $pelicula['imagen'] ?>" class="card-img mt-3" style="object-fit: contain;" alt="Imagen de la película">
        </div>
        <div class="col-md-8">
            <input type="hidden" name="id_ticket" value="<?=$ticket['id_ticket']?>">
            <input type="hidden" name="folio" value="<?=$ticket['folio']?>">
            <input type="hidden" name="id_pelicula" id="id_pelicula" value="<?=$pelicula['id_pelicula']?>">
            <input type="hidden" name="id_usuario" value="<?=session("id_usuario")?>">
            <select id="pelicula" name="pelicula" class="form-select form-select-lg mt-3" onchange="mostrarImagen(); limpiarAsientosYTotal();">
                <option value="">Seleccione una película</option>
                <?php foreach ($peliculas_activas as $p): ?>
                    <option value="<?= $p['id_pelicula'] ?>" <?= ($ticket['id_pelicula'] == $p['id_pelicula']) ? 'selected' : '' ?>>
                        <?= $p['titulo_pelicula'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
                <label for="nombre_cliente" class="mt-3 p-1" style="font-size: 1.12rem; color: white;" ><Strong>Nombre del Cliente</Strong></label>
                <input type="text" name="nombre_cliente" id="nombre_cliente" class="form-control form-control-lg mt-3" value="<?= $ticket['nombre_cliente'] ?>" placeholder="Nombre del Cliente" required>
                <select id="sala" name="sala" class="form-select form-select-lg mt-3" onchange="actualizarHorarios();" required>
                    <option value="">Seleccione una sala</option>
                    <?php foreach ($salas as $sala): ?>
                        <option value="<?= $sala['id_sala'] ?>" <?= ($ticket['id_sala'] == $sala['id_sala']) ? 'selected' : '' ?>><?= $sala['nombre_sala'] ?></option>
                    <?php endforeach; ?>
                </select>
                <select id="horarios" name="horarios" class="form-select form-select-lg mt-3" required>
                    <option value="">Seleccione un horario</option>
                    <?php foreach ($horarios_disponibles as $horario): ?>
                        <option value="<?= $horario['id_horario'] ?>" <?= ($ticket['id_horario'] == $horario['id_horario']) ? 'selected' : '' ?>>
                            <?= $horario['horario_inicio'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <input type="date" name="fecha_compra" id="fecha_compra" class="form-control form-control-lg mt-3" value="<?= $ticket['fecha_compra'] ?>" min="<?= date('Y-m-d') ?>" max="<?= date('Y-m-d', strtotime('+1 week')) ?>" required>
                <label for="numero_asientos" class="mt-3 p-1" style="font-size: 1.12rem; color: white;" ><Strong>Elija los asientos deseados</Strong></label>
                <input type="number" name="numero_asientos" onchange="calcularPrecio()" id="numero_asientos" class="form-control form-control-lg mt-3" value="<?= $ticket['numero_asientos'] ?>" placeholder="Número de Asientos" min="1" max="20" required>
                <label for="precio_total" class="mt-3 p-1" style="font-size: 1.12rem; color: white;" ><Strong>Precio Total</Strong></label>
                <input type="number" name="precio_total" id="precio_total" class="form-control form-control-lg mt-3" placeholder="Total" value="<?= $ticket['total'] ?>" readonly>
                <label for="nombre_usuario" class="mt-3 p-1" style="font-size: 1.27rem; color: white; background-color:black;" >Usuario que le realizo la Venta: <Strong> <?= session('nombre_usuario') ?></Strong></label>
                <br>
                <button class="btn btn-light m-3" onchange="submitForm();"  type="submit"><strong>Actualizar Compra</strong></button>
                <a href="<?=base_url('ventas')?>" type="submit" id="btnEnviar" class="btn btn-dark m-3"><strong>Cancelar</strong></a>
        </div>
    </form>
</div>

<?=$piepagina?>

<script>
    // Define el precio de la película (puedes obtenerlo desde PHP si no está disponible en el frontend)
    var precioPelicula = <?= $pelicula['precio'] ?>;
    
    function actualizarHorarios() {
        var idSala = document.getElementById('sala').value;

        fetch('<?= site_url('taquilla/horarios/') ?>' + idSala)
            .then(response => response.json())
            .then(data => {
                console.log(data);

                var horariosDropdown = document.getElementById('horarios');
                var nombrePeliculaInput = document.getElementById('nombrePelicula');
                horariosDropdown.innerHTML = '<option value="">Seleccione un horario</option>';

                data.forEach(horario => {
                    var option = document.createElement('option');
                    option.value = horario.id_horario;
                    option.textContent = horario.horario_inicio;
                    horariosDropdown.appendChild(option);
                });
                var peliculaSeleccionada = document.getElementById('pelicula');
                var nombrePelicula = peliculaSeleccionada.options[peliculaSeleccionada.selectedIndex].text;
                nombrePeliculaInput.value = nombrePelicula;
            })
            .catch(error => {
                console.error('Error al obtener los horarios:', error);
            });
    }
    function limpiarAsientosYTotal() {
        document.getElementById('numero_asientos').value = '';
        document.getElementById('precio_total').value = '';
    }

    function mostrarImagen() {
        var selectPelicula = document.getElementById('pelicula');
        var imagenPelicula = document.getElementById('imagenPelicula');
        var idPeliculaSeleccionada = selectPelicula.value; // Obtener el ID de la película seleccionada
        var imagen;

        // Definir un array asociativo que contenga las rutas de las imágenes según el ID de la película
        var imagenes = {
            <?php foreach ($peliculas_activas as $p): ?>
                <?= $p['id_pelicula'] ?>: '<?= base_url() ?>/uploads/<?= $p['imagen'] ?>',
            <?php endforeach; ?>
        };
        
        // Verificar si el ID de la película seleccionada está en el array de imágenes
        if (idPeliculaSeleccionada in imagenes) {
            imagen = imagenes[idPeliculaSeleccionada];
        } else {
            // Si el ID de la película seleccionada no está en el array, mostrar una imagen por defecto o un mensaje de error
            imagen = '<?= base_url() ?>/img/ra.jpg';
        }
        
        // Asignar la ruta de la imagen al atributo src de la etiqueta img
        imagenPelicula.src = imagen;
    }
    function calcularPrecio() {
        var numeroAsientos = document.getElementById('numero_asientos').value;
        var precioTotalInput = document.getElementById('precio_total');
        if (numeroAsientos >= 1 && numeroAsientos <= 20 && !isNaN(numeroAsientos) && Number.isInteger(parseFloat(numeroAsientos))) {
            var precioTotal = precioPelicula * numeroAsientos;
            precioTotalInput.value = precioTotal.toFixed(2); // Redondea el precio total a dos decimales
        } else {
            alert('Por favor, seleccione un número de asientos válido entre 1 y 20.');
            document.getElementById('numero_asientos').value = "";
            precioTotalInput.value = ''; 
        }
    }
    function submitForm() {
        var form = document.getElementById('ticketForm');
        var formData = new FormData(form);
        
        fetch(form.action, {
            method: form.method,
            body: formData
        })
        .then(response => {
            if (response.ok) {
                // Mostrar mensaje de éxito
                alert('La venta ha sido actualizada exitosamente.');
            } else {
                // Mostrar mensaje de error
                alert('Ha ocurrido un error al actualizar la venta. Por favor, inténtelo de nuevo.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            // Mostrar mensaje de error
            alert('Ha ocurrido un error al actualizar la venta. Por favor, inténtelo de nuevo.');
        });
    }
</script>
