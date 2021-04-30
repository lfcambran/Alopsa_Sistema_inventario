<?php

if (strlen(session_id())<1)
    session_start();

require '../modelos/datostir.php';
$datosTIR=new datostir;
$idtir=isset($_POST['idintir'])? limpiarCadena($_POST['idintir']):"";
$contenedor= isset($_POST['contenedor'])? limpiarCadena($_POST['contenedor']):'';
$serietir= isset($_POST['serie_tir'])? limpiarCadena($_POST['serie_tir']):"";
$chasis= isset($_POST['chassis'])? limpiarCadena($_POST['chassis']):"";
$tchissis= isset($_POST['tipochasis'])? limpiarCadena($_POST['tipochasis']):'';
$refr=isset($_POST['refrigeracion'])? limpiarCadena($_POST['refrigeracion']):'';
$tcon= isset($_POST['tipocontenedor'])? limpiarCadena($_POST['tipocontenedor']):'';
$fecha= isset($_POST['fecha'])? limpiarCadena($_POST['fecha']):'';
$hora= isset($_POST['hora'])? limpiarCadena($_POST['hora']):'';
$tmingreso= isset($_POST['checkin'])? limpiarCadena($_POST['checkin']):'';
$tmsalida= isset($_POST['checkout'])? limpiarCadena($_POST['checkout']):'';
$consi= isset($_POST['vaciosi'])? limpiarCadena($_POST['vaciosi']):'';
$conno= isset($_POST['vaciono'])? limpiarCadena($_POST['vaciono']):'';
$izq= isset($_POST['izquierda'])? limpiarCadena($_POST['izquierda']):'';
$der= isset($_POST['derecha'])? limpiarCadena($_POST['derecha']):'';
$fre= isset($_POST['frente'])? limpiarCadena($_POST['frente']):'';
$int= isset($_POST['interior'])? limpiarCadena($_POST['interior']):'';
$tra=isset($_POST['trasero'])? limpiarCadena($_POST['trasero']):'';
$tec=isset($_POST['techo'])? limpiarCadena($_POST['techo']):'';
$cha= isset($_POST['chasis'])? limpiarCadena($_POST['chasis']):'';
$obser= isset($_POST['observaciones'])? limpiarCadena($_POST['observaciones']):'';
$cli= isset($_POST['cliente'])? limpiarCadena($_POST['cliente']):'';
$dest= isset($_POST['destino'])? limpiarCadena($_POST['destino']):'';
$nav= isset($_POST['naviera'])? limpiarCadena($_POST['naviera']):'';
$idf = isset($_POST['idf'])? limpiarCadena($_POST['idf']):'';
switch ($_GET['op']){
           case 'guardaryeditar':
           if ($tmingreso==on){
               $tipomov='Ingreso';
           }else if($tmsalida==on){
               $tipomov='Salida';
           }
           if ($consi==on){
               $convasio='si';
           }else if($conno==on){
               $convasio='no';
           }
           if ($izq==on){$izqu=true;}else{$izqu=false;}
           if ($der==on){$dere=true;}else{$dere=false;}
           if ($fre==on){$fren=true;}else{$fren=false;}
           if ($int==on){$inte=true;}else{$inte=false;}
           if ($tra==on){$tras=true;}else{$tras=false;}
           if ($tec==on){$tech=true;}else{$tech=false;}
           if ($cha==on){$chas=true;}else{$chas=false;}
           if (empty($idtir)){
               $rspta=$datosTIR->Insertar();
               echo $rspta ;
           }else{
               
           }
           
           break;
       case 'listar':
           $rspta=$datosTIR->listar();
           $datos_tir=array();
            while ($reg=$rspta->fetch_object()){
                $datos_tir[]=array(
                    "0"=>$reg->No_Contenedor,
                    "1"=>$reg->chassis,
                    "2"=>$reg->SerieTir,
                    "3"=>$reg->fecha,
                    "4"=>$reg->hora,
                    "5"=>$reg->Transporte,
                    "6"=>$reg->Nombre_de_Piloto,
                    "7"=>$reg->Placas,
                    "8"=>$reg->Destino,
                    "9"=>$reg->vacio,
                    "10"=>$reg->cliente,
                    "11"=>'<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idtir.')"><i class="fa fa-pencil" data-toggle="tooltip" data-placement="top" title="Editar Monitoreo"></i></button>'.' '.'<button class="btn btn-danger btn-xs" onclick="dasactivar('.$reg->idtir.')"><i class="fa fa-close" data-toggle="tooltip" data-placement="top" title="Anular Monitoreo"></i></button> '
                );
            }
            $results=array(
            "sEcho"=>1,
            "iTotalRecords"=> count($datos_tir),
            "iTotalDisplayRecords"=> count($datos_tir),
            "aaData"=>$datos_tir
        );
        echo json_encode($results);
           break;
       case 'listaringreso':
        $rspta=$datosTIR->listar_ingreso();
        echo '<option value="0">Selecione Ingreso</option>';
        while ($reg=$rspta->fetch_object()){
            echo '<option value='.$reg->Id_Ingreso.'>'.$reg->Id_Ingreso.'-'.$reg->No_Contenedor.'</option>';
        }
        break;
        
        case 'mostraringreso':
            $idingreso=$_REQUEST['iding'];
            $rspta=$datosTIR->datosingreso($idingreso);
            while ($row= mysqli_fetch_array($rspta)){
            echo '<div class="form-group col-lg-2 col-md-3 col-xs-12"><label>Chassis</label><input type="text" class="form-control" id="chassis" name="chassis" onkeyup="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"></div>'
                . '<div class="form-group col-lg-2 col-md-3 col-xs-12"><label>ORD</label><input type="text" class="form-control" id="ord" name="ord" value="'.$row['ord'].'" disabled="true"></div>'
                .'<div class="form-group col-lg-3 col-md-3 col-xs-12"><label>Transportista</label><input type="text" class="form-control" value="'.$row['Transporte'].'" disabled="true"><input type="hidden" id="naviera" name="naviera" value="'.$row['Transporte'].'" > </div>'
                .'<div class="form-group col-lg-3 col-md-3 col-xs-12"><label>Piloto</label><input type="text" class="form-control" value="'.$row['Nombre_de_Piloto'].'" disabled="true"></div>'
                .'<div class="form-group col-lg-3 col-md-3 col-xs-12"><label>Licencia</label><input type="text" class="form-control" value="'.$row['Licencias'].'" disabled="true"></div>'
                .'<div class="form-group col-lg-3 col-md-3 col-xs-12"><label>Placas</label><input type="text" class="form-control" value="'.$row['Placas'].'" disabled="true"></div>'
                .'<div class="form-group col-lg-2 col-md-3 col-xs-12"><label>Codigo</label><input type="text" class="form-control" value="'.$row['Codigo_Piloto_Naviera'].'" disabled="true"></div>'
                .'<div class="form-group col-lg-3 col-md-3 col-xs-12"><label>Destino</label><input type="text" class="form-control" id="destino" name="destino" value="'.$row['Destino'].'" disabled="true"><input type="hidden" id="idf" name="idf" value="'.$row['Id_f'].'"></div>';

            }
            break;
       case 'listardanios':
           $utfalla=$_REQUEST['udanio'];
           $rspta=$datosTIR->listar_danios($utfalla);
           echo '<option value="0">Seleccione..</option>';
           while ($reg=$rspta->fetch_object()){
               echo '<option value='.$reg->falla.'>'.$reg->falla.'</option>';
           }
           
           break;
       case 'listar_tchasis':
           $rspta=$datosTIR->listar_tchasis();
           echo '<option value="0">Seleccione..</option>';
           while ($reg=$rspta->fetch_object()){
               echo '<option value='.$reg->descripcion.'>'.$reg->descripcion.'</option>';
           }
           break;
       case 'listar_tcontenedor':
           $rspta=$datosTIR->listar_tcontenedores();
           echo '<option value="0">Seleccione..</option>';
           while ($reg=$rspta->fetch_object()){
               echo '<option value='.$reg->descripcion.'>'.$reg->descripcion.'</option>';
           }
           break;

       case 'enviardetalle':
            $insertado=0;
           $dfilas = json_decode($_POST['datosfilas'],true);
           foreach ($dfilas as $filas){
               $item=$filas['val'];
               $ubica=$filas['ubic'];
               $desc=$filas['descripd'];
               $op=$filas['opcion'];
               $ob=$filas['obser'];
               $pos=$filas['posicion'];
               if ($op=='SI'){
                   $op1=1;
               }else{$op1=0;}
                   
                 $rspta=$datosTIR->inserta_detalle_tir($item,$ubica,$desc,$op1,$pos,$ob);
                 if($rspta==true){
                     $insertado=$insertado+1;
                 }
           }
           if ($insertado>=1){
               echo 'Se ha Insertado los Datos Tir';
           }else {
               echo 'Error: Error al Grabar';
           }
           break;
       case 'crearselect':
           echo '<div class="form-group col-lg-2 col-md-3 col-xs-12"><label>Posicion</label><select class="form-control" id="posicion" name="Posicion"><option value="izq">Izquierda</option><option value="der">Derecha</option></select></div>';
           break;
}