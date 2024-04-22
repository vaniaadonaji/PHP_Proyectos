<?=$cabecera?>

    <h4>Formulario de Crear</h4>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Ingresar datos del Libro</h5>
            <p class="card-text">
                <form action="<?=site_url('/guardar')?>" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="nombre"><strong>Nombre:</strong></label>
                        <input type="text" id="nombre" value="<?=old('nombre')?>" name="nombre" class="form-control mb-2" >
                    </div>
                    <div class="form-group">
                        <label for="imagen"><strong>Imagen:</strong> </label>
                        <br>
                        <input type="file" id="imagen" name="imagen" class="form-control-file m-2" >
                    </div>
                    <button class="btn btn-info m-1 p-2" type="submit">Guardar</button>
                    <a href="<?=base_url('/');?>" class="btn btn-danger m-1 p-2">Cancelar</a>
                </form>
            </p>
        </div>
    </div>

<?=$piepagina?>