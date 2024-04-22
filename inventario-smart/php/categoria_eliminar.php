<?php
	/*== Almacenando datos ==*/
    // Limpiamos de inyeccion SQL y almacenamos lo que contiene la variable de tipo GET llamada category_id_del en mi variable $category_id_del
    $category_id_del=limpiar_cadena($_GET['category_id_del']);

    /*== Verificando usuario ==*/
    // Abrimos la conexion a la base de datos y la almacenamos en la variable  $check_categoria
    $check_categoria=conexion();
    // Despues hacemos un select de categoria_id de la tabla categoria donde categoria_id sea igual a la categoria que estamos pasandole por medio de la variable get 
    // y esa peticion la almacenamos en la variable $check_categoria
    $check_categoria=$check_categoria->query("SELECT categoria_id FROM categoria WHERE categoria_id='$category_id_del'");
    
    // Este if es para saber si existe la categoria que se quizo seleccionar anteriormente en la base de datos
    // Si los datos seleccionados en la consulta es igual a 1 entonces significa que si existe, entonces:
    if($check_categoria->rowCount()==1){

        # Verificamos que esta categoria que queremos eliminar no tenga productos asociados, ya que si tiene productos
        # asodiados entonces no podremos eliminar la categoria

         // Abrimos otra conexion a la base de datos y la almacenamos en la variable $check_productos
    	$check_productos=conexion();
        // Dentro de la variable $check_productos ahora vamos a almacenar la consulta select que dice, selecciona
        // categoria_id de la tabla producto donde categoria_id sea igual a la que estamos mandando seleccionando solo 1 registro con el limit
        // sin importar cual sea, solo me interesa saber si tiene productos registrados, por eso solo selecciono uno, el que sea da igual
    	$check_productos=$check_productos->query("SELECT categoria_id FROM producto WHERE categoria_id='$category_id_del' LIMIT 1");

        // Si la categoria que queremos eliminar NO tiene productos registrados entonces si podemos eliminarla, entonces:
    	if($check_productos->rowCount()<=0){

            // Abrimos una tercera conexion a la base de datos y la almacenamos en la variable $eliminar_categoria
    		$eliminar_categoria=conexion();
            // Dentro de la variable $eliminar_categoria ahora vamos a almacenar la consulta delete que dice, elimina
            // de la tabla categoria la categoria con id que le mandamos usando prepare para mayor seguridad enves de query
	    	$eliminar_categoria=$eliminar_categoria->prepare("DELETE FROM categoria WHERE categoria_id=:id");

            //Ejecutamos la consulta a la base de datos delete con execute, mandandole el marcador :id con el valor de la variable $category_id_del
	    	$eliminar_categoria->execute([":id"=>$category_id_del]);

            // Si se elimino un dato entonces:
	    	if($eliminar_categoria->rowCount()==1){
		        echo '
		            <div class="notification is-info is-light">
		                <strong>¡CATEGORIA ELIMINADA!</strong><br>
		                Los datos de la categoría se eliminaron con exito
		            </div>
		        ';
		    }else{
                // Si no se elimino nungun dato entonces:
		        echo '
		            <div class="notification is-danger is-light">
		                <strong>¡Ocurrio un error inesperado!</strong><br>
		                No se pudo eliminar la categoría, por favor intente nuevamente
		            </div>
		        ';
		    }
            // Cierro mi tercera conexion a la base de datos
		    $eliminar_categoria=null;
    	}else{
            // Si la categoria que queremos eliminar tiene productos registrados entonces:
    		echo '
	            <div class="notification is-danger is-light">
	                <strong>¡Ocurrio un error inesperado!</strong><br>
	                No podemos eliminar la categoría ya que tiene productos asociados
	            </div>
	        ';
    	}
        // Cierro mi segunda conexion a la base de datos
    	$check_productos=null;
    }else{
        // En caso de que la categoria que se quiere eliminar no existe en la base de datos entonces:
    	echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                La CATEGORIA que intenta eliminar no existe
            </div>
        ';
    }
    // Cerramos la conexion a la base de datos
    $check_categoria=null;