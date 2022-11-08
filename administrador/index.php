<?php
$mensaje="";
// login http://localhost/sitioweb/administrador/index.php
session_start();
    if($_POST){
        if(($_POST['usuario']=="michel")&&($_POST['contrasenia']=="michel")){
            
            $_SESSION['usuario']='ok';
            $_SESSION['nombreUsuario']='michel';
            header('Location:inicio.php');
        }else{
            $mensaje="Error: usuario o contraseña incorrecto";
        }
        
        header('Location:inicio.php');


    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador del sitio web</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" 
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

</head>
<body>
        <br><br><br>
    <div class=container>
        <div class="row">
            <div class="col-md-4">
                
            </div>

            <div class="col-md-4">
                
                 <div class="card">
                        
                        <div class="card-header">
                            Login
                        </div>
                        
                        
                        <div class="card-body">
                            <?php if($mensaje){ ?>
                                <div class="alert alert-danger" role="alert">
                                <?php echo $mensaje; ?>
                                </div>
                            <?php } ?> 
                                
                            <form method="POST" action="">
                                <div class = "form-group">
                                <label >Usuario</label>
                                <input type="text" class="form-control"  name="usuario"  placeholder="Escriba tu usuario">
                                </div>
                                
                                <div class="form-group">
                                <label >Contraseña</label>
                                <input type="password" class="form-control"  name="contrasenia" placeholder="Escriba tu contraseña">
                                </div>
                                
                                
                                <button type="submit" class="btn btn-primary">Entrar</button>
                            </form>
                         

                        </div>

                 </div>

            </div>
        </div>
    </div>

</body>
</html>