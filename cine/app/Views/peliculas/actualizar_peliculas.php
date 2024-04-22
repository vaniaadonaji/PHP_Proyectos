<?=$cabecera2?>
    <div class="row">
        <div class="col-sm-12 col-md-3 col-lg-3 col-xl-3 mt-2"></div>
        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 position-relative mt-2">
            <div class="card card3 text-bg-dark mb-5">
                <form class="row card-body" action="<?=base_url('peliculas/actualizar')?>" method="post" enctype="multipart/form-data">
                    <div>
                        <input type="hidden" name="id" value="<?=$pelicula['id_pelicula']?>">
                    </div>
                        <div class="mb-2">
                            <h4 class="text-md-center text-sm-center"><strong>BenVani Cineplex</strong></h4>
                        </div>
                        <div class="col-sm-12 col-md-5 col-lg-5">
                            <label class="form-control-sm" for="titulo_pelicula" ><strong>Título de la película</strong></label>
                        </div>
                        <div class="col-sm-12 col-md-7 col-lg-7">
                            <span><input class="form-control form-control form-control mb-2" type="text" placeholder="Ingresa el título" value="<?=$pelicula['titulo_pelicula']?>" name="titulo_pelicula" id="titulo_pelicula" required/></span>
                        </div>
                        <div class="col-sm-12 col-md-5 col-lg-5">
                            <label class="form-control-sm" for="duracion"><strong>Duración</strong></label>
                        </div>
                        <div class="col-sm-12 col-md-7 col-lg-7">
                            <span><input class="form-control form-control form-control mb-2" type="number" value="<?=$pelicula['duracion']?>" name="duracion" id="duracion" placeholder="Ingresa la duración de la película" required/></span>
                        </div>
                        <div class="col-sm-12 col-md-5 col-lg-5">
                            <label class="form-control-sm" for="sinopsis"><strong>Sinopsis</strong></label>
                        </div>
                        <div class="col-sm-12 col-md-7 col-lg-7">
                            <span><input class="form-control form-control form-control mb-2" name="sinopsis" value="<?=$pelicula['sinopsis']?>" id="sinopsis" type="text" placeholder="Ingresa la sinopsis de la película" required/></span>
                        </div>
                        <div class="col-sm-12 col-md-5 col-lg-5">
                            <label class="form-control-sm" for="genero"><strong>Género</strong></label>
                        </div>
                        <div class="col-sm-12 col-md-7 col-lg-7">
                            <select id="genero" name="genero" class="form-select mb-2">
                                <option value="Terror" <?php if($pelicula['genero'] == 'Terror') echo 'selected'; ?>>Terror</option>
                                <option value="Suspenso"<?php if($pelicula['genero'] == 'Suspenso') echo 'selected'; ?>>Suspenso</option>
                                <option value="Comedia"<?php if($pelicula['genero'] == 'Comedia') echo 'selected'; ?>>Comedia</option>
                                <option value="Accion"<?php if($pelicula['genero'] == 'Acción') echo 'selected'; ?>>Acción</option>
                                <option value="Drama"<?php if($pelicula['genero'] == 'Drama') echo 'selected'; ?>>Drama</option>
                                <option value="Guerra"<?php if($pelicula['genero'] == 'Guerra') echo 'selected'; ?>>Guerra</option>
                                <option value="Musical"<?php if($pelicula['genero'] == 'Musical') echo 'selected'; ?>>Musical</option>
                                <option value="Ciencia ficcion"<?php if($pelicula['genero'] == 'Ciencia ficcion') echo 'selected'; ?>>Ciencia ficción</option>
                                <option value="Aventura"<?php if($pelicula['genero'] == 'Aventura') echo 'selected'; ?>>Aventura</option>
                                <option value="Romance"<?php if($pelicula['genero'] == 'Romance') echo 'selected'; ?>>Romance</option>
                                <option value="Animacion"<?php if($pelicula['genero'] == 'Animacion') echo 'selected'; ?>>Animacion</option>
                                <option value="Crimen"<?php if($pelicula['genero'] == 'Crimen') echo 'selected'; ?>>Crimen</option>
                                <option value="Documental"<?php if($pelicula['genero'] == 'Documental') echo 'selected'; ?>>Documental</option>
                            </select>
                        </div>
                        <div class="col-sm-12 col-md-5 col-lg-5">
                            <label for="imagen"><strong>Imagen:</strong> </label>
                        </div>
                        <div class="col-sm-12 col-md-7 col-lg-7">
                            <img class="img-thumbnail mx-auto d-block" src="<?=base_url()?>/uploads/<?=$pelicula['imagen'];?>" alt="imagen de la película">
                            <input type="file" id="imagen" name="imagen" class="form-control-file my-2">
                        </div>
                        <div class="col-sm-12 col-md-5 col-lg-5">
                            <label class="form-control-sm" for="precio"><strong>Precio de la película</strong></label>
                        </div>
                        <div class="col-sm-12 col-md-7 col-lg-7">
                            <span><input class="form-control form-control form-control mb-2" step="any" value="<?=$pelicula['precio']?>" name="precio" id="precio" type="number" placeholder="Ingresa el precio de la película" required /></span>
                        </div>
                        <div class="col-sm-12 col-md-5 col-lg-5">
                            <label class="form-control-sm" for="estado_pelicula"><strong>Estado</strong></label>
                        </div>
                        <div class="col-sm-12 col-md-7 col-lg-7">
                            <select id="estado_pelicula" name="estado_pelicula" class="form-select mb-2" >
                                <option value="Activa" <?php if($pelicula['estado_pelicula'] == 'Activa') echo 'selected'; ?>>Activa</option>
                                <option value="Inactiva" <?php if($pelicula['estado_pelicula'] == 'Inactiva') echo 'selected'; ?>> Inactiva</option>
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