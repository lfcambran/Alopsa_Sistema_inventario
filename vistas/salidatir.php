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
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h class="box-title"> Salida TIR  <button class="btn btn-success" id="btnagregar" onclick="mostrarmodal()"><i class="fa fa-plus-circle"></i>   Agregar</button> </h>
                                <div class="box-tools pull-right">
                                    <a href="../vistas/dashboard.php"><button class="btn btn-info"><i class="fa fa-arrow-circle-left"></i> Volver</button></a>
                                </div>
                        <div class="panel-body table-responsive" id="listatirsalida">
                            <table id="tbllistadotirsa" class="table table-striped table-bordered table-condensed table-hover">
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
        </div>
    </section>
</div>
<div class="modal fade" id="getmodaltirs" name="getmodaltirs" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidde="true"  data-backdrop="static"   data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="titulo" name="titulo"></h4>
            </div>
            <div class="modal-body">
                <form name="formulariotirs" id="formulariotirs" method="POST">
                    <input id="idtirsa" name="idtirsa" type="hidden">
                    <div class="row">
                        <div class="form-group col-lg-1 col-md-12 col-sm-12 col-xs-12">
                              <input id="idintir" name="idintir" type="hidden">
                              <label>Serie:</label>
                            <input type="text" class="form-control" id="serie_tir" name="serie_tir" value="A">
                        </div>
                        <div class="form-group col-lg-3 col-md-12 col-sm-12 col-xs-12">
                          
                            <label>TIR:</label>
                                <select name="notir" id="notir" class="form-control select-picker" data-live-search="true">
                                </select>
                                <input type="hidden" id="idtir" name="idtir">
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i>  Grabar</button>
                        
                            <button class="btn btn-danger pull-right" onclick="cancelarform()" data-dismiss="modal" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                        </div>
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
<script src="scripts/salidatir.js"></script>

<?php
}
ob_end_flush();
?>