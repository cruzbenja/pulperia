<?php

include("conexion.php");

$tipo = $_GET["op"];


if($tipo=="editarlote"){

    $idProducto = $_POST["idProducto"];
    $idProveedor = $_POST["idProveedor"];
    $id = $_POST["id"];
    $stock = $_POST['stock'];

        $Actualizar = "UPDATE lote SET idProducto = $idProducto ,idProveedor = $idProveedor, stock= $stock where id = $id";
        $resultado = mysqli_query($conectar, $Actualizar);   

        if ($resultado) {
            echo '1';
        } 
        else {
            echo '2';
        }
}

if($tipo=="Eliminarlote"){

    $id = $_POST['id'];
    $estado = $_POST['estado'];

        $insertar = "UPDATE lote set estado = '$estado' where id= $id";
        $resultado = mysqli_query($conectar, $insertar);   

        if ($resultado) {
            echo '1';
        } 
        else {
            echo '2';
        }   
}

if($tipo=="TotalTipoProductos"){

    $consulta = "SELECT count(id) as total FROM producto where estado = 'Habilitado'";
    $resultado2 = mysqli_query($conectar, $consulta);
    $row1 = $resultado2->fetch_assoc();
    $total = $row1['total']; 

    echo $total;
}

if($tipo=="TotalCantidadProductos"){


    $consulta = "SELECT sum(stock) as total FROM lote where estado = 'Habilitado'";
    $resultado2 = mysqli_query($conectar, $consulta);
    $row1 = $resultado2->fetch_assoc();
    $cantidad = $row1['total']; 

    echo $cantidad;
}

if($tipo=="TotalInversionMercaderia"){

    $consulta = "SELECT l.id,l.stock,cd.precioUnitario,sum(l.stock * cd.precioUnitario) as total FROM lote as l
    left JOIN comprasDetalle as cd on cd.lote = l.id
    where l.estado = 'Habilitado'
    GROUP by l.id,l.stock,cd.precioUnitario,cd.subtotal,l.estado";
    $resultado2 = mysqli_query($conectar, $consulta);

    if($resultado2){
        $total = 0;
        while ($listado = mysqli_fetch_array($resultado2)) {
            $total = $total + $listado['total'] ;
        }
        echo $total;
    }
    else{
        echo 'error';
    }

    
}

if($tipo=="TotalGananciaMercaderia"){

    $consulta = "SELECT l.id,l.stock,l.precioVenta,sum(l.stock * l.precioVenta) as total FROM lote as l
    where l.estado = 'Habilitado'
    GROUP by l.id,l.stock,l.precioVenta";
    $resultado2 = mysqli_query($conectar, $consulta);
    if($resultado2){
        $total = 0;
        while ($listado = mysqli_fetch_array($resultado2)) {
            $total = $total + $listado['total'] ;
        }
        echo $total;
    }
    else{
        echo 'error';
    }
}