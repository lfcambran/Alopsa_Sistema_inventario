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
    listardatostir();
}

function listardatostir(){
    var fechain=$('#fechainicial').val();
    var fechafi=$('#fechafinal').val();
   tabla=$('#tbllistadortir').dataTable({
       "aProcessing": true,
       "aServerSide": true,
     
       "ajax":{
           url:'../ajax/reportes.php?op=listatirs',
           type: 'POST',
           data: {fechai:fechain,fechaf:fechafi},
           dataType:'json',
           error:function(e){
                    swal(e.responseText);
                }
       },
       "bDestroy":true,
       "iDisplayLength":10,
       "order":[[0,"asc"]]
   }).DataTable();
}
function mostrarre(){
    listardatostir();
}
function exportar(){
    var fechain=$('#fechainicial').val();
    var fechafi=$('#fechafinal').val();
    window.location.href = "../exportar_re/exportar.php" + "?fechainicial=" + fechain + "&fechafinal=" + fechafi + "&tipo=" + 'tirs'
}
function exportarex(){
    var fechain=$('#fechainicial').val();
    var fechafi=$('#fechafinal').val();
   
    window.open('../exportar_re/exportacion_excel.php?reporte=rtir&fechainicial='+fechain+'&fechafinal='+fechafi)
}