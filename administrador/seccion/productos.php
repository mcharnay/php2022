<?php include('../template/cabecera.php'); ?>

<?php

/*
se usó esto para ver si la info llega bien
print_r($_POST);
print_r($_FILES);
*/


//Validaciones con if ternarios. txtID=()?:;
$txtID=(isset($_POST['txtID']))?$_POST['txtID']:"";
$txtNombre=(isset($_POST['txtNombre']))?$_POST['txtNombre']:"";
$txtImagen=(isset($_FILES['txtImagen']['name']))?$_FILES['txtImagen']['name']:""; //este es duferente.
$accion=(isset($_POST['accion']))?$_POST['accion']:"";

/* Esto se usó para ver si llegó la información.
echo $txtID."</br>";  
echo $txtNombre."</br>";
echo $txtImagen."</br>";
echo $accion."</br>";
*/


//inlcluir la conexión de la bd
include('../config/bd.php');

//canalizar accion de usuario, agregar modificar o borrar.

switch($accion){

//se sacó del insert de mysl, tener en cuenta que una vez abierta la conexión a la base de datos, se usa la variable $conexion para usar la BD.
//INSERT INTO `libros` (`id`, `nombre`, `imagen`) VALUES (NULL, 'Libro de php', 'imagen.jpg');

    case "Agregar":
        //string de conexion y ejecución.
        $sentenciaSQL= $conexion->prepare("INSERT INTO libros (nombre, imagen) VALUES (:nombre, :imagen);");
        $sentenciaSQL->bindParam(':nombre', $txtNombre);

        //fecha se usa para ponerselo a la image para q no se repita.
        $fecha = new DateTime();
        $nombreArchivo=($txtImagen!="")?$fecha->getTimestamp()."_".$_FILES["txtImagen"]["name"]:"imagen.jpg";

        $tmpImagen=$_FILES["txtImagen"]["tmp_name"];

        if( $tmpImagen!=""){
            move_uploaded_file($tmpImagen,"../../img/".$nombreArchivo);
        }

        $sentenciaSQL->bindParam(':imagen',$nombreArchivo);
        $sentenciaSQL->execute();
        //echo "Presionaste agregar";
        header("Location:productos.php");
        break;
    
    case "Modificar":
        $sentenciaSQL= $conexion->prepare("UPDATE libros SET nombre=:nombre WHERE id=:id");
        $sentenciaSQL->bindParam(':nombre', $txtNombre);
        $sentenciaSQL->bindParam(':id', $txtID);
        $sentenciaSQL->execute();

        //agrega nueva imagen a la carpeta , no a la bd
        if($txtImagen!=""){
                
            $fecha = new DateTime();
            $nombreArchivo=($txtImagen!="")?$fecha->getTimestamp()."_".$_FILES["txtImagen"]["name"]:"imagen.jpg";
            $tmpImagen=$_FILES["txtImagen"]["tmp_name"];

            move_uploaded_file($tmpImagen,"../../img/".$nombreArchivo);

            //luego de encontrar imagen y pegarla, borrar la angitua
            $sentenciaSQL= $conexion->prepare("SELECT imagen FROM libros WHERE id=:id");
            $sentenciaSQL->bindParam(':id', $txtID);
            $sentenciaSQL->execute();
            $libro=$sentenciaSQL->fetch(PDO::FETCH_LAZY);

            //con esto se borra la imagen antigua de la carpeta.
            if( isset($libro["imagen"]) && ($libro["imagen"]!="imagen.jpg") ){
                if(file_exists("../../img/".$libro["imagen"])){
                    unlink("../../img/".$libro["imagen"]);
                }
            }
                
            //luego de haber borrado la imagen anterior, se agrega la nueva imagen y se agrega a la BD.
                $sentenciaSQL= $conexion->prepare("UPDATE libros SET imagen=:imagen WHERE id=:id");
                $sentenciaSQL->bindParam(':imagen', $nombreArchivo); //se actualiza el nuevo nombre del archivo.
                $sentenciaSQL->bindParam(':id', $txtID);
                $sentenciaSQL->execute();
            }
        
                   // echo "Presionaste Modificar";
             header("Location:productos.php");
        break;
    
    case "Cancelar":
        header("Location:productos.php");
        break;


    
    case "Seleccionar":
        //echo "Presionaste Seleccionar";
        //los datos al seleccionar, se pondrán en value de los input text para se editados.
        $sentenciaSQL= $conexion->prepare("SELECT * FROM libros WHERE id=:id");
        $sentenciaSQL->bindParam(':id', $txtID);
        $sentenciaSQL->execute();
        $libro=$sentenciaSQL->fetch(PDO::FETCH_LAZY);

        $txtNombre=$libro['nombre'];
        $txtImagen=$libro['imagen'];
        break;
        
    case "Borrar":

        $sentenciaSQL= $conexion->prepare("SELECT imagen FROM libros WHERE id=:id");
        $sentenciaSQL->bindParam(':id', $txtID);
        $sentenciaSQL->execute();
        $libro=$sentenciaSQL->fetch(PDO::FETCH_LAZY);

        //con esto se borra la imagen de la carpeta.
        if( isset($libro["imagen"]) && ($libro["imagen"]!="imagen.jpg") ){
            if(file_exists("../../img/".$libro["imagen"])){
                unlink("../../img/".$libro["imagen"]);
            }
        }
    
        //echo "Presionaste Borrar";
        $sentenciaSQL= $conexion->prepare("DELETE FROM libros WHERE id=:id");
        $sentenciaSQL->bindParam(':id', $txtID);
        $sentenciaSQL->execute();
        header("Location:productos.php");
       
       
        break;    
        

}


//acá se hizo el select all
$sentenciaSQL= $conexion->prepare("SELECT * FROM libros");
$sentenciaSQL->execute();
$listaLIbros = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);  //se guarda $sentenciaSQLen una variable para ejecutar la variable

?>


    <div class="col-md-5">


       <div class="card">
        <div class="card-header">
            Datos de Libro
        </div>
        <div class="card-body">
            
        <!--FOrmulario de ingreso de libro-->
                <form method="POST" enctype="multipart/form-data" >

                    <div class ="form-group">
                    <label for="txtID">ID:</label>
                    <input type="text" required readonly class="form-control"  value="<?php echo $txtID; ?>" name="txtID" id="txtID" placeholder="ID">
                    </div>

                    <div class ="form-group">
                    <label for="txtNombre">Nombre:</label>
                    <input type="text" required class="form-control" value="<?php echo $txtNombre; ?>"  name="txtNombre" id="txtNombre" placeholder="Nombre del libro">
                    </div>

                    <!--El de imagen se hace diferente-->
                    <div class ="form-group">
                    <label for="txtNombre">Imagen:</label>
                    
                    <!--esto es importante ya que de acá se saca el nombre de la imagen-->
                    <?php echo $txtImagen; ?>

                    <!--Si existe imagen, mostrarla al presionar seleccionar-->
                    <?php if($txtImagen!=""){ ?>

                        <img class="img-thumbnai rounded" src="../../img/<?php echo $txtImagen; ?>" width="50" alt="">

                    <?php } ?>    


                    <input type="file" class="form-control"  name="txtImagen" id="txtImagen" placeholder="Imagen del libro">
                    </div>

                    <!--activar o desactivar botones con php-->
                    <div class="btn-group" role="group" aria-label="">
                        <button type="submit" name="accion" <?php echo ($accion=="Seleccionar")?"disabled":"";?> value="Agregar" class="btn btn-success">Agregar</button>
                        <button type="submit" name="accion" <?php echo ($accion!="Seleccionar")?"disabled":"";?> value="Modificar" class="btn btn-warning">Modificar</button>
                        <button type="submit" name="accion" <?php echo ($accion!="Seleccionar")?"disabled":"";?> value="Cancelar" class="btn btn-info">Cancelar</button>
                    </div>


                </form>
        </div>
        
       </div> 


       
       
    </div>

    <div class="col-md-7">

        <!--Tabla donde se rellena con select, en los tr se abre etiqueta php para hacer un foreach -->
        <table class="table table-borderer">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Imagen</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($listaLIbros as $libro) { ?>
                <tr>
                    <td><?php echo $libro['id']; ?></td>
                    <td><?php echo $libro['nombre']; ?></td>
                    <td>
                        <img src="../../img/<?php echo $libro['imagen']; ?>" width="50" alt="">
                    <td/>
                        

                    <form method="POST">
                        <input type="hidden" name="txtID" id="txtID" value="<?php echo $libro['id']; ?>">

                        <input type="submit" class="btn btn-primary" name="accion" value="Seleccionar">

                        <input type="submit" class="btn btn-danger" name="accion" value="Borrar">
                    </form>
                
                    </td>
                </tr>
            <?php } ?>    
            </tbody>
        </table>
    </div>


<?php include('../template/pie.php'); ?>
