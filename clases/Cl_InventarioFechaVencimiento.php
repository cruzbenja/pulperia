<?php

session_start();
include("conexion.php");

$tipo = $_GET["op"];


if($tipo == "filtrarProductos"){

    $fechaInicio = $_POST['fechaInicio'];
    $DiferenciaBs = $_POST['diferencia'];

    $obtenerestado = "SELECT estado FROM inventarioFecha order by id desc limit 1";
    $resultado4 = mysqli_query($conectar, $obtenerestado);
    $row = $resultado4->fetch_assoc();
    $estado = $row['estado'];


    if($estado == "Cerrado" || $estado == "" || $estado == null){
        $registrarInventario = "INSERT INTO inventarioFecha values(null,'$fechaInicio',null,0,'Abierto')";
        $resultado = mysqli_query($conectar, $registrarInventario);

        $seleccionarInventario = "SELECT id FROM inventarioFecha order by id desc limit 1";
        $resultado2 = mysqli_query($conectar, $seleccionarInventario);
        $row = $resultado2->fetch_assoc();
        $idInventario = $row['id']; 

        if($resultado2){
            $consultar = "SELECT l.id as idLote,l.vencimiento,p.nombre,p.unidad,l.stock from lote as l left join producto as p on p.id = l.idProducto where l.estado = 'Habilitado' and l.stock > 0 ORDER BY p.nombre,p.unidad ASC";     
            $resultado1 = mysqli_query($conectar, $consultar);
    
            $tabla = "";
            $tabla .= '<table id="example1" class="table table-bordered table-striped"  method="POST">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nro Lote</th>                               
                                <th>Producto</th>
                                <th>Vencimiento</th>
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
                    $ingresarinventarioProducto = "INSERT INTO inventarioFechaProductos values(null,$idInventario,".$listado['idLote'].",".$listado['stock'].",0,$diferencia)";
                    $resultado3 = mysqli_query($conectar, $ingresarinventarioProducto);
    
                    $cont++;
                    $tabla .= "<tr>";
                    $tabla .= "<td data-title=''>" . $cont . "</td>";
                    $tabla .= "<td data-title=''>" . $listado['idLote'] . "</td>";                   
                    $tabla .= "<td data-title=''>" . $listado['nombre'] . " " . $listado['unidad'] . "</td>";
                    $tabla .= "<td data-title=''>" . $listado['vencimiento'] . "</td>";
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
        $ObtenerIdInventario = "SELECT id FROM inventarioFecha order by id desc limit 1";
        $resultado5 = mysqli_query($conectar, $ObtenerIdInventario);
        $row2 = $resultado5->fetch_assoc();
        $idInventario = $row2['id'];

       /* $obtenerDiferencia = "SELECT sum(diferencia) as diferencia FROM inventarioFechaProductos where idInventario = $idInventario";
        $resultado6 = mysqli_query($conectar, $obtenerDiferencia);
        $row3 = $resultado6->fetch_assoc();
        $diferencias = $row3['diferencia']; */

        $ActualizarEstado = "UPDATE inventarioFecha SET fechaFin = '$fechaInicio', estado = 'Cerrado', diferencia = $DiferenciaBs where id = $idInventario";
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

        $registrarInventario = "SELECT * FROM inventarioFecha order by id desc limit 1";
        $resultado2 = mysqli_query($conectar, $registrarInventario);
        $row = $resultado2->fetch_assoc();
        $estadoinventario = $row['estado']; 

        $ObtenerIdInventario = "SELECT id FROM inventarioFecha order by id desc limit 1";
        $resultado5 = mysqli_query($conectar, $ObtenerIdInventario);
        $row2 = $resultado5->fetch_assoc();
        $idInventario = $row2['id']; 

        if($estadoinventario == 'Abierto'){
            $consultar = "SELECT i.idLote as id,p.nombre,p.unidad,l.vencimiento,i.stockSistema,i.stockFisico,i.diferencia FROM inventarioFechaProductos as i left join lote as l on l.id = i.idLote left join producto as p on p.id = l.idProducto where i.idInventario = $idInventario";     
            $resultado1 = mysqli_query($conectar, $consultar);
    
            $tabla = "";
            $tabla .= '<table id="example1" class="table table-bordered table-striped"  method="POST">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nro Lote</th>                              
                                <th>Producto</th>
                                <th>Vencimiento</th>
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
                    $tabla .= "<td data-title=''>" . $listado['nombre'] . " " . $listado['unidad'] . "</td>";
                    $tabla .= "<td data-title=''>" . $listado['vencimiento'] . "</td>";
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

    $obtenerStockSistema = "SELECT stockSistema FROM inventarioFechaProductos where idLote = $id order by id desc limit 1";
    $resultado = mysqli_query($conectar, $obtenerStockSistema);
    $row = $resultado->fetch_assoc();
    $stockSistema = $row['stockSistema']; 

    $diferencia = $stock - $stockSistema;

    $actualizarStock = "UPDATE inventarioFechaProductos SET stockFisico = $stock, diferencia = $diferencia where idLote = $id";
    $resultado2 = mysqli_query($conectar, $actualizarStock);

    if($resultado2){
        echo '1';
    }
    else{
        echo '2';
    }
}

if($tipo=="actualizarStock"){

    $fechaInicio = $_POST["fechaInicio"];

    $ObtenerIdInventario = "SELECT id FROM inventarioFecha order by id desc limit 1";
    $resultado5 = mysqli_query($conectar, $ObtenerIdInventario);
    $row2 = $resultado5->fetch_assoc();
    $idInventario = $row2['id']; 

    $consultar2 = "SELECT i.idLote as id,i.stockFisico,i.diferencia FROM inventarioFechaProductos as i left join lote as l on l.id = i.idLote left join producto as p on p.id = l.idProducto where i.idInventario = $idInventario";     
    $resultado8 = mysqli_query($conectar, $consultar2);

    $resultado12 = "";
    $actualizarKardex = "";
    if ($resultado8) {
        while ($listado = mysqli_fetch_array($resultado8)) {
            
            //actualiza el stock del lote de acuerdo al inventario realizado
            $ingresarinventarioProducto = "UPDATE lote SET stock = ".$listado['stockFisico']." where id = ".$listado['id']."";
            $resultado9 = mysqli_query($conectar, $ingresarinventarioProducto);

            //obtiene el id del producto de un lote
            $obtenerIdProducto = "SELECT l.idProducto FROM lote as l left join producto as p on p.id = l.idProducto where l.id = ".$listado['id']."";
            $resultado10 = mysqli_query($conectar, $obtenerIdProducto);
            $row2 = $resultado10->fetch_assoc();
            $idProducto = $row2['idProducto']; 

             //obtiene la ultima cantidad de un producto registrado en el kardex
             $saldo = 0;
             $obtenersaldo = "SELECT stock FROM kardex where idLote = ".$listado['id']." order by id desc limit 1";
             $resultado11 = mysqli_query($conectar, $obtenersaldo);
             $row2 = $resultado11->fetch_assoc();
             if($row2['stock'] != "" || $row2['stock'] != null){
                $saldo = $row2['stock'];
             }
             

             //para saber si en el kardex se va a sumar o restar
             if($listado['diferencia'] != 0){
                if($listado['diferencia'] < 0){
                    //operacion 
                    $resta = $saldo + $listado['diferencia'];
                    $salida = $listado['diferencia'] * -1;
                    $actualizarKardex = "INSERT INTO kardex values(null,".$listado['id'].",$idProducto,'$fechaInicio',0,$salida,$resta,'Salida para cuadrar inventario N° $idInventario')";
                    $resultado12 = mysqli_query($conectar, $actualizarKardex);
                }
                else{
                     //operacion 
                     $resta = $saldo + $listado['diferencia'];
                     $actualizarKardex = "INSERT INTO kardex values(null,".$listado['id'].",$idProducto,'$fechaInicio',".$listado['diferencia'].",0,$resta,'Ingreso para cuadrar inventario N° $idInventario')";
                     $resultado12 = mysqli_query($conectar, $actualizarKardex);
                }
             }
             else{
                $resultado12 = true;
             }
           
        }
    }


    if($resultado12){
        echo '1';
    }
    else{
        echo $actualizarKardex;
    }
        
}  

if($tipo == "estadoDelInventario"){

    //obtengo el ultimo inventario abierto
    $ObtenerIdInventario = "SELECT id FROM inventarioFecha order by id desc limit 1";
    $resultado = mysqli_query($conectar, $ObtenerIdInventario);
    $row = $resultado->fetch_assoc();
    $idInventario = $row['id']; 

    //obtengo la diferencia monetaria del ultimo inventario abierto
    $obtenerDiferenciaMoney = "SELECT sum(cd.precioUnitario* ifp.diferencia) as diferencia FROM inventarioFechaProductos as ifp left join comprasDetalle as cd on cd.lote = ifp.idLote where ifp.idInventario = $idInventario";
    $resultado21 = mysqli_query($conectar, $obtenerDiferenciaMoney);
    $row21 = $resultado21->fetch_assoc();
    $diferencia = $row21['diferencia']; 


    if($resultado21){
        echo $diferencia ;
    }
    else{
        echo 'error';
    }
}

if($tipo == "prueba"){

    $resultado2 = "hola";

    if($resultado2 == "hola"){
        echo "oi" ;
    }
    else{
        echo 'error';
    }
}