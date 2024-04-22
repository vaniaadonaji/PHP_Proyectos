<?=$cabecera?>
<br>
<div class="my-2 row">
    <?php
    // Obtener los valores de los filtros
    $filtro_fecha = isset($_GET['fecha']) ? $_GET['fecha'] : '';
    $filtro_usuario = isset($_GET['usuario']) ? $_GET['usuario'] : '';
    $filtro_folio = isset($_GET['folio']) ? $_GET['folio'] : '';
    ?>
    <div class="row justify-content-center">
        <div class="col-12 col-md-10">
            <form class="row" role="search">
                <div class="col-12 col-sm-6 col-md-4 mb-2">
                    <select id="fecha" name="fecha" style="border: 2px solid #DA4E4E;" class="form-select">
                        <option value="">Seleccionar Fecha</option>
                        <?php foreach ($fechas as $fecha): ?>
                            <option value="<?= $fecha['fecha_compra'] ?>" <?= ($filtro_fecha == $fecha['fecha_compra']) ? 'selected' : '' ?>>
                                <?= $fecha['fecha_compra'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-12 col-md-4 mb-2">
                    <select id="folio" name="folio" style="border: 2px solid #DA4E4E;" class="form-select">
                        <option value="">Seleccionar Folio</option>
                        <?php foreach ($folios as $folio): ?>
                            <option value="<?= $folio['folio'] ?>" <?= ($filtro_folio == $folio['folio']) ? 'selected' : '' ?>>
                                <?= $folio['folio'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-12 col-md-1 mb-2">
                    <button type="submit" class="btn btn-dark">Buscar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row justify-content-center mt-3">
        <?php foreach ($tickets as $ticket):?>
            <div class="col-12 col-md-6 col-lg-4 mb-4">
                <div class="card h-100 tarjeta">
                    <div class="card-body">
                        <h5 class="card-title">Venta # <?=$ticket['id_ticket'];?></h5>
                        <p class="card-text">Folio de la venta: <strong> <?=$ticket['folio']; ?></strong></p>
                        <p class="card-text">Nombre del cliente: <strong><?=$ticket['nombre_cliente']; ?></strong></p>
                        <p class="card-text">ID de la sala: <strong><?=$ticket['id_sala'];?></strong></p>
                        <p class="card-text">ID del horario: <strong><?=$ticket['id_horario'];?></strong></p>
                        <p class="card-text">ID del usuario que realizo la venta: <strong><?=$ticket['id_usuario'];?></strong></p>
                        <p class="card-text">ID de la pelicula: <strong><?=$ticket['id_pelicula'];?></strong></p>
                        <p class="card-text">Numero de asientos: <strong><?=$ticket['numero_asientos'];?></strong></p>
                        <p class="card-text">Fecha de la venta: <strong><?=$ticket['fecha_compra'];?></strong></p>
                        <p class="card-text">Total = <strong>$<?=$ticket['total']; ?></strong></p>
                        <div class="text-center">
                            <form action="<?=base_url('ticket/editar/'.$ticket['id_ticket'])?>" >
                                <button class="btn btn-outline-danger mb-1" type="submit">Editar</button>
                            </form>
                            <form action="<?=base_url('ticket/borrar/'.$ticket['id_ticket'])?>" method="post" onsubmit="return confirmarEliminacionP();">
                                <button class="btn btn-outline-danger" type="submit" >Borrar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <nav aria-label="...">
        <ul class="pagination justify-content-center">
            <!-- Botón Previous -->
            <li class="page-item <?= ($current_page == 1) ? 'disabled' : '' ?>">
            <a class="page-link" href="<?= ($current_page == 1) ? '#' : base_url('ventas?page=' . ($current_page - 1)) ?>">Previous</a>
            </li>
            <!-- Botones de páginas -->
            <?php
            // Determinar el rango de botones a mostrar
            $start = max(1, $current_page - 2);
            $end = min($total_pages, $start + 3);
            // Generar botones de página
            for ($i = $start; $i <= $end; $i++) :
            ?>
            <li class="page-item <?= ($i == $current_page) ? 'active' : '' ?>">
                <a class="page-link" href="<?= base_url('ventas?page=' . $i) ?>"><?= $i ?></a>
            </li>
            <?php endfor; ?>
            <!-- Botón Next -->
            <li class="page-item <?= ($current_page == $total_pages) ? 'disabled' : '' ?>">
            <a class="page-link" href="<?= ($current_page == $total_pages) ? '#' : base_url('ventas?page=' . ($current_page + 1)) ?>">Next</a>
            </li>
        </ul>
    </nav>
</div>
<?=$piepagina?>
<script>
    function confirmarEliminacionP() {
        if (confirm("¿Estás seguro de que deseas eliminar esta Venta?")) {
            return true;
        } else {
            return false;
        }
    }
</script>
