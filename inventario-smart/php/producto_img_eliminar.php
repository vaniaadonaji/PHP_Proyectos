<?php
    // Incluimos el script con todas nuestras funciones importantes
	require_once "main.php";

	/*== Almacenando datos ==*/
    // Almacenamos el id del producto al que pertenece la imagen que queremos eliminar
    $product_id=limpiar_cadena($_POST['img_del_id']);

    /*== Verificando producto ==*/
    // Abrimos conexion a la base de datos
    $check_producto=conexion();
    // Hacemos una peticion SELECT, selecciona todos los registros de la tabla producto donde el producto_id sea igual al id 
    // del producto que se manda desde el formulario
    $check_producto=$check_producto->query("SELECT * FROM producto WHERE producto_id='$product_id'");

    // Este if es para saber si existe el producto que se quizo seleccionar anteriormente en la base de datos
    // Si los datos seleccionados en la consulta es igual a 1 entonces significa que si existe, entonces:
    if($check_producto->rowCount()==1){
        // Colocaremos los valores de los campos de ese producto en un array llamado $datos
    	$datos=$check_producto->fetch();
    }else{
        // Si no existe en nuestra base de datos entonces:
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                La imagen del PRODUCTO que intenta eliminar no existe
            </div>
        ';
        // Detenemos la ejecucion del script
        exit();
    }
    // Cerramos la conexion a la base de datos
    $check_producto=null;


    /* Directorios de imagenes */
    // Almacenamos la ruta de nuestro directorio que contiene las imagenes en una variable
	$img_dir='../img/producto/';

	/* Cambiando permisos al directorio */
    // Le damos todos los permisos
	chmod($img_dir, 0777);


	/* Eliminando la imagen */
    // Si la imagen que queremos eliminar existe en nuestra carpeta img, en la carpeta producto entonces:
	if(is_file($img_dir.$datos['producto_foto'])){
        // Le damos todos los permisos a esa imagen
		chmod($img_dir.$datos['producto_foto'], 0777);

        // Si hubo un error al eliminar la imagen del producto entonces:
		if(!unlink($img_dir.$datos['producto_foto'])){
			echo '
	            <div class="notification is-danger is-light">
	                <strong>¡Ocurrio un error inesperado!</strong><br>
	                Error al intentar eliminar la imagen del producto, por favor intente nuevamente
	            </div>
	        ';
            // Y detenemos la ejecucion de este script
	        exit();
		}
	}


	/*== Actualizando datos ==*/
    // Abrimos conexion a la base de datos
    $actualizar_producto=conexion();
    // Preparamos una consulta UPDATE, actualiza en la tabla producto el campo de imagen del producto dejandolo vacio ya que se elimino
    $actualizar_producto=$actualizar_producto->prepare("UPDATE producto SET producto_foto=:foto WHERE producto_id=:id");

    // Ponemos los valores correctos correspondientes en cada marcador
    $marcadores=[
        ":foto"=>"",
        ":id"=>$product_id
    ];

    // Si la actualizacion de la eliminacion se ejecuto correctamente entonces:
    if($actualizar_producto->execute($marcadores)){
        echo '
            <div class="notification is-info is-light">
                <strong>¡IMAGEN O FOTO ELIMINADA!</strong><br>
                La imagen del producto ha sido eliminada exitosamente, pulse Aceptar para recargar los cambios.

                <p class="has-text-centered pt-5 pb-5">
                    <a href="index.php?vista=product_img&product_id_up='.$product_id.'" class="button is-link is-rounded">Aceptar</a>
                </p">
            </div>
        ';
    }else{
        // Si la actualizacion de la eliminacion NO se ejecuto correctamente entonces: 
        echo '
            <div class="notification is-warning is-light">
                <strong>¡IMAGEN O FOTO ELIMINADA!</strong><br>
                Ocurrieron algunos inconvenientes, sin embargo la imagen del producto ha sido eliminada, pulse Aceptar para recargar los cambios.

                <p class="has-text-centered pt-5 pb-5">
                    <a href="index.php?vista=product_img&product_id_up='.$product_id.'" class="button is-link is-rounded">Aceptar</a>
                </p">
            </div>
        ';
    }
    // Cerramos la conexion a la base de datos
    $actualizar_producto=null;