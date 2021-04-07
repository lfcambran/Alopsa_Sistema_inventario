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
                        <h class="box-title"> Desconexion de Contenedores <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i>  Agregar</button> </h>
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