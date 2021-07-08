init();

function init(){
    contador_ingresos();
    contador_tirs();
    contador_conexion();
    contador_movinternos();
}

function contador_ingresos(){
    $.post('../ajax/dashboard.php?op=cantidad_ingreso_maestros',
    function(data){
       dc=JSON.parse(data);
       $('#cantidadingresos').html(dc);
    });
}
function contador_tirs(){
    $.post('../ajax/dashboard.php?op=cantidad_tirs',
            function(data){
                d=JSON.parse(data);
                $('#cantidadtir').html(d);
            }
     );
}
function contador_conexion(){
    $.post('../ajax/dashboard.php?op=Cantidad_conexion',
        function(data){
            d=JSON.parse(data);
            $('#cantidadConexion').html(d);
        }
    );
}
function contador_movinternos(){
    $.post('../ajax/dashboard.php?op=cantidad_movinterno',
    function(data){
        d=JSON.parse(data);
        $('#cantidadmovint').html(d);
    });
}