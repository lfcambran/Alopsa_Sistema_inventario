var tabla;

init();

function init(){
      listar();
      listacomboingreso();
      llenarcombopatio();
      $("#formularioposcon").on('submit',function(e){
         guardar_editar(e); 
      });
}

function listar(){
    tabla=$('#tbllistaposicionc').dataTable().DataTable();
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
            success:function(d){
                
            },
            error:function(d){
                
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
 
$("#contenedor").change(function(){
    var idingreso=$('#contenedor').val();
    mostraringreso(idingreso);
});
$('#patio').change(function(){
   var idpatio=$('#patio').val();
   $.ajax({
      url:'../ajax/posicionprecon.php?op=listararea',
      data:{id_patio:idpatio},
      type:"get",
      datatype: 'json',
      success:function(r){
          $('#areap').removeAttr('disabled');
          $('#areap').html(r);
          $('#areap').selectpicker('refresh');
          
      },
      error:function(r){
        console.log(r);  
      }
   });
});
$('#areap').change(function(){
   var idarea=$('#areap').val();
   $.ajax({
       url:'../ajax/posicionprecon.php?op=listarbloque',
       data:{id_area:idarea},
       type:"get",
       datatype: 'json',
       success:function(r){
           $('#bloque').removeAttr('disabled');
           $('#bloque').html(r);
           $('#bloque').selectpicker('refresh');
       },
       error:function(r){
           console.log(r);
       }
   });
});
$('#bloque').change(function(){
   var idbloque=$('#bloque').val();
   $.ajax({
      url:'../ajax/posicionprecon.php?op=listarfila',
      data:{id_bloque:idbloque},
      type:"get",
      datatype:'json',
      success:function(r){
          $('#fila').removeAttr('disabled');
          $('#fila').html(r);
          $('#fila').selectpicker('refresh');
      },
      error:function(r){
          console.log(r);
      }
   });
});
$('#fila').change(function(){
    var idfila=$('#fila').val();
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