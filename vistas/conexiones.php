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
                        <h class="box-title"> Conexion por Contenedor <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i>  Agregar</button> </h>
                        <div class="box-tools pull-right">
                                    <a href="../vistas/dashboard.php"><button class="btn btn-info"><i class="fa fa-arrow-circle-left"></i> Volver</button></a>
                        </div>
                    </div>
                    <div class="panel-body table-responsive" id="listaconexion">
                        <table id="tbllistadoconexion" class="table table-striped table-bordered table-condensed table-hover">
                            <thead>
                            <th>contenedor</th>
                            <th>Fecha Conexion</th>
                            <th>Hora Conexion</th>
                            <th>Set Point</th>
                            <th>Suministro</th>
                            <th>Retorno</th>
                            <th>No. Ingreso</th>
                            <th>Cabezal</th>
                            <th>Piloto</th>
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
<div class="modal" id="getmodalConexion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="titulo" name="titulo"></h4>
            </div>
            <div class="modal-body">
                <form action="" name="formularioconex" id="formularioconex" method="POST">
                    <div class="row">
                        <div class="form-group col-lg-3 col-md-12 col-sm-12 col-xs-12">
                            <input type="hidden" id="idconexion" name="idconexion">

                            <label>Contenedor:</label>
                            <select name="contenedor" id="contenedor" class="form-control select-picker" data-live-search="true">
                            </select>
                            <input type="hidden" id="idingreso" name="idingreso">

                        </div>
                       <div id="datosingreso"></div>
                       <div class="form-group col-lg-3 col-md-3 col-xs-12">
                        <label>Fecha:</label>
                        <input type="date" class="form-control" name="fechaco" id="fechaco" value="<?php  echo date("Y-m-d"); ?>">
                       </div> 
                       <div class="form-group col-lg-2 col-md-3 col-xs-12">
                        <label>Hora Monitoreo:</label>
                        <div class="input-group clockpicker">
                            <input type="text" class="form-control" name="horaconexion" id="horaconexion" value="<?php $hora2 =new DateTime("now", new DateTimeZone(' America/Guatemala')); echo $hora2->format('H:i:s'); ?>">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-time"></span>
                            </span>
                        </div>
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
                    </div>
                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i>  Grabar</button>
                            <button class="btn btn-danger pull-right" onclick="cancelarform()" data-dismiss="modal" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                    </div>
                    
                </form>
            </div>
            <div class="modal-footer"><div class="row"></div></div>
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
<script src="scripts/conexiones.js"></script>
<?php
    
}

ob_end_flush();
?>