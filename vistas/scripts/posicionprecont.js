var tabla;

init();

function init(){
      listar();
      listacomboingreso();
      llenarcombopatio();
      $("#formularioposcon").on('submit',function(e){
         guardar_editar(e); 
      });
      $("#formularioanulacion").on('submit',function(e){
          validarusuario(e);
      })
}

function listar(){
    tabla=$('#tbllistaposicionc').dataTable({
        'aProcessing':true,
        'aServerSide':true,
        'ajax':{
          url:'../ajax/posicionprecon.php?op=listarpos',
          type:'get',
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
    var idposcontenedor=$('#idposcont').val();
    
    if (idposcontenedor==""){
        $("#titulo").html("Asignar Contenedor en Patio");
    }else {
        $("#titulo").html("Modificacion de Contenedor en Patio");
    }
    $("#getmodalcpos").modal('toggle');
}
function listacomboingreso(){
    $.post("../ajax/posicionprecon.php?op=listaringreso",function(r){
         $("#contenedor").html(r);
        $("#contenedor").selectpicker('refresh');
    })
}

function llenarcombopatio(){
        $.post("../ajax/posicionprecon.php?op=listapatio",function(r){
         $("#patio").html(r);
         $("#patio").selectpicker('refresh');
         $("#areap").attr('disabled',!$('#areap').attr('disabled'));
         $('#bloque').attr('disabled',!$('#bloque').attr('disabled'));
         $('#fila').attr('disabled',!$('#fila').attr('disabled'));
    })
}

function mostraringreso(val){
    $.ajax({
        url:'../ajax/posicionprecon.php?op=mostraringreso',
        data:{idingreso:val},
        type: "get",
        datatype: "json",
        success:function(r){
            $('#datosingreso').html(r);
        }
    });
}
function cancelarform(){
    limpiar();
}
function limpiar(){
    var now = new Date();
    var day = ("0" + now.getDate()).slice(-2);
    var month = ("0" + (now.getMonth() + 1)).slice(-2);
    var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
    var hora = now.getHours();
    var minuto =("0" + now.getMinutes()).slice(-2);
    var segundo = ("0" + now.getSeconds()).slice(-2);
    var horaactual = hora + ":" + minuto + ":" + segundo;
    //listacomboingreso();
    $('#contenedor').val('0');
    $('#contenedor').selectpicker('refresh');
    $('#fechai').val(today);
    $('#hora').val(horaactual);
    $('#patio').val('');
    $('#patio').selectpicker('refresh');
    $('#areap').val(0);
    $("#areap").attr('disabled',!$('#areap').attr('disabled'));
    $('#areap').selectpicker('refresh');
    $('#bloque').val(0);
    $('#bloque').attr('disabled',!$('#bloque').attr('disabled'));
    $('#bloque').selectpicker('refresh');
    $('#fila').val(0);
    $('#fila').attr('disabled',!$('#fila').attr('disabled'));
    $('#fila').selectpicker('refresh');
    $('#noaltura').val('');
    $('#observaciones').val('');
    $('#area_p').val('');
    $('#idposcont').val('');
    $('#bloque_p').val('');
    $('#fila_p').val('');
    $('idingreso').val('');
    $('#contenedor').removeAttr('disabled');
    $('#no_altura').val('');
    mostraringreso(0);
}
function guardar_editar(e){
    e.preventDefault();
    var error=0;
    var mensajeerror="";
    if ($('#contenedor').val()==0){
             error+=1;
             mensajeerror=mensajeerror+' Debe de Seleccionar un Contenedor para continuar \n';
       
    }else{
          if(error>=1){
            error=error-1;
        }
    }
    if ($('#patio').val()==0 || $('#patio').val()==''){
        error+=1;
        mensajeerror=mensajeerror+' Debe de Seleccionar el patio para continuar \n';
    }else{
        if(error>=1 || error==-1){
        error=error-1;
        }
    }
    if ($('#areap').val()==0 || $('#areap').val()=='' || $('#areap').val()==null ){
        error+=1;
         mensajeerror=mensajeerror+' Debe de Seleccionar el Area para continuar \n';
    }else{
        if(error>=1 || error==-1){
        error=error-1;
        }
       }
    if ($('#bloque').val()==0 || $('#bloque').val()=='' || $('#bloque').val()==null){
        error+=1;
        mensajeerror=mensajeerror+' Debe de Seleccionar el bloque para continuar \n';
    }else{
        if(error>=1 || error==-1){
            error=error-1;
        }
    }
    
    if($('#fila').val()==0 || $('#fila').val()=='' || $('#fila').val()==null){
        error+=1;
        mensajeerror=mensajeerror+' Debe de Seleccionar la Fila para continuar \n';
    }else {
        if(error>=1 || error==-1){
        error=error-1;
        }
    }
    if ($('#noaltura').val()==0 || $('#noaltura').val()==''){
        error+=1;
        mensajeerror=mensajeerror+' la altura del contenedor no puede ser o sin valor \n';
    }else{
        if(error>=1 || error==-1){
        error=error-1;
        }
    }
    if (error<0){
        error=0;
    }
    $("#btnGuardar").prop("disabled",false);
    var formdata=new FormData($("#formularioposcon")[0]);
    
    if (error==0){
        $.ajax({
            url:'../ajax/posicionprecon.php?op=guardareditar',
            type:'POST',
            data: formdata,
            contentType: false,
            processData: false,
            datatype:'json',
            success:function(da){
                var d=da.substring(0,2);
                if(d=='Se'){
                    swal({icon:'success',title:'Posicion Contenedor',text:da});
                    tabla.ajax.reload();
                    $('#getmodalcpos').modal('toggle');
                }else if(d=='Er'){
                    swal({icon:'warning',title:'Error al Grabar Posicion de Contenedor',text:da});
                }else {
                    swal('Error: -> '. e);
                }
                
            },
            error:function(xhr, ajaxOptions, thrownError){
                 alert(thrownError);
            }
        });
    }else{
        swal({
            title:'Error al Grabar',
            icon:'warning',
            text:'Se ha generado los siguiente errores: \n' + mensajeerror
        })
    };
}
function mostrar(id){
    $.post("../ajax/posicionprecon.php?op=mostrar",{idposcont:id},
        function(data,status){
            datos=JSON.parse(data);
            $('#idposcont').val(datos.id_conte_posi);
            $('#fechai').val(datos.fecha);
            $('#hora').val(datos.hora);
            $('#contenedor').val(datos.id_ingre_m);
            $('#contenedor').selectpicker('refresh');
            $('#patio').val(datos.idpatio);
            $('#patio').val(datos.idpatio).change();
            $('#patio').selectpicker('refresh');
            $('#area_p').val(datos.idarea);
            $('#bloque_p').val(datos.idbloque);
            $('#fila_p').val(datos.idfila);
            $('#areap').val(datos.idarea);
            $('#areap').selectpicker('refresh');
             mostraringreso(datos.id_ingre_m);
            $('#areap').val(datos.idarea).change();
            $('#bloque').val(datos.idbloque).change();
            $('#bloque').val(datos.idbloque);
            $('#bloque').selectpicker('refresh');
            $('#idingreso').val(datos.id_ingre_m);
            $('#fila').val(datos.idfila);
            $('#fila').val(datos.idfila).change();
            $('#fila').selectpicker('refresh');
            
            $('#observaciones').val(datos.observaciones);
            $('#contenedor').prop("disabled", true);
            $('#contenedor').selectpicker('refresh');
            mostrarmodal();
        }
                
                        
    );
   
}
function dasactivar(val,val2){
    $('#idposconta').val(val);
    $('#idaltura').val(val2)
    $('#getmodalanp').modal('show');
}
function cancelar_anu(){
    $('#usuario').val('');
    $('#password').val('');
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
                var idanular=$("#idposconta").val();
                var id_al=$('#idaltura').val();
                desactivar_pos(idanular,id_al);
            }else{
                swal({title:'Anulacion Cancelada',title:"No cuenta con el acceso para anular el ingreso"})
            }
        }
        );
    }
}
function desactivar_pos(idanular,id_al){
    swal({
        title: "Anulacion de Registro",
        text: "Esta seguro de Anular la Posicion actual del Contenedor",
        icon: "warning",
        buttons: true,
        dangerMode:true,
    })
            .then((willDelete)=>{
                if (willDelete){
                    $.post("../ajax/posicionprecon.php?op=desactivar",{idposcon:idanular,idaltura:id_al},function(e){
                       var c=e.substring(0,2);
                       if (c=="Se"){
                           limpiar();
                           swal({icon:'success',title:'Anulacion de Posicion Contenedor',title:e});
                       }else if (c=="No"){
                           limpiar();
                            swal({icon:'warning',title:'Anulacion de Posicion Contenedor',title:e});
                       }else{
                           swal("Error: "+ e );
                       }
                                $("#usuario").val('');
                                $("#password").val('');
                                $('#getmodalanp').modal('toggle');
				tabla.ajax.reload();
                    });
                }else{
                    swal("Se ha Cancelado la Accion por el Usuario!");
                    $('#getmodalanp').modal('toggle');
                }
            });
}
$("#contenedor").change(function(){
    var idingreso=$('#contenedor').val();
     $("#idingreso").val(idingreso);
    mostraringreso(idingreso);
});
$('#patio').change(function(){
   var idpatio=$('#patio').val();
   var idpos=$('#idposcont').val();
   $.ajax({
      url:'../ajax/posicionprecon.php?op=listararea',
      data:{id_patio:idpatio},
      type:"get",
      datatype: 'json',
      success:function(r){
          $('#areap').removeAttr('disabled');
          $('#areap').html(r);
         
          if ( idpos !== ''){
              $('#areap').val(idpos);
          }
           $('#areap').selectpicker('refresh');
      },
      error:function(r){
        console.log(r);  
      }
   });
});
$('#areap').change(function(){
    var idarea=$('#areap').val();
    if (idarea==null){
        idarea=$('#area_p').val();
    }
    var idblo=$('#bloque_p').val();
   $.ajax({
       url:'../ajax/posicionprecon.php?op=listarbloque',
       data:{id_area:idarea},
       type:"get",
       datatype: 'json',
       success:function(r){
           $('#bloque').removeAttr('disabled');
           $('#bloque').html(r);
           if (idblo !== ''){
               $('#bloque').val(idblo);
           }
           $('#bloque').selectpicker('refresh');
       },
       error:function(r){
           console.log(r);
       }
   });
});
$('#bloque').change(function(){
   var idbloque=$('#bloque').val();
   if (idbloque==null){
       idbloque=$('#bloque_p').val()
   }
   var idfil=$('#fila_p').val();
   $.ajax({
      url:'../ajax/posicionprecon.php?op=listarfila',
      data:{id_bloque:idbloque},
      type:"get",
      datatype:'json',
      success:function(r){
          $('#fila').removeAttr('disabled');
          $('#fila').html(r);
          if (idfil !== '' ){
              $('#fila').val(idfil);
          }
          $('#fila').selectpicker('refresh');
      },
      error:function(r){
          console.log(r);
      }
   });
});
$('#fila').change(function(){
    var idfila=$('#fila').val();
    if (idfila==null){
        idfila=$('#fila_p').val();
    }
    $.ajax({
        url:'../ajax/posicionprecon.php?op=alturafila',
        data:{id_fila:idfila},
        type:"get",
        datatype:'json',
        success:function(r){
            $('#numerofila_c').html(r);
        }
    })
})