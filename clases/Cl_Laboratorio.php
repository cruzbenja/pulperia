<?php

include("conexion.php");

$tipo = $_GET["op"];

if($tipo=="RegistrarLaboratorio"){

    $nombre = $_POST["nombre"];
    $status = "Habilitado";

        $insertar = "INSERT INTO laboratorio VALUES(null,'$nombre','$status')";
        $resultado2 = mysqli_query($conectar, $insertar);   

        if ($resultado2) {
            echo '1';
        } 
        else {
            echo '2';
        }
}




if($tipo=="editarLaboratorio"){

    $nombre = $_POST["nombre"];
    $id = $_POST['id'];

        $insertar = "UPDATE laboratorio SET laboratorio = '$nombre' where id= $id";

        $resultado2 = mysqli_query($conectar, $insertar);   

        if ($resultado2) {
            echo '1';
        } 
        else {
            echo '2';
        }
    
       
}

if($tipo=="EliminarLaboratorio"){

    $id = $_POST['id'];
    $status = $_POST['estado'];

        $insertar = "UPDATE laboratorio SET estado = '$status' where id= $id";
        $resultado2 = mysqli_query($conectar, $insertar);   

        if ($resultado2) {
            echo '1';
        } 
        else {
            echo '2';
        }
    
       
}