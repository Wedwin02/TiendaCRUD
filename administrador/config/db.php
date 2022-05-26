<?php

$host = "localhost";
$bd = "sistemaweb";
$usuario = "root";
$pass = "";
try {
    //code...
    $conexion = new PDO("mysql:host=$host; dbname=$bd", $usuario, $pass);

} catch (Exception $ex) {
    //throw $th;
    echo $ex->getMessage();
}
?>