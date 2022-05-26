
<?php
include("../administrador/config/db.php");
session_start();
$txtusuario = (isset($_POST['usuario'])) ? $_POST['usuario'] : "";
$txtcontrasenia = (isset($_POST['contrasenia'])) ? $_POST['contrasenia'] : "";

$sentenciaSQL = $conexion->prepare('SELECT usuario, pass FROM cuenta WHERE usuario=:usuario AND pass =:pass ;');
$sentenciaSQL->bindParam(':usuario', $txtusuario);
$sentenciaSQL->bindParam(':pass', $txtcontrasenia);
$sentenciaSQL->execute();
$Lista = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
foreach ($Lista as  $value) {
     $listusuario =   $value['usuario'];
     $listpass =   $value['pass'];
}

if($_POST){
    if(($_POST['usuario']==$listusuario)&&($_POST['contrasenia']==$listpass)){
        $_SESSION['usuario']="ok";
        $_SESSION['nombreUsuario']=$listusuario;
        header('Location:inicio.php');
    }else{
        $mess = "Error: El Usuario o Contraseña incorrectos..";
        
    }

}
   
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <div class="row">
    <div class="col-md-4">
    </div>
        <div class="col-md-4">
            <br><br><br>
            <div class="card border-2 rounded-2" style="width: 18rem;">
           

                <div class="card-body ">
                <img src="../img/avatar.png" class="rounded mx-auto d-block" width="180px" alt="...">

              
                    <form method="POST">
                    <div class = "form-group">
                    <label for="exampleInputEmail1">Usuario</label>
                    <input type="text" class="form-control" name="usuario"  placeholder="Ingresar Usuario">
                    </div>
                    <div class="form-group">
                    <label for="exampleInputPassword1">Contraseña</label>
                    <input type="password" class="form-control" name="contrasenia"  placeholder="Ingresar Contraseña">
                    </div>
                    <br>
                    <a href="crearUsuarios.php">Crear Usuario</a>
                    <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary rounded-2">Iniciar</button>
                    <?php  if(isset($mess)){?>
                             <div class="alert alert-danger" role="alert">
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