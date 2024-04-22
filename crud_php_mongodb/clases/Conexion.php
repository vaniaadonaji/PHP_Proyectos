<?php 
    require_once $_SERVER['DOCUMENT_ROOT'] . "/crud_php_mongodb/vendor/autoload.php";

    class Conexion {
        public static function conectar() {
           try {
                $usuario = "admin";
                $password = "02Mayovd";
                $BD = "crud";
                $cadenaConexion = "mongodb+srv://". 
                                    $usuario . ":" . 
                                    $password . "@clustermongo1.0ht5mnv.mongodb.net/" . 
                                    $BD . "?retryWrites=true&w=majority&appName=clustermongo1";
                $cliente = new MongoDB\Client($cadenaConexion);
                return $cliente->selectDatabase($BD);
           } catch (\Throwable $th) {
               return $th->getMessage();
           }
        }
    }