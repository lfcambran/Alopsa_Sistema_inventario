var tabla;
init();
$(document).ready(function() {
    var url = window.location;
    // Will only work if string in href matches with location
    $('.treeview-menu li a[href="' + url + '"]').parent().addClass('active');
    // Will also work for relative and absolute hrefs
    $('.treeview-menu li a').filter(function() {
        return this.href == url;
    }).parent().parent().parent().addClass('active');


});

function init(){
    listartirsalida();
    listartirs();
}

function listartirsalida(){
    tabla=$('#tbllistadotirsa').dataTable().DataTable();
}

function mostrarmodal(){
    var idtirs=$("#idtirsa").val();
     if (idtirs==""){
        $("#titulo").html("Agregar TIR Salida");
    }else{
        $('#titulo').html("Modificacion del TIR No."+idtirs);
    }
    $('#getmodaltirs').modal('toggle');
}

function listartirs(){
   $.post("../ajax/salidatirs.php?op=listartirs",function(r){
      $("#notir").html(r);
      $("#notir").selectpicker('refresh');
   });
}