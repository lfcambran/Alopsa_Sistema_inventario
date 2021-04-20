var tabla;

function init(){
    listar();
    listarcomboingreso();
    $("#formularioconex").on("submit",function(e){
       guardaryeditar(e);
    });
      $("#formularioautorizacion").on("submit",function(e){
       validarusuario(e); 
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
    $.post("../ajax/conexiones.php?op=listaringreso",function(r){
        $("#contenedor").html(r);
        $("#contenedor").selectpicker('refresh');
    });
}

$("#contenedor").change(function(){
     var idingreso=$("#contenedor").val();
     $("#idingreso").val(idingreso);
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
        $.ajax({
           url: "../ajax/conexiones.php?op=guardaryeditar",
           type: "POST",
           data: data,
           contentType: false,
           processData: false,
           success: function(datos){
               
               var d = datos.substring(0,2);
               if (d=='Se'){
                   swal({icon:'success',title:'Conexion', text:datos});
                   tabla.ajax.reload();
                    $('#getmodalConexion').modal('toggle');
               }else if (d=='Er'){
                   swal({icon:'error',title:'Error al Grabar', text:datos});
               }
           }
        });
       
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
    $('#tipoconexion').val("");
    $('#tipoconexion').selectpicker('refresh');
}
function mostrar(id){
    $.post("../ajax/conexiones.php?op=mostrar",{idconexion:id},
        function(data,status){
            data=JSON.parse(data);
            $('#idconexion').val(data.Id);
            $('#fechaco').val(data.Fecha_Conexion);
            $('#horaconexion').val(data.Hora_De_Conexion);
            $('#setpoint').val(data.Setpoint);
            $('#retorno').val(data.Retorno);
            $('#suministro').val(data.Suministro);
            $('#contenedor').val(data.Id_ingreso);
            $('#contenedor').selectpicker('refresh');
            $('#idingreso').val(data.Id_ingreso);
            $('#tipoconexion').val(data.tipoconexion);
            mostraringreso(data.Id_ingreso);
                mostrarform();
        }
    );
}
function dasactivar(id_conexion){
    $("#getmodalau_m").modal('show');
    $("#id_conexion").val(id_conexion);
    
}
function validarusuario(e){
    e.preventDefault();
    $("#btnGuardar2").prop("disabled",false);
    var usuario=$("#usuario").val();
    var password=$("#password").val();
    if ($("#usuario").val()==""){
        swal({ title: "Parametro Requerido", text:"Debe de Ingresar su usuario para anular el ingreso"});
    }else if ($("#password").val()=="") {
        swal({title:"Parametro Requerido",text:'Debe de Ingresar su contraseña para continuar'});
    }else{
        $.post("../ajax/usuario.php?op=validaranulacion",{"logina":usuario,"clavea":password},
        function(data){
            if (data!="null"){
                var idanular=$("#id_conexion").val();
                desactivarcon(idanular,);
            }else{
                swal({title:'Anulacion Cancelada',title:"No cuenta con el acceso para anular el ingreso"})
            }
        }
        );
    }
}

function desactivarcon(val){
    swal({
  title: "Anulacion de Registro",
  text: "Esta seguro de Anular la conexion seleccionada",
  icon: "warning",
  buttons: true,
  dangerMode: true,
})
.then((willDelete) => {
  if (willDelete) {
      $.post("../ajax/conexiones.php?op=desactivar", {id_c : val}, function(e){
				swal({icon:'success',title:'Anulacion de Conexion',title:e});
                                $('#getmodalau_m').modal('toggle');
				tabla.ajax.reload();
			});
  } else {
    swal("se ha cancelado la accion!");
  }
});
}
init();