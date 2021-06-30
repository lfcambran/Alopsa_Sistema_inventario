<?php

ob_start();
session_start();
if (!isset($_SESSION['nombre'])){
    header("Location: login.html");
}else{
    require 'header.php';
    
    if ($_SESSION['ingresomov']==1){
   ?>
<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        
                      
                        <div class="box-tools pull-right">
                                    <a href="../vistas/dashboard.php"><button class="btn btn-info"><i class="fa fa-arrow-circle-left"></i> Volver</button></a>
                                </div>
                       
                        <div class="nav-tabs-custom">
                             <ul class="nav nav-tabs">
                                <li ><a href="#movintcab" data-toggle="tab">Movimiento con Cabezal</a></li>
                                <li class="active"><a href="#movinterno" data-toggle="tab">Movimientos Internos</a></li>
                                
                              </ul>
                            <div class="tab-content">
                                <div class="active tab-pane" id="movinterno">
                                    <h4 class="box-title"> Movimientos Interno <button class="btn btn-success" id="btnagregar" onclick="mostrarmodal()"><i class="fa fa-plus-circle"></i>  Agregar</button> </h4>
                                     <div class="panel-body" id="listamov_interno">
                                        <table id="tbllista_movinterno" class="table table-responsive table-striped  table-bordered table-condensed table-hover">
                                            <thead>
                                             <th>No.</th>
                                             <th>Semana</th>
                                             <th>Año</th>
                                             <th>Fecha Movi.</th>
                                             <th>Hora Ingreso</th>
                                             <th>Contenedor</th>
                                             <th>Medida</th>
                                             <th>Bloque</th>
                                             <th>posicion</th>
                                             <th>Cliente</th>
                                             <th>Actividad</th>
                                             <th>motivo</th>
                                            <th>Opciones</th>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane" id="movintcab">
                                    <h4 class="box-title"> Movimientos Interno Cabezales <button class="btn btn-success" id="btnagregar" onclick="mostrarmodalc()"><i class="fa fa-plus-circle"></i>  Agregar</button> </h4>
                                    <div class="panel-body table-responsive" id="listamov_internoc">
                                        <table id="tbllista_movinternoc" class="table table-striped table-bordered table-condensed table-hover ">
                                            <thead>
                                            <th>No.</th>
                                            <th>Semana</th>
                                            <th>Fecha Movi.</th>
                                            <th>Hora Ingreso</th>
                                            <th>Contenedor</th>
                                            <th>Cliente</th>
                                            <th>Actividad</th>
                                            <th>Comentario</th>
                                            <th>Opciones</th>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="modal" id="getmodalmovinterno" name="getmodalmovinterno" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="titulo" name="titulo"></h4>
                                        </div>
                                        <div class="modal-body">
                                            <form name="formularioagregar" id="formularioagregar" method="POST">
                                                <div class="box box-info">
                                                    <div class="box-body">
                                                        <div class="row">
                                                            <input type="hidden" id="idmovinterno" name="idmovinterno"><!-- comment -->
                                                            <div class="form-group col-lg-2 col-md-4 col-xs-4">
                                                                <label>Semana</label>
                                                                <input type="text" class="form-control" id="semana" name="semana" autocomplete="off" placeholder="Semana" onkeyup="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" required=""><!-- comment -->
                                                            </div>
                                                        
                                                        
                                                            <div class="form-group col-lg-2 col-md-4 col-xs-4">
                                                                <label>Año</label>
                                                                <input type="text" class="form-control" id="anio" name="anio" autocomplete="off" placeholder="Año" value="<?php  echo date("Y"); ?>" required="">
                                                            </div>
                                                            
                                                        
                                                            <div class="form-group col-lg-3 col-md-4 col-xs-4">
                                                                <label>Fecha de Mov. Interno</label>
                                                                <input type="date" class="form-control" id="fechamov" name="fechamov" autocomplete="off" placeholder="Fecha de Mov. Interno" value="<?php  echo date("Y-m-d"); ?>" required="">
                                                            </div>
                                                            
                                                            <div class="form-group col-lg-3 col-md-12 col-xs-12">                                                            
                                                            <label>Hora Ingreso</label>
                                                            <div class="input-group clockpicker">
                                                                <input type="text" class="form-control" id="hingreso" name="hingreso" autocomplete="off" placeholder="Hora Ingreso" value="<?php $hora2 =new DateTime("now"); echo $hora2->format('H:i:s');  ?>" required="">
                                                                <span class="input-group-addon">
                                                                    <span class="glyphicon glyphicon-time"></span>
                                                                </span>
                                                            </div>
                                                            </div>   

                                                           
                                                        </div>
                                                        <div class="row">
                                                        
                                                            <div class="form-group col-lg-3 col-md-4 col-xs-4">
                                                                <label>Contenedor</label>
                                                                <select class="form-control select-picker" id="contenedor" name="contenedor" data-live-search="true">
                                                                    </select>
                                                                
                                                            </div>
                                                            <div class="form-group col-lg-2 col-md-12 col-xs-12">
                                                                <label>Bloque Anterior:</label>
                                                                <input type="text" id="bloqueanterior" name="bloqueanterior" class="form-control">
                                                                <input type="hidden" id="bloqueanteriorh" name="bloqueanteriorh">
                                                            </div>
                                                            <div class="form-group col-lg-3 col-md-12 col-xs-12">
                                                                <label>Medida</label>
                                                                <select class="form-control select-picker" id="medida" name="medida" required=""></select>
                                                            </div>
                                                            <div class="form-group col-lg-3 col-md-12 col-xs-12">
                                                                <label>Patio:</label>
                                                                <select name="patio" id="patio" class="form-control select-picker" data-live-search="true" ></select>
                                                            </div>
                                                          </div>
                                                        <div class="row">
                                                            
                                                           <div class="form-group col-lg-3 col-md-12 col-xs-12">
                                                                <label>Area:</label>
                                                                <select class="form-control select-picker" id="areap" name="areap" required=""></select>
                                                            </div>
                                                             <div class="form-group col-lg-3 col-md-12 col-xs-12">
                                                                <label>Bloque</label>
                                                                <select class="form-control select-picker" id="bloque" name="bloque"  required=""></select>
                                                            </div>
                                                            <div class="form-group col-lg-3 col-md-12 col-xs-12">
                                                                <label>Cliente</label>
                                                                <input type="text" class="form-control" id="cliente" name="cliente" autocomplete="off" placeholder="Cliente" onkeyup="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" required="">
                                                            </div>
                                                            <div id="opcion"></div>
                                                        
                                                       
                                                        </div>
                               
                                                        <div class="row">
                                                            <div class="form-group col-lg-4 col-md-4 col-xs-4">
                                                                <label>Actividad</label>
                                                                <input type="text" class="form-control" id="actividad" name="actividad" autocomplete="off" placeholder="Actividad" onkeyup="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" required="" value="MOV. INTERNO">
                                                            </div>
                                                            <div class="form-group col-lg-6 col-md-6 col-xs-6">
                                                            <label>Motivo</label>
                                                            <textarea type="text" class="form-control" id="motivo" name="motivo" autocomplete="off" placeholder="Motivo" onkeyup="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" required=""></textarea>
                                                        </div>
                                                        </div>
                                                    <div class="row">
                                                        <div class="form-group col-lg-12 col-md-12 col-xs-12">
                                                            <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>
                                                            <button class="btn btn-danger pull-right" onclick="cancelarform()" data-dismiss="modal" type="button"><i class="fa fa-close"></i> Cancelar</button>
                                                        </div>
                                                    </div>
                                                    
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            
                            
                        </div>
                        
                       
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<div class="modal" id="getmodalmovic" name="getmodalmovic" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="titulo" name="titulo"></h4>
            </div>
            <div class="modal-body">
                <form name="formularioagregarc" id="formularioagregarc" method="POST">
                    <div class="box box-info">
                        <div class="box-body">
                            <div class="row">
                                <input type="hidden" id="idmovic" name="idmovic"><!-- comment -->
                                <div class="form-group col-lg-4 col-md-4 col-xs-4">
                                    <label>Semana</label>
                                    <input type="text" class="form-control" id="semanac" name="semanac" autocomplete="off" placeholder="Semana" onkeyup="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" required="">
                                </div>
                                <div class="form-group col-lg-4 col-md-4 col-xs-4">
                                    <label>Fecha de Mov. Interno</label>
                                    <input type="date" class="form-control" id="fechamovc" name="fechamovc" autocomplete="off" placeholder="Fecha de Mov. Interno" value="<?php  echo date("Y-m-d"); ?>" required="">
                                </div>
                                <div class="form-group col-lg-4 col-md-4 col-xs-4">
                                    <label>Hora Ingreso</label>
                                    <div class="input-group clockpicker">
                                        <input type="text" class="form-control" id="Hingresoc" name="Hingresoc" autocomplete="off" placeholder="Hora Ingreso" value="<?php $hora2 =new DateTime("now"); echo $hora2->format('H:i:s');  ?>" required="">
                                         <span class="input-group-addon">
                                         <span class="glyphicon glyphicon-time"></span>
                                         </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-4 col-md-4 col-xs-4">
                                  <label>Contenedor</label>
                                    <select class="form-control select-picker" id="contenedorc" name="contenedorc" data-live-search="true">
                                        </select>
                                      <input type="hidden" id="idingresoc" name="idingresoc">
                                </div>
                                <div class="form-group col-lg-4 col-md-4 col-xs-4">
                                    <label>Cliente</label>
                                    <input type="text" class="form-control" id="clientec" name="clientec" autocomplete="off" placeholder="Cliente" onkeyup="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" required="">
                                </div>
                                <div class="form-group col-lg-4 col-md-4 col-xs-4">
                                    <label>Atividad</label>
                                    <input type="text" class="form-control" id="actividadc" name="actividadc" autocomplete="off" placeholder="Actividad" onkeyup="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" required="">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-6 col-md-6 col-xs-6">
                                  <label>Comentario</label>
                                    <textarea type="text" class="form-control" id="comentario" name="comentario" autocomplete="off" placeholder="Comentario" onkeyup="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" required=""></textarea>
                                </div>
                            </div>
                             <div class="row">
                                <div class="form-group col-lg-12 col-md-12 col-xs-12">
                                    <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>
                                    <button class="btn btn-danger pull-right" onclick="cancelarformc()" data-dismiss="modal" type="button"><i class="fa fa-close"></i> Cancelar</button>
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
    } else {
        require 'noacceso.php';
    }
    require 'footer.php';
    ?>
<script>
$('.clockpicker').clockpicker({
    placement:'bottom',
    donetext:'Aceptar'
});

$('.clockpickeri').clockpicker({
    placement:'bottom',
    donetext:'Aceptar'
});
$('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass   : 'iradio_flat-green'
    })
</script>
<script src="scripts/movinterno.js"></script>
<?php
}

ob_end_flush();

