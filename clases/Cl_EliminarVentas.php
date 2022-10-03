<?php

session_start();
include("conexion.php");

$tipo = $_GET["op"];
$idUsuario = $_SESSION['id'];

    if($tipo == "EliminarVentas"){

        $idVenta = $_POST['idVenta'];
        $motivo = $_POST['motivo'];

            $consultar = "SELECT * FROM ventaproducto where idVenta = $idVenta";               
            $resultado1 = mysqli_query($conectar, $consultar);

            if($resultado1){

                $actualizar = "UPDATE venta set motivoEliminacion = '$motivo', estado = 'Eliminado', idUsuario1 = $idUsuario, fechaEliminacion = sysdate() where id = $idVenta";               
                $resultado2 = mysqli_query($conectar, $actualizar);

                if ($resultado2) {
                    while ($listado = mysqli_fetch_array($resultado1)) {

                          //obtiene el idProducto
                          $consulta3 = "SELECT idProducto FROM lote where id = " . $listado['idLote'] . "";
                          $resultado3 = mysqli_query($conectar, $consulta3);
                          $row1 = $resultado3->fetch_assoc();
                          $idProducto = $row1['idProducto'];
  

                         //obtiene el ultimo stock del Producto en el kardex
                        $consulta4 = "SELECT * FROM kardex where idLote = " . $listado['idLote'] . " order by id desc limit 1";
                        $resultado4 = mysqli_query($conectar, $consulta4);
                        $row2 = $resultado4->fetch_assoc();
                        $stockKardex = $row2['stock'];
                        $totalDevolucion = $stockKardex + $listado['cantidad'];

                            //registra en el kardex
                            $insertarKardex = "INSERT INTO kardex values(null," . $listado['idLote'] . ",$idProducto,sysdate(),".$listado['cantidad'].",0,$totalDevolucion,'Ingreso por eliminación de la venta N° $idVenta')";
                            $resultado5 = mysqli_query($conectar, $insertarKardex);

                            //actualizar en el lote
                            $actualizarLote = "UPDATE lote SET stock = stock + ".$listado['cantidad']." where id = ".$listado['idLote']."";
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

    if($tipo == "DetalleVenta"){


            $idVenta = $_POST['idVenta'];
    
                $consultar = "SELECT v.id,v.fecha,v.cliente,p.nombre as producto,la.laboratorio,pr.presentacion,p.unidad,l.precioVenta,vp.cantidad,
                vp.subtotal,v.total,u.usuario,vp.idLote FROM venta as v 
                LEFT join ventaproducto as vp on vp.idVenta = v.id
                left join lote as l on l.id = vp.idLote
                left join producto as p on p.id = l.idProducto
                left join laboratorio as la on la.id = p.idLaboratorio
                left join presentacion as pr on pr.id = p.idPresentacion
                left join usuario as u on u.id = v.idUsuario
                where v.id = $idVenta";               
                $resultado1 = mysqli_query($conectar, $consultar);
    
    
                if($resultado1){
    
                    $tabla = "";
                    $tabla .= '<table id="example2" class="table table-bordered table-striped"  method="POST">
                                <thead>
                                    <tr>          
                                        <th>Lote</th>       
                                        <th>Producto</th>
                                        <th>Laboratorio</th>
                                        <th>Cant.</th>
                                        <th>Precio</th>
                                        <th>SubTotal</th> 	                
                                    </tr>
                                </thead>
                                <tbody > ';
                            
                    $cont = 0;
                    if ($resultado1) {
                        while ($listado = mysqli_fetch_array($resultado1)) {
                            $tabla .= "<tr>";
                            $tabla .= "<td data-title=''>" . $listado['idLote'] . "</td>";
                            $tabla .= "<td data-title=''>" . $listado['producto'] . " " . $listado['unidad'] . "</td>";
                            $tabla .= "<td data-title=''>" . $listado['laboratorio'] . "</td>";
                            $tabla .= "<td data-title=''>" . $listado['cantidad'] . "</td>";
                            $tabla .= "<td data-title=''>" . $listado['precioVenta'] . "</td>";
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

    if($tipo == "MotivoEliminacion"){

        $idVenta = $_POST["idVenta"];
        
            $consultar = "SELECT * FROM venta where id = $idVenta";               
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

    if($tipo == "verUsuario"){

        $idVenta = $_POST["idVenta"];
        
            $consultar = "SELECT u.usuario FROM venta as v 
                        LEFT JOIN usuario as u on u.id = v.idUsuario
                        where v.id = $idVenta";               
            $resultado = mysqli_query($conectar, $consultar);  
            $row = $resultado->fetch_assoc();
            $usuario = $row['usuario'];

        if($resultado){
            echo $usuario;
        }
        else{
            echo 'error';
        }

    }
    
       