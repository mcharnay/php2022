<?php
session_start();
  //si hay un usuario logeado
  if(!isset($_SESSION['usuario'])){
    header("Location:../index.php");
  }else{

    if($_SESSION['usuario']=="ok"){
      $nombreUsuario=$_SESSION["nombreUsuario"];
    }

  }

?>


<!doctype html>
<html lang="en">
  <head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" 
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>

  <!--Redirección, esta variable da info sobre el host donde estoy, esto se usa para usar por ejemplo mipagina.com, y que siempre use ese link-->
  <!--En este caso, la url vale localhost, pero si fuera otra página, sería ese el valor-->
  <?php $url="http://".$_SERVER['HTTP_HOST']."/sitioweb" ?>

  <!--Recordar poner echo en el url, si no, no envía.-->
    <nav class="navbar navbar-expand navbar-light bg-light">
        <div class="nav navbar-nav">
            <a class="nav-item nav-link active" href="#">Administrador del sitio web<span class="sr-only">(current)</span></a>
            <a class="nav-item nav-link" href="<?php echo $url?>/administrador/inicio.php">Inicio</a>

            <a class="nav-item nav-link" href="<?php echo $url?>/administrador/seccion/productos.php">Libros</a>
            <a class="nav-item nav-link" href="<?php echo $url?>/administrador/seccion/cerrar.php"">Cerrar</a>
            <a class="nav-item nav-link" href="<?php echo $url; ?>">Ver sitio web</a>
        </div>
    </nav>

    <div class="container">
      <br>
        <div class="row">
