<?php
ob_start();
session_start();
if (!isset($_SESSION['nombre'])){
    header("Location: login.html");
}else{
    require 'header.php';
   
   
    if($_SESSION['ingresoc']==1){
        ?>
    <div class="content-wrapper">
            <section class="content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box">
                            <div class="box-header with-border">
                                <h1 class="box-title">Datos Maestro Contenedores <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i>  Agregar</button></h1>
                                <div class="box-tools pull-right">
                                    <a href="../vistas/dashboard.php"><button class="btn btn-info"><i class="fa fa-arrow-circle-left"></i> Volver</button></a>
                                </div>
                            </div>
                            <div class="panel-body table-responsive" id="listadoregistrosdb">
                                <table id="tbllistadodm" class="table table-striped table-bordered table-condensed table-hover ">
                                    <thead>
                                    <th>Piloto</th>
                                    <th>Placas</th>
                                    <th>Contenedor</th>
                                    <th>Marchamo</th>
                                    <th>Bloque</th>
                                    <th>Posicion</th>
                                    <th>Producto</th>
                                    <th>Barco</th>
                                    <th>Destino</th>
                                    <th>Opciones</th>
                                    </thead>
                                    <tbody>
                                        
                                    </tbody>
                                    
                                </table>
                            </div>
                            <div class="panel-body" id="formulariodmaestros">
                                <form action="" name="formularioingreso" id="formularioingreso" method="POST">
                                    <div class="form-group col-lg-2 col-md-6 col-xs-12">
                                        <label for="">Fecha Ingreso</label>
                                        <input type="hidden" id="idingreso" name="idingreso">
                                        <input type="date" class="form-control" name="fecha_ingreso" id="fecha_ingreso" value="<?php echo date("Y-m-d"); ?>">
                                    </div>
                                     <div class="form-group col-lg-2 col-md-6 col-xs-12">
                                        <label for="">Hora de Ingreso</label>
                                        <div class="input-group clockpicker">
                                        <input type="text" class="form-control" name="horaingreso" id="horaingreso" value="<?php  $hora =new DateTime("now", new DateTimeZone(' America/Guatemala')); echo $hora->format('H:i:s'); ?>">
                                        <span class="input-group-addon">
                                             <span class="glyphicon glyphicon-time"></span>
                                         </span>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-4 col-md-6 col-xs-12">
                                        <label for="">Contenedor(*)</label>
                                        <input type="text" class="form-control" name="nocontenedor" id="nocontenedor" max="20" placeholder="No. Contenedor" onkeyup="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" required>
                                    </div>
                                    <div class="form-group col-lg-3 col-md-6 col-xs-12">
                                        <label for="">Barco(*)</label>
                                        <input type="text" class="form-control" name="barco" id="barco" max="30" placeholder="Nombre Barco" onkeyup="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" required>
                                    </div>form-control" name="producto" id="producto" placeholder="Producto Contenedor" max="20" onkeyup="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" required>
                                    </div>
                                    <div class="form-group col-lg-3 col-md-3 col-xs-12">
                                        <label>Orden</label>
                                        <input type="text" class="form-control" name="orden" id="orden"  max="20" placeholder="Orden" onkeyup="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" required>
                                    </div>
                                    
                                    <div class="form-group col-lg-2 col-md-3 col-xs-12">
                                        <label>Bloque</label>
                                        <select name="bloque" id="bloque" class="form-control selectpicker" data-live-search="true" required>
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-3 col-md-3 col-xs-12">
                                        <label>Tipo Contenido(*)</label>
                                        <input type="text" class="form-control" name="tipoc" id="tipoc" max="20" placeholder="Tipo de Contenido" onkeyup="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" required>
                                    </div>
                                    <div class="form-group col-lg-4 col-md-3 col-xs-12">
                                        <label>Descripcion Contenido(*)</label>
                                        <input type="text" class="form-control" name="dcontenido" id="dcontenido" placeholder="Descripcion del Contenido Contenedor" max="50" onkeyup="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" required>
                                    </div>
                                    <div class="form-group col-lg-4 col-md-3 col-xs-12">
                                        <label>Detalle Servicio</label>
                                        <input type="text" class="form-control" name="dservicio" id="dservicio" placeholder="Detalle del Servicio" max="20" onkeyup="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" required>
                                    </div>
                                     <div class="form-group col-lg-3 col-md-3 col-xs-12">
                                        <label>No. Marchamos</label>
                                        <input type="text" class="form-control" name="marchamo" id="marchamo" placeholder="Numero Marchamo" max="20" onkeyup="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" required>
                                    </div>
                                   
                                 
                                      <div class="form-group col-lg-2 col-md-3 col-xs-12">
                                        <label>Hora TIR</label>
                                         <div class="input-group clockpicker2">
                                         <input type="text" class="form-control" name="htir" id="htir"  max="20" value="<?php $hora2 =new DateTime("now", new DateTimeZone(' America/Guatemala')); echo $hora2->format('H:i:s'); ?>"  required>
                                         <span class="input-group-addon">
                                             <span class="glyphicon glyphicon-time"></span>
                                         </span>
                                         </div>
                                      
                                    </div>
                                    
                                    <div class="form-group col-lg-2 col-md-3 col-xs-12">
                                        <label>Serie TIR</label>
                                        <input type="text" class="form-control" name="serietir" id="serietir" max="2" value="A" placeholder="Serie TIR" onkeyup="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" required>
                                    </div>
                                    <div class="form-group col-lg-4 col-md-3 col-xs-12">
                                        <label>Producto</label>
                                        <input type="text" class="form-control" name="producto" id="producto" placeholder="Producto Contenedor" max="20" onkeyup="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" required>
                                    </div>
                                    <div class="form-group col-lg-3 col-md-3 col-xs-12">
                                        <label>Orden</label>
                                        <input type="text" class="form-control" name="orden" id="orden"  max="20" placeholder="Orden" onkeyup="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" required>
                                    </div>
                                    
                                    <div class="form-group col-lg-2 col-md-3 col-xs-12">
                                        <label>Bloque</label>
                                        <select name="bloque" id="bloque" class="form-control selectpicker" data-live-search="true" required>
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-2 col-md-3 col-xs-12">
                                        <label>Posicion</label>
                                        <select name="posicion" id="posicion" class="form-control selectpicker" data-live-search="true">
                                            
                                        </select>
                                        <input type="hidden" id="noposicion" name="noposicion">
                                    </div>
                                 
                                     <div class="form-group col-lg-3 col-md-3 col-xs-12">
                                        <label>Destino</label>
                                        <input type="text" id="destino" name="destino" placeholder="Destino Contenedor" class="form-control" onkeyup="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
                                    </div>
                                    <div class="form-group col-lg-3 col-md-3 col-md-12">
                                        <label>Fecha Asignacion</label>
                                        <input type="date" class="form-control" name="fechaasignacion" id="fechaasignacion" value="<?php echo date("Y-m-d"); ?>">
                                    </div>
                                      
                                       <div class="form-group col-lg-3 col-md-3 col-xs-12">
                                           <label>Piloto:</label>
                                                <select name="piloto" id="piloto" class="form-control selectpicker" data-live-search="true" required>
                                                </select>
                                           <input type="hidden" id="idpiloto" name="idpiloto">
                                        </div>
                                <div id="datos_piloto"></div>
                                      <div class="form-inline col-lg-12 col-md-12 col-sm-12 col-xs-12"></div>
                                     <div class="form-group col-lg-6 col-md-3 col-xs-12">
                                        <label>Observaciones</label>
                                        <textarea class="form-control" id="observaciones" name="observaciones"></textarea>
                                    </div>
                                    
                                    
                                     <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i>  Guardar</button>
                                        <button class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                                        
                                    </div>
                                </form>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </section>
    </div>

<div class="modal fade" id="getmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidde="true"  data-backdrop="static" 
  data-keyboard="false">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Autorizacion de Anulacion</h4>
            </div>
            <div class="modal-body">
                <form action="" name="formularioauto" id="formularioauto" method="POST">
                    <div class="form-group col-lg-12 col-md-12 col-xs-12">
                        <input type="hidden" id="id_anular" name="id_anular">
                        <input type="hidden" id="idb" name="idb">
                        <input type="hidden" id="idp" name="idp">
                        <label>Usuario:</label>
                        <input type="text" class="form-control" name="usuario" id="usuario">
                        <label>Contraseña:</label>
                        <input type="password" class="form-control" name="password" id="password">
                    </div>
                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <button class="btn btn-primary" type="submit" id="btnGuardar2"><i class="fa fa-close"></i>  Anular</button>
                        <button class="btn btn-danger pull-right" data-dismiss="modal" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                
            </div>
        </div>
    </div>
</div>


        <?php
    }else {
        require 'noacceso.php';
    }
    require 'footer.php';
    ?>
    
<script>
    $('.clockpicker').clockpicker({
        placement:'bottom',
        donetext: 'Aceptar'
    });
    $('.clockpicker2').clockpicker({
       placement: 'bottom',
       donetext: 'Aceptar'
    });
</script>
<script src="scripts/ingresosm.js"></script>
<?php
}
ob_end_flush()
?>