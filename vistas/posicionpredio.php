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
                                <th>contenedor</th>
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
<script src="scripts/posicionprecont.js"></script>
<?php
}
ob_end_flush();
?>