<?php
session_start();


    include("conexion.php");

        $usuario = $_POST["user"];
        $password = $_POST["pass"];
        $sql="select u.id as id_usua,u.name as usuario,u.pass as contra,p.nombre as personal,r.id as rol,r.nombre as nombre_rol from usuario as u left join personal as p on p.id=u.per_id left join rol as r on r.id=u.rol_id where u.name='$usuario'";
 
        $resultado = mysqli_query($conectar,$sql);
        $num = $resultado->num_rows;

        if($num > 0){

            $row = $resultado->fetch_assoc();
            $password_bd = $row['contra'];  
            

            if($password_bd == $password){

                $_SESSION['id'] = $row['id_usua'];
                $_SESSION['usuario'] = $row['usuario'];     
                $_SESSION['password']  = $password_bd;
                $_SESSION['tipo_rol'] = $row['rol'];
                $_SESSION['nombre_rol'] = $row['nombre_rol'];
                $_SESSION['personal'] = $row['personal'];
                echo '1';
            }
            else{
               echo '2';
            }
        }
        else{
            //echo "El usuario no existe";
            echo '3';
        }

?>