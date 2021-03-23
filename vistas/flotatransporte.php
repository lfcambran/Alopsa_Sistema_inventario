<?php

ob_start();
session_start();
if (!isset($_SESSION['nombre'])){
    header("Location: login.html");
}else{
    require 'header.php';
    
    if ($_SESSION['Datosm']==1){
        ?>
        <div class="content-wrapper">
            <section class="content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box">
                            <div class="box-header with-border">
                                <h1 class="box-title">Flota Transporte   <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i>  Agregar</button></h1>
                                <div class="box-tools pull-right">
                                    <a href="../vistas/dashboard.php"><button class="btn btn-info"><i class="fa fa-arrow-circle-left"></i> Volver</button></a>
                                </div>
                            </div>
                            <div class="panel-body table-responsive" id="listadoregistrosf">
                                <table id="tbllistadof" class="table table-striped table-bordered table-condensed table-hover ">
                                    <thead>
                                    <th>Opciones</th>
                                    <th>Cabezal</th>
                                    <th>Piloto</th>
                                    <th>Licencia</th>
                                    <th>Placas</th>
                                    <th>Codigo N.</th>
                                    <th>Naviera</th>
                                    <th>Transporte</th>
                                    <th>Ubicacion</th>
                                    <tbody>
                                    </tbody>
                                    </thead>
                                         <tfoot>
                                            <th></th>
                                            <th>Cabezal</th>
                                            <th>Piloto</th>
                                            <th>Licencia</th>
                                            <th>Placas</th>
                                            <th>Codigo N.</th>
                                            <th>Naviera</th>
                                            <th>Transporte</th>
                                            <th>Ubicacion</th>
                                         </tfoot> 
                                </table>
                                
                            </div>
                            <div class="panel-body" id="formularioregistros">
                                <form action="" name="formulario" id="formulario" method="POST">
                                    <div class="form-group col-lg-4 col-md-6 col-xs-12">
                                    <label for="">Cabezal(*):</label>
                                    <input type="hidden" class="form-control" name="codigoid" id="codigoid">
                                    <input class="form-control" type="text" name="cabezal" id="cabezal" maxlength="20" placeholder="Cabezal" onkeyup="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" required>
                                    </div>
                                    <div class="form-group col-lg-4 col-md-6 col-xs-12">
                                        <label for="">Nombre Piloto(*):</label>
                                        <input class="form-control" type="text" name="nombrepiloto" id="nombrepiloto" name="nombrepiloto" maxlength="50" placeholder="Nombre Del Piloto" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" required>
                                    </div>
                                    <div class="form-group col-lg-4 col-md-6 col-xs-12">
                                        <label for="">Licencia(*):</label>
                                        <input class="form-control" type="text" name="licencia" id="licencia" maxlength="20" placeholder="Numero de Licencia"  onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" required>
                                    </div>
                                    <div class="form-group col-lg-4 col-md-6 col-xs-12">
                                        <label for="">Placa(*):</label>
                                        <input class="form-control" type="text" name="placas" id="placas" maxlength="10" placeholder="Placas Cabezal"  onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" required>
                                    </div>
                                    <div class="form-group col-lg-4 col-md-6 col-xs-12">
                                        <label for="">Codigo Naviera(*):</label>
                                        <input class="form-control" type="text" name="codigon" id="codigon" maxlength="10" placeholder="Codigo de Naviera" onkeyup="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" required>
                                    </div>
                                    <div class="form-group col-lg-4 col-md-6 col-xs-12">
                                        <label for="">Naviera:</label>
                                        <input class="form-control" type="text" name="naviera" id="naviera" maxlength="20" placeholder="Naviera" onkeyup="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" required>
                                    </div>
                                    <div class="form-group col-lg-4 col-md-6 col-xs-12">
                                        <label for="">Transporte:</label>
                                        <input class="form-control" type="text" name="transporte" id="transporte" maxlength="20" placeholder="Transporte" onkeyup="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" required>
                                    </div>
                                    <div class="form-group col-lg-4 col-md-6 col-xs-12">
                                        <label for="">Ubicacion:</label>
                                        <input class="form-control" type="text" name="ubicacion" id="ubicacion" maxlength="20" placeholder="Ubicacion" onkeyup="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" required>
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

        <?php
    }else {
        require 'noacceso.php';
    }
  
    require 'footer.php';
 ?>
 <script src="scripts/datosm_flota.js"></script>
 <?php 
}

ob_end_flush();
?>