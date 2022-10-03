<?php

include("conexion.php");

$tipo = $_GET["op"];

if($tipo=="RegistrarRol"){

    $nombre = $_POST["nomb"];
         $usuario = $_POST["usu"];
            $pass = $_POST["contra"];
            $rol = $_POST["rol"];
//// trayendo el id delpersonal
            $consulta="select * from personal where nombre='$nombre'";
             $ejecutar=mysqli_query($conectar, $consulta);
             $row=$ejecutar->fetch_assoc();
             $id_persona=$row['id'];
            $insertar = "INSERT INTO usuario VALUES(NULL,'$usuario','$pass','$id_persona','$rol')";
        $resultado2 = mysqli_query($conectar, $insertar);   

        if ($resultado2) {
            echo '1';
        } 
        else {
            echo '2';
        }
}


if($tipo=="editarRol"){

    $id = $_POST['Id'];
    $usuario=$_POST['usu'];
     $contra = $_POST["con"];
     $perso=$_POST["per"];
      $rol = $_POST["rl"]; 
      
      $sql="select * from personal where nombre = '$perso'";
      $ejecutar=mysqli_query($conectar, $sql);
      $row= $ejecutar->fetch_assoc();
      $idper=$row['id'];
     

       
            $insertar = "UPDATE usuario SET name ='$usuario', pass='$contra', per_id ='$idper', rol_id ='$rol' where id= '$id'";
        $resultado = mysqli_query($conectar, $insertar);   

        if ($resultado) {
            echo '1';
        } 
        else {
            echo '2';
        }
}

if($tipo=="RegistrarPermiso"){

    $idArea = $_POST["idArea"];
    $idtipoUsuario = $_POST["idtipoUsuario"];
    
    $resultado2 = "";
    $acceso = "";
        $guardar = "SELECT * FROM permisosAreas where idTipousuario = $idtipoUsuario and idArea = $idArea";
        $resultado = mysqli_query($conectar, $guardar);   
        $row = $resultado->fetch_assoc();
        $id = $row['idTipousuario'];

        if($id == "" || $id == null){
            $guardar1 = "INSERT INTO permisosAreas  VALUES(null,$idtipoUsuario,$idArea,1)";
            $resultado2 = mysqli_query($conectar, $guardar1);  
        }
        else{

            $guardar1 = "SELECT * FROM permisosAreas where idTipousuario = $idtipoUsuario and idArea = $idArea";
            $resultado1 = mysqli_query($conectar, $guardar1);   
            $row1 = $resultado1->fetch_assoc();
            $acceso = $row1['accesos'];

            if($acceso == 1){
                $guardar2 = "UPDATE permisosAreas SET accesos = 0 where idTipousuario = $idtipoUsuario and idArea = $idArea";
                $resultado2 = mysqli_query($conectar, $guardar2);
            }
             else{
                $guardar2 = "UPDATE permisosAreas SET accesos = 1 where idTipousuario = $idtipoUsuario and idArea = $idArea";
                $resultado2 = mysqli_query($conectar, $guardar2);
             }
        }

        if ($resultado2) {
            echo '1';
        } 
        else {
            echo '2';
        }
}




if($tipo=="EliminarRol"){

    $id = $_POST['id'];
    $estado = $_POST['estado'];

        $insertar = "UPDATE tipousuario set estado = '$estado' where id= $id";
        $resultado2 = mysqli_query($conectar, $insertar);  
    
        if ($resultado2) {
            echo '1';
        } 
        else {
            echo '2';
        }     
}

if($tipo=="ObtenerRoles"){

    $idtipoUsuario = $_POST['idtipoUsuario'];

    $consultar = "SELECT id,area FROM areas where estado = 'Habilitado'";     
    $resultado1 = mysqli_query($conectar, $consultar);

    $tabla = "";
    $tabla .= '<table id="example2" class="table table-bordered table-striped"  method="POST">
                <thead>
                    <tr>
                        <th width="50px"></th>
                        <th>Áreas</th>        
                    </tr>
                </thead>
                <tbody > ';

    if ($resultado1) {
        while ($listado = mysqli_fetch_array($resultado1)) {

  
                $tabla .= "<tr>";
                $idArea = $listado['id'];
                $sql2 = "SELECT * FROM permisosAreas where idTipousuario = $idtipoUsuario and idArea = $idArea";
                $resultado2 = mysqli_query($conectar, $sql2);
                $row2 = $resultado2->fetch_assoc();
                $accesos = $row2['accesos'];

                if($accesos == 1){
                    $tabla .= "<td data-title='' onchange='guardarPermiso(".$listado['id'].")'><input class='check-input' type='checkbox' checked></td>";

                }
                else{
                    $tabla .= "<td data-title=''  onchange='guardarPermiso(".$listado['id'].")'><input class='check-input' type='checkbox'></td>";
                }
            
            $tabla .= "<td data-title=''>" . $listado['area'] . "</td>";
            $tabla .= "</td>";
            $tabla .= "</tr>";
        }
        $tabla .= "</tbody>
            
        </table>";
        echo  $tabla;   
    }
    else{
        echo 'error';
    }
}