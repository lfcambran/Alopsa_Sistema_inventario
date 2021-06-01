var tabla;

init();

function init(){
    listar();
    llenarlistaingreso();
    $('#formularioexpo').on('submit',function(e){
        guardareditar(e);
    });
     $("#formularioautorizacion").on("submit",function(e){
       validarusuario(e); 
    });
}

function listar(){
    tabla=$('#tbllistaexportacion').dataTable({
        "aProcessing":true,
        "aServerSide":true,
        "bDestroy":true,
        "ajax":{
            url:'../ajax/exportacion.php?op=listar',
            type:'get',
            dataType: 'json',
            error:function(e){
                console.log(e.responseText);
                swal("Error : " + e.responseText);
            }
        },
        "iDisplayLength":10,
        "order":[[0,"asc"]]
    }).DataTable();
}
function mostrarmodal(){
    var idexpo=$('#idexportacion').val();
    if (idexpo==''){
        $('#titulo').html("Creacion de Exportacion");
    }else{
        $('#titulo').html("Modificacion de Exportacion No. " + idexpo);
    }
    $('#getmodalexpo').modal('show');
}
function llenarlistaingreso(){
    $.post('../ajax/exportacion.php?op=listaringreso', function(r){
        $("#contenedor").html(r);
        $("#contenedor").selectpicker('refresh');
    });
}
function mostraringresom(val){
    $.ajax({
        url:'../ajax/exportacion.php?op=mostrarcontenedor',
        data:{idingresoc:val},
        type: "get",
        datatype:"json",
        success:function(resp){
            $('#datoscont').html(resp);
        },
        error:function(e){
            swal(e);
        }
    })
}
function limpiar(){
    var now = new Date();
    var dia = ('0' + now.getDate()).slice(-2);
    var mes = ('0' + (now.getMonth() + 1)).slice(-2);
    var today = now.getFullYear()+'-'+(mes)+'-'+dia;
    var hora = now.getHours();
    var minutos= ('0'+now.getMinutes()).slice(-2);
    var segundo = ("0" + now.getSeconds()).slice(-2);
    var horaa = hora + ':' + minutos + ':' + segundo;
    $('#fecha').val(today);
    $('#fecha_asig').val(today);
    $('#hora').val(horaa);
    $('#idexportacion').val();
    $('#idingresoc').val('');
    $('#contenedor').val('');
    $('#contenedor').selectpicker('refresh');
    mostraringresom(0);
}
function cancelarform(){
    limpiar();
}
function guardareditar(e){
    e.preventDefault();
    $('#btnGuardar').prop('disable',false);
    var datos=new FormData($('#formularioexpo')[0]);
    if ($('#contenedor').val()==0){
         swal({title: "Dato Importante", text:"Debe de Seleccionar el contenedor para continuar"});
    }else{
        $.ajax({
            url:'../ajax/exportacion.php?op=guardareditar',
            type: 'POST',
            data: datos,
            contentType: false,
            processData: false,
            success: function(resp){
                var res=resp.substring(0,2);
                if (res=='Se'){
                     swal({icon:'success',title:'Exportacion', text:resp});
                     tabla.ajax.reload();
                    $('#getmodalexpo').modal('toggle');
                }else if (res=='Er'){
                    swal({icon:'error',title:'Error al Grabar', text:resp});
                }else{
                    swal(resp);
                }
            },
            error: function(r){
                swal('Error: '+ r);
            }
        })
    }
}
function mostrar(val){
    $.post('../ajax/exportacion.php?op=mostrar',{id_exportacion:val},
        function(datos,status){
            data=JSON.parse(datos);
            $('#idexportacion').val(data.Id_e);
            $('#fecha').val(data.Fecha_salida);
            $('#hora').val(data.Hora_Salida);
            $('#fecha_asig').val(data.fecha_asignacion);
            $('#contenedor').val(data.id);
            $('#contenedor').selectpicker('refresh');
            $('#idingresoc').val(data.id);
            mostraringresom(data.id);
            mostrarmodal();
        }
    );
}
function dasactivar(id_expo,id_ingreso){
    
    $('#id_expo').val(id_expo);
    $('#id_ingreso').val(id_ingreso);
    $('#getmodalau_exp').modal('show');
}
function validarusuario(e){
    e.preventDefault();
    $('#btnGuardar2').prop('disabled',false);
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
                var idexpo=$("#id_expo").val();
                var idingreso=$('#id_ingreso').val();
                
                desactivarexpo(idexpo,idingreso,usuario);
            }else{
                swal({title:'Anulacion Cancelada',title:"No cuenta con el acceso para anular el ingreso"})
            }
        }
        );
    }
}
function desactivarexpo(val1,val2,val3){
     swal({
  title: "Anulacion de Registro",
  text: "Esta seguro de Anular la exportacion seleccionada",
  icon: "warning",
  buttons: true,
  dangerMode: true,
})
.then((willDelete) => {
  if (willDelete) {
      $.post("../ajax/exportacion.php?op=anular", {idexpo : val1,id_ingreso: val2,usuarioa:val3}, function(e){
				swal({icon:'success',title:'Anulacion de Registro',title:e});
                                $('#getmodalau_exp').modal('toggle');
				tabla.ajax.reload();
			});
  } else {
    swal("se ha cancelo la accion!");
  }
});
}
$('#contenedor').change(function(){
    var idingreso=$('#contenedor').val();
    $('#idingresoc').val(idingreso);
    mostraringresom(idingreso);
})