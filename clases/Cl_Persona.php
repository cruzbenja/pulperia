<?php

include("conexion.php");

$tipo = $_GET["op"];

if($tipo=="RegistrarPersona"){

    $nombre = $_POST["nombre"];
    $apellidos = $_POST["apellidos"];
    $carnet = $_POST["carnet"];
    $telefono = $_POST["telefono"];
    $fecha = $_POST['fecha'];
    $miembrosFamilia = $_POST['miembrosFamilia'];
    $estado = "Activo";


    if($nombre == "" || $apellidos == "" || $carnet == "" || $telefono == "" || $fecha == "" || $miembrosFamilia == ""){
        echo '3';
    }

        $insertar = "INSERT INTO persona VALUES(null,'$nombre','$apellidos','$carnet',$telefono,'$fecha','$miembrosFamilia','$estado')";

        $resultado2 = mysqli_query($conectar, $insertar);   

        if ($resultado2) {
            echo '1';
        } 
        else {
            echo '2';
        }
}

if($tipo=="editarPersona"){

    $nombre = $_POST["nombre"];
    $apellidos = $_POST["apellidos"];
    $carnet = $_POST["carnet"];
    $telefono = $_POST["telefono"];
    $miembrosFamilia = $_POST['miembrosFamilia'];
    $id = $_POST['id'];

    if($nombre == "" || $apellidos == "" || $carnet == "" || $telefono == "" || $miembrosFamilia == ""){
        echo '3';
    }
    else{
        $insertar = "UPDATE persona SET nombre = '$nombre', apellidos= '$apellidos',carnet='$carnet',telefono='$telefono',miembrosFamilia=$miembrosFamilia where id= $id";
        $resultado2 = mysqli_query($conectar, $insertar);   

        if ($resultado2) {
            echo '1';
        } 
        else {
            echo '2';
        }
    }
       
}

if($tipo=="EliminarPersona"){

    $id = $_POST['id'];
    $status = "Inactivo";

        $insertar = "UPDATE persona SET estado = '$status' where id= $id";
        $resultado2 = mysqli_query($conectar, $insertar);   

        if ($resultado2) {
            echo '1';
        } 
        else {
            echo '2';
        }
    
       
}




