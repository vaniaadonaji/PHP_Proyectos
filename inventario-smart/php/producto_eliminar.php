<?php
	/*== Almacenando datos ==*/
    // Limpiamos de inyeccion SQL y almacenamos lo que contiene la variable de tipo GET llamada product_id_del en mi variable $producty_id_del
    $product_id_del=limpiar_cadena($_GET['product_id_del']);

    /*== Verificando producto ==*/
    // Abrimos la conexion a la base de datos y la almacenamos en la variable  $check_producto
    $check_producto=conexion();
    // Despues hacemos un select de todos los registros de la tabla producto donde producto_id sea igual al producto que estamos
    // pasandole por medio de la variable get y esa peticion la almacenamos en la variable $check_producto
    $check_producto=$check_producto->query("SELECT * FROM producto WHERE producto_id='$product_id_del'");

    // Este if es para saber si existe el producto que se quizo seleccionar anteriormente en la base de datos
    // Si los datos seleccionados en la consulta es igual a 1 entonces significa que si existe, entonces:
    if($check_producto->rowCount()==1){

        // Convertimos los campos del registro que se selecciono en un array llamado $datos con la funcion fetch() 
    	$datos=$check_producto->fetch();

        // Abrimos conexion a la base de datos
    	$eliminar_producto=conexion();
        // Preparamos una peticion DELETE: Elimina de la tabla producto donde producto_id de la base de datos sea igual 
        // al id del producto que se quiere eliminar desde el formulario
    	$eliminar_producto=$eliminar_producto->prepare("DELETE FROM producto WHERE producto_id=:id");

        // Ejecutamos la consulta a la base de datos delete con execute, mandandole el marcador :id con el valor de la 
        // variable $product_id_del
    	$eliminar_producto->execute([":id"=>$product_id_del]);

        // Si se elimino el producto de la base de datos entonces:
    	if($eliminar_producto->rowCount()==1){

    		if(is_file("./img/producto/".$datos['producto_foto'])){
    			chmod("./img/producto/".$datos['producto_foto'], 0777);
				unlink("./img/producto/".$datos['producto_foto']);
    		}

	        echo '
	            <div class="notification is-info is-light">
	                <strong>¡PRODUCTO ELIMINADO!</strong><br>
	                Los datos del producto se eliminaron con exito
	            </div>
	        ';
	    }else{
            // Si no se elimino nungun dato entonces:
	        echo '
	            <div class="notification is-danger is-light">
	                <strong>¡Ocurrio un error inesperado!</strong><br>
	                No se pudo eliminar el producto, por favor intente nuevamente
	            </div>
	        ';
	    }
        // Cerramos la conexion a la base de datos
	    $eliminar_producto=null;
    }else{
        // En caso de que la categoria que se quiere eliminar no existe en la base de datos entonces:
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El PRODUCTO que intenta eliminar no existe
            </div>
        ';
    }
    // Cerramos la conexion a la base de datos
    $check_producto=null;