var tabla;

function init(){
    mostrarform(false);
      $("#formulario").on("submit",function(e){
   	guardaryeditar(e);
   });
    listar();
}
function mostrarform(flag){
    //limpiar();
    if (flag){
        $("#listadoregistrosf").hide();
        $("#formularioregistros").show();
		$("#btnGuardar").prop("disabled",false);
		$("#btnagregar").hide();
        
    }else{
        $("#listadoregistrosf").show();
		$("#formularioregistros").hide();
		$("#btnagregar").show();
        
    }
    
}
function cancelarform(){
	limpiar();
	mostrarform(false);
}
function limpiar(){
  $("#codigoid").val("");  
  $("#cabezal").val("");
  $("#nombrepiloto").val("");
  $("#licencia").val("");
  $("#placas").val("");
  $("#codigon").val("");
  $("#naviera").val("");
  $("#transporte").val("");
  $("#ubicacion").val("");
}
function listar(){
    tabla=$('#tbllistadof').dataTable({
		"aProcessing": true,//activamos el procedimiento del datatable
		"aServerSide": true,//paginacion y filrado realizados por el server
		dom: 'Bfrtip',//definimos los elementos del control de la tabla
		buttons: [
                  'copyHtml5',
                  'excelHtml5',
                  'csvHtml5',
                  'pdf'
		],
		"ajax":
		{
			url:'../ajax/flotatransporte.php?op=listar',
			type: "get",
			dataType : "json",
			error:function(e){
				console.log(e.responseText);
			}
		},
		"bDestroy":true,
		"iDisplayLength":10,//paginacion
		"order":[[0,"desc"]]//ordenar (columna, orden)
	}).DataTable();
}

function guardaryeditar(e){
    e.preventDefault();
    $("#btnGuardar").prop("disabled",true);
    var formData=new FormData($("#formulario")[0]);
    
    $.ajax({
       url:"../ajax/flotatransporte.php?op=guardaryeditar",
       type: "POST",
       data: formData,
       contentType: false,
       processData: false,
       
       success: function(datos){
           bootbox.alert(datos);
           mostrarform(false);
           tabla.ajax.reload();
       }
    });
    limpiar();
}
function mostrar(id){
   $.post("../ajax/flotatransporte.php?op=mostrar",{codigoid:id},
   function(data,status){
       data=JSON.parse(data);
       mostrarform(true);
        $("#codigoid").val(data.Id_f);  
        $("#cabezal").val(data.Cabezal);
        $("#nombrepiloto").val(data.Nombre_de_Piloto);
        $("#licencia").val(data.Licencias);
        $("#placas").val(data.Placas);
        $("#codigon").val(data.Codigo_Piloto_Naviera);
        $("#naviera").val(data.Naviera);
        $("#transporte").val(data.Transporte);
        $("#ubicacion").val(data.Ubicacion);
       
   }
    );  
}
function desactivar(id){
    bootbox.confirm("¿Esta seguro de desactivar este dato?", function(result){
            if(result){
                $.post("../ajax/flotatransporte.php?op=desactivar",{codigoid:id}, function(e){
                    bootbox.alert(e);
                    tabla.ajax.reload();
                });
            }
    });
}
function activar(id){
    bootbox.confirm("¿Esta seguro de activar este dato?" , function(result){
		if (result) {
			$.post("../ajax/flotatransporte.php?op=desactivar", {codigoid : id}, function(e){
				bootbox.alert(e);
				tabla.ajax.reload();
			});
		}
	});
}
init();