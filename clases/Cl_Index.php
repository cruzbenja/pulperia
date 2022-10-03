<?php

session_start();
include("conexion.php");

$tipo = $_GET["op"];



    if($tipo=="alertaVencimiento"){
        $nombreAlerta = $_POST["nombreAlerta"];
        $diasAlerta = $_POST["diasAlerta"];
        $id = $_POST['id'];


            $insertar = "UPDATE alertaVencimiento SET nombreAlerta = '$nombreAlerta', dias= $diasAlerta where id= $id";
            $resultado2 = mysqli_query($conectar, $insertar);   

            if ($resultado2) {
                echo '1';
            } 
            else {
                echo '2';
            }
    }

    if($tipo=="ProductosVencidos"){

        $consulta = "SELECT * from alertaVencimiento where id = 1";
        $ejecutar1 = mysqli_query($conectar, $consulta) or die(mysqli_error($conectar));
        $row1 = $ejecutar1->fetch_assoc();
        $dia = $row1['dias'];

       
          $consulta1 = "SELECT COUNT(l.vencimiento) as vencidos FROM lote as l
          left join producto as p on p.id = l.idProducto
          left join laboratorio as la on la.id = p.idLaboratorio
          where l.estado = 'Habilitado' and l.stock > 0 and DATEDIFF(l.vencimiento, curdate()) <= $dia";
          $ejecutar = mysqli_query($conectar, $consulta1);
          $row = $ejecutar->fetch_assoc();
          $vencidos = $row['vencidos'];

          if($ejecutar){
            echo $vencidos;
          }
          else{
            echo 'error';
          }
        
       
          
    }

    if($tipo=="ProductosPorVencer"){

                  $consulta = "SELECT * from alertaVencimiento where id = 2";
                  $ejecutar = mysqli_query($conectar, $consulta) or die(mysqli_error($conectar));
                  $row = $ejecutar->fetch_assoc();
                  $dia2 = $row['dias'];

                  $consulta2 = "SELECT * from alertaVencimiento where id = 1";
                  $ejecutar2 = mysqli_query($conectar, $consulta2) or die(mysqli_error($conectar));
                  $row2 = $ejecutar2->fetch_assoc();
                  $dia = $row2['dias'];

                  $consulta3 = "SELECT COUNT(l.vencimiento) as vencidos FROM lote as l
                  left join producto as p on p.id = l.idProducto
                  left join laboratorio as la on la.id = p.idLaboratorio
                  where l.estado = 'Habilitado' and l.stock > 0 and DATEDIFF(l.vencimiento, curdate()) > $dia and DATEDIFF(l.vencimiento, curdate()) <= $dia2";
                  $ejecutar3 = mysqli_query($conectar, $consulta3) or die(mysqli_error($conectar));
                  $row3 = $ejecutar3->fetch_assoc();
                  $porVencer = $row3['vencidos'];

          if($ejecutar2){
            echo $porVencer;
          }
          else{
            echo 'error';
          }
    }

    if($tipo=="ProductoPromocion"){

        $consulta = "SELECT * from alertaVencimiento where id = 3";
        $ejecutar = mysqli_query($conectar, $consulta) or die(mysqli_error($conectar));
        $row = $ejecutar->fetch_assoc();
        $dia3 = $row['dias'];

        $consulta = "SELECT * from alertaVencimiento where id = 2";
        $ejecutar = mysqli_query($conectar, $consulta) or die(mysqli_error($conectar));
        $row = $ejecutar->fetch_assoc();
        $dia2 = $row['dias'];

        $consulta = "SELECT COUNT(l.vencimiento) as vencidos FROM lote as l
        left join producto as p on p.id = l.idProducto
        left join laboratorio as la on la.id = p.idLaboratorio
        where l.estado = 'Habilitado' and l.stock > 0 and DATEDIFF(l.vencimiento, curdate()) > $dia2 and DATEDIFF(l.vencimiento, curdate()) <= $dia3";
        $ejecutar = mysqli_query($conectar, $consulta) or die(mysqli_error($conectar));
        $row = $ejecutar->fetch_assoc();
        $promocion = $row['vencidos'];

          if($ejecutar){
            echo $promocion;
          }
          else{
            echo 'error';
          }
    }

    if($tipo=="ProductosBuenaFecha"){

        $consulta = "SELECT * from alertaVencimiento where id = 3";
        $ejecutar = mysqli_query($conectar, $consulta) or die(mysqli_error($conectar));
        $row = $ejecutar->fetch_assoc();
        $dia3 = $row['dias'];


        $consulta = "SELECT COUNT(l.vencimiento) as vencidos FROM lote as l
        left join producto as p on p.id = l.idProducto
        left join laboratorio as la on la.id = p.idLaboratorio
        where l.estado = 'Habilitado' and l.stock > 0 and DATEDIFF(l.vencimiento, curdate()) >= $dia3";
        $ejecutar = mysqli_query($conectar, $consulta) or die(mysqli_error($conectar));
        $row = $ejecutar->fetch_assoc();
        $buenaFecha = $row['vencidos'];

          if($ejecutar){
            echo $buenaFecha;
          }
          else{
            echo 'error';
          }
    }
       
