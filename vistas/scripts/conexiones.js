var tabla;

function init(){
    listar();
    listarcomboingreso();
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
init();