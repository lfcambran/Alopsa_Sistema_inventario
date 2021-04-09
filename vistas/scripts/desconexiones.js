var tabla;

init();

$("#contenedor").change(function(){
    var idconexion=$('#contenedor').val();
    mostrarconexion(idconexion);
})

function init(){
    listar();
    listarcombocone();
}
function listar(){
    tabla=$('#tbllisdesconexion').dataTable({
        "aProcessing":true,
        "aServerSide":true,
         buttons:[
             'excelHtml5',
             'pdf'
         ],
         "ajax":{
             url:'../ajax/desconexiones.php?op=listar',
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
function mostrarmodal(){
    var iddesco = $("#iddesconexion").val();
    
    if (iddesco==""){
        $("#titulo").html("Agregar una Desconexion");
    }else{
         $("#titulo").html("Modificar Desconexion No. "+iddesco);
     }
     $('#getmodaldes').modal('show');
}
function cancelarform(){
    
}
function listarcombocone(){
     $.post("../ajax/desconexiones.php?op=listarconexiones",function(r){
        $("#contenedor").html(r);
        $("#contenedor").selectpicker('refresh');
    });
}
function mostrarconexion(val){
    $.ajax({
       url:'../ajax/desconexiones.php?op=mostrarconexion',
       data:{idconexion:val},
       type: "get", 
       datatype:"json",
       success: function(resp){
           $('#datosicone').html(resp);
       }
    });
}