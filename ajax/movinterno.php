<?php

if (strlen(session_id())<1)
    session_start();

require '../modelos/movinterno.php';
require '../modelos/bitacora.php';
date_default_timezone_set("America/Guatemala");

$minter=new movinterno;
$bitacora=new bitacora();
$idmovinter= isset($_POST['idmovinterno'])? limpiarCadena($_POST['idmovinterno']):'';
$semana=isset($_POST['semana'])? limpiarCadena($_POST['semana']):'';
$anio=isset($_POST['anio'])? limpiarCadena($_POST['anio']):'';
$fecha=isset($_POST['fechamov'])? limpiarCadena($_POST['fechamov']):'';
$hora=isset($_POST['hingreso'])? limpiarCadena($_POST['hingreso']):'';
$contenedor= isset($_POST['contenedor'])? limpiarCadena($_POST['contenedor']):'';
$bloquea= isset($_POST['bloqueanteriorh'])? limpiarCadena($_POST['bloqueanteriorh']):'';
$med=isset($_POST['medida'])? limpiarCadena($_POST['medida']):'';
$pat=isset($_POST['patio'])? limpiarCadena($_POST['patio']):'';
$idarea= isset($_POST['areap'])? limpiarCadena($_POST['areap']):'';
$idbloque= isset($_POST['bloque'])? limpiarCadena($_POST['bloque']):'';
$cliente= isset($_POST['cliente'])? limpiarCadena($_POST['cliente']):'';
$acti=isset($_POST['actividad'])? limpiarCadena($_POST['actividad']):'';
$motivo= isset($_POST['motivo'])? limpiarCadena($_POST['motivo']):'';
$opcion=isset($_POST['opcion'])? limpiarCadena($_POST['opcion']):'';
$idcontenedor= isset($_POST['idcontenedor'])? limpiarCadena($_POST['idcontenedor']):'';
$user_id=$_SESSION['idusuario'];

switch ($_GET['op']){
    case 'listaringreso':
       $rspta=$minter->listar_ingreso();
        echo '<option value="0">Seleccione Ingreso</option>';
        while ($reg=$rspta->fetch_object()){
            echo '<option value='.$reg->id_ingre_m.'>'.$reg->id_ingre_m.'-'.$reg->No_Contenedor.'</option>';
        }
        break;
    case 'listaringresoc':
       $rspta=$minter->listar_ingresoc();
        echo '<option value="0">Seleccione Ingreso</option>';
        while ($reg=$rspta->fetch_object()){
            echo '<option value='.$reg->id_ingre_m.'>'.$reg->id_ingre_m.'-'.$reg->No_Contenedor.'</option>';
        }
        break;
    case 'listarpatio':
        $rspta=$minter->listar_patio();
        echo '<option value="0">Seleccione Patio</option>';
        while ($reg=$rspta->fetch_object()){
            echo '<option value='.$reg->id_patio.'>'.$reg->id_patio.'-'.$reg->patio_desc.'</option>';
        }
        break;
    case 'listarmedidas':
        $rspta=$minter->medida_contenedor();
        echo '<option value="0">Selecion medida</option>';
        while ($reg=$rspta->fetch_object()){
            echo '<option value='.$reg->id.'>'.$reg->id.'|'.$reg->descripcion.'</option>';
        }
    case 'listararea':
        $idpatio=$_REQUEST['id_patio'];
        if (!empty($idpatio)){
        $rspta=$minter->listar_area($idpatio);
        echo '<option value="0">Seleccione Area</option>';
        while ($reg=$rspta->fetch_object()){
             echo '<option value='.$reg->id_area.'>'.$reg->area.'</option>';
        }    
        }
        break;
    case 'listarbloque':
        $idarea=$_REQUEST['id_area'];
        $rspta=$minter->listar_bloque($idarea);
        echo '<option value="0">Seleccione Bloque</option>';
        while ($reg=$rspta->fetch_object()){
             echo '<option value='.$reg->id_bloque.'>'.$reg->Descripcion.'</option>';
        }    
        
        break;
    case 'mostraropcion':
        echo '<div class="form-group col-lg-2 col-md-12 col-xs-12"><label>DRY/REFF</label><select class="form-control select-picker" data-live-search="true" id="opcion" name="opcion" ><option value="DRY">DRY</option><option value="REFF">REFF</option></select> </div>  ';
        break;
    case 'mostrarbloqueanterior':
        $iding=$_REQUEST['contenedor'];
            $rspta=$minter->bloque_cont($iding);
            echo json_encode($rspta);
        break;
    
    case 'guardareditar':
        if (empty($idmovinterno)){
            $rspta=$minter->insertar($semana,$anio,$fecha,$hora,$contenedor,$bloquea,$med,$pat,$idarea,$idbloque,$cliente,$acti,$motivo,$opcion,$user_id,$idcontenedor);
            if ($rspta==true){
                 $hoy = date("Y/m/d");
                $hora_actual=date("H:i:s");
                $bitacora->insertar_bitacora('Inserta', $hoy, $hora_actual,$_SESSION['nombre'] ,'Movimiento interno realizado','movimientos');
           }
           echo $rspta ? 'Se Realizo el movimiento interno correctamente; Se modifico la posicion del contenedor':'Error: se ha generado un error al grabar';
        }else{
            $rspta=$minter->actualizar($idmovinter,$semana,$anio,$fecha,$hora,$contenedor,$bloquea,$med,$pat,$idarea,$idbloque,$cliente,$acti,$motivo,$opcion,$idcontenedor);
            if ($rspta==true){
                $hoy = date("Y/m/d");
                $hora_actual=date("H:i:s");
                $bitacora->insertar_bitacora('Actualizar', $hoy, $hora_actual,$_SESSION['nombre'] ,'Se ha actualizado el registro numero '.$idposcontpre,'movimientos');
            }
            echo $rspta ? 'Se ha Actualizado el movimiento interno seleccionado satisfactoriamente':'Error: Se ha generado un error al grabar';
        }
        break;
    case 'listar':
        $rspta=$minter->listar_movinterno();
        $datos=Array();
        while ($reg=$rspta->fetch_object()){
            $datos[]=array(
                '0'=>$reg->Id_Movimientos,
                '1'=>$reg->Semana,
                '2'=>$reg->anio,
                '3'=>$reg->Fecha_Movimiento,
                '4'=>$reg->Hora_Ingreso,
                '5'=>$reg->No_Contenedor,
                '6'=>$reg->Medida,
                '7'=>$reg->bnuevo,
                '8'=>$reg->area,
                '9'=>$reg->Cliente,
                '10'=>$reg->Actividad,
                '11'=>$reg->Motivo,
                '12'=>'<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->Id_Movimientos.')"><i class="fa fa-pencil" data-toggle="tooltip" data-placement="top" title="Editar Monitoreo"></i></button>'.' '.'<button class="btn btn-danger btn-xs" onclick="dasactivar('.$reg->Id_Movimientos.')"><i class="fa fa-close" data-toggle="tooltip" data-placement="top" title="Anular"></i></button> '
                    
            );
        }
         $results=array(
            "sEcho"=>1,
            "iTotalRecords"=> count($datos),
            "iTotalDisplayRecords"=> count($datos),
            "aaData"=>$datos
        );
        echo json_encode($results);
        break;
}