<?php include("./template/cabecera.php");?>
<?php
 include("administrador/config/db.php");

//Llenar la tabla de presentacion 
$sentenciaSQL = $conexion->prepare('SELECT * FROM libros');
$sentenciaSQL->execute();
$listaLibros = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
?>
<?php  foreach ($listaLibros as  $libro) {?>
<div class="col-md-3">
 <div class="card-group">
    <div class="card">        
        <img class="card-img-top" src="./img/<?php echo $libro['img'] ?>" alt="">
        <div class="card-body">
            <h4 class="card-title"><?php echo $libro['nombre'] ?></h4>
            <button type="button" name="" id="" class="btn btn-primary" btn-lg btn-block">Ver más</button>
        </div>
    </div>   
 </div>   
</div>
<?php }?>


<?php include("./template/pie.php");?>