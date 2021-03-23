<?php 
//incluir la conexion de base de datos
require "../config/Conexion.php";
class Consultas{


	//implementamos nuestro constructor
public function __construct(){

}

//listar registros
public function listar_asistencia($alumn_id,$team_id,$date_at){

	$sql="SELECT * FROM assistance a INNER JOIN alumn p ON a.alumn_id=p.id INNER JOIN team t ON a.team_id=t.idgrupo  WHERE a.alumn_id='$alumn_id' AND a.team_id='$team_id' AND a.date_at='$date_at'";
	return ejecutarConsulta($sql);
}
  
public function listar_comportamiento($alumn_id,$team_id,$date_at){

	$sql="SELECT * FROM behavior a INNER JOIN alumn p ON a.alumn_id=p.id INNER JOIN team t ON a.team_id=t.idgrupo  WHERE a.alumn_id='$alumn_id' AND a.team_id='$team_id' AND a.date_at='$date_at'";
	return ejecutarConsulta($sql);
}

public function ventasfechacliente($fecha_inicio,$fecha_fin,$idcliente){
	$sql="SELECT DATE(v.fecha_hora) as fecha, u.nombre as usuario, p.nombre as cliente, v.tipo_comprobante,v.serie_comprobante, v.num_comprobante , v.total_venta, v.impuesto, v.estado FROM venta v INNER JOIN persona p ON v.idcliente=p.idpersona INNER JOIN usuario u ON v.idusuario=u.idusuario WHERE DATE(v.fecha_hora)>='$fecha_inicio' AND DATE(v.fecha_hora)<='$fecha_fin' AND v.idcliente='$idcliente'";
	return ejecutarConsulta($sql);
}

public function totalcomprahoy(){  
	$sql="SELECT IFNULL(SUM(total_compra),0) as total_compra FROM ingreso WHERE DATE(fecha_hora)=curdate()";
	return ejecutarConsulta($sql);
}

public function totalventahoy(){
	$sql="SELECT IFNULL(SUM(total_venta),0) as total_venta FROM venta WHERE DATE(fecha_hora)=curdate()";
	return ejecutarConsulta($sql);
}

public function comprasultimos_10dias(){
	$sql=" SELECT CONCAT(DAY(fecha_hora),'-',MONTH(fecha_hora)) AS fecha, SUM(total_compra) AS total FROM ingreso GROUP BY fecha_hora ORDER BY fecha_hora DESC LIMIT 0,10";
	return ejecutarConsulta($sql);
}

public function ventasultimos_12meses(){
	$sql=" SELECT DATE_FORMAT(fecha_hora,'%M') AS fecha, SUM(total_venta) AS total FROM venta GROUP BY MONTH(fecha_hora) ORDER BY fecha_hora DESC LIMIT 0,12";
	return ejecutarConsulta($sql);
}

public function cantidadalumnos($user_id){
	$sql="SELECT COUNT(*) total_alumnos FROM alumn WHERE user_id='$user_id'";
	

	return ejecutarConsulta($sql);
}
public function cantidadalumnos_porgrupo($user_id,$idgrupo){
	$sql="SELECT a.id as idalumno, a.name,a.lastname,a.image  FROM alumn a INNER JOIN alumn_team alt ON a.id=alt.alumn_id WHERE a.user_id='$user_id' AND alt.team_id='$idgrupo'";
	
	
	return ejecutarConsulta($sql); 
}
public function cantidadg($user_id,$idgrupo){
	$sql="SELECT COUNT(*) total_alumnos  FROM alumn a INNER JOIN alumn_team alt ON a.id=alt.alumn_id WHERE a.user_id='$user_id' AND alt.team_id='$idgrupo'";
	

	return ejecutarConsulta($sql);
}

public function cantidadgrupos($idusuario){
	$sql="SELECT idgrupo,nombre, idusuario, favorito FROM team WHERE idusuario='$idusuario'";
	return ejecutarConsulta($sql);
}

public function cantidadarticulos(){
	$sql="SELECT COUNT(*) totalar FROM articulo WHERE condicion=1";
	return ejecutarConsulta($sql);
}
public function totalstock(){
	$sql="SELECT SUM(stock) AS totalstock FROM articulo";
	return ejecutarConsulta($sql);
}

public function cantidadcategorias(){
	$sql="SELECT COUNT(*) totalca FROM categoria WHERE condicion=1";
	return ejecutarConsulta($sql);
}

}

 ?>
