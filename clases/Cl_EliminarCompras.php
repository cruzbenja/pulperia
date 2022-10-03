<?php

session_start();
include("conexion.php");

$tipo = $_GET["op"];
$idUsuario = $_SESSION['id'];
  
    if($tipo == "EliminarCompras"){

        $idCompra = $_POST['idCompra'];
        $motivo = $_POST['motivo'];

            $consultar = "SELECT * FROM comprasDetalle where idCompras = $idCompra";               
            $resultado1 = mysqli_query($conectar, $consultar);


            if($resultado1){

                $actualizar = "UPDATE compras set motivoEliminacion = '$motivo', estado = 'Eliminado', idUsuario1 = $idUsuario, fechaEliminacion = sysdate() where id = $idCompra";               
                $resultado2 = mysqli_query($conectar, $actualizar);

                if ($resultado2) {
                    while ($listado = mysqli_fetch_array($resultado1)) {

                          //obtiene el idProducto
                          $consulta3 = "SELECT idProducto FROM lote where id = " . $listado['lote'] . "";
                          $resultado3 = mysqli_query($conectar, $consulta3);
                          $row1 = $resultado3->fetch_assoc();
                          $idProducto = $row1['idProducto'];
  

                         //obtiene el ultimo stock del Producto en el kardex
                        $consulta4 = "SELECT * FROM kardex where idLote = " . $listado['lote'] . " order by id desc limit 1";
                        $resultado4 = mysqli_query($conectar, $consulta4);
                        $row2 = $resultado4->fetch_assoc();
                        $stockKardex = $row2['stock'];
                        $totalDevolucion = $stockKardex - $listado['cantidad'];

                            //registra en el kardex
                            $insertarKardex = "INSERT INTO kardex values(null," . $listado['lote'] . ",$idProducto,sysdate(),0,".$listado['cantidad'].",$totalDevolucion,'Salida por eliminación de la compra N° $idCompra')";
                            $resultado5 = mysqli_query($conectar, $insertarKardex);

                            //actualizar en el lote
                            $actualizarLote = "UPDATE lote SET stock = stock - ".$listado['cantidad']." where id = ".$listado['lote']."";
                            $resultado6 = mysqli_query($conectar, $actualizarLote);
                    }
                    echo  "1";   
                }
                else{
                    echo "3";
                }
               
            }
            else{
                echo "2";
            }
        
    }
    

    if($tipo == "MotivoEliminacion"){

        $idCompra = $_POST["idCompra"];
        
            $consultar = "SELECT * FROM compras where id = $idCompra";               
            $resultado = mysqli_query($conectar, $consultar);  
            $row = $resultado->fetch_assoc();
            $motivo = $row['motivoEliminacion'];

        if($resultado){
            echo $motivo;
        }
        else{
            echo 'error';
        }

    }


    if($tipo == "VerUsuario"){

        $idCompra = $_POST["idCompra"];
        
            $consultar = "SELECT u.usuario FROM compras as c left join usuario as u on u.id = c.idUsuario where c.id = $idCompra";               
            $resultado = mysqli_query($conectar, $consultar);  
            $row = $resultado->fetch_assoc();
            $Usuario = $row['usuario'];

        if($resultado){
            echo $Usuario;
        }
        else{
            echo 'error';
        }

    }


    if($tipo == "DetalleCompra"){


            $idCompra = $_POST['idCompra'];
    
                $consultar = "SELECT c.id as idCompras, u.usuario,c.fecha as fechaCompra,pro.proveedor,c.totalCompra, cd.lote,lo.vencimiento as fechaVencimiento,
                p.nombre as producto,p.unidad,cd.cantidad,cd.precioUnitario as precioCompra,cd.porcentajeGanancia,l.laboratorio,pr.presentacion,lo.vencimiento,cd.subtotal FROM compras as c 
                LEFT join comprasDetalle as cd on cd.idCompras = c.id 
                left join usuario as u on u.id = c.idUsuario 
                left join proveedor as pro on pro.id = c.idProveedor 
                LEFT JOIN producto as p on p.id = cd.idProducto 
                LEFT JOIN laboratorio as l on l.id = p.idLaboratorio 
                LEFT JOIN presentacion as pr on pr.id = p.idPresentacion 
                LEFT join lote as lo on lo.id = cd.lote 
                where c.id = $idCompra";               
                $resultado1 = mysqli_query($conectar, $consultar);  
    
                if($resultado1){
    
                    $tabla = "";
                    $tabla .= '<table id="example2" class="table table-bordered table-striped"  method="POST">
                                <thead>
                                    <tr>          
                                        <th>N° Lote</th>                                 
                                        <th>Vencimiento</th>
                                        <th>Producto</th>
                                        <th>Laboratorio</th>
                                        <th>Cantidad</th>
                                        <th>Precio</th>
                                        <th>Ganancia</th>
                                        <th>Total</th>                
                                    </tr>
                                </thead>
                                <tbody > ';
                            
                    $cont = 0;
                    if ($resultado1) {
                        while ($listado = mysqli_fetch_array($resultado1)) {
                            $tabla .= "<tr>";
                            $tabla .= "<td data-title=''>" . $listado['lote'] . "</td>";
                            $tabla .= "<td data-title=''>" . $listado['fechaVencimiento'] . "</td>";
                            $tabla .= "<td data-title=''>" . $listado['producto'] . " " . $listado['unidad'] . "</td>";
                            $tabla .= "<td data-title=''>" . $listado['laboratorio'] . "</td>";
                            $tabla .= "<td data-title=''>" . $listado['cantidad'] . "</td>";
                            $tabla .= "<td data-title=''>" . $listado['precioCompra'] . "</td>";
                            $tabla .= "<td data-title=''>" . $listado['porcentajeGanancia'] . " %</td>";
                            $tabla .= "<td data-title=''>" . $listado['subtotal'] . "</td>";
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


    
       