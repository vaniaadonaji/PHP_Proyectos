<?php 
	include "./clases/Conexion.php";
	include "./clases/Crud.php";

	$crud = new Crud();
	$id = $_POST['id'];
	$datos = $crud->obtenerDocumento($id);
	$idMongo = $datos->_id;
?>

<?php include "./header.php"; ?>

<div class="container mt-4">
	<div class="row justify-content-center">
		<div class="col-md-6">
			<div class="card card1">
				<div class="card-header bg-info text-white">
                    <h2 class="mb-0">Actualizar Registro</h2>
                </div>
				<div class="card-body">
					<a href="index.php" class="btn btn-outline-info mb-3">
						<i class="fas fa-arrow-left"></i> Regresar
					</a>

					<form action="./procesos/actualizar.php" method="POST">
						<input type="hidden" value="<?php echo $idMongo ?>" name="id">
						<div class="form-group">
							<label for="paterno"><strong>Apellido Paterno</strong></label>
							<input type="text" class="form-control" id="paterno" name="paterno" value="<?php echo $datos->paterno ?>">
						</div>
						<br>
						<div class="form-group">
							<label for="materno"><strong>Apellido Materno</strong></label>
							<input type="text" class="form-control" id="materno" name="materno" value="<?php echo $datos->materno ?>">
						</div>
						<br>
						<div class="form-group">
							<label for="nombre"><strong>Nombre</strong></label>
							<input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $datos->nombre ?>">
						</div>
						<br>
						<div class="form-group">
							<label for="fechaNacimiento"><strong>Fecha de Nacimiento</strong></label>
							<input type="date" class="form-control" id="fechaNacimiento" name="fechaNacimiento" value="<?php echo $datos->fecha_nacimiento ?>">
						</div>
						<br>
						<button type="submit" class="btn btn-info">
							<i class="fas fa-save"></i> Actualizar
						</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<?php include "./scripts.php"; ?>
