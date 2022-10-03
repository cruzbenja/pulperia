<?php

include("conexion.php");

$tipo = $_GET["op"];

if($tipo=="RegistrarCategoria"){

    $nombre = $_POST["nombre"];
    $status = "Habilitado";

        $insertar = "INSERT INTO categoria VALUES(null,'$nombre')";
        $resultado2 = mysqli_query($conectar, $insertar);   

        if ($resultado2) {
            echo '1';
        } 
        else {
            echo '2';
        }
}




if($tipo=="editarCategoria"){

    $nombre = $_POST["nombre"];
    $id = $_POST['id'];

        $insertar = "UPDATE categoria SET nombre = '$nombre' where id= '$id'";

        $resultado2 = mysqli_query($conectar, $insertar);   

        if ($resultado2) {
            echo '1';
        } 
        else {
            echo '2';
        }
    
       
}

 






