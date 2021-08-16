 <?php 
 
if (strlen(session_id())<1) 
  session_start();
require '../ajax/sessionphp.php';
date_default_timezone_set("America/Guatemala");
$sessiones=new sessiones();
//$sessiones->tiempoactivo();
if ($_SESSION['seccionactiva']=='activo'){
    echo'<script type="text/javascript">
    alert("La ultima Sesion no fue cerrada correctamente. Sesion Actualizada");
    </script>';
    $_SESSION['seccionactiva']='';
}
  ?>
 <!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <title>Sistema Alopsa|Contenedores</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="../public/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../public/css/font-awesome.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../public/css/AdminLTE.min.css">
     <link rel="stylesheet" href="../public/Ionicons/css/ionicons.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="../public/css/_all-skins.min.css">
    
    <!--<link rel="apple-touch-icon" href="../public/img/apple-touch-icon.png">-->
    <link rel="shortcut icon" href="../public/img/favicon.ico">
    <link rel="stylesheet" href="../public/iCheck/all.css">
    <!-- DATATABLES -->
    <link rel="stylesheet" type="text/css" href="../public/datatables/jquery.dataTables.min.css">    
    <link href="../public/datatables/buttons.dataTables.min.css" rel="stylesheet"/>
    <link href="../public/datatables/responsive.dataTables.min.css" rel="stylesheet"/>
    
    <link rel="stylesheet" type="text/css" href="../public/css/bootstrap-select.min.css">
    <link rel="stylesheet" type="text/css" href="../public/clockpicker/jquery-clockpicker.css">
    <link rel="stylesheet" type="text/css" href="../public/clockpicker/bootstrap-clockpicker.min.css">
   
    <link rel="stylesheet" type="text/css" href="../public/morris/morris.css" />
  </head>

<body class="hold-transition skin-blue sidebar-mini">
  <!-- Load Facebook SDK for JavaScript -->
<div id="fb-root"></div>



<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="dashboard.php" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>INV</b> Con</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Inv</b> Contenedores</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Navegación</span>
          </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">

          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
			<?php   
                    if ($_SESSION['imagen']==""){
                        ?>
                <img src="../files/server/usuario.png" class="user-image" alt="User Image">
                   <?php
                    }else{
                        ?>
                        <img src="../files/usuarios/<?php echo $_SESSION['imagen']; ?>" class="user-image" alt="User Image">
                   <?php
                   }?>
			<span class="hidden-xs"><?php echo $_SESSION['nombre']; ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                 <?php
                   if ($_SESSION['imagen']==""){?>
                  <img src="../files/server/usuario.png" class="img-circle" alt="User Image">
                  <?php
                  }else{?>
                <img src="../files/usuarios/<?php echo $_SESSION['imagen']; ?>" class="img-circle" alt="User Image">
                  <?php } ?>
                <p>
                  <?php echo $_SESSION['nombre'].' '.$_SESSION['cargo']; ?>
                </p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                 <!-- <a href="#" class="btn btn-default btn-flat">Cambiar Contraseña</a>-->
                </div>
                <div class="pull-right">
                  <a href="../ajax/usuario.php?op=salir" class="btn btn-default btn-flat">Salir</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->

        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
     
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">

<br>
       <?php 
if ($_SESSION['dashboard']==1) {
  echo ' <li><a href="../vistas/dashboard.php"><i class="fa  fa-dashboard (alias)"></i> <span>Dashboard</span></a>
        </li>';
}
        ?> 


     <?php 
if ($_SESSION['ingresoc']==1) {
  echo '<li class="treeview">
          <a href="#">
            <i class="fa fa-truck"></i> <span>Ingreso Contenedores</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="ingresosm.php"><i class="fa fa-ship"></i>Ingreso Maestro</a></li>
          </ul>
          <ul class="treeview-menu">
            <li><a href="daniostir.php"><i class="fa fa-calendar-times-o"></i>Daños TIR</a></li>
          </ul>
          <ul class="treeview-menu">
            <li><a href="posicionpredio.php"><i class="fa fa-caret-square-o-left"></i>Posicion Predio</a></li>
          </ul>
          
          <ul class="treeview-menu">
            <li><a href="conexiones.php"><i class="fa fa-plug"></i>Conexion</a></li>
          </ul>
           <ul class="treeview-menu">
            <li><a href="monitoreo.php"><i class="fa fa-desktop"></i>Monitoreo</a></li>
          </ul>
          <ul class="treeview-menu">
          <li><a href="desconexiones.php"><i class="fa fa-minus-circle"></i>Desconexion</a></li>
          </ul>
          <!--<ul class="treeview-menu">
          <li><a href="asignaciones.php"><i class="fa fa-plus-square"></i>Asignaciones</a></li>
          </ul>-->
            <ul class="treeview-menu">
          <li><a href="exportacion.php"><i class="fa fa-share-alt"></i>Exportaciones</a></li>
          </ul>
        </li>
        ';
}   
if ($_SESSION['ingresomov']==1){
        echo '
        <li class="treeview">
         <a href="#">
            <i class="fa fa-random"></i> <span>Movimiento Contenedores</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="movinterno.php"><i class="fa fa-recycle"></i>Movimiento Interno</a></li>
          </ul>
        </li>
       
        '
     
    ;
}
        ?>

<?php
    if ($_SESSION['Datosm']==1){
        echo '<li class="treeview">
               <a href="#">
               <i class="fa fa-file-text"></i><span>Datos Maestros</span>
               <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
                </span>
               </a>
               <ul class="treeview-menu">
               <li><a href="flotatransporte.php"><i class="fa fa-car"></i>Flota Transporte</a></li>
                </ul>
        </li>';
    }
?>




           <?php 
if ($_SESSION['acceso']==1) {
  echo '  <li class="treeview">
          <a href="#">
            <i class="fa fa-users"></i> <span>Acceso</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="usuario.php"><i class="fa fa-circle-o"></i> Usuarios</a></li>
            <li><a href="permiso.php"><i class="fa fa-circle-o"></i> Permisos</a></li>
          </ul>
        </li>';
}
        ?>  
        <?php 
            if ($_SESSION['reporte']==1){
                echo '<li class="treeview">
                     <a href="#">
                        <i class="fa fa-file-pdf-o"></i>
                        <span>Reportes</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                     </a>
                     <ul class="treeview-menu">
                     <li><a href="reportestir.php"><i class="fa fa-file-text-o"></i><span>Reportes Ingresos </span></a></li>
                        <li><a href="reportestir.php"><i class="fa fa-file-pdf-o"></i><span>Reportes TIR Emitidos </span></a></li>
                        <li><a href="reportestira.php"><i class="fa fa-remove"></i><span>Reportes TIR Anulados </span></a></li>
                     </ul>
                </li>';
            }
        ?>
        <li><a href="paginaencontru.php"><i class="fa fa-question-circle"></i> <span>Ayuda</span><small class="label pull-right bg-yellow"></small></a></li>
        <li><a href="../ajax/usuario.php?op=salir"><i class="fa fa-close"></i> <span>Salir</span><small class="label pull-right bg-yellow"></small></a></li>
        <li><a href="paginaencontru.php"><i class="fa  fa-exclamation-circle"></i> <span>Acerca de</span><small class="label pull-right bg-yellow"></small></a></li>   
        
      </ul>
    </section
    <!-- /.sidebar -->
  </aside>