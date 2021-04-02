var tabla;

function init(){
    listar();
    listarcomboingreso();
    $("#formulariom").on("submit",function(e){
       guardaryeditar(e);
    });
}
//lista todo los monitoreos en la tabla
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
function cancelarform(){
    limpiar();
}
function guardaryeditar(e){
    e.preventDefault();    
    $("#btnGuardar").prop('disabled',false);
    var formdata= new FormData($('#formulariom')[0]);
    if ($("#contenedor").val()=='0'){
        
        bootbox.alert("Debe de Seleccionar el Contenedor para continuar");
    }else{
        
       $.ajax({
           url: "../ajax/monitoreo.php?op=guardaryeditar",
           type: "POST",
           data: formdata,
           contentType: false,
           processData: false,
           
           success: function(datos){
           bootbox.alert(datos);
           tabla.ajax.reload();
           $('#getmodalm').modal('toggle');
       }
        });
        
    }
        
}
function limpiar(){
    var now = new Date();
    var dia = ("0" + now.getDate()).slice(-2);
    var mes = ("0" + (now.getMonth() + 1)).slice(-2);
    var today = now.getFullYear()+"-"+(mes)+"-"+dia;
    alert(today);
    var hora = now.getHours();
    var minuto =("0" + now.getMinutes()).slice(-2);
    var segundo = ("0" + now.getSeconds()).slice(-2);
    var horaactual = hora + ":" + minuto + ":" + segundo;
    listarcomboingreso();
    $("#horamonitoreo").val(horaactual);
    $("#fecham").val(today);
    $("#contenedor").val(false).trigger("change");
    $("#idingreso").val("");
    $("#retorno").val("");
    $("#setpoint").val("");
    $("#suministro").val("");
    $("#mecanico").val("");
    $("#observaciones").val();
    
}
init();