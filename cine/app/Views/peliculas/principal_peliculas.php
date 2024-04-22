
<?=$cabecera?>
<br>
<div class="my-2 row">
<?php
// Obtener los valores de los filtros
$filtro_genero = isset($_GET['genero']) ? $_GET['genero'] : '';
$filtro_estado_pelicula = isset($_GET['estado_pelicula']) ? $_GET['estado_pelicula'] : '';
$filtro_titulo_pelicula = isset($_GET['u']) ? $_GET['u'] : '';
?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8">
            <form class="row" role="search">
                <div class="col-12 col-sm-6 col-md-4 mb-2">
                    <select id="genero" name="genero" class="form-select">
                        <option value="">Género de la película</option>
                        <option value="Terror" <?= ($filtro_genero == 'Terror') ? 'selected' : '' ?>>Terror</option>
                        <option value="Suspenso" <?= ($filtro_genero == 'Suspenso') ? 'selected' : '' ?>>Suspenso</option>
                        <option value="Comedia" <?= ($filtro_genero == 'Comedia') ? 'selected' : '' ?>>Comedia</option>
                        <option value="Accion" <?= ($filtro_genero == 'Accion') ? 'selected' : '' ?>>Acción</option>
                        <option value="Drama" <?= ($filtro_genero == 'Drama') ? 'selected' : '' ?>>Drama</option>
                        <option value="Guerra" <?= ($filtro_genero == 'Guerra') ? 'selected' : '' ?>>Guerra</option>
                        <option value="Musical" <?= ($filtro_genero == 'Musical') ? 'selected' : '' ?>>Musical</option>
                        <option value="Ciencia ficcion" <?= ($filtro_genero == 'Ciencia ficcion') ? 'selected' : '' ?>>Ciencia ficción</option>
                        <option value="Aventura" <?= ($filtro_genero == 'Aventura') ? 'selected' : '' ?>>Aventura</option>
                        <option value="Romance" <?= ($filtro_genero == 'Romance') ? 'selected' : '' ?>>Romance</option>
                        <option value="Animacion" <?= ($filtro_genero == 'Animacion') ? 'selected' : '' ?>>Animacion</option>
                        <option value="Crimen" <?= ($filtro_genero == 'Crimen') ? 'selected' : '' ?>>Crimen</option>
                        <option value="Documental" <?= ($filtro_genero == 'Documental') ? 'selected' : '' ?>>Documental</option>
                    </select>
                </div>
                <div class="col-12 col-sm-6 col-md-4 mb-2">
                    <select id="estado_pelicula" name="estado_pelicula" class="form-select">
                        <option value="">Estado de la Película</option>
                        <option value="Activa" <?= ($filtro_estado_pelicula == 'Activa') ? 'selected' : '' ?>>Activa</option>
                        <option value="Inactiva" <?= ($filtro_estado_pelicula == 'Inactiva') ? 'selected' : '' ?>>Inactiva</option>
                    </select>
                </div>
                <div class="col-12 col-md-4 mb-2">
                    <div class="input-group">
                        <input name="u" class="form-control" type="search" placeholder="Buscar título de la película..." aria-label="Buscar" value="<?= $filtro_titulo_pelicula ?>">
                        <button class="btn btn-danger" type="submit" id="btnBuscar">Buscar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-12 text-center">
            <a href="<?=base_url('peliculas/crear')?>" class="btn btn-danger px-2" type="button">Agregar una película</a>
        </div>
    </div>
    <div class="row justify-content-center mt-3">
        <?php foreach ($peliculas as $pelicula):?>
            
            <div class="col-12 col-md-6 col-lg-4 mb-4">
                <div class="card h-100 tarjeta">
                    <img src="<?=base_url()?>/uploads/<?=$pelicula['imagen'];?>" class="card-img-top" style="object-fit: contain; height: 300px;" alt="...">
                    <div class="card-body">
                        <h5 class="card-title"><?=$pelicula['titulo_pelicula'];?></h5>
                        <p class="card-text"><?=$pelicula['sinopsis'];?></p>
                        <p class="card-text"><small class="text-muted"><?=$pelicula['genero']; ?></small></p>
                        <p class="card-text">$ <?=$pelicula['precio']; ?></p>
                        <div class="text-center">
                            <form action="<?=base_url('peliculas/editar/'.$pelicula['id_pelicula'])?>" >
                                <button class="btn btn-outline-danger mb-1" type="submit">Editar</button>
                            </form>
                            <form action="<?=base_url('peliculas/borrar/'.$pelicula['id_pelicula'])?>" method="post" onsubmit="return confirmarEliminacionP();">
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
                <a class="page-link" href="<?= ($current_page == 1) ? '#' : base_url('peliculas?page=' . ($current_page - 1)) ?>">Previous</a>
            </li>
            <!-- Botones de páginas -->
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?= ($i == $current_page) ? 'active' : '' ?>">
                    <a class="page-link" href="<?= base_url('peliculas?page=' . $i) ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>
            <!-- Botón Next -->
            <li class="page-item <?= ($current_page == $total_pages) ? 'disabled' : '' ?>">
                <a class="page-link" href="<?= ($current_page == $total_pages) ? '#' : base_url('peliculas?page=' . ($current_page + 1)) ?>">Next</a>
            </li>
        </ul>
    </nav>
</div>
<script>
    function confirmarEliminacionP() {
        if (confirm("¿Estás seguro de que deseas eliminar esta Película?")) {
            return true;
        } else {
            return false;
        }
    }
</script>