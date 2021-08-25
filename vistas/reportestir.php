<?php
ob_start();
session_start();
date_default_timezone_set("America/Guatemala");
if (!isset($_SESSION['nombre'])){
    header("Location: login.html");
}else{
    require 'header.php';
    require 'funciones.php';
    if ($_SESSION['reporte']==1){
        ?>
<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h class="box-title"> Listado de TIRs </h>
                        <div class="box-tools pull-right">
                                    <a href="../vistas/dashboard.php"><button class="btn btn-info"><i class="fa fa-arrow-circle-left"></i> Volver</button></a>
                                </div>
                        <div class="row">
                            <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">
                                <label>Fecha Inicial:</label>
                                <input type="date" id="fechainicial" name="fechainicial" class="form-control" value="<?php  echo _primer_dia_mes(); ?>">
                                
                            </div>
                            <div class="form-group col-lg-2 col-md-12 col-sm-12 col-xs-12">
                                <label>Fecha Final:</label>
                                <input type="date" id="fechafinal" name="fechafinal" class="form-control" value="<?php echo _ultimo_dia_mes(); ?>">
                            </div>
                            <div class="form-group col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                </br>
                                <button class="btn btn-primary" id="verreporte" name="verreporte" onclick="mostrarre()"><i class="fa fa-files-o"></i>  Ver Reporte</button>
                                <button class="btn btn-info" id="exportar" name="exportar" onclick="exportar()"><i class="fa fa-arrow-circle-o-down"></i> Exportar Reporte</button>
                                <button class="btn btn-success" id="exportarexcel" name="exportarexcel" onclick="exportarex()"><i class="fa fa-file-excel-o"></i> Exportar Excel</button>
                            </div>
                          
                            
                        </div>
                        <div class="panel-body table-responsive" id="listatirs">
                            <table id="tbllistadortir" class="table table-striped table-bordered table-condensed table-hover">
                                <thead>
                                <th>No.</th>
                                    <th>Numero TIR</th>
                                    <th>Contenedor</th>
                                    <th>Chasis</th>
                                    <th>Serie</th>
                                    <th>Fecha</th>
                                    <th>Hora</th>
                                    <th>Destino</th>
                                    <th>Cliente</th>
                                    <th>Barco</th>
                                    <th>Tipo Mov.</th>
                                    <th>Ver</th>
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
<script src="scripts/reportestir.js"></script>
<?php    
}
ob_end_flush();
?>

