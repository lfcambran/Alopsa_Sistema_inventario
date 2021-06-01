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
                        <h class="box-title"> Exportacion <button class="btn btn-success" id="btnagregar" onclick="mostrarmodal()"><i class="fa fa-plus-circle"></i>  Agregar</button> </h>
                        <div class="box-tools pull-right">
                                    <a href="../vistas/dashboard.php"><button class="btn btn-info"><i class="fa fa-arrow-circle-left"></i> Volver</button></a>
                                </div>
                        <div class="panel-body table-responsive" id="listaexportacion">
                            <table id="tbllistaexportacion" class="table table-striped table-bordered table-condensed table-hover">
                                <thead>
                                <th>Fecha</th>
                                <th>Hora</th>
                                <th>Contenedor</th>
                                <th>Piloto</th>
                                <th>Licencia</th>
                                <th>Barco/Viaje</th>
                                <th>Estado Exportacion</th>
                                <th>Estado Contenedor</th>
                                <th>Opciones</th>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<div class="modal" id="getmodalexpo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"  data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="titulo" name="titulo"></h4>
            </div>
            <div class="modal-body">
                <form name="formularioexpo" id="formularioexpo" method="POST">
                    
                    <div class="box box-info">
                        <div class="box-body">
                            <div class="row">
                                <input type="hidden" id="idexportacion" name="idexportacion">
                                <div class="form-group col-lg-3 col-md-12 col-xs-12">
                                    <label>Fecha Exportacion:</label>
                                    <input type="date" id="fecha" name="fecha" class="form-control" value="<?php  echo date("Y-m-d"); ?>">
                                </div>
                                <div class="form-group col-lg-3 col-md-12 col-xs-12">
                                    <label>Hora Exportacion:</label>
                                    <div class="input-group clockpicker" data-autoclose="true" > 
                                    <input type="text" class="form-control" name="hora" id="hora" value="<?php $hora2 =new DateTime("now", new DateTimeZone(' America/Guatemala')); echo $hora2->format('H:i:s'); ?>">
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-time"></span>
                                    </span>
                                    </div>
                                </div>
                                <div class="form-group col-lg-3 col-md-12 col-xs-12">
                                    <label>Fecha Asignacion:</label>
                                    <input type="date" id="fecha_asig" name="fecha_asig" class="form-control" value="<?php echo date("Y-m-d"); ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-3 col-md-12 col-xs-12">
                                    <label>Contenedor:</label>
                                    <select name="contenedor" id="contenedor" class="form-control select-picker" data-live-search="true">
                                </select>
                                <input type="hidden" id="idingresoc" name="idingresoc">
                                </div>
                                <div id="datoscont"></div>
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
<div class="modal fade" id="getmodalau_exp" name="getmodalau_exp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidde="true"  data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
             <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Autorizacion de Anulacion</h4>
            </div>
            <div class="modal-body">
                <form action="" name="formularioautorizacion" id="formularioautorizacion"method="POST">
                    <div class="form-group col-lg-12 col-md-12 col-xs-12">
                        <input type="hidden" id="id_expo" name="id_expo">
                        <input type="hidden" id="id_ingreso" name="id_ingreso">
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
<script type="text/javascript">
    $('.clockpicker').clockpicker({
        placement: 'bottom',
        donetext: 'Done'
        
    })
</script>
<script src="scripts/exportacion.js"></script>
<?php
    
}

ob_end_flush();
?>