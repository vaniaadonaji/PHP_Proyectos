<?=$cabecera?>
<br>
    <a href="<?=base_url('crear')?>" class="btn btn-success mb-2" type="button">Crear un Libro</a>
        <br>
        <table class="table table-ligth mt-2">
            <thead class="table-ligth">
                <tr>
                    <th>#</th>
                    <th>Imagen</th>
                    <th>Nombres</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($libros as $libro):?>
                    <tr>
                        <td><?=$libro['id'];?></td>
                        <td>
                            <img class="img-thumbnail" src="<?=base_url()?>/uploads/<?=$libro['imagen'];?>" width="100" alt="">
                        </td>
                        <td><?=$libro['nombre']; ?></td>
                        <td>
                            <a href="<?=base_url('editar/'.$libro['id'])?>" class="btn btn-light m-1" type="button">Editar</a>
                            <a href="<?=base_url('borrar/'.$libro['id'])?>" class="btn btn-danger m-1" type="button">Borrar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
<?=$piepagina?>