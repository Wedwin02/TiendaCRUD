<?php include('../template/cabecera.php'); ?>
<?php
$txtID = (isset($_POST['txtID'])) ? $_POST['txtID'] : "";
$txtNombre = (isset($_POST['txtNombre'])) ? $_POST['txtNombre'] : "";
$txtImg = (isset($_FILES['txtImg']['name'])) ? $_FILES['txtImg']['name'] : "";
$accion = (isset($_POST['accion'])) ? $_POST['accion'] : "";

include('../config/db.php');
switch ($accion) {
    case 'Agregar':
        # code...      
        $sentenciaSQL = $conexion->prepare("INSERT INTO libros(nombre, img) VALUES (:nombre,:img);");
        $sentenciaSQL->bindParam(':nombre', $txtNombre);


        $fecha= new DateTime();
        $NombreArchivo=($txtImg!="")?$fecha->getTimestamp()."_".$_FILES["txtImg"]["name"]:"imagen.jpg";
           
        $tmpImagen =$_FILES["txtImg"]["tmp_name"];

        if($tmpImagen!=""){
                move_uploaded_file($tmpImagen,'../../img/'.$NombreArchivo);
        }
        $sentenciaSQL->bindParam(':img', $NombreArchivo);
        $sentenciaSQL->execute();


        header("Location:productos.php");
        break;
    case 'Modificar':
        # code...
        $sentenciaSQL = $conexion->prepare('UPDATE  libros SET nombre=:nombre WHERE id=:id');
        $sentenciaSQL->bindParam(':nombre', $txtNombre);
        $sentenciaSQL->bindParam(':id', $txtID);
        $sentenciaSQL->execute();

        if($txtImg!=""){

            $fecha= new DateTime();
            $NombreArchivo=($txtImg!="")?$fecha->getTimestamp()."_".$_FILES["txtImg"]["name"]:"imagen.jpg";
            $tmpImagen =$_FILES["txtImg"]["tmp_name"];

            move_uploaded_file($tmpImagen,'../../img/'.$NombreArchivo);

            $sentenciaSQL = $conexion->prepare('SELECT img FROM libros WHERE id=:id');
            $sentenciaSQL->bindParam(':id', $txtID);
            $sentenciaSQL->execute();
            $libro = $sentenciaSQL->fetch(PDO::FETCH_LAZY);
    
            if(isset($libro['img']) &&($libro['img']!="imagen.jpg")){
                if(file_exists("../../img/".$libro['img'])){
                    unlink("../../img/".$libro['img']);
                }
            }


            $sentenciaSQL = $conexion->prepare('UPDATE  libros SET img=:img WHERE id=:id');
            $sentenciaSQL->bindParam(':img', $NombreArchivo);
            $sentenciaSQL->bindParam(':id', $txtID);
            $sentenciaSQL->execute(); 
        }
        header("Location:productos.php");
        break;
    case 'Cancelar':
        # code...

        header("Location:productos.php");


        break;
    case 'Seleccionar':
        # code...
        $sentenciaSQL = $conexion->prepare('SELECT * FROM libros WHERE id=:id');
        $sentenciaSQL->bindParam(':id', $txtID);
        $sentenciaSQL->execute();
        $libro = $sentenciaSQL->fetch(PDO::FETCH_LAZY);
        $txtNombre= $libro['nombre'];
        $txtImg = $libro['img'];
        break;
    case 'Borrar':
        # code...
        $sentenciaSQL = $conexion->prepare('SELECT img FROM libros WHERE id=:id');
        $sentenciaSQL->bindParam(':id', $txtID);
        $sentenciaSQL->execute();
        $libro = $sentenciaSQL->fetch(PDO::FETCH_LAZY);

        if(isset($libro['img']) &&($libro['img']!="imagen.jpg")){
            if(file_exists("../../img/".$libro['img'])){
                unlink("../../img/".$libro['img']);
            }
        }

        $sentenciaSQL = $conexion->prepare('DELETE FROM libros WHERE id=:id');
        $sentenciaSQL->bindParam(':id', $txtID);
        $sentenciaSQL->execute();
        header("Location:productos.php");
        break;
    default:
        # code...
        break;
}
//Llenar la tabla de presentacion 
$sentenciaSQL = $conexion->prepare('SELECT * FROM libros');
$sentenciaSQL->execute();
$listaLibros = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="col-md-4">
    <div class="card">
        <div class="card-header">
            Datos de Libro
        </div>
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="txtID">ID:</label>
                    <input type="text" require readonly class="form-control" value="<?php echo$txtID?>"name="txtID" id="txtID">
                </div>
                <div class="form-group">
                    <label for="txtNombre">Nombre:</label>
                    <input type="text" require class="form-control" value="<?php echo$txtNombre?>"name="txtNombre" id="txtNombre">
                </div>
                <div class="form-group">
                    
                    <label for="txtImg">Imagen:</label>
                    <br />
                    <?php if($txtImg!="") {?>

                        <img  class="img-thumbnail rounded-1"  src="../../img/<?php echo $txtImg?>"  width="50" alt="">
                    <?php }?>
                    <input  require type="file" class="form-control" name="txtImg" id="txtImg">
                </div>
                <br>
                <div class="d-grid gap-2 d-md-block " role="group" aria-label="Basic example">
                    
                    <button type="submit" name="accion" value="Agregar"<?php echo ($accion == 'Seleccionar')?"disabled":"";?> class="btn btn-success">Agregar</button>
                    <button type="submit" name="accion" value="Modificar" <?php echo ($accion != 'Seleccionar')?"disabled":"";?> class="btn btn-warning">Modificar</button>
                    <button type="submit" name="accion" value="Cancelar" <?php echo ($accion != 'Seleccionar')?"disabled":"";?> class="btn btn-info">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="col-md-8">

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre del Libro</th>
                <th>Imagen</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($listaLibros as $libro) { ?>
                <tr>
                    <td><?php echo $libro['id'] ?></td>
                    <td><?php echo $libro['nombre'] ?></td>
                    <td>
                        <img class="img-thumbnail rounded-1" src="../../img/<?php echo $libro['img'] ?>"  width="50" alt="">
                        
                    </td>
                    <td>
                        <form method="post">
                            
                            <input type="hidden" name="txtID" id="txtID" value="<?php echo $libro['id'] ?>" />
                            <input type="submit" name="accion" value="Seleccionar" class="btn btn-warning" />
                            <input type="submit" name="accion" value="Borrar" class="btn btn-danger" />
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<?php include("../template/pie.php"); ?>