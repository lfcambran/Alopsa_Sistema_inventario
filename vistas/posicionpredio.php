<?php
ob_start();
session_start();
if (!isset($_SESSION['nombre'])){
    header("Location: login.html");
}else{
    require 'header.php';
    
    if ($_SESSION['ingresoc']==1){
       ?>
<div class="content-wrapper">
    <section class="content">
        <div class="box box-info">
            <div class="box-header">
                
                  <h class="box-title"> Posiciones de Contenedores<button class="btn btn-success" id="btnagregar" onclick="mostrarmodal()"><i class="fa fa-plus-circle"></i>  Agregar</button> </h>
                                <div class="box-tools pull-right">
                                            <a href="../vistas/dashboard.php"><button class="btn btn-info"><i class="fa fa-arrow-circle-left"></i> Volver</button></a>
                                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel-body table-responsive" id="posicionespredioc">
                            <table id="tbllistaposicionc" class="table table-striped table-bordered table-condensed table-hover">
                                <thead>
                                <th>Contenedor</th>
                                <th>Patio</th>
                                <th>Area</th>
                                <th>Bloque</th>
                                <th>Fila</th>
                                <th>Altura</th>
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
<div class="modal fade" id="getmodalcpos" name="getmodalcpos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidde="true"  data-backdrop="static"   data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="titulo" name="titulo"></h4>
            </div>
            <div class="modal-body">
                <form name="formularioposcon" id="formularioposcon" method="POST">
                    <div class="box box-info">
                        <div class="box-body">
                            <div class="form-group col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                <label>Fecha</label>
                                <input type="date" id="fechai" name="fechai" class="form-control" value="<?php echo date("Y-m-d"); ?>">
                            </div>
                            <div class="form-group col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                <label>Hora:</label>
                                <div class="input-group clockpicker" data-autoclose="true">
                                    <input type="text" class="form-control" name="hora" id="hora" value="<?php $hora = new DateTime("now"); echo $hora->format('H:i:s'); ?>">
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-time"></span>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                <label>Contenedor:</label>
                                <select name="contenedor" id='contenedor' class="form-control select-picker" data-live-search='true'>
                                </select>
                            </div>
                            <div id="datosingreso"></div>
                            <div class="form-group col-lg-3 col-md-12 col-xs-12">
                                <label>Patio Predio:</label>
                                <select name="patio" id="patio" class="form-control select-picker" data-live-search='true'></select>
                            </div>
                            <div class="form-group col-lg-2 col-md-12 col-xs-12">
                                <label>Area en Patio</label>
                                <select name="areap" id="areap" class="form-control select-picker" data-live-search="true" required>
                                    
                                </select>
                            </div>
                            <div class="form-group col-lg-2 col-md-12 col-xs-12">
                                <label>Bloque en Area</label>
                                <select name="bloque" id="bloque" class="form-control select-picker" data-live-search="true" required></select>
                            </div>
                            <div class="form-group col-lg-2 col-md-12 col-xs-12">
                                <label>Fila en Bloque</label>
                                <select name="fila" id="fila" class="form-control select-picker" data-live-search="true" required=""></select>
                            </div>
                            <div id="numerofila_c"></div>
                            <div class="form-group col-lg-4 col-md-12 col-xs-12">
                                <label>Observaciones</label>
                                <textarea id="observaciones" name="observaciones" class="form-control"></textarea>
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
<?php
       
    }else{
        require 'noacceso.php';
    }
     require 'footer.php';
     ?>
<script type="text/javascript">
$('.clockpicker').clockpicker({
    donetext: 'Aceptar'
});
</script>
<script src="scripts/posicionprecont.js"></script>
<?php
}
ob_end_flush();
?>