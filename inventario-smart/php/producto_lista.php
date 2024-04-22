<?php
    // Este archivo se parece mucho a usuario_lista.php solamente fue modificado para que funcionara con categoria
    
    // Esta variable va a servir para saber desde donde vamos a empezar a contar los registros que vamos a mostrar en las tablas de categorias, contendra el indice 
    // Si la pagina viene definida osea es mayor a 0 entonces hace el calculo para saber desde donde contar
    // Sino se le agrega el valor 0 a la variable inicio (empezaremos a contar desde el indice 0)
	$inicio = ($pagina>0) ? (($pagina * $registros)-$registros) : 0;
    // Con la variable tabla vamos a ir construyendo la tabla completa a lo largo de la ejecucion de este script
	$tabla="";

    // Almacenamos todos mis campos que voy a utilizar en la consulta SELECT con INNER JOIN dentro de la variable $campos
    // Recordemos que por ejemplo producto.producto_id quiero seleccionar el campo producto_id de la tabla producto, ya que
    // con el INNER JOIN lo que hago es que puedo seleccionar campos de diferentes tablas uniendolas con el INNER JOIN
    // por eso es importante especificar de que tabla es cada campo
	$campos="producto.producto_id,producto.producto_codigo,producto.producto_nombre,producto.producto_precio,producto.producto_stock,producto.producto_foto,producto.categoria_id,producto.usuario_id,categoria.categoria_id,categoria.categoria_nombre,usuario.usuario_id,usuario.usuario_nombre,usuario.usuario_apellido";

    // Aqui veremos si generaremos el listado con busqueda o el listado normal sin nungun filtro de busqueda
    // Si la variable busqueda viene definida y tiene algo almacenado entonces:
	if(isset($busqueda) && $busqueda!=""){
        // Consulta con INNER JOIN añadiendo busqueda

		$consulta_datos="SELECT $campos FROM producto INNER JOIN categoria ON producto.categoria_id=categoria.categoria_id INNER JOIN usuario ON producto.usuario_id=usuario.usuario_id WHERE producto.producto_codigo LIKE '%$busqueda%' OR producto.producto_nombre LIKE '%$busqueda%' ORDER BY producto.producto_nombre ASC LIMIT $inicio,$registros";

		$consulta_total="SELECT COUNT(producto_id) FROM producto WHERE producto_codigo LIKE '%$busqueda%' OR producto_nombre LIKE '%$busqueda%'";

    // Si el valor de categoria_id es mayor a 0 significa que hemos seleccionado una categoria entonces:
	}elseif($categoria_id>0){
        // Son las mismas consultas que las normales pero donde categoria_id sea igual al id de la categoria que seleccionamos
		$consulta_datos="SELECT $campos FROM producto INNER JOIN categoria ON producto.categoria_id=categoria.categoria_id INNER JOIN usuario ON producto.usuario_id=usuario.usuario_id WHERE producto.categoria_id='$categoria_id' ORDER BY producto.producto_nombre ASC LIMIT $inicio,$registros";

        // Aqui vamos a tener el total de registros que tenemos de la tabla producto en la base de datos DONDE categoria_id sea igual al id de la categoria que seleccionamos
		$consulta_total="SELECT COUNT(producto_id) FROM producto WHERE categoria_id='$categoria_id'";

	}else{
        // Cuando tenemos el listado NORMAL sin ninguna busqueda ni buscando por categoria:

        // Selecciona los campos de la tabla producto, categoria y usuario donde 
        // categoria_id de la tabla producto sea igual a categoria_id de la tabla categoria
        // y usuario_id de la tabla producto sea igual a usuario_id de la tabla usuario
        // Y ordena los registros seleccionados de manera Ascendente por nombre del producto
        // y agregando un limite con limit de lo que contanga la variable inicio (indice) y registros (15 registros maximo como limite)
		$consulta_datos="SELECT $campos FROM producto INNER JOIN categoria ON producto.categoria_id=categoria.categoria_id INNER JOIN usuario ON producto.usuario_id=usuario.usuario_id ORDER BY producto.producto_nombre ASC LIMIT $inicio,$registros";

        // Aqui vamos a tener el total de registros que tenemos de la tabla producto en la base de datos 
		$consulta_total="SELECT COUNT(producto_id) FROM producto";

	}

    // Abrimos conexion a la base de datos
	$conexion=conexion();

    // Ejecutamos la consulta select que tenemos almacenada en $consulta_datos, ya sea cualquiera de las 3 
	$datos = $conexion->query($consulta_datos);
    // Esos datos que se seleccionaron los ponemos en un array llamado $datos con fetchAll()
	$datos = $datos->fetchAll();

    // Ejecutamos la consulta select que tenemos almacenada en $consulta_total, ya sea cualquiera de las 3 
	$total = $conexion->query($consulta_total);
    // Y almacenamos el valor de la columna, que nos devolvio la consulta, ya convertido a int en mi variable llamada $total
    // es decir el numero de resitros seleccionados en la consulta convertido a entero
	$total = (int) $total->fetchColumn();

    // En la variable Npaginas que estamos creando vamos a almacenar el numero de paginas que se tienen que crear en el paginador
    // para eso divido la cantidad de datos ($total) entre el numero maximo de registros permitidos en cada pagina ($registros) osea 15
    // Y el resultado lo redondeo con la funcion ceil() a su numero proximo, por ejemplo 2.1 se redondea a 3
	$Npaginas =ceil($total/$registros);

    // Lo que hace este if es ver si hay registros y si estamos ubicados en una pagina existente es decir en una pagina valida.
	// Si la cantidad de datos ($total) es mayor o igual a 1 AND la pagina en la que estamos ubicados ($pagina) es menor o igual al 
	// numero de paginas que se tienen que crear en el paginador ($Npaginas) entonces:
	if($total>=1 && $pagina<=$Npaginas){
        // Sumamos al indice ($inicio) un 1, para que empiece a contar en 1 el primer registro y no en 0 en la tabla y se lo agregamos a la variable ($contador)
		$contador=$inicio+1;
        // En esta variable se almacenara el numero del primer registro en esa pagina del paginador.
		// Esto para mostrar un mensaje como por ej. Mostrando usuarios del (1) al 5 de un total de 17 registros.
		// Esta variable tendria el numero 1 en ese ejemplo, ese mensaje se mostrara debajo de la tabla de los registros en el sistema.
		$pag_inicio=$inicio+1;
        // Recorremos todos los datos almacenados en el array ($datos) con una variable apenas creada llamada ($rows)
		foreach($datos as $rows){
            // Y vamos construyendo las filas($rows) de la tabla de datos, por medio de el nombre de su campo en la base de datos o su clave
			// añadiendo tambien sus botones para actualizar y eliminar en CADA fila de la tabla que se vaya generando dinamicamente.
			$tabla.='
				<article class="media">
			        <figure class="media-left">
			            <p class="image is-64x64">';
			            if(is_file("./img/producto/".$rows['producto_foto'])){
			            	$tabla.='<img src="./img/producto/'.$rows['producto_foto'].'">';
			            }else{
			            	$tabla.='<img src="./img/producto.png">';
			            }
			   $tabla.='</p>
			        </figure>
			        <div class="media-content">
			            <div class="content">
			              <p>
			                <strong>'.$contador.' - '.$rows['producto_nombre'].'</strong><br>
			                <strong>CODIGO:</strong> '.$rows['producto_codigo'].', <strong>PRECIO:</strong> $'.$rows['producto_precio'].', <strong>STOCK:</strong> '.$rows['producto_stock'].', <strong>CATEGORIA:</strong> '.$rows['categoria_nombre'].', <strong>REGISTRADO POR:</strong> '.$rows['usuario_nombre'].' '.$rows['usuario_apellido'].'
			              </p>
			            </div>
			            <div class="has-text-right">
			                <a href="index.php?vista=product_img&product_id_up='.$rows['producto_id'].'" class="button is-link is-rounded is-small">Imagen</a>
			                <a href="index.php?vista=product_update&product_id_up='.$rows['producto_id'].'" class="button is-success is-rounded is-small">Actualizar</a>
			                <a href="'.$url.$pagina.'&product_id_del='.$rows['producto_id'].'" class="button is-danger is-rounded is-small">Eliminar</a>
			            </div>
			        </div>
			    </article>

			    <hr>
            ';
            $contador++;
		}
		$pag_final=$contador-1;
	}else{
		if($total>=1){
			$tabla.='
				<p class="has-text-centered" >
					<a href="'.$url.'1" class="button is-link is-rounded is-small mt-4 mb-4">
						Haga clic acá para recargar el listado
					</a>
				</p>
			';
		}else{
			$tabla.='
				<p class="has-text-centered" >No hay registros en el sistema</p>
			';
		}
	}

	if($total>0 && $pagina<=$Npaginas){
		$tabla.='<p class="has-text-right">Mostrando productos <strong>'.$pag_inicio.'</strong> al <strong>'.$pag_final.'</strong> de un <strong>total de '.$total.'</strong></p>';
	}

	$conexion=null;
	echo $tabla;

	if($total>=1 && $pagina<=$Npaginas){
		echo paginador_tablas($pagina,$Npaginas,$url,7);
	}