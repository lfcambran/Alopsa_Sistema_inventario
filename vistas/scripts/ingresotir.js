var tabla;
var tabla2;
var  i =1;
init();

function init(){
      listar();
      listarcomboingreso();
      tabladanios();
}

function listar(){
     tabla=$('#tbllistadotir').dataTable({
        "aProcessing": true,
        "aServerSide": true,
        dom: 'Bfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'pdf'
        ],
        "ajax":{
                url:'../ajax/daniostir.php?op=listar',
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

function tabladanios(){
    tabla2=$('#tablafallastir').dataTable({
      
    }).DataTable();
}
function mostrarmodal(){
    var idtir=$('#idintir').val();
    
    if (idtir==""){
        $("#titulo").html("Agregar Dator TIR");
    }else{
        $('#titulo').html("Modificacion del TIR No."+idtir);
    }
    $('#getmodaltir').modal('toggle');
}
function listarcomboingreso(){
    $.post("../ajax/daniostir.php?op=listaringreso",function(r){
         $("#contenedor").html(r);
        $("#contenedor").selectpicker('refresh');
    });
}

$("#contenedor").change(function(){
     var idingreso=$("#contenedor").val();
    mostraringreso(idingreso);
});
$("#ubicacion").change(function(){
    var opcionu=$("#ubicacion").val();
    mostrardanios(opcionu);
});
$('#agregar').click(function(){
    var ubicacion = document.getElementById("ubicacion");
    var ubic=ubicacion.options[ubicacion.selectedIndex].text;
    var opd=document.getElementById("opcionesd");
    var opciond =opd.options[opd.selectedIndex].text;
    var observacion = $('#observacionf').val();
       
    tabla2.row.add([i,ubic,opciond,'SI',observacion,'<button type="button" name="remove" id="' + i + '" class="btn btn-danger btn_remove">Quitar</button>']).draw(false);
    i++;
    $('#ubicacion').val("");
    $('#ubicacion').selectpicker('refresh');
    $('#opcionesd').val("");
    $('#opcionesd').selectpicker('refresh');
    $("#observacionf").val("");
    $("#tablafallastir").DataTable();
    
});

$(document).on('click','.btn_remove', function(){
       tabla2.row('.selected').remove().draw( false );  
       i=i-1;
});
 $('#tablafallastir tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
        }
        else {
            tabla2.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
    } );
function mostraringreso(val){
    $.ajax({
       url:'../ajax/daniostir.php?op=mostraringreso',
       data:{iding:val},
       type: "get",
       datatype: "json",
       success:function(resp){
            $('#datosingreso').html(resp);
       }
    });
}
function mostrardanios(val){
    $.post("../ajax/daniostir.php?op=listardanios",{udanio:val} ,function(r){
        $("#opcionesd").html(r);
        $("#opcionesd").selectpicker('refresh');
    })
}
