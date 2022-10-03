<?php
require('head.php');
include('../clases/conexion.php');


$fechaInicio = $_GET["fechaInicial"];
$fechaFinal = $_GET["fechaFin"];

$consulta= "";

if($fechaInicio != "" && $fechaFinal != ""){
        $consulta = "and v.fecha between '$fechaInicio' and '$fechaFinal'";
}

$consulta1 = "SELECT v.id,v.fecha,v.cliente,p.nombre as producto,la.laboratorio,pr.presentacion,p.unidad,l.precioVenta,vp.cantidad,vp.subtotal,
v.total,u.usuario,vp.idLote FROM venta as v 
LEFT join ventaproducto as vp on vp.idVenta = v.id
left join lote as l on l.id = vp.idLote
left join producto as p on p.id = l.idProducto
left join laboratorio as la on la.id = p.idLaboratorio
left join presentacion as pr on pr.id = p.idPresentacion
left join usuario as u on u.id = v.idUsuario
where v.estado = 'Habilitado' $consulta";
$resultado = mysqli_query($conectar,$consulta1);


$pdf = new PDF("P","mm","LETTER");
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','B',13);


$DatosVenta = "SELECT id,fecha,cliente,idUsuario,total FROM venta where id = 1";
$resultado1 = mysqli_query($conectar,$DatosVenta);

while($row = $resultado1->fetch_assoc()){
        $pdf->SetFillColor(255,255,255);
        $pdf->Cell(20,7,'Cliente: ',0,0,'L',1); 
        $pdf->SetFont('Arial','',12);     
        $pdf->Write(7,$row["cliente"]);

        $pdf->SetFont('Arial','B',13);
        $pdf->Write(7,'        Fecha: ');      
        $pdf->SetFont('Arial','',12);
        $pdf->Write(7,$row["fecha"]);

        $pdf->SetFont('Arial','B',13);
        $pdf->Write(7,'        Total Venta: ');    
        $pdf->SetFont('Arial','',12);  
        $pdf->Write(7,$row["total"]);
}

$pdf->ln(15);
$pdf->SetFillColor(0,0,0);
$pdf->SetTextColor(255,255,255);
$pdf->Cell(10,10,"Nro",1,0,'C',1);
$pdf->Cell(40,10,"Cliente",1,0,'C',1);
$pdf->Cell(30,10,"Fecha",1,0,'C',1);
$pdf->Cell(60,10,"Producto",1,0,'C',1);
$pdf->Cell(20,10,"Cantidad",1,0,'C',1);
$pdf->Cell(20,10,"Precio",1,0,'C',1);
$pdf->Cell(20,10,"Total",1,1,'C',1);

$pdf->SetFont('Arial','',12);
$pdf->SetFillColor(255,255,255);
$pdf->SetTextColor(0,0,0);
while($row = $resultado->fetch_assoc()){

        $pdf->Cell(10,7,$row["id"],1,0,'L',1);
        $pdf->Cell(40,7,$row["cliente"],1,0,'L',1);
        $pdf->Cell(30,7,$row["fecha"],1,0,'L',1);
        $pdf->Cell(60,7,$row["producto"],1,0,'L',1);
        $pdf->Cell(20,7,$row["cantidad"],1,0,'L',1);
        $pdf->Cell(20,7,$row["precioVenta"],1,0,'L',1);
        $pdf->Cell(20,7,$row["subtotal"],1,1,'L',1);

   
}

$pdf->Output();
?>