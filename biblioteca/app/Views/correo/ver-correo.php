<?=$cabecera?>
    <br>
    <div class="row">
            <div class="col-md-6">
                <!-- Formulario para enviar correo -->
                <h2>Enviar Correo</h2>
                <form action="<?= base_url('enviar-correo');?>" method="post">
                    <div class="mb-3">
                        <label for="destinatario" class="form-label">Destinatario:</label>
                        <input type="email" class="form-control" id="destinatario" name="destinatario" required>
                    </div>
                    <div class="mb-3">
                        <label for="asunto" class="form-label">Asunto:</label>
                        <input type="text" class="form-control" id="asunto" name="asunto" required>
                    </div>
                    <div class="mb-3">
                        <label for="mensaje" class="form-label">Mensaje:</label>
                        <textarea class="form-control" id="mensaje" name="mensaje" rows="4" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Enviar Correo</button>
                </form>
            </div>
            <div class="col-md-6">
                <!-- Botón para descargar archivo -->
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title">Descargar Archivo</h2>
                        <br>
                        <a href="<?= base_url('descargar');?>" class="btn btn-primary">Descargar Manual CodeIgniter</a>
                    </div>
                </div>
            </div>
        </div>
<?=$piepagina?>
