<?php 
require_once "global.php";

$conexion=new mysqli(DB_HOST,DB_USERNAME,DB_PASSWORD,DB_NAME);

mysqli_query($conexion, 'SET NAMES "'.DB_ENCODE.'"');

//muestra posible error en la conexion
if (mysqli_connect_errno()) {
	printf("Falló en la conexion con la base de datos: %s\n",mysqli_connect_error());
	exit();
}

if (!function_exists('ejecutarConsulta')) {
	Function ejecutarConsulta($sql){ 
global $conexion;
$query=$conexion->query($sql);
if ($query==false){
    $fila='errores.txt';
    $errorconsulta=date('l jS \of F Y h:i:s A'). " - " . mysqli_errno($conexion). " : " . mysqli_error($conexion) . ' - ' . $sql ."\n";
    file_put_contents($fila, $errorconsulta, FILE_APPEND | LOCK_EX);
}
return $query;

}

function ejecutarConsultaSimpleFila($sql){
            global $conexion;

            $query=$conexion->query($sql);
            $row=$query->fetch_assoc();
            if ($query==false){
                $fila='errores.txt';
                $errorconsulta=date('l jS \of F Y h:i:s A'). " - " . mysqli_errno($conexion). " : " . mysqli_error($conexion) . ' - ' . $sql ."\n";
                file_put_contents($fila, $errorconsulta, FILE_APPEND | LOCK_EX);
            }
            return $row;
}

function ejecutarConsulta_retornarID($sql){
global $conexion;
$query=$conexion->query($sql);
 if ($query==false){
                $fila='errores.txt';
                $errorconsulta=date('l jS \of F Y h:i:s A'). " - " . mysqli_errno($conexion). " : " . mysqli_error($conexion) . ' - ' . $sql ."\n";
                file_put_contents($fila, $errorconsulta, FILE_APPEND | LOCK_EX);
            }
return $conexion->insert_id;
}
function numeroitem($sql){
    global $conexion;
    $result=$conexion->query($sql);
    $rowcount=mysqli_num_rows($result);
     
    return $rowcount;
}
function limpiarCadena($str){
global $conexion;
$str=mysqli_real_escape_string($conexion,trim($str));
return htmlspecialchars($str);
}

}

 ?>