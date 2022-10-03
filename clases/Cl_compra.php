<?php

session_start();
include("conexion.php");

$tipo = $_GET["op"];
$idUsuario = $_SESSION['id'];


if($tipo=="RegistrarCompra"){

    $idCompra = $_POST["idCompra"];
    $fecha =$_POST["fecha"];
    $idProveedor = $_POST["idProveedor"];
    $totalCompra = $_POST["totalCompra"];
    

    $idProducto = $_POST["idProducto"];
    $cantidad = $_POST["cantidad"];
    $precioCompra = $_POST["precioCompra"];
    $ganancia = $_POST["ganancia"];
    $precioVenta = $_POST["precioVenta"];
    $subtotal =$_POST["subtotal"];
    $lote = $_POST["lote"];
    $fechaVencimiento = $_POST["fechaVencimiento"];

    $array_idProducto = explode(",",$idProducto);
    $array_lote = explode(",",$lote);
    $array_vencimiento = explode(",",$fechaVencimiento);
    $array_cantidad = explode(",",$cantidad);
    $array_precioCompra = explode(",",$precioCompra);
    $array_ganancia = explode(",",$ganancia);
    $array_precioVenta = explode(",",$precioVenta);
    $array_subtotal = explode(",",$subtotal);
    

        $insertar = "INSERT INTO compras VALUES($idCompra,$idUsuario,'$fecha',$idProveedor,$totalCompra,'Habilitado',null,null,null)";
        $resultado = mysqli_query($conectar, $insertar);
        
        if($resultado){
            /*$consulta = "SELECT * FROM compras order by id desc  limit 1";
            $resultado2 = mysqli_query($conectar, $consulta);
            $row1 = $resultado2->fetch_assoc();
            $idCompra2 = $row1['id']; */
    
            $resultado7= "";
            $insertarKardex = "";
            for ($i=0; $i < count($array_idProducto); $i++) { 
                //registra el detalle de los productos de la compra
                $insertarDetalle = "INSERT INTO comprasDetalle values(null,$idCompra,$array_idProducto[$i],$array_lote[$i],$array_cantidad[$i],$array_precioCompra[$i],$array_ganancia[$i],$array_precioVenta[$i],$array_subtotal[$i],'Habilitado')";
                $resultado3 = mysqli_query($conectar, $insertarDetalle);

                //registra el lote de la respectiva compra
                $insertLote = "INSERT INTO lote VALUES($array_lote[$i],$array_cantidad[$i],'$array_vencimiento[$i]',$array_idProducto[$i],$idProveedor,$array_precioVenta[$i],'Habilitado')";
                $resultado4 = mysqli_query($conectar, $insertLote);

                   //obtiene el ultimo stock del idProducto buscado
                   $consulta2 = "SELECT * FROM kardex where idLote = $array_lote[$i] order by id desc limit 1";
                   $resultado6 = mysqli_query($conectar, $consulta2);
                   $row2 = $resultado6->fetch_assoc();
                   $stock = $row2['stock'];
                   $totalCompra= $stock + $array_cantidad[$i];
   
                       //registra en el kardex
                       $insertarKardex = "INSERT INTO kardex values(null,$array_lote[$i],$array_idProducto[$i],'$fecha',$array_cantidad[$i],0,$totalCompra,'Ingreso por compra N° $idCompra')";
                       $resultado7 = mysqli_query($conectar, $insertarKardex);
                           
            }
    

            if($resultado7){
                echo '1';
            }
            else{
                echo '2';
            }
           
        }
        else{
            echo '3';
        }
    }  
    
    
    if($tipo=="obtenerIdCompra"){

        $consulta = "SELECT * FROM compras order by id desc limit 1";
        $resultado2 = mysqli_query($conectar, $consulta);
        $row1 = $resultado2->fetch_assoc();
        $idCompra2 = $row1['id']; 

        echo $idCompra2;
    }

    if($tipo=="ValidarLote"){

        $lote = $_POST['lote'];

        $consulta = "SELECT * FROM lote where id = $lote";
        $resultado2 = mysqli_query($conectar, $consulta);
        $row1 = mysqli_num_rows($resultado2);

        echo $row1;
    }
       
    
    if($tipo == "filtrarFechas"){

        $fechaInicio = $_POST['fechaInicio'];
        $fechaFinal = $_POST['fechaFinal'];

            $consultar = "SELECT c.id as idCompras, u.usuario,c.fecha as fechaCompra,pro.proveedor,c.totalCompra, cd.lote,lo.vencimiento as fechaVencimiento,
                p.nombre as producto,p.unidad,cd.cantidad,cd.precioUnitario as precioCompra,cd.porcentajeGanancia,l.laboratorio,
                pr.presentacion,lo.vencimiento FROM compras as c 
                LEFT join comprasDetalle as cd on cd.idCompras = c.id 
                left join usuario as u on u.id = c.idUsuario 
                left join proveedor as pro on pro.id = c.idProveedor 
                LEFT JOIN producto as p on p.id = cd.idProducto 
                LEFT JOIN laboratorio as l on l.id = p.idLaboratorio 
                LEFT JOIN presentacion as pr on pr.id = p.idPresentacion 
                LEFT join lote as lo on lo.id = cd.lote 
                where c.estado = 'Habilitado' and c.fecha BETWEEN '$fechaInicio' and '$fechaFinal'";               
            $resultado1 = mysqli_query($conectar, $consultar);


            if($resultado1){

                $tabla = "";
                $tabla .= '<table id="example1" class="table table-bordered table-striped"  method="POST">
                            <thead>
                                <tr>
                                    <th>N° Compra</th> 
                                    <th>N° Lote</th>                  
                                    <th>Fecha Compra</th>                  
                                    <th>Fecha Vencimiento</th>
                                    <th>Nombre Producto</th>
                                    <th>Nombre Laboratorio</th>
                                    <th>Tipo de Presentación</th>
                                    <th>Cantidad Comprada</th>
                                    <th>Precio Compra</th>
                                    <th>% de Ganancia</th> 
                                    <th>Total Compra</th>
                                    <th>Proveedor</th>
                                    <th>Usuario</th>                           
                                </tr>
                            </thead>
                            <tbody > ';
            
            
                $cont = 0;
                if ($resultado1) {
                    while ($listado = mysqli_fetch_array($resultado1)) {
            

                        $tabla .= "<tr>";
                        $tabla .= "<td data-title=''>" . $listado['idCompras'] . "</td>";
                        $tabla .= "<td data-title=''>" . $listado['lote'] . "</td>";
                        $tabla .= "<td data-title=''>" . $listado['fechaCompra'] . "</td>";
                        $tabla .= "<td data-title=''>" . $listado['fechaVencimiento'] . "</td>";
                        $tabla .= "<td data-title=''>" . $listado['producto'] . " " . $listado['unidad'] . "</td>";
                        $tabla .= "<td data-title=''>" . $listado['laboratorio'] . "</td>";
                        $tabla .= "<td data-title=''>" . $listado['presentacion'] . "</td>";
                        $tabla .= "<td data-title=''>" . $listado['cantidad'] . "</td>";
                        $tabla .= "<td data-title=''>" . $listado['precioCompra'] . "</td>";
                        $tabla .= "<td data-title=''>" . $listado['porcentajeGanancia'] . "</td>";
                        $tabla .= "<td data-title=''>" . $listado['totalCompra'] . "</td>";
                        $tabla .= "<td data-title=''>" . $listado['proveedor'] . "</td>";
                        $tabla .= "<td data-title=''>" . $listado['usuario'] . "</td>";
                       
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
