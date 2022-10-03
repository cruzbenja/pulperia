<?php

include("conexion.php");

$tipo = $_GET["op"];

if($tipo=="RegistrarEmpleado"){

            $nombre = $_POST["nomb"];
            $fecha = $_POST["fecha"];
            $telefono = $_POST["tele"];
            $dire = $_POST["dir"];
            $carnet = $_POST["ci"];

        $insertar = "INSERT INTO personal VALUES(NULL,'$nombre','$fecha','$telefono','$dire','$carnet')";
        $resultado2 = mysqli_query($conectar, $insertar);   

        if ($resultado2) {
            echo '1';
        } 
        else {
            echo '2';
        }
}


if($tipo=="editarEmpleado"){

    $id = $_POST['id'];
    $nombre = $_POST["name"];
    $fecha = $_POST["fec"];
     $telefono = $_POST["te"];       
    $dire = $_POST["di"];
     $ci = $_POST["cin"];

     $insertar = "UPDATE personal SET nombre='$nombre', fecha_nac='$fecha', telefono='$telefono', direccion='$dire',ci='$ci' where id= '$id'";
        $resultado = mysqli_query($conectar, $insertar);   

        if ($resultado) {
            echo '1';
        } 
        else {
            echo '2';
        }
}

if($tipo=="EliminarEmpleado"){

    $id = $_POST['id1'];

    $insertar = "DELETE FROM personal where id =$id";
        $resultado2 = mysqli_query($conectar, $insertar);

        if ($resultado2) {
            echo '1';
        } 
        else {
            echo '2';
        }
    
       
}

 