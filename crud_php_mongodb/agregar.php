<?php include "./header.php"; ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card card1">
				<div class="card-header bg-info text-white">
                    <h2 class="mb-0">Agregar Nuevo Registro</h2>
                </div>
                <div class="card-body">
                    <a href="index.php" class="btn btn-outline-info mb-3">
                        <i class="fas fa-arrow-left"></i> Regresar
                    </a>

                    <form action="./procesos/insertar.php" method="post">
                        <div class="form-group">
                            <label for="paterno"><strong>Apellido Paterno</strong></label>
                            <input type="text" class="form-control" id="paterno" name="paterno" required>
                        </div>
						<br>
                        <div class="form-group">
                            <label for="materno"><strong>Apellido Materno</strong></label>
                            <input type="text" class="form-control" id="materno" name="materno">
                        </div>
						<br>
                        <div class="form-group">
                            <label for="nombre"><strong>Nombre</strong></label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
						<br>
                        <div class="form-group">
                            <label for="fechaNacimiento"><strong>Fecha de Nacimiento</strong></label>
                            <input type="date" class="form-control" id="fechaNacimiento" name="fechaNacimiento" required>
                        </div>
                        <br>
                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="fas fa-save"></i> Agregar Registro
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include "./scripts.php"; ?>
