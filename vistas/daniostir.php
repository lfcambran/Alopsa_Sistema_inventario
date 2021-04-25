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
                            <th>serie No.</th>
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
                            <label>Serie:</label>
                            <input type="text" class="form-control" id="serie_tir" name="serie_tir" value="A">
                        </div>
                        <div class="form-group col-lg-3 col-md-12 col-sm-12 col-xs-12">
                            <input id="idintir" name="idintir" type="hidden">
                            <label>Contenedor:</label>
                                <select name="contenedor" id="contenedor" class="form-control select-picker" data-live-search="true">
                                </select>
                                <input type="hidden" id="idingreso" name="idingreso">
                        </div>
                        <div id="datosingreso"></div>
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
                            <label> GATE IN <input type="checkbox" class="minimal" id="checkin" checked="true" ></label>
                            
                           <label> GATE OUT <input type="checkbox" class="minimal" id="checkout"  ></label>
                           
                        </div>
                        <div class="form-group col-lg-2 col-md-3 col-xs-12">
                            <label> Vacio SI <input type="checkbox" class="minimal" id="vaciosi" checked="true"></label>
                            <label> Vacio NO <input type="checkbox" class="minimal" id="vaciono" ></label>
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
                                <input type="checkbox" class="flat-red" id="izquierda">
                                </div>
                            </div>
                            <div class="form-group col-lg-2">
                                <div align="center">
                                    <label>Derecha</label>
                                    <img src="../files/server/derecha.png" alt="" />
                                    <input type="checkbox" class="flat-red" id="derecha">
                                </div>
                            </div>
                            <div class="form-group col-lg-1 col-md-3">
                                <div align="center">
                                    <label> Frente </label>
                                    <img src="../files/server/frente.png" alt=""/>
                                    <input type="checkbox" class="flat-red" id="frente">
                                </div>
                            </div>
                            <div class="form-group col-lg-2">
                                <div align="center">
                                    <label>Interior</label>
                                    <img src="../files/server/interior.png" alt=""/>
                                    <input type="checkbox" class="flat-red" id="interior">
                                </div>
                            </div>
                             <div class="form-group col-lg-1">
                                <div align="center">
                                    <label>Trasero</label>
                                    <img src="../files/server/trasero.png" alt=""/>
                                    <input type="checkbox" class="flat-red" id="trasero">
                                </div>
                            </div>
                             <div class="form-group col-lg-2 ">
                                <div align="center">
                                    <label>Techo</label>
                                    <img src="../files/server/techo.png" alt=""/>
                                    <input type="checkbox" class="flat-red" id="techo">
                                </div>
                            </div>
                             <div class="form-group col-lg-2">
                                <div align="center">
                                    <label>Chasis</label>
                                    <img src="../files/server/chasis.png" alt=""/>
                                    <input type="checkbox" class="flat-red" id="chasis">
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
                                    <option value="inex">Interior/Exterior</option>
                                    <option value="puerta">Puertas</option>
                                    <option value="chasis">Chasis</option>
                                    <option value="llantas">Llantas</option>
                                </select>
                            </div>
                            <div class="form-group col-lg-2 col-md-12 col-sm-12 col-xs-12">
                                <label>Opciones Daños</label>
                                <select name="opcionesd" id="opcionesd" class="form-control select-picker" data-live-search="true"></select>
                            </div>
                            <div class="form-group col-lg-4 col-md-12 col-sm-12 col-xs-12">
                               <label>Observacion</label>
                                <textarea name="observacionf" id="observacionf" class="form-control"></textarea>
                            </div>
                            <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                <div align="center">
                                    <p></p><br>
                                    <button id="agregar" type="button" name="agregar" class="btn btn-success"><i class="fa fa-plus-circle"></i>  Agregar</button>
                                </div>
                            </div>
                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <table id="tablafallastir" class="tabla table-responsive table-striped ">
                                <thead>
                                    <th>#</th>
                                    <th>Ubicacion</th>
                                    <th>Descripcion daño</th>
                                    <th>Opcion</th>
                                    <th>Observaciones</th>
                                    <th>Borrar</th>
                                </thead>
                                <tbody id="table_data">
                                
                                </tbody>
                            </table>
                            </div>
                        </div>
                            <div class="row">
                                <div class="form-group col-lg-6">
                                    <label>Observaciones:</label>
                                    <textarea id="observaciones" name="observaciones" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>  
                   </div>
                </form>
            </div>
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