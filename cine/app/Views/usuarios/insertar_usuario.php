<?=$cabecera2?>
    <div class="row">
        <div class="col-sm-12 col-md-3 col-lg-3 col-xl-3 mt-2"></div>
        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 position-relative mt-2">
            <div class="card card3 text-bg-dark">
                    <form class="row card-body" action="<?=base_url('usuarios/guardar')?>" method="post" enctype="multipart/form-data">
                        <div class="mb-2">
                            <h4 class="text-md-center text-sm-center"><strong>BenVani Cineplex</strong></h4>
                        </div>
                        <div class="col-sm-12 col-md-5 col-lg-5">
                            <label class="form-control-sm" for="nombre_usuario"><strong>Nombre de Usuario</strong></label>
                        </div>
                        <div class="col-sm-12 col-md-7 col-lg-7">
                            <span><input class="form-control form-control form-control mb-2" type="text" placeholder="Ingresa tu Usuario" name="nombre_usuario" id="nombre_usuario" required value="<?=old('nombre_usuario')?>" /></span>
                        </div>
                        <div class="col-sm-12 col-md-5 col-lg-5">
                            <label class="form-control-sm" for="password"><strong>Password</strong></label>
                        </div>
                        <div class="col-sm-12 col-md-7 col-lg-7">
                            <span><input class="form-control form-control form-control mb-2" type="password" name="password" id="password" placeholder="Ingresa tu Password" required /></span>
                        </div>
                        <div class="col-sm-12 col-md-5 col-lg-5">
                            <label class="form-control-sm" for="confirmar_password"><strong>Confirmar Password</strong></label>
                        </div>
                        <div class="col-sm-12 col-md-7 col-lg-7">
                            <span><input class="form-control form-control form-control mb-2" name="confirmar_password" id="confirmar_password" type="password" placeholder="Confirma tu Password" required /></span>
                        </div>
                        <div class="col-sm-12 col-md-5 col-lg-5">
                            <label class="form-control-sm" for="tipo_usuario"><strong>Tipo de Usuario</strong></label>
                        </div>
                        <div class="col-sm-12 col-md-7 col-lg-7">
                            <select id="tipo_usuario" name="tipo_usuario" class="form-select mb-2">
                                <option value="Taquillero">Taquillero</option>
                                <option value="Administrador">Administrador</option>
                            </select>
                        </div>
                        <div class="col-sm-12 col-md-5 col-lg-5">
                            <label class="form-control-sm" for="estado_usuario"><strong>Estado</strong></label>
                        </div>
                        <div class="col-sm-12 col-md-7 col-lg-7">
                            <select id="estado_usuario" name="estado_usuario" class="form-select mb-2" >
                                <option value="Activo">Activo</option>
                                <option value="Inactivo">Inactivo</option>
                            </select>
                        </div>
                        <div class="col-sm-10 col-md-6 col-lg-6 col-xl-6 "></div>
                        <div class=" col-sm-12 col-md-1 col-lg-1 col-xl-1 m-2 ">
                            <button class="btn btn-danger" type="submit">Guardar</button>
                        </div>
                        <div class="col-sm-10 col-md-2 col-lg-2 col-xl-2"></div>
                        <div class=" col-sm-1 col-md-1 col-lg-1 col-xl-1 m-2 ">
                            <a href="<?=base_url('usuarios')?>" type="submit" id="btnEnviar" class="btn btn-danger ">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        <div class="col-sm-12 col-md-3 col-lg-3 col-xl-3 mt-2"></div>
        </div>
    </div>
<?=$piepagina?>