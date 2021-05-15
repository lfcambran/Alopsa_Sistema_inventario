<?php

if (strlen(session_id())<1)
    session_start();

require '../modelos/datostir.php';
require '../modelos/bitacora.php';
date_default_timezone_set("America/Guatemala");
$datosTIR=new datostir;
$bitacora=new bitacora();
$idtir=isset($_POST['idintir'])? limpiarCadena($_POST['idintir']):"";
$contenedor= isset($_POST['contenedor'])? limpiarCadena($_POST['contenedor']):'';
$serietir= isset($_POST['serie_tir'])? limpiarCadena($_POST['serie_tir']):"";
$chasis= isset($_POST['chassis'])? limpiarCadena($_POST['chassis']):"";
$tchassis= isset($_POST['tipochasis'])? limpiarCadena($_POST['tipochasis']):'';
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
$user_id=$_SESSION['idusuario'];
switch ($_GET['op']){
           case 'guardaryeditar':
           if ($tmingreso=='on'){$tipomov='Ingreso'; }else if($tmsalida=='on'){
               $tipomov='Salida';
           }
           if ($consi=='on'){$convasio='si';}else if($conno=='on'){
               $convasio='no';
           }
           if ($izq=='on'){$izqu=1;}else{$izqu=0;}
           if ($der=='on'){$dere=1;}else{$dere=0;}
           if ($fre=='on'){$fren=1;}else{$fren=0;}
           if ($int=='on'){$inte=1;}else{$inte=0;}
           if ($tra=='on'){$tras=1;}else{$tras=0;}
           if ($tec=='on'){$tech=1;}else{$tech=0;}
           if ($cha=='on'){$chas=1;}else{$chas=0;}
           if (empty($idtir)){
               $rspta=$datosTIR->Insertar($serietir,$chasis,$tchassis,$refr,$tcon,$fecha,$hora,$tipomov,$nav,$convasio,$dest,$izqu,$dere,$fren,$inte,$tras,$tech,$chas,$obser,$cli,$contenedor,$idf,$user_id);
               echo json_encode($rspta);
           }else{
               $rspta=$datosTIR->actualizar($idtir,$serietir,$chasis,$tchassis,$refr,$tcon,$fecha,$hora,$tipomov,$nav,$convasio,$dest,$izqu,$dere,$fren,$inte,$tras,$tech,$chas,$obser,$cli,$contenedor,$idf);
               echo json_encode($rspta);
               //echo $rspta ? 'Se Actualizo correctamente el TIR':'Error al actualizar el TIR';
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
                    "11"=>'<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idtir.')"><i class="fa fa-pencil" data-toggle="tooltip" data-placement="top" title="Editar Datos TIR"></i></button>'.' '.'<button class="btn btn-danger btn-xs" onclick="dasactivar('.$reg->idtir.')"><i class="fa fa-close" data-toggle="tooltip" data-placement="top" title="Anular TIR"></i></button>'.' '.'<button class="btn btn-success btn-xs" onclick="cerrartir('.$reg->idtir.')"><i class="fa fa-lock" data-toggle="tooltip" data-placement="top" title="Cerrar TIR"></i></button> '
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
            echo '<div class="form-group col-lg-2 col-md-3 col-xs-12"><label>Tara:</label><input type="text" class="form-control" id="tara" name="tara" value="'.$row['tara'].'" disabled="true"></div>'
                .'<div class="form-group col-lg-3 col-md-3 col-xs-12"><label>Transportista</label><input type="text" class="form-control" value="'.$row['Transporte'].'" disabled="true"><input type="hidden" id="naviera" name="naviera" value="'.$row['Transporte'].'" > </div>'
                .'<div class="form-group col-lg-3 col-md-3 col-xs-12"><label>Piloto</label><input type="text" class="form-control" value="'.$row['Nombre_de_Piloto'].'" disabled="true"></div>'
                .'<div class="form-group col-lg-3 col-md-3 col-xs-12"><label>Licencia</label><input type="text" class="form-control" value="'.$row['Licencias'].'" disabled="true"></div>'
                .'<div class="form-group col-lg-3 col-md-3 col-xs-12"><label>Placas</label><input type="text" class="form-control" value="'.$row['Placas'].'" disabled="true"></div>'
                .'<div class="form-group col-lg-2 col-md-3 col-xs-12"><label>Codigo</label><input type="text" class="form-control" value="'.$row['Codigo_Piloto_Naviera'].'" disabled="true"></div>'
                .'<div class="form-group col-lg-3 col-md-3 col-xs-12"><label>Destino</label><input type="text" class="form-control"  value="'.$row['Destino'].'" disabled="true"><input type="hidden" id="destino" name="destino" value="'.$row['Destino'].'"><input type="hidden" id="idf" name="idf" value="'.$row['Id_f'].'"></div>';

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
       case 'actualizadetalle':
           $dfilas= json_decode($_POST['datosfila'],true);
           $idtir=$_POST['id_tir'];
           $cont=0;
           $notir=0;
           $counitem=0;
           foreach ($dfilas as $filas){
               $item= substr($filas['id_c'], -2);
                $ubica=$filas['ubic'];
                $desc=$filas['descripd'];
                $op=$filas['opcion'];
                $ob=$filas['obser'];
                $pos=$filas['posicion'];
                if ($op=='SI'){
                    $op1=1;
                }else{$op1=0;}
               $rspta=$datosTIR->consultar_item($item,$idtir);
               if ($rspta==1){
                   $rspta=$datosTIR->Actualizar_detalle($item, $idtir, $ubica, $desc, $op1, $pos, $ob);
                   if ($rspta==true){
                       $cont=$cont+1;
                     $notir=$idtir;
                   }
               } else if ($rspta==0){
                   $rspta=$datosTIR->inserta_detalle_tir($idtir,$ubica,$desc,$op1,$pos,$ob);
                    if($rspta==true){
                     $cont=$cont+1;
                     $notir=$idtir;
                    }
                   
               }       
           }
           if ($cont>=1){
                $bitacora=new bitacora();
                $hoy = date("Y/m/d");
                $hora_actual=date("H:i:s");
                $bitacora->insertar_bitacora('Actualizar', $hoy, $hora_actual,$_SESSION['nombre'] ,'Se Actualiza TIR numero '.$notir,'datostir');
            echo 'Up Se ha actualizados los datos del TIR seleccionado';
                
           }else{
                echo 'Error: Error al actualizar notificar al administrador';
           }
           break;
       case 'enviardetalle':
           $insertado=0;
           $notir=0;
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
                     $notir=$item;
                 }
           }
           if ($insertado>=1){
               
                $bitacora=new bitacora();
                $hoy = date("Y/m/d");
                $hora_actual=date("H:i:s");
                $bitacora->insertar_bitacora('Insertar', $hoy, $hora_actual,$_SESSION['nombre'] ,'Se Inserta TIR numero '.$notir,'datostir');
                echo 'In Se ha Insertado los Datos TIR';
           }else {
               echo 'Error: Error al Grabar notificar al administrador';
           }
           break;
       case 'crearselect':
           echo '<div class="form-group col-lg-2 col-md-3 col-xs-12"><label>Posicion</label><select class="form-control" id="posicion" name="Posicion"><option value="izq">Izquierda</option><option value="der">Derecha</option></select></div>';
           break;
       case 'mostrartir':
           $id_tir=$_REQUEST['idtir'];
           $rspta=$datosTIR->mostrar_tir($id_tir);
           echo json_encode($rspta);
           break;
       case 'detalletir':
           $id_tir=$_REQUEST['idtird'];
           $rspta=$datosTIR->listar_detallatir($id_tir);
           $datosdet=array();
           $contador=0;
           while ($reg=$rspta->fetch_object()){
               $contador+=1;
               if ($reg->opcionfalla==1)
               {$opcion='SI';}else{$opcion='NO';}
               $datos[]=array(
                   '0'=>$contador.' - '.$reg->idfalla_tir,
                   '1'=>$reg->ubicacion,
                   '2'=>$reg->falla,
                   '3'=>$opcion,
                   '4'=>$reg->Posicion,
                   '5'=>$reg->observacion,
                   '6'=>'<button type="button" name="remove" id="'.$contador.'" class="btn btn-danger btn_remove">Quitar</button>'
               );
           }
           $resultas=array(
               "sEcho"=>1,
               "iTotalRecords"=> count($datos),
               "iTotalDisplayRecords"=> count($datos),
                "aaData"=>$datos
           );
           echo json_encode($resultas);
           break;
        case 'detalletirc':
            $idtir=$_REQUEST['idtirc'];
            $rspta=$datosTIR->listar_detallatir($idtir);
           $datosdet=array();
           $contador=0;
           while ($reg=$rspta->fetch_object()){
               $contador+=1;
               if ($reg->opcionfalla==1)
               {$opcion='SI';}else{$opcion='NO';}
               $datos[]=array(
                   '0'=>$contador.' - '.$reg->idfalla_tir,
                   '1'=>$reg->ubicacion,
                   '2'=>$reg->falla,
                   '3'=>$opcion,
                   '4'=>$reg->Posicion,
                   '5'=>$reg->observacion
                   
               );
           }
           $resultas=array(
               "sEcho"=>1,
               "iTotalRecords"=> count($datos),
               "iTotalDisplayRecords"=> count($datos),
                "aaData"=>$datos
           );
           echo json_encode($resultas);
        break;     
        case 'desactivar':
            $iddtir=$_REQUEST['id_dtir'];
            $usuarioanula=$_REQUEST['usuarioa'];
            $rspta=$datosTIR->desactivar_tir($iddtir);
            if ($rspta==true){
                
                $bitacora=new bitacora();
                $hoy = date("Y-m-d");
                $hora_actual=date("H:i:s");
                $bitacora->insertar_bitacora('anular', $hoy, $hora_actual,$usuarioanula ,'Se anula TIR numero '.$iddtir,'datostir');
            }
            echo $rspta ? 'El TIR Seleccionado fue desactivado Satisfactoriamente':'No se pudo Desactivar el Documento TIR';
               break;
        case 'cerrar_tir':
                $idtirc=isset($_POST['idtircierre'])? limpiarCadena($_POST['idtircierre']):"";
                $observacionesc=isset($_POST['observacionesc'])? limpiarCadena($_POST['observacionesc']):'';
                $user_idc=$_SESSION['idusuario'];
                $hoy = date("Y/m/d");
                $hora_actual=date("H:i:s");
                $rspta=$datosTIR->insertar_cierre($idtirc,$observacionesc,$user_idc,$hoy,$hora_actual);
                if ($rspta==true){
                
                  $bitacora->insertar_bitacora('Insertar', $hoy, $hora_actual,$_SESSION['nombre'] ,'Cierre de TIR No. '.$idtirc,'datostir');
                }
                 echo $rspta ? 'Se ha cerrado el TIR Satisfactoriamente.':'Error. No se pudo Desactivar el Documento TIR';
               break;
           case 'eliminar_detalle':
               $id_dtir=substr($_REQUEST['iddet_tir'], -2);
               $id_tir=$_REQUEST['id_tir'];
               $rspta=$datosTIR->eliminarDetalle_tir($id_dtir,$id_tir);
               if ($rspta==true){
                    $hoy = date("Y/m/d");
                    $hora_actual=date("H:i:s");
                   $bitacora->insertar_bitacora('Eliminacion', $hoy, $hora_actual, $_SESSION['nombre'], 'Eliminacion de detalle no. '.$id_dtir, 'fallas_tir');
               }
               echo $rspta ? 'Se ha realizado la Eliminacion de detalle seleccionado.':'Error. no se ha eliminado el detalle seleccionado';
               break;
}