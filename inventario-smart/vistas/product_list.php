<div class="container is-fluid mb-6">
    <h1 class="title">Productos</h1>
    <h2 class="subtitle">Lista de productos</h2>
</div>

<div class="container pb-6 pt-6">
    <?php
    # Incluimos el archivo con nuestras funciones principales #
        require_once "./php/main.php";

        # Eliminar producto #
        // Si la variable de tipo get llamada product_id_del viene definida entonces:
        if(isset($_GET['product_id_del'])){
            // Incluimos el archivo para eliminar un producto 
            require_once "./php/producto_eliminar.php";
        }

        // Si la variable de tipo GET llamada page NO viene definida entonces:
        if(!isset($_GET['page'])){
            // Entonces creamos la variable pagina con valor 1 (para indicar que estamos ubicados en la pagina 1)
            $pagina=1;
        }else{
            // Si viene definida creamos la variable pagina y le asignamos el valor de la variable GET llamada page convertido a entero
            $pagina=(int) $_GET['page'];
            // Si el valor de la variable pagina es menor o igual a 1 entonces 
            if($pagina<=1){
                // A la variable pagina le asignamos el valor 1, esto para despues CARGAR AL USUARIO LA PAGINA 1 DEL PAGINADO y no una que NO existe como la 0
                $pagina=1;
            }
        }
        // Si la variable de tipo GET llamada category_id viene definida entonces (?)
        // $categoria_id va a ser igual a la variable de tipo GET llamada category_id
        // Sino $categoria_id va a ser igual a 0
        $categoria_id = (isset($_GET['category_id'])) ? $_GET['category_id'] : 0;

        // Por seguridad limpiamos el valor de la variable pagina de inyeccion SQL o HTML
        $pagina=limpiar_cadena($pagina);
        // Creamos la variable url con la direccion a la pagina del paginador SIN valor todavia
        $url="index.php?vista=product_list&page="; /* <== */
        // Creamos la variable registros y el valor que tiene es el numero de registros que se van a mostrar en cada pagina del paginado como MAXIMO
        $registros=10;
        // Esta variable nos va a permitir la busqueda de usuarios 
        $busqueda="";

        # Paginador producto #
        require_once "./php/producto_lista.php";
    ?>
</div>