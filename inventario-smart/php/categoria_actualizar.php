<?php
    # Como en categoria no vamos a utilizar variables de sesion pues no incluimos el archivo para la sesion como en usuario_actualizar.php

    // Incluimos el archivo con las funciones importantes
	require_once "main.php";

	/*== Almacenando id ==*/
    // Almacenamos el id mandado desde el formulario del archivo category_update.php en el input con name categoria_id
    $id=limpiar_cadena($_POST['categoria_id']);


    /*== Verificando categoria ==*/
    // Abrimos una conexion a la base de datos
	$check_categoria=conexion();
    // Ahora almacenamos el resultado de la consulta select a la base de datos para poder verificar
    // si la categoria realmente existe en la base de datos mediante su id
	$check_categoria=$check_categoria->query("SELECT * FROM categoria WHERE categoria_id='$id'");

    // Verificamos si la categoria realmente existe en la base de datos mediante su id, a ver si la consulta trajo algun registro
    if($check_categoria->rowCount()<=0){
        // Si la categoria NO existe entonces
    	echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                La categoría no existe en el sistema
            </div>
        ';
        // Y detenemos la ejecucion del script
        exit();
    }else{
        //Si la categoria SI existe en la base de datos entonces:
        // Almacenamos los campos del registro que encontro dentro de un array con la funcion fetch en la variable datos
    	$datos=$check_categoria->fetch();
    }
    // Cerramos la conexion a la base de datos
    $check_categoria=null;

    /*== Almacenando datos ==*/
    $nombre=limpiar_cadena($_POST['categoria_nombre']);
    $ubicacion=limpiar_cadena($_POST['categoria_ubicacion']);


    /*== Verificando campos obligatorios ==*/
    if($nombre==""){
        // Si los todos los campos obligatorios NO vienen completados entonces
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No has llenado todos los campos que son obligatorios
            </div>
        ';
        exit();
    }


    /*== Verificando integridad de los datos ==*/
    if(verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{4,50}",$nombre)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El NOMBRE no coincide con el formato solicitado
            </div>
        ';
        exit();
    }

    if($ubicacion!=""){
    	if(verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{5,150}",$ubicacion)){
	        echo '
	            <div class="notification is-danger is-light">
	                <strong>¡Ocurrio un error inesperado!</strong><br>
	                La UBICACION no coincide con el formato solicitado
	            </div>
	        ';
	        exit();
	    }
    }


    /*== Verificando nombre ==*/
    // Verificamos que el nombre de la categoria del formulario es el mismo que el que tenemos almacenado en la base de datos
    if($nombre!=$datos['categoria_nombre']){
        // En caso de que SI Abrimos conexion a la base de datos
	    $check_nombre=conexion();
        // Hacemos una consulta select, selecciona categoria_nombre de la tabla categoria donde categoria_nombre sea el mismo al que se mando en el formulario
	    $check_nombre=$check_nombre->query("SELECT categoria_nombre FROM categoria WHERE categoria_nombre='$nombre'");
        // Si la consulta select si selecciono un dato, significa que esa usuario SI existe en nuestra base de datos, entonces:
	    if($check_nombre->rowCount()>0){
            // Mandaremos una notificacion diciendo que el nombre ya se encuentra registrado
	        echo '
	            <div class="notification is-danger is-light">
	                <strong>¡Ocurrio un error inesperado!</strong><br>
	                El NOMBRE ingresado ya se encuentra registrado, por favor elija otro
	            </div>
	        ';
            // Detenemos la ejecucion del script
	        exit();
	    }
        // Cerrarmos la conexion a la base de datos
	    $check_nombre=null;
    }


    /*== Actualizar datos ==*/
    // Abrimos conexion a la base de datos
    $actualizar_categoria=conexion();
    // Hacemos una consulta para actualizar UPDATE utilizando prepare para mayor seguridad
    // Actualiza de la tabla categoria los campos categoria_nombre, categoria_ubicacion
    // DONDE categoria_id sea igual al id de la categoria que esta enviando desde el formulario
    // Poniendoles el valor que almacena cada variable ($nombre, $ubicacion) usando sus marcadores de posicion del array llamado $marcadores
    $actualizar_categoria=$actualizar_categoria->prepare("UPDATE categoria SET categoria_nombre=:nombre,categoria_ubicacion=:ubicacion WHERE categoria_id=:id");

    $marcadores=[
        ":nombre"=>$nombre,
        ":ubicacion"=>$ubicacion,
        ":id"=>$id
    ];

    // Si el usuario se actualizo con exito entonces:
    if($actualizar_categoria->execute($marcadores)){
        echo '
            <div class="notification is-info is-light">
                <strong>¡CATEGORIA ACTUALIZADA!</strong><br>
                La categoría se actualizo con exito
            </div>
        ';
    }else{
        // Si no se actualizo con exito entonces:
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No se pudo actualizar la categoría, por favor intente nuevamente
            </div>
        ';
    }
    // Cerramos la conexion a la base de datos
    $actualizar_categoria=null;