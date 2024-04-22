<div class="container is-fluid mb-6">
	<h1 class="title">Productos</h1>
	<h2 class="subtitle">Actualizar imagen de producto</h2>
</div>

<div class="container pb-6 pt-6">
	<?php
        // Incluimos el boton que tenemos para retroceder de la carpeta inc
		include "./inc/btn_back.php";

        // Incluimos el archivo de main.php con las funciones
		require_once "./php/main.php";

        // Si la variable de tipo GET llamada product_id_up viene definida entonces (?) 
        // En caso de que si venga definida vamos a almacenarle el valor de la variable de tipo GET product_id_up a la variable $id
        // En caso de que no venga defindia vamos a colocarle a la variable $id el valor de 0
		$id = (isset($_GET['product_id_up'])) ? $_GET['product_id_up'] : 0;

		/*== Verificando producto ==*/
        // Hacemos la conexion a la base de datos almacenada en $check_categoria
    	$check_producto=conexion();
        // Hacemos una consulta select de todo en la tabla producto donde producto_id coincida con el id que tenemos almacenado en $id
    	$check_producto=$check_producto->query("SELECT * FROM producto WHERE producto_id='$id'");

        // Si el select anterior selecciono algun registro, eso quiere decir que el id almacenado en $id si existe entonces
        if($check_producto->rowCount()>0){
            // convertimos los datos que se seleccionaron en un array con fetch y almacenamos ese array en $datos, 
            // solo son datos de UN SOLO REGISTRO, por eso ocupamos fetch y no fetchAll
        	$datos=$check_producto->fetch();
	?>

    <!-- Aqui vamos a obtener la respuesta del formulario via ajax de abajo, por eso el div vacio tiene la clase form-rest con
    la que trabajamos en el archivo llamado ajax.js -->
	<div class="form-rest mb-6 mt-6"></div>

	<div class="columns">
		<div class="column is-two-fifths">
			<?php 
                // Si existe un archivo de imagen asociado al producto en la ruta especificada entonces:
                if(is_file("./img/producto/".$datos['producto_foto'])){ 
                    // Se mostrara la imagen del producto con el codigo HTML
            ?>
			<figure class="image mb-6">
                <!-- Se mostrara la imagen del producto -->
			  	<img src="./img/producto/<?php echo $datos['producto_foto']; ?>">
			</figure>
            <!-- Se crea un pequeño formulario para eliminar la foto con ayuda del archivo producto_img_eliminar.php -->
			<form class="FormularioAjax" action="./php/producto_img_eliminar.php" method="POST" autocomplete="off" >

				<input type="hidden" name="img_del_id" value="<?php echo $datos['producto_id']; ?>">

				<p class="has-text-centered">
                    <!-- Boton para eliminar la imagen del producto -->
					<button type="submit" class="button is-danger is-rounded">Eliminar imagen</button>
				</p>
			</form>
			<?php 
                // Si NO existe un archivo de imagen asociado al producto en la ruta especificada entonces:
                }else{
             ?>
			<figure class="image mb-6">
			  	<img src="./img/producto.png">
			</figure>
			<?php 
                } 
            ?>
		</div>
		<div class="column">
            <!-- Se crea un form para actualizar la imagen del producto con ayuda del archivo producto_img_actualizar.php -->
			<form class="mb-6 has-text-centered FormularioAjax" action="./php/producto_img_actualizar.php" method="POST" enctype="multipart/form-data" autocomplete="off" >
                
                <!-- Aqui se mostrara el nombre del producto -->
				<h4 class="title is-4 mb-6"><?php echo $datos['producto_nombre']; ?></h4>
				
				<label>Foto o imagen del producto</label><br>

				<input type="hidden" name="img_up_id" value="<?php echo $datos['producto_id']; ?>">

				<div class="file has-name is-horizontal is-justify-content-center mb-6">
				  	<label class="file-label">
				    	<input class="file-input" type="file" name="producto_foto" accept=".jpg, .png, .jpeg" >
				    	<span class="file-cta">
				      		<span class="file-label">Imagen</span>
				    	</span>
				    	<span class="file-name">JPG, JPEG, PNG. (MAX 3MB)</span>
				  	</label>
				</div>
				<p class="has-text-centered">
                    <!-- Boton para actualizar la imagen del producto -->
					<button type="submit" class="button is-success is-rounded">Actualizar</button>
				</p>
			</form>
		</div>
	</div>
	<?php 
        // Si el select anterior NO selecciono algun registro, eso quiere decir que el id almacenado en $id NO existe 
        // en nuestra base de datos entonces
		}else{
            // Mostraremos un alert de error
			include "./inc/error_alert.php";
		}
        // Cerramos la conexion con la base de datos
		$check_producto=null;
	?>
</div>