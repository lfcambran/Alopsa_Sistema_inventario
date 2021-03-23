<?php

if (strlen(session_id())<1)
    session_start ();

require '../modelos/datosmaestro.php';
$datosmaestros = new datosm();
$id= isset($_POST['idingreso'])? limpiarCadena($_POST['idingreso']):"";
$fechai= isset($_POST['fecha_ingreso'])? limpiarCadena($_POST['fecha_ingreso']):"";
$horai= isset($_POST['horaingreso'])? limpiarCadena($_POST['horaingreso']):"";
$contenedor= isset($_POST['nocontenedor'])? limpiarCadena($_POST['nocontenedor']):"";
$barco= isset($_POST['barco'])? limpiarCadena($_POST['barco']):"";
$tipocontenido= isset($_POST['tipoc'])? limpiarCadena($_POST['tipoc']):"";
$descontenido=isset($_POST['dcontenido'])? limpiarCadena($_POST['dcontenido']):"";
$detalleservicio= isset($_POST['dservicio'])? limpiarCadena($_POST['dservicio']):"";
$marchamo= isset($_POST['marchamo'])? limpiarCadena($_POST['marchamo']):"";
$horatir=isset($_POST['htir'])? limpiarCadena($_POST['htir']):"";
$serietir=isset($_POST['serietir'])? limpiarCadena($_POST['serietir']):"";
$producto=isset($_POST['producto'])? limpiarCadena($_POST['producto']):"";
$orden= isset($_POST['orden'])? limpiarCadena($_POST['orden']):"";
$bloque=isset($_POST['bloque'])? limpiarCadena($_POST['bloque']):"";
$posicion=isset($_POST['posicion'])? limpiarCadena($_POST['posicion']):"";
$destino= isset($_POST['destino'])? limpiarCadena($_POST['destino']):"";
$fechaasignacion = isset($_POST['fechaasignacion'])? limpiarCadena($_POST['fechaasignacion']):"";
$idpiloto=isset($_POST['piloto'])? limpiarCadena($_POST['piloto']):"";
$observaciones=isset($_POST['observaciones'])? limpiarCadena($_POST['observaciones']):"";
        
$user_id=$_SESSION['idusuario'];


switch ($_GET["op"]){
    case 'guardaryeditar':
        if (empty($id)){
            $rspta=$datosmaestros->insertar($fechai,$horai,$contenedor,$barco,$tipocontenido,$descontenido,$detalleservicio,$marchamo,$horatir,$serietir,$producto,$orden,$bloque,$posicion,$destino,$fechaasignacion,$idpiloto,$user_id,$observaciones);
            echo $rspta ? 'Ingreso Realizado Exitosamente':'Error al realizar el Ingreso';
        }else {
            $rspta=$datosmaestros->actualizar($id, $fechai,$horai,$contenedor,$barco,$tipocontenido,$descontenido,$detalleservicio,$marchamo,$horatir,$serietir,$producto,$orden,$bloque,$posicion,$destino,$fechaasignacion,$idpiloto,$user_id,$observaciones);
                    
            echo $rspta ? "Datos actualizados correctamente" : "No se pudo actualizar los datos"; 
        }
        
        break;
        
    case 'activar':
        break;
    case 'desactivar':
        break;
    case 'mostrardatos';
        $idingreso=$_REQUEST['idingreso'];
        $rspta=$datosmaestros->mostraringreso($idingreso);
        echo json_encode($rspta);
        break;
    case 'listar':
        $rspta= $datosmaestros->listar();
        $datos=Array();
        
        while ($reg=$rspta->fetch_object()){
            $datos[]=array(
                "0"=>$reg->Nombre_de_Piloto,
                "1"=>$reg->Placas,
                "2"=>$reg->No_Contenedor,
                "3"=>$reg->Marchamo,
                "4"=>$reg->Bloque,
                "5"=>$reg->Posicion,
                "6"=>$reg->producto,
                "7"=>$reg->Barco,
                "8"=>$reg->Destino,
                "9"=>'<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->Id_Ingreso.')"><i class="fa fa-pencil"></i></button>'.' '.'<button class="btn btn-danger btn-xs" onclick="dasactivar('.$reg->Id_Ingreso.')"><i class="fa fa-close"></i></button> '
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