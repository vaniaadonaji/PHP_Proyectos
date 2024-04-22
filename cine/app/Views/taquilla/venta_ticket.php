<?=$cabecera?>

<div class="row">
    <div class="col-md-4">
        <img src="<?= base_url() ?>/uploads/<?= $pelicula['imagen']; ?>" class="card-img mt-3" style="object-fit: contain;" alt="...">
    </div>
    <div class="col-md-8">
        <form action="<?=base_url('taquilla/guardar')?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id_pelicula" value="<?=$pelicula['id_pelicula']?>">
            <input type="hidden" name="id_usuario" value="<?=session("id_usuario")?>">
            <input type="text" name="titulo_pelicula" id="titulo_pelicula" class="form-control form-control-lg mt-3" value="<?= $pelicula['titulo_pelicula'] ?>" readonly>
            <label for="nombre_cliente" class="mt-3 p-1" style="font-size: 1.12rem; color: white;" ><Strong>Nombre del Cliente</Strong></label>
            <input type="text" name="nombre_cliente" id="nombre_cliente" class="form-control form-control-lg mt-3" value="<?= old('nombre_cliente') ? old('nombre_cliente') : '' ?>" placeholder="Nombre del Cliente" required>
            <select id="sala" name="sala" class="form-select form-select-lg mt-3" onchange="actualizarHorarios();" required>
                <option value="">Seleccione una sala</option>
                <?php foreach ($salas as $sala): ?>
                    <option value="<?= $sala['id_sala'] ?>"><?= $sala['nombre_sala'] ?></option>
                <?php endforeach; ?>
            </select>
            <select id="horarios" name="horarios" class="form-select form-select-lg mt-3" required>
                <option value="">Seleccione un horario</option>
                <?php foreach ($horarios as $horario): ?>
                    <option value="<?= $horario['id_horario'] ?>" <?= old('horarios') == $horario['id_horario'] ? 'selected' : '' ?>>
                        <?= $horario['horario_inicio'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <input type="date" name="fecha_compra" id="fecha_compra" class="form-control form-control-lg mt-3" min="<?= date('Y-m-d') ?>" max="<?= date('Y-m-d', strtotime('+1 week')) ?>" value="<?= old('fecha_compra') ?>" required>
            <label for="numero_asientos" class="mt-3 p-1" style="font-size: 1.12rem; color: white;" ><Strong>Elija los asientos deseados</Strong></label>
            <input type="number" name="numero_asientos" id="numero_asientos" class="form-control form-control-lg mt-3" placeholder="Número de Asientos" min="1" max="20" value="<?= old('numero_asientos') ?>" oninput="calcularPrecio()" required>
            <label for="precio_total" class="mt-3 p-1" style="font-size: 1.12rem; color: white;" ><Strong>Precio Total</Strong></label>
            <input type="number" name="precio_total" id="precio_total" class="form-control form-control-lg mt-3" placeholder="Total" value="<?= old('precio_total') ?>" readonly>
            <label for="nombre_usuario" class="mt-3 p-1" style="font-size: 1.27rem; color: white; background-color:black;" >Usuario que le realizo la Venta: <Strong> <?= session('nombre_usuario') ?></Strong></label>
            <br>
            <button class="btn btn-light m-3"  type="submit"><strong>Confirmar Compra</strong></button>
            <a href="<?=base_url('taquilla')?>" type="submit" id="btnEnviar" class="btn btn-dark m-3"><strong>Cancelar</strong></a>
        </form>
    </div>
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
                horariosDropdown.innerHTML = '<option value="">Seleccione un horario</option>';

                data.forEach(horario => {
                    var option = document.createElement('option');
                    option.value = horario.id_horario;
                    option.textContent = horario.horario_inicio;
                    horariosDropdown.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Error al obtener los horarios:', error);
            });
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
    
</script>