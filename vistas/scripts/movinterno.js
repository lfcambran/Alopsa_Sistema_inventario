var tabla;
var tabla2;
init();

function init(){
    lista();
    listac();
    listarcomboingreso();
    listarcomboingresoc();
    llenarcombopatio();
    llenarcombomedida();
    $('#semana').val(semanadelmes($('#fechamov').val()));
    $('#semanac').val(semanadelmes($('#fechamovc').val()));
    $('#formularioagregar').on('submit',function(e){
       guardareditar(e); 
    });
    $('#formularioagregarc').on('submit',function(e){
       guardareditarc(e); 
    });
    $('#formularioanulacion').on('submit',function(e){
        validarusuario(e);
    })
}
function lista(){
    tabla=$('#tbllista_movinterno').dataTable({
        'aProcessing':true,
        'aServerSide':true,
        'ajax':{
          url:'../ajax/movinterno.php?op=listar',
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
function listac(){
    tabla2=$('#tbllista_movinternoc').dataTable({
        'aProcessing':true,
        'aServerSide':true,
        'ajax':{
          url:'../ajax/movinternoc.php?op=listar',
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
    var idmovinterno = $('#idmovinterno').val();
    if (idmovinterno==""){
        $('#titulo').html("Ingreso Movimientos Internos");
    }else{
        $('#titulo').html('Modificacion de Movimientos Internos No. ' + idmovinterno);
    }
    $('#getmodalmovinterno').modal('toggle');
}
function mostrarmodalc(){
    var idmovinternoc = $('#idmovic').val();
    if (idmovinternoc==""){
        $('#tituloc').html("Ingreso Movimientos Internos Cabezales");
    }else{
        $('#tituloc').html('Modificacion de Movimientos Internos Cabezales No. ' + idmovinternoc);
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
    $('#medida').selectpicker('refresh');
    $('#bloque').val('');
    $('#bloque').selectpicker('refresh');
    $('#cliente').val('');
    $('#cliente').trigger('change');
    $('#actividad').val('Mov Interno');
    $('#patio').val('');
    $('#patio').selectpicker('refresh');
    $('#patio').trigger('change');
    $('#motivo').val('');
    $('#areap').val('');
    $('#semana').val(semanadelmes($('#fechamov').val()));
    $('#edita').val('');
    $('#idbloque').val("");
    $('#idareap').val("");
    $('#idpatio').val("");
    $('#bloqueanteriorh').val("");
    $('#bloqueanterior').val("");
    $('#bloque').trigger('change');
    $('#areap').trigger('change');
    $('#idmovinterno').val('');
    $('#opcionac').val('');
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
    $('#actividadc').val('Mov. Interno');
    $('#comentarioc').val('');
    $('#semanac').val(semanadelmes($('#fechamovc').val()));
    $('#titulo').html('');
    $('#idmovic').val('');
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
                    limpiar();
                    $('#getmodalmovinterno').modal('toggle');
                }else if(d=='Er'){
                    swal({icon:'warning',title:'Error al Grabar el Movimiento Interno',text:da});
                }else {
                    swal('Error: -> '.da);
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
function guardareditarc(e){
    e.preventDefault();
    var error=0;
    var mensajeerror="";
    
    if ($('#clientec').val==''){
        error+=1;
             mensajeerror=mensajeerror+' Debe de ingresar el nombre del cliente';
    }else{
          if(error>=1){
            error=error-1;
        }
    }
    if ($('#actividadc').val()==''){
            error+=1;
             mensajeerror=mensajeerror+' Debe de Ingresar el nombre de la actividad';
    }else{
          if(error>=1){
            error=error-1;
        }
    }
    $('#btnGuardar2').prop('#disabled',false);
    
    var datosform=new FormData($('#formularioagregarc')[0]);
    
    if (error==0){
           $.ajax({
           url:'../ajax/movinternoc.php?op=guardareditar',
           type:'POST',
           data: datosform,
           contentType:false,
           processData:false,
           datatype:'json',
           success:function(da){
                var d=da.substring(0,2);
                if(d=='Se'){
                    swal({icon:'success',title:'Movimiento Interno con Cabezal',text:da});
                    tabla2.ajax.reload();
                    $('#getmodalmovic').modal('toggle');
                }else if(d=='Er'){
                    swal({icon:'warning',title:'Error al Grabar el Movimiento Interno con Cabezal',text:da});
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
    }
    
}
function mostrar(val){
    $.post('../ajax/movinterno.php?op=mostrar',{idmovinterno:val},
    function(data,status){
        
        if (status=='success'){
            d=JSON.parse(data);
            $('#edita').val('ac');
            $('#idmovinterno').val(d.Id_Movimientos);
            $('#semana').val(d.Semana);
            $('#anio').val(d.anio);
            $('#fechamov').val(d.Fecha_Movimiento);
            $('#hingreso').val(d.Hora_Ingreso);
            $('#contenedor').val(d.Contenedor);
            $('#contenedor').selectpicker('refresh');
            $('#idcontenedor').val(d.Contenedor);
            $('#bloqueanterior').val(d.banterior);
            $('#bloqueanteriorh').val(d.banterior);
            $('#medida').val(d.Medida);
            $('#medida').selectpicker('refresh');
            $("#idpatio").val(d.Patio);
            $("#patio").val(false).trigger("change");
            $('#idareap').val(d.area);
            $('#areap').val(true).trigger("change");
            $('#patio').val(d.Patio);
            $('#patio').selectpicker('refresh');
            $('#areap').val(d.area);
            $('#areap').selectpicker('refresh');
            $('#bloque').val(d.bnuevo);
            $('#idbloque').val(d.bnuevo);
            $('#bloque').selectpicker('refresh');
            $('#cliente').val(d.Cliente);
            $('#motivo').val(d.Motivo);
            $('#actividad').val(d.Actividad);
            $('#cliente').trigger('change');
            $('#opcionac').val(d.opciont);

            mostrarmodal();
        }else{
            swal('Se Genero un error al consultar la informacion del movimiento'+status);
        }
    }
    );
}
function mostrarc(val){
    $.post('../ajax/movinternoc.php?op=mostrar',{idmovinternoc:val},
    function(data,status){
        d=JSON.parse(data);
        $('#idmovic').val(d.id);
        $('#semanac').val(d.semana);
        $('#fechamovc').val(d.fecha_mov);
        $('#hingresoc').val(d.hora_ingreso);
        $('#contenedorc').val(d.contenedor);
        $('#contenedorc').selectpicker('refresh');
        $('#clientec').val(d.cliente);
        $('#actividadc').val(d.actividad);
        $('#comentarioc').val(d.Movinter_c)
        if (d.estado=='inactivo'){
            $('#btnGuardar2').prop('disabled',true);
        }else if (d.estado=='activo'){
            $('#btnGuardar2').prop('disabled',false);
        }
       mostrarmodalc() 
    });
}
function dasactivarc(val){
   $('#idmov_intc').val(val);
   $('#tipomov').val('internoc');
    $('#getmodalanmintc').modal('show');
}
function activarc(val){
    swal({
       title:"Activacion de Movimiento Interno Con cabezal",
       text:"¿Se activara el ingreso seleccionado desea continuar?",
       icon:"success",
       buttons: true,
       dangerMode: true,
    }).then((willDelete)=>{
        if (willDelete){
        $.post("../ajax/movinternoc.php?op=activar", {idmovinterc:val}, function(e){
				swal(e);
				tabla2.ajax.reload();
			});
              }
    });
   
}
function cancelar_anu(){
    $('#usuario').val('');
    $('#password').val('');
}
function validarusuario(e){
    e.preventDefault();
    $('#btnGuardar3').prop('disabled',false);
    var usuario=$("#usuario").val();
    var password=$("#password").val();
    if ($("#usuario").val()==""){
        swal({ title: "Parametro Requerido", text:"Debe de Ingresar su usuario para anular"});
    }else if ($("#password").val()=="") {
        swal({title:"Parametro Requerido",text:'Debe de Ingresar su contraseña para continuar'});
    }else{
        $.post("../ajax/usuario.php?op=validaranulacion",{"logina":usuario,"clavea":password},
        function(data){
            if (data!="null"){
                var idmovintc=$("#idmov_intc").val();
                   desactivar_movinterc(idmovintc);
            }else{
                swal({title:'Anulacion Cancelada',title:"No cuenta con el acceso para anular "})
            }
        }
        );
    }
}
function desactivar_movinterc(val){
    swal({
        title: "Anulacion de Registro",
        text: "Esta seguro de Anular el Movimiento con Cabezal",
        icon: "warning",
        buttons: true,
        dangerMode:true,
    })
            .then((willDelete)=>{
                if (willDelete){
                    $.post("../ajax/movinternoc.php?op=desactivar",{idmovinterc:val},function(e){
                       var c=e.substring(0,2);
                       if (c=="Se"){
                           limpiar();
                           swal({icon:'success',title:'Anulacion el Movimiento Interno',title:e});
                       }else if (c=="No"){
                           limpiar();
                            swal({icon:'warning',title:'Anulacion del Movimiento Interno',title:e});
                       }else{
                           swal("Error: "+ e );
                       }
                                $("#usuario").val('');
                                $("#password").val('');
                                $('#getmodalanmintc').modal('toggle');
				tabla2.ajax.reload();
                    });
                }else{
                    swal("Se ha Cancelado la Accion por el Usuario!");
                    $('#getmodalanmintc').modal('toggle');
                }
            });
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
     if (idpatio===null){
         idpatio=$('#idpatio').val();
     }else{
         
         idpatio=$('#patio').val();
     }
     $.ajax({
        url:'../ajax/movinterno.php?op=listararea',
        data:{id_patio:idpatio},
        type:'get',
        datatype:'json',
        success:function(r){
            $('#areap').removeAttr('disabled');
            $('#areap').html(r);
            $('#areap').selectpicker('refresh');
            if ($('#edita').val()=='ac'){
                $('#areap').val($('#idareap').val());
                $('#areap').selectpicker('refresh');
            }
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
           $('#idcontenedor').val(d.id_conte_posi);
       }
    );
});
$('#areap').change(function(){
     var idarea=$('#areap').val();
     if (idarea===null){
           idarea=$('#idareap').val();
     }else{
         idarea=$('#areap').val();
       
     }
     if (!idarea==""){   
     $.ajax({
        url:'../ajax/movinterno.php?op=listarbloque',
        data:{id_area:idarea},
        type:"get",
        datatype: 'json',
        success:function(r,status){
           $('#bloque').removeAttr('disabled');
           $('#bloque').html(r);
           $('#bloque').selectpicker('refresh');
           if ($('#edita').val()=='ac'){
               $("#bloque").val($('#idbloque').val());
                $('#bloque').selectpicker('refresh');
           }
        }
     });
}else{
    $('#bloque').html('');
    $('#bloque').selectpicker('refresh');
}
});
$('#cliente').change(function(){
        if ($('#cliente').val()=='MAERSK'){
            if ($('#edita').val()=='ac'){
                var v=$('#opcionac').val();
                $.ajax({
                    url:'../ajax/movinterno.php?op=mostraropcionac',
                    type: 'get',
                    data: {valor:v},
                    datatype:'json',
                     success:function(r){                    
                        $('#opcion').html(r);
                    }
                });
            }else{
            $.ajax({
               url:'../ajax/movinterno.php?op=mostraropcion',
               type:'get',
               datatype:'json',
               success:function(r){                    
                        $('#opcion').html(r);
                    }
            });
        } 
    }else {
            $('#opcion').html("");
        }
          
})