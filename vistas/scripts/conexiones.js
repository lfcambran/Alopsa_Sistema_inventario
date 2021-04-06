var tabla;

function init(){
    listar();
    listarcomboingreso();
    $("#formularioconex").on("submit",function(e){
       guardaryeditar(e);
    });
}
function listar(){
    tabla=$('#tbllistadoconexion').dataTable({
        "aProcessing":true,
        "aServerSide":true,
        buttons:[
                    'excelHtml5',
                    'pdf'
        ],
        "ajax":{
            url:'../ajax/conexiones.php?op=listar',    
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
    var idconexion = $('#idconexion').val();
    
    if(idconexion==""){
        $("#titulo").html("Agregar Conexion");
    }else{
        $("#titulo").html("Modificar Conexion No."+idconexion);
    }
    $("#getmodalConexion").modal('toggle');
}
function listarcomboingreso(){
    $.post("../ajax/monitoreo.php?op=listaringreso",function(r){
        $("#contenedor").html(r);
        $("#contenedor").selectpicker('refresh');
    });
}

$("#contenedor").change(function(){
     var idingreso=$("#contenedor").val();
        mostraringreso(idingreso);
});
function mostraringreso(val){
    
    $.ajax({
       url:'../ajax/conexiones.php?op=mostraringreso',
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
    var data= new FormData($("#formularioconex")[0]);
    if ($("#contenedor").val()==0){
        swal({title: "Dato Importante", text:"Debe de Seleccionar el contenedor para continuar"});
    }else {
        
    }
}
function limpiar(){
     var now = new Date();
    var dia = ("0" + now.getDate()).slice(-2);
    var mes = ("0" + (now.getMonth() + 1)).slice(-2);
    var today = now.getFullYear()+"-"+(mes)+"-"+dia;
    var hora = now.getHours();
    var minuto =("0" + now.getMinutes()).slice(-2);
    var segundo = ("0" + now.getSeconds()).slice(-2);
    var horaactual = hora + ":" + minuto + ":" + segundo;
    listarcomboingreso();
    $("#horaconexion").val(horaactual);
    $("#fechaco").val(today);
    $("#contenedor").val(false).trigger("change");
    $("#idingreso").val("");
    $("#retorno").val("");
    $("#setpoint").val("");
    $("#suministro").val("");
}
init();