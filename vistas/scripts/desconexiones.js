var tabla;

init();


function init(){
    listar();
    listarcombocone();
    $('#formulariodesc').on("submit",function(e){
       guardaryeditar(e); 
    });
     $("#formularioautorizacion").on("submit",function(e){
       validarusuario(e); 
    });
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
    limpiar();
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
           $('#datoscone').html(resp);
           calcularhoras()
       }
    });
}
function calcularhoras(){
    if ($('#contenedor').val()>0){
    $('#fechahorai').val($("#fechac").val() + ' ' + $('#horac').val());
    $('#fechahoraf').val($("#fechadesc").val() + ' ' + $('#horadesc').val());
    var horaconexion=moment($('#fechahorai').val(),"YYYY-MM-DD HH:mm");
    var horadesconexion=moment($('#fechahoraf').val(),"YYYY-MM-DD HH:mm" );
    var totalfecha=horadesconexion.diff(horaconexion,'hours')
    var min=totalfecha*60;
    var mindef=horadesconexion.diff(horaconexion,'m')-min
    
    $("#totalhoras").val(totalfecha+':' + padDigitos(mindef,2));
    }else{$("#totalhoras").val('0');}
}
function padDigitos(numero, digitos) {
    return Array(Math.max(digitos - String(numero).length + 1, 0)).join(0) + numero;
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
     listarcombocone();
    $('#fechadesc').val(today);
    $('#horadesc').val(horaactual);
     mostrarconexion(0);
    $('#totalhoras').val("0:00");
    $('#observaciones').val("");
    
}
$("#contenedor").change(function(){
    var idconexion=$("#contenedor").val();
    $('#idconexion').val(idconexion);
    mostrarconexion(idconexion);
})

function guardaryeditar(e){
    e.preventDefault();
    $('#btnGuardar').prop('disable',false);
    var dato = new FormData($("#formulariodesc")[0]);
     if ($("#contenedor").val()==0){
        swal({title: "Dato Importante", text:"Debe de Seleccionar el contenedor para continuar"});
    }else {
         $.ajax({
           url: "../ajax/desconexiones.php?op=guardaryeditar",
           type: "POST",
           data: dato,
           contentType: false,
           processData: false,
           success: function(datos){
               
               var d = datos.substring(0,2);
               if (d=='Se'){
                   swal({icon:'success',title:'Desconexion de Contenedor', text:datos});
                   tabla.ajax.reload();
                    $('#getmodaldes').modal('toggle');
               }else if (d=='Er'){
                   swal({icon:'error',title:'Error al Grabar', text:datos});
               }
           }
        });
    }
}
function mostrar(id){
    $.post("../ajax/desconexiones.php?op=mostrar",{iddesconexion:id},
        function(datos,status){
            data=JSON.parse(datos);
            $('#iddesconexion').val(data.Id_d);
            $('#idconexion').val(data.idconexion);
            $('#contenedor').val(data.idconexion);
            $('#contenedor').selectpicker('refresh');
            $('#fechadesc').val(data.Fecha_De_Desconexion);
            $('#horadesc').val(data.Hora_De_Desconexio);
            $('#totalhoras').val(data.totalhoras);
            $('#observaciones').val(data.observaciones);
            mostrarconexion(data.idconexion);
          mostrarmodal();
         }
    );
}

function dasactivar(val){
    $("#getmodalau_desc").modal('show');
    $("#id_desco").val(val);
    
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
                var idanular=$("#id_desco").val();
                desactivardesco(idanular);
            }else{
                swal({title:'Anulacion Cancelada',title:"No cuenta con el acceso para anular el ingreso"})
            }
        }
        );
    }
}

function desactivardesco(val){
    swal({
  title: "Anulacion de Registro",
  text: "Esta seguro de Anular la desconexion seleccionada",
  icon: "warning",
  buttons: true,
  dangerMode: true,
})
.then((willDelete) => {
  if (willDelete) {
      $.post("../ajax/desconexiones.php?op=desactivar", {id_desc : val}, function(e){
				swal({icon:'success',title:'Anulacion de desconexion',title:e});
                                $('#getmodalau_desc').modal('toggle');
				tabla.ajax.reload();
			});
  } else {
    swal("se ha cancelo la accion!");
  }
});
}