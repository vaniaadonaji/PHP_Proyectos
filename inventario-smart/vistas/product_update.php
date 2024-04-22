<div class="container is-fluid mb-6">
	<h1 class="title">Productos</h1>
	<h2 class="subtitle">Actualizar producto</h2>
</div>

<div class="container pb-6 pt-6">
	<?php
        // Incluimos el boton que tenemos para retroceder, lo tenemos en la carpeta inc
		include "./inc/btn_back.php";

        // Incluimos el archivo de main.php con las funciones
		require_once "./php/main.php";

        // Si la variable de tipo GET llamada product_id_up viene definida entonces (?) 
        // En caso de que si venga definida vamos a almacenarle el valor de la variable de tipo GET product_id_up a la variable $id
        // En caso de que no venga defindia vamos a colocarle a la variable $id el valor de 0
		$id = (isset($_GET['product_id_up'])) ? $_GET['product_id_up'] : 0;
        // Limpiamos su contenido de inyeccion sql o html
		$id=limpiar_cadena($id);

		/*== Verificando producto ==*/
        // Abrimos conexion a la base de datos
    	$check_producto=conexion();
        // Hacemos una peticion SELECT, selecciono todos los datos de la tabla producto donde producto_id sea igual al id del 
        // producto que se esta mandando desde el formulario
    	$check_producto=$check_producto->query("SELECT * FROM producto WHERE producto_id='$id'");

        // Si la consulta selecciono 1 registro entonces:
        if($check_producto->rowCount()>0){
            // Almacenaremos los campos de ese registro seleccionado en un array llamado $datos con la funcion fetch()
        	$datos=$check_producto->fetch();
	?>

	<div class="form-rest mb-6 mt-6"></div>
	<!-- Mostramos el nombre del producto que se quiere actualizar en un h2 -->
	<h2 class="title has-text-centered"><?php echo $datos['producto_nombre']; ?></h2>

	<form action="./php/producto_actualizar.php" method="POST" class="FormularioAjax" autocomplete="off" >

		<input type="hidden" name="producto_id" value="<?php echo $datos['producto_id']; ?>" required >

		<div class="columns">
		  	<div class="column">
		    	<div class="control">
					<label>Código de barra</label>
                    <!-- Mostramos el codigo de barra del producto que se quiere actualizar en un h2 -->
				  	<input class="input" type="text" name="producto_codigo" pattern="[a-zA-Z0-9- ]{1,70}" maxlength="70" required value="<?php echo $datos['producto_codigo']; ?>" >
				</div>
		  	</div>
		  	<div class="column">
		    	<div class="control">
					<label>Nombre</label>
                    <!-- Mostramos el nombre del producto que se quiere actualizar en un h2 -->
				  	<input class="input" type="text" name="producto_nombre" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,$#\-\/ ]{1,70}" maxlength="70" required value="<?php echo $datos['producto_nombre']; ?>" >
				</div>
		  	</div>
		</div>
		<div class="columns">
		  	<div class="column">
		    	<div class="control">
					<label>Precio</label>
                    <!-- Mostramos el precio del producto que se quiere actualizar en un h2 -->
				  	<input class="input" type="text" name="producto_precio" pattern="[0-9.]{1,25}" maxlength="25" required value="<?php echo $datos['producto_precio']; ?>" >
				</div>
		  	</div>
		  	<div class="column">
		    	<div class="control">
					<label>Stock</label>
                    <!-- Mostramos el stock del producto que se quiere actualizar en un h2 -->
				  	<input class="input" type="text" name="producto_stock" pattern="[0-9]{1,25}" maxlength="25" required value="<?php echo $datos['producto_stock']; ?>" >
				</div>
		  	</div>
		  	<div class="column">
				<label>Categoría</label><br>
		    	<div class="select is-rounded">
				  	<select name="producto_categoria" >
				    	<?php
                            // Abrimos conexion con la base de datos
    						$categorias=conexion();
                            // Hacemos una consulta SELECT, selecciona todos los registros de la tabla categoria
    						$categorias=$categorias->query("SELECT * FROM categoria");
                            // Si se selecciono 1 o mas registros con la consulta entonces:
    						if($categorias->rowCount()>0){
                                // Almacenamos todos esos registros en un array llamado $categorias con la funcion fetchAll()
    							$categorias=$categorias->fetchAll();
                                // Recorremos el array $categorias con un foreach a traves de una variable llamada $rows
    							foreach($categorias as $row){
                                    // Si el id de la categoria almacenado en datos es el mismo que el que estamos recorriendo con $row entonces:
    								if($datos['categoria_id']==$row['categoria_id']){
                                        // Mostrara la opcion en el select, con el nombre de la categoria que se quiere actualizar dentro, y diciendonos 
                                        // que es la categoria a la que pertenece nuestro producto actualmente 
    									echo '<option value="'.$row['categoria_id'].'" selected="" >'.$row['categoria_nombre'].' (Actual)</option>';
    								}else{
                                        // Si no es el mismo entonces mostrara el nombre de la categoria que coincida al id de esa categoria
                                        // Esto ira agregando todas las opciones en nuestro select agregandole dinamicamente todas las
                                        // categorias que tenemos registradas en nuestra base de datos
    									echo '<option value="'.$row['categoria_id'].'" >'.$row['categoria_nombre'].'</option>';
    								}
				    			}
				   			}
                            // Cerramos la conexion a la base de datos
				   			$categorias=null;
				    	?>
				  	</select>
				</div>
		  	</div>
		</div>
		<p class="has-text-centered">
            <!-- boton para actualizar los datos del producto -->
			<button type="submit" class="button is-success is-rounded">Actualizar</button>
		</p>
	</form>
	<?php 
        // Si la consulta NO selecciono ningun registro entonces:
        // significa que el producto que se quiere actualizar no existe en nuestra base de datos entonces:
		}else{
            // Incluimos el codigo html del mensaje de error
			include "./inc/error_alert.php";
		}
        // Cerramos la conexion con la base de datos
		$check_producto=null;
	?>
</div>