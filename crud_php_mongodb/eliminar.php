<?php
    include "./clases/Conexion.php";
    include "./clases/Crud.php";
    include "./header.php"; 

    $crud = new Crud();
    $id = $_POST['id'];
    $datos = $crud->obtenerDocumento($id);
?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card1">
                <div class="card-header bg-info text-white">
                    <h2 class="mb-0">Eliminar Registro</h2>
                </div>
                <div class="card-body">
                    <a href="index.php" class="btn btn-outline-info mb-3">
                        <i class="fa-solid fa-angles-left"></i> Regresar
                    </a>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Apellido Paterno</th>
                                <th>Apellido Materno</th>
                                <th>Nombre</th>
                                <th>Fecha de Nacimiento</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?php echo $datos->paterno; ?></td>
                                <td><?php echo $datos->materno; ?></td>
                                <td><?php echo $datos->nombre; ?></td>
                                <td><?php echo $datos->fecha_nacimiento; ?></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="alert alert-danger" role="alert">
                        <p>¿Estás seguro de eliminar este registro?</p>
                        <p>Una vez eliminado no podrá ser recuperado.</p>
                    </div>
                    <form action="./procesos/eliminar.php" method="POST">
                        <input type="hidden" name="id" value="<?php echo $datos->_id; ?>">
                        <button type="submit" class="btn btn-danger">
                            <i class="fa-solid fa-user-xmark"></i> Eliminar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include "./scripts.php"; ?>
