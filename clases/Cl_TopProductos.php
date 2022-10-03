<?php  

session_start();
include("conexion.php");

$tipo = $_GET["op"];
$idUsuario = $_SESSION['id'];

if($tipo == "topProductos"){

    $Mes = $_POST['mes'];

        $consultar = "SELECT p.nombre,p.unidad,sum(vp.cantidad) as cantidad,sum(vp.subtotal) as total FROM ventaproducto as vp 
        left join lote as l on l.id = vp.idLote
        LEFT join producto as p on p.id = l.idProducto  
        left join venta as v on v.id = vp.idVenta
        where month(v.fecha) = $Mes and v.estado = 'Habilitado'
        group by p.nombre,p.unidad
         order by cantidad desc
         limit 10";               
        $resultado1 = mysqli_query($conectar, $consultar);


        if($resultado1){

            $tabla = "";
            $tabla .= '<table id="example1" class="table table-bordered table-striped"  method="POST">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Producto</th>
                                <th>Medida</th>
                                <th>Cantidad</th>
                                <th>Total</th>              
                            </tr>
                        </thead>
                        <tbody > ';
        
        
            $cont = 0;
            if ($resultado1) {
                while ($listado = mysqli_fetch_array($resultado1)) {
        
                    $cont++;
                    $tabla .= "<tr>";
                    $tabla .= "<td data-title=''>$cont </td>";
                    $tabla .= "<td data-title=''>" . $listado['nombre'] . "</td>";
                    $tabla .= "<td data-title=''>" . $listado['unidad'] . "</td>";
                    $tabla .= "<td data-title=''>" . $listado['cantidad'] . "</td>";
                    $tabla .= "<td data-title=''>" . $listado['total'] . "</td>";               
                    $tabla .= "</td>";
                    $tabla .= "</tr>";
                }
            }
        
            $tabla .= "</tbody>
                    
                    </table>";
            echo  $tabla;   
        }
        else{
            echo "2";
        }
    
}


if($tipo=="TotalIngresos"){

    $mes = $_POST['mes'];
    $condicion = "";

    if($mes != "" || $mes != null){
        $condicion = "and month(v.fecha) = $mes";
    }

    $consulta = "SELECT sum(vp.subtotal) as subtotal FROM ventaproducto as vp 
                    left join venta as v on v.id = vp.idVenta
                    where v.estado = 'Habilitado' $condicion";
    $resultado2 = mysqli_query($conectar, $consulta);
    $row1 = $resultado2->fetch_assoc();
    $subtotal = $row1['subtotal']; 

    if($resultado2){
        echo $subtotal;
    }
    else{
        echo 'error';
    }
}


if($tipo=="ProductoVendidos"){

    $mes = $_POST['mes'];
    $condicion = "";

    if($mes != "" || $mes != null){
        $condicion = "and month(v.fecha) = $mes";
    }

    $consulta = "SELECT sum(vp.cantidad) as cantidad FROM ventaproducto as vp 
    left join venta as v on v.id = vp.idVenta
    where v.estado = 'Habilitado' $condicion";
    $resultado2 = mysqli_query($conectar, $consulta);
    $row1 = $resultado2->fetch_assoc();
    $cantidad = $row1['cantidad']; 

    if($resultado2){
        echo $cantidad;
    }
    else{
        echo 'error';
    }
}


if($tipo=="VentasPorUsuario"){

    $mes = $_POST['mes'];
    $condicion = "";

    if($mes != "" || $mes != null){
        $condicion = "and month(v.fecha) = $mes";
    }

    $consulta = "SELECT COUNT(v.idUsuario) as usuario FROM venta as v 
                    where v.estado = 'Habilitado'  and v.idUsuario = $idUsuario $condicion";
    $resultado2 = mysqli_query($conectar, $consulta);
    $row1 = $resultado2->fetch_assoc();
    $usuario = $row1['usuario']; 

    if($resultado2){
        echo $usuario;
    }
    else{
        echo 'error';
    }
    
}