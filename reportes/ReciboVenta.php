<?php
require('../plugins/fpdf/fpdf.php');
include('../clases/conexion.php');


//$nroVenta = $_GET["NroVenta"];

//$consulta = "";
//$resultado = mysqli_query($conectar,$consulta);


$pdf = new PDF("P","mm","LETTER");

$pdf->AddPage();


$pdf->SetFont('Arial','B',13);
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




$pdf->Output();
?>