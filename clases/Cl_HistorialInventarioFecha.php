<?php

session_start();
include("conexion.php");

$tipo = $_GET["op"];


if($tipo == "filtrarHistorial"){

    $id = $_POST['id'];

            $consultar = "SELECT i.idLote as id,p.nombre,p.unidad,l.vencimiento,i.stockSistema,i.stockFisico,i.diferencia,inv.fechaInicio,inv.fechaFin FROM inventarioFechaProductos as i left join lote as l on l.id = i.idLote left join producto as p on p.id = l.idProducto left join inventarioFecha as inv on inv.id = i.idInventario where i.idInventario = $id";
            $resultado1 = mysqli_query($conectar, $consultar);
    
            $tabla = "";
            $tabla .= '<table id="example1" class="table table-bordered table-striped"  method="POST">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Fecha Inicio</th>
                                <th>Fecha Final</th>
                                <th>Lote</th>
                                <th>Producto</th>
                                <th>Unidad</th>
                                <th>Stock Sistema</th>
                                <th>Stock Fisico</th>
                                <th>Diferencia</th>                                  
                            </tr>
                        </thead>
                        <tbody > ';
        
        
            $cont = 0;
            if ($resultado1) {
                while ($listado = mysqli_fetch_array($resultado1)) {

                    $cont++;
                    $tabla .= "<tr>";
                    $tabla .= "<td data-title=''>" . $cont . "</td>";
                    $tabla .= "<td data-title=''>" . $listado['fechaInicio'] . "</td>";
                    $tabla .= "<td data-title=''>" . $listado['fechaFin'] . "</td>";
                    $tabla .= "<td data-title=''>" . $listado['id'] . "</td>";
                    $tabla .= "<td data-title=''>" . $listado['nombre'] . "</td>";
                    $tabla .= "<td data-title=''>" . $listado['unidad'] . "</td>";
                    $tabla .= "<td data-title=''>" . $listado['stockSistema'] . "</td>";
                    $tabla .= "<td data-title=''>" . $listado['stockFisico'] . "</td>";
                    $tabla .= "<td data-title=''>" . $listado['diferencia'] . "</td>";
                    $tabla .= "</td>";
                    $tabla .= "</tr>";
                }
            }
        
            $tabla .= "</tbody>
                    
                    </table>";
            echo  $tabla;   
      
}


if($tipo == "BuscarHistorial"){

        $consultarHistorial = "SELECT * FROM inventarioFecha order by id asc";
        $resultado = mysqli_query($conectar, $consultarHistorial);

            $tabla = "";
            $tabla .= '<table id="example1" class="table table-bordered table-striped"  method="POST">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Fecha Inicial</th>
                                <th>Fecha Final</th>
                                <th>Pérdida / Ganancia</th>
                                <th>Estado</th>
                                <th width="130px">Accion</th> 	                
                            </tr>
                        </thead>
                        <tbody > ';
        
        
            $cont = 0;
            if ($resultado) {
                while ($listado = mysqli_fetch_array($resultado)) {
        
                    $cont++;
                    $tabla .= "<tr>";
                    $tabla .= "<td data-title=''>" . $cont . "</td>";
                    $tabla .= "<td data-title=''>" . $listado['fechaInicio'] . "</td>";
                    $tabla .= "<td data-title=''>" . $listado['fechaFin'] . "</td>";
                    $tabla .= "<td data-title=''>Bs. " . $listado['diferencia'] . "</td>";
                    $tabla .= "<td data-title=''>" . $listado['estado'] . "</td>";
                    if($listado['estado'] == "Abierto"){
                        $tabla .= "<td data-title=''></td>";
                    }
                    else{
                        $tabla .= "<td data-title=''><button type='button' class='btn btn-success btn-sm checkbox-toggle' onclick='VerHistorial(".$listado['id'].")'>Ver Historial</button></td>";
                    }
                    
                    $tabla .= "</td>";
                    $tabla .= "</tr>";
                }
            }
        
            $tabla .= "</tbody>
                    
                    </table>";
            echo  $tabla;       
}
