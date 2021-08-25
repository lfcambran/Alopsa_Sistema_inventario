<?php
if (strlen(session_id())<1)
    session_start();
require '../modelos/reportes.php';
require 'fpdf/fpdf.php';
$reportesg=new reportes_g();

class PDF extends FPDF
{
function Header()
{
    $this->Image('../files/server/alopsa.jpg',20,8,50);
    $this->SetFont('Arial','B',12);
    $this->Cell(110);
    $this->Cell(60,10,'Reporte TIR Activos',1,0,'C');
    
    $this->Ln(20);
    
}
function Footer()
{
    // Posición: a 1,5 cm del final
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Número de página
    $this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'C');
}
}

if (isset($_GET["fechainicial"]) && isset($_GET["fechafinal"]) && isset($_GET['tipo'])) {
   
    
    $fechaincial = $_GET["fechainicial"];
    $fechafinal = $_GET["fechafinal"];
    

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage('L','Letter');
$pdf->SetFont('Arial','B',7);

$pdf->Ln(10);
$pdf->SetFillColor(2,157,116);
$pdf->SetTextColor(240, 255, 240);

$w = array(12,12,25, 20,20,20,18,18,20,30,30,30);
$pdf->Cell(12,12,'No Tir',1,0,'C',true);
$pdf->Cell(12,12,'Serie',1,0,'C',true);
$pdf->Cell(25,12,'Contenedor',1,0,'C',true);
$pdf->Cell(20,12,'Fecha',1,0,'C',true);
$pdf->Cell(20,12,'Hora',1,0,'C',true);
$pdf->Cell(20,12,'Chassis',1,0,'C',true);
$pdf->Cell(18,12,'Tipo Chasis',1,0,'',true);
$pdf->Cell(18,12,'Refrigeracion',1,0,'',true);
$pdf->Cell(20,12,'Naviera',1,0,'C',true);
$pdf->Cell(30,12,'Destino',1,0,'C',true);
$pdf->Cell(30,12,'Clientes',1,0,'C',true);
$pdf->Cell(30,12,'Barco',1,0,'C',true);
$pdf->Ln();
$pdf->SetFont('Arial','',7);
$pdf->SetTextColor(0, 10, 0);

    $rspta=$reportesg->reportetirs_ex($fechaincial, $fechafinal);
    
    foreach ($rspta as $consulta) {
        
        
        $pdf->Cell($w[0],6,$consulta['idtir'],1,0,'C');
        $pdf->Cell($w[1],6,$consulta['SerieTir'],1,0,'C');
        $pdf->Cell($w[2],6,$consulta['No_Contenedor'],1,0,'C');
        $pdf->Cell($w[3],6,$consulta['fecha'],1,0,'C');
        $pdf->Cell($w[4],6,$consulta['hora'],1,0,'C');
        $pdf->Cell($w[5],6,$consulta['chassis'],1,0,'C');
        $pdf->Cell($w[6],6,$consulta['tipochassis'],1,0,'C');
        $pdf->Cell($w[7],6,$consulta['refrigeracion'],1,0,'C');
        $pdf->Cell($w[8],6,$consulta['Nombre_naviera'],1,0,'C');
        $pdf->Cell($w[9],6,$consulta['Destino'],1,0,'C');
        $pdf->Cell($w[10],6,$consulta['cliente'],1,0,'C');
        $pdf->Cell($w[11],6,$consulta['Barco'],1,0,'C');
        $pdf->Ln();
    }
    $pdf->Output();
} else {
    echo "<p>No parameters</p>";
}

