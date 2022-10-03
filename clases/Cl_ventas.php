<?php
session_start();
include("conexion.php");

$tipo = $_GET["op"];
$id = $_SESSION['id'];

if($tipo=="Registrarventa"){

    $idVenta = $_POST["idventa"];
    $fecha =$_POST["fecha"];
    $cliente = $_POST["cliente"];
    $carnet = $_POST["carnet"];
    $totalventa = $_POST["totalventa"];
    

    $lote = $_POST["lote"];
    $cantidad = $_POST["cantidad"];
    $subtotal =$_POST["subtotal"];

    $array_lote = explode(",",$lote);
    $array_cantidad = explode(",",$cantidad);
    $array_subtotal = explode(",",$subtotal);
    

        $insertar = "INSERT INTO venta VALUES($idVenta,'$fecha','$cliente','$carnet',$id,$totalventa,'Habilitado',null,null,null)";
        $resultado = mysqli_query($conectar, $insertar);
        
        if($resultado){
          
            $resultado6= "";
            $stock="";
            for ($i=0; $i < count($array_lote); $i++) { 
                $insertarDetalle = "INSERT INTO ventaproducto values(null,$array_lote[$i],$idVenta,$array_cantidad[$i],$array_subtotal[$i],'Habilitado')";
                $resultado3 = mysqli_query($conectar, $insertarDetalle);

                //descuenta el stock del lote respectivo
                $ActualizarLote = "UPDATE lote SET stock = stock - $array_cantidad[$i] where id = $array_lote[$i]";
                $resultado4 = mysqli_query($conectar, $ActualizarLote);

                //obtiene el id del producto de la tabla lote
                $consulta= "select * from lote where id =  $array_lote[$i]";
                $resultado5= mysqli_query($conectar,$consulta);
                $row1 = $resultado5->fetch_assoc();
                $idProducto = $row1['idProducto'];

                //obtiene el ultimo stock del idProducto buscado
                $consulta2 = "SELECT * FROM kardex where idLote = $array_lote[$i] order by id desc limit 1";
                $resultado6 = mysqli_query($conectar, $consulta2);
                $row2 = $resultado6->fetch_assoc();
                $stock = $row2['stock'];
                $totalVenta= $stock - $array_cantidad[$i];

                    //registra en el kardex
                    $insertarKardex = "INSERT INTO kardex values(null,$array_lote[$i],$idProducto,'$fecha',0,$array_cantidad[$i],$totalVenta,'Salida por venta N° $idVenta')";
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
    
    
    if($tipo=="obtenerIdventa"){

        $consulta = "SELECT id FROM venta order by id DESC limit 1";
        $resultado2 = mysqli_query($conectar, $consulta);
        $row1 = $resultado2->fetch_assoc();
        $idCompra2 = $row1['id']; 

        echo $idCompra2;
    }

    if($tipo=="ValidarStock"){

        $nroLote = $_POST['lote'];
        $cantidad = $_POST['cantidad'];

        $consulta = "SELECT * FROM lote where id = $nroLote";
        $resultado2 = mysqli_query($conectar, $consulta);
        $row1 = $resultado2->fetch_assoc();
        $stock = $row1['stock']; 

        if($stock >= $cantidad){
            echo '1';
        }
        else{
            echo '2';
        }
    }

    if($tipo == "filtrarFechas"){
        $fechaInicio = $_POST['fechaInicio'];
        $fechaFinal = $_POST['fechaFinal'];

            $consultar = "SELECT v.id,v.fecha,v.cliente,p.nombre as producto,la.laboratorio,pr.presentacion,p.unidad,l.precioVenta,vp.cantidad,
            vp.subtotal,v.total,u.usuario,vp.idLote FROM venta as v 
            LEFT join ventaproducto as vp on vp.idVenta = v.id
            left join lote as l on l.id = vp.idLote
            left join producto as p on p.id = l.idProducto
            left join laboratorio as la on la.id = p.idLaboratorio
            left join presentacion as pr on pr.id = p.idPresentacion
            left join usuario as u on u.id = v.idUsuario
            where v.estado = 'Habilitado' and v.fecha BETWEEN '$fechaInicio' and '$fechaFinal'";               
            $resultado1 = mysqli_query($conectar, $consultar);


            if($resultado1){

                $tabla = "";
                $tabla .= '<table id="example1" class="table table-bordered table-striped"  method="POST">
                            <thead>
                                <tr>
                                    <th>#</th> 
                                    <th>Cliente</th>                  
                                    <th>Fecha</th>   
                                    <th>Lote</th>                  
                                    <th>Producto</th>
                                    <th>Laboratorio</th>
                                    <th>Presentación</th>
                                    <th>Cant.</th>
                                    <th>Precio</th>
                                    <th>SubTotal</th> 
                                    <th>Total</th>
                                    <th>Usuario</th>  	                
                                </tr>
                            </thead>
                            <tbody > ';
            
            
                $cont = 0;
                if ($resultado1) {
                    while ($listado = mysqli_fetch_array($resultado1)) {
            

                        $tabla .= "<tr>";
                        $tabla .= "<td data-title=''>" . $listado['id'] . "</td>";
                        $tabla .= "<td data-title=''>" . $listado['cliente'] . "</td>";
                        $tabla .= "<td data-title=''>" . $listado['fecha'] . "</td>";
                        $tabla .= "<td data-title=''>" . $listado['idLote'] . "</td>";
                        $tabla .= "<td data-title=''>" . $listado['producto'] . " " . $listado['unidad'] . "</td>";
                        $tabla .= "<td data-title=''>" . $listado['laboratorio'] . "</td>";
                        $tabla .= "<td data-title=''>" . $listado['presentacion'] . "</td>";
                        $tabla .= "<td data-title=''>" . $listado['cantidad'] . "</td>";
                        $tabla .= "<td data-title=''>" . $listado['precioVenta'] . "</td>";
                        $tabla .= "<td data-title=''>" . $listado['subtotal'] . "</td>";
                        $tabla .= "<td data-title=''>" . $listado['total'] . "</td>";
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


    if($tipo == "EliminarVenta"){

        $idVenta = $_POST["id"];
        $idLote = $_POST["idLote"];
        $cantidad = $_POST["cantidad"];

        $Eliminar = "UPDATE venta SET estado = 'Eliminado' where id = $idVenta";
        $resultado = mysqli_query($conectar, $Eliminar);


         //obtiene el id del producto de la tabla lote
         $consulta= "select * from lote where id =  $idLote";
         $resultado5= mysqli_query($conectar,$consulta);
         $row1 = $resultado5->fetch_assoc();
         $idProducto = $row1['idProducto'];


         //obtiene el ultimo stock del idProducto buscado
         $consulta2 = "SELECT * FROM kardex where idLote = idLote order by id desc limit 1";
         $resultado6 = mysqli_query($conectar, $consulta2);
         $row2 = $resultado6->fetch_assoc();
         $stock = $row2['stock'];
         $totalDevolucion = $stock + $cantidad;

             //registra en el kardex
             $insertarKardex = "INSERT INTO kardex values(null,$idLote,$idProducto,sysdate(),$cantidad,0,$totalDevolucion,'Ingreso por eliminación de la venta N° $idVenta')";
             $resultado7 = mysqli_query($conectar, $insertarKardex);
    }

    
       