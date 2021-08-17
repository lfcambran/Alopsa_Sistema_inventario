var tabla;
$(document).ready(function() {
    var url = window.location;
    // Will only work if string in href matches with location
    $('.treeview-menu li a[href="' + url + '"]').parent().addClass('active');
    // Will also work for relative and absolute hrefs
    $('.treeview-menu li a').filter(function() {
        return this.href == url;
    }).parent().parent().parent().addClass('active');


});

init();

function init(){
   listardatos();
}
function listardatos(){
     var fechainicial=$('#fechainicial').val();
    var fechafinal=$('#fechafinal').val();
    tabla=$('#tbllistadoingreso').dataTable({
        "aProcessing": true,
        "ajax":{
          url:'../ajax/reportes.php?op=listaringresos',
          type: 'POST',
          data: {fechai:fechainicial,fechaf:fechafinal},
          dataType: 'json',
          error:function(e) {
                        swal(e.responseText);
                        }
        },
        "bDestroy":true,
       "iDisplayLength":10,
       "order":[[0,"asc"]]

    }).DataTable();
}
function mostrarin(){
    listardatos();
}
function exportar(){
    var fechain=$('#fechainicial').val();
    var fechafi=$('#fechafinal').val();
    window.location.href = "../exportar_re/exportaring.php" + "?fechainicial=" + fechain + "&fechafinal=" + fechafi 
}