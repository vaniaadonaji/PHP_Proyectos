<div class="container is-fluid mb-6">
	<h1 class="title">Productos</h1>
	<h2 class="subtitle">Nuevo producto</h2>
</div>

<div class="container pb-6 pt-6">
	<?php
        // Añado el script donde tengo mis funciones importantes
		require_once "./php/main.php";
	?>

    <!-- En este div vamos a mostrar la respuesta que nos devuelva el archivo que va a procesar los datos a traves de AJAX
    osea el archivo ajax.js a traves de la clase form-rest -->
	<div class="form-rest mb-6 mt-6"></div>

    <!-- Ponemos en el action del formulario la ruta del archivo a la que queremos enviar los datos desde este formulario -->
	<!-- De igual forma le añadimos la clase FormularioAjax para enviar los datos por medio de Ajax  -->
    <!-- De igual forma agregamos el atributo enctype="multipart/form-data" para que podamos enviar imagenes mediante post con este formulario -->
	<form action="./php/producto_guardar.php" method="POST" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data" >
		<div class="columns">
		  	<div class="column">
		    	<div class="control">
					<label>Código de barra</label>
				  	<input class="input" type="text" name="producto_codigo" pattern="[a-zA-Z0-9- ]{1,70}" maxlength="70" required >
				</div>
		  	</div>
		  	<div class="column">
		    	<div class="control">
					<label>Nombre</label>
				  	<input class="input" type="text" name="producto_nombre" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,$#\-\/ ]{1,70}" maxlength="70" required >
				</div>
		  	</div>
		</div>
		<div class="columns">
		  	<div class="column">
		    	<div class="control">
					<label>Precio</label>
				  	<input class="input" type="text" name="producto_precio" pattern="[0-9.]{1,25}" maxlength="25" required >
				</div>
		  	</div>
		  	<div class="column">
		    	<div class="control">
					<label>Stock</label>
				  	<input class="input" type="text" name="producto_stock" pattern="[0-9]{1,25}" maxlength="25" required >
				</div>
		  	</div>
		  	<div class="column">
				<label>Categoría</label><br>
		    	<div class="select is-rounded">
				  	<select name="producto_categoria" >
                        <!-- En esta opcion el atributo selected es el que se va a seleccionar por defecto -->
                        <!-- Osea que nos dira siempre Seleccione una opcion siempre por dafault  -->
				    	<option value="" selected="" >Seleccione una opción</option>
				    	<?php
                            // Abrimos conexion a la base de datos
    						$categorias=conexion();
                            // Hacemos una consulta select, selecciona todo de la tabla categoria y almacenamos esos registros en $categorias
    						$categorias=$categorias->query("SELECT * FROM categoria");
                            // Si la consulta selecciono 1 o mas registros entonces:
    						if($categorias->rowCount()>0){
                                // Convertimos todos esos registros, o todas esas categorias que seleccionamos
                                // a un array llamado $categorias con fetchAll()
    							$categorias=$categorias->fetchAll();
                                // Por medio de un foreach recorremos el array $categorias mediante la variable $row
    							foreach($categorias as $row){
                                    // Vamos creando dinamicamente las opciones del select que se mostraran en mi HTML con el foreach
                                    // donde el valor (value) va a ser el id de la categoria y el nombre de la categoria para que se
                                    // muestre en mi opcion cada categoria que tengo
    								echo '<option value="'.$row['categoria_id'].'" >'.$row['categoria_nombre'].'</option>';
				    			}
				   			}
				   			$categorias=null;
				    	?>
				  	</select>
				</div>
		  	</div>
		</div>
		<div class="columns">
			<div class="column">
				<label>Foto o imagen del producto</label><br>
				<div class="file is-small has-name">
				  	<label class="file-label">
				    	<input class="file-input" type="file" name="producto_foto" accept=".jpg, .png, .jpeg" >
				    	<span class="file-cta">
				      		<span class="file-label">Imagen</span>
				    	</span>
				    	<span class="file-name">JPG, JPEG, PNG. (MAX 3MB)</span>
				  	</label>
				</div>
			</div>
		</div>
		<p class="has-text-centered">
			<button type="submit" class="button is-info is-rounded">Guardar</button>
		</p>
	</form>
</div>