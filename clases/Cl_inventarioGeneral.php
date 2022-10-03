<?php

include("conexion.php");

$tipo = $_GET["op"];


if($tipo == "filtrarProductos"){

    $fechaInicio = $_POST['fechaInicio'];

    $obtenerestado = "SELECT estado FROM inventarios order by id desc limit 1";
    $resultado4 = mysqli_query($conectar, $obtenerestado);
    $row = $resultado4->fetch_assoc();
    $estado = $row['estado'];

    if($estado == "Cerrado" || $estado == "" || $estado == null){
        $registrarInventario = "INSERT INTO inventarios values(null,'$fechaInicio','$fechaInicio',0,'Abierto')";
        $resultado = mysqli_query($conectar, $registrarInventario);

        $registrarInventario = "SELECT id FROM inventarios order by id desc limit 1";
        $resultado2 = mysqli_query($conectar, $registrarInventario);
        $row = $resultado2->fetch_assoc();
        $idInventario = $row['id']; 

        if($resultado2){
            $consultar = 'SELECT p.id,p.nombre,p.unidad,sum(l.stock) as stock FROM producto as p left join lote as l on l.idProducto = p.id where p.estado = "Habilitado" and l.stock > 0 group BY p.id,p.nombre,p.unidad';     
            $resultado1 = mysqli_query($conectar, $consultar);
    
            $tabla = "";
            $tabla .= '<table id="example1" class="table table-bordered table-striped"  method="POST">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Código</th>
                                <th>Producto</th>
                                <th>Unidad</th>
                                <th>Stock Sistema</th>
                                <th>Stock Fisico</th>
                                <th>Diferencia</th>
                                <th width="130px">Accion</th> 	                
                            </tr>
                        </thead>
                        <tbody > ';
        
        
            $cont = 0;
            if ($resultado1) {
                while ($listado = mysqli_fetch_array($resultado1)) {
        
                    $diferencia = $listado['stock'] * -1;
                    $ingresarinventarioProducto = "INSERT INTO inventarioProducto values(null,$idInventario,".$listado['id'].",".$listado['stock'].",0,$diferencia)";
                    $resultado3 = mysqli_query($conectar, $ingresarinventarioProducto);
    
                    $cont++;
                    $tabla .= "<tr>";
                    $tabla .= "<td data-title=''>" . $cont . "</td>";
                    $tabla .= "<td data-title=''>" . $listado['id'] . "</td>";
                    $tabla .= "<td data-title=''>" . $listado['nombre'] . "</td>";
                    $tabla .= "<td data-title=''>" . $listado['unidad'] . "</td>";
                    $tabla .= "<td data-title=''>" . $listado['stock'] . "</td>";
                    $tabla .= "<td data-title=''>0</td>";
                    $tabla .= "<td data-title=''>-" . $listado['stock'] . "</td>";
                    $tabla .= "<td data-title=''><button type='button' class='btn btn-success btn-sm checkbox-toggle' onclick='modalIngresarStock(" . $listado['id'] . ")'>Ingresar Stock</button></td>";
                    $tabla .= "</td>";
                    $tabla .= "</tr>";
                }
            }
        
            $tabla .= "</tbody>
                    
                    </table>";
            echo  $tabla;   
        }
        else{
            echo 'error';
        }
    }
    else{
        $ObtenerIdInventario = "SELECT id FROM inventarios order by id desc limit 1";
        $resultado5 = mysqli_query($conectar, $ObtenerIdInventario);
        $row2 = $resultado5->fetch_assoc();
        $idInventario = $row2['id']; 

        $obtenerDiferencia = "SELECT sum(diferencia) as diferencia FROM inventarioProducto where idInventario = $idInventario";
        $resultado6 = mysqli_query($conectar, $obtenerDiferencia);
        $row3 = $resultado6->fetch_assoc();
        $diferencias = $row3['diferencia']; 

        $ActualizarEstado = "UPDATE inventarios SET fechaFin = '$fechaInicio', estado = 'Cerrado', diferencia = $diferencias where id = $idInventario";
        $resultado7 = mysqli_query($conectar, $ActualizarEstado);

        if($resultado7){
            echo 'ok';
        }
        else{
            echo 'falla';
        }
    }
      
}


if($tipo == "BuscarApertura"){

        $registrarInventario = "SELECT * FROM inventarios order by id desc limit 1";
        $resultado2 = mysqli_query($conectar, $registrarInventario);
        $row = $resultado2->fetch_assoc();
        $estadoinventario = $row['estado']; 

        $ObtenerIdInventario = "SELECT id FROM inventarios order by id desc limit 1";
        $resultado5 = mysqli_query($conectar, $ObtenerIdInventario);
        $row2 = $resultado5->fetch_assoc();
        $idInventario = $row2['id']; 

        if($estadoinventario == 'Abierto'){
            $consultar = "SELECT p.id,p.nombre,p.unidad,i.stockSistema,i.stockFisico,i.diferencia FROM inventarioProducto as i left join producto as p on p.id = i.idProducto left join inventarios as inv on inv.id = i.idInventario where inv.id = $idInventario";     
            $resultado1 = mysqli_query($conectar, $consultar);
    
            $tabla = "";
            $tabla .= '<table id="example1" class="table table-bordered table-striped"  method="POST">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Código</th>
                                <th>Producto</th>
                                <th>Unidad</th>
                                <th>Stock Sistema</th>
                                <th>Stock Fisico</th>
                                <th>Diferencia</th>
                                <th width="130px">Accion</th> 	                
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
                    $tabla .= "<td data-title=''>" . $listado['nombre'] . "</td>";
                    $tabla .= "<td data-title=''>" . $listado['unidad'] . "</td>";
                    $tabla .= "<td data-title=''>" . $listado['stockSistema'] . "</td>";
                    $tabla .= "<td data-title=''>" . $listado['stockFisico'] . "</td>";
                    $tabla .= "<td data-title=''>" . $listado['diferencia'] . "</td>";
                    $tabla .= "<td data-title=''><button type='button' class='btn btn-success btn-sm checkbox-toggle' onclick='modalIngresarStock(".$listado['id'].")'>Ingresar Stock</button></td>";
                    $tabla .= "</td>";
                    $tabla .= "</tr>";
                }
            }
        
            $tabla .= "</tbody>
                    
                    </table>";
            echo  $tabla;   
        }
        else{
            echo 'vacio';
        }     
}

if($tipo == "ingresarStock"){

    $id = $_POST["id"];
    $stock = $_POST["stock"];

    $obtenerStockSistema = "SELECT stockSistema FROM inventarioProducto where idProducto = $id";
    $resultado = mysqli_query($conectar, $obtenerStockSistema);
    $row = $resultado->fetch_assoc();
    $stockSistema = $row['stockSistema']; 

    $diferencia = $stock - $stockSistema;

    $actualizarStock = "UPDATE inventarioProducto SET stockFisico = $stock, diferencia = $diferencia where idProducto = $id";
    $resultado2 = mysqli_query($conectar, $actualizarStock);

    if($resultado2){
        echo '1';
    }
    else{
        echo '2';
    }
}