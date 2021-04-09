<?php

ob_start();
session_start();
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
                        <h class="box-title"> Desconexion de Contenedores <button class="btn btn-success" id="btnagregar" onclick="mostrarmodal()"><i class="fa fa-plus-circle"></i>  Agregar</button> </h>
                        <div class="box-tools pull-right">
                                    <a href="../vistas/dashboard.php"><button class="btn btn-info"><i class="fa fa-arrow-circle-left"></i> Volver</button></a>
                                </div>
                        <div class="panel-body table-responsive" id="listadesconexion">
                            <table id="tbllisdesconexion" class="table table-striped table-bordered table-condensed table-hover">
                                <thead>
                                <th>Contenedor</th>
                                <th>Fecha</th>
                                <th>Hora</th>
                                <th>Total Horas</th>
                                <th>No. Conexion</th>
                                <th>fecha Ingreso</th>
                                <th>Hora Ingreso</th>
                                <th>Contenido</th>
                                <th>Piloto</th>
                                <th>Cabezal</th>
                                <th>No. Ingreso</th>
                                <th>Opciones</th>    
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<div class="modal" id="getmodaldes" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"  data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="titulo" name="titulo"></h4>
            </div>
        <div class="modal-body">
            <form name="formulariodesc" id="formulariodesc" method="POST">
                <div class="row">
                    <div class="form-group col-lg-3 col-md-12 col-sm-12 col-xs-12">
                        <input type="hidden" id="iddesconexion" name="iddesconexion">
                        <label>Contenedor</label>
                        <select name="contenedor" id="contenedor" class="form-control select-picker" data-live-search="true">
                        </select>
                    </div>
                    <div id="datoscone"></div>
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
        <?php
    }else{
        require 'noacceso.php';
    }
    require 'footer.php';
    ?>
<script src="scripts/desconexiones.js"></script>
<?php
    
}

ob_end_flush();
?>