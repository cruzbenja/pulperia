<?php

session_start();
include("conexion.php");

$tipo = $_GET["op"];


if($tipo == "LotesDeshabilitados"){

            $consultar = "SELECT l.id as idLote, p.nombre,p.unidad,la.laboratorio,l.vencimiento,cd.precioUnitario as precioCompra,
                        l.stock,sum(cd.precioUnitario * l.stock) as total FROM lote as l 
                        left join comprasDetalle as cd on cd.lote = l.id
                        left join producto as p on p.id = l.idProducto
                        left join laboratorio as la on la.id = p.idLaboratorio
                        where l.estado = 'Deshabilitado'
                        group by l.id, p.nombre,p.unidad,la.laboratorio,l.vencimiento,cd.precioUnitario,l.stock";
            $resultado1 = mysqli_query($conectar, $consultar);
    
            $tabla = "";
            $tabla .= '<table id="example2" class="table table-bordered table-striped"  method="POST">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Lote</th>
                                <th>Producto</th>
                                <th>Unidad</th>
                                <th>Laboratorio</th>
                                <th>Vencimiento</th>
                                <th>Precio Compra</th>
                                <th>Stock</th>
                                <th>Total</th>	                             
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
                    $tabla .= "<td data-title=''>" . $listado['nombre'] . "</td>";
                    $tabla .= "<td data-title=''>" . $listado['unidad'] . "</td>";
                    $tabla .= "<td data-title=''>" . $listado['laboratorio'] . "</td>";
                    $tabla .= "<td data-title=''>" . $listado['vencimiento'] . "</td>";
                    $tabla .= "<td data-title=''>" . $listado['precioCompra'] . "</td>";
                    $tabla .= "<td data-title=''>" . $listado['stock'] . "</td>";
                    $tabla .= "<td data-title=''>" . $listado['total'] . "</td>";
                    $tabla .= "</td>";
                    $tabla .= "</tr>";
                    
                }
            }
        
            $tabla .= "</tbody>
                    
                    </table>";
            echo  $tabla;   
      
}

if($tipo == "CalcularPerdida"){

    $consultar = "SELECT l.id as idLote, p.nombre,p.unidad,la.laboratorio,l.vencimiento,cd.precioUnitario as precioCompra,
                l.stock,sum(cd.precioUnitario * l.stock) as total FROM lote as l 
                left join comprasDetalle as cd on cd.lote = l.id
                left join producto as p on p.id = l.idProducto
                left join laboratorio as la on la.id = p.idLaboratorio
                where l.estado = 'Deshabilitado'
                group by l.id, p.nombre,p.unidad,la.laboratorio,l.vencimiento,cd.precioUnitario,l.stock";
    $resultado1 = mysqli_query($conectar, $consultar);

    $total = 0;
    if ($resultado1) {
        while ($listado = mysqli_fetch_array($resultado1)) {

            $total = $total + $listado['total'];
            
        }
        echo $total;
    }
    else{
        echo 'error';
    }
}