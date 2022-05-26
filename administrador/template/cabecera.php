<?php 

session_start();
if(!isset($_SESSION['usuario'])){
    header("Location:../index.php");
}else{
    if($_SESSION['usuario']=='ok'){
        $nombreUsuario =$_SESSION['nombreUsuario'];
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
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    
</head>
<body>
    <?php $url="http://".$_SERVER['HTTP_HOST']."/phpmood" ?>
    <nav class="navbar navbar-expand navbar-dark bg-primary">
          
            <div class="container-fluid">
                <div class="nav navbar-nav">  
                    <a class="nav-item nav-link active" href="<?php echo $url;?>/administrador/inicio.php"><span>Administrador</span></a>
                    <a class="nav-item nav-link" href="<?php echo $url;?>/administrador/inicio.php">Inicio</a>
                    <a class="nav-item nav-link" href="<?php echo $url;?>/administrador/seccion/productos.php">Libros</a>
                    <a class="nav-item nav-link" href="<?php echo $url;?>">Ver Sitio web</a>
            
                   
                </div>
                <div class="d-grid d-md-flex justify-content-md-end">                        
                <a class="btn btn-primary disabled" href="">Bienvenido: <?php echo $nombreUsuario; ?></a>
                <a class="btn btn-outline-dark me-md-2  " type="button" href="<?php echo $url;?>/administrador/seccion/cerrar.php">Cerrar Sesion</a>
              </div>
       
             </div>
        
    </nav>
    <div class="container">
        <br>
        <div class="row">