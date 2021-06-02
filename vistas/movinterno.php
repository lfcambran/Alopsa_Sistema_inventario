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
                        <h4 class="box-title"> Movimientos Interno <button class="btn btn-success" id="btnagregar" onclick="mostrarmodal()"><i class="fa fa-plus-circle"></i>  Agregar</button> </h4>
                    <div class="box-tools pull-right">
                                    <a href="../vistas/dashboard.php"><button class="btn btn-info"><i class="fa fa-arrow-circle-left"></i> Volver</button></a>
                                </div>
                        <div class="panel-body" id="listamov_interno">
                            <table id="tbllista_movinterno" class="table table-responsive table-striped table-condensed table-hover">
                                <thead>
                                <th></th>
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
<?php
    } else {
        require 'noacceso.php';
    }
    require 'footer.php';
    ?>
<script src="scripts/movinterno.js"></script>
<?php
}

ob_end_flush();

