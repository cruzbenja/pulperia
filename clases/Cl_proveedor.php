<?php

include("conexion.php");

$tipo = $_GET["op"];

if($tipo=="RegistrarProveedor"){

    $nombre = $_POST["nombre"];
    $telefono = $_POST["telefono"];
    $correo = $_POST["correo"];
    $direccion = $_POST["direccion"];
  

        $insertar = "INSERT INTO proveedor VALUES(null,'$nombre','$telefono','$correo','$direccion')";
        $resultado2 = mysqli_query($conectar, $insertar);   

        if ($resultado2) {
            echo '1';
        } 
        else {
            echo '2';
        }
}




if($tipo=="editarProveedor"){

    $nombre = $_POST["nombre"];
    $telefono = $_POST["telefono"];
    $correo = $_POST["correo"];
    $direccion = $_POST["direccion"];
    $id = $_POST['id'];

        $insertar = "UPDATE proveedor SET empre = '$nombre',telefono = '$telefono',correo = '$correo',direccion = '$direccion' where id= '$id'";

        $resultado2 = mysqli_query($conectar, $insertar);   

        if ($resultado2) {
            echo '1';
        } 
        else {
            echo '2';
        }
    
       
}


       






