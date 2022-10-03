<?php

include("conexion.php");

$tipo = $_GET["op"];

if($tipo=="RegistrarProducto"){

            $catego = $_POST['cate'];
            $provee = $_POST["pro"];
            $present = $_POST["prese"];
            $codigo = $_POST["codi"];          
            $nombre = $_POST['nom'];
            $canti = $_POST["cant"];
            $precio = $_POST["pre"];
        

            $insertar = "INSERT INTO produco VALUES(NULL,'$catego','$provee','$codigo','$nombre','$canti','$present','$precio')";

        $resultado2 = mysqli_query($conectar, $insertar);   

        if ($resultado2) {
            echo '1';
        } 
        else {
            echo '2';
        }
}


if($tipo=="editarProducto"){

    // traendo  el id de la categoria
      $categoria = $_POST["cate"];
      $consulta="select * from categoria where nombre= '$categoria'";
      $resul=mysqli_query($conectar,$consulta);
      $row=$resul->fetch_assoc();
      $id_cate=$row['id'];

// traendo  el id de la proveedor
      $provee = $_POST["prove"];
     $consulta1="select * from proveedor where empre='$provee'";
     $resul1=mysqli_query($conectar, $consulta1);
     $row1=$resul1->fetch_assoc();
     $id_prove=$row1['id'];
  // traendo  el id de la presentacion
  $presenta = $_POST["presen"];
  $consulta2="select * from presentacion where nombre='$presenta'";
  $resul2=mysqli_query($conectar, $consulta2);
  $row2=$resul2->fetch_assoc();
  $id_prese= $row2['id'];
  ///////////////////////////////

        $id = $_POST['id'];      
        $codig = $_POST["codi"];
        $nombre = $_POST["name"]; 
        $cantidad = $_POST['cantid'];
        $precio = $_POST["preci"];
          
        $ActualizarProducto = "update produco set categoria_id='$id_cate', prove_id='$id_prove', codigo_pro='$codig', nombre='$nombre', cantidad='$cantidad', presenta_id='$id_prese', precio='$precio' where id = '$id'";
        $resultado = mysqli_query($conectar, $ActualizarProducto);   

        if ($resultado) {
            echo '1';
        } 
        else {
            echo '2';
        }
}

if($tipo=="EliminarProducto"){

    $id = $_POST['id'];
    $estado = $_POST['estado'];

        $insertar = "UPDATE producto set estado = '$estado' where id= $id";
        $resultado = mysqli_query($conectar, $insertar);   

        if ($resultado) {
            echo '1';
        } 
        else {
            echo '2';
        }     
}



if($tipo == "VerLotes"){

    $idProducto = $_POST['idProducto'];

    $consultar = "SELECT l.id,l.stock,l.vencimiento,DATEDIFF(l.vencimiento, curdate()) as dias FROM lote as l left join producto as p on p.id = l.idProducto where p.id = $idProducto and l.stock > 0 order by l.vencimiento asc";     
    $resultado1 = mysqli_query($conectar, $consultar);

    $tabla = "";
    $tabla .= '<table id="ejemplo" class="table table-striped table-valign-middle" method="POST">
                <thead>
                    <tr>
                        <th>#</th>
                        <th class="text-center">N° Lote</th>
                        <th class="text-center">stock</th>
                        <th class="text-center">Vencimiento</th>
                        <th class="text-center">Dias Restantes</th>               
                    </tr>
                </thead>
                <tbody > ';


    $cont = 0;
    if ($resultado1) {
        while ($listado = mysqli_fetch_array($resultado1)) {

            $cont++;
            $tabla .= "<tr>";
            $tabla .= "<td data-title=''>" . $cont . "</td>";
            $tabla .= "<td data-title=''>" . $listado['id'] . "</td>";
            $tabla .= "<td data-title=''>" . $listado['stock'] . "</td>";
            $tabla .= "<td data-title=''>" . $listado['vencimiento'] . "</td>";
            $tabla .= "<td data-title=''>" . $listado['dias'] . " dias</td>";
            $tabla .= "</td>";
            $tabla .= "</tr>";
        }
    }

    $tabla .= "</tbody>
            
            </table>";
    echo  $tabla;   
}



