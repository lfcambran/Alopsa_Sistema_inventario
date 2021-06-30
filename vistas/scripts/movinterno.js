var tabla;
var tabla;
init();

function init(){
    lista();
    listac();
    listarcomboingreso();
    listarcomboingresoc();
    llenarcombopatio();
    llenarcombomedida();
    $('#semana').val(semanadelmes($('#fechamov').val()));
    $('#formularioagregar').on('submit',function(e){
       guardareditar(e); 
    });
    $('#formularioagregarc').on('submit',function(e){
       guardareditarc(e); 
    });
    
}
function lista(){
    tabla=$('#tbllista_movinterno').dataTable().DataTable();
}
function listac(){
    tabla=$('#tbllista_movinternoc').dataTable().DataTable();
}
function mostrarmodal(){
    var idmovinterno = $('#idmovinterno').val();
    if (idmovinterno==""){
        $('#titulo').html("Ingreso Movimientos Internos");
    }else{
        $('#titulo').html('Modificacion de Movimientos Internos No. ' + idmovinterno);
    }
    $('#getmodalmovinterno').modal('toggle');
}
function mostrarmodalc(){
    var idmovinterno = $('#idmovic').val();
    if (idmovinterno==""){
        $('#titulo').html("Ingreso Movimientos Internos Cabezales");
    }else{
        $('#titulo').html('Modificacion de Movimientos Internos Cabezales No. ' + idmovinterno);
    }
    $('#getmodalmovic').modal('toggle');
}
function listarcomboingreso(){
    $.post("../ajax/movinterno.php?op=listaringreso",function(r){
        $("#contenedor").html(r);
        $("#contenedor").selectpicker('refresh');
        $('#bloqueanterior').prop('disabled', true);
    });
}
function listarcomboingresoc(){
    $.post("../ajax/movinterno.php?op=listaringresoc",function(c){
        $("#contenedorc").html(c);
        $("#contenedorc").selectpicker('refresh');
    });
}
function llenarcombopatio(){
    $.post('../ajax/movinterno.php?op=listarpatio',function(r){
        $('#patio').html(r);
        $('#patio').selectpicker('refresh');
        $('#bloque').attr('disabled',!$('#bloque').attr('disabled'));
        $('#areap').attr('disabled',!$('#area').attr('disabled'));
    });
}
function llenarcombomedida(){
    $.post('../ajax/movinterno.php?op=listarmedidas', function(r){
        $('#medida').html(r);
        $('#medida').selectpicker('refresh');
        
    })
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
    $('#semana').val('');
    $('#anio').val(now.getFullYear());
    $('#fechamov').val(today);
    $('#Hingreso').val(horaactual);
    $('#contenedor').val('');
    $('#contenedor').selectpicker('refresh');
    $('#medida').val('');
    $('#bloque').val('');
    $('#cliente').val('');
    $('#actividad').val('');
    $('#patio').val('');
    $('#motivo').val('');
    listarcomboingreso();
    
}
function cancelarformc(){
    limpiarc();
}
function limpiarc(){
    var now = new Date();
    var day = ("0" + now.getDate()).slice(-2);
    var month = ("0" + (now.getMonth() + 1)).slice(-2);
    var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
    var hora = now.getHours();
    var minuto =("0" + now.getMinutes()).slice(-2);
    var segundo = ("0" + now.getSeconds()).slice(-2);
    var horaactual = hora + ":" + minuto + ":" + segundo;
    $('#semanac').val('');
    $('#fechamovc').val(today);
    $('#Hingresoc').val(horaactual);
    $('#contenedorc').val('');
    $('#contenedorc').selectpicker('refresh');
    $('#clientec').val('');
    $('#actividadc').val('');
    $('#comentario').val('');
    listarcomboingresoc();
}
function guardareditar(e){
    e.preventDefault();
    var error=0;
    var mensajeerror='';
    
    if ($('#contenedor').val()==0){
        error+=1;
        mensajeerror=mensajeerror+' Debe de Seleccionar un Contenedor para continuar \n';
    }else{
           if(error>=1){
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
    if ($('#cliente').val()==''){
         error+=1;
        mensajeerror=mensajeerror+'Debe de ingresar un cliente \n';
    }else{
        if( error==-1){
            error=error-1;
        }
    }
    if ($('#medida').val()==0 || $('#medida').val()=='' || $('#medida').val()==null){
        error+=1;
        mensajeerror=mensajeerror+'Debe de especificar la medida del contenedor \n';
    }
    else{
        if (error==-1){
            error=error-1;
        }
    }
     $("#btnGuardar").prop("disabled",false);
    var formdata=new FormData($('#formularioagregar')[0]);
    
    if(error==0){
        $.ajax({
           url:'../ajax/movinterno.php?op=guardareditar',
           type:'POST',
           data: formdata,
           contentType:false,
           processData:false,
           datatype:'json',
           success:function(da){
                var d=da.substring(0,2);
                if(d=='Se'){
                    swal({icon:'success',title:'Movimiento Interno',text:da});
                    tabla.ajax.reload();
                    $('#getmodalmovinterno').modal('toggle');
                }else if(d=='Er'){
                    swal({icon:'warning',title:'Error al Grabar el Movimiento Interno',text:da});
                }else {
                    swal('Error: -> '. e);
                }
           },
        });
    }else{
        swal({
            title:'Error al Grabar',
            icon:'warning',
            text:'Se ha generado los siguiente errores: \n' + mensajeerror
        })
    };
}
function semanadelmes(fecha){
    var dt = new Date(fecha);
    var thisDay = dt.getDate();

    var newDate = dt;
    newDate.setDate(1); 
    var digit = newDate.getDay();

    var Q = (thisDay + digit) / 7;

    var R = (thisDay + digit) % 7;

    if (R !== 0) 
        return Math.ceil(Q);
    else 
        return Q;
}

$('#patio').change(function(){
     var idpatio=$('#patio').val();
     $.ajax({
        url:'../ajax/movinterno.php?op=listararea',
        data:{id_patio:idpatio},
        type:'get',
        datatype:'json',
        success:function(r){
            $('#areap').removeAttr('disabled');
            $('#areap').html(r);
            $('#areap').selectpicker('refresh');
        }
     });
});
$('#contenedor').change(function(){
    var idingreso=$('#contenedor').val();
    $.post('../ajax/movinterno.php?op=mostrarbloqueanterior',{contenedor:idingreso},
       function(data,status){
           d=JSON.parse(data);
           $('#bloqueanterior').val(d.Descripcion);
           $('#bloqueanteriorh').val(d.Descripcion);
       }
    );
});
$('#areap').change(function(){
     var idarea=$('#areap').val();
     $.ajax({
        url:'../ajax/movinterno.php?op=listarbloque',
        data:{id_area:idarea},
        type:"get",
        datatype: 'json',
        success:function(r){
           $('#bloque').removeAttr('disabled');
           $('#bloque').html(r);
           $('#bloque').selectpicker('refresh');
        }
     });
});
$('#cliente').change(function(){
        if ($('#cliente').val()=='MAERSK'){
            $.ajax({
               url:'../ajax/movinterno.php?op=mostraropcion',
               type:'get',
               datatype:'json',
               success:function(r){
                   $('#opcion').html(r);
               }
            });
        }
          
})