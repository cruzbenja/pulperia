<?php

session_start();
include("conexion.php");

$tipo = $_GET["op"];



if($tipo == "filtrarKardex"){
    $fechaInicio = $_POST['fechaInicio'];
    $fechaFinal = $_POST['fechaFinal'];
    $idLote = $_POST['id'];

        $consultar = "SELECT k.idLote,p.nombre,p.unidad,k.fecha,k.entrada,k.salida,k.stock,k.concepto FROM kardex as k 
                        LEFT JOIN producto as p on p.id = k.idProducto 
                        where k.fecha BETWEEN '$fechaInicio' and '$fechaFinal' and k.idLote = $idLote";
        
        $resultado1 = mysqli_query($conectar, $consultar);

        $tabla = "";
        $tabla .= '<table id="example1" class="table table-bordered table-striped"  method="POST">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Lote</th>        
                            <th>Fecha</th>                                                      
                            <th>Entrada</th>
                            <th>Salida</th>
                            <th>Saldo</th>
                            <th>Motivo</th>    	                
                        </tr>
                    </thead>
                    <tbody > ';
    
    
        $cont = 0;
        if ($resultado1) {
            while ($listado = mysqli_fetch_array($resultado1)) {
    
                $cont++;
                $tabla .= "<tr>";
                $tabla .= "<td data-title=''>" . $cont . "</td>";
                $tabla .= "<td data-title=''>" . $listado['idLote'] . "</td>";
                $tabla .= "<td data-title=''>" . $listado['fecha'] . "</td>";
                $tabla .= "<td data-title=''>" . $listado['entrada'] . "</td>";
                $tabla .= "<td data-title=''>" . $listado['salida'] . "</td>";
                $tabla .= "<td data-title=''>" . $listado['stock'] . "</td>";
                $tabla .= "<td data-title=''>" . $listado['concepto'] . "</td>";
                $tabla .= "</td>";
                $tabla .= "</tr>";
            }
        }
    
        $tabla .= "</tbody>
                
                </table>";
        echo  $tabla;   
}