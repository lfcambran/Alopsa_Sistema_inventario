var tabla;

//funcion que se ejecuta al inicio
function init(){
   mostrarform(false);
   mostrarform_clave(false);
   listar();
$("#formularioc").on("submit",function(c){
   	editar_clave(c);
   })
   $("#formulario").on("submit",function(e){
   	guardaryeditar(e);
   })

   $("#imagenmuestra").hide();
//mostramos los permisos
$.post("../ajax/usuario.php?op=permisos&id=", function(r){
	$("#permisos").html(r);
});
}

//funcion limpiar
function limpiar(){
	$("#nombre").val("");
        $("#departamento").val("");
	$("#empresa").val("")
	$("#email").val("");
	$("#cargo").val("");
	$("#login").val("");
	$("#clave").val("");
	$("#imagenmuestra").attr("src","");
	$("#imagenactual").val("");
	$("#idusuario").val("");
        $("#cargo").selectpicker('refresh');
}

//funcion mostrar formulario
function mostrarform(flag){
	limpiar();
	if(flag){
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		$("#btnGuardar").prop("disabled",false);
		$("#btnagregar").hide();
	}else{
		$("#listadoregistros").show();
		$("#formularioregistros").hide();
		$("#btnagregar").show();
	}
}
function mostrarform_clave(flag){
	limpiar();
	if(flag){
		$("#listadoregistros").hide();
		$("#formulario_clave").show();
		$("#btnGuardar_clave").prop("disabled",false);
		$("#btnagregar").hide();
	}else{
		$("#listadoregistros").show();
		$("#formulario_clave").hide();
		$("#btnagregar").show();
	}
}
//cancelar form
function cancelarform(){
	$("#claves").show();
	limpiar();
	mostrarform(false);
}
function cancelarform_clave(){
	limpiar();
	mostrarform_clave(false);

}
//funcion listar
function listar(){
	tabla=$('#tbllistado').dataTable({
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
			url:'../ajax/usuario.php?op=listar',
			type: "get",
			dataType : "json",
			error:function(e){
				console.log(e.responseText);
			}
		},
		"bDestroy":true,
		"iDisplayLength":5,//paginacion
		"order":[[0,"desc"]]//ordenar (columna, orden)
	}).DataTable();
}
//funcion para guardaryeditar
function guardaryeditar(e){
     e.preventDefault();//no se activara la accion predeterminada 
     $("#btnGuardar").prop("disabled",true);
     var formData=new FormData($("#formulario")[0]);

     $.ajax({
     	url: "../ajax/usuario.php?op=guardaryeditar",
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
$("#claves").show();
     limpiar();
}

function editar_clave(c){
     c.preventDefault();//no se activara la accion predeterminada 
     $("#btnGuardar_clave").prop("disabled",true);
     var formData=new FormData($("#formularioc")[0]);

     $.ajax({
     	url: "../ajax/usuario.php?op=editar_clave",
     	type: "POST",
     	data: formData,
     	contentType: false,
     	processData: false,

     	success: function(datos){
     		bootbox.alert(datos);
     		mostrarform_clave(false);
     		tabla.ajax.reload();
     	}
     });

     limpiar();
}
function mostrar(idusuario){
	$.post("../ajax/usuario.php?op=mostrar",{idusuario : idusuario},
		function(data,status)
		{
			data=JSON.parse(data);
			mostrarform(true);
			if ($("#idusuario").val(data.idusuario).length==0) {
           	$("#claves").show();
           	
           }else{
			$("#claves").hide();
			}
			$("#nombre").val(data.nombre_usuario);
            //$("#tipo_documento").val(data.tipo_documento);
            //$("#tipo_documento").selectpicker('refresh');
            //$("#num_documento").val(data.num_documento);
            $("#empresa").val(data.empresa);
            $("#departamento").val(data.departamento);
            $("#email").val(data.email);
            $("#cargo").val(data.id_rol);
            $("#cargo").selectpicker('refresh');
            $("#login").val(data.usuario);
        
            $("#imagenmuestra").show();
            $("#imagenmuestra").attr("src","../files/usuarios/"+data.imagen);
            $("#imagenactual").val(data.imagen);
            $("#idusuario").val(data.id_usuario);

 
		});
	$.post("../ajax/usuario.php?op=permisos&id="+idusuario, function(r){
	$("#permisos").html(r);
});
}

function mostrar_clave(idusuario){
	$.post("../ajax/usuario.php?op=mostrar_clave",{idusuario : idusuario},
		function(data,status)
		{
			data=JSON.parse(data);
			mostrarform_clave(true);
            $("#clavec").val(data.clave);
            $("#idusuarioc").val(data.idusuario);
		});
}

//funcion para desactivar
function desactivar(idusuario){
	bootbox.confirm("¿Esta seguro de desactivar este dato?", function(result){
		if (result) {
			$.post("../ajax/usuario.php?op=desactivar", {idusuario : idusuario}, function(e){
				bootbox.alert(e);
				tabla.ajax.reload();
			});
		}
	})
}

function activar(idusuario){
	bootbox.confirm("¿Esta seguro de activar este dato?" , function(result){
		if (result) {
			$.post("../ajax/usuario.php?op=activar", {idusuario : idusuario}, function(e){
				bootbox.alert(e);
				tabla.ajax.reload();
			});
		}
	})
}


init();