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

                  <div class="col-lg-3 col-xs-6">
                      <div class="small-box bg-aqua">
                      <div class="inner">
                          <h3>5</h3>
                          <p>Ingresos Nuevos</p>
                      </div>
                      <div class="icon">
                         <i class="ion ion-android-subway"></i>
                      </div>
                          <a href="ingresosm.php" class="small-box-footer">Mas info <i class="fa fa-arrow-circle-right"></i></a>
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
