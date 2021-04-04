<?php

ob_start();
session_start();
date_default_timezone_set("America/Guatemala");
if (!isset($_SESSION['nombre'])){
    header("Location: login.html");
}else{
    require 'header.php';
    
    If($_SESSION['ingresoc']==1){
        ?>
<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h class="box-title"> Monitoreo de Contenedores <button class="btn btn-success" id="btnagregar" onclick="mostrarform()"><i class="fa fa-plus-circle"></i>  Agregar</button> </h>
                        <div class="box-tools pull-right">
                                    <a href="../vistas/dashboard.php"><button class="btn btn-info"><i class="fa fa-arrow-circle-left"></i> Volver</button></a>
                        </div>
                    </div>
                    <div class="panel-body table-responsive" id="listadeingresos">
                        <table id="tbllistadoingresos" class="table table-striped table-bordered table-condensed table-hover">
                            <thead>
                            <th>Contenedor</th>
                            <th>Hora</th>
                            <th>Producto</th>
                            <th>Set Point</th>
                            <th>Retorno</th>
                            <th>Bloque</th>
                            <th>Posicion</th>
                            <th>Barco</th>
                            <th>fecha</th>
                            <th>Opciones</th>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<div class="modal" id="getmodalm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="titulo" name="titulo"></h4>
            </div>
            <div class="modal-body">
                <form action="" name="formulariom" id="formulariom" method="POST">
                    <div class="row">
                    <div class="form-group col-lg-3 col-md-12 col-sm-12 col-xs-12">
                        <input type="hidden" id="idmonitoreo" name="idmonitoreo">
                        
                        <label>Contenedor:</label>
                        <select name="contenedor" id="contenedor" class="form-control select-picker" data-live-search="true">
                        </select>
                        <input type="hidden" id="idingreso" name="idingreso">
                        
                    </div>
                     
                    <div id="datosingreso"></div>
                    </div> 
                    <div class="row">
                        <div class="form-group col-lg-2 col-md-3 col-xs-12">
                        <label>Hora Monitoreo:</label>
                        <div class="input-group clockpicker">
                            <input type="text" class="form-control" name="horamonitoreo" id="horamonitoreo" value="<?php $hora2 =new DateTime("now", new DateTimeZone(' America/Guatemala')); echo $hora2->format('H:i:s'); ?>">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-time"></span>
                            </span>
                        </div>
                        </div>
                        <div class="form-group col-lg-3 col-md-3 col-xs-12">
                        <label>Fecha:</label>
                        <input type="date" class="form-control" name="fecham" id="fecham" value="<?php  echo date("Y-m-d"); ?>">
                        </div>
                        <div class="form-group col-lg-3 col-md-3 col-xs-12">
                        <label>Retorno:</label>
                        <input type="text" class="form-control" name="retorno" id="retorno" placeholder="Retorno" onkeyup="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
                        </div>
                        <div class="form-group col-lg-3 col-md-3 col-xs-12">
                        <label>Set Point:</label>
                        <input type="text" class="form-control" name="setpoint" id="setpoint" placeholder="Set Point" onkeyup="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
                        </div>
                        <div class="form-group col-lg-3 col-md-3 col-xs-12">
                        <label>Suministro:</label>
                        <input type="text" class="form-control" name="suministro" id="suministro" placeholder="Suministro" onkeyup="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
                        </div>
                        <div class="form-group col-lg-3 col-md-3 col-xs-12">
                        <label>Mecanico:</label>
                        <input type="text" class="form-control" name="mecanico" id="mecanico" placeholder="mecanico" onkeyup="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
                        </div>
                        <div class="form-group col-lg-5 col-md-3 col-xs-4">
                            <label>Observaciones:</label>
                            <textarea class="form-control" id="observaciones" name="observaciones" ></textarea>
                        </div>
                           
                    </div>
                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i>  Grabar</button>
                        <button class="btn btn-danger pull-right" onclick="cancelarform()" data-dismiss="modal" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                    </div>
                    
                </form>
            </div>
            <div class="modal-footer">
            
        </div>
        </div>
        
    </div>
</div>

<div class="modal fade" id="getmodalau_m" nama="getmodalau_m" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidde="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Autorizacion de Anulacion</h4>
            </div>
            <div class="modal-body">
                <form action="" name="formularioautorizacion" id="formularioautorizacion"method="POST">
                    <div class="form-group col-lg-12 col-md-12 col-xs-12">
                        <input type="hidden" id="id_monitoreo" name="id_monitoreo">
                        <label>Usuario:</label>
                        <input type="text" class="form-control" name="usuario" id="usuario">
                        <label>contraseña:</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div
                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <button class="btn btn-primary" type="submit" id="btnGuardar2"><i class="fa fa-close"></i>  Anular</button>
                        <button class="btn btn-danger pull-right" data-dismiss="modal" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
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
<script>
$('.clockpicker').clockpicker({
   placement:'bottom',
   donetext:'Aceptar'
});
</script>
<script src="scripts/monitoreo.js"></script>
<?php
    
}

ob_end_flush();
?>