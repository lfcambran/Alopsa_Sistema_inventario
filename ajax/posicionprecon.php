<?php

if (strlen(session_id())<1)
    session_start();

require '../modelos/posicion_contenedor_predio.php';
date_default_timezone_set("America/Guatemala");
$posicion_conte=new posicion_cont_predio();

switch ($_GET['op']){
    case 'listaringreso':
        $rspta=$posicion_conte->listar_ingresos_conte();
        echo '<option value="0">Selecione Ingreso</option>';
        while ($reg=$rspta->fetch_object()){
            echo '<option value='.$reg->Id_Ingreso.'>'.$reg->Id_Ingreso.'-'.$reg->No_Contenedor.'</option>';
        }
     break;
    case 'listapatio':
        $rspta=$posicion_conte->listar_patio();
        echo '<option value="0">Selecione Ingreso</option>';
        while ($reg=$rspta->fetch_object()){
            echo '<option value='.$reg->id_patio.'>'.$reg->id_patio.'-'.$reg->patio_desc.'</option>';
        }
        break;
    case 'listararea':
        $idpatio=$_REQUEST['id_patio'];
        $rspta=$posicion_conte->listar_area($idpatio);
        echo '<option value="0">Seleccione Area</option>';
        while ($reg=$rspta->fetch_object()){
             echo '<option value='.$reg->id_area.'>'.$reg->id_patio.'-'.$reg->area.'</option>';
        }    
        
        break;
    case 'listarbloque':
        $idarea=$_REQUEST['id_area'];
        $rspta=$posicion_conte->listar_bloque($idarea);
        echo '<option value="0">Seleccione Bloque</option>';
        while ($reg=$rspta->fetch_object()){
             echo '<option value='.$reg->id_bloque.'>'.$reg->area.'-'.$reg->Descripcion.'</option>';
        }    
        
        break;
    case 'listarfila':
        $idbloque=$_REQUEST['id_bloque'];
        $rspta=$posicion_conte->listar_fila($idbloque);
        echo '<option value="0">Seleccione Fila</option>';
        while ($reg=$rspta->fetch_object()){
             echo '<option value='.$reg->idfila.'>'.$reg->Descripcion.'-'.$reg->fila.'</option>';
        } 
        break;
    case 'alturafila':
        $idfila=$_REQUEST['id_fila'];
        $rspta=$posicion_conte->numero_altura($idfila);
        while ($row= mysqli_fetch_array($rspta)){
            echo '<div class="form-group col-lg-2 col-md-3 col-xs-12"><label id="altura" name="altura">Altura:</label><input type="text" class="form-control" name="noaltura" id="noaltura" value="'.$row['altura'].'"></div>';
        }
        break;
    case 'mostraringreso':
        $id_ingreso=$_REQUEST['idingreso'];
        $rspta=$posicion_conte->datosingresoco($id_ingreso);
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
}

?>