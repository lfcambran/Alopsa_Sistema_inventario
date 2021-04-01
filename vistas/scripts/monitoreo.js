var tabla;

function init(){
    listar();
    listarcomboingreso();
    $("#formulariom").on("submit",function(e){
       guardaryeditar(e);
    });
}

function listar(){
    tabla=$('#tbllistadoingresos').dataTable({
        "aProcessing":true,
        "aServerSide":true,
         buttons:[
             'excelHtml5',
             'pdf'
         ],
         "ajax":{
             url:'../ajax/monitoreo.php?op=listar',
             type: 'get',
             dataType: 'json',
             error:function(e){
                 console.log(e.responseText);
             }
         },
         "bDestroy":true,
        "iDisplayLength":10,
        "order":[[0,"asc"]]
    }).DataTable();
}

function mostrarform(){
    var idm = $("#idmonitoreo").val();
    
    if(idm==""){
         $("#titulo").html("Agregar Monitoreo");
    }else{
        $("#titulo").html("Modificar Monitoreo");
    }
    $('#getmodalm').modal('toggle');
}
$("#contenedor").change(function(){
    var idingreso=$("#contenedor").val();
    mostraringreso(idingreso);
});
function listarcomboingreso(){
    $.post("../ajax/monitoreo.php?op=listaringreso",function(r){
        $("#contenedor").html(r);
        $("#contenedor").selectpicker('refresh');
    });
}
function mostraringreso(val){
    
    $.ajax({
       url:'../ajax/monitoreo.php?op=mostraringreso',
       data:{idingreso:val},
       type: "get",
       datatype:"json",
       success: function(resp){
           $('#datosingreso').html(resp);
       }
    });
}
function guardaryeditar(e){
    e.preventDefault();
    var producto=$('#producto').val();
    
    $("#btnGuardar").prop('disabled',false);
    var formdata= new FormData($('#formulariom')[0]);
    if ($("#contenedor").val()=='0'){
        
        bootbox.alert("Debe de Seleccionar el Contenedor para continuar");
    }else{
        
       $.ajax({
           url:"../ajax/monitoreo.php?op=guardaryeditar",
           type: "POST",
           data: formdata,
           contentType: false,
           success: function(datos){
           bootbox.alert(datos);
           tabla.ajax.reload();
           $('#getmodalm').modal('toggle');
       }
        });
        
    }
        
}
init();