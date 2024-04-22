<div class="container is-fluid mb-6">
    <h1 class="title">Productos</h1>
    <h2 class="subtitle">Lista de productos por categoría</h2>
</div>

<div class="container pb-6 pt-6">
    <?php
        // Incluimos el archivo con nuestras funciones importantes:
        require_once "./php/main.php";
    ?>
    <div class="columns">
        <div class="column is-one-third">
            <h2 class="title has-text-centered">Categorías</h2>
            <?php
                // Abrimos conexion a la base de datos
                $categorias=conexion();
                // Hacemos una consulta SELECT, selecciona todos los registros de la tabla categoria
                $categorias=$categorias->query("SELECT * FROM categoria");
                // Si se selecciono 1 registro o mas entonces:
                if($categorias->rowCount()>0){
                    // Colocamos todos esos registros seleccionados en un arreglo llamado $categorias
                    $categorias=$categorias->fetchAll();
                    // Recorremos con un foreach el arreglo $categorias que contiene todos los registros de la tabla categoria
                    // por medio de una variable llamada $row
                    foreach($categorias as $row){
                        // Vamos generando dinamicamente etiquetas <a> con la ruta para cada id de cada categoria y su nombre de la categoria
                        // Esto para ir listando las categorias ademas de darle un bonito diseño a cada etiqueta <a> que se esta generando con bulma
                        echo '<a href="index.php?vista=product_category&category_id='.$row['categoria_id'].'" class="button is-link is-inverted is-fullwidth">'.$row['categoria_nombre'].'</a>';
                    }
                }else{
                    // Si NO se seleccionaron registros con la consulta SELECT entonces:
                    // Decimos que NO hay categorias registradas
                    echo '<p class="has-text-centered" >No hay categorías registradas</p>';
                }
                // Cerramos la conexion a la base de datos
                $categorias=null;
            ?>
        </div>
        <div class="column">
            <?php
                // Si la consulta de tipo GET llamada category_id viene definida entonces (?):
                // Almacenaremos el valor de la variable de tipo GET llamada category_id en la variable $categoria_id
                // Si no viene definida entonces almacenaremos 0 en la variable $categoria_id
                $categoria_id = (isset($_GET['category_id'])) ? $_GET['category_id'] : 0;

                /*== Verificando categoria ==*/
                // Abrimos conexion a la base de datos
                $check_categoria=conexion();
                // Hacemos una consulta SELECT, selecciona todos los registros de la tabla categoria donde el campo categoria_id
                // sea igual al id de la categoria que estamos mandando desde el formulario
                $check_categoria=$check_categoria->query("SELECT * FROM categoria WHERE categoria_id='$categoria_id'");

                // Si la consulta SELECT seleciono 1 registro entonces:
                if($check_categoria->rowCount()>0){

                    // Colocaremos los campos de ese registro en un array llamado $check_categoria con la funcion fetch()
                    $check_categoria=$check_categoria->fetch();

                    // Mostraremos el nombre de la categoria con un h2 y un parrafo con su ubicacion de esa categoria 
                    // con ayuda del array que contiene los datos de la categoria que se selecciono
                    echo '
                        <h2 class="title has-text-centered">'.$check_categoria['categoria_nombre'].'</h2>
                        <p class="has-text-centered pb-6" >'.$check_categoria['categoria_ubicacion'].'</p>
                    ';

                    // Inlcuimos elarchivo que contiene todas nuestras funciones importantes
                    require_once "./php/main.php";

                    # Eliminar producto #
                    // Si la variable de tipo GET viene definida entonces:
                    if(isset($_GET['product_id_del'])){
                        // Inlcuimos el script que sirve para eliminar un producto
                        require_once "./php/producto_eliminar.php";
                    }

                    if(!isset($_GET['page'])){
                        $pagina=1;
                    }else{
                        $pagina=(int) $_GET['page'];
                        if($pagina<=1){
                            $pagina=1;
                        }
                    }

                    $pagina=limpiar_cadena($pagina);
                    $url="index.php?vista=product_category&category_id=$categoria_id&page="; /* <== */
                    $registros=11;
                    $busqueda="";

                    # Paginador producto #
                    // E incluimos el script que sirve para listar productos
                    require_once "./php/producto_lista.php";

                }else{
                    // Si la consulta SELECT NO seleciono ningun registro entonces:
                    // Mostramos un h2 que dira Seleccione una categoria para empezar
                    echo '<h2 class="has-text-centered title" >Seleccione una categoría para empezar</h2>';
                }
                // Cerramos la conexion con la base de datos
                $check_categoria=null;
            ?>
        </div>
    </div>
</div>