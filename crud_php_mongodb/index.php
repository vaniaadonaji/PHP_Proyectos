<?php 
	session_start();
	include "./clases/Conexion.php";
	include "./clases/Crud.php";
	$crud = new Crud();
	$datos = $crud->mostrarDatos();

	$mensaje = '';
	if (isset($_SESSION['mensaje_crud'])) {
		$mensaje = $crud->mensajesCrud($_SESSION['mensaje_crud']);
		unset($_SESSION['mensaje_crud']);
	}
?>

<?php include "./header.php"; ?>

<div class="container mt-4">
	<div class="row">
		<div class="col">
			<div class="card shadow-lg">
				<div class="card-body">
					<h2 class="mb-4">CRUD con MongoDB y PHP</h2>
					<a href="./agregar.php" class="btn btn-primary mb-3">
						<i class="fas fa-user-plus me-2"></i> Agregar Nuevo Registro
					</a>
					<hr>

					<table class="table table-hover">
						<thead class="table-dark">
							<th>Apellido Paterno</th>
							<th>Apellido Materno</th>
							<th>Nombre</th>
							<th>Fecha de Nacimiento</th>
							<th>Editar</th>
							<th>Eliminar</th>
						</thead>
						<tbody>
							<?php foreach ($datos as $item): ?>
								<tr>
									<td><?php echo $item->paterno; ?></td>
									<td><?php echo $item->materno; ?></td>
									<td><?php echo $item->nombre; ?></td>
									<td><?php echo $item->fecha_nacimiento; ?></td>
									<td class="text-center">
										<form action="./actualizar.php" method="POST">
											<input type="hidden" value="<?php echo $item->_id ?>" name="id">
											<button type="submit" class="btn btn-outline-info">
												<i class="fas fa-user-edit"></i>
											</button>
										</form>
									</td>
									<td class="text-center">
										<form action="./eliminar.php" method="POST">
											<input type="hidden" value="<?php echo $item->_id ?>" name="id">
											<button type="submit" class="btn btn-outline-danger">
												<i class="fas fa-user-times"></i>
											</button>
										</form>
									</td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<?php include "./scripts.php"; ?>

<script>
	let mensaje = "<?php echo $mensaje; ?>";
	console.log(mensaje);
</script>
