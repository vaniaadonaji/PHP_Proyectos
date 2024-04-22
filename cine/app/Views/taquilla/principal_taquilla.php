<?=$cabecera?>

<div class="row justify-content-center mt-3">
    <div class="col-md-4 text-center">
        <select id="pelicula" style="border: 2px solid #DA4E4E;" class="form-select mb-3">
            <option value="">Seleccione una película</option>
            <?php foreach ($peliculas_activas as $pelicula): ?>
                <option value="<?= $pelicula['id_pelicula'] ?>"><?= $pelicula['titulo_pelicula'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>
</div>

<div class="row justify-content-center mt-3" id="tarjetasPeliculas">
    <?php foreach ($peliculas_activas as $pelicula):?>
        <div class="col-12 col-md-6 col-lg-4 mb-4 pelicula-card" data-pelicula-id="<?=$pelicula['id_pelicula']?>">
            <div class="card h-100 tarjeta">
                <img src="<?=base_url()?>/uploads/<?=$pelicula['imagen'];?>" class="card-img-top" style="object-fit: contain; height: 300px;" alt="...">
                <div class="card-body">
                    <h5 class="card-title"><?=$pelicula['titulo_pelicula'];?></h5>
                    <p class="card-text"><?=$pelicula['sinopsis'];?></p>
                    <p class="card-text"><small class="text-muted"><?=$pelicula['genero']; ?></small></p>
                    <p class="card-text">$ <?=$pelicula['precio']; ?></p>
                    <div class="text-center">
                        <form action="<?=base_url('taquilla/comprar/'.$pelicula['id_pelicula'])?>" >
                            <button class="btn btn-outline-danger mb-1" type="submit">Comprar Boletos</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?=$piepagina?>

<script>
    document.getElementById('pelicula').addEventListener('change', function() {
        var seleccion = this.value;

        fetch('<?php echo base_url('taquilla/filtrarPeliculas/'); ?>' + seleccion)
            .then(response => response.json())
            .then(data => {
                // Ocultar todas las tarjetas de películas
                document.querySelectorAll('.pelicula-card').forEach(tarjeta => {
                    tarjeta.style.display = 'none';
                });

                // Mostrar solo la tarjeta de la película seleccionada
                var tarjetaSeleccionada = document.querySelector('.pelicula-card[data-pelicula-id="' + data.id_pelicula + '"]');
                if (tarjetaSeleccionada) {
                    tarjetaSeleccionada.style.display = 'block';
                }
            })
            .catch(error => console.error('Error:', error));
    });
</script>
