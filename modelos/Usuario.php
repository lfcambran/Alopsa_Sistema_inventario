<?php 
//incluir la conexion de base de datos
require "../config/Conexion.php";
class Usuario{


	//implementamos nuestro constructor
public function __construct(){

}

//metodo insertar regiustro
public function insertar($nombre,$departamento,$empresa,$email,$cargo,$login,$clave,$imagen,$permisos){
	$sql="INSERT INTO usuarios (nombre_usuario,departamento,empresa,email,id_rol,usuario,clave,imagen,condicion) VALUES ('$nombre','$departamento','$empresa','$email','$cargo','$login','$clave','$imagen','1')";
	//return ejecutarConsulta($sql);
	 $id_usuarionew=ejecutarConsulta_retornarID($sql);
	 $num_elementos=0;
	 $sw=true;
	 while ($num_elementos < count($permisos)) {

	 	$sql_detalle="INSERT INTO usuario_permiso (idusuario,idpermiso) VALUES('$id_usuarionew','$permisos[$num_elementos]')";

	 	ejecutarConsulta($sql_detalle) or $sw=false;

	 	$num_elementos=$num_elementos+1;
	 }
	 return $sw;
}

public function editar($id_usuario,$nombre,$departamento,$empresa,$email,$cargo,$login,$imagen,$permisos){
	$sql="UPDATE usuarios SET nombre_usuario='$nombre',departamento='$departamento',empresa='$empresa',email='$email',id_rol='$cargo',usuario='$login',imagen='$imagen' 
	WHERE id_usuario='$id_usuario'";
	 ejecutarConsulta($sql);

	 //eliminar permisos asignados
	 $sqldel="DELETE FROM usuario_permiso WHERE idusuario='$id_usuario'";
	 ejecutarConsulta($sqldel);

	 	 $num_elementos=0;
	 $sw=true;
	 while ($num_elementos < count($permisos)) {

	 	$sql_detalle="INSERT INTO usuario_permiso (idusuario,idpermiso) VALUES('$id_usuario','$permisos[$num_elementos]')";

	 	ejecutarConsulta($sql_detalle) or $sw=false;

	 	$num_elementos=$num_elementos+1;
	 }
	 return $sw;
}
public function editar_clave($id_usuario,$clave){
	$sql="UPDATE usuarios SET clave='$clave' WHERE id_usuario='$id_usuario'";
	return ejecutarConsulta($sql);
}
public function cambiar_clave($usuario,$clave){
    $sql="UPDATE usuarios SET clave='$clave' WHERE usuario='$usuario'";
    return ejecutarConsulta($sql);
}
public function mostrar_clave($id_usuario){
	$sql="SELECT id_usuario, clave FROM usuarios WHERE id_usuario='$id_usuario'";
	return ejecutarConsultaSimpleFila($sql);
}
public function desactivar($id_usuario){
	$sql="UPDATE usuarios SET condicion='0' WHERE id_usuario='$id_usuario'";
	return ejecutarConsulta($sql);
}
public function activar($id_usuario){
	$sql="UPDATE usuarios SET condicion='1' WHERE id_usuario='$id_usuario'";
	return ejecutarConsulta($sql);
}

//metodo para mostrar registros
public function mostrar($id_usuario){
	$sql="SELECT * FROM usuarios WHERE id_usuario='$id_usuario'";
	return ejecutarConsultaSimpleFila($sql);
}

//listar registros
public function listar(){
	$sql="SELECT * FROM usuarios";
	return ejecutarConsulta($sql);
}

//metodo para listar permmisos marcados de un usuarios especifico
public function listarmarcados($id_usuario){
	$sql="SELECT * FROM usuario_permiso WHERE idusuario='$id_usuario'";
	return ejecutarConsulta($sql);
}

//Función para verificar el acceso al sistema
public function verificar($login,$clave)
    {
    	$sql="SELECT id_usuario,nombre_usuario,email,descripcion cargo,imagen,nombre_usuario  FROM usuarios inner join rol on usuarios.id_rol = rol.id_rol WHERE usuario='$login' AND clave='$clave' AND condicion='1'"; 
    	return ejecutarConsulta($sql);  
    }
    
public function verificaranulacion($login,$clave){
    $sql="SELECT id_usuario,nombre_usuario,email,descripcion cargo,imagen,nombre_usuario  FROM usuarios inner join rol on usuarios.id_rol = rol.id_rol WHERE usuario='$login' AND clave='$clave' AND condicion='1' AND rol.id_rol in(1,3)"; 
    	return ejecutarConsulta($sql);  
}
public function consulta_usuario($usuario){
    $sql="select * from usuarios where usuario='$usuario'";
    if (numeroitem($sql)==0){
        return false;
    }else {
        return true;
        
    }
    
}
}

 ?>
