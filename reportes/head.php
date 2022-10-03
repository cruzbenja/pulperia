<?php
require('../plugins/fpdf/fpdf.php');

class PDF extends FPDF
{
    // Page header
    function Header()
    {
        // Logo
        $this->Image('../img/LogoSoftwareBolivia.png',6,3,30);
        // Arial bold 15
        $this->SetFont('Arial','B',20);
        // Title
        $this->Cell(0,10,'Recibo de Venta',0,1,'C');
        // Line break
        $this->Ln(15);
    }

    // Page footer
    function Footer()
    {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial','I',10);
        // Page number
        $this->Write(5,'Facebook: SoftwareBolivia      ');
        $this->Write(5,' Direccion: Av. Banzer Barrio Ferbo calle las americas # 24      ');
        $this->Write(5,' Telefono: 69092272');
     //   $this->Cell(0,18,utf8_decode('Pagina').$this->PageNo(). ' / {nb}',0,0,'C');
    }


}



?>
