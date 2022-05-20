-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         10.4.22-MariaDB - mariadb.org binary distribution
-- SO del servidor:              Win64
-- HeidiSQL Versión:             10.1.0.5464
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Volcando estructura de base de datos para db_escuela
CREATE DATABASE IF NOT EXISTS `db_escuela` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `db_escuela`;

-- Volcando estructura para tabla db_escuela.alumnos
CREATE TABLE IF NOT EXISTS `alumnos` (
  `alumno_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  `cnumlegajo_alumno` varchar(20) DEFAULT NULL,
  `cestado_legajo` varchar(50) NOT NULL,
  `nsituacion_alumno` int(1) unsigned NOT NULL DEFAULT 1 COMMENT '1 - activo \r\n2 - inactivo',
  `cobservaciones_alumno` varchar(255) NOT NULL,
  `balumno_regular` int(1) unsigned NOT NULL DEFAULT 1,
  `rela_estadoalumno_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  `rela_persona_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  `rela_persona_id_tutor1` bigint(20) unsigned NOT NULL DEFAULT 0,
  `rela_persona_id_tutor2` bigint(20) unsigned NOT NULL DEFAULT 0,
  `rela_persona_id_tutor3` bigint(20) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`alumno_id`),
  KEY `rela_estadoalumno_id` (`rela_estadoalumno_id`),
  KEY `rela_persona_id` (`rela_persona_id`),
  KEY `rela_persona_id_tutor1` (`rela_persona_id_tutor1`),
  KEY `rela_persona_id_tutor2` (`rela_persona_id_tutor2`),
  KEY `rela_persona_id_tutor3` (`rela_persona_id_tutor3`),
  CONSTRAINT `FK_alumnos_estado_alumnos` FOREIGN KEY (`rela_estadoalumno_id`) REFERENCES `estado_alumnos` (`estadoalumno_id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_alumnos_personas` FOREIGN KEY (`rela_persona_id`) REFERENCES `personas` (`persona_id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_alumnos_personas_2` FOREIGN KEY (`rela_persona_id_tutor1`) REFERENCES `personas` (`persona_id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_alumnos_personas_3` FOREIGN KEY (`rela_persona_id_tutor2`) REFERENCES `personas` (`persona_id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Almacena informacion sobre los Alumnos de la escuela';

-- Volcando datos para la tabla db_escuela.alumnos: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `alumnos` DISABLE KEYS */;
INSERT INTO `alumnos` (`alumno_id`, `cnumlegajo_alumno`, `cestado_legajo`, `nsituacion_alumno`, `cobservaciones_alumno`, `balumno_regular`, `rela_estadoalumno_id`, `rela_persona_id`, `rela_persona_id_tutor1`, `rela_persona_id_tutor2`, `rela_persona_id_tutor3`) VALUES
	(1, '0987', '0', 1, '', 1, 1, 1, 1, 1, 0),
	(2, '763', '', 1, '', 1, 2, 7, 1, 3, 0);
/*!40000 ALTER TABLE `alumnos` ENABLE KEYS */;

-- Volcando estructura para tabla db_escuela.anos_lectivos
CREATE TABLE IF NOT EXISTS `anos_lectivos` (
  `anolectivo_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  `ndescripcion_anolectivo` int(4) NOT NULL DEFAULT 0,
  `dfechainicio_anolectivo` date NOT NULL,
  `dfechafinclases_anolectivo` date NOT NULL,
  `dfechafin_anolectivo` date NOT NULL,
  `bactivo_anolectivo` int(1) unsigned NOT NULL,
  PRIMARY KEY (`anolectivo_id`) USING BTREE,
  KEY `cdescripcion_anolectivo` (`ndescripcion_anolectivo`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC COMMENT='Almacena Informacion sobre los Años Lectivos';

-- Volcando datos para la tabla db_escuela.anos_lectivos: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `anos_lectivos` DISABLE KEYS */;
INSERT INTO `anos_lectivos` (`anolectivo_id`, `ndescripcion_anolectivo`, `dfechainicio_anolectivo`, `dfechafinclases_anolectivo`, `dfechafin_anolectivo`, `bactivo_anolectivo`) VALUES
	(1, 2020, '2020-03-11', '2020-12-11', '2020-08-19', 1),
	(2, 2021, '2020-03-02', '2020-12-11', '2020-12-22', 1);
/*!40000 ALTER TABLE `anos_lectivos` ENABLE KEYS */;

-- Volcando estructura para tabla db_escuela.barrios
CREATE TABLE IF NOT EXISTS `barrios` (
  `barrio_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `cnombre_barrio` varchar(50) NOT NULL,
  PRIMARY KEY (`barrio_id`),
  KEY `nombre_barrio` (`cnombre_barrio`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COMMENT='Almacena Informacion sobre los Barrios de una localidad';

-- Volcando datos para la tabla db_escuela.barrios: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `barrios` DISABLE KEYS */;
INSERT INTO `barrios` (`barrio_id`, `cnombre_barrio`) VALUES
	(1, 'B° El Palomar'),
	(2, 'Simon bolivar');
/*!40000 ALTER TABLE `barrios` ENABLE KEYS */;

-- Volcando estructura para tabla db_escuela.calendario
CREATE TABLE IF NOT EXISTS `calendario` (
  `calendario_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `dfecha_calendario` date NOT NULL,
  `cdescripcion_calendario` varchar(100) NOT NULL,
  `rela_anolectivo_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`calendario_id`),
  KEY `rela_anolectivo_id` (`rela_anolectivo_id`),
  KEY `dfecha_calendario` (`dfecha_calendario`),
  CONSTRAINT `FK__anos_lectivos` FOREIGN KEY (`rela_anolectivo_id`) REFERENCES `anos_lectivos` (`anolectivo_id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Almacena infromacion sobre el calendario del año lectivo';

-- Volcando datos para la tabla db_escuela.calendario: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `calendario` DISABLE KEYS */;
/*!40000 ALTER TABLE `calendario` ENABLE KEYS */;

-- Volcando estructura para tabla db_escuela.calles
CREATE TABLE IF NOT EXISTS `calles` (
  `calle_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `cnombre_calle` varchar(50) NOT NULL,
  PRIMARY KEY (`calle_id`),
  KEY `nombre_calle` (`cnombre_calle`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COMMENT='Almacena Informacion sobre las calles';

-- Volcando datos para la tabla db_escuela.calles: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `calles` DISABLE KEYS */;
INSERT INTO `calles` (`calle_id`, `cnombre_calle`) VALUES
	(2, 'Av. Maradona 1200'),
	(1, 'Juan José Paso');
/*!40000 ALTER TABLE `calles` ENABLE KEYS */;

-- Volcando estructura para tabla db_escuela.cargos
CREATE TABLE IF NOT EXISTS `cargos` (
  `cargol_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `cdescripcion_cargo` varchar(50) NOT NULL,
  PRIMARY KEY (`cargol_id`) USING BTREE,
  KEY `cdescripcion_cargo` (`cdescripcion_cargo`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC COMMENT='almacena inform acion sobre los cargos del personal';

-- Volcando datos para la tabla db_escuela.cargos: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `cargos` DISABLE KEYS */;
INSERT INTO `cargos` (`cargol_id`, `cdescripcion_cargo`) VALUES
	(1, 'administrativo');
/*!40000 ALTER TABLE `cargos` ENABLE KEYS */;

-- Volcando estructura para tabla db_escuela.carreras
CREATE TABLE IF NOT EXISTS `carreras` (
  `carrera_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `cdescripcion_carrera` varchar(50) NOT NULL,
  `netapastemporales_carrera` int(1) unsigned DEFAULT 1 COMMENT 'cantidad de etapas del año escolar',
  `cdescripcionetapatemporal_carrera` varchar(50) NOT NULL COMMENT 'descripcion de la etapa . Ej: TRIMESTRE.',
  PRIMARY KEY (`carrera_id`) USING BTREE,
  KEY `cdescripcion_ciclolectivo` (`cdescripcion_carrera`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC COMMENT='Almacena Informacion sobre las carreras que se dictan en la institucion';

-- Volcando datos para la tabla db_escuela.carreras: ~4 rows (aproximadamente)
/*!40000 ALTER TABLE `carreras` DISABLE KEYS */;
INSERT INTO `carreras` (`carrera_id`, `cdescripcion_carrera`, `netapastemporales_carrera`, `cdescripcionetapatemporal_carrera`) VALUES
	(1, 'CBT', 3, 'Ciclo Básico Técnico'),
	(2, 'Informática', 4, 'Informática'),
	(3, 'Programación', 4, 'Programación'),
	(4, 'Mecánica', 4, 'Mecánica automotriz');
/*!40000 ALTER TABLE `carreras` ENABLE KEYS */;

-- Volcando estructura para tabla db_escuela.cursos
CREATE TABLE IF NOT EXISTS `cursos` (
  `curso_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `cdescripcion_curso` varchar(50) NOT NULL,
  `rela_carrera_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`curso_id`) USING BTREE,
  KEY `cdescripcion_curso` (`cdescripcion_curso`) USING BTREE,
  KEY `rela_carrera_id` (`rela_carrera_id`),
  CONSTRAINT `FK_cursos_carreras` FOREIGN KEY (`rela_carrera_id`) REFERENCES `carreras` (`carrera_id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC COMMENT='Almacena Informacion sobre las cursos que se encuentan en la institucion';

-- Volcando datos para la tabla db_escuela.cursos: ~22 rows (aproximadamente)
/*!40000 ALTER TABLE `cursos` DISABLE KEYS */;
INSERT INTO `cursos` (`curso_id`, `cdescripcion_curso`, `rela_carrera_id`) VALUES
	(1, '1 I', 1),
	(2, '1 II', 1),
	(3, '2 I', 1),
	(4, '2 II', 1),
	(5, '3 I', 1),
	(6, '3 II', 1),
	(7, '4 I', 2),
	(8, '4 II', 2),
	(9, '4 III', 4),
	(10, '4 IV', 3),
	(11, '5 I', 2),
	(12, '5 II', 2),
	(13, '5 III', 4),
	(14, '5 IV', 3),
	(15, '6 I', 2),
	(16, '6 II', 2),
	(17, '6 III', 4),
	(18, '6 IV', 3),
	(19, '7 I', 2),
	(20, '7 II', 2),
	(21, '7 III', 4),
	(22, '7 IV', 3);
/*!40000 ALTER TABLE `cursos` ENABLE KEYS */;

-- Volcando estructura para tabla db_escuela.cursos_horarios
CREATE TABLE IF NOT EXISTS `cursos_horarios` (
  `cursoshorarios_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `cdescripcion_cursohorario` varchar(50) NOT NULL,
  `cdias_horario` varchar(7) NOT NULL DEFAULT '0000000',
  `rela_curso_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  `rela_trayecto_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  `rela_preceptor_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  `bhorario_activo` int(1) unsigned NOT NULL COMMENT '1 - activo',
  PRIMARY KEY (`cursoshorarios_id`),
  KEY `rela_curso_id` (`rela_curso_id`),
  KEY `rela_trayecto_id` (`rela_trayecto_id`),
  KEY `rela_peceptor_id` (`rela_preceptor_id`) USING BTREE,
  CONSTRAINT `FK_cursos_horarios_cursos` FOREIGN KEY (`rela_curso_id`) REFERENCES `cursos` (`curso_id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_cursos_horarios_preceptores` FOREIGN KEY (`rela_preceptor_id`) REFERENCES `preceptores` (`preceptor_id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_cursos_horarios_trayectos` FOREIGN KEY (`rela_trayecto_id`) REFERENCES `trayectos` (`trayecto_id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COMMENT='Almacena informacion sobre los horarios de los cursos';

-- Volcando datos para la tabla db_escuela.cursos_horarios: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `cursos_horarios` DISABLE KEYS */;
INSERT INTO `cursos_horarios` (`cursoshorarios_id`, `cdescripcion_cursohorario`, `cdias_horario`, `rela_curso_id`, `rela_trayecto_id`, `rela_preceptor_id`, `bhorario_activo`) VALUES
	(1, 'fcvgbh', 'Martes', 1, 1, 1, 1),
	(2, 'gvhb', 'Jueves', 2, 2, 1, 1);
/*!40000 ALTER TABLE `cursos_horarios` ENABLE KEYS */;

-- Volcando estructura para tabla db_escuela.cursos_horarios_materias
CREATE TABLE IF NOT EXISTS `cursos_horarios_materias` (
  `cursoshorariosmaterias_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ndia_cursohorariomateria` int(1) unsigned NOT NULL DEFAULT 1 COMMENT '1 - lunes \r\n2 - martes \r\n3 - miercoles \r\n4 -jueves \r\n5 -viernes \r\n6 - sabado \r\n0 - domingo  \r\n\r\ncomo en php\r\n\r\n',
  `rela_cursohorarios_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  `rela_curso_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  `rela_trayecto_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  `rela_materia_id_modulo1` bigint(20) unsigned NOT NULL DEFAULT 0,
  `rela_docente_id1` bigint(20) unsigned NOT NULL DEFAULT 0,
  `nsituacion_docente1` int(1) unsigned NOT NULL DEFAULT 1 COMMENT '1 - titular  2 - interino  3 - suplente ',
  `rela_materia_id_modulo2` bigint(20) unsigned NOT NULL DEFAULT 0,
  `rela_docente_id2` bigint(20) unsigned NOT NULL DEFAULT 0,
  `nsituacion_docente2` int(1) unsigned NOT NULL DEFAULT 1 COMMENT '1 - titular  2 - interino  3 - suplente ',
  `rela_materia_id_modulo3` bigint(20) unsigned NOT NULL DEFAULT 0,
  `rela_docente_id3` bigint(20) unsigned NOT NULL DEFAULT 0,
  `nsituacion_docente3` int(1) unsigned NOT NULL DEFAULT 1 COMMENT '1 - titular  2 - interino  3 - suplente ',
  `rela_materia_id_modulo4` bigint(20) unsigned NOT NULL DEFAULT 0,
  `rela_docente_id4` bigint(20) unsigned NOT NULL DEFAULT 0,
  `nsituacion_docente4` int(1) unsigned NOT NULL DEFAULT 1 COMMENT '1 - titular  2 - interino  3 - suplente ',
  `rela_materia_id_modulo5` bigint(20) unsigned NOT NULL DEFAULT 0,
  `rela_docente_id5` bigint(20) unsigned NOT NULL DEFAULT 0,
  `nsituacion_docente5` int(1) unsigned NOT NULL DEFAULT 1 COMMENT '1 - titular  2 - interino  3 - suplente ',
  `rela_materia_id_modulo6` bigint(20) unsigned NOT NULL DEFAULT 0,
  `rela_docente_id6` bigint(20) unsigned NOT NULL DEFAULT 0,
  `nsituacion_docente6` int(1) unsigned NOT NULL DEFAULT 1 COMMENT '1 - titular  2 - interino  3 - suplente ',
  `rela_materia_id_modulo7` bigint(20) unsigned NOT NULL DEFAULT 0,
  `rela_docente_id7` bigint(20) unsigned NOT NULL DEFAULT 0,
  `nsituacion_docente7` int(1) unsigned NOT NULL DEFAULT 1 COMMENT '1 - titular  2 - interino  3 - suplente ',
  `chora_desdemodulo1` varchar(10) NOT NULL,
  `chora_hastamodulo1` varchar(10) NOT NULL,
  `chora_desdemodulo2` varchar(10) NOT NULL,
  `chora_hastamodulo2` varchar(10) NOT NULL,
  `chora_desdemodulo3` varchar(10) NOT NULL,
  `chora_hastamodulo3` varchar(10) NOT NULL,
  `chora_desdemodulo4` varchar(10) NOT NULL,
  `chora_hastamodulo4` varchar(10) NOT NULL,
  `chora_desdemodulo5` varchar(10) NOT NULL,
  `chora_hastamodulo5` varchar(10) NOT NULL,
  `chora_desdemodulo6` varchar(10) NOT NULL,
  `chora_hastamodulo6` varchar(10) NOT NULL,
  `chora_desdemodulo7` varchar(10) NOT NULL,
  `chora_hastamodulo7` varchar(10) NOT NULL,
  `nvalor_inasistencia` decimal(3,2) unsigned NOT NULL DEFAULT 1.00,
  `bhorario_activo` int(1) unsigned NOT NULL,
  PRIMARY KEY (`cursoshorariosmaterias_id`) USING BTREE,
  KEY `rela_curso_id` (`rela_curso_id`),
  KEY `rela_trayecto_id` (`rela_trayecto_id`),
  KEY `curso-trayecto-dia` (`rela_curso_id`,`rela_trayecto_id`,`ndia_cursohorariomateria`),
  KEY `rela_materia_id_modulo1` (`rela_materia_id_modulo1`),
  KEY `rela_materia_id_modulo2` (`rela_materia_id_modulo2`),
  KEY `rela_materia_id_modulo3` (`rela_materia_id_modulo3`),
  KEY `rela_materia_id_modulo4` (`rela_materia_id_modulo4`),
  KEY `rela_materia_id_modulo5` (`rela_materia_id_modulo5`),
  KEY `rela_materia_id_modulo6` (`rela_materia_id_modulo6`),
  KEY `rela_materia_id_modulo7` (`rela_materia_id_modulo7`),
  KEY `rela_docente_id1` (`rela_docente_id1`),
  KEY `rela_docente_id2` (`rela_docente_id2`),
  KEY `rela_docente_id3` (`rela_docente_id3`),
  KEY `rela_docente_id4` (`rela_docente_id4`),
  KEY `rela_docente_id6` (`rela_docente_id6`),
  KEY `rela_docente_id5` (`rela_docente_id5`),
  KEY `rela_docente_id7` (`rela_docente_id7`),
  KEY `rela_cursohorarios_id` (`rela_cursohorarios_id`),
  CONSTRAINT `FK_cursos_horarios_materias_cursos` FOREIGN KEY (`rela_curso_id`) REFERENCES `cursos` (`curso_id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_cursos_horarios_materias_cursos_horarios` FOREIGN KEY (`rela_cursohorarios_id`) REFERENCES `cursos_horarios` (`cursoshorarios_id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_cursos_horarios_materias_docentes` FOREIGN KEY (`rela_docente_id1`) REFERENCES `docentes` (`docente_id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_cursos_horarios_materias_docentes_2` FOREIGN KEY (`rela_docente_id2`) REFERENCES `docentes` (`docente_id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_cursos_horarios_materias_docentes_3` FOREIGN KEY (`rela_docente_id3`) REFERENCES `docentes` (`docente_id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_cursos_horarios_materias_docentes_4` FOREIGN KEY (`rela_docente_id4`) REFERENCES `docentes` (`docente_id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_cursos_horarios_materias_docentes_5` FOREIGN KEY (`rela_docente_id5`) REFERENCES `docentes` (`docente_id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_cursos_horarios_materias_docentes_6` FOREIGN KEY (`rela_docente_id6`) REFERENCES `docentes` (`docente_id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_cursos_horarios_materias_docentes_7` FOREIGN KEY (`rela_docente_id7`) REFERENCES `docentes` (`docente_id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_cursos_horarios_materias_materias` FOREIGN KEY (`rela_materia_id_modulo1`) REFERENCES `materias` (`materia_id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_cursos_horarios_materias_materias_2` FOREIGN KEY (`rela_materia_id_modulo2`) REFERENCES `materias` (`materia_id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_cursos_horarios_materias_materias_3` FOREIGN KEY (`rela_materia_id_modulo3`) REFERENCES `materias` (`materia_id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_cursos_horarios_materias_materias_4` FOREIGN KEY (`rela_materia_id_modulo4`) REFERENCES `materias` (`materia_id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_cursos_horarios_materias_materias_5` FOREIGN KEY (`rela_materia_id_modulo5`) REFERENCES `materias` (`materia_id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_cursos_horarios_materias_materias_6` FOREIGN KEY (`rela_materia_id_modulo6`) REFERENCES `materias` (`materia_id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_cursos_horarios_materias_materias_7` FOREIGN KEY (`rela_materia_id_modulo7`) REFERENCES `materias` (`materia_id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_cursos_horarios_materias_trayectos` FOREIGN KEY (`rela_trayecto_id`) REFERENCES `trayectos` (`trayecto_id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC COMMENT='Almacena informacion sobre los horarios de los cursos y las materias';

-- Volcando datos para la tabla db_escuela.cursos_horarios_materias: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `cursos_horarios_materias` DISABLE KEYS */;
INSERT INTO `cursos_horarios_materias` (`cursoshorariosmaterias_id`, `ndia_cursohorariomateria`, `rela_cursohorarios_id`, `rela_curso_id`, `rela_trayecto_id`, `rela_materia_id_modulo1`, `rela_docente_id1`, `nsituacion_docente1`, `rela_materia_id_modulo2`, `rela_docente_id2`, `nsituacion_docente2`, `rela_materia_id_modulo3`, `rela_docente_id3`, `nsituacion_docente3`, `rela_materia_id_modulo4`, `rela_docente_id4`, `nsituacion_docente4`, `rela_materia_id_modulo5`, `rela_docente_id5`, `nsituacion_docente5`, `rela_materia_id_modulo6`, `rela_docente_id6`, `nsituacion_docente6`, `rela_materia_id_modulo7`, `rela_docente_id7`, `nsituacion_docente7`, `chora_desdemodulo1`, `chora_hastamodulo1`, `chora_desdemodulo2`, `chora_hastamodulo2`, `chora_desdemodulo3`, `chora_hastamodulo3`, `chora_desdemodulo4`, `chora_hastamodulo4`, `chora_desdemodulo5`, `chora_hastamodulo5`, `chora_desdemodulo6`, `chora_hastamodulo6`, `chora_desdemodulo7`, `chora_hastamodulo7`, `nvalor_inasistencia`, `bhorario_activo`) VALUES
	(1, 1, 1, 1, 2, 2, 3, 1, 1, 3, 1, 1, 3, 1, 1, 3, 1, 2, 3, 1, 2, 3, 1, 2, 3, 1, '', '', '', '', '', '', '', '', '', '', '', '', '', '', 1.00, 0);
/*!40000 ALTER TABLE `cursos_horarios_materias` ENABLE KEYS */;

-- Volcando estructura para tabla db_escuela.cursos_materias
CREATE TABLE IF NOT EXISTS `cursos_materias` (
  `cursosmaterias_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `rela_curso_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  `rela_materia_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`cursosmaterias_id`) USING BTREE,
  KEY `rela_curso_id` (`rela_curso_id`) USING BTREE,
  KEY `rela_materia_id` (`rela_materia_id`),
  CONSTRAINT `FK_cursos_materias_cursos` FOREIGN KEY (`rela_curso_id`) REFERENCES `cursos` (`curso_id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_cursos_materias_materias` FOREIGN KEY (`rela_materia_id`) REFERENCES `materias` (`materia_id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC COMMENT='Almacena informacion sobre los materias de los cursos';

-- Volcando datos para la tabla db_escuela.cursos_materias: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `cursos_materias` DISABLE KEYS */;
INSERT INTO `cursos_materias` (`cursosmaterias_id`, `rela_curso_id`, `rela_materia_id`) VALUES
	(1, 1, 1),
	(2, 1, 2);
/*!40000 ALTER TABLE `cursos_materias` ENABLE KEYS */;

-- Volcando estructura para tabla db_escuela.direcciones
CREATE TABLE IF NOT EXISTS `direcciones` (
  `direccion_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `cmanzana_direccion` varchar(4) NOT NULL,
  `ccasa_direccion` varchar(4) NOT NULL,
  `csector_direccion` varchar(4) NOT NULL,
  `clote_direccion` varchar(4) NOT NULL,
  `cparcela_direccion` varchar(4) NOT NULL,
  `cdescripcion_direccion` varchar(50) NOT NULL,
  `rela_calle_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  `rela_barrio_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  `rela_localidad_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  `rela_persona_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`direccion_id`),
  KEY `rela_calle_id` (`rela_calle_id`),
  KEY `rela_barrio_id` (`rela_barrio_id`),
  KEY `rela_localidad_id` (`rela_localidad_id`),
  KEY `rela_persona_id` (`rela_persona_id`),
  CONSTRAINT `FK_direcciones_barrios` FOREIGN KEY (`rela_barrio_id`) REFERENCES `barrios` (`barrio_id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_direcciones_calles` FOREIGN KEY (`rela_calle_id`) REFERENCES `calles` (`calle_id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_direcciones_localidades` FOREIGN KEY (`rela_localidad_id`) REFERENCES `localidades` (`localidad_id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_direcciones_personas` FOREIGN KEY (`rela_persona_id`) REFERENCES `personas` (`persona_id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1 COMMENT='Almacena las direcciones de las personas';

-- Volcando datos para la tabla db_escuela.direcciones: ~7 rows (aproximadamente)
/*!40000 ALTER TABLE `direcciones` DISABLE KEYS */;
INSERT INTO `direcciones` (`direccion_id`, `cmanzana_direccion`, `ccasa_direccion`, `csector_direccion`, `clote_direccion`, `cparcela_direccion`, `cdescripcion_direccion`, `rela_calle_id`, `rela_barrio_id`, `rela_localidad_id`, `rela_persona_id`) VALUES
	(1, '34', '6', '2', '5', '6', '', 1, 1, 1, 1),
	(2, '34', '51', '0', '0', '0', '-', 2, 1, 1, 2),
	(3, '32', '20', '0', '0', '0', '-', 2, 1, 1, 7),
	(4, '34', '51', '0', '0', '0', '-', 1, 2, 1, 6),
	(5, '32', '20', '0', '0', '0', '-', 2, 2, 1, 4),
	(6, '32', '20', '0', '0', '0', '-', 2, 1, 1, 3),
	(7, '34', '20', '0', '0', '0', '-', 1, 1, 1, 5);
/*!40000 ALTER TABLE `direcciones` ENABLE KEYS */;

-- Volcando estructura para tabla db_escuela.divisiones
CREATE TABLE IF NOT EXISTS `divisiones` (
  `division_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `rela_curso_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  `rela_anolectivo_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`division_id`) USING BTREE,
  KEY `cdescripcion_ciclolectivo` (`rela_curso_id`) USING BTREE,
  KEY `rela_anolectivo_id` (`rela_anolectivo_id`) USING BTREE,
  CONSTRAINT `FK_divisiones_anos_lectivos` FOREIGN KEY (`rela_anolectivo_id`) REFERENCES `anos_lectivos` (`anolectivo_id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_divisiones_cursos` FOREIGN KEY (`rela_curso_id`) REFERENCES `cursos` (`curso_id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC COMMENT='Almacena Informacion sobre las divisiones con alumnos';

-- Volcando datos para la tabla db_escuela.divisiones: ~22 rows (aproximadamente)
/*!40000 ALTER TABLE `divisiones` DISABLE KEYS */;
INSERT INTO `divisiones` (`division_id`, `rela_curso_id`, `rela_anolectivo_id`) VALUES
	(3, 1, 1),
	(4, 2, 1),
	(5, 3, 1),
	(6, 4, 1),
	(7, 5, 1),
	(8, 6, 1),
	(9, 7, 1),
	(10, 8, 1),
	(11, 9, 1),
	(12, 10, 1),
	(13, 11, 1),
	(14, 12, 1),
	(15, 13, 1),
	(16, 14, 1),
	(17, 15, 1),
	(18, 16, 1),
	(19, 17, 1),
	(20, 18, 1),
	(21, 19, 1),
	(22, 20, 1),
	(23, 21, 1),
	(24, 22, 1);
/*!40000 ALTER TABLE `divisiones` ENABLE KEYS */;

-- Volcando estructura para tabla db_escuela.divisiones_alumnos
CREATE TABLE IF NOT EXISTS `divisiones_alumnos` (
  `division_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `rela_anolectivo_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  `rela_curso_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  `rela_alumno_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`division_id`) USING BTREE,
  KEY `cdescripcion_ciclolectivo` (`rela_curso_id`) USING BTREE,
  KEY `rela_anolectivo_id` (`rela_anolectivo_id`) USING BTREE,
  KEY `rela_alumno_id` (`rela_alumno_id`),
  CONSTRAINT `FK_divisiones_alumnos_alumnos` FOREIGN KEY (`rela_alumno_id`) REFERENCES `alumnos` (`alumno_id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_divisiones_alumnos_anos_lectivos` FOREIGN KEY (`rela_anolectivo_id`) REFERENCES `anos_lectivos` (`anolectivo_id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_divisiones_alumnos_cursos` FOREIGN KEY (`rela_curso_id`) REFERENCES `cursos` (`curso_id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC COMMENT='Almacena Informacion sobre las divisiones con alumnos';

-- Volcando datos para la tabla db_escuela.divisiones_alumnos: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `divisiones_alumnos` DISABLE KEYS */;
INSERT INTO `divisiones_alumnos` (`division_id`, `rela_anolectivo_id`, `rela_curso_id`, `rela_alumno_id`) VALUES
	(1, 1, 1, 1);
/*!40000 ALTER TABLE `divisiones_alumnos` ENABLE KEYS */;

-- Volcando estructura para tabla db_escuela.divisiones_horarios_materias
CREATE TABLE IF NOT EXISTS `divisiones_horarios_materias` (
  `divisionhorario_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `dfecha_horario` date NOT NULL,
  `rela_cursohorario_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  `rela_anolectivo_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  `rela_curso_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  `rela_trayecto_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  `rela_preceptor_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  `ndia_cursohorariomateria` int(1) unsigned NOT NULL DEFAULT 1 COMMENT '1 - lunes \r\n2 - martes \r\n3 - miercoles \r\n4 -jueves \r\n5 -viernes \r\n6 - sabado \r\n0 - domingo  \r\n\r\ncomo en php\r\n\r\n',
  `rela_materia_id_modulo1` bigint(20) unsigned NOT NULL DEFAULT 0,
  `rela_docente_id1` bigint(20) unsigned NOT NULL DEFAULT 0,
  `nsituacion_docente1` int(1) unsigned NOT NULL DEFAULT 1 COMMENT '1 - titular  2 - interino  3 - suplente ',
  `bdocente_presente1` int(1) unsigned NOT NULL DEFAULT 1,
  `rela_materia_id_modulo2` bigint(20) unsigned NOT NULL DEFAULT 0,
  `rela_docente_id2` bigint(20) unsigned NOT NULL DEFAULT 0,
  `nsituacion_docente2` int(1) unsigned NOT NULL DEFAULT 1 COMMENT '1 - titular  2 - interino  3 - suplente ',
  `bdocente_presente2` int(1) unsigned NOT NULL DEFAULT 1,
  `rela_materia_id_modulo3` bigint(20) unsigned NOT NULL DEFAULT 0,
  `rela_docente_id3` bigint(20) unsigned NOT NULL DEFAULT 0,
  `nsituacion_docente3` int(1) unsigned NOT NULL DEFAULT 1 COMMENT '1 - titular  2 - interino  3 - suplente ',
  `bdocente_presente3` int(1) unsigned NOT NULL DEFAULT 1,
  `rela_materia_id_modulo4` bigint(20) unsigned NOT NULL DEFAULT 0,
  `rela_docente_id4` bigint(20) unsigned NOT NULL DEFAULT 0,
  `nsituacion_docente4` int(1) unsigned NOT NULL DEFAULT 1 COMMENT '1 - titular  2 - interino  3 - suplente ',
  `bdocente_presente4` int(1) unsigned NOT NULL DEFAULT 1,
  `rela_materia_id_modulo5` bigint(20) unsigned NOT NULL DEFAULT 0,
  `rela_docente_id5` bigint(20) unsigned NOT NULL DEFAULT 0,
  `nsituacion_docente5` int(1) unsigned NOT NULL DEFAULT 1 COMMENT '1 - titular  2 - interino  3 - suplente ',
  `bdocente_presente5` int(1) unsigned NOT NULL DEFAULT 1,
  `rela_materia_id_modulo6` bigint(20) unsigned NOT NULL DEFAULT 0,
  `rela_docente_id6` bigint(20) unsigned NOT NULL DEFAULT 0,
  `nsituacion_docente6` int(1) unsigned NOT NULL DEFAULT 1 COMMENT '1 - titular  2 - interino  3 - suplente ',
  `bdocente_presente6` int(1) unsigned NOT NULL DEFAULT 1,
  `rela_materia_id_modulo7` bigint(20) unsigned NOT NULL DEFAULT 0,
  `rela_docente_id7` bigint(20) unsigned NOT NULL DEFAULT 0,
  `nsituacion_docente7` int(1) unsigned NOT NULL DEFAULT 1 COMMENT '1 - titular  2 - interino  3 - suplente ',
  `bdocente_presente7` int(1) unsigned NOT NULL DEFAULT 1,
  `chora_desdemodulo1` varchar(10) NOT NULL,
  `chora_hastamodulo1` varchar(10) NOT NULL,
  `chora_desdemodulo2` varchar(10) NOT NULL,
  `chora_hastamodulo2` varchar(10) NOT NULL,
  `chora_desdemodulo3` varchar(10) NOT NULL,
  `chora_hastamodulo3` varchar(10) NOT NULL,
  `chora_desdemodulo4` varchar(10) NOT NULL,
  `chora_hastamodulo4` varchar(10) NOT NULL,
  `chora_desdemodulo5` varchar(10) NOT NULL,
  `chora_hastamodulo5` varchar(10) NOT NULL,
  `chora_desdemodulo6` varchar(10) NOT NULL,
  `chora_hastamodulo6` varchar(10) NOT NULL,
  `chora_desdemodulo7` varchar(10) NOT NULL,
  `chora_hastamodulo7` varchar(10) NOT NULL,
  `nvalor_inasistencia` decimal(3,2) unsigned NOT NULL DEFAULT 1.00,
  PRIMARY KEY (`divisionhorario_id`) USING BTREE,
  KEY `rela_curso_id` (`rela_curso_id`) USING BTREE,
  KEY `rela_trayecto_id` (`rela_trayecto_id`) USING BTREE,
  KEY `rela_peceptor_id` (`rela_preceptor_id`) USING BTREE,
  KEY `rela_anolectivo_id` (`rela_anolectivo_id`) USING BTREE,
  KEY `rela_materia_id_modulo1` (`rela_materia_id_modulo1`) USING BTREE,
  KEY `rela_docente_id1` (`rela_docente_id1`) USING BTREE,
  KEY `rela_materia_id_modulo2` (`rela_materia_id_modulo2`) USING BTREE,
  KEY `rela_docente_id2` (`rela_docente_id2`) USING BTREE,
  KEY `rela_materia_id_modulo3` (`rela_materia_id_modulo3`) USING BTREE,
  KEY `rela_docente_id3` (`rela_docente_id3`) USING BTREE,
  KEY `rela_materia_id_modulo4` (`rela_materia_id_modulo4`) USING BTREE,
  KEY `rela_docente_id4` (`rela_docente_id4`) USING BTREE,
  KEY `rela_materia_id_modulo5` (`rela_materia_id_modulo5`) USING BTREE,
  KEY `rela_docente_id5` (`rela_docente_id5`) USING BTREE,
  KEY `rela_materia_id_modulo6` (`rela_materia_id_modulo6`) USING BTREE,
  KEY `rela_docente_id6` (`rela_docente_id6`) USING BTREE,
  KEY `rela_materia_id_modulo7` (`rela_materia_id_modulo7`) USING BTREE,
  KEY `rela_docente_id7` (`rela_docente_id7`) USING BTREE,
  KEY `rela_cursohorario_id` (`rela_cursohorario_id`) USING BTREE,
  KEY `dfecha_horario` (`dfecha_horario`) USING BTREE,
  CONSTRAINT `FK_divisiones_horarios_materias_anos_lectivos` FOREIGN KEY (`rela_anolectivo_id`) REFERENCES `anos_lectivos` (`anolectivo_id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_divisiones_horarios_materias_cursos` FOREIGN KEY (`rela_curso_id`) REFERENCES `cursos` (`curso_id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_divisiones_horarios_materias_cursos_horarios` FOREIGN KEY (`rela_cursohorario_id`) REFERENCES `cursos_horarios` (`cursoshorarios_id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_divisiones_horarios_materias_docentes` FOREIGN KEY (`rela_docente_id1`) REFERENCES `docentes` (`docente_id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_divisiones_horarios_materias_docentes_2` FOREIGN KEY (`rela_docente_id2`) REFERENCES `docentes` (`docente_id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_divisiones_horarios_materias_docentes_3` FOREIGN KEY (`rela_docente_id3`) REFERENCES `docentes` (`docente_id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_divisiones_horarios_materias_docentes_4` FOREIGN KEY (`rela_docente_id4`) REFERENCES `docentes` (`docente_id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_divisiones_horarios_materias_docentes_5` FOREIGN KEY (`rela_docente_id5`) REFERENCES `docentes` (`docente_id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_divisiones_horarios_materias_docentes_6` FOREIGN KEY (`rela_docente_id6`) REFERENCES `docentes` (`docente_id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_divisiones_horarios_materias_docentes_7` FOREIGN KEY (`rela_docente_id7`) REFERENCES `docentes` (`docente_id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_divisiones_horarios_materias_materias` FOREIGN KEY (`rela_materia_id_modulo1`) REFERENCES `materias` (`materia_id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_divisiones_horarios_materias_materias_2` FOREIGN KEY (`rela_materia_id_modulo2`) REFERENCES `materias` (`materia_id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_divisiones_horarios_materias_materias_3` FOREIGN KEY (`rela_materia_id_modulo3`) REFERENCES `materias` (`materia_id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_divisiones_horarios_materias_materias_4` FOREIGN KEY (`rela_materia_id_modulo4`) REFERENCES `materias` (`materia_id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_divisiones_horarios_materias_materias_5` FOREIGN KEY (`rela_materia_id_modulo5`) REFERENCES `materias` (`materia_id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_divisiones_horarios_materias_materias_6` FOREIGN KEY (`rela_materia_id_modulo6`) REFERENCES `materias` (`materia_id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_divisiones_horarios_materias_materias_7` FOREIGN KEY (`rela_materia_id_modulo7`) REFERENCES `materias` (`materia_id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_divisiones_horarios_materias_preceptores` FOREIGN KEY (`rela_preceptor_id`) REFERENCES `preceptores` (`preceptor_id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_divisiones_horarios_materias_trayectos` FOREIGN KEY (`rela_trayecto_id`) REFERENCES `trayectos` (`trayecto_id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC COMMENT='Almacena informacion sobre los horarios de las divisiones ,la fecha y la asistencia del profesor';

-- Volcando datos para la tabla db_escuela.divisiones_horarios_materias: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `divisiones_horarios_materias` DISABLE KEYS */;
/*!40000 ALTER TABLE `divisiones_horarios_materias` ENABLE KEYS */;

-- Volcando estructura para tabla db_escuela.divisiones_inasistencias
CREATE TABLE IF NOT EXISTS `divisiones_inasistencias` (
  `divisioninasistencia_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `dfecha_inasistencia` date NOT NULL,
  `binasistencia_justificada` int(1) unsigned NOT NULL DEFAULT 0,
  `rela_anolectivo_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  `rela_curso_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  `rela_trayecto_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  `rela_alumno_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  `rela_documentos_personas_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`divisioninasistencia_id`) USING BTREE,
  KEY `cdescripcion_ciclolectivo` (`rela_curso_id`) USING BTREE,
  KEY `rela_anolectivo_id` (`rela_anolectivo_id`) USING BTREE,
  KEY `rela_alumno_id` (`rela_alumno_id`) USING BTREE,
  KEY `rela_trayecto_id` (`rela_trayecto_id`),
  KEY `dfecha_asistencia` (`dfecha_inasistencia`) USING BTREE,
  KEY `rela_documentos_personas_id` (`rela_documentos_personas_id`),
  CONSTRAINT `FK_divisiones_asistencias_alumnos` FOREIGN KEY (`rela_alumno_id`) REFERENCES `alumnos` (`alumno_id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_divisiones_asistencias_anos_lectivos` FOREIGN KEY (`rela_anolectivo_id`) REFERENCES `anos_lectivos` (`anolectivo_id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_divisiones_asistencias_cursos` FOREIGN KEY (`rela_curso_id`) REFERENCES `cursos` (`curso_id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_divisiones_asistencias_trayectos` FOREIGN KEY (`rela_trayecto_id`) REFERENCES `trayectos` (`trayecto_id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_divisiones_inasistencias_documentos_personas` FOREIGN KEY (`rela_documentos_personas_id`) REFERENCES `documentos_personas` (`documento_id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC COMMENT='Almacena Informacion sobre las inasistencias de los alumnos';

-- Volcando datos para la tabla db_escuela.divisiones_inasistencias: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `divisiones_inasistencias` DISABLE KEYS */;
/*!40000 ALTER TABLE `divisiones_inasistencias` ENABLE KEYS */;

-- Volcando estructura para tabla db_escuela.docentes
CREATE TABLE IF NOT EXISTS `docentes` (
  `docente_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nsituacion_docente` int(1) unsigned NOT NULL DEFAULT 1 COMMENT '1 - activo \r\n2 - inactivo',
  `cnumlegajo_docente` varchar(50) DEFAULT NULL,
  `cnumregistro_docente` varchar(50) DEFAULT NULL,
  `cestado_legajo` varchar(50) NOT NULL,
  `cobservaciones_docente` varchar(255) NOT NULL,
  `rela_persona_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  `rela_estadodocente_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`docente_id`),
  KEY `rela_persona_id` (`rela_persona_id`),
  KEY `rela_estadodocente_id` (`rela_estadodocente_id`) USING BTREE,
  CONSTRAINT `FK_docentes_estado_docentes` FOREIGN KEY (`rela_estadodocente_id`) REFERENCES `estado_docentes` (`estadodocente_id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_docentes_personas` FOREIGN KEY (`rela_persona_id`) REFERENCES `personas` (`persona_id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1 COMMENT='Almacena Informacion sobre los Docentes';

-- Volcando datos para la tabla db_escuela.docentes: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `docentes` DISABLE KEYS */;
INSERT INTO `docentes` (`docente_id`, `nsituacion_docente`, `cnumlegajo_docente`, `cnumregistro_docente`, `cestado_legajo`, `cobservaciones_docente`, `rela_persona_id`, `rela_estadodocente_id`) VALUES
	(3, 1, '980', '909', '', '', 1, 1),
	(5, 1, '398', '121', '', '', 2, 1);
/*!40000 ALTER TABLE `docentes` ENABLE KEYS */;

-- Volcando estructura para tabla db_escuela.documentos_personas
CREATE TABLE IF NOT EXISTS `documentos_personas` (
  `documento_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `rela_tipodocumento_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  `rela_persona_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  `cimg_documento` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`documento_id`) USING BTREE,
  KEY `rela_tipodocumento_id` (`rela_tipodocumento_id`),
  KEY `rela_persona_id` (`rela_persona_id`) USING BTREE,
  CONSTRAINT `FK_documentospersonas_personas` FOREIGN KEY (`rela_persona_id`) REFERENCES `personas` (`persona_id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_documentospersonas_tiposdocumentos` FOREIGN KEY (`rela_tipodocumento_id`) REFERENCES `tipos_documentos` (`tipodocumento_id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='almacena documentos digitalizados de las personas';

-- Volcando datos para la tabla db_escuela.documentos_personas: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `documentos_personas` DISABLE KEYS */;
/*!40000 ALTER TABLE `documentos_personas` ENABLE KEYS */;

-- Volcando estructura para tabla db_escuela.documentos_varios
CREATE TABLE IF NOT EXISTS `documentos_varios` (
  `documento_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `rela_tipodocumento_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  `cnombre_documento` varchar(100) DEFAULT NULL,
  `cdescripcion_documento` varchar(100) DEFAULT NULL,
  `dfecha_documento` date DEFAULT NULL,
  `rruta` varchar(100) NOT NULL,
  PRIMARY KEY (`documento_id`) USING BTREE,
  KEY `rela_tipodocumento_id` (`rela_tipodocumento_id`) USING BTREE,
  KEY `dfecha_documento` (`dfecha_documento`),
  KEY `cdescripcion_documento` (`cdescripcion_documento`),
  CONSTRAINT `FK_documentos_varios_tipos_documentos` FOREIGN KEY (`rela_tipodocumento_id`) REFERENCES `tipos_documentos` (`tipodocumento_id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC COMMENT='almacena documentos de la institucion';

-- Volcando datos para la tabla db_escuela.documentos_varios: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `documentos_varios` DISABLE KEYS */;
INSERT INTO `documentos_varios` (`documento_id`, `rela_tipodocumento_id`, `cnombre_documento`, `cdescripcion_documento`, `dfecha_documento`, `rruta`) VALUES
	(45, 13, 'PRÃCTICAS PROFESIONALIZANTES.docx', 'jhin', '2020-09-14', '../../storage/documentos/alta/PRÃCTICAS PROFESIONALIZANTES.docx');
/*!40000 ALTER TABLE `documentos_varios` ENABLE KEYS */;

-- Volcando estructura para tabla db_escuela.estado_alumnos
CREATE TABLE IF NOT EXISTS `estado_alumnos` (
  `estadoalumno_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `cdescripcion_estadoalumno` varchar(50) NOT NULL,
  PRIMARY KEY (`estadoalumno_id`),
  KEY `cdescripcion_estadoalumno` (`cdescripcion_estadoalumno`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COMMENT='Almacena Informacion sobre el estado en la institucion de los alumnos';

-- Volcando datos para la tabla db_escuela.estado_alumnos: ~3 rows (aproximadamente)
/*!40000 ALTER TABLE `estado_alumnos` DISABLE KEYS */;
INSERT INTO `estado_alumnos` (`estadoalumno_id`, `cdescripcion_estadoalumno`) VALUES
	(3, 'libre'),
	(2, 'regular'),
	(1, 'reincorporado');
/*!40000 ALTER TABLE `estado_alumnos` ENABLE KEYS */;

-- Volcando estructura para tabla db_escuela.estado_docentes
CREATE TABLE IF NOT EXISTS `estado_docentes` (
  `estadodocente_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `cdescripcion_estadodocente` varchar(50) NOT NULL,
  PRIMARY KEY (`estadodocente_id`) USING BTREE,
  KEY `cdescripcion_estadoalumno` (`cdescripcion_estadodocente`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC COMMENT='Almacena Informacion sobre el estado en la institucion de los docentes';

-- Volcando datos para la tabla db_escuela.estado_docentes: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `estado_docentes` DISABLE KEYS */;
INSERT INTO `estado_docentes` (`estadodocente_id`, `cdescripcion_estadodocente`) VALUES
	(1, 'activo'),
	(2, 'inactivo');
/*!40000 ALTER TABLE `estado_docentes` ENABLE KEYS */;

-- Volcando estructura para tabla db_escuela.etapas_escolares
CREATE TABLE IF NOT EXISTS `etapas_escolares` (
  `etapaescolar_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `cdescripcion_etapa` varchar(50) NOT NULL DEFAULT '0',
  PRIMARY KEY (`etapaescolar_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1 COMMENT='Almacena Informacion sobre las etapas escolares vigentes';

-- Volcando datos para la tabla db_escuela.etapas_escolares: ~7 rows (aproximadamente)
/*!40000 ALTER TABLE `etapas_escolares` DISABLE KEYS */;
INSERT INTO `etapas_escolares` (`etapaescolar_id`, `cdescripcion_etapa`) VALUES
	(1, 'Primer Trismestre'),
	(2, 'Segundo Trimestre'),
	(3, 'Tercer Trimestre'),
	(4, 'Diciembre'),
	(5, 'Febrero'),
	(6, 'Primer Cuatrimestre'),
	(7, 'Segundo Cuatrimestre');
/*!40000 ALTER TABLE `etapas_escolares` ENABLE KEYS */;

-- Volcando estructura para tabla db_escuela.examenes
CREATE TABLE IF NOT EXISTS `examenes` (
  `examen_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `rela_anolectivo_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  `rela_curso_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  `rela_materia_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  `rela_alumno_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  `rela_etapaescolar_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  `dfecha_examen` date NOT NULL,
  `ncalificacion` decimal(10,2) unsigned NOT NULL DEFAULT 0.00,
  `rela_docente_id_1` bigint(20) unsigned NOT NULL DEFAULT 0,
  `rela_docente_id_2` bigint(20) unsigned NOT NULL DEFAULT 0,
  `rela_docente_id_3` bigint(20) unsigned NOT NULL DEFAULT 0,
  `nnumacta_examen` int(10) unsigned NOT NULL DEFAULT 0,
  `nanoacta_examen` int(10) unsigned NOT NULL DEFAULT 0,
  `nnumlibro_examen` int(10) unsigned NOT NULL DEFAULT 0,
  `nnumfolio_examen` int(10) unsigned NOT NULL DEFAULT 0,
  `nnumpagina_examen` int(10) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`examen_id`) USING BTREE,
  KEY `rela_curso_id` (`rela_curso_id`) USING BTREE,
  KEY `rela_materia_id` (`rela_materia_id`) USING BTREE,
  KEY `rela_anolectivo_id` (`rela_anolectivo_id`) USING BTREE,
  KEY `rela_etapaescolar_id` (`rela_etapaescolar_id`) USING BTREE,
  KEY `rela_docente_id_1` (`rela_docente_id_1`),
  KEY `rela_docente_id_2` (`rela_docente_id_2`),
  KEY `rela_docente_id_3` (`rela_docente_id_3`),
  KEY `rela_alumno_id` (`rela_alumno_id`),
  CONSTRAINT `FK_examenes_alumnos` FOREIGN KEY (`rela_alumno_id`) REFERENCES `alumnos` (`alumno_id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_examenes_anos_lectivos` FOREIGN KEY (`rela_anolectivo_id`) REFERENCES `anos_lectivos` (`anolectivo_id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_examenes_cursos` FOREIGN KEY (`rela_curso_id`) REFERENCES `cursos` (`curso_id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_examenes_docentes` FOREIGN KEY (`rela_docente_id_1`) REFERENCES `docentes` (`docente_id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_examenes_docentes_2` FOREIGN KEY (`rela_docente_id_2`) REFERENCES `docentes` (`docente_id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_examenes_docentes_3` FOREIGN KEY (`rela_docente_id_3`) REFERENCES `docentes` (`docente_id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_examenes_etapas_escolares` FOREIGN KEY (`rela_etapaescolar_id`) REFERENCES `etapas_escolares` (`etapaescolar_id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_examenes_materias` FOREIGN KEY (`rela_materia_id`) REFERENCES `materias` (`materia_id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC COMMENT='Almacena informacion sobre los examenes de los alumnos';

-- Volcando datos para la tabla db_escuela.examenes: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `examenes` DISABLE KEYS */;
/*!40000 ALTER TABLE `examenes` ENABLE KEYS */;

-- Volcando estructura para tabla db_escuela.historiales_alumnos
CREATE TABLE IF NOT EXISTS `historiales_alumnos` (
  `historialalumno_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `dfecha_historial` date NOT NULL,
  `historial_alumno` longtext NOT NULL,
  `rela_alumno_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`historialalumno_id`),
  KEY `dfecha_historial` (`dfecha_historial`),
  KEY `rela_alumno_id` (`rela_alumno_id`),
  CONSTRAINT `FK_historiales_alumnos_alumnos` FOREIGN KEY (`rela_alumno_id`) REFERENCES `alumnos` (`alumno_id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COMMENT='almacena informacion del historial del alumno';

-- Volcando datos para la tabla db_escuela.historiales_alumnos: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `historiales_alumnos` DISABLE KEYS */;
INSERT INTO `historiales_alumnos` (`historialalumno_id`, `dfecha_historial`, `historial_alumno`, `rela_alumno_id`) VALUES
	(2, '2020-09-03', 'ads10\r\nads20\r\n\r\n', 1);
/*!40000 ALTER TABLE `historiales_alumnos` ENABLE KEYS */;

-- Volcando estructura para tabla db_escuela.historiales_docentes
CREATE TABLE IF NOT EXISTS `historiales_docentes` (
  `historialdocente_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `dfecha_historial` date NOT NULL,
  `historial_docente` longtext NOT NULL,
  `rela_docente_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`historialdocente_id`) USING BTREE,
  KEY `dfecha_historial` (`dfecha_historial`) USING BTREE,
  KEY `rela_docente_id` (`rela_docente_id`) USING BTREE,
  CONSTRAINT `FK_historiales_docentes_docentes` FOREIGN KEY (`rela_docente_id`) REFERENCES `docentes` (`docente_id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC COMMENT='almacena informacion del historial del docente';

-- Volcando datos para la tabla db_escuela.historiales_docentes: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `historiales_docentes` DISABLE KEYS */;
INSERT INTO `historiales_docentes` (`historialdocente_id`, `dfecha_historial`, `historial_docente`, `rela_docente_id`) VALUES
	(4, '2020-09-09', 'jhin\r\n', 5);
/*!40000 ALTER TABLE `historiales_docentes` ENABLE KEYS */;

-- Volcando estructura para tabla db_escuela.historiales_personal
CREATE TABLE IF NOT EXISTS `historiales_personal` (
  `historialpersonal_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `dfecha_historial` date NOT NULL,
  `historial_personal` longtext NOT NULL,
  `rela_personal_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`historialpersonal_id`) USING BTREE,
  KEY `dfecha_historial` (`dfecha_historial`) USING BTREE,
  KEY `rela_personal_id` (`rela_personal_id`) USING BTREE,
  CONSTRAINT `FK_historiales_personal_personales` FOREIGN KEY (`rela_personal_id`) REFERENCES `personales` (`personal_id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC COMMENT='almacena informacion del historial del personal';

-- Volcando datos para la tabla db_escuela.historiales_personal: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `historiales_personal` DISABLE KEYS */;
INSERT INTO `historiales_personal` (`historialpersonal_id`, `dfecha_historial`, `historial_personal`, `rela_personal_id`) VALUES
	(3, '2020-07-20', 'jhinso', 2),
	(6, '0000-00-00', 'adsa', 3);
/*!40000 ALTER TABLE `historiales_personal` ENABLE KEYS */;

-- Volcando estructura para tabla db_escuela.localidades
CREATE TABLE IF NOT EXISTS `localidades` (
  `localidad_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `cnombre_localidad` varchar(50) NOT NULL,
  `rela_provincia_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`localidad_id`),
  KEY `nombre_localidad` (`cnombre_localidad`) USING BTREE,
  KEY `rela_provincia_id` (`rela_provincia_id`) USING BTREE,
  CONSTRAINT `FK_localidades_provincias` FOREIGN KEY (`rela_provincia_id`) REFERENCES `provincias` (`provincia_id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COMMENT='Almacena Informacion sobre las Localidades/Pueblos de una Provincia';

-- Volcando datos para la tabla db_escuela.localidades: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `localidades` DISABLE KEYS */;
INSERT INTO `localidades` (`localidad_id`, `cnombre_localidad`, `rela_provincia_id`) VALUES
	(1, 'Formosa', 1);
/*!40000 ALTER TABLE `localidades` ENABLE KEYS */;

-- Volcando estructura para tabla db_escuela.log
CREATE TABLE IF NOT EXISTS `log` (
  `log_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `dfecha_log` date NOT NULL,
  `chora_log` time NOT NULL,
  `cdescripcion_log` varchar(255) NOT NULL,
  `rela_usuario_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`log_id`),
  KEY `rela_usuario_id` (`rela_usuario_id`),
  KEY `dfechahora` (`dfecha_log`,`chora_log`),
  CONSTRAINT `FK_log_usuarios` FOREIGN KEY (`rela_usuario_id`) REFERENCES `usuarios` (`usuario_id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COMMENT='Almacena Informacion sobre las actividades de los usuarios';

-- Volcando datos para la tabla db_escuela.log: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `log` DISABLE KEYS */;
INSERT INTO `log` (`log_id`, `dfecha_log`, `chora_log`, `cdescripcion_log`, `rela_usuario_id`) VALUES
	(1, '2022-05-20', '09:59:38', ' Ingreso el sistema : Administrador con ID: 4', 4);
/*!40000 ALTER TABLE `log` ENABLE KEYS */;

-- Volcando estructura para tabla db_escuela.materias
CREATE TABLE IF NOT EXISTS `materias` (
  `materia_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `cnombre_materia` varchar(50) NOT NULL,
  PRIMARY KEY (`materia_id`) USING BTREE,
  KEY `cdescripcion_ciclolectivo` (`cnombre_materia`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC COMMENT='Almacena Informacion sobre las materias que se dictan en la institucion';

-- Volcando datos para la tabla db_escuela.materias: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `materias` DISABLE KEYS */;
INSERT INTO `materias` (`materia_id`, `cnombre_materia`) VALUES
	(2, 'inglés'),
	(1, 'lengua');
/*!40000 ALTER TABLE `materias` ENABLE KEYS */;

-- Volcando estructura para tabla db_escuela.notas
CREATE TABLE IF NOT EXISTS `notas` (
  `notas_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `rela_anolectivo_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  `rela_curso_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  `rela_materia_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  `rela_etapaescolar_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  `rela_alumno_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  `ncalificacion` decimal(10,2) unsigned NOT NULL DEFAULT 0.00,
  PRIMARY KEY (`notas_id`) USING BTREE,
  KEY `rela_curso_id` (`rela_curso_id`) USING BTREE,
  KEY `rela_materia_id` (`rela_materia_id`) USING BTREE,
  KEY `rela_anolectivo_id` (`rela_anolectivo_id`),
  KEY `rela_etapaescolar_id` (`rela_etapaescolar_id`),
  KEY `rela_alumno_id` (`rela_alumno_id`),
  CONSTRAINT `FK_notas_alumnos` FOREIGN KEY (`rela_alumno_id`) REFERENCES `alumnos` (`alumno_id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_notas_anos_lectivos` FOREIGN KEY (`rela_anolectivo_id`) REFERENCES `anos_lectivos` (`anolectivo_id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_notas_cursos` FOREIGN KEY (`rela_curso_id`) REFERENCES `cursos` (`curso_id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_notas_etapas_escolares` FOREIGN KEY (`rela_etapaescolar_id`) REFERENCES `etapas_escolares` (`etapaescolar_id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_notas_materias` FOREIGN KEY (`rela_materia_id`) REFERENCES `materias` (`materia_id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC COMMENT='Almacena informacion sobrelas notas de los alumnos';

-- Volcando datos para la tabla db_escuela.notas: ~3 rows (aproximadamente)
/*!40000 ALTER TABLE `notas` DISABLE KEYS */;
INSERT INTO `notas` (`notas_id`, `rela_anolectivo_id`, `rela_curso_id`, `rela_materia_id`, `rela_etapaescolar_id`, `rela_alumno_id`, `ncalificacion`) VALUES
	(1, 1, 1, 1, 1, 1, 10.00),
	(2, 2, 6, 2, 1, 1, 8.00),
	(3, 2, 7, 2, 6, 1, 7.00);
/*!40000 ALTER TABLE `notas` ENABLE KEYS */;

-- Volcando estructura para tabla db_escuela.paises
CREATE TABLE IF NOT EXISTS `paises` (
  `pais_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `cnombre_pais` varchar(50) NOT NULL,
  PRIMARY KEY (`pais_id`),
  KEY `nombre_pais` (`cnombre_pais`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COMMENT='Almacena Informacion sobre los paises';

-- Volcando datos para la tabla db_escuela.paises: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `paises` DISABLE KEYS */;
INSERT INTO `paises` (`pais_id`, `cnombre_pais`) VALUES
	(1, 'ARGENTINA');
/*!40000 ALTER TABLE `paises` ENABLE KEYS */;

-- Volcando estructura para tabla db_escuela.parametros
CREATE TABLE IF NOT EXISTS `parametros` (
  `nmaximo_inasitencias` int(10) unsigned NOT NULL DEFAULT 0,
  `nvalor_reincorporacion` int(10) unsigned NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='almacena parametros para el funcionamiento del sistema';

-- Volcando datos para la tabla db_escuela.parametros: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `parametros` DISABLE KEYS */;
/*!40000 ALTER TABLE `parametros` ENABLE KEYS */;

-- Volcando estructura para tabla db_escuela.personales
CREATE TABLE IF NOT EXISTS `personales` (
  `personal_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `cnumlegajo_personal` varchar(50) NOT NULL,
  `nsituacion_personal` int(1) unsigned NOT NULL DEFAULT 1 COMMENT '1 - activo \r\n2 - inactivo',
  `cobservaciones_personal` varchar(255) NOT NULL,
  `rela_persona_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  `rela_cargo_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`personal_id`) USING BTREE,
  KEY `rela_persona_id` (`rela_persona_id`) USING BTREE,
  KEY `rela_cargo_id` (`rela_cargo_id`) USING BTREE,
  CONSTRAINT `FK_personales_cargos` FOREIGN KEY (`rela_cargo_id`) REFERENCES `cargos` (`cargol_id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_personales_personas` FOREIGN KEY (`rela_persona_id`) REFERENCES `personas` (`persona_id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC COMMENT='Almacena Informacion sobre el personal de la institucion';

-- Volcando datos para la tabla db_escuela.personales: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `personales` DISABLE KEYS */;
INSERT INTO `personales` (`personal_id`, `cnumlegajo_personal`, `nsituacion_personal`, `cobservaciones_personal`, `rela_persona_id`, `rela_cargo_id`) VALUES
	(2, '816', 1, '', 1, 1),
	(3, '344', 1, '', 6, 1);
/*!40000 ALTER TABLE `personales` ENABLE KEYS */;

-- Volcando estructura para tabla db_escuela.personas
CREATE TABLE IF NOT EXISTS `personas` (
  `persona_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `capellidos_persona` varchar(100) NOT NULL,
  `cnombres_persona` varchar(100) NOT NULL,
  `ndni_persona` int(10) unsigned NOT NULL DEFAULT 0,
  `ncuil_persona` int(11) DEFAULT NULL,
  `cemail_persona` varchar(100) DEFAULT NULL,
  `dfechanac_persona` date DEFAULT NULL,
  `rela_sexo_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`persona_id`),
  KEY `nombrecompleto` (`capellidos_persona`,`cnombres_persona`) USING BTREE,
  KEY `ndni_persona` (`ndni_persona`),
  KEY `ccuil_persona` (`ncuil_persona`) USING BTREE,
  KEY `rela_sexo_id` (`rela_sexo_id`),
  CONSTRAINT `FK_personas_sexos` FOREIGN KEY (`rela_sexo_id`) REFERENCES `sexos` (`sexo_id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1 COMMENT='Almacena Informacion sobre las personas que interactuan con la institucion';

-- Volcando datos para la tabla db_escuela.personas: ~7 rows (aproximadamente)
/*!40000 ALTER TABLE `personas` DISABLE KEYS */;
INSERT INTO `personas` (`persona_id`, `capellidos_persona`, `cnombres_persona`, `ndni_persona`, `ncuil_persona`, `cemail_persona`, `dfechanac_persona`, `rela_sexo_id`) VALUES
	(1, 'Gonzalez', 'Gabriel', 43807013, 2043807013, 'gabriel240901gmail.com', '2001-09-24', 1),
	(2, 'Perez', 'Juan David', 908567432, 21, 'perezjuan90@gmail.com', '1992-07-15', 1),
	(3, 'Rodriguez', 'Pedro Fabian', 988768430, 204, 'rodriguezzzefe@gmail.com', '2020-09-09', 1),
	(4, 'Martinez', 'Alan Jacinto', 986765048, 178, 'kbgfdudn@gmail.com', '2020-09-08', 1),
	(5, 'Rosario', 'Florencia Luisa', 964986455, 987654052, 'lakshjfywndh@hotmail.com', '2020-09-07', 2),
	(6, 'Tato', 'Gaspar Marcelo', 954187654, 987, 'laksyuwmhdhd@yahoo.com', '2020-09-06', 1),
	(7, 'Gimenez', 'Gerardo Marcos', 876548765, 754, 'hybdsujhbvyufi@gmail.com', '2020-09-05', 1);
/*!40000 ALTER TABLE `personas` ENABLE KEYS */;

-- Volcando estructura para tabla db_escuela.preceptores
CREATE TABLE IF NOT EXISTS `preceptores` (
  `preceptor_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nsituacion_preceptor` int(1) unsigned NOT NULL DEFAULT 1 COMMENT '1 - activo \r\n2 - inactivo',
  `rela_persona_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`preceptor_id`) USING BTREE,
  KEY `rela_persona_id` (`rela_persona_id`) USING BTREE,
  CONSTRAINT `FK_preceptores_personas` FOREIGN KEY (`rela_persona_id`) REFERENCES `personas` (`persona_id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC COMMENT='Almacena Informacion sobre los preceptores de la institucion';

-- Volcando datos para la tabla db_escuela.preceptores: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `preceptores` DISABLE KEYS */;
INSERT INTO `preceptores` (`preceptor_id`, `nsituacion_preceptor`, `rela_persona_id`) VALUES
	(1, 1, 1);
/*!40000 ALTER TABLE `preceptores` ENABLE KEYS */;

-- Volcando estructura para tabla db_escuela.provincias
CREATE TABLE IF NOT EXISTS `provincias` (
  `provincia_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `cnombre_provincia` varchar(50) NOT NULL,
  `rela_pais_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`provincia_id`),
  KEY `nombre_provincia` (`cnombre_provincia`) USING BTREE,
  KEY `rela_pais_id` (`rela_pais_id`) USING BTREE,
  CONSTRAINT `FK_provincias_paises` FOREIGN KEY (`rela_pais_id`) REFERENCES `paises` (`pais_id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COMMENT='Almacena Informacion sobre las Provincias/Estados de un pais';

-- Volcando datos para la tabla db_escuela.provincias: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `provincias` DISABLE KEYS */;
INSERT INTO `provincias` (`provincia_id`, `cnombre_provincia`, `rela_pais_id`) VALUES
	(1, 'Cuidad de Formosa', 1);
/*!40000 ALTER TABLE `provincias` ENABLE KEYS */;

-- Volcando estructura para tabla db_escuela.roles
CREATE TABLE IF NOT EXISTS `roles` (
  `rol_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `cdescripcion_rol` varchar(50) NOT NULL,
  PRIMARY KEY (`rol_id`),
  KEY `cdescripcion_rol` (`cdescripcion_rol`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1 COMMENT='Administra los roles de usuarios';

-- Volcando datos para la tabla db_escuela.roles: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` (`rol_id`, `cdescripcion_rol`) VALUES
	(1, 'ADMINSTRADOR'),
	(20, 'INVITADO');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;

-- Volcando estructura para tabla db_escuela.sexos
CREATE TABLE IF NOT EXISTS `sexos` (
  `sexo_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `cdescripcion_sexo` varchar(50) NOT NULL,
  PRIMARY KEY (`sexo_id`),
  KEY `cdescripcion_sexo` (`cdescripcion_sexo`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COMMENT='Alamcena los diferentes sexos de las personas';

-- Volcando datos para la tabla db_escuela.sexos: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `sexos` DISABLE KEYS */;
INSERT INTO `sexos` (`sexo_id`, `cdescripcion_sexo`) VALUES
	(2, 'Femenino'),
	(1, 'Masculino');
/*!40000 ALTER TABLE `sexos` ENABLE KEYS */;

-- Volcando estructura para tabla db_escuela.telefonos
CREATE TABLE IF NOT EXISTS `telefonos` (
  `telefono_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ntipo_telefono` int(1) NOT NULL DEFAULT 1 COMMENT '1 - telefono celular\r\n2 - telefono fijo\r\n3 -otro tipo',
  `cnumero_telefono` varchar(20) NOT NULL,
  `rela_persona_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`telefono_id`),
  KEY `rela_persona_id` (`rela_persona_id`),
  CONSTRAINT `FK_telefonos_personas` FOREIGN KEY (`rela_persona_id`) REFERENCES `personas` (`persona_id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COMMENT='Almacena Informacion sobre los Telefonos de las personas';

-- Volcando datos para la tabla db_escuela.telefonos: ~3 rows (aproximadamente)
/*!40000 ALTER TABLE `telefonos` DISABLE KEYS */;
INSERT INTO `telefonos` (`telefono_id`, `ntipo_telefono`, `cnumero_telefono`, `rela_persona_id`) VALUES
	(1, 1, '3704567890', 1),
	(2, 1, '765432178', 2),
	(3, 1, '3718765843', 7);
/*!40000 ALTER TABLE `telefonos` ENABLE KEYS */;

-- Volcando estructura para tabla db_escuela.tipos_documentos
CREATE TABLE IF NOT EXISTS `tipos_documentos` (
  `tipodocumento_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `cdescripcion_tipodocumento` varchar(50) NOT NULL DEFAULT '0',
  `ccarpeta_documento` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`tipodocumento_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1 COMMENT='almacena informacion sobre los tipos de documentos que se pueden almacenar';

-- Volcando datos para la tabla db_escuela.tipos_documentos: ~3 rows (aproximadamente)
/*!40000 ALTER TABLE `tipos_documentos` DISABLE KEYS */;
INSERT INTO `tipos_documentos` (`tipodocumento_id`, `cdescripcion_tipodocumento`, `ccarpeta_documento`) VALUES
	(12, 'renuncia', 'renuncia'),
	(13, 'alta', 'alta'),
	(14, 'baja', 'baja');
/*!40000 ALTER TABLE `tipos_documentos` ENABLE KEYS */;

-- Volcando estructura para tabla db_escuela.trayectos
CREATE TABLE IF NOT EXISTS `trayectos` (
  `trayecto_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `cdescripcion_trayecto` varchar(50) NOT NULL,
  PRIMARY KEY (`trayecto_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COMMENT='almacena informacion sobre los trayectos escolares';

-- Volcando datos para la tabla db_escuela.trayectos: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `trayectos` DISABLE KEYS */;
INSERT INTO `trayectos` (`trayecto_id`, `cdescripcion_trayecto`) VALUES
	(1, 'ghjk'),
	(2, 'bnm');
/*!40000 ALTER TABLE `trayectos` ENABLE KEYS */;

-- Volcando estructura para tabla db_escuela.usuarios
CREATE TABLE IF NOT EXISTS `usuarios` (
  `usuario_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `cnombre_usuario` varchar(100) NOT NULL,
  `cemail_usuario` varchar(100) NOT NULL,
  `cpassword_usuario` varchar(100) NOT NULL,
  `nestado_usuario` int(1) unsigned NOT NULL DEFAULT 1 COMMENT '1 - activo \r\n2 - inactivo',
  `cimg_usuario` varchar(100) DEFAULT NULL,
  `rela_rol_id` bigint(20) unsigned NOT NULL DEFAULT 20,
  PRIMARY KEY (`usuario_id`),
  KEY `rela_rol_id` (`rela_rol_id`),
  KEY `cemail_usuario` (`cemail_usuario`),
  CONSTRAINT `FK_usuarios_roles` FOREIGN KEY (`rela_rol_id`) REFERENCES `roles` (`rol_id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COMMENT='Almacena la informacion de los usuarios del sistema';

-- Volcando datos para la tabla db_escuela.usuarios: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` (`usuario_id`, `cnombre_usuario`, `cemail_usuario`, `cpassword_usuario`, `nestado_usuario`, `cimg_usuario`, `rela_rol_id`) VALUES
	(4, 'Administrador', 'admin@admin', '$2y$10$N3NeFU6iXTSCcEIILvIUXukNqikwI9J./uDQS9LZDngJtyRhTf8Fm', 1, 'default.png', 1);
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
