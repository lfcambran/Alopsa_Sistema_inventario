<?php
ob_start();
session_start();
if (!isset($_SESSION['nombre'])){
    header("Location: login.html");
}else{
    require 'header.php';
    
    if($_SESSION['dashboard']==1){
        ?>
<div class="content-wrapper">
    <section class="content-header">
        <h1> DashBoard <small>Control Panel</small></h1>
         <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
        </ol>
    </section>
    
    <section class="content">
        

            <div class="box box-info">
              <div class="box-body">
                <div class="row">

                  <div class="col-lg-3 col-md-6 col-xs-6">
                      <div class="small-box bg-aqua">
                      <div class="inner">
                          <h3 id="cantidadingresos"></h3>
                          <p>Ingresos Activos</p>
                      </div>
                      <div class="icon">
                         <i class="ion ion-android-subway"></i>
                      </div>
                          <a href="ingresosm.php" class="small-box-footer">Mas info <i class="fa fa-arrow-circle-right"></i></a>
                      </div>
                  </div>
                    
                    <div class="col-lg-3 col-md-6 col-xs-6">
                        <div class="small-box bg-blue">
                            <div class="inner">
                                <h3 id="cantidadtir"></h3>
                                <p>TIRs Ingresados</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-android-document"></i>
                            </div>
                            <a class="small-box-footer"><i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-xs-6">
                        <div class="small-box bg-red">
                              <div class="inner">
                                  <h3 id="cantidadConexion"></h3>
                                  <p>Conexiones Activas</p>
                              </div> 
                            <div class="icon">
                                <i class="ion ion-network"></i>
                            </div>
                            <a class="small-box-footer"><i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                        
                    </div>
                    <div class="col-lg-3 col-md-6 col-xs-6">
                        <div class="small-box bg-purple">
                            <div class="inner">
                                <h3 id="cantidadmovint"></h3>
                                <p>Movimiento Internos</p>
                            </div>
                            <div class="icon">
                            <i class="ion ion-shuffle"></i>
                            </div>
                            <a class="small-box-footer"><i class="fa fa-arrow-circle-right"></i></a>
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
<script src="scripts/dashboard.js"></script>
<?php    
}
ob_end_flush();
?>
