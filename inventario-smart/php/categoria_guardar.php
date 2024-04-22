<?php
    // Añadimos el contenido del archivo main.php para usarse solo una ves en este archivo 
	require_once "main.php";

    /*== Almacenando datos ==*/
    // Almacenamos el nombre y ubicacion que se envian desde el formulario limpiando antes esos datos de inyeccion sql
    $nombre=limpiar_cadena($_POST['categoria_nombre']);
    $ubicacion=limpiar_cadena($_POST['categoria_ubicacion']);


    /*== Verificando campos obligatorios ==*/
    // Si nombre esta vacio significa que no se a llenado ese campo obligatorio
    if($nombre==""){
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
    // Abrimos conexion a la base de datos
    $check_nombre=conexion();
    // Hacemos una consulta select de categoria_nombre de la tabla categoria donde categoria_nombre de la BD sea igual al nombre que se manda desde el formulario
    $check_nombre=$check_nombre->query("SELECT categoria_nombre FROM categoria WHERE categoria_nombre='$nombre'");
    // Si la consulta SELECT selecciono 1 registro de la base de datos entonces:
    if($check_nombre->rowCount()>0){
        // Significa que el usuario ya se encuentra registrado en la base de datos
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El NOMBRE ingresado ya se encuentra registrado, por favor elija otro
            </div>
        ';
        // Se detiene la ejecucion del script
        exit();
    }
    // Cerramos al conexion a la base de datos
    $check_nombre=null;


    /*== Guardando datos ==*/
    // Abrimos una conexion a la base de datos
    $guardar_categoria=conexion();
    // Hacemos una consulta INSERT, inserta en la tabla categoria en los campos categoria_nombre y categoria_ubicacion
    // Preparamos el INSERT usando el array $marcadores, utilizando sus marcadores en el prepare para hacer la insercion mas segura
    $guardar_categoria=$guardar_categoria->prepare("INSERT INTO categoria(categoria_nombre,categoria_ubicacion) VALUES(:nombre,:ubicacion)");

    // Hacemos el Array para almacenar los valores que queremos insertar en la base de datos, uno en cada marcador
    $marcadores=[
        ":nombre"=>$nombre,
        ":ubicacion"=>$ubicacion
    ];

    // Ejecutamos la consulta SELECT que tenemos preparada, ya con los valores correctos mandole los que tenemos en el array $marcadores
    $guardar_categoria->execute($marcadores);

    // Si se inserto 1 registro entonces:
    if($guardar_categoria->rowCount()==1){
        // Significa que la categoria se registro con exito
        echo '
            <div class="notification is-info is-light">
                <strong>¡CATEGORIA REGISTRADA!</strong><br>
                La categoría se registro con exito
            </div>
        ';
    }else{
        // Significa que la categoria NO se registro con exito
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No se pudo registrar la categoría, por favor intente nuevamente
            </div>
        ';
    }
    // Cerramos la conexion a la base de datos
    $guardar_categoria=null;