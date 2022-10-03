<?php

include("conexion.php");

$tipo = $_GET["op"];

if($tipo=="RegistrarPresentacion"){

    $nombre = $_POST["nombre"];
    $status = "Habilitado";

        $insertar = "INSERT INTO presentacion VALUES(null,'$nombre','$status')";
        $resultado2 = mysqli_query($conectar, $insertar);   

        if ($resultado2) {
            echo '1';
        } 
        else {
            echo '2';
        }
}




if($tipo=="editarPresentacion"){

    $nombre = $_POST["nombre"];
    $id = $_POST['id'];

        $insertar = "UPDATE presentacion SET presentacion = '$nombre' where id= $id";

        $resultado2 = mysqli_query($conectar, $insertar);   

        if ($resultado2) {
            echo '1';
        } 
        else {
            echo '2';
        }
    
       
}

if($tipo=="EliminarPresentacion"){

    $id = $_POST['id'];
    $status = $_POST['estado'];

        $insertar = "UPDATE presentacion SET estado = '$status' where id= $id";
        $resultado2 = mysqli_query($conectar, $insertar);   

        if ($resultado2) {
            echo '1';
        } 
        else {
            echo '2';
        }
    
       
}






