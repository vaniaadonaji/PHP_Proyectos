<?=$cabecera?>
    <h4>Formulario de Crear</h4>


    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Ingresar datos del Libro</h5>
            <p class="card-text">
                <form action="<?=site_url('/actualizar')?>" method="post" enctype="multipart/form-data">
                    <div>
                        <input type="hidden" name="id" value="<?=$libro['id']?>">
                    </div>
                    <div class="form-group">
                        <label for="nombre"><strong>Nombre:</strong></label>
                        <input type="text" id="nombre" value="<?=$libro['nombre']?>" name="nombre" class="form-control mb-2" required>
                    </div>
                    <div class="form-group">
                        <label for="imagen"><strong>Imagen:</strong> </label>
                        <br>
                        <img class="img-thumbnail" src="<?=base_url()?>/uploads/<?=$libro['imagen'];?>" width="100" alt="">
                        <br>
                        <input type="file" id="imagen"  name="imagen" class="form-control-file m-2">
                    </div>
                    <button class="btn btn-info m-1 p-2" type="submit">Actuaizar</button>
                    <a href="<?=base_url('/');?>" class="btn btn-danger m-1 p-2">Cancelar</a>
                </form>
            </p>
        </div>
    </div>
<?=$piepagina?>