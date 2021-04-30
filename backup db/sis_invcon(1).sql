-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-04-2021 a las 07:50:24
-- Versión del servidor: 10.4.18-MariaDB
-- Versión de PHP: 7.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sis_invcon`
--
CREATE DATABASE IF NOT EXISTS `sis_invcon` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `sis_invcon`;

DELIMITER $$
--
-- Procedimientos
--
DROP PROCEDURE IF EXISTS `actualizar_asign`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `actualizar_asign` (IN `idasignacion` INT, IN `observaciones` VARCHAR(255), IN `bloque` INT, IN `posicion` INT, IN `idingreso` INT, IN `idf` INT)  begin
	start transaction;
		
	update sis_invcon.asignaciones set observaciones = observaciones,
									   bloque=bloque,
									   posicion = posicion,
									   id = idingreso,
									   Id_f = idf
	where Id_a = idasignacion;
	
	update sis_invcon.posicion set id_ingreso=idingreso, estado='Asignado' where idPosicion=posicion and idbloque=bloque;
		
if (@@error_count=0) then
	commit;
	else
	rollback;
end if;
commit;
END$$

DROP PROCEDURE IF EXISTS `actualizar_asignaciones`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `actualizar_asignaciones` (IN `idasignacion` INT, IN `Observaciones` VARCHAR(255), IN `Bloque` INT, IN `posiciona` INT, IN `idingresoa` INT, IN `idfa` INT)  begin
	 start transaction;
	update sis_invcon.asignaciones set observaciones = Observaciones,
	bloque = Bloque, posicion = posiciona, id = idingresoa,Id_f = idfa
	where Id_a = idasignacion;

if (@@error_count=0) then
	commit;
	else
	rollback;
end if;
commit;

END$$

DROP PROCEDURE IF EXISTS `actualizar_conexion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `actualizar_conexion` (IN `id_conexion` INT, IN `fechac` CHAR(10), IN `horacon` CHAR(10), IN `setpoint` DECIMAL(5,2), IN `suministro` DECIMAL(5,2), IN `retorno` DECIMAL(5,2), IN `idingreso` INT, IN `idf` INT, IN `temperatura` CHAR(2), IN `tipocon` CHAR(2))  BEGIN
  start transaction;

  update conexion set Fecha_Conexion = fechac,Hora_De_Conexion=horacon,Setpoint=setpoint,
        Retorno=retorno,Suministro=suministro,Id_ingreso=idingreso,Id_f=Id_f,temperatura=temperatura,tipoconexion=tipocon
    where Id=id_conexion;

  if (@@error_count=0) then
	commit;
	else
	rollback;
end if;
commit;

END$$

DROP PROCEDURE IF EXISTS `actualizar_desconexion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `actualizar_desconexion` (IN `iddesco` INT, IN `fechadesco` CHAR(10), IN `horadesco` CHAR(10), IN `totalhoras` CHAR(10), IN `observaciones` VARCHAR(70), IN `idf` INT, IN `idingre` INT, IN `idconexion` INT)  BEGIN
  start transaction;
      update desconexion set Fecha_De_Desconexion=fechadesco,Hora_De_Desconexio=horadesco,
        totalhoras=totalhoras,observaciones=observaciones,id=idingre,Id_f=idf,idconexion=idconexion
        where Id_d=iddesco;

  if (@@error_count=0) then
	commit;
	else
	rollback;
end if;
commit;

END$$

DROP PROCEDURE IF EXISTS `actualizar_ingreso`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `actualizar_ingreso` (IN `idingreso` INT, IN `fechaingreso` DATE, IN `horaingreso` CHAR(20), IN `nocontenedor` CHAR(20), IN `barco` VARCHAR(50), IN `tipocontenido` CHAR(20), IN `dcontenido` VARCHAR(20), IN `dservicio` VARCHAR(50), IN `marchamo` CHAR(20), IN `htir` CHAR(10), IN `serietir` CHAR(5), IN `producto` VARCHAR(30), IN `orden` INT, IN `bloque` CHAR(20), IN `posicion` INT, IN `destino` CHAR(20), IN `fechaasignacion` DATE, IN `observaciones` VARCHAR(200), IN `idf` INT, IN `idusuario` INT)  BEGIN
  DECLARE posiciona int;
  DECLARE bloquea char(20);

  select Bloque,Posicion INTO bloquea,posiciona from ingreso_maestro where Id_Ingreso=idingreso;
   update posicion set id_ingreso=0, estado='Sin Asignar' where id_ingreso=idingreso;

    UPDATE ingreso_maestro SET Fecha_ingreso=fechaingreso,
    Hora_ingreso=horaingreso,No_Contenedor=nocontenedor,Barco=barco,
    Tipo_Contenido=tipocontenido,Descripcion_contenido=dcontenido,Detalle_Servicio=dservicio,
    Marchamo=marchamo,Hora_TIR=htir,Serie_TIR=serietir,producto=producto,
    Ord=orden,Bloque=bloque,Posicion=posicion,Observaciones=observaciones,
    Destino=destino,Fecha_Asignacion=fechaasignacion,Estado='Ingresado',Id_f=idf,
    id_usuario=idusuario WHERE Id_Ingreso=idingreso;
   
    UPDATE posicion SET id_ingreso=idingreso, estado='Asignado' where idPosicion=posicion and idbloque=bloque;

  END$$

DROP PROCEDURE IF EXISTS `actualizar_monitoreo`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `actualizar_monitoreo` (IN `idmonitoreo` INT, IN `horamonitoreo` CHAR(10), IN `retorno` VARCHAR(30), IN `observaciones` VARCHAR(70), IN `producto` CHAR(20), IN `setpoint` CHAR(20), IN `suministro` VARCHAR(20), `fechamonitoreo` CHAR(10), IN `mecanico` CHAR(20), IN `idingreso` INT, IN `idf` INT, IN `temperatura` CHAR(2))  BEGIN
  start transaction;
  
  update monitoreo set Hora_De_Monitoreo=horamonitoreo,Retorno=retorno,Observaciones=observaciones,
    Producto=producto,Set_Point=setpoint,Suministro=suministro,Fecha_Del_Monitoreo=fechamonitoreo,
    Nombre_Del_Mecanico=mecanico,id_ingreso=idingreso,Id_f=idf,temperatura=temperatura
  where Id_m=idmonitoreo;

  if (@@error_count=0) then 
    commit;
    else
    rollback;
    end if;
commit;
END$$

DROP PROCEDURE IF EXISTS `datosconexion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `datosconexion` (IN `idconexion` INT)  BEGIN
select a.Fecha_Conexion,a.Hora_De_Conexion,a.Setpoint,a.Suministro,b.Fecha_ingreso,b.Hora_ingreso,c.Cabezal,c.Nombre_de_Piloto,b.Id_f,b.Id_Ingreso
  from conexion a
  inner join ingreso_maestro b on a.Id_ingreso=b.Id_Ingreso
  inner join flota_transporte c on b.Id_f=c.Id_f
  where a.id=idconexion;
END$$

DROP PROCEDURE IF EXISTS `datosingreso`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `datosingreso` (IN `idingreso` INT)  BEGIN
select a.Ord,a.producto,b.Descripcion,c.noposicion,a.Barco,a.Id_f from ingreso_maestro a 
  inner JOIN bloque b on a.Bloque=b.id_bloque
  inner JOIN posicion c on a.Posicion=c.idposicion and a.Bloque=c.idbloque
  inner join conexion d on d.Id_ingreso=a.Id_Ingreso
  where d.Id=idingreso and a.Estado='ingresado';
END$$

DROP PROCEDURE IF EXISTS `datosingreso_asig`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `datosingreso_asig` (IN `idingreso` INT)  BEGIN
SELECT a.Id_Ingreso,a.ord,b.Nombre_de_Piloto,b.Licencias,b.Placas,b.Codigo_Piloto_Naviera,a.No_Contenedor,
  a.Bloque,a.Posicion,a.producto,a.Barco,c.Descripcion,d.noposicion,a.Id_f
  from ingreso_maestro a 
  inner join flota_transporte b on b.Id_f=a.Id_f
  inner join bloque c on a.Bloque=c.id_bloque
  inner join posicion d on a.Posicion=d.idposicion
  where a.Estado='Ingresado' and a.Id_Ingreso=idingreso;
END$$

DROP PROCEDURE IF EXISTS `datosingreso_c`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `datosingreso_c` (IN `idingreso` INT)  BEGIN
select a.Ord,a.producto,b.Descripcion,c.noposicion,a.Barco,a.Id_f from ingreso_maestro a 
  inner JOIN bloque b on a.Bloque=b.id_bloque
  inner JOIN posicion c on a.Posicion=c.idposicion and a.Bloque=c.idbloque
  where a.Id_Ingreso=idingreso and a.Estado='ingresado';
END$$

DROP PROCEDURE IF EXISTS `datosingreso_datostir`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `datosingreso_datostir` (IN `idingreso` INT)  begin
	select a.Id_Ingreso,a.ord,b.Nombre_de_Piloto,b.Licencias,b.Placas ,b.Codigo_Piloto_Naviera,a.No_Contenedor,
	  b.Transporte,a.Destino,a.Id_f
	  from ingreso_maestro a 
	  inner join flota_transporte b on b.Id_f=a.Id_f
	  where a.Estado='Ingresado' and a.Id_Ingreso=idingreso;
END$$

DROP PROCEDURE IF EXISTS `insertar_asign`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `insertar_asign` (IN `observaciones` VARCHAR(255), IN `bloque` INT, IN `posicion` INT, IN `idingreso` INT, IN `idf` INT, IN `idusuario` INT)  BEGIN
start transaction;
    insert into asignaciones (observaciones,bloque,posicion,id,Id_f,id_usuario)VALUES(
    observaciones,bloque,posicion,idingreso,idf,idusuario
    );
    
     UPDATE posicion SET id_ingreso=idingreso, estado='Asignado' where idPosicion=posicion and idbloque=bloque;

if (@@error_count=0) then
	commit;
	else
	rollback;
end if;
commit;

END$$

DROP PROCEDURE IF EXISTS `insertar_cone`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `insertar_cone` (IN `fechac` CHAR(10), IN `horacon` CHAR(10), IN `setpoint` DECIMAL(5,2), IN `suministro` DECIMAL(5,2), IN `retorno` DECIMAL(5,2), IN `idingreso` INT, IN `idf` INT, IN `idusuario` INT, IN `temperatura` CHAR(2), IN `tipocon` CHAR(2))  BEGIN
	start transaction;
		INSERT into sis_invcon.conexion (Fecha_Conexion,Hora_De_Conexion,Setpoint,Suministro,Retorno,
	Id_ingreso,Id_f,Id_usuario,Estado,temperatura,tipoconexion) values (fechac,horacon,setpoint,suministro,retorno,idingreso,idf,idusuario,'Activo',temperatura,tipocon);
if (@@error_count=0) then
	commit;
	else
	rollback;
end if;
commit;
END$$

DROP PROCEDURE IF EXISTS `Insertar_desconexion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `Insertar_desconexion` (IN `fechadesco` CHAR(10), IN `horadesco` CHAR(10), IN `totalhoras` CHAR(10), IN `observaciones` VARCHAR(70), IN `idf` INT, IN `idingre` INT, IN `idusuario` INT, IN `idconexion` INT)  BEGIN
  	start transaction;
  insert into desconexion(Fecha_De_Desconexion,Hora_De_Desconexio,totalhoras,observaciones,id,Id_f,id_usuario,estado,idconexion)
          values (fechadesco,horadesco,totalhoras,observaciones,idingre,idf,idusuario,'Activo',idconexion);
  if (@@error_count=0) then
	commit;
	else
	rollback;
end if;
commit;
END$$

DROP PROCEDURE IF EXISTS `insertar_monitoreo`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `insertar_monitoreo` (IN `horamonitoreo` CHAR(10), IN `retorno` VARCHAR(30), IN `observaciones` VARCHAR(70), IN `producto` CHAR(20), IN `setpoint` CHAR(20), IN `suministro` VARCHAR(20), `fechamonitoreo` CHAR(10), IN `mecanico` CHAR(20), IN `idingreso` INT, IN `idf` INT, IN `idusuarios` INT, IN `temperaura` CHAR(2))  BEGIN
start transaction;
  insert into monitoreo (Hora_De_Monitoreo,Retorno,Observaciones,Producto,
                          Set_Point,Suministro,Fecha_Del_Monitoreo,
                          Nombre_Del_Mecanico,id_ingreso,Id_f,id_usuario,estado,temperatura) 
                      VALUES (horamonitoreo,retorno,observaciones,producto,setpoint,suministro,
                              fechamonitoreo,mecanico,idingreso,idf,idusuarios,'Activo',temperaura);
if (@@error_count=0) then
  commit;
  else
  rollback;
  end if;
commit;
END$$

DROP PROCEDURE IF EXISTS `insert_fallastir`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_fallastir` (IN `iddtir` INT, IN `ubicacion` CHAR(50), IN `f` CHAR(20), IN `op` BIT, IN `obser` VARCHAR(50), IN `pos` VARCHAR(10))  begin
	start transaction;
	
	INSERT INTO sis_invcon.fallas_tir
	(id_datostir, ubicacion, falla, opcionfalla, observacion,Posicion)
	VALUES(iddtir, ubicacion, f, op, obser,pos);

if (@@error_count=0) then
	commit;
	else
	rollback;
end if;
commit;
END$$

DROP PROCEDURE IF EXISTS `insert_tir`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_tir` (IN `seriet` CHAR(2), IN `chasis` CHAR(10), IN `tchasis` VARCHAR(5), IN `refrig` VARCHAR(10), IN `tconten` VARCHAR(10), IN `fechat` CHAR(10), IN `horat` CHAR(10), IN `tmov` CHAR(10), IN `naviera` VARCHAR(30), IN `vacio` VARCHAR(10), IN `destino` VARCHAR(30), IN `fizq` BIT, IN `fder` BIT, IN `ffre` BIT, IN `finte` BIT, IN `ftra` BIT, IN `ftec` BIT, IN `fcha` BIT, IN `cli` VARCHAR(100), IN `obser` VARCHAR(200), IN `id_ingre` INT, IN `idf` INT, IN `idusuario` INT)  begin
	start transaction;
		
	INSERT INTO sis_invcon.datostir
		(SerieTir, chassis, tipochassis, refrigeracion, tipocontenedor, fecha, hora, 
		tipomov, Nombre_naviera, vacio, Destino, fallaizq, fallader, fallafre, fallainte, 
		fallatra, fallatec, fallachas, cliente, observaciones, idingreso, id_f, id_usuario, estado)
		VALUES(seriet, chasis, tchasis, refrig, tconten, fechat, horat,
		tmov, naviera, vacio, destino, fizq, fder, ffre, finte,
		ftra, ftec, fcha, cli, obser, id_ingre, idf, idusuario, 'Activo');
	
 if (@@error_count=0) then
	commit;
	select last_insert_id();
	else
	rollback;
end if;
commit;
END$$

DROP PROCEDURE IF EXISTS `listardatosm`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `listardatosm` ()  BEGIN
SELECT a.Id_Ingreso,b.Nombre_de_Piloto,b.Placas,a.No_Contenedor,a.Marchamo,c.Descripcion Bloque,d.noPosicion Posicion,a.producto,a.Barco,a.Destino,a.Estado,a.Bloque idb,a.Posicion idp,a.Id_f from ingreso_maestro a 
            inner join flota_transporte b on a.Id_f=b.Id_f 
            inner join bloque c on a.Bloque=c.id_bloque
            inner join posicion d on a.Posicion=d.idPosicion and a.Bloque=d.idbloque
            WHERE b.Estado=1 and a.Estado in('Ingresado','Anulado');
END$$

DROP PROCEDURE IF EXISTS `listar_asignaciones`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `listar_asignaciones` ()  BEGIN
 SELECT b.Ord, a.Id_a,c.Nombre_de_Piloto,c.Placas,c.Codigo_Piloto_Naviera,b.No_Contenedor,d.Descripcion Bloque,e.noposicion Posicion,b.producto,b.Barco
  from  asignaciones a 
  inner join ingreso_maestro b on a.id=b.Id_Ingreso
  inner join flota_transporte c on a.Id_f=c.Id_f
  INNER JOIN bloque d on a.bloque=d.id_bloque
  inner join posicion e on a.posicion=e.idposicion
  where b.Estado='Ingresado';
END$$

DROP PROCEDURE IF EXISTS `listar_Monitoreo`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `listar_Monitoreo` ()  BEGIN
  select a.Id_m,b.No_Contenedor,a.Hora_De_Monitoreo,a.Producto,a.Set_Point,a.Retorno,d.Descripcion Bloque,b.Posicion,b.Barco,a.Fecha_Del_Monitoreo 
  from monitoreo a 
  inner JOIN ingreso_maestro b on a.Id_m=b.Id_Ingreso
  inner join flota_transporte c on a.Id_f=c.Id_f
  inner join bloque d on b.Bloque = d.id_bloque
  where a.estado='Activo';
END$$

DROP PROCEDURE IF EXISTS `mostrar_asignacion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `mostrar_asignacion` (IN `idasignacion` INT)  begin
	
	select * from sis_invcon.asignaciones where Id_a = idasignacion;
END$$

DROP PROCEDURE IF EXISTS `mostrar_conexiones`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `mostrar_conexiones` ()  BEGIN
  select a.Id,b.No_Contenedor, a.Fecha_Conexion,a.Hora_De_Conexion,a.Setpoint,a.Suministro,a.Retorno,b.Id_Ingreso,c.Cabezal,c.Nombre_de_Piloto from conexion a
  inner join ingreso_maestro b on a.Id_ingreso=b.Id_Ingreso 
  inner join flota_transporte c on a.Id_f=c.Id_f
  where b.Estado='Ingresado' and a.Estado='Activo';
END$$

DROP PROCEDURE IF EXISTS `mostrar_datostir`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `mostrar_datostir` ()  begin
	select im.No_Contenedor,a.chassis,SerieTir,a.fecha,a.hora,ft.Transporte,ft.Nombre_de_Piloto,ft.Placas ,
	a.Destino , a.vacio,a.cliente,a.idtir 
	from sis_invcon.datostir a inner join ingreso_maestro im on a.idingreso = im.Id_Ingreso
	inner join flota_transporte ft on a.id_f = ft.Id_f 
	where a.estado='Activo';
END$$

DROP PROCEDURE IF EXISTS `mostrar_datos_monitoreo`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `mostrar_datos_monitoreo` (IN `idmonitoreo` INT)  BEGIN
  select * from monitoreo where Id_m=idmonitoreo;
END$$

DROP PROCEDURE IF EXISTS `mostrar_dato_conexion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `mostrar_dato_conexion` (IN `idconexion` INT)  BEGIN
  select * from conexion where Id=idconexion;
END$$

DROP PROCEDURE IF EXISTS `mostrar_desconexion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `mostrar_desconexion` ()  BEGIN
  SELECT a.Fecha_De_Desconexion,a.Hora_De_Desconexio,a.totalhoras,b.Id_Ingreso,c.Cabezal,c.Nombre_de_Piloto,
  b.No_Contenedor,a.Id_d,b.Hora_ingreso,b.Fecha_ingreso,b.Descripcion_contenido,d.Id 'idco'
  from desconexion a 
  inner join ingreso_maestro b on a.id=b.Id_Ingreso
  inner join flota_transporte c on a.Id_f=c.Id_f
  inner join conexion d on a.idconexion = d.Id
  where a.estado='Activo' and b.Estado='Ingresado';
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignaciones`
--

DROP TABLE IF EXISTS `asignaciones`;
CREATE TABLE `asignaciones` (
  `Id_a` int(11) NOT NULL,
  `observaciones` varchar(255) DEFAULT NULL,
  `bloque` int(11) DEFAULT NULL,
  `posicion` int(11) DEFAULT NULL,
  `id` int(11) NOT NULL,
  `Id_f` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `asignaciones`
--

INSERT INTO `asignaciones` (`Id_a`, `observaciones`, `bloque`, `posicion`, `id`, `Id_f`, `id_usuario`) VALUES
(1, 'prueba actualizada', 2, 4, 1, 3, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bitacora`
--

DROP TABLE IF EXISTS `bitacora`;
CREATE TABLE `bitacora` (
  `id` int(11) NOT NULL,
  `accion` varchar(20) DEFAULT NULL,
  `fecha` varchar(10) DEFAULT NULL,
  `hora` varchar(10) DEFAULT NULL,
  `usuario` varchar(20) DEFAULT NULL,
  `descripcion` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bloque`
--

DROP TABLE IF EXISTS `bloque`;
CREATE TABLE `bloque` (
  `id_bloque` int(11) NOT NULL,
  `Descripcion` char(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `bloque`
--

INSERT INTO `bloque` (`id_bloque`, `Descripcion`) VALUES
(1, 'C1'),
(2, 'C2'),
(3, 'C3');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `conexion`
--

DROP TABLE IF EXISTS `conexion`;
CREATE TABLE `conexion` (
  `Id` int(11) NOT NULL,
  `Fecha_Conexion` date DEFAULT NULL,
  `Hora_De_Conexion` char(10) DEFAULT NULL,
  `Setpoint` decimal(5,2) DEFAULT NULL,
  `Suministro` decimal(5,2) DEFAULT NULL,
  `Retorno` decimal(5,2) DEFAULT NULL,
  `Id_ingreso` int(11) NOT NULL,
  `Id_f` int(11) NOT NULL,
  `Id_usuario` int(11) NOT NULL,
  `Estado` char(10) DEFAULT NULL,
  `temperatura` char(2) DEFAULT NULL,
  `tipoconexion` varchar(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `conexion`
--

INSERT INTO `conexion` (`Id`, `Fecha_Conexion`, `Hora_De_Conexion`, `Setpoint`, `Suministro`, `Retorno`, `Id_ingreso`, `Id_f`, `Id_usuario`, `Estado`, `temperatura`, `tipoconexion`) VALUES
(1, '2021-04-06', '19:11:43', '3.10', '2.20', '2.10', 4, 1, 1, 'Activo', 'F', 'PP'),
(2, '2021-04-09', '15:20:40', '25.00', '12.00', '3.20', 3, 3, 1, 'Activo', 'F', 'EE');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `datostir`
--

DROP TABLE IF EXISTS `datostir`;
CREATE TABLE `datostir` (
  `idtir` int(11) NOT NULL,
  `SerieTir` char(2) DEFAULT NULL,
  `chassis` varchar(10) DEFAULT NULL,
  `tipochassis` varchar(5) DEFAULT NULL,
  `refrigeracion` varchar(10) DEFAULT NULL,
  `tipocontenedor` varchar(10) DEFAULT NULL,
  `fecha` varchar(10) DEFAULT NULL,
  `hora` varchar(10) DEFAULT NULL,
  `tipomov` varchar(10) DEFAULT NULL,
  `Nombre_naviera` varchar(30) NOT NULL,
  `vacio` varchar(10) DEFAULT NULL,
  `Destino` varchar(30) DEFAULT NULL,
  `fallaizq` bit(1) DEFAULT NULL,
  `fallader` bit(1) DEFAULT NULL,
  `fallafre` bit(1) DEFAULT NULL,
  `fallainte` bit(1) DEFAULT NULL,
  `fallatra` bit(1) DEFAULT NULL,
  `fallatec` bit(1) DEFAULT NULL,
  `fallachas` bit(1) DEFAULT NULL,
  `cliente` varchar(100) DEFAULT NULL,
  `observaciones` varchar(200) DEFAULT NULL,
  `idingreso` int(11) DEFAULT NULL,
  `id_f` int(11) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `estado` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `desconexion`
--

DROP TABLE IF EXISTS `desconexion`;
CREATE TABLE `desconexion` (
  `Id_d` int(11) NOT NULL,
  `Fecha_De_Desconexion` date DEFAULT NULL,
  `Hora_De_Desconexio` char(10) DEFAULT NULL,
  `totalhoras` char(20) DEFAULT NULL,
  `observaciones` varchar(75) DEFAULT NULL,
  `id` int(11) NOT NULL,
  `Id_f` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `estado` char(10) DEFAULT NULL,
  `idconexion` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `desconexion`
--

INSERT INTO `desconexion` (`Id_d`, `Fecha_De_Desconexion`, `Hora_De_Desconexio`, `totalhoras`, `observaciones`, `id`, `Id_f`, `id_usuario`, `estado`, `idconexion`) VALUES
(1, '2021-04-09', '13:51', '66:39', 'prueba', 3, 3, 1, 'Activo', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dfallatir`
--

DROP TABLE IF EXISTS `dfallatir`;
CREATE TABLE `dfallatir` (
  `id` int(11) NOT NULL,
  `utfalla` varchar(10) DEFAULT NULL,
  `falla` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `dfallatir`
--

INSERT INTO `dfallatir` (`id`, `utfalla`, `falla`) VALUES
(1, 'inex', 'SUCIO'),
(2, 'inex', 'MAL OLOR'),
(3, 'inex', 'RAYADURA'),
(4, 'puerta', 'EMPAQUE'),
(5, 'puerta', 'MANIJAS'),
(6, 'puerta', 'VISAGRAS'),
(7, 'chasis', 'LUCES'),
(8, 'chasis', 'PATAS'),
(9, 'chasis', 'FRENOS'),
(10, 'chasis', 'OTROS'),
(11, 'llantas', 'ADELANTE'),
(12, 'llantas', 'ATRAS'),
(13, 'marcham', 'ADELANTE'),
(14, 'marcham', 'ATRAS');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `envios`
--

DROP TABLE IF EXISTS `envios`;
CREATE TABLE `envios` (
  `Id_en` int(11) NOT NULL,
  `No_Envio` int(11) DEFAULT NULL,
  `Fecha_Envio` date DEFAULT NULL,
  `id` int(11) NOT NULL,
  `Id_f` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `exportacion`
--

DROP TABLE IF EXISTS `exportacion`;
CREATE TABLE `exportacion` (
  `Id_e` int(11) NOT NULL,
  `Fecha_de_salida` char(20) DEFAULT NULL,
  `Hora_de_Salida` date DEFAULT NULL,
  `id` int(11) NOT NULL,
  `Id_f` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fallas_tir`
--

DROP TABLE IF EXISTS `fallas_tir`;
CREATE TABLE `fallas_tir` (
  `idfalla_tir` int(11) NOT NULL,
  `id_datostir` int(11) DEFAULT NULL,
  `ubicacion` char(20) DEFAULT NULL,
  `falla` varchar(20) DEFAULT NULL,
  `opcionfalla` bit(1) DEFAULT NULL,
  `Posicion` varchar(10) DEFAULT NULL,
  `observacion` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `flota_transporte`
--

DROP TABLE IF EXISTS `flota_transporte`;
CREATE TABLE `flota_transporte` (
  `Id_f` int(11) NOT NULL,
  `Cabezal` char(20) DEFAULT NULL,
  `Nombre_de_Piloto` char(20) DEFAULT NULL,
  `Licencias` char(20) DEFAULT NULL,
  `Placas` char(20) DEFAULT NULL,
  `Codigo_Piloto_Naviera` char(20) DEFAULT NULL,
  `Naviera` char(20) DEFAULT NULL,
  `Creadopor` char(20) DEFAULT NULL,
  `Estado` int(11) DEFAULT NULL,
  `Fechacreacion` date DEFAULT NULL,
  `Transporte` varchar(20) DEFAULT NULL,
  `Ubicacion` char(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `flota_transporte`
--

INSERT INTO `flota_transporte` (`Id_f`, `Cabezal`, `Nombre_de_Piloto`, `Licencias`, `Placas`, `Codigo_Piloto_Naviera`, `Naviera`, `Creadopor`, `Estado`, `Fechacreacion`, `Transporte`, `Ubicacion`) VALUES
(1, '122C', 'CRISTIAN ERNESTO GAR', '1928 08990 1804', 'C018BQH', '31748', 'MAERSK', 'Administrador', 1, '2021-03-30', 'MARK', 'PUERTO'),
(2, '117C', 'RONY DE JESUS HERRER', '2283 20143 1801', 'C007BQH', '30232', 'MAERSK', 'Administrador', 1, '2021-03-30', 'MARK', 'PUERTO'),
(3, 'C6', 'MARIO ESTUARDO MORAL', '2635 62298 1801', 'C899BPK', '40893', 'CHIQUITA', 'Administrador', 1, '2021-03-30', 'MARK', 'PUERTO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingreso_maestro`
--

DROP TABLE IF EXISTS `ingreso_maestro`;
CREATE TABLE `ingreso_maestro` (
  `Id_Ingreso` int(11) NOT NULL,
  `Fecha_ingreso` date DEFAULT NULL,
  `Hora_ingreso` char(20) DEFAULT NULL,
  `No_Contenedor` char(20) DEFAULT NULL,
  `Barco` varchar(50) DEFAULT NULL,
  `Tipo_Contenido` char(20) DEFAULT NULL,
  `Descripcion_contenido` varchar(50) DEFAULT NULL,
  `Detalle_Servicio` varchar(20) DEFAULT NULL,
  `Marchamo` char(20) DEFAULT NULL,
  `Hora_TIR` char(10) DEFAULT NULL,
  `Serie_TIR` char(5) DEFAULT NULL,
  `producto` varchar(30) DEFAULT NULL,
  `Ord` int(11) DEFAULT NULL,
  `Bloque` char(20) DEFAULT NULL,
  `Posicion` int(11) DEFAULT NULL,
  `Observaciones` char(20) DEFAULT NULL,
  `Destino` char(20) DEFAULT NULL,
  `Fecha_Asignacion` date DEFAULT NULL,
  `Estado` char(20) DEFAULT NULL,
  `Id_f` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `ingreso_maestro`
--

INSERT INTO `ingreso_maestro` (`Id_Ingreso`, `Fecha_ingreso`, `Hora_ingreso`, `No_Contenedor`, `Barco`, `Tipo_Contenido`, `Descripcion_contenido`, `Detalle_Servicio`, `Marchamo`, `Hora_TIR`, `Serie_TIR`, `producto`, `Ord`, `Bloque`, `Posicion`, `Observaciones`, `Destino`, `Fecha_Asignacion`, `Estado`, `Id_f`, `id_usuario`) VALUES
(1, '2021-03-31', '21:09:17', 'TEMU9080595', 'STARD STANDARD V49', 'VACIO', 'VACIO RF', 'VACIO', 'ALOPSA5490', '21:09:17', 'A', 'BANANO', 438, '2', 4, '0890021297/900020873', 'FINCAS', '2021-03-31', 'Ingresado', 3, 1),
(2, '2021-04-01', '21:10:27', 'TEMU9080595', 'STARD STANDARD V49', 'VACIO', 'VACIO RF', 'VACIO', 'ALOPSA5490', '21:10:27', 'A', 'BANANO', 43, '1', 2, 'prueba de ingreso', 'FINCAS', '2021-04-01', 'Anulado', 1, 1),
(3, '2021-04-06', '18:00:37', 'TEMU9488308', 'STARD STANDARD V49', 'VACIO', 'VACIO RF', 'VACIO', 'ALOPSA5483', '18:00:37', 'A', 'SIN PRODUCTO', 9751, '2', 5, 'DESPACHO A FINCAS 2', 'FINCAS', '2021-04-06', 'Ingresado', 3, 1),
(4, '2021-04-09', '14:59:13', 'TEMU9501349', 'STARD STANDARD V49', 'VACIO', 'VACIO RF', 'VACIO', 'ALOPSA5495', '14:59:13', 'A', 'BANANO', 11, '2', 6, 'DESPACHO A FINCAS', 'FINCAS', '2021-04-09', 'Ingresado', 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `monitoreo`
--

DROP TABLE IF EXISTS `monitoreo`;
CREATE TABLE `monitoreo` (
  `Id_m` int(11) NOT NULL,
  `Hora_De_Monitoreo` char(10) DEFAULT NULL,
  `Retorno` decimal(5,2) DEFAULT NULL,
  `Observaciones` varchar(50) DEFAULT NULL,
  `Producto` char(20) DEFAULT NULL,
  `Set_Point` decimal(5,2) DEFAULT NULL,
  `Suministro` decimal(5,2) DEFAULT NULL,
  `Fecha_Del_Monitoreo` char(20) DEFAULT NULL,
  `Nombre_Del_Mecanico` char(20) DEFAULT NULL,
  `id_ingreso` int(11) NOT NULL,
  `Id_f` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `estado` varchar(10) DEFAULT NULL,
  `temperatura` char(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `monitoreo`
--

INSERT INTO `monitoreo` (`Id_m`, `Hora_De_Monitoreo`, `Retorno`, `Observaciones`, `Producto`, `Set_Point`, `Suministro`, `Fecha_Del_Monitoreo`, `Nombre_Del_Mecanico`, `id_ingreso`, `Id_f`, `id_usuario`, `estado`, `temperatura`) VALUES
(1, '22:42:02', '0.00', 'pruebas', 'BANANO', '23.00', '0.00', '2021-04-01', 'LUIS CAMBRAN', 1, 2, 1, 'Activo', 'F'),
(2, '15:16:12', '3.20', 'Prueba de ingreso', 'SIN PRODUCTO', '12.00', '1.00', '2021-04-09', 'CARLOS LOPEZ', 3, 3, 1, 'Activo', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movimientos`
--

DROP TABLE IF EXISTS `movimientos`;
CREATE TABLE `movimientos` (
  `Id_Movimientos` int(11) NOT NULL,
  `Semana` char(20) DEFAULT NULL,
  `Año` char(20) DEFAULT NULL,
  `Hora_Movimiento` char(10) DEFAULT NULL,
  `Fecha_Movimeinto` char(20) DEFAULT NULL,
  `Medida` char(20) DEFAULT NULL,
  `No_Contenedor` char(20) DEFAULT NULL,
  `Ingreso_Movimiento` char(10) DEFAULT NULL,
  `Cliente` char(20) DEFAULT NULL,
  `Actividad` char(20) DEFAULT NULL,
  `Motivo` char(20) DEFAULT NULL,
  `Despacho_Movimeinto` char(20) DEFAULT NULL,
  `Importacion` char(20) DEFAULT NULL,
  `Exportacion` char(20) DEFAULT NULL,
  `Adicionales` char(20) DEFAULT NULL,
  `Movimiento_Interno` char(20) DEFAULT NULL,
  `Observaciones` varchar(75) DEFAULT NULL,
  `Fecha_Movimiento` date DEFAULT NULL,
  `Horario_Turno` char(20) DEFAULT NULL,
  `Kalmar_No` char(20) DEFAULT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permiso`
--

DROP TABLE IF EXISTS `permiso`;
CREATE TABLE `permiso` (
  `idpermiso` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL
) ENGINE=InnoDB AVG_ROW_LENGTH=5461 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `permiso`
--

INSERT INTO `permiso` (`idpermiso`, `nombre`) VALUES
(1, 'dashboard'),
(2, 'acceso'),
(3, 'reportes'),
(4, 'Ingresoc'),
(5, 'Datosm'),
(6, 'ingresov'),
(7, 'ingresomov');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `posicion`
--

DROP TABLE IF EXISTS `posicion`;
CREATE TABLE `posicion` (
  `idposicion` int(11) NOT NULL,
  `noposicion` int(11) DEFAULT NULL,
  `estado` char(20) DEFAULT NULL,
  `idbloque` int(11) DEFAULT NULL,
  `id_ingreso` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `posicion`
--

INSERT INTO `posicion` (`idposicion`, `noposicion`, `estado`, `idbloque`, `id_ingreso`) VALUES
(1, 1, 'Sin Asignar', 1, 0),
(2, 2, 'Sin Asignar', 1, 0),
(3, 3, 'Sin Asignar', 1, 0),
(4, 1, 'Asignado', 2, 1),
(5, 2, 'Asignado', 2, 3),
(6, 3, 'Asignado', 2, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

DROP TABLE IF EXISTS `rol`;
CREATE TABLE `rol` (
  `id_rol` int(11) NOT NULL,
  `descripcion` char(20) DEFAULT NULL
) ENGINE=InnoDB AVG_ROW_LENGTH=8192 DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`id_rol`, `descripcion`) VALUES
(1, 'Admin'),
(2, 'Usuario'),
(3, 'Supervisor');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tamaniochasis`
--

DROP TABLE IF EXISTS `tamaniochasis`;
CREATE TABLE `tamaniochasis` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tamaniochasis`
--

INSERT INTO `tamaniochasis` (`id`, `descripcion`) VALUES
(1, '20\''),
(2, '40\''),
(3, '40\' - 45\''),
(4, '45\'');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipocontenedor`
--

DROP TABLE IF EXISTS `tipocontenedor`;
CREATE TABLE `tipocontenedor` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tipocontenedor`
--

INSERT INTO `tipocontenedor` (`id`, `descripcion`) VALUES
(1, '20 STD'),
(2, '40 STD'),
(3, '40 HC'),
(4, '45 HC'),
(5, 'FLAT RACK'),
(6, 'OPEN TOP'),
(7, 'ISO TANK');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombre_usuario` char(20) DEFAULT NULL,
  `usuario` char(20) DEFAULT NULL,
  `clave` varchar(250) DEFAULT NULL,
  `condicion` int(11) DEFAULT NULL,
  `id_rol` int(11) DEFAULT NULL,
  `imagen` varchar(50) DEFAULT NULL,
  `email` varchar(75) DEFAULT NULL,
  `departamento` varchar(50) DEFAULT NULL,
  `empresa` varchar(75) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre_usuario`, `usuario`, `clave`, `condicion`, `id_rol`, `imagen`, `email`, `departamento`, `empresa`) VALUES
(1, 'Administrador', 'admin', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', 1, 1, '1614482617.png', 'sorporte@interport.com.gt', 'Informatica', 'ALOPSA'),
(2, 'Luis Cambran', 'lcambran', '908ac8d4a9cbab02e53685ca15fbaf46f63a06e2215257272d005da14858764c', 1, 3, '1617246834.png', 'luis@cambrantech.com', 'Informatica', 'ALOPSA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_permiso`
--

DROP TABLE IF EXISTS `usuario_permiso`;
CREATE TABLE `usuario_permiso` (
  `idusuario_permiso` int(11) NOT NULL,
  `idusuario` int(11) NOT NULL,
  `idpermiso` int(11) NOT NULL
) ENGINE=InnoDB AVG_ROW_LENGTH=1820 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuario_permiso`
--

INSERT INTO `usuario_permiso` (`idusuario_permiso`, `idusuario`, `idpermiso`) VALUES
(14, 1, 1),
(15, 1, 2),
(16, 1, 4),
(17, 1, 5),
(18, 1, 7),
(19, 2, 1),
(20, 2, 2),
(21, 2, 5),
(22, 2, 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vacios_despachos`
--

DROP TABLE IF EXISTS `vacios_despachos`;
CREATE TABLE `vacios_despachos` (
  `Id_vd` int(11) NOT NULL,
  `Fecha_Despacho` char(20) DEFAULT NULL,
  `Hora_De_Despacho` char(20) DEFAULT NULL,
  `Marchamo` char(20) DEFAULT NULL,
  `Digitador` char(20) DEFAULT NULL,
  `Id_f` int(11) NOT NULL,
  `Id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vacios_flota`
--

DROP TABLE IF EXISTS `vacios_flota`;
CREATE TABLE `vacios_flota` (
  `Id` int(11) NOT NULL,
  `Cabezal` char(20) DEFAULT NULL,
  `Codigo_Cabezal` char(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vacios_ingresos`
--

DROP TABLE IF EXISTS `vacios_ingresos`;
CREATE TABLE `vacios_ingresos` (
  `Id` int(11) NOT NULL,
  `Fecha_Ingreso` date DEFAULT NULL,
  `Hora_De_Ingreso` datetime DEFAULT NULL,
  `SZ` char(20) DEFAULT NULL,
  `Dry_Reefer` char(20) DEFAULT NULL,
  `Clasificacion` char(20) DEFAULT NULL,
  `Contenido` char(20) DEFAULT NULL,
  `Procedencia` char(20) DEFAULT NULL,
  `TIR` char(20) DEFAULT NULL,
  `HR_TIR` char(20) DEFAULT NULL,
  `Transporte` char(20) DEFAULT NULL,
  `Ubicacion` char(20) DEFAULT NULL,
  `Estatus` char(20) DEFAULT NULL,
  `Predio_From` char(20) DEFAULT NULL,
  `Fecha` date DEFAULT NULL,
  `Sello_Export` char(20) DEFAULT NULL,
  `Sello_Alopsa` char(20) DEFAULT NULL,
  `Buque` char(20) DEFAULT NULL,
  `ETA` char(20) DEFAULT NULL,
  `Booking` char(20) DEFAULT NULL,
  `Cliente` char(20) DEFAULT NULL,
  `Producto` char(20) DEFAULT NULL,
  `No_De_ATC` char(20) DEFAULT NULL,
  `Peso_Tara` char(20) DEFAULT NULL,
  `Fecha_Emision` char(20) DEFAULT NULL,
  `Fecha_Vencimiento` char(20) DEFAULT NULL,
  `Fecha_Actual` char(20) DEFAULT NULL,
  `Dias_Estadia` char(20) DEFAULT NULL,
  `Problemas_ATC` char(20) DEFAULT NULL,
  `Forecast` char(20) DEFAULT NULL,
  `Chatarra` char(20) DEFAULT NULL,
  `Daños` char(20) DEFAULT NULL,
  `Año_De_Fabricacion` date DEFAULT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `asignaciones`
--
ALTER TABLE `asignaciones`
  ADD PRIMARY KEY (`Id_a`,`id`,`Id_f`,`id_usuario`),
  ADD KEY `ingreso_m_asignaciones` (`id`,`Id_f`,`id_usuario`);

--
-- Indices de la tabla `bitacora`
--
ALTER TABLE `bitacora`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bitacora_id_IDX` (`id`) USING BTREE;

--
-- Indices de la tabla `bloque`
--
ALTER TABLE `bloque`
  ADD PRIMARY KEY (`id_bloque`);

--
-- Indices de la tabla `conexion`
--
ALTER TABLE `conexion`
  ADD PRIMARY KEY (`Id`,`Id_ingreso`,`Id_f`,`Id_usuario`),
  ADD KEY `ingreso_m_conexion` (`Id_ingreso`,`Id_usuario`);

--
-- Indices de la tabla `datostir`
--
ALTER TABLE `datostir`
  ADD PRIMARY KEY (`idtir`),
  ADD KEY `datortir_FK` (`idingreso`,`id_f`,`id_usuario`),
  ADD KEY `datortir_idtir_IDX` (`idtir`) USING BTREE;

--
-- Indices de la tabla `desconexion`
--
ALTER TABLE `desconexion`
  ADD PRIMARY KEY (`Id_d`,`id`,`Id_f`,`id_usuario`),
  ADD KEY `ingreso_m_desconexion` (`id`,`Id_f`,`id_usuario`);

--
-- Indices de la tabla `dfallatir`
--
ALTER TABLE `dfallatir`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `envios`
--
ALTER TABLE `envios`
  ADD PRIMARY KEY (`Id_en`,`id`,`Id_f`,`id_usuario`),
  ADD KEY `ingreso_m_envio` (`id`,`Id_f`,`id_usuario`);

--
-- Indices de la tabla `exportacion`
--
ALTER TABLE `exportacion`
  ADD PRIMARY KEY (`Id_e`,`id`,`Id_f`,`id_usuario`),
  ADD KEY `ingreso_m_export` (`id`,`Id_f`,`id_usuario`);

--
-- Indices de la tabla `fallas_tir`
--
ALTER TABLE `fallas_tir`
  ADD PRIMARY KEY (`idfalla_tir`),
  ADD KEY `Fallas_TIR_FK` (`id_datostir`);

--
-- Indices de la tabla `flota_transporte`
--
ALTER TABLE `flota_transporte`
  ADD PRIMARY KEY (`Id_f`);

--
-- Indices de la tabla `ingreso_maestro`
--
ALTER TABLE `ingreso_maestro`
  ADD PRIMARY KEY (`Id_Ingreso`,`Id_f`,`id_usuario`),
  ADD UNIQUE KEY `UK_ingreso_maestro` (`Id_Ingreso`,`id_usuario`),
  ADD KEY `flota_ingreso_m` (`Id_f`),
  ADD KEY `usuario_maestro` (`id_usuario`);

--
-- Indices de la tabla `monitoreo`
--
ALTER TABLE `monitoreo`
  ADD PRIMARY KEY (`Id_m`,`id_ingreso`,`Id_f`,`id_usuario`),
  ADD KEY `ingreso_m_monitoreo` (`id_ingreso`,`id_usuario`);

--
-- Indices de la tabla `movimientos`
--
ALTER TABLE `movimientos`
  ADD PRIMARY KEY (`Id_Movimientos`,`id_usuario`),
  ADD KEY `mov_usuario` (`id_usuario`);

--
-- Indices de la tabla `permiso`
--
ALTER TABLE `permiso`
  ADD PRIMARY KEY (`idpermiso`);

--
-- Indices de la tabla `posicion`
--
ALTER TABLE `posicion`
  ADD PRIMARY KEY (`idposicion`),
  ADD KEY `FK_posicion_idbloque` (`idbloque`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id_rol`);

--
-- Indices de la tabla `tamaniochasis`
--
ALTER TABLE `tamaniochasis`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipocontenedor`
--
ALTER TABLE `tipocontenedor`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD KEY `usuario_rol` (`id_rol`);

--
-- Indices de la tabla `usuario_permiso`
--
ALTER TABLE `usuario_permiso`
  ADD PRIMARY KEY (`idusuario_permiso`),
  ADD KEY `fk_u_permiso_usuario_idx` (`idusuario`),
  ADD KEY `fk_usuario_permiso_idx` (`idpermiso`);

--
-- Indices de la tabla `vacios_despachos`
--
ALTER TABLE `vacios_despachos`
  ADD PRIMARY KEY (`Id_vd`),
  ADD KEY `flota_vacio_d` (`Id_f`),
  ADD KEY `vacios_ingreso_despacho_v` (`Id`,`id_usuario`);

--
-- Indices de la tabla `vacios_flota`
--
ALTER TABLE `vacios_flota`
  ADD PRIMARY KEY (`Id`);

--
-- Indices de la tabla `vacios_ingresos`
--
ALTER TABLE `vacios_ingresos`
  ADD PRIMARY KEY (`Id`,`id_usuario`),
  ADD KEY `usuario_vacio_ingreso` (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `asignaciones`
--
ALTER TABLE `asignaciones`
  MODIFY `Id_a` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `bitacora`
--
ALTER TABLE `bitacora`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `bloque`
--
ALTER TABLE `bloque`
  MODIFY `id_bloque` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `conexion`
--
ALTER TABLE `conexion`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `datostir`
--
ALTER TABLE `datostir`
  MODIFY `idtir` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `desconexion`
--
ALTER TABLE `desconexion`
  MODIFY `Id_d` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `dfallatir`
--
ALTER TABLE `dfallatir`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `envios`
--
ALTER TABLE `envios`
  MODIFY `Id_en` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `exportacion`
--
ALTER TABLE `exportacion`
  MODIFY `Id_e` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `fallas_tir`
--
ALTER TABLE `fallas_tir`
  MODIFY `idfalla_tir` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `flota_transporte`
--
ALTER TABLE `flota_transporte`
  MODIFY `Id_f` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `ingreso_maestro`
--
ALTER TABLE `ingreso_maestro`
  MODIFY `Id_Ingreso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `monitoreo`
--
ALTER TABLE `monitoreo`
  MODIFY `Id_m` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `movimientos`
--
ALTER TABLE `movimientos`
  MODIFY `Id_Movimientos` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `permiso`
--
ALTER TABLE `permiso`
  MODIFY `idpermiso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `posicion`
--
ALTER TABLE `posicion`
  MODIFY `idposicion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tamaniochasis`
--
ALTER TABLE `tamaniochasis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tipocontenedor`
--
ALTER TABLE `tipocontenedor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuario_permiso`
--
ALTER TABLE `usuario_permiso`
  MODIFY `idusuario_permiso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `vacios_despachos`
--
ALTER TABLE `vacios_despachos`
  MODIFY `Id_vd` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `vacios_flota`
--
ALTER TABLE `vacios_flota`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `vacios_ingresos`
--
ALTER TABLE `vacios_ingresos`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `asignaciones`
--
ALTER TABLE `asignaciones`
  ADD CONSTRAINT `ingreso_m_asignaciones` FOREIGN KEY (`id`,`Id_f`,`id_usuario`) REFERENCES `ingreso_maestro` (`Id_Ingreso`, `Id_f`, `id_usuario`);

--
-- Filtros para la tabla `conexion`
--
ALTER TABLE `conexion`
  ADD CONSTRAINT `ingreso_m_conexion` FOREIGN KEY (`Id_ingreso`,`Id_usuario`) REFERENCES `ingreso_maestro` (`Id_Ingreso`, `id_usuario`);

--
-- Filtros para la tabla `datostir`
--
ALTER TABLE `datostir`
  ADD CONSTRAINT `datortir_FK` FOREIGN KEY (`idingreso`,`id_f`,`id_usuario`) REFERENCES `ingreso_maestro` (`Id_Ingreso`, `Id_f`, `id_usuario`);

--
-- Filtros para la tabla `desconexion`
--
ALTER TABLE `desconexion`
  ADD CONSTRAINT `ingreso_m_desconexion` FOREIGN KEY (`id`,`Id_f`,`id_usuario`) REFERENCES `ingreso_maestro` (`Id_Ingreso`, `Id_f`, `id_usuario`);

--
-- Filtros para la tabla `envios`
--
ALTER TABLE `envios`
  ADD CONSTRAINT `ingreso_m_envio` FOREIGN KEY (`id`,`Id_f`,`id_usuario`) REFERENCES `ingreso_maestro` (`Id_Ingreso`, `Id_f`, `id_usuario`);

--
-- Filtros para la tabla `exportacion`
--
ALTER TABLE `exportacion`
  ADD CONSTRAINT `ingreso_m_export` FOREIGN KEY (`id`,`Id_f`,`id_usuario`) REFERENCES `ingreso_maestro` (`Id_Ingreso`, `Id_f`, `id_usuario`);

--
-- Filtros para la tabla `fallas_tir`
--
ALTER TABLE `fallas_tir`
  ADD CONSTRAINT `Fallas_TIR_FK` FOREIGN KEY (`id_datostir`) REFERENCES `datostir` (`idtir`);

--
-- Filtros para la tabla `ingreso_maestro`
--
ALTER TABLE `ingreso_maestro`
  ADD CONSTRAINT `flota_ingreso_m` FOREIGN KEY (`Id_f`) REFERENCES `flota_transporte` (`Id_f`),
  ADD CONSTRAINT `usuario_maestro` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `monitoreo`
--
ALTER TABLE `monitoreo`
  ADD CONSTRAINT `ingreso_m_monitoreo` FOREIGN KEY (`id_ingreso`,`id_usuario`) REFERENCES `ingreso_maestro` (`Id_Ingreso`, `id_usuario`);

--
-- Filtros para la tabla `movimientos`
--
ALTER TABLE `movimientos`
  ADD CONSTRAINT `mov_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `posicion`
--
ALTER TABLE `posicion`
  ADD CONSTRAINT `FK_posicion_idbloque` FOREIGN KEY (`idbloque`) REFERENCES `bloque` (`id_bloque`) ON DELETE NO ACTION;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuario_rol` FOREIGN KEY (`id_rol`) REFERENCES `rol` (`id_rol`);

--
-- Filtros para la tabla `usuario_permiso`
--
ALTER TABLE `usuario_permiso`
  ADD CONSTRAINT `fk_u_permiso_usuario` FOREIGN KEY (`idusuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_usuario_permiso` FOREIGN KEY (`idpermiso`) REFERENCES `permiso` (`idpermiso`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `vacios_despachos`
--
ALTER TABLE `vacios_despachos`
  ADD CONSTRAINT `flota_vacio_d` FOREIGN KEY (`Id_f`) REFERENCES `flota_transporte` (`Id_f`),
  ADD CONSTRAINT `vacios_ingreso_despacho_v` FOREIGN KEY (`Id`,`id_usuario`) REFERENCES `vacios_ingresos` (`Id`, `id_usuario`);

--
-- Filtros para la tabla `vacios_ingresos`
--
ALTER TABLE `vacios_ingresos`
  ADD CONSTRAINT `usuario_vacio_ingreso` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
