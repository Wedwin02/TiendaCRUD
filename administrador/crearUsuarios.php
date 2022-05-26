<?php

$txtID = (isset($_POST['txtID'])) ? $_POST['txtID'] : "";
$txtNombres = (isset($_POST['txtNombres'])) ? $_POST['txtNombres'] : "";
$txtApellidos = (isset($_POST['txtApellidos'])) ? $_POST['txtApellidos'] : "";
$txtEmail = (isset($_POST['txtEmail'])) ? $_POST['txtEmail'] : "";
$txtUsuario = (isset($_POST['txtUsuario'])) ? $_POST['txtUsuario'] : "";
$txtPass = (isset($_POST['txtPass'])) ? $_POST['txtPass'] : "";
$accion = (isset($_POST['accion'])) ? $_POST['accion'] : "";
include('./config/db.php');
switch ($accion) {
    case 'Agregar':
        # code...
        #Se ingresa primero el Usuario y contraseña 
        $sentenciaSQL = $conexion->prepare("INSERT INTO cuenta (usuario,pass) VALUES (:usuario,:pass);");
        $sentenciaSQL->bindParam(':usuario', $txtUsuario);
        $sentenciaSQL->bindParam(':pass', $txtPass);
        $sentenciaSQL->execute();

        $sentenciaSQL = $conexion->prepare('SELECT idUsuario FROM cuenta ORDER BY cuenta.idUsuario DESC LIMIT 1;');
        $sentenciaSQL->execute();
        $Lista = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
         foreach ($Lista as  $value) {
             $idUsuario =   $value['idUsuario'];
         }
         

        if( isset($idUsuario)){
               #Crear Datos personales 
            $sentenciaSQL = $conexion->prepare("INSERT INTO datospersonales (nombres,apellidos,email,idUsuario) VALUES (:nombres,:apellidos,:email,:idUsuario);");
            $sentenciaSQL->bindParam(':nombres', $txtNombres);
            $sentenciaSQL->bindParam(':apellidos', $txtApellidos);
            $sentenciaSQL->bindParam(':email', $txtEmail);
            $sentenciaSQL->bindParam(':idUsuario', $idUsuario);
            $sentenciaSQL->execute();
            $mess = "Regitro creado con exito";
        }else{
            $mess = "Error";
        }
  
        header("Location:index.php");
        break;
    
    default:
        # code...
        break;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <title>Crear Usuario</title>
</head>
<body>
    
<div class="container">
    <div class="row">
    <div class="col-md-4">
    </div>
        <div class="col-md-4">
        <br><br><br><br>
    
        <div class="card">
            
            <div class="card-body">
                 <form method="POST">
                     <input type="text"  name="txtID" hidden>
                    <div class = "form-group">
                    <label for="exampleInputEmail1">Nombres</label>
                    <input type="text" class="form-control" name="txtNombres"  placeholder="Ingresar Nombres">
                    </div>
                    <div class = "form-group">
                    <label for="exampleInputEmail1">Apellidos</label>
                    <input type="text" class="form-control" name="txtApellidos"  placeholder="Ingresar Apellidos">
                    </div>
                    <div class = "form-group">
                    <label for="exampleInputEmail1">Correo</label>
                    <input type="text" class="form-control" name="txtEmail"  placeholder="Ingresar Correo">
                    </div>
                    <div class = "form-group">
                    <label for="exampleInputEmail1">Nombre de Usuario</label>
                    <input type="text" class="form-control" name="txtUsuario"  placeholder="Ingresar Usuario">
                    </div>
                    <div class="form-group">
                    <label for="exampleInputPassword1">Contraseña</label>
                    <input type="password" class="form-control" name="txtPass"  placeholder="Ingresar Contraseña">
                    </div>
                    <br>
                    <div class="d-grid gap-2">
                    <button type="submit" name="accion" value="Agregar" class="btn btn-primary rounded-2">Crear</button>
                    <?php  if(isset($mess)){?>
                             <div class="alert alert-primary" role="alert">
                    <?php echo $mess?>                
                             </div>
                    <?php } ?>
                    </div>
                    </form>
             </div>
        </div>
        </div>
    </div>
</div>
    
</body>
</html>