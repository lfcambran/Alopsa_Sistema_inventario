<?php

if (strlen(session_id())<1)
    session_start();

require '../modelos/reportes.php';
date_default_timezone_set("America/Guatemala");
require 'PHPExcel/Classes/PHPExcel.php';
$datosExcel = new PHPExcel();
$reportesg=new reportes_g();


switch ($_GET['reporte']){
       case 'ingreso':
           
           $datosExcel->setActiveSheetIndex(0);
           $datosExcel->getActiveSheet()->setTitle('Reporte Ingresos');
           
            $fechaincial = $_GET["fechainicial"];
            $fechafinal = $_GET["fechafinal"];
           
            $colinicial = 3;
            
            $BStyle = array(
                                'borders' => array(
                                  'allborders' => array(
                                    'style' => PHPExcel_Style_Border::BORDER_THIN
                                  )
                                )
                            );
               
                $datosExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
                $datosExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
                $datosExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
                $datosExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
                $datosExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
                $datosExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
                $datosExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
                $datosExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
                $datosExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
                $datosExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
                $datosExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
                $datosExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
                
                $datosExcel->getActiveSheet()->getStyle("C1")->getFont()->setBold(true);
                $datosExcel->getActiveSheet()->getStyle("A{$colinicial}")->getFont()->setBold(true);
                $datosExcel->getActiveSheet()->getStyle("B{$colinicial}")->getFont()->setBold(true);
                $datosExcel->getActiveSheet()->getStyle("C{$colinicial}")->getFont()->setBold(true);
                $datosExcel->getActiveSheet()->getStyle("D{$colinicial}")->getFont()->setBold(true);
                $datosExcel->getActiveSheet()->getStyle("E{$colinicial}")->getFont()->setBold(true);
                $datosExcel->getActiveSheet()->getStyle("F{$colinicial}")->getFont()->setBold(true);
                $datosExcel->getActiveSheet()->getStyle("G{$colinicial}")->getFont()->setBold(true);
                $datosExcel->getActiveSheet()->getStyle("H{$colinicial}")->getFont()->setBold(true);
                $datosExcel->getActiveSheet()->getStyle("I{$colinicial}")->getFont()->setBold(true);
                $datosExcel->getActiveSheet()->getStyle("J{$colinicial}")->getFont()->setBold(true);
                $datosExcel->getActiveSheet()->getStyle("K{$colinicial}")->getFont()->setBold(true);
                $datosExcel->getActiveSheet()->getStyle("L{$colinicial}")->getFont()->setBold(true);
                
                $datosExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(35);
                
                $objDrawind = new PHPExcel_Worksheet_Drawing();
                            $objDrawind->setName("logo");
                            $objDrawind->setDescription("logo");
                            $objDrawind->setPath('../files/server/alopsa.jpg');
                            $objDrawind->setOffsetY(5);
                            $objDrawind->setOffsetX(5);
                            $objDrawind->setCoordinates('A1');
                            $objDrawind->setWidth(40);
                            $objDrawind->setHeight(40);
                            $objDrawind->setWorksheet($datosExcel->getActiveSheet());
                            
               $datosExcel->getActiveSheet()->mergeCells('C1:J1');             
               $datosExcel->getActiveSheet()->setCellValue('C1','ALOPSA BARRIOS - INVENTARIO CONTENEDORES');  
               $datosExcel->getActiveSheet()->getStyle('C1')->getAlignment()->applyFromArray(
                     array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
                );
               $datosExcel->getActiveSheet()->getStyle('C1:J1')->applyFromArray($BStyle);
               $datosExcel->getActiveSheet()->setCellValue("L1", date("d-m-Y"));
               $datosExcel->getActiveSheet()->setCellValue("A{$colinicial}","Codigo");
               $datosExcel->getactivesheet()->setCellValue("B{$colinicial}","Contenedor");
               $datosExcel->getActiveSheet()->setCellValue("C{$colinicial}","Fecha");
               $datosExcel->getActiveSheet()->setCellValue("D{$colinicial}","Hora");
               $datosExcel->getActiveSheet()->setCellValue("E{$colinicial}","Barco");
               $datosExcel->getActiveSheet()->setCellValue("F{$colinicial}","Contenido");
               $datosExcel->getActiveSheet()->setCellValue("G{$colinicial}","Destino");
               $datosExcel->getActiveSheet()->setCellValue("H{$colinicial}","Cliente");
               $datosExcel->getActiveSheet()->setCellValue("I{$colinicial}","Piloto");
               $datosExcel->getActiveSheet()->setCellValue("J{$colinicial}","Estado");
               $datosExcel->getActiveSheet()->setCellValue("K{$colinicial}","Servicio");
               $datosExcel->getActiveSheet()->setCellValue("L{$colinicial}","Contenido");
               
               $datosreporte=$reportesg->reporte_ingresos($fechaincial, $fechafinal);
               
               
               foreach ($datosreporte as $dr) {
                   $colinicial++;
                   
                $datosExcel->getActiveSheet()->setCellValue('A'.$colinicial,$dr['Id_Ingreso'])
	                              ->setCellValue('B' . $colinicial, $dr['No_Contenedor'])
	                              ->setCellValue('C' . $colinicial, date('d/m/Y', strtotime($dr['Fecha_ingreso'])))
	                              ->setCellValue('D' . $colinicial, $dr['Hora_ingreso'])
	                              ->setCellValue('E' . $colinicial, $dr['Barco'])
                                      ->setCellValue('F' . $colinicial, $dr['Descripcion_contenido'])
                                      ->setCellValue('G' . $colinicial, $dr['Destino'])
                                      ->setCellValue('H' . $colinicial, $dr['cliente'])
                                      ->setCellValue('I' . $colinicial, $dr['Nombre_de_Piloto'])
                                      ->setCellValue('J' . $colinicial, $dr['Estado'])
                                      ->setCellValue('K' . $colinicial, $dr['Detalle_Servicio'])
                                      ->setCellValue('L' . $colinicial, $dr['Tipo_Contenido']);
                
                }
               
               
               $nomarchivo="Inventario de Contenedores ".date("dmYHis").".xls";     
               header('Content-Type: application/vnd.ms-excel');
               header('Content-Disposition: attachment;filename="'.$nomarchivo.'"');
               header('Cache-Control: max-age=0');
               
               $objWriter = PHPExcel_IOFactory::createWriter($datosExcel,'Excel5');
               $objWriter->save('php://output');
             
           
           break;
       case 'rtir':
           
           $datosExcel->setActiveSheetIndex(0);
           $datosExcel->getActiveSheet()->setTitle('Reporte TIRs Activos');
           
            $fechaincial = $_GET["fechainicial"];
            $fechafinal = $_GET["fechafinal"];
           
            $colinicial = 3;
            
            $BStyle = array(
                                'borders' => array(
                                  'allborders' => array(
                                    'style' => PHPExcel_Style_Border::BORDER_THIN
                                  )
                                )
                            );
           
            $datosExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
                $datosExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
                $datosExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
                $datosExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
                $datosExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
                $datosExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
                $datosExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
                $datosExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
                $datosExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
                $datosExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
                $datosExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
                $datosExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
                
                $datosExcel->getActiveSheet()->getStyle("C1")->getFont()->setBold(true);
                $datosExcel->getActiveSheet()->getStyle("A{$colinicial}")->getFont()->setBold(true);
                $datosExcel->getActiveSheet()->getStyle("B{$colinicial}")->getFont()->setBold(true);
                $datosExcel->getActiveSheet()->getStyle("C{$colinicial}")->getFont()->setBold(true);
                $datosExcel->getActiveSheet()->getStyle("D{$colinicial}")->getFont()->setBold(true);
                $datosExcel->getActiveSheet()->getStyle("E{$colinicial}")->getFont()->setBold(true);
                $datosExcel->getActiveSheet()->getStyle("F{$colinicial}")->getFont()->setBold(true);
                $datosExcel->getActiveSheet()->getStyle("G{$colinicial}")->getFont()->setBold(true);
                $datosExcel->getActiveSheet()->getStyle("H{$colinicial}")->getFont()->setBold(true);
                $datosExcel->getActiveSheet()->getStyle("I{$colinicial}")->getFont()->setBold(true);
                $datosExcel->getActiveSheet()->getStyle("J{$colinicial}")->getFont()->setBold(true);
                $datosExcel->getActiveSheet()->getStyle("K{$colinicial}")->getFont()->setBold(true);
                $datosExcel->getActiveSheet()->getStyle("L{$colinicial}")->getFont()->setBold(true);
                
                $datosExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(35);
                
                $objDrawind = new PHPExcel_Worksheet_Drawing();
                            $objDrawind->setName("logo");
                            $objDrawind->setDescription("logo");
                            $objDrawind->setPath('../files/server/alopsa.jpg');
                            $objDrawind->setOffsetY(5);
                            $objDrawind->setOffsetX(5);
                            $objDrawind->setCoordinates('A1');
                            $objDrawind->setWidth(40);
                            $objDrawind->setHeight(40);
                            $objDrawind->setWorksheet($datosExcel->getActiveSheet());
                            
               $datosExcel->getActiveSheet()->mergeCells('C1:J1');             
               $datosExcel->getActiveSheet()->setCellValue('C1',"ALOPSA BARRIOS - REPORTE TIR'S");  
               $datosExcel->getActiveSheet()->getStyle('C1')->getAlignment()->applyFromArray(
                     array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
                );
               $datosExcel->getActiveSheet()->getStyle('C1:J1')->applyFromArray($BStyle);
               $datosExcel->getActiveSheet()->setCellValue("L1", date("d-m-Y"));
               $datosExcel->getActiveSheet()->setCellValue("A{$colinicial}","No. Tir");
               $datosExcel->getactivesheet()->setCellValue("B{$colinicial}","Serie");
               $datosExcel->getActiveSheet()->setCellValue("C{$colinicial}","Contenedor");
               $datosExcel->getActiveSheet()->setCellValue("D{$colinicial}","Fecha");
               $datosExcel->getActiveSheet()->setCellValue("E{$colinicial}","Hora");
               $datosExcel->getActiveSheet()->setCellValue("F{$colinicial}","Chassis");
               $datosExcel->getActiveSheet()->setCellValue("G{$colinicial}","Tipo Chassis");
               $datosExcel->getActiveSheet()->setCellValue("H{$colinicial}","Refrigeracion");
               $datosExcel->getActiveSheet()->setCellValue("I{$colinicial}","Naviera");
               $datosExcel->getActiveSheet()->setCellValue("J{$colinicial}","Destino");
               $datosExcel->getActiveSheet()->setCellValue("K{$colinicial}","Cliente");
               $datosExcel->getActiveSheet()->setCellValue("L{$colinicial}","Barco");

            $datosreporte=$reportesg->reportetirs_ex($fechaincial, $fechafinal);
               
               
               foreach ($datosreporte as $dr) {
                   $colinicial++;
                   
                $datosExcel->getActiveSheet()->setCellValue('A'.$colinicial,$dr['idtir'])
	                              ->setCellValue('B' . $colinicial, $dr['SerieTir'])
	                              ->setCellValue('C' . $colinicial, $dr['No_Contenedor'])
	                              ->setCellValue('D' . $colinicial, date('d/m/Y', strtotime($dr['fecha'])))
	                              ->setCellValue('E' . $colinicial, $dr['hora'])
                                      ->setCellValue('F' . $colinicial, $dr['chassis'])
                                      ->setCellValue('G' . $colinicial, $dr['tipochassis'])
                                      ->setCellValue('H' . $colinicial, $dr['refrigeracion'])
                                      ->setCellValue('I' . $colinicial, $dr['Nombre_naviera'])
                                      ->setCellValue('J' . $colinicial, $dr['Destino'])
                                      ->setCellValue('K' . $colinicial, $dr['cliente'])
                                      ->setCellValue('L' . $colinicial, $dr['Barco']);
                
                }
               
               
               $nomarchivo="Listado de TIR ".date("dmYHis").".xls";     
               header('Content-Type: application/vnd.ms-excel');
               header('Content-Disposition: attachment;filename="'.$nomarchivo.'"');
               header('Cache-Control: max-age=0');
               
               $objWriter = PHPExcel_IOFactory::createWriter($datosExcel,'Excel5');
               $objWriter->save('php://output');
             
           break;
}
