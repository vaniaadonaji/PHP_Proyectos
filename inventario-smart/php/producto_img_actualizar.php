<?php
    // Incluimos el script con todas nuestras funciones importantes
    require_once "main.php";

	/*== Almacenando datos ==*/
    // Almacenamos el id del producto al que pertenece la imagen que queremos actualizar
    $product_id=limpiar_cadena($_POST['img_up_id']);

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
                La imagen del PRODUCTO que intenta actualizar no existe
            </div>
        ';
        // Detenemos la ejecucion del script
        exit();
    }
    // Cerramos la conexion a la base de datos
    $check_producto=null;


    /*== Comprobando si se ha seleccionado una imagen ==*/
    if($_FILES['producto_foto']['name']=="" || $_FILES['producto_foto']['size']==0){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No ha seleccionado ninguna imagen o foto
            </div>
        ';
        exit();
    }


    /* Directorios de imagenes */
    // Almacenamos la ruta de nuestro directorio que contiene las imagenes en una variable
    $img_dir='../img/producto/';


    /* Creando directorio de imagenes */
    // Si el directorio NO existe entonces:
    if(!file_exists($img_dir)){
        // Intentamos crear el directorio y si ocurre un error al crear el directorio entonces:
        if(!mkdir($img_dir,0777)){
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


    /* Cambiando permisos al directorio */
    // Le damos todos los permisos al directorio
    chmod($img_dir, 0777);


    /* Comprobando formato de las imagenes */
    if(mime_content_type($_FILES['producto_foto']['tmp_name'])!="image/jpeg" && mime_content_type($_FILES['producto_foto']['tmp_name'])!="image/png"){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                La imagen que ha seleccionado es de un formato que no está permitido
            </div>
        ';
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

    /* Nombre de la imagen */
    $img_nombre=renombrar_fotos($datos['producto_nombre']);

    /* Nombre final de la imagen */
    $foto=$img_nombre.$img_ext;

    /* Moviendo imagen al directorio */
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


    /* Eliminando la imagen anterior */
    if(is_file($img_dir.$datos['producto_foto']) && $datos['producto_foto']!=$foto){

        chmod($img_dir.$datos['producto_foto'], 0777);
        unlink($img_dir.$datos['producto_foto']);
    }


    /*== Actualizando datos ==*/
    // Abrimos conexion a la base de datos
    $actualizar_producto=conexion();
    // Preparamos una consulta UPDATE en la tabla producto para actualizar el nombre de la foto por el nuevo nombre en el producto
    // por medio del marcador que contiene el valor que queremos colocar en la base de datos
    $actualizar_producto=$actualizar_producto->prepare("UPDATE producto SET producto_foto=:foto WHERE producto_id=:id");

    // Array con marcadores y valores de la nueva imagen que hemos actualizado
    $marcadores=[
        ":foto"=>$foto,
        ":id"=>$product_id
    ];

    // Si la actualizacion se ejecuto correctamente entonces:
    if($actualizar_producto->execute($marcadores)){
        echo '
            <div class="notification is-info is-light">
                <strong>¡IMAGEN O FOTO ACTUALIZADA!</strong><br>
                La imagen del producto ha sido actualizada exitosamente, pulse Aceptar para recargar los cambios.

                <p class="has-text-centered pt-5 pb-5">
                    <a href="index.php?vista=product_img&product_id_up='.$product_id.'" class="button is-link is-rounded">Aceptar</a>
                </p">
            </div>
        ';
    }else{
        // Si no se pudo hacer la actualizacion entonces:
        if(is_file($img_dir.$foto)){
            chmod($img_dir.$foto, 0777);
            unlink($img_dir.$foto);
        }

        echo '
            <div class="notification is-warning is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No podemos subir la imagen al sistema en este momento, por favor intente nuevamente
            </div>
        ';
    }
    // Cerramos la conexion a la base de datos
    $actualizar_producto=null;