<?php
    // Añadimos el archivo de inicio de sesion 
	require_once "../inc/session_start.php";

    // Agregamos el archivo main con nuestras funciones importantes que vamos a usar
	require_once "main.php";

	/*== Almacenando datos ==*/
    // Aqui guardo los datos que envio el usuario desde el formulario para agregar nuevo producto (product_new.php) en variables
    // y los limpio de inyecciones con la funcion limpiar_cadena() que tengo en main.php pero la puedo usar por el require_once
	$codigo=limpiar_cadena($_POST['producto_codigo']);
	$nombre=limpiar_cadena($_POST['producto_nombre']);

	$precio=limpiar_cadena($_POST['producto_precio']);
	$stock=limpiar_cadena($_POST['producto_stock']);
	$categoria=limpiar_cadena($_POST['producto_categoria']);


	/*== Verificando campos obligatorios ==*/
    //Si alguno de estos campos obligatorios viene vacio entonces
    if($codigo=="" || $nombre=="" || $precio=="" || $stock=="" || $categoria==""){
        // Mostramos una notificacion de alerta en codigo HTML sacada de bulma 
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No has llenado todos los campos que son obligatorios
            </div>
        ';
        // Detenemos la ejecucion del codigo con exit()
        exit();
    }


    /*== Verificando integridad de los datos ==*/
    if(verificar_datos("[a-zA-Z0-9- ]{1,70}",$codigo)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El CODIGO de BARRAS no coincide con el formato solicitado
            </div>
        ';
        exit();
    }

    if(verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,$#\-\/ ]{1,70}",$nombre)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El NOMBRE no coincide con el formato solicitado
            </div>
        ';
        exit();
    }

    if(verificar_datos("[0-9.]{1,25}",$precio)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El PRECIO no coincide con el formato solicitado
            </div>
        ';
        exit();
    }

    if(verificar_datos("[0-9]{1,25}",$stock)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El STOCK no coincide con el formato solicitado
            </div>
        ';
        exit();
    }


    /*== Verificando codigo ==*/
    $check_codigo=conexion();
    $check_codigo=$check_codigo->query("SELECT producto_codigo FROM producto WHERE producto_codigo='$codigo'");
    if($check_codigo->rowCount()>0){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El CODIGO de BARRAS ingresado ya se encuentra registrado, por favor elija otro
            </div>
        ';
        exit();
    }
    $check_codigo=null;


    /*== Verificando nombre ==*/
    // Hacemos conexion a la BD con la funcion conexion() del archivo main.php
    $check_nombre=conexion();
    // Hago una consulta SELECT, selecciona producto_nombre de la tabla producto DONDE producto_nombre sea igual al nombre 
    // que se esta mandando desde el formulario product_new.php
    $check_nombre=$check_nombre->query("SELECT producto_nombre FROM producto WHERE producto_nombre='$nombre'");
    // Si existe un registro con ese nombre en la consulta a la base de datos entonces:
    if($check_nombre->rowCount()>0){
        //Mostramos una notificacion de alerta en codigo HTML sacada de bulma y detenemos la ejecucion del codigo con exit()
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El NOMBRE ingresado ya se encuentra registrado, por favor elija otro
            </div>
        ';
        exit();
    }
    $check_nombre=null;


    /*== Verificando categoria ==*/
    $check_categoria=conexion();
    $check_categoria=$check_categoria->query("SELECT categoria_id FROM categoria WHERE categoria_id='$categoria'");
    if($check_categoria->rowCount()<=0){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                La categoría seleccionada no existe
            </div>
        ';
        exit();
    }
    // Cierro la conexion a la Base de datos (es necesario cerrarla para liberar espacio de memoria)
    $check_categoria=null;


    /* Directorios de imagenes */
    // Almacenamos la ruta de la carpeta que creamos en la carpeta img
	$img_dir='../img/producto/';


	/*== Comprobando si se ha seleccionado una imagen ==*/
    // Si se ha subido una imagen entonces:
	if($_FILES['producto_foto']['name']!="" && $_FILES['producto_foto']['size']>0){

        /* Creando directorio de imagenes */
        // Si el archivo o directorio $img_dir NO existe en el sistema de archivos entonces
        if(!file_exists($img_dir)){

            // Si NO se pudo crear el directorio en el sistema de archivos utilizando la función mkdir() de PHP en la ruta
            // que esta almacenada en img_dir y con todos los permisos (0777) entonces:
            if(!mkdir($img_dir,0777)){
                // Enviaremos una notificacion de error al crear el directorio de imagenes
                echo '
                    <div class="notification is-danger is-light">
                        <strong>¡Ocurrio un error inesperado!</strong><br>
                        Error al crear el directorio de imagenes
                    </div>
                ';
                // Detenemos la ejecucion del script
                exit();
            }
        }

		/* Comprobando formato de las imagenes */
        // Si el tipo de imagen que se selecciono NO coincide con el tipo de imagen que estamos pidiendo entonces:
		if(mime_content_type($_FILES['producto_foto']['tmp_name'])!="image/jpeg" && mime_content_type($_FILES['producto_foto']['tmp_name'])!="image/png"){
            // Entonces diremos que la imagen no coincide con el formato solicitado
			echo '
	            <div class="notification is-danger is-light">
	                <strong>¡Ocurrio un error inesperado!</strong><br>
	                La imagen que ha seleccionado es de un formato que no está permitido
	            </div>
	        ';
            // Y detenemos la ejecucion del script
	        exit();
		}


		/* Comprobando que la imagen no supere el peso permitido */
		if(($_FILES['producto_foto']['size']/1024)>3072){
			echo '
	            <div class="notification is-danger is-light">
	                <strong>¡Ocurrio un error inesperado!</strong><br>
	                La imagen que ha seleccionado supera el límite de peso permitido
	            </div>
	        ';
			exit();
		}


		/* extencion de las imagenes */
		switch(mime_content_type($_FILES['producto_foto']['tmp_name'])){
			case 'image/jpeg':
			  $img_ext=".jpg";
			break;
			case 'image/png':
			  $img_ext=".png";
			break;
		}

		/* Cambiando permisos al directorio */
		chmod($img_dir, 0777);

		/* Nombre de la imagen */
		$img_nombre=renombrar_fotos($nombre);

		/* Nombre final de la imagen */
		$foto=$img_nombre.$img_ext;

		/* Moviendo imagen al directorio */
        // Si NO se puede subir la foto entonces:
		if(!move_uploaded_file($_FILES['producto_foto']['tmp_name'], $img_dir.$foto)){
			echo '
	            <div class="notification is-danger is-light">
	                <strong>¡Ocurrio un error inesperado!</strong><br>
	                No podemos subir la imagen al sistema en este momento, por favor intente nuevamente
	            </div>
	        ';
            // Detenemos la ejecucion del script
			exit();
		}

	}else{
        // Si no se ha subido la imagen entonces la variable foto se queda vacia
		$foto="";
	}


	/*== Guardando datos ==*/
    // Abrimos conexion con la base de datos
    $guardar_producto=conexion();
    // Preparamos un insert, inserta en la tabla producto (producto_codigo, producto_nombre, producto_precio, producto_stock, producto_foto, categoria_id, usuario_id)
    // Enviando los valores correspondientes a cada marcador que tenemos en el array $marcadores
    $guardar_producto=$guardar_producto->prepare("INSERT INTO producto(producto_codigo,producto_nombre,producto_precio,producto_stock,producto_foto,categoria_id,usuario_id) 
    VALUES(:codigo,:nombre,:precio,:stock,:foto,:categoria,:usuario)");

    // Creamos el array con marcadores y con el valor correspondiente a cada marcador
    $marcadores=[
        ":codigo"=>$codigo,
        ":nombre"=>$nombre,
        ":precio"=>$precio,
        ":stock"=>$stock,
        ":foto"=>$foto,
        ":categoria"=>$categoria,
        ":usuario"=>$_SESSION['id']
    ];

    // Ejecutamos el INSERT que teniamos preparado enviandole los valores correctos
    $guardar_producto->execute($marcadores);

    // Si se guardo un producto entonces:
    if($guardar_producto->rowCount()==1){
        // El producto se registro con exito
        echo '
            <div class="notification is-info is-light">
                <strong>¡PRODUCTO REGISTRADO!</strong><br>
                El producto se registro con exito
            </div>
        ';
    }else{
        // Si el producto no se registro con exito entonces:
        // Si existe un archivo en la ruta especificada en $img_dir entonces
    	if(is_file($img_dir.$foto)){
            // Cambia sus permisos a 0777, lo que otorga permisos de lectura, escritura y ejecución para todos los usuarios.
			chmod($img_dir.$foto, 0777);
            // Luego lo elimina del sistema de archivos
			unlink($img_dir.$foto);
        }
        
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No se pudo registrar el producto, por favor intente nuevamente
            </div>
        ';
    }
    // Cerramos la conexion a la base de datos
    $guardar_producto=null;