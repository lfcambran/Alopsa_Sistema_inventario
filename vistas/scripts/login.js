function mostrarmodal(){
    $('#getmodal_cambio').modal('toggle');
}
function limpiar(){
    $("#usuario").val("");
    $("#newpassword").val("");
}
function cambiarpassword(){
    var usuario=$("#usuario").val();
    var password=$("#newpassword").val();
    
    if (usuario==""){
        bootbox.alert("Debe de Ingresar el usuario para continuar");
    }else if (password=="") {
        bootbox.alert("Debe de Ingresar el nuevo Password ");
    } else{
    
    $.post('../ajax/usuario.php?op=consultarusuario',{idusuario:usuario}, function(e){
        if (e=='1'){
            bootbox.alert("El usuario que ingreso no existe");
        }else{
            $.post('../ajax/usuario.php?op=resetpassword',{idusuario:usuario,clave:password}, function(e){
                bootbox.alert(e);
                limpiar();
               $('#getmodal_cambio').modal('toggle');
        
           });
        }
    });
    }
    
}
$("#frmAcceso").on('submit',function(e)
{
    
    e.preventDefault();
    logina=$("#logina").val();
    clavea=$("#clavea").val();

    $.post("../ajax/usuario.php?op=verificar",
        {"logina":logina,"clavea":clavea},
        function(data)
    {
        if (data!="null")
        {
            
            $(location).attr("href","escritorio.php");            
        }
        else
        {
            swal({icon: "error", title:"Error de Autenticacion", text: "Usuario y/o Password incorrectos"});
        }
    });
})