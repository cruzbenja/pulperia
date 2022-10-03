<?php

session_start();
if (!isset($_SESSION['rol_id'])) {
    header("Location:../login.php");
} 
else{


    include("conexion.php");

    $tipo = $_GET["op"];

    if($tipo=="registrarcategoria"){

            $nombre = $_POST["nomb"];
       
            if($nombre  == ""){
                echo '2';
                return false;
            }
            else {
                    $insertar = "INSERT INTO categoria VALUES(null,'$nombre')";

                    $resultado2 = mysqli_query($conectar, $insertar);

                    if ($resultado2) {

                        echo '1';
                    } 
                  
                }
    }


    if($tipo=="ModificarCategoria"){

        $categoria = $_POST["name"];
        $id = $_POST['id'];
 
        if($categoria == ""){
            echo '3';
            return false;
        }
                 $insertar = "UPDATE categoria SET nombre='$categoria' where id=$id ";
 
                 $resultado2 = mysqli_query($conectar, $insertar);
 
                 if ($resultado2) {
 
                     echo '1';
                 } 
                 else {
                     echo $insertar;
                 }
    }
}

?>