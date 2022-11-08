<?php

//conectarse a la bd.
$host = "localhost";
$bd = "sitio";
$usuario = "root";
$contrasenia="";

try {
    //variable de conexión.
    $conexion=new PDO("mysql:host=$host;dbname=$bd",$usuario,$contrasenia );
    if($conexion){
        //echo "Conectado a bd";
    }
} catch ( Exception $ex) {
    echo $ex->getMessage();
}


?>