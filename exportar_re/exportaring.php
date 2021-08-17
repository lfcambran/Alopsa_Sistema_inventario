<?php

if (strlen(session_id())<1)
    session_start();

require '../modelos/reportes.php';
require 'pdf/fpdf/fpdf.php';
$reportesg=new reportes_g();
class PDF extends FPDF{
    function Header() {
        $this->Image('../files/server/alopsa.jpg',20,8,50);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(110);
        $this->Cell(60, 10, 'Reporte de Ingresos', 0, 0, 'C');
        $this->Ln(20);
         
              
    }
    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial','I',8);
        $this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'C');
    }
}

if (isset($_GET['fechainicial']) && isset($_GET['fechafinal'])){
    
    $fechaincial = $_GET["fechainicial"];
    $fechafinal = $_GET["fechafinal"];
    
    $pdf = new PDF();
    $pdf->AliasNbPages();
    $pdf->SetTitle('Reporte de Ingresos');
    $pdf->AddPage('L', 'Letter');
    $pdf->SetFont('Arial','B',7);
    
    $pdf->Ln(5);
    $pdf->SetFillColor(2,157,11);
    $pdf->SetTextColor(240, 255, 240);
    
    $w = array(12,25,15,15,25,20,20,30,25,20,28,20);
    $pdf->Cell(12,12,'Codigo',1,0,'C',true);
    $pdf->Cell(25,12,'Contenedor',1,0,'C',true);
    $pdf->Cell(15,12,'Fecha',1,0,'C',true);
    $pdf->Cell(15,12,'Hora',1,0,'C',true);
    $pdf->Cell(25,12,'Barco',1,0,'C',true);
    $pdf->Cell(20,12,'Contenido',1,0,'C',true);
    $pdf->Cell(20,12,'Destino',1,0,'C',true);
    $pdf->Cell(30,12,'Cliente',1,0,'C',true);
    $pdf->Cell(25,12,'Piloto',1,0,'C',true);
    $pdf->Cell(20,12,'Estado',1,0,'C',true);
    $pdf->Cell(28,12,'Servicio',1,0,'C',true);
    $pdf->Cell(20,12,'Contenido',1,0,'C',true);
    $pdf->Ln();
    $pdf->SetFont('Arial','',7);
    $pdf->SetTextColor(0, 10, 0);
    
    $rspta=$reportesg->reporte_ingresos($fechaincial,$fechafinal);
    
    foreach ($rspta as $datosi){
        
         $pdf->Cell($w[0],6,$datosi['Id_Ingreso'],1,0,'C');
         $pdf->Cell($w[1],6,$datosi['No_Contenedor'],1,0,'C');
         $pdf->Cell($w[2],6,$datosi['Fecha_ingreso'],1,0,'C');
         $pdf->Cell($w[3],6,$datosi['Hora_ingreso'],1,0,'C');
         $pdf->Cell($w[4],6,$datosi['Barco'],1,0,'C');
         $pdf->Cell($w[5],6,$datosi['Descripcion_contenido'],1,0,'C');
         $pdf->Cell($w[6],6,$datosi['Destino'],1,0,'C');
         $pdf->Cell($w[7],6,$datosi['cliente'],1,0,'C');
         $pdf->Cell($w[8],6,$datosi['Nombre_de_Piloto'],1,0,'C');
         $pdf->Cell($w[9],6,$datosi['Estado'],1,0,'C');
         $pdf->Cell($w[10],6,$datosi['Detalle_Servicio'],1,0,'C');
         $pdf->Cell($w[11],6,$datosi['Tipo_Contenido'],1,0,'C');
         $pdf->Ln();
    }
    
   $pdf->Output(); 
} else {
     echo "<p>No parameters</p>";
}
?>
