<div class="container is-fluid mb-6">
    <h1 class="title">Categorías</h1>
    <h2 class="subtitle">Lista de categoría</h2>
</div>

<div class="container pb-6 pt-6">
    <?php
         # Incluimos el archivo con nuestras funciones principales #
        require_once "./php/main.php";

        # Eliminar categoria #
        // Si la variable de tipo get llamada category_id_del viene definida entonces:
        if(isset($_GET['category_id_del'])){
            // Incluimos el archivo para eliminar una categoria 
            require_once "./php/categoria_eliminar.php";
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

        // Por seguridad limpiamos el valor de la variable pagina de inyeccion SQL o HTML
        $pagina=limpiar_cadena($pagina);
        // Creamos la variable url con la direccion a la pagina del paginador SIN valor todavia
        $url="index.php?vista=category_list&page="; /* <== */
        // Creamos la variable registros y el valor que tiene es el numero de registros que se van a mostrar en cada pagina del paginado como MAXIMO
        $registros=11;
        // Esta variable nos va a permitir hacer la busqueda de categorias 
        $busqueda="";

        # Incluimos el archivo del Paginador categoria #
        require_once "./php/categoria_lista.php";
    ?>
</div>