<?php
//activamos almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION['nombre'])) {
  header("Location: login.html");
}else{

 
require 'header.php';

if ($_SESSION['dashboard']==1) {
$user_id=$_SESSION["idusuario"];
  require_once "../modelos/Consultas.php";
  $consulta = new Consultas();
  /*$rsptav = $consulta->cantidadalumnos($user_id);
  $regv=$rsptav->fetch_object();
  $totalestudiantes=$regv->total_alumnos;
  $cap_almacen=3000;*/

 ?>
    <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="row">
        <div class="col-md-12">
      <div class="box">
<div class="panel-body">
<?php  /*$rspta=$consulta->cantidadgrupos($user_id);
$colores = array("box box-success direct-chat direct-chat-success bg-green", "box box-primary direct-chat direct-chat-primary bg-aqua", "box box-warning direct-chat direct-chat-warning bg-yellow", "box box-danger direct-chat direct-chat-danger bg-red");
      while ($reg=$rspta->fetch_object()) {
        $idgrupo=$reg->idgrupo;
        $nombre_grupo=$reg->nombre;*/
        ?>


<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
          <!-- DIRECT CHAT SUCCESS -->
          <div class="<?php //echo $colores[array_rand($colores)]; ?> collapsed-box">
            <div class="box-header with-border">
              <h3 class="box-title"><?php //echo $nombre_grupo; ?></h3>

              <div class="box-tools pull-right">
                <span data-toggle="tooltip" title="" class="badge" data-original-title="Cantidad de Estudiantes">
                  <?php /*
                    $rsptag=$consulta->cantidadg($user_id,$idgrupo);
                    while ($regrupo=$rsptag->fetch_object()) {
                      echo $regrupo->total_alumnos;
                    }*/
                   ?>
                </span>
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                </button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body" style="">
              <!-- Conversations are loaded here -->
              <div class="direct-chat-messages">
                <!-- Message. Default to the left -->
                <div class="direct-chat-msg">

                    <?php /*
                    $rsptas=$consulta->cantidadalumnos_porgrupo($user_id,$idgrupo);
                    while ($reg=$rsptas->fetch_object()) {
                      
                   if (empty($reg->image)){
                    echo ' <img class="img-circle" src="../files/articulos/estudiante.png" height="50px" width="50px">';

                  }else echo '<img class="img-circle" src="../files/articulos/'. $reg->image.'" height="50px" width="50px">';
                     } */?>
                  <!-- /.direct-chat-info -->
                  <!-- /.direct-chat-text -->
                </div>
              </div>
              <!--/.direct-chat-messages-->
              <!-- /.direct-chat-pane -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer" style="">
            <!--  <a href="vista_grupo.php?idgrupo=<?php //echo $idgrupo; ?>" class="btn btn-default form-control" >Ir... <i class="fa fa-arrow-circle-right"></i></a>-->
            </div>
            <!-- /.box-footer-->
          </div>
          <!--/.direct-chat -->
        </div>


<?php // } ?>


</div>

<!--fin centro-->
      </div>
      </div>
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
<?php 
}else{
 require 'noacceso.php'; 
}

require 'footer.php';
 ?>

 <?php 
}

ob_end_flush();
  ?>
