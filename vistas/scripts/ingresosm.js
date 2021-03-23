var tabla;

function init(){
    mostrarform(false);
    listar();
    listar_bloque();
    listar_pilotos();
}
function listar_bloque(){
    $.post("../ajax/bloque_posicion.php?op=listar_bloques",function(r){
        $("#bloque").html(r);
        $("#bloque").selectpicker('refresh');
    });
}
function listar_pilotos(){
    $.post("../ajax/flotatransporte.php?op=selectflota",function(r){
       $("#piloto").html(r);
       $("#piloto").selectpicker('refresh');
    });
    
}
function mostrarform(flag){
    if (flag){
        $("#listadoregistrosdb").hide();
        $("#formularioingreso").show();
		$("#btnGuardar").prop("disabled",false);
		$("#btnagregar").hide();
        
    }else{
        $("#listadoregistrosdb").show();
		$("#formularioingreso").hide();
		$("#btnagregar").show();
        
    }
}

function cancelarform(){
    limpiar();
    mostrarform(false);
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
    $("#fecha_ingreso").val(today);
    $("#horaingreso").val(horaactual);
    $("#nocontenedor").val("");
    $("#barco").val("");
    $("#tipoc").val("");
    $("#dcontenido").val("");
    $("#dservicio").val("");
    $("#marchamo").val("");
    $("#htir").val(horaactual);
    $("#serietir").val("A");
    $("#producto").val("");
    $("#orden").val("");         
    $("#destino").val("");
    $("#fechaasignacion").val();
    $("#observaciones").val();
    listar_bloque();
    listar_pilotos();
    $("#bloque").val(false).trigger( "change" );
    $("#posicion").val(false).trigger("change");
    $("#piloto").val(false).trigger("change");
    
    
}

function listar(){
    tabla=$('#tbllistadodm').dataTable({
        "aProcessing": true,
        "aServerSide": true,
        dom: 'Bfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'pdf'
        ],
        "ajax":{
                url:'../ajax/datosmaestro.php?op=listar',
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
$("#piloto").change(function(){
    var id_piloto=$("#piloto").val();
    $("#idpiloto").val(id_piloto);
   datospiloto();
});
$("#bloque").change(function(){
   var idbloque=$("#bloque").val();
   listarposicion(idbloque);
   
});
function listarposicion(val){
    $.post("../ajax/bloque_posicion.php?op=listar_posicion",{idbloque:val},function(r){
        $("#posicion").html(r);
        $("#posicion").selectpicker('refresh');
    });
}
function datospiloto(){
    var  idpiloto_f = $("#idpiloto").val();
    $.ajax({
       url:'../ajax/flotatransporte.php?op=mostrardatos',
       data:{idpiloto:idpiloto_f},
       type: "get",
       datatype:"json",
       success: function(resp){
        $('#datos_piloto').html(resp);
       }
    });
}
function guardaryeditar(e){
    e.preventDefault();
    $("#btnGuardar").prop("disabled",false);
    var formdata=new FormData($("#formularioingreso")[0]);
    $.ajax({
       url: "../ajax/datosmaestro.php?op=guardaryeditar",
       type: "POST",
       data: formdata,
       contentType: false,
       processData: false,
       
       success: function(datos){
           bootbox.alert(datos);
           mostrarform(false);
           tabla.ajax.reload();
       }
    });
}
function mostrar(id){
   $.post("../ajax/datosmaestro.php?op=mostrardatos",{idingreso:id},
           function(data,status){
             data=JSON.parse(data);
             mostrarform(true);
             $("#fecha_ingreso").val(data.Fecha_ingreso);
             $("#horaingreso").val(data.Hora_ingreso);
             $("#nocontenedor").val(data.No_Contenedor);
                $("#barco").val(data.Barco);
                $("#tipoc").val(data.Tipo_contenido);
                $("#dcontenido").val(data.Descripcion_contenido);
                $("#dservicio").val(data.Detalle_Servicio);
                $("#marchamo").val(data.Marchamo);
                $("#htir").val(data.Hora_TIR);
                $("#serietir").val(data.Serie_TIR);
                $("#producto").val(data.producto);
                $("#orden").val(data.Ord);         
                $("#destino").val(data.Destino);
                $("#fechaasignacion").val(data.Fecha_Asignacion);
                $("#observaciones").val(data.Observaciones);
                $("#bloque").val(data.Bloque);
                $("#bloque").selectpicker('refresh'); 
                $("#posicion").val(data.Posicion);
                $("#posicion").selectpicker('refresh');
                
           });
    
}
function desactivar(idingreso){
    bootbox.confirm("¿Esta seguro de desactivar el ingreso seleccionado?", function(result){
		if (result) {
			$.post("../ajax/datosmaestro.php?op=desactivar", {idingreso : idingreso}, function(e){
				bootbox.alert(e);
				tabla.ajax.reload();
			});
		}
	});
}
init();

