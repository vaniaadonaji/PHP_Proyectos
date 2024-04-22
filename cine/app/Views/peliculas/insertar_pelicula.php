<?=$cabecera2?>
    <div class="row">
        <div class="col-sm-12 col-md-3 col-lg-3 col-xl-3 mt-2"></div>
        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 position-relative mt-2">
            <div class="card card3 text-bg-dark">
                    <form class="row card-body" action="<?=base_url('peliculas/guardar')?>" method="post" enctype="multipart/form-data">
                        <div class="mb-2">
                            <h4 class="text-md-center text-sm-center"><strong>BenVani Cineplex</strong></h4>
                        </div>
                        <div class="col-sm-12 col-md-5 col-lg-5">
                            <label class="form-control-sm" for="titulo_pelicula"><strong>Título de la película</strong></label>
                        </div>
                        <div class="col-sm-12 col-md-7 col-lg-7">
                            <span><input class="form-control form-control form-control mb-2" type="text" placeholder="Ingresa el título" name="titulo_pelicula" id="titulo_pelicula" required value="<?=old('titulo_pelicula')?>" /></span>
                        </div>
                        <div class="col-sm-12 col-md-5 col-lg-5">
                            <label class="form-control-sm" for="duracion"><strong>Duración</strong></label>
                        </div>
                        <div class="col-sm-12 col-md-7 col-lg-7">
                            <span><input class="form-control form-control form-control mb-2" type="number" name="duracion" id="duracion" placeholder="Ingresa la duración de la película" required value="<?=old('duracion')?>" /></span>
                        </div>
                        <div class="col-sm-12 col-md-5 col-lg-5">
                            <label class="form-control-sm" for="sinopsis"><strong>Sinopsis</strong></label>
                        </div>
                        <div class="col-sm-12 col-md-7 col-lg-7">
                            <span><input class="form-control form-control form-control mb-2" name="sinopsis" id="sinopsis" type="text" placeholder="Ingresa la sinopsis de la película" required value="<?=old('sinopsis')?>"/></span>
                        </div>
                        <div class="col-sm-12 col-md-5 col-lg-5">
                            <label class="form-control-sm" for="genero"><strong>Género</strong></label>
                        </div>
                        <div class="col-sm-12 col-md-7 col-lg-7">
                            <select id="genero" name="genero" class="form-select mb-2">
                                <option value="Terror">Terror</option>
                                <option value="Suspenso">Suspenso</option>
                                <option value="Comedia">Comedia</option>
                                <option value="Accion">Acción</option>
                                <option value="Drama">Drama</option>
                                <option value="Guerra">Guerra</option>
                                <option value="Musical">Musical</option>
                                <option value="Ciencia ficcion">Ciencia ficción</option>
                                <option value="Aventura">Aventura</option>
                                <option value="Romance">Romance</option>
                                <option value="Animacion">Animacion</option>
                                <option value="Crimen">Crimen</option>
                                <option value="Documental">Documental</option>
                            </select>
                        </div>
                        <div class="col-sm-12 col-md-5 col-lg-5">
                            <label class="form-control-sm" for="imagen"><strong>Imágen</strong></label>
                        </div>
                        <div class="col-sm-12 col-md-7 col-lg-7">
                            <span><input class="form-control form-control form-control mb-2" name="imagen" id="imagen" type="file" placeholder="Ingresa la imágen de la película" required /></span>
                        </div>
                        <div class="col-sm-12 col-md-5 col-lg-5">
                            <label class="form-control-sm" for="precio"><strong>Precio de la película</strong></label>
                        </div>
                        <div class="col-sm-12 col-md-7 col-lg-7">
                            <span><input class="form-control form-control form-control mb-2" step="any" name="precio" id="precio" type="number" placeholder="Ingresa el precio de la película" required value="<?=old('precio')?>"/></span>
                        </div>
                        <div class="col-sm-12 col-md-5 col-lg-5">
                            <label class="form-control-sm" for="estado_pelicula"><strong>Estado</strong></label>
                        </div>
                        <div class="col-sm-12 col-md-7 col-lg-7">
                            <select id="estado_pelicula" name="estado_pelicula" class="form-select mb-2" >
                                <option value="Activa">Activa</option>
                                <option value="Inactiva">Inactiva</option>
                            </select>
                        </div>
                        <div class="col-sm-10 col-md-6 col-lg-6 col-xl-6 "></div>
                        <div class=" col-sm-12 col-md-1 col-lg-1 col-xl-1 m-2 ">
                            <button class="btn btn-danger" type="submit">Guardar</button>
                        </div>
                        <div class="col-sm-10 col-md-2 col-lg-2 col-xl-2"></div>
                        <div class=" col-sm-1 col-md-1 col-lg-1 col-xl-1 m-2 ">
                            <a href="<?=base_url('peliculas')?>" type="submit" id="btnEnviar" class="btn btn-danger ">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        <div class="col-sm-12 col-md-3 col-lg-3 col-xl-3 mt-2"></div>
        </div>
    </div>
<?=$piepagina?>