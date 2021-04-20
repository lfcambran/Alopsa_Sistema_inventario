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
                        <div class="form-group col-lg-3 col-md-12 col-sm-12 col-xs-12">
                            <input id="idintir" name="idintir" type="hidden">
                            <label>Contenedor:</label>
                        <select name="contenedor" id="contenedor" class="form-control select-picker" data-live-search="true">
                        </select>
                        <input type="hidden" id="idingreso" name="idingreso">
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
<script src="scripts/ingresotir.js"></script>
<?php
}

ob_end_flush();
?>