<div class="container is-fluid mb-6">
	<h1 class="title">Categorías</h1>
	<h2 class="subtitle">Actualizar categoría</h2>
</div>

<div class="container pb-6 pt-6">
	<?php
        // Incluimos el boton que tenemos para retroceder de la carpeta inc
		include "./inc/btn_back.php";

        // Incluimos el archivo de main.php con las funciones
		require_once "./php/main.php";

        // Si la variable de tipo GET llamada category_id_up viene definida entonces (?) 
        // En caso de que si venga definida vamos a almacenarle el valor de la variable de tipo GET category_id_up a la variable $id
        // En caso de que no venga defindia vamos a colocarle a la variable $id el valor de 0
		$id = (isset($_GET['category_id_up'])) ? $_GET['category_id_up'] : 0;
        // Limpiamos su contenido de inyeccion sql o html
		$id=limpiar_cadena($id);

		/*== Verificando categoria ==*/
        // Hacemos la conexion a la base de datos almacenada en $check_categoria
    	$check_categoria=conexion();
        // Hacemos una consulta select de todo en la tabla categoria donde categoria_id coincida con el id que tenemos almacenado en $id
    	$check_categoria=$check_categoria->query("SELECT * FROM categoria WHERE categoria_id='$id'");

        // Si el select anterior selecciono algun registro, eso quiere decir que el id almacenado en $id si existe entonces
        if($check_categoria->rowCount()>0){
            // convertimos los datos que se seleccionaron en un array con fetch y almacenamos ese array en $datos, 
            // solo son datos de UN SOLO REGISTRO, por eso ocupamos fetch y no fetchAll
        	$datos=$check_categoria->fetch();
	?>

    <!-- Aqui vamos a obtener la respuesta del formulario via ajax de abajo, por eso el div vacio tiene la clase form-rest con
    la que trabajamos en el archivo llamado ajax.js -->
	<div class="form-rest mb-6 mt-6"></div>

    <!-- Aqui en este formulario tenemos la clase FormularioAjax para enviar los datos por via ajax usando el archivo ajax.php -->
	<!-- igual tenemos en action (a que archivo se van a mandar los datos) en este caso a categoria_actualizar.php de la carpeta php -->
	<form action="./php/categoria_actualizar.php" method="POST" class="FormularioAjax" autocomplete="off" >

        <!-- A traves de este input vamos a mandar el id al archivo llamado categoria_actulizar.php -->
		<input type="hidden" name="categoria_id" value="<?php echo $datos['categoria_id']; ?>" required >

		<div class="columns">
		  	<div class="column">
		    	<div class="control">
					<label>Nombre</label>
                    <!-- Aqui se mostrara lo que hay en el array que creamos arriba con la clave categoria_nombre ya que es array asociativo -->
				  	<input class="input" type="text" name="categoria_nombre" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{4,50}" maxlength="50" 
                    required value="<?php echo $datos['categoria_nombre']; ?>" >
				</div>
		  	</div>
		  	<div class="column">
		    	<div class="control">
					<label>Ubicación</label>
                    <!-- Aqui se mostrara lo que hay en el array que creamos arriba con la clave categoria_ubicacion ya que es array asociativo -->
				  	<input class="input" type="text" name="categoria_ubicacion" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{5,150}" maxlength="150" 
                    value="<?php echo $datos['categoria_ubicacion']; ?>" >
				</div>
		  	</div>
		</div>
		<p class="has-text-centered">
			<button type="submit" class="button is-success is-rounded">Actualizar</button>
		</p>
	</form>
	<?php 
        // Si el select anterior NO selecciono algun registro, eso quiere decir que el id almacenado en $id NO existe entonces:
		}else{
            // Incluimos el codigo html del mensaje de error
			include "./inc/error_alert.php";
		}
        // Cerramos la conexion a la base de datos
		$check_categoria=null;
	?>
</div>