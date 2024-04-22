
<?=$cabecera?>
<br>
<div class="my-2 row">
<?php
// Obtener los valores de los filtros
$filtro_tipo_usuario = isset($_GET['tipo_usuario']) ? $_GET['tipo_usuario'] : '';
$filtro_estado_usuario = isset($_GET['estado_usuario']) ? $_GET['estado_usuario'] : '';
$filtro_nombre_usuario = isset($_GET['u']) ? $_GET['u'] : '';
?>
<div class="row justify-content-center">
    <div class="col-12 col-md-8">
        <form class="row" role="search">
            <div class="col-12 col-sm-6 col-md-4 mb-2">
                <select id="tipo_usuario" name="tipo_usuario" style="border: 2px solid #DA4E4E;" class="form-select">
                    <option value="">Tipo de Usuario</option>
                    <option value="Taquillero" <?= ($filtro_tipo_usuario == 'Taquillero') ? 'selected' : '' ?>>Taquillero</option>
                    <option value="Administrador" <?= ($filtro_tipo_usuario == 'Administrador') ? 'selected' : '' ?>>Administrador</option>
                </select>
            </div>
            <div class="col-12 col-sm-6 col-md-4 mb-2">
                <select id="estado_usuario" name="estado_usuario" style="border: 2px solid #DA4E4E;" class="form-select">
                    <option value="">Estado del Usuario</option>
                    <option value="Activo" <?= ($filtro_estado_usuario == 'Activo') ? 'selected' : '' ?>>Activo</option>
                    <option value="Inactivo" <?= ($filtro_estado_usuario == 'Inactivo') ? 'selected' : '' ?>>Inactivo</option>
                </select>
            </div>
            <div class="col-12 col-md-4 mb-2">
                <div class="input-group">
                    <input name="u" class="form-control" type="search" placeholder="Buscar nombre del usuario..." aria-label="Buscar" value="<?= $filtro_nombre_usuario ?>">
                    <button class="btn btn-danger" type="submit" id="btnBuscar">Buscar</button>
                </div>
            </div>
        </form>
    </div>
</div>
    <div class="row justify-content-center">
        <div class="col-12 text-center">
            <a href="<?=base_url('usuarios/crear')?>" class="btn btn-danger mb-2" type="button">Crear un Usuario</a>
        </div>
    </div>
        <table class="table table-dark mt-2">
            <thead class="table-ligth">
                <tr>
                    <th class="w-25 text-center">Usuario</th>
                    <th class="w-25 text-center">Tipo</th>
                    <th class="w-25 text-center">Estado</th>
                    <th class="w-25 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $usuario):?>
                    <tr>
                        <td class="w-25 text-center"><?=$usuario['nombre_usuario'];?></td>
                        <td class="w-25 text-center"><?=$usuario['tipo_usuario']; ?></td>
                        <td class="w-25 text-center"><?=$usuario['estado_usuario']; ?></td>
                        <td class="w-25 text-center">
                            <form action="<?=base_url('usuarios/editar/'.$usuario['id_usuario'])?>" >
                                <button class="btn btn-light mb-1" type="submit">Editar</button>
                            </form>
                            <form action="<?=base_url('usuarios/borrar/'.$usuario['id_usuario'])?>" method="post" onsubmit="return confirmarEliminacion('<?=$usuario['nombre_usuario']?>');">
                                <button class="btn btn-danger" type="submit">Borrar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Paginador -->
        <nav aria-label="...">
            <ul class="pagination justify-content-center">
                <!-- Botón Previous -->
                <li class="page-item <?= ($current_page == 1) ? 'disabled' : '' ?>">
                <a class="page-link" href="<?= ($current_page == 1) ? '#' : base_url('usuarios?page=' . ($current_page - 1)) ?>">Previous</a>
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
                    <a class="page-link" href="<?= base_url('usuarios?page=' . $i) ?>"><?= $i ?></a>
                </li>
                <?php endfor; ?>
                <!-- Botón Next -->
                <li class="page-item <?= ($current_page == $total_pages) ? 'disabled' : '' ?>">
                <a class="page-link" href="<?= ($current_page == $total_pages) ? '#' : base_url('usuarios?page=' . ($current_page + 1)) ?>">Next</a>
                </li>
            </ul>
        </nav>

</div>
</body>
<script>
    function confirmarEliminacion(nombreUsuario) {
        if (nombreUsuario === 'Tigger') {
            alert('No se puede eliminar este usuario.');
            return false;
        } else {
            return confirm("¿Estás seguro de que deseas eliminar este usuario?");
        }
    }
</script>
</html>