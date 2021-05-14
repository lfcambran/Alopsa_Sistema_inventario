<?php

ob_start();
session_start();
date_default_timezone_set("America/Guatemala");

if (!isset($_SESSION['nombre'])){
    header("Location: login.html");
}else{
    require 'header.php';
    
    if ($_SESSION['ingresoc']==1){
        ?>
<div class="content-wrapper">
    <section class="content-header">
        <h1><small> TIR </small></h1>
         <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Ingresos TIR</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h class="box-title"> Ingresos de Contenedores TIR <button class="btn btn-success" id="btnagregar" onclick="mostrarmodal()"><i class="fa fa-plus-circle"></i>  Agregar</button> </h>
                        <div class="box-tools pull-right">
                                    <a href="../vistas/dashboard.php"><button class="btn btn-info"><i class="fa fa-arrow-circle-left"></i> Volver</button></a>
                        </div>
                    </div>
                    <div class="panel-body table-responsive" id="listadotir">
                        <table id="tbllistadotir" class="table table-striped table-bordered table-condensed table-hover">
                            <thead>
                            <th>Contenedor</th>
                            <th>Chasis</th>
                            <th>serie</th>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Transportista</th>
                            <th>Piloto</th>
                            <th>Placas</th>
                            <th>Destino</th>
                            <th>Vacio</th>
                            <th>Cliente</th>
                            <th>Opciones</th>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<div class="modal fade" id="getmodaltir" name="getmodaltir" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidde="true"  data-backdrop="static"   data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="titulo" name="titulo"></h4>
            </div>
            <div class="modal-body">
                <form name="formulariotir" id="formulariotir" method="POST">

                    <div class="row">
                          <div class="form-group col-lg-1 col-md-12 col-sm-12 col-xs-12">
                              <input id="idintir" name="idintir" type="hidden">
                              <label>Serie:</label>
                            <input type="text" class="form-control" id="serie_tir" name="serie_tir" value="A">
                        </div>
                        <div class="form-group col-lg-3 col-md-12 col-sm-12 col-xs-12">
                          
                            <label>Contenedor:</label>
                                <select name="contenedor" id="contenedor" class="form-control select-picker" data-live-search="true">
                                </select>
                                <input type="hidden" id="idingreso" name="idingreso">
                        </div>
                        <div id="datosingreso"></div>
                        <div class="form-group col-lg-2 col-md-3 col-xs-12">
                            <label>Chassis</label>
                            <input type="text" class="form-control" id="chassis" name="chassis" onkeyup="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
                        </div>
                        <div class="form-group col-lg-3 col-md-12 col-sm-12 col-xs-12">
                            <label>Tamaño Chasis:</label>
                            <select id="tipochasis" name="tipochasis" class="form-control select-picker" data-live-search="true"></select>
                        </div>
                        <div class="form-group col-lg-2 col-md-12 col-sm-12 col-xs-12">
                            <label>Refrigeracion</label>
                            <select id='refrigeracion' name="refrigeracion" class="form-control select-picker">
                                <option value="">Seleccione..</option>
                                <option value="gens">Gens</option>
                                <option value="reef">Reef</option>
                                <option value="seco">Seco</option>
                            </select>
                        </div>
                        <div class="form-group col-lg-2 col-md-12 col-sm-12 col-xs-12">
                            <label>Tipo Contenedor:</label>
                            <select id='tipocontenedor' name="tipocontenedor" class="form-control select-picker" data-live-search="true"></select>
                        </div>
                    </div>
                    <div class="row">
                          <div class="form-group col-lg-3 col-md-3 col-xs-12">
                            <label>Fecha:</label>
                            <input type="date" class="form-control" name="fecha" id="fecha" value="<?php  echo date("Y-m-d"); ?>">
                          </div> 
                          <div class="form-group col-lg-3 col-md-3 col-xs-12">
                          <label>Hora:</label>
                            <div class="input-group clockpicker" data-autoclose="true" > 
                            <input type="text" class="form-control" name="hora" id="hora" value="<?php $hora2 =new DateTime("now", new DateTimeZone(' America/Guatemala')); echo $hora2->format('H:i:s'); ?>">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-time"></span>
                            </span>
                            </div>
                          </div>
                        <div class="form-group col-lg-2 col-md-3 col-xs-12">
                            <label> GATE IN <input type="checkbox" class="minimal" id="checkin" name="checkin" checked="true" ></label>
                            <label> GATE OUT <input type="checkbox" class="minimal" id="checkout" name="checkout" ></label>
                           
                        </div>
                        <div class="form-group col-lg-2 col-md-3 col-xs-12">
                            <label> Vacio SI <input type="checkbox" class="minimal" id="vaciosi" name="vaciosi" checked="true"></label>
                            <label> Vacio NO <input type="checkbox" class="minimal" id="vaciono" name="vaciono" ></label>
                        </div>
                    </div>
                    <div class="box box-info">
                        <div class="box-header">
                            <h5 class="box-title">Daños Contenedor</h5>
                        </div>
                        <div class="box-body">
                            <div class="form-group col-lg-2">
                                <div align="center">
                                <label>Izquierda</label>
                                <img src="../files/server/izquierda.png" alt=""/>
                                <input type="checkbox" class="flat-red" id="izquierda" name="izquierda">
                                </div>
                            </div>
                            <div class="form-group col-lg-2">
                                <div align="center">
                                    <label>Derecha</label>
                                    <img src="../files/server/derecha.png" alt="" />
                                    <input type="checkbox" class="flat-red" id="derecha" name="derecha">
                                </div>
                            </div>
                            <div class="form-group col-lg-1 col-md-3">
                                <div align="center">
                                    <label> Frente </label>
                                    <img src="../files/server/frente.png" alt=""/>
                                    <input type="checkbox" class="flat-red" id="frente" name="frente">
                                </div>
                            </div>
                            <div class="form-group col-lg-2">
                                <div align="center">
                                    <label>Interior</label>
                                    <img src="../files/server/interior.png" alt=""/>
                                    <input type="checkbox" class="flat-red" id="interior" name="interio">
                                </div>
                            </div>
                             <div class="form-group col-lg-1">
                                <div align="center">
                                    <label>Trasero</label>
                                    <img src="../files/server/trasero.png" alt=""/>
                                    <input type="checkbox" class="flat-red" id="trasero" name="trasero">
                                </div>
                            </div>
                             <div class="form-group col-lg-2 ">
                                <div align="center">
                                    <label>Techo</label>
                                    <img src="../files/server/techo.png" alt=""/>
                                    <input type="checkbox" class="flat-red" id="techo" name="techo">
                                </div>
                            </div>
                             <div class="form-group col-lg-2">
                                <div align="center">
                                    <label>Chasis</label>
                                    <img src="../files/server/chasis.png" alt=""/>
                                    <input type="checkbox" class="flat-red" id="chasis" name="chasis">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box box-success">
                         <div class="box-header">
                             <h4 class="box-title">Contenedores</h4>
                          </div>
                   
                        <div class="box-body">
                            
                        <div class="row">
                            <div class="form-group col-lg-3">
                                <label>Daños/Faltantes</label>
                                 <select name="ubicacion" id="ubicacion" class="form-control select-picker" data-live-search="true">
                                     <option value="">Seleccione..</option>
                                    <option value="int">Interior</option>
                                    <option value="ext">Exterior</option>
                                    <option value="puerta">Puertas</option>
                                    <option value="chasis">Chasis</option>
                                    <option value="llantas">Llantas</option>
                                    <option value="marcham">Marchamos</option>
                                </select>
                            </div>
                            <div class="form-group col-lg-2 col-md-12 col-sm-12 col-xs-12">
                                <label>Opciones Daños</label>
                                <select name="opcionesd" id="opcionesd" class="form-control select-picker" data-live-search="true"></select>
                            </div>
                            <div id="select_esp"></div>
                            <div class="form-group col-lg-4 col-md-12 col-sm-12 col-xs-12">
                               <label>Observacion</label>
                                <textarea name="observacionf" id="observacionf" class="form-control"></textarea>
                            </div>
                            <div class="form-group col-lg-2 col-md-3 col-sm-3 col-xs-3">
                                <div align="center">
                                    <p></p><br>
                                    <button id="agregar" type="button" name="agregar" class="btn btn-success"><i class="fa fa-plus-circle"></i>  Agregar</button>
                                </div>
                            </div>
                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                               <div class="panel-body table-responsive"> 
                                    <table id="tablafallastir" class="table table-striped " style="width: 100%;">
                                        <thead>
                                            <th>#</th>
                                            <th>Ubicacion</th>
                                            <th>Descripcion daño</th>
                                            <th>Opcion</th>
                                            <th>posicion</th>
                                            <th>Observaciones</th>
                                            <th>Borrar</th>
                                        </thead>
                                        <tbody id="table_data">

                                        </tbody>
                                    </table>
                               </div>
                            </div>
                        </div>
                            <div class="row">
                                <div class="form-group col-lg-6">
                                    <label>Observaciones:</label>
                                    <textarea id="observaciones" name="observaciones" class="form-control"></textarea>
                                </div>
                                <div class="form-group col-lg-3">
                                    <label>Cliente</label>
                                    <input type="text" id="cliente" name="cliente" class="form-control">
                                </div>
                            </div>
                        </div>  
                        
                   </div>
                     <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i>  Grabar</button>
                        
                        <button class="btn btn-danger pull-right" onclick="cancelarform()" data-dismiss="modal" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer"></div>
        </div>
        
    </div>
</div> 
<div class="modal fade" id="getmodalatir" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidde="true"  data-backdrop="static" 
  data-keyboard="false">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Autorizacion de Anulacion</h4>
            </div>
            <div class="modal-body">
                <form action="" name="formularioanulatir" id="formularioanulatir" method="POST">
                    <div class="form-group col-lg-12 col-md-12 col-xs-12">
                        <input type="hidden" id="id_tiranular" name="id_tiranular">
                        <input type="hidden" id="idb" name="idb">
                        <input type="hidden" id="idp" name="idp">
                        <label>Usuario:</label>
                        <input type="text" class="form-control" name="usuario" id="usuario">
                        <label>Contraseña:</label>
                        <input type="password" class="form-control" name="password" id="password">
                    </div>
                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <button class="btn btn-primary" type="submit" id="btnGuardar2"><i class="fa fa-close"></i>  Anular</button>
                        <button class="btn btn-danger pull-right" data-dismiss="modal" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="getmodalcerrar" tabindex="-1" role="dialog" aria-labelledby="myModalLbael" aria-hidde="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="titulo2" name="titulo2"></h4>
            </div>
            <div class="modal-body">
                <form name="formulario_cierre" id="formulario_cierre" method="POST">
                    <div class="row">
                        <div class="form-group col-lg-2 col-md-12 col-xs-12">
                           <input type="hidden" id="idtircierre" name="idtircierre">
                            <label>serie</label>
                            <input type="text" id="seriec" name="seriec" class="form-control" disabled="true">
                        </div>
                        <div class="form-group col-lg-2 col-md-12 col-xs-12">
   
                              <label>Contenedor:</label>
                                <select name="contenedor2" id="contenedor2" class="form-control select-picker" data-live-search="true">
                                </select>
                              <input type="hidden" id="idingresoc" name="idingresoc">
                        </div>
                        <div id="datosingreso2"></div>
               
                        <div class="form-group col-lg-3 col-md-3 col-xs-12">
                            <label> GATE IN <input type="checkbox" class="minimal" id="checkinc" name="checkinc" ></label>
                            <label> GATE OUT <input type="checkbox" class="minimal" id="checkoutc" name="checkoutc" ></label>
                           
                        </div>
                        <div class="form-group col-lg-2 col-md-3 col-xs-12">
                            <label>chassis</label>
                            <input type="text" class="form-control" id="chassisc" name="chassisc" disabled="">
                        </div>
                        <div class="form-group col-lg-3 col-md-12 col-xs-12">
                            <label>Fecha</label>
                            <input type="date" id="fechac" name="fechac" class="form-control" disabled="">
                        </div>
                        <div class="form-group col-lg-2 col-md-12 col-xs-12">
                            <label>Hora</label>
                            <input type="time" id="horac" name="horac" class="form-control" disabled="">
                        </div>
                    </div>
                     <div class="box box-info">
                        <div class="box-header">
                            <h5 class="box-title">Daños Contenedor</h5>
                        </div>
                         <div class="box-body">
                                <div class="form-group col-lg-2">
                                    <div align="center">
                                    <label>Izquierda</label>
                                    <input type="checkbox" class="flat-red" id="izquierdac" name="izquierdac">
                                    </div>
                                </div>
                                <div class="form-group col-lg-2">
                                    <div align="center">
                                        <label>Derecha</label>
                                        <input type="checkbox" class="flat-red" id="derechac" name="derechac">
                                    </div>
                                </div>
                                <div class="form-group col-lg-2">
                                    <div align="center">
                                        <label>Frente</label>
                                        <input type="checkbox" class="flat-red" id="frentec" name="frentec">
                                    </div>
                                </div>
                                <div class="form-group col-lg-2">
                                    <div align="center">
                                        <label>Interior</label>
                                        <input type="checkbox" class="flat-red" id="interiorc" name="interiorc">
                                    </div>
                                </div>
                                <div class="form-group col-lg-2">
                                    <div align="center">
                                        <label>Trasero</label>
                                        <input type="checkbox" class="flat-red" id="traseroc" name="traseroc">
                                    </div>
                                </div>
                                <div class="form-group col-lg-2">
                                    <div align="center">
                                        <label>Techo</label>
                                        <input type="checkbox" class="flat-red" id="techoc" name="techoc">
                                    </div>
                                </div>
                                <div class="form-group col-lg-2">
                                    <div align="center">
                                    <label>Chasisi</label>
                                    <input type="checkbox" class="flat-red" id="chasisc" name="chasisc">
                                    </div>
                                </div>
                         </div>
                     </div>
                    <div class="box box-success">
                        <div class="box-header">
                            <h4 class='box-title'>Listado Daños</h4>

                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class='panel-body table-responsive'>
                                        <table id="listdanioconte" class="table table-striped" style="width: 100%">
                                            <thead>
                                                <th>#</th>
                                                <th>Ubicacion</th>
                                                <th>Descripcion daño</th>
                                                <th>Opcion</th>
                                                <th>posicion</th>
                                                <th>Observaciones</th>
                                            </thead>
                                            <tbody id="table_datac">

                                        </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="form-group col-lg-6 col-md-12 col-sm-12 col-xs-12">
                        <label>Observaciones</label>
                        <textarea id="observacionesc" name="observacionesc" class="form-control"></textarea>
                    </div>
                    <p></p>
                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <button class="btn btn-success" type="submit" id="btnGuardar3"><i class="fa fa-lock"></i>  Cerrar</button>
                        <button class="btn btn-danger pull-right" data-dismiss="modal" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>

    <?php    
    }else{
        require 'noacceso.php';
    }
    require 'footer.php';
    
    ?>
<script  type="text/javascript">

$('.clockpicker').clockpicker({
     donetext: 'Done'
});

 //iCheck for checkbox and radio inputs
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass   : 'iradio_minimal-blue'
    })
    //Red color scheme for iCheck
    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
      checkboxClass: 'icheckbox_minimal-red',
      radioClass   : 'iradio_minimal-red'
    })
    //Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass   : 'iradio_flat-green'
    })
</script>
<script src="scripts/ingresotir.js"></script>
<?php
}

ob_end_flush();
?>