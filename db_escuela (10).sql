-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-08-2022 a las 16:01:30
-- Versión del servidor: 10.4.22-MariaDB
-- Versión de PHP: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `db_escuela`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumnos`
--

CREATE TABLE `alumnos` (
  `alumno_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `cnumlegajo_alumno` varchar(20) DEFAULT NULL,
  `cestado_legajo` varchar(50) NOT NULL,
  `nsituacion_alumno` int(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT '1 - activo \r\n2 - inactivo',
  `cobservaciones_alumno` varchar(255) NOT NULL,
  `balumno_regular` int(1) UNSIGNED NOT NULL DEFAULT 1,
  `rela_estadoalumno_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `rela_persona_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `rela_persona_id_tutor1` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `rela_persona_id_tutor2` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `rela_persona_id_tutor3` bigint(20) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Almacena informacion sobre los Alumnos de la escuela';

--
-- Volcado de datos para la tabla `alumnos`
--

INSERT INTO `alumnos` (`alumno_id`, `cnumlegajo_alumno`, `cestado_legajo`, `nsituacion_alumno`, `cobservaciones_alumno`, `balumno_regular`, `rela_estadoalumno_id`, `rela_persona_id`, `rela_persona_id_tutor1`, `rela_persona_id_tutor2`, `rela_persona_id_tutor3`) VALUES
(0, '033333', '0', 1, '', 1, 2, 3, 7, 6, 0),
(1, '0987', '0', 1, '', 1, 1, 1, 1, 1, 0),
(2, '763', '', 1, '', 1, 2, 7, 1, 3, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `anos_lectivos`
--

CREATE TABLE `anos_lectivos` (
  `anolectivo_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `ndescripcion_anolectivo` int(4) NOT NULL DEFAULT 0,
  `dfechainicio_anolectivo` date NOT NULL,
  `dfechafinclases_anolectivo` date NOT NULL,
  `dfechafin_anolectivo` date NOT NULL,
  `bactivo_anolectivo` int(1) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Almacena Informacion sobre los Años Lectivos' ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `anos_lectivos`
--

INSERT INTO `anos_lectivos` (`anolectivo_id`, `ndescripcion_anolectivo`, `dfechainicio_anolectivo`, `dfechafinclases_anolectivo`, `dfechafin_anolectivo`, `bactivo_anolectivo`) VALUES
(1, 2020, '2020-03-11', '2020-12-11', '2020-08-19', 0),
(2, 2021, '2020-03-02', '2020-12-11', '2020-12-22', 0),
(3, 2022, '2022-03-03', '2022-12-27', '2022-12-31', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `barrios`
--

CREATE TABLE `barrios` (
  `barrio_id` bigint(20) UNSIGNED NOT NULL,
  `cnombre_barrio` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Almacena Informacion sobre los Barrios de una localidad';

--
-- Volcado de datos para la tabla `barrios`
--

INSERT INTO `barrios` (`barrio_id`, `cnombre_barrio`) VALUES
(1, 'B° El Palomar'),
(2, 'Simon bolivar');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calendario`
--

CREATE TABLE `calendario` (
  `calendario_id` bigint(20) UNSIGNED NOT NULL,
  `dfecha_calendario` date NOT NULL,
  `cdescripcion_calendario` varchar(100) NOT NULL,
  `rela_anolectivo_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Almacena infromacion sobre el calendario del año lectivo';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calles`
--

CREATE TABLE `calles` (
  `calle_id` bigint(20) UNSIGNED NOT NULL,
  `cnombre_calle` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Almacena Informacion sobre las calles';

--
-- Volcado de datos para la tabla `calles`
--

INSERT INTO `calles` (`calle_id`, `cnombre_calle`) VALUES
(2, 'Av. Maradona 1200'),
(1, 'Juan José Paso');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cargos`
--

CREATE TABLE `cargos` (
  `cargol_id` bigint(20) UNSIGNED NOT NULL,
  `cdescripcion_cargo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='almacena inform acion sobre los cargos del personal' ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `cargos`
--

INSERT INTO `cargos` (`cargol_id`, `cdescripcion_cargo`) VALUES
(1, 'administrativo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carreras`
--

CREATE TABLE `carreras` (
  `carrera_id` bigint(20) UNSIGNED NOT NULL,
  `cdescripcion_carrera` varchar(50) NOT NULL,
  `netapastemporales_carrera` int(1) UNSIGNED DEFAULT 1 COMMENT 'cantidad de etapas del año escolar',
  `cdescripcionetapatemporal_carrera` varchar(50) NOT NULL COMMENT 'descripcion de la etapa . Ej: TRIMESTRE.'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Almacena Informacion sobre las carreras que se dictan en la institucion' ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `carreras`
--

INSERT INTO `carreras` (`carrera_id`, `cdescripcion_carrera`, `netapastemporales_carrera`, `cdescripcionetapatemporal_carrera`) VALUES
(1, 'CBT', 3, 'Ciclo Básico Técnico'),
(2, 'Informática', 4, 'Informática'),
(3, 'Programación', 4, 'Programación'),
(4, 'Mecánica', 4, 'Mecánica automotriz');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cursos`
--

CREATE TABLE `cursos` (
  `curso_id` bigint(20) UNSIGNED NOT NULL,
  `cdescripcion_curso` varchar(50) NOT NULL,
  `rela_carrera_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Almacena Informacion sobre las cursos que se encuentan en la institucion' ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `cursos`
--

INSERT INTO `cursos` (`curso_id`, `cdescripcion_curso`, `rela_carrera_id`) VALUES
(1, '1I', 1),
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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cursos_horarios`
--

CREATE TABLE `cursos_horarios` (
  `cursoshorarios_id` bigint(20) UNSIGNED NOT NULL,
  `cdescripcion_cursohorario` varchar(50) NOT NULL,
  `cdias_horario` varchar(7) NOT NULL DEFAULT '0000000',
  `rela_curso_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `rela_trayecto_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `rela_preceptor_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `bhorario_activo` int(1) UNSIGNED NOT NULL COMMENT '1 - activo'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Almacena informacion sobre los horarios de los cursos';

--
-- Volcado de datos para la tabla `cursos_horarios`
--

INSERT INTO `cursos_horarios` (`cursoshorarios_id`, `cdescripcion_cursohorario`, `cdias_horario`, `rela_curso_id`, `rela_trayecto_id`, `rela_preceptor_id`, `bhorario_activo`) VALUES
(1, 'Horario 1I', '1111100', 1, 1, 1, 1),
(2, 'Horario 1II', '1111100', 2, 2, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cursos_horarios_materias`
--

CREATE TABLE `cursos_horarios_materias` (
  `cursoshorariosmaterias_id` bigint(20) UNSIGNED NOT NULL,
  `ndia_cursohorariomateria` int(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT '1 - lunes \r\n2 - martes \r\n3 - miercoles \r\n4 -jueves \r\n5 -viernes \r\n6 - sabado \r\n0 - domingo  \r\n\r\ncomo en php\r\n\r\n',
  `rela_cursohorarios_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `rela_curso_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `rela_trayecto_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `rela_materia_id_modulo1` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `rela_docente_id1` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `nsituacion_docente1` int(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT '1 - titular  2 - interino  3 - suplente ',
  `rela_materia_id_modulo2` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `rela_docente_id2` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `nsituacion_docente2` int(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT '1 - titular  2 - interino  3 - suplente ',
  `rela_materia_id_modulo3` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `rela_docente_id3` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `nsituacion_docente3` int(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT '1 - titular  2 - interino  3 - suplente ',
  `rela_materia_id_modulo4` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `rela_docente_id4` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `nsituacion_docente4` int(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT '1 - titular  2 - interino  3 - suplente ',
  `rela_materia_id_modulo5` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `rela_docente_id5` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `nsituacion_docente5` int(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT '1 - titular  2 - interino  3 - suplente ',
  `rela_materia_id_modulo6` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `rela_docente_id6` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `nsituacion_docente6` int(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT '1 - titular  2 - interino  3 - suplente ',
  `rela_materia_id_modulo7` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `rela_docente_id7` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `nsituacion_docente7` int(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT '1 - titular  2 - interino  3 - suplente ',
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
  `nvalor_inasistencia` decimal(3,2) UNSIGNED NOT NULL DEFAULT 1.00,
  `bhorario_activo` int(1) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Almacena informacion sobre los horarios de los cursos y las materias' ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `cursos_horarios_materias`
--

INSERT INTO `cursos_horarios_materias` (`cursoshorariosmaterias_id`, `ndia_cursohorariomateria`, `rela_cursohorarios_id`, `rela_curso_id`, `rela_trayecto_id`, `rela_materia_id_modulo1`, `rela_docente_id1`, `nsituacion_docente1`, `rela_materia_id_modulo2`, `rela_docente_id2`, `nsituacion_docente2`, `rela_materia_id_modulo3`, `rela_docente_id3`, `nsituacion_docente3`, `rela_materia_id_modulo4`, `rela_docente_id4`, `nsituacion_docente4`, `rela_materia_id_modulo5`, `rela_docente_id5`, `nsituacion_docente5`, `rela_materia_id_modulo6`, `rela_docente_id6`, `nsituacion_docente6`, `rela_materia_id_modulo7`, `rela_docente_id7`, `nsituacion_docente7`, `chora_desdemodulo1`, `chora_hastamodulo1`, `chora_desdemodulo2`, `chora_hastamodulo2`, `chora_desdemodulo3`, `chora_hastamodulo3`, `chora_desdemodulo4`, `chora_hastamodulo4`, `chora_desdemodulo5`, `chora_hastamodulo5`, `chora_desdemodulo6`, `chora_hastamodulo6`, `chora_desdemodulo7`, `chora_hastamodulo7`, `nvalor_inasistencia`, `bhorario_activo`) VALUES
(1, 1, 1, 1, 2, 2, 3, 1, 1, 3, 1, 1, 3, 1, 1, 3, 1, 2, 3, 1, 2, 3, 1, 2, 3, 1, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '1.00', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cursos_materias`
--

CREATE TABLE `cursos_materias` (
  `cursosmaterias_id` bigint(20) UNSIGNED NOT NULL,
  `rela_curso_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `rela_materia_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Almacena informacion sobre los materias de los cursos' ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `cursos_materias`
--

INSERT INTO `cursos_materias` (`cursosmaterias_id`, `rela_curso_id`, `rela_materia_id`) VALUES
(1, 1, 1),
(2, 1, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `direcciones`
--

CREATE TABLE `direcciones` (
  `direccion_id` bigint(20) UNSIGNED NOT NULL,
  `cmanzana_direccion` varchar(4) NOT NULL,
  `ccasa_direccion` varchar(4) NOT NULL,
  `csector_direccion` varchar(4) NOT NULL,
  `clote_direccion` varchar(4) NOT NULL,
  `cparcela_direccion` varchar(4) NOT NULL,
  `cdescripcion_direccion` varchar(50) NOT NULL,
  `rela_calle_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `rela_barrio_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `rela_localidad_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `rela_persona_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Almacena las direcciones de las personas';

--
-- Volcado de datos para la tabla `direcciones`
--

INSERT INTO `direcciones` (`direccion_id`, `cmanzana_direccion`, `ccasa_direccion`, `csector_direccion`, `clote_direccion`, `cparcela_direccion`, `cdescripcion_direccion`, `rela_calle_id`, `rela_barrio_id`, `rela_localidad_id`, `rela_persona_id`) VALUES
(1, '34', '6', '2', '5', '6', '', 1, 1, 1, 1),
(2, '34', '51', '0', '0', '0', '-', 2, 1, 1, 2),
(3, '32', '20', '0', '0', '0', '-', 2, 1, 1, 7),
(4, '34', '51', '0', '0', '0', '-', 1, 2, 1, 6),
(5, '32', '20', '0', '0', '0', '-', 2, 2, 1, 4),
(6, '32', '20', '0', '0', '0', '-', 2, 1, 1, 3),
(7, '34', '20', '0', '0', '0', '-', 1, 1, 1, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `divisiones`
--

CREATE TABLE `divisiones` (
  `division_id` bigint(20) UNSIGNED NOT NULL,
  `rela_curso_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `rela_anolectivo_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Almacena Informacion sobre las divisiones con alumnos' ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `divisiones`
--

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `divisiones_alumnos`
--

CREATE TABLE `divisiones_alumnos` (
  `division_id` bigint(20) UNSIGNED NOT NULL,
  `rela_anolectivo_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `rela_curso_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `rela_alumno_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `ncantidad_reincorporacion` int(10) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Almacena Informacion sobre las divisiones con alumnos' ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `divisiones_alumnos`
--

INSERT INTO `divisiones_alumnos` (`division_id`, `rela_anolectivo_id`, `rela_curso_id`, `rela_alumno_id`, `ncantidad_reincorporacion`) VALUES
(1, 3, 1, 1, 0),
(2, 3, 1, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `divisiones_horarios_materias`
--

CREATE TABLE `divisiones_horarios_materias` (
  `divisionhorario_id` bigint(20) UNSIGNED NOT NULL,
  `dfecha_horario` date NOT NULL,
  `rela_cursohorario_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `rela_anolectivo_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `rela_curso_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `rela_trayecto_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `rela_preceptor_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `ndia_cursohorariomateria` int(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT '1 - lunes \r\n2 - martes \r\n3 - miercoles \r\n4 -jueves \r\n5 -viernes \r\n6 - sabado \r\n0 - domingo  \r\n\r\ncomo en php\r\n\r\n',
  `rela_materia_id_modulo1` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `rela_docente_id1` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `nsituacion_docente1` int(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT '1 - titular  2 - interino  3 - suplente ',
  `bdocente_presente1` int(1) UNSIGNED NOT NULL DEFAULT 1,
  `rela_materia_id_modulo2` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `rela_docente_id2` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `nsituacion_docente2` int(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT '1 - titular  2 - interino  3 - suplente ',
  `bdocente_presente2` int(1) UNSIGNED NOT NULL DEFAULT 1,
  `rela_materia_id_modulo3` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `rela_docente_id3` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `nsituacion_docente3` int(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT '1 - titular  2 - interino  3 - suplente ',
  `bdocente_presente3` int(1) UNSIGNED NOT NULL DEFAULT 1,
  `rela_materia_id_modulo4` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `rela_docente_id4` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `nsituacion_docente4` int(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT '1 - titular  2 - interino  3 - suplente ',
  `bdocente_presente4` int(1) UNSIGNED NOT NULL DEFAULT 1,
  `rela_materia_id_modulo5` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `rela_docente_id5` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `nsituacion_docente5` int(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT '1 - titular  2 - interino  3 - suplente ',
  `bdocente_presente5` int(1) UNSIGNED NOT NULL DEFAULT 1,
  `rela_materia_id_modulo6` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `rela_docente_id6` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `nsituacion_docente6` int(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT '1 - titular  2 - interino  3 - suplente ',
  `bdocente_presente6` int(1) UNSIGNED NOT NULL DEFAULT 1,
  `rela_materia_id_modulo7` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `rela_docente_id7` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `nsituacion_docente7` int(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT '1 - titular  2 - interino  3 - suplente ',
  `bdocente_presente7` int(1) UNSIGNED NOT NULL DEFAULT 1,
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
  `nvalor_inasistencia` decimal(3,2) UNSIGNED NOT NULL DEFAULT 1.00
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Almacena informacion sobre los horarios de las divisiones ,la fecha y la asistencia del profesor' ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `divisiones_horarios_materias`
--

INSERT INTO `divisiones_horarios_materias` (`divisionhorario_id`, `dfecha_horario`, `rela_cursohorario_id`, `rela_anolectivo_id`, `rela_curso_id`, `rela_trayecto_id`, `rela_preceptor_id`, `ndia_cursohorariomateria`, `rela_materia_id_modulo1`, `rela_docente_id1`, `nsituacion_docente1`, `bdocente_presente1`, `rela_materia_id_modulo2`, `rela_docente_id2`, `nsituacion_docente2`, `bdocente_presente2`, `rela_materia_id_modulo3`, `rela_docente_id3`, `nsituacion_docente3`, `bdocente_presente3`, `rela_materia_id_modulo4`, `rela_docente_id4`, `nsituacion_docente4`, `bdocente_presente4`, `rela_materia_id_modulo5`, `rela_docente_id5`, `nsituacion_docente5`, `bdocente_presente5`, `rela_materia_id_modulo6`, `rela_docente_id6`, `nsituacion_docente6`, `bdocente_presente6`, `rela_materia_id_modulo7`, `rela_docente_id7`, `nsituacion_docente7`, `bdocente_presente7`, `chora_desdemodulo1`, `chora_hastamodulo1`, `chora_desdemodulo2`, `chora_hastamodulo2`, `chora_desdemodulo3`, `chora_hastamodulo3`, `chora_desdemodulo4`, `chora_hastamodulo4`, `chora_desdemodulo5`, `chora_hastamodulo5`, `chora_desdemodulo6`, `chora_hastamodulo6`, `chora_desdemodulo7`, `chora_hastamodulo7`, `nvalor_inasistencia`) VALUES
(1, '2022-08-26', 1, 3, 1, 1, 1, 1, 2, 5, 1, 1, 2, 5, 1, 1, 2, 5, 1, 1, 2, 5, 1, 1, 2, 5, 1, 1, 2, 5, 1, 1, 2, 5, 1, 1, '14:00', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '17:00', '0.50'),
(7, '2022-08-26', 1, 3, 2, 1, 1, 1, 1, 3, 1, 1, 1, 3, 1, 1, 1, 3, 1, 1, 1, 3, 1, 1, 1, 3, 1, 1, 1, 3, 1, 1, 1, 3, 1, 1, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0.50');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `divisiones_inasistencias`
--

CREATE TABLE `divisiones_inasistencias` (
  `divisioninasistencia_id` bigint(20) UNSIGNED NOT NULL,
  `dfecha_inasistencia` date NOT NULL,
  `binasistencia_justificada` int(1) UNSIGNED NOT NULL DEFAULT 0,
  `rela_anolectivo_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `rela_curso_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `rela_trayecto_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `rela_alumno_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `rela_documentos_personas_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `btardanza_asistencia` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Almacena Informacion sobre las inasistencias de los alumnos' ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `docentes`
--

CREATE TABLE `docentes` (
  `docente_id` bigint(20) UNSIGNED NOT NULL,
  `nsituacion_docente` int(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT '1 - activo \r\n2 - inactivo',
  `cnumlegajo_docente` varchar(50) DEFAULT NULL,
  `cnumregistro_docente` varchar(50) DEFAULT NULL,
  `cestado_legajo` varchar(50) NOT NULL,
  `cobservaciones_docente` varchar(255) NOT NULL,
  `rela_persona_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `rela_estadodocente_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Almacena Informacion sobre los Docentes';

--
-- Volcado de datos para la tabla `docentes`
--

INSERT INTO `docentes` (`docente_id`, `nsituacion_docente`, `cnumlegajo_docente`, `cnumregistro_docente`, `cestado_legajo`, `cobservaciones_docente`, `rela_persona_id`, `rela_estadodocente_id`) VALUES
(3, 1, '980', '909', '', '', 1, 1),
(5, 1, '398', '121', '', '', 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documentos_personas`
--

CREATE TABLE `documentos_personas` (
  `documento_id` bigint(20) UNSIGNED NOT NULL,
  `rela_tipodocumento_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `rela_persona_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `cimg_documento` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='almacena documentos digitalizados de las personas';

--
-- Volcado de datos para la tabla `documentos_personas`
--

INSERT INTO `documentos_personas` (`documento_id`, `rela_tipodocumento_id`, `rela_persona_id`, `cimg_documento`) VALUES
(1, 13, 1, 'Buenos dias');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documentos_varios`
--

CREATE TABLE `documentos_varios` (
  `documento_id` bigint(20) UNSIGNED NOT NULL,
  `rela_tipodocumento_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `cnombre_documento` varchar(100) DEFAULT NULL,
  `cdescripcion_documento` varchar(100) DEFAULT NULL,
  `dfecha_documento` date DEFAULT NULL,
  `rruta` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='almacena documentos de la institucion' ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `documentos_varios`
--

INSERT INTO `documentos_varios` (`documento_id`, `rela_tipodocumento_id`, `cnombre_documento`, `cdescripcion_documento`, `dfecha_documento`, `rruta`) VALUES
(45, 13, 'PRÃCTICAS PROFESIONALIZANTES.docx', 'jhin', '2020-09-14', '../../storage/documentos/alta/PRÃCTICAS PROFESIONALIZANTES.docx');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_alumnos`
--

CREATE TABLE `estado_alumnos` (
  `estadoalumno_id` bigint(20) UNSIGNED NOT NULL,
  `cdescripcion_estadoalumno` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Almacena Informacion sobre el estado en la institucion de los alumnos';

--
-- Volcado de datos para la tabla `estado_alumnos`
--

INSERT INTO `estado_alumnos` (`estadoalumno_id`, `cdescripcion_estadoalumno`) VALUES
(3, 'libre'),
(2, 'regular'),
(1, 'reincorporado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_docentes`
--

CREATE TABLE `estado_docentes` (
  `estadodocente_id` bigint(20) UNSIGNED NOT NULL,
  `cdescripcion_estadodocente` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Almacena Informacion sobre el estado en la institucion de los docentes' ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `estado_docentes`
--

INSERT INTO `estado_docentes` (`estadodocente_id`, `cdescripcion_estadodocente`) VALUES
(1, 'activo'),
(2, 'inactivo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `etapas_escolares`
--

CREATE TABLE `etapas_escolares` (
  `etapaescolar_id` bigint(20) UNSIGNED NOT NULL,
  `cdescripcion_etapa` varchar(50) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Almacena Informacion sobre las etapas escolares vigentes';

--
-- Volcado de datos para la tabla `etapas_escolares`
--

INSERT INTO `etapas_escolares` (`etapaescolar_id`, `cdescripcion_etapa`) VALUES
(1, 'Primer Trismestre'),
(2, 'Segundo Trimestre'),
(3, 'Tercer Trimestre'),
(4, 'Diciembre'),
(5, 'Febrero'),
(6, 'Primer Cuatrimestre'),
(7, 'Segundo Cuatrimestre');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `examenes`
--

CREATE TABLE `examenes` (
  `examen_id` bigint(20) UNSIGNED NOT NULL,
  `rela_anolectivo_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `rela_curso_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `rela_materia_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `rela_alumno_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `rela_etapaescolar_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `dfecha_examen` date NOT NULL,
  `ncalificacion` decimal(10,2) UNSIGNED NOT NULL DEFAULT 0.00,
  `rela_docente_id_1` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `rela_docente_id_2` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `rela_docente_id_3` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `nnumacta_examen` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `nanoacta_examen` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `nnumlibro_examen` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `nnumfolio_examen` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `nnumpagina_examen` int(10) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Almacena informacion sobre los examenes de los alumnos' ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historiales_alumnos`
--

CREATE TABLE `historiales_alumnos` (
  `historialalumno_id` bigint(20) UNSIGNED NOT NULL,
  `dfecha_historial` date NOT NULL,
  `historial_alumno` longtext NOT NULL,
  `rela_alumno_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='almacena informacion del historial del alumno';

--
-- Volcado de datos para la tabla `historiales_alumnos`
--

INSERT INTO `historiales_alumnos` (`historialalumno_id`, `dfecha_historial`, `historial_alumno`, `rela_alumno_id`) VALUES
(2, '2020-09-03', 'ads10\r\nads20\r\n\r\n', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historiales_docentes`
--

CREATE TABLE `historiales_docentes` (
  `historialdocente_id` bigint(20) UNSIGNED NOT NULL,
  `dfecha_historial` date NOT NULL,
  `historial_docente` longtext NOT NULL,
  `rela_docente_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='almacena informacion del historial del docente' ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `historiales_docentes`
--

INSERT INTO `historiales_docentes` (`historialdocente_id`, `dfecha_historial`, `historial_docente`, `rela_docente_id`) VALUES
(4, '2020-09-09', 'jhin\r\n', 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historiales_personal`
--

CREATE TABLE `historiales_personal` (
  `historialpersonal_id` bigint(20) UNSIGNED NOT NULL,
  `dfecha_historial` date NOT NULL,
  `historial_personal` longtext NOT NULL,
  `rela_personal_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='almacena informacion del historial del personal' ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `historiales_personal`
--

INSERT INTO `historiales_personal` (`historialpersonal_id`, `dfecha_historial`, `historial_personal`, `rela_personal_id`) VALUES
(3, '2020-07-20', 'jhinso', 2),
(6, '0000-00-00', 'adsa', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `localidades`
--

CREATE TABLE `localidades` (
  `localidad_id` bigint(20) UNSIGNED NOT NULL,
  `cnombre_localidad` varchar(50) NOT NULL,
  `rela_provincia_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Almacena Informacion sobre las Localidades/Pueblos de una Provincia';

--
-- Volcado de datos para la tabla `localidades`
--

INSERT INTO `localidades` (`localidad_id`, `cnombre_localidad`, `rela_provincia_id`) VALUES
(1, 'Formosa', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `log`
--

CREATE TABLE `log` (
  `log_id` bigint(20) UNSIGNED NOT NULL,
  `dfecha_log` date NOT NULL,
  `chora_log` time NOT NULL,
  `cdescripcion_log` varchar(255) NOT NULL,
  `rela_usuario_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Almacena Informacion sobre las actividades de los usuarios';

--
-- Volcado de datos para la tabla `log`
--

INSERT INTO `log` (`log_id`, `dfecha_log`, `chora_log`, `cdescripcion_log`, `rela_usuario_id`) VALUES
(1, '2022-05-20', '09:59:38', ' Ingreso el sistema : Administrador con ID: 4', 4),
(2, '2022-06-15', '12:54:48', ' Ingreso el sistema : Administrador con ID: 4', 4),
(3, '2022-06-19', '15:02:14', ' Ingreso el sistema : Administrador con ID: 4', 4),
(4, '2022-06-21', '08:05:21', ' Ingreso el sistema : Administrador con ID: 4', 4),
(5, '2022-06-22', '08:06:53', ' Ingreso el sistema : Administrador con ID: 4', 4),
(6, '2022-06-24', '08:13:37', ' Ingreso el sistema : Administrador con ID: 4', 4),
(7, '2022-06-24', '08:47:05', ' Ingreso el sistema : Administrador con ID: 4', 4),
(8, '2022-06-24', '08:53:06', ' Ingreso el sistema : Administrador con ID: 4', 4),
(9, '2022-06-24', '09:02:22', ' Ingreso el sistema : Administrador con ID: 4', 4),
(10, '2022-06-24', '09:07:30', ' Ingreso el sistema : Administrador con ID: 4', 4),
(11, '2022-06-24', '09:11:08', ' Ingreso el sistema : Administrador con ID: 4', 4),
(12, '2022-06-24', '09:13:22', ' Ingreso el sistema : Administrador con ID: 4', 4),
(13, '2022-06-24', '09:17:45', ' Ingreso el sistema : Administrador con ID: 4', 4),
(14, '2022-06-24', '10:18:27', ' Ingreso el sistema : Administrador con ID: 4', 4),
(15, '2022-07-15', '08:16:26', ' Ingreso el sistema : Administrador con ID: 4', 4),
(16, '2022-07-15', '08:56:42', ' Ingreso el sistema : Administrador con ID: 4', 4),
(17, '2022-07-15', '08:59:34', ' Ingreso el sistema : Administrador con ID: 4', 4),
(18, '2022-07-15', '09:18:38', ' Ingreso el sistema : Administrador con ID: 4', 4),
(19, '2022-08-05', '07:38:32', ' Ingreso el sistema : Administrador con ID: 4', 4),
(20, '2022-08-05', '08:10:09', ' Ingreso el sistema : Administrador con ID: 4', 4),
(21, '2022-08-12', '07:58:17', ' Ingreso el sistema : Administrador con ID: 4', 4),
(22, '2022-08-17', '08:45:50', ' Ingreso el sistema : Administrador con ID: 4', 4),
(23, '2022-08-19', '07:43:09', ' Ingreso el sistema : Administrador con ID: 4', 4),
(24, '2022-08-19', '09:42:51', ' Ingreso el sistema : Administrador con ID: 4', 4),
(25, '2022-08-26', '08:06:15', ' Ingreso el sistema : Administrador con ID: 4', 4),
(26, '2022-08-26', '08:41:20', ' Ingreso el sistema : Administrador con ID: 4', 4),
(27, '2022-08-26', '08:42:14', ' Ingreso el sistema : Administrador con ID: 4', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materias`
--

CREATE TABLE `materias` (
  `materia_id` bigint(20) UNSIGNED NOT NULL,
  `cnombre_materia` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Almacena Informacion sobre las materias que se dictan en la institucion' ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `materias`
--

INSERT INTO `materias` (`materia_id`, `cnombre_materia`) VALUES
(2, 'inglés'),
(1, 'lengua');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notas`
--

CREATE TABLE `notas` (
  `notas_id` bigint(20) UNSIGNED NOT NULL,
  `rela_anolectivo_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `rela_curso_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `rela_materia_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `rela_etapaescolar_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `rela_alumno_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `ncalificacion` decimal(10,2) UNSIGNED NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Almacena informacion sobrelas notas de los alumnos' ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `notas`
--

INSERT INTO `notas` (`notas_id`, `rela_anolectivo_id`, `rela_curso_id`, `rela_materia_id`, `rela_etapaescolar_id`, `rela_alumno_id`, `ncalificacion`) VALUES
(1, 1, 1, 1, 1, 1, '10.00'),
(2, 2, 6, 2, 1, 1, '8.00'),
(3, 2, 7, 2, 6, 1, '7.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paises`
--

CREATE TABLE `paises` (
  `pais_id` bigint(20) UNSIGNED NOT NULL,
  `cnombre_pais` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Almacena Informacion sobre los paises';

--
-- Volcado de datos para la tabla `paises`
--

INSERT INTO `paises` (`pais_id`, `cnombre_pais`) VALUES
(1, 'ARGENTINA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `parametros`
--

CREATE TABLE `parametros` (
  `nmaximo_inasitencias` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `nvalor_reincorporacion` int(10) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='almacena parametros para el funcionamiento del sistema';

--
-- Volcado de datos para la tabla `parametros`
--

INSERT INTO `parametros` (`nmaximo_inasitencias`, `nvalor_reincorporacion`) VALUES
(15, 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personales`
--

CREATE TABLE `personales` (
  `personal_id` bigint(20) UNSIGNED NOT NULL,
  `cnumlegajo_personal` varchar(50) NOT NULL,
  `nsituacion_personal` int(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT '1 - activo \r\n2 - inactivo',
  `cobservaciones_personal` varchar(255) NOT NULL,
  `rela_persona_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `rela_cargo_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Almacena Informacion sobre el personal de la institucion' ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `personales`
--

INSERT INTO `personales` (`personal_id`, `cnumlegajo_personal`, `nsituacion_personal`, `cobservaciones_personal`, `rela_persona_id`, `rela_cargo_id`) VALUES
(2, '816', 1, '', 1, 1),
(3, '344', 1, '', 6, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personas`
--

CREATE TABLE `personas` (
  `persona_id` bigint(20) UNSIGNED NOT NULL,
  `capellidos_persona` varchar(100) NOT NULL,
  `cnombres_persona` varchar(100) NOT NULL,
  `ndni_persona` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `ncuil_persona` int(11) DEFAULT NULL,
  `cemail_persona` varchar(100) DEFAULT NULL,
  `dfechanac_persona` date DEFAULT NULL,
  `rela_sexo_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Almacena Informacion sobre las personas que interactuan con la institucion';

--
-- Volcado de datos para la tabla `personas`
--

INSERT INTO `personas` (`persona_id`, `capellidos_persona`, `cnombres_persona`, `ndni_persona`, `ncuil_persona`, `cemail_persona`, `dfechanac_persona`, `rela_sexo_id`) VALUES
(1, 'Gonzalez', 'Gabriel', 43807013, 2043807013, 'gabriel240901gmail.com', '2001-09-24', 1),
(2, 'Perez', 'Juan David', 908567432, 21, 'perezjuan90@gmail.com', '1992-07-15', 1),
(3, 'Rodriguez', 'Pedro Fabian', 988768430, 204, 'rodriguezzzefe@gmail.com', '2020-09-09', 1),
(4, 'Martinez', 'Alan Jacinto', 986765048, 178, 'kbgfdudn@gmail.com', '2020-09-08', 1),
(5, 'Rosario', 'Florencia Luisa', 964986455, 987654052, 'lakshjfywndh@hotmail.com', '2020-09-07', 2),
(6, 'Tato', 'Gaspar Marcelo', 954187654, 987, 'laksyuwmhdhd@yahoo.com', '2020-09-06', 1),
(7, 'Gimenez', 'Gerardo Marcos', 876548765, 754, 'hybdsujhbvyufi@gmail.com', '2020-09-05', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `preceptores`
--

CREATE TABLE `preceptores` (
  `preceptor_id` bigint(20) UNSIGNED NOT NULL,
  `nsituacion_preceptor` int(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT '1 - activo \r\n2 - inactivo',
  `rela_persona_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Almacena Informacion sobre los preceptores de la institucion' ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `preceptores`
--

INSERT INTO `preceptores` (`preceptor_id`, `nsituacion_preceptor`, `rela_persona_id`) VALUES
(1, 1, 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `provincias`
--

CREATE TABLE `provincias` (
  `provincia_id` bigint(20) UNSIGNED NOT NULL,
  `cnombre_provincia` varchar(50) NOT NULL,
  `rela_pais_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Almacena Informacion sobre las Provincias/Estados de un pais';

--
-- Volcado de datos para la tabla `provincias`
--

INSERT INTO `provincias` (`provincia_id`, `cnombre_provincia`, `rela_pais_id`) VALUES
(1, 'Cuidad de Formosa', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `rol_id` bigint(20) UNSIGNED NOT NULL,
  `cdescripcion_rol` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Administra los roles de usuarios';

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`rol_id`, `cdescripcion_rol`) VALUES
(1, 'ADMINSTRADOR'),
(20, 'INVITADO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sexos`
--

CREATE TABLE `sexos` (
  `sexo_id` bigint(20) UNSIGNED NOT NULL,
  `cdescripcion_sexo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Alamcena los diferentes sexos de las personas';

--
-- Volcado de datos para la tabla `sexos`
--

INSERT INTO `sexos` (`sexo_id`, `cdescripcion_sexo`) VALUES
(2, 'Femenino'),
(1, 'Masculino');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `telefonos`
--

CREATE TABLE `telefonos` (
  `telefono_id` bigint(20) UNSIGNED NOT NULL,
  `ntipo_telefono` int(1) NOT NULL DEFAULT 1 COMMENT '1 - telefono celular\r\n2 - telefono fijo\r\n3 -otro tipo',
  `cnumero_telefono` varchar(20) NOT NULL,
  `rela_persona_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Almacena Informacion sobre los Telefonos de las personas';

--
-- Volcado de datos para la tabla `telefonos`
--

INSERT INTO `telefonos` (`telefono_id`, `ntipo_telefono`, `cnumero_telefono`, `rela_persona_id`) VALUES
(1, 1, '3704567890', 1),
(2, 1, '765432178', 2),
(3, 1, '3718765843', 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_documentos`
--

CREATE TABLE `tipos_documentos` (
  `tipodocumento_id` bigint(20) UNSIGNED NOT NULL,
  `cdescripcion_tipodocumento` varchar(50) NOT NULL DEFAULT '0',
  `ccarpeta_documento` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='almacena informacion sobre los tipos de documentos que se pueden almacenar';

--
-- Volcado de datos para la tabla `tipos_documentos`
--

INSERT INTO `tipos_documentos` (`tipodocumento_id`, `cdescripcion_tipodocumento`, `ccarpeta_documento`) VALUES
(12, 'renuncia', 'renuncia'),
(13, 'alta', 'alta'),
(14, 'baja', 'baja');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trayectos`
--

CREATE TABLE `trayectos` (
  `trayecto_id` bigint(20) UNSIGNED NOT NULL,
  `cdescripcion_trayecto` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='almacena informacion sobre los trayectos escolares';

--
-- Volcado de datos para la tabla `trayectos`
--

INSERT INTO `trayectos` (`trayecto_id`, `cdescripcion_trayecto`) VALUES
(1, 'CBT'),
(2, 'CST');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `usuario_id` bigint(20) UNSIGNED NOT NULL,
  `cnombre_usuario` varchar(100) NOT NULL,
  `cemail_usuario` varchar(100) NOT NULL,
  `cpassword_usuario` varchar(100) NOT NULL,
  `nestado_usuario` int(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT '1 - activo \r\n2 - inactivo',
  `cimg_usuario` varchar(100) DEFAULT NULL,
  `rela_rol_id` bigint(20) UNSIGNED NOT NULL DEFAULT 20
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Almacena la informacion de los usuarios del sistema';

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`usuario_id`, `cnombre_usuario`, `cemail_usuario`, `cpassword_usuario`, `nestado_usuario`, `cimg_usuario`, `rela_rol_id`) VALUES
(4, 'Administrador', 'admin@admin', '$2y$10$N3NeFU6iXTSCcEIILvIUXukNqikwI9J./uDQS9LZDngJtyRhTf8Fm', 1, 'default.png', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alumnos`
--
ALTER TABLE `alumnos`
  ADD PRIMARY KEY (`alumno_id`),
  ADD KEY `rela_estadoalumno_id` (`rela_estadoalumno_id`),
  ADD KEY `rela_persona_id` (`rela_persona_id`),
  ADD KEY `rela_persona_id_tutor1` (`rela_persona_id_tutor1`),
  ADD KEY `rela_persona_id_tutor2` (`rela_persona_id_tutor2`),
  ADD KEY `rela_persona_id_tutor3` (`rela_persona_id_tutor3`);

--
-- Indices de la tabla `anos_lectivos`
--
ALTER TABLE `anos_lectivos`
  ADD PRIMARY KEY (`anolectivo_id`) USING BTREE,
  ADD KEY `cdescripcion_anolectivo` (`ndescripcion_anolectivo`) USING BTREE;

--
-- Indices de la tabla `barrios`
--
ALTER TABLE `barrios`
  ADD PRIMARY KEY (`barrio_id`),
  ADD KEY `nombre_barrio` (`cnombre_barrio`) USING BTREE;

--
-- Indices de la tabla `calendario`
--
ALTER TABLE `calendario`
  ADD PRIMARY KEY (`calendario_id`),
  ADD KEY `rela_anolectivo_id` (`rela_anolectivo_id`),
  ADD KEY `dfecha_calendario` (`dfecha_calendario`);

--
-- Indices de la tabla `calles`
--
ALTER TABLE `calles`
  ADD PRIMARY KEY (`calle_id`),
  ADD KEY `nombre_calle` (`cnombre_calle`) USING BTREE;

--
-- Indices de la tabla `cargos`
--
ALTER TABLE `cargos`
  ADD PRIMARY KEY (`cargol_id`) USING BTREE,
  ADD KEY `cdescripcion_cargo` (`cdescripcion_cargo`) USING BTREE;

--
-- Indices de la tabla `carreras`
--
ALTER TABLE `carreras`
  ADD PRIMARY KEY (`carrera_id`) USING BTREE,
  ADD KEY `cdescripcion_ciclolectivo` (`cdescripcion_carrera`) USING BTREE;

--
-- Indices de la tabla `cursos`
--
ALTER TABLE `cursos`
  ADD PRIMARY KEY (`curso_id`) USING BTREE,
  ADD KEY `cdescripcion_curso` (`cdescripcion_curso`) USING BTREE,
  ADD KEY `rela_carrera_id` (`rela_carrera_id`);

--
-- Indices de la tabla `cursos_horarios`
--
ALTER TABLE `cursos_horarios`
  ADD PRIMARY KEY (`cursoshorarios_id`),
  ADD KEY `rela_curso_id` (`rela_curso_id`),
  ADD KEY `rela_trayecto_id` (`rela_trayecto_id`),
  ADD KEY `rela_peceptor_id` (`rela_preceptor_id`) USING BTREE;

--
-- Indices de la tabla `cursos_horarios_materias`
--
ALTER TABLE `cursos_horarios_materias`
  ADD PRIMARY KEY (`cursoshorariosmaterias_id`) USING BTREE,
  ADD KEY `rela_curso_id` (`rela_curso_id`),
  ADD KEY `rela_trayecto_id` (`rela_trayecto_id`),
  ADD KEY `curso-trayecto-dia` (`rela_curso_id`,`rela_trayecto_id`,`ndia_cursohorariomateria`),
  ADD KEY `rela_materia_id_modulo1` (`rela_materia_id_modulo1`),
  ADD KEY `rela_materia_id_modulo2` (`rela_materia_id_modulo2`),
  ADD KEY `rela_materia_id_modulo3` (`rela_materia_id_modulo3`),
  ADD KEY `rela_materia_id_modulo4` (`rela_materia_id_modulo4`),
  ADD KEY `rela_materia_id_modulo5` (`rela_materia_id_modulo5`),
  ADD KEY `rela_materia_id_modulo6` (`rela_materia_id_modulo6`),
  ADD KEY `rela_materia_id_modulo7` (`rela_materia_id_modulo7`),
  ADD KEY `rela_docente_id1` (`rela_docente_id1`),
  ADD KEY `rela_docente_id2` (`rela_docente_id2`),
  ADD KEY `rela_docente_id3` (`rela_docente_id3`),
  ADD KEY `rela_docente_id4` (`rela_docente_id4`),
  ADD KEY `rela_docente_id6` (`rela_docente_id6`),
  ADD KEY `rela_docente_id5` (`rela_docente_id5`),
  ADD KEY `rela_docente_id7` (`rela_docente_id7`),
  ADD KEY `rela_cursohorarios_id` (`rela_cursohorarios_id`);

--
-- Indices de la tabla `cursos_materias`
--
ALTER TABLE `cursos_materias`
  ADD PRIMARY KEY (`cursosmaterias_id`) USING BTREE,
  ADD KEY `rela_curso_id` (`rela_curso_id`) USING BTREE,
  ADD KEY `rela_materia_id` (`rela_materia_id`);

--
-- Indices de la tabla `direcciones`
--
ALTER TABLE `direcciones`
  ADD PRIMARY KEY (`direccion_id`),
  ADD KEY `rela_calle_id` (`rela_calle_id`),
  ADD KEY `rela_barrio_id` (`rela_barrio_id`),
  ADD KEY `rela_localidad_id` (`rela_localidad_id`),
  ADD KEY `rela_persona_id` (`rela_persona_id`);

--
-- Indices de la tabla `divisiones`
--
ALTER TABLE `divisiones`
  ADD PRIMARY KEY (`division_id`) USING BTREE,
  ADD KEY `cdescripcion_ciclolectivo` (`rela_curso_id`) USING BTREE,
  ADD KEY `rela_anolectivo_id` (`rela_anolectivo_id`) USING BTREE;

--
-- Indices de la tabla `divisiones_alumnos`
--
ALTER TABLE `divisiones_alumnos`
  ADD PRIMARY KEY (`division_id`) USING BTREE,
  ADD KEY `cdescripcion_ciclolectivo` (`rela_curso_id`) USING BTREE,
  ADD KEY `rela_anolectivo_id` (`rela_anolectivo_id`) USING BTREE,
  ADD KEY `rela_alumno_id` (`rela_alumno_id`);

--
-- Indices de la tabla `divisiones_horarios_materias`
--
ALTER TABLE `divisiones_horarios_materias`
  ADD PRIMARY KEY (`divisionhorario_id`) USING BTREE,
  ADD KEY `rela_curso_id` (`rela_curso_id`) USING BTREE,
  ADD KEY `rela_trayecto_id` (`rela_trayecto_id`) USING BTREE,
  ADD KEY `rela_peceptor_id` (`rela_preceptor_id`) USING BTREE,
  ADD KEY `rela_anolectivo_id` (`rela_anolectivo_id`) USING BTREE,
  ADD KEY `rela_cursohorario_id` (`rela_cursohorario_id`) USING BTREE,
  ADD KEY `dfecha_horario` (`dfecha_horario`) USING BTREE;

--
-- Indices de la tabla `divisiones_inasistencias`
--
ALTER TABLE `divisiones_inasistencias`
  ADD PRIMARY KEY (`divisioninasistencia_id`) USING BTREE,
  ADD KEY `cdescripcion_ciclolectivo` (`rela_curso_id`) USING BTREE,
  ADD KEY `rela_anolectivo_id` (`rela_anolectivo_id`) USING BTREE,
  ADD KEY `rela_alumno_id` (`rela_alumno_id`) USING BTREE,
  ADD KEY `rela_trayecto_id` (`rela_trayecto_id`),
  ADD KEY `dfecha_asistencia` (`dfecha_inasistencia`) USING BTREE,
  ADD KEY `rela_documentos_personas_id` (`rela_documentos_personas_id`);

--
-- Indices de la tabla `docentes`
--
ALTER TABLE `docentes`
  ADD PRIMARY KEY (`docente_id`),
  ADD KEY `rela_persona_id` (`rela_persona_id`),
  ADD KEY `rela_estadodocente_id` (`rela_estadodocente_id`) USING BTREE;

--
-- Indices de la tabla `documentos_personas`
--
ALTER TABLE `documentos_personas`
  ADD PRIMARY KEY (`documento_id`) USING BTREE,
  ADD KEY `rela_tipodocumento_id` (`rela_tipodocumento_id`),
  ADD KEY `rela_persona_id` (`rela_persona_id`) USING BTREE;

--
-- Indices de la tabla `documentos_varios`
--
ALTER TABLE `documentos_varios`
  ADD PRIMARY KEY (`documento_id`) USING BTREE,
  ADD KEY `rela_tipodocumento_id` (`rela_tipodocumento_id`) USING BTREE,
  ADD KEY `dfecha_documento` (`dfecha_documento`),
  ADD KEY `cdescripcion_documento` (`cdescripcion_documento`);

--
-- Indices de la tabla `estado_alumnos`
--
ALTER TABLE `estado_alumnos`
  ADD PRIMARY KEY (`estadoalumno_id`),
  ADD KEY `cdescripcion_estadoalumno` (`cdescripcion_estadoalumno`);

--
-- Indices de la tabla `estado_docentes`
--
ALTER TABLE `estado_docentes`
  ADD PRIMARY KEY (`estadodocente_id`) USING BTREE,
  ADD KEY `cdescripcion_estadoalumno` (`cdescripcion_estadodocente`) USING BTREE;

--
-- Indices de la tabla `etapas_escolares`
--
ALTER TABLE `etapas_escolares`
  ADD PRIMARY KEY (`etapaescolar_id`);

--
-- Indices de la tabla `examenes`
--
ALTER TABLE `examenes`
  ADD PRIMARY KEY (`examen_id`) USING BTREE,
  ADD KEY `rela_curso_id` (`rela_curso_id`) USING BTREE,
  ADD KEY `rela_materia_id` (`rela_materia_id`) USING BTREE,
  ADD KEY `rela_anolectivo_id` (`rela_anolectivo_id`) USING BTREE,
  ADD KEY `rela_etapaescolar_id` (`rela_etapaescolar_id`) USING BTREE,
  ADD KEY `rela_docente_id_1` (`rela_docente_id_1`),
  ADD KEY `rela_docente_id_2` (`rela_docente_id_2`),
  ADD KEY `rela_docente_id_3` (`rela_docente_id_3`),
  ADD KEY `rela_alumno_id` (`rela_alumno_id`);

--
-- Indices de la tabla `historiales_alumnos`
--
ALTER TABLE `historiales_alumnos`
  ADD PRIMARY KEY (`historialalumno_id`),
  ADD KEY `dfecha_historial` (`dfecha_historial`),
  ADD KEY `rela_alumno_id` (`rela_alumno_id`);

--
-- Indices de la tabla `historiales_docentes`
--
ALTER TABLE `historiales_docentes`
  ADD PRIMARY KEY (`historialdocente_id`) USING BTREE,
  ADD KEY `dfecha_historial` (`dfecha_historial`) USING BTREE,
  ADD KEY `rela_docente_id` (`rela_docente_id`) USING BTREE;

--
-- Indices de la tabla `historiales_personal`
--
ALTER TABLE `historiales_personal`
  ADD PRIMARY KEY (`historialpersonal_id`) USING BTREE,
  ADD KEY `dfecha_historial` (`dfecha_historial`) USING BTREE,
  ADD KEY `rela_personal_id` (`rela_personal_id`) USING BTREE;

--
-- Indices de la tabla `localidades`
--
ALTER TABLE `localidades`
  ADD PRIMARY KEY (`localidad_id`),
  ADD KEY `nombre_localidad` (`cnombre_localidad`) USING BTREE,
  ADD KEY `rela_provincia_id` (`rela_provincia_id`) USING BTREE;

--
-- Indices de la tabla `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `rela_usuario_id` (`rela_usuario_id`),
  ADD KEY `dfechahora` (`dfecha_log`,`chora_log`);

--
-- Indices de la tabla `materias`
--
ALTER TABLE `materias`
  ADD PRIMARY KEY (`materia_id`) USING BTREE,
  ADD KEY `cdescripcion_ciclolectivo` (`cnombre_materia`) USING BTREE;

--
-- Indices de la tabla `notas`
--
ALTER TABLE `notas`
  ADD PRIMARY KEY (`notas_id`) USING BTREE,
  ADD KEY `rela_curso_id` (`rela_curso_id`) USING BTREE,
  ADD KEY `rela_materia_id` (`rela_materia_id`) USING BTREE,
  ADD KEY `rela_anolectivo_id` (`rela_anolectivo_id`),
  ADD KEY `rela_etapaescolar_id` (`rela_etapaescolar_id`),
  ADD KEY `rela_alumno_id` (`rela_alumno_id`);

--
-- Indices de la tabla `paises`
--
ALTER TABLE `paises`
  ADD PRIMARY KEY (`pais_id`),
  ADD KEY `nombre_pais` (`cnombre_pais`) USING BTREE;

--
-- Indices de la tabla `personales`
--
ALTER TABLE `personales`
  ADD PRIMARY KEY (`personal_id`) USING BTREE,
  ADD KEY `rela_persona_id` (`rela_persona_id`) USING BTREE,
  ADD KEY `rela_cargo_id` (`rela_cargo_id`) USING BTREE;

--
-- Indices de la tabla `personas`
--
ALTER TABLE `personas`
  ADD PRIMARY KEY (`persona_id`),
  ADD KEY `nombrecompleto` (`capellidos_persona`,`cnombres_persona`) USING BTREE,
  ADD KEY `ndni_persona` (`ndni_persona`),
  ADD KEY `ccuil_persona` (`ncuil_persona`) USING BTREE,
  ADD KEY `rela_sexo_id` (`rela_sexo_id`);

--
-- Indices de la tabla `preceptores`
--
ALTER TABLE `preceptores`
  ADD PRIMARY KEY (`preceptor_id`) USING BTREE,
  ADD KEY `rela_persona_id` (`rela_persona_id`) USING BTREE;

--
-- Indices de la tabla `provincias`
--
ALTER TABLE `provincias`
  ADD PRIMARY KEY (`provincia_id`),
  ADD KEY `nombre_provincia` (`cnombre_provincia`) USING BTREE,
  ADD KEY `rela_pais_id` (`rela_pais_id`) USING BTREE;

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`rol_id`),
  ADD KEY `cdescripcion_rol` (`cdescripcion_rol`);

--
-- Indices de la tabla `sexos`
--
ALTER TABLE `sexos`
  ADD PRIMARY KEY (`sexo_id`),
  ADD KEY `cdescripcion_sexo` (`cdescripcion_sexo`);

--
-- Indices de la tabla `telefonos`
--
ALTER TABLE `telefonos`
  ADD PRIMARY KEY (`telefono_id`),
  ADD KEY `rela_persona_id` (`rela_persona_id`);

--
-- Indices de la tabla `tipos_documentos`
--
ALTER TABLE `tipos_documentos`
  ADD PRIMARY KEY (`tipodocumento_id`);

--
-- Indices de la tabla `trayectos`
--
ALTER TABLE `trayectos`
  ADD PRIMARY KEY (`trayecto_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`usuario_id`),
  ADD KEY `rela_rol_id` (`rela_rol_id`),
  ADD KEY `cemail_usuario` (`cemail_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `barrios`
--
ALTER TABLE `barrios`
  MODIFY `barrio_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `calendario`
--
ALTER TABLE `calendario`
  MODIFY `calendario_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `calles`
--
ALTER TABLE `calles`
  MODIFY `calle_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `cargos`
--
ALTER TABLE `cargos`
  MODIFY `cargol_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `carreras`
--
ALTER TABLE `carreras`
  MODIFY `carrera_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `cursos`
--
ALTER TABLE `cursos`
  MODIFY `curso_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `cursos_horarios`
--
ALTER TABLE `cursos_horarios`
  MODIFY `cursoshorarios_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `cursos_horarios_materias`
--
ALTER TABLE `cursos_horarios_materias`
  MODIFY `cursoshorariosmaterias_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `cursos_materias`
--
ALTER TABLE `cursos_materias`
  MODIFY `cursosmaterias_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `direcciones`
--
ALTER TABLE `direcciones`
  MODIFY `direccion_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `divisiones`
--
ALTER TABLE `divisiones`
  MODIFY `division_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `divisiones_alumnos`
--
ALTER TABLE `divisiones_alumnos`
  MODIFY `division_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `divisiones_horarios_materias`
--
ALTER TABLE `divisiones_horarios_materias`
  MODIFY `divisionhorario_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `divisiones_inasistencias`
--
ALTER TABLE `divisiones_inasistencias`
  MODIFY `divisioninasistencia_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=139;

--
-- AUTO_INCREMENT de la tabla `docentes`
--
ALTER TABLE `docentes`
  MODIFY `docente_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `documentos_personas`
--
ALTER TABLE `documentos_personas`
  MODIFY `documento_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `documentos_varios`
--
ALTER TABLE `documentos_varios`
  MODIFY `documento_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT de la tabla `estado_alumnos`
--
ALTER TABLE `estado_alumnos`
  MODIFY `estadoalumno_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `estado_docentes`
--
ALTER TABLE `estado_docentes`
  MODIFY `estadodocente_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `etapas_escolares`
--
ALTER TABLE `etapas_escolares`
  MODIFY `etapaescolar_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `examenes`
--
ALTER TABLE `examenes`
  MODIFY `examen_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `historiales_alumnos`
--
ALTER TABLE `historiales_alumnos`
  MODIFY `historialalumno_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `historiales_docentes`
--
ALTER TABLE `historiales_docentes`
  MODIFY `historialdocente_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `historiales_personal`
--
ALTER TABLE `historiales_personal`
  MODIFY `historialpersonal_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `localidades`
--
ALTER TABLE `localidades`
  MODIFY `localidad_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `log`
--
ALTER TABLE `log`
  MODIFY `log_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de la tabla `materias`
--
ALTER TABLE `materias`
  MODIFY `materia_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `notas`
--
ALTER TABLE `notas`
  MODIFY `notas_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `paises`
--
ALTER TABLE `paises`
  MODIFY `pais_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `personales`
--
ALTER TABLE `personales`
  MODIFY `personal_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `personas`
--
ALTER TABLE `personas`
  MODIFY `persona_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `preceptores`
--
ALTER TABLE `preceptores`
  MODIFY `preceptor_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `provincias`
--
ALTER TABLE `provincias`
  MODIFY `provincia_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `rol_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `sexos`
--
ALTER TABLE `sexos`
  MODIFY `sexo_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `telefonos`
--
ALTER TABLE `telefonos`
  MODIFY `telefono_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tipos_documentos`
--
ALTER TABLE `tipos_documentos`
  MODIFY `tipodocumento_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `trayectos`
--
ALTER TABLE `trayectos`
  MODIFY `trayecto_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `usuario_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `alumnos`
--
ALTER TABLE `alumnos`
  ADD CONSTRAINT `FK_alumnos_estado_alumnos` FOREIGN KEY (`rela_estadoalumno_id`) REFERENCES `estado_alumnos` (`estadoalumno_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_alumnos_personas` FOREIGN KEY (`rela_persona_id`) REFERENCES `personas` (`persona_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_alumnos_personas_2` FOREIGN KEY (`rela_persona_id_tutor1`) REFERENCES `personas` (`persona_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_alumnos_personas_3` FOREIGN KEY (`rela_persona_id_tutor2`) REFERENCES `personas` (`persona_id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `calendario`
--
ALTER TABLE `calendario`
  ADD CONSTRAINT `FK__anos_lectivos` FOREIGN KEY (`rela_anolectivo_id`) REFERENCES `anos_lectivos` (`anolectivo_id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `cursos`
--
ALTER TABLE `cursos`
  ADD CONSTRAINT `FK_cursos_carreras` FOREIGN KEY (`rela_carrera_id`) REFERENCES `carreras` (`carrera_id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `cursos_horarios`
--
ALTER TABLE `cursos_horarios`
  ADD CONSTRAINT `FK_cursos_horarios_cursos` FOREIGN KEY (`rela_curso_id`) REFERENCES `cursos` (`curso_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_cursos_horarios_preceptores` FOREIGN KEY (`rela_preceptor_id`) REFERENCES `preceptores` (`preceptor_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_cursos_horarios_trayectos` FOREIGN KEY (`rela_trayecto_id`) REFERENCES `trayectos` (`trayecto_id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `cursos_horarios_materias`
--
ALTER TABLE `cursos_horarios_materias`
  ADD CONSTRAINT `FK_cursos_horarios_materias_cursos` FOREIGN KEY (`rela_curso_id`) REFERENCES `cursos` (`curso_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_cursos_horarios_materias_cursos_horarios` FOREIGN KEY (`rela_cursohorarios_id`) REFERENCES `cursos_horarios` (`cursoshorarios_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_cursos_horarios_materias_docentes` FOREIGN KEY (`rela_docente_id1`) REFERENCES `docentes` (`docente_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_cursos_horarios_materias_docentes_2` FOREIGN KEY (`rela_docente_id2`) REFERENCES `docentes` (`docente_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_cursos_horarios_materias_docentes_3` FOREIGN KEY (`rela_docente_id3`) REFERENCES `docentes` (`docente_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_cursos_horarios_materias_docentes_4` FOREIGN KEY (`rela_docente_id4`) REFERENCES `docentes` (`docente_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_cursos_horarios_materias_docentes_5` FOREIGN KEY (`rela_docente_id5`) REFERENCES `docentes` (`docente_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_cursos_horarios_materias_docentes_6` FOREIGN KEY (`rela_docente_id6`) REFERENCES `docentes` (`docente_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_cursos_horarios_materias_docentes_7` FOREIGN KEY (`rela_docente_id7`) REFERENCES `docentes` (`docente_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_cursos_horarios_materias_materias` FOREIGN KEY (`rela_materia_id_modulo1`) REFERENCES `materias` (`materia_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_cursos_horarios_materias_materias_2` FOREIGN KEY (`rela_materia_id_modulo2`) REFERENCES `materias` (`materia_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_cursos_horarios_materias_materias_3` FOREIGN KEY (`rela_materia_id_modulo3`) REFERENCES `materias` (`materia_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_cursos_horarios_materias_materias_4` FOREIGN KEY (`rela_materia_id_modulo4`) REFERENCES `materias` (`materia_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_cursos_horarios_materias_materias_5` FOREIGN KEY (`rela_materia_id_modulo5`) REFERENCES `materias` (`materia_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_cursos_horarios_materias_materias_6` FOREIGN KEY (`rela_materia_id_modulo6`) REFERENCES `materias` (`materia_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_cursos_horarios_materias_materias_7` FOREIGN KEY (`rela_materia_id_modulo7`) REFERENCES `materias` (`materia_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_cursos_horarios_materias_trayectos` FOREIGN KEY (`rela_trayecto_id`) REFERENCES `trayectos` (`trayecto_id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `cursos_materias`
--
ALTER TABLE `cursos_materias`
  ADD CONSTRAINT `FK_cursos_materias_cursos` FOREIGN KEY (`rela_curso_id`) REFERENCES `cursos` (`curso_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_cursos_materias_materias` FOREIGN KEY (`rela_materia_id`) REFERENCES `materias` (`materia_id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `direcciones`
--
ALTER TABLE `direcciones`
  ADD CONSTRAINT `FK_direcciones_barrios` FOREIGN KEY (`rela_barrio_id`) REFERENCES `barrios` (`barrio_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_direcciones_calles` FOREIGN KEY (`rela_calle_id`) REFERENCES `calles` (`calle_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_direcciones_localidades` FOREIGN KEY (`rela_localidad_id`) REFERENCES `localidades` (`localidad_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_direcciones_personas` FOREIGN KEY (`rela_persona_id`) REFERENCES `personas` (`persona_id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `divisiones`
--
ALTER TABLE `divisiones`
  ADD CONSTRAINT `FK_divisiones_anos_lectivos` FOREIGN KEY (`rela_anolectivo_id`) REFERENCES `anos_lectivos` (`anolectivo_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_divisiones_cursos` FOREIGN KEY (`rela_curso_id`) REFERENCES `cursos` (`curso_id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `divisiones_alumnos`
--
ALTER TABLE `divisiones_alumnos`
  ADD CONSTRAINT `FK_divisiones_alumnos_alumnos` FOREIGN KEY (`rela_alumno_id`) REFERENCES `alumnos` (`alumno_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_divisiones_alumnos_anos_lectivos` FOREIGN KEY (`rela_anolectivo_id`) REFERENCES `anos_lectivos` (`anolectivo_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_divisiones_alumnos_cursos` FOREIGN KEY (`rela_curso_id`) REFERENCES `cursos` (`curso_id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `divisiones_horarios_materias`
--
ALTER TABLE `divisiones_horarios_materias`
  ADD CONSTRAINT `FK_divisiones_horarios_materias_anos_lectivos` FOREIGN KEY (`rela_anolectivo_id`) REFERENCES `anos_lectivos` (`anolectivo_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_divisiones_horarios_materias_cursos` FOREIGN KEY (`rela_curso_id`) REFERENCES `cursos` (`curso_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_divisiones_horarios_materias_cursos_horarios` FOREIGN KEY (`rela_cursohorario_id`) REFERENCES `cursos_horarios` (`cursoshorarios_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_divisiones_horarios_materias_docentes` FOREIGN KEY (`rela_docente_id1`) REFERENCES `docentes` (`docente_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_divisiones_horarios_materias_docentes_2` FOREIGN KEY (`rela_docente_id2`) REFERENCES `docentes` (`docente_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_divisiones_horarios_materias_docentes_3` FOREIGN KEY (`rela_docente_id3`) REFERENCES `docentes` (`docente_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_divisiones_horarios_materias_docentes_4` FOREIGN KEY (`rela_docente_id4`) REFERENCES `docentes` (`docente_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_divisiones_horarios_materias_docentes_5` FOREIGN KEY (`rela_docente_id5`) REFERENCES `docentes` (`docente_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_divisiones_horarios_materias_docentes_6` FOREIGN KEY (`rela_docente_id6`) REFERENCES `docentes` (`docente_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_divisiones_horarios_materias_docentes_7` FOREIGN KEY (`rela_docente_id7`) REFERENCES `docentes` (`docente_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_divisiones_horarios_materias_materias` FOREIGN KEY (`rela_materia_id_modulo1`) REFERENCES `materias` (`materia_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_divisiones_horarios_materias_materias_2` FOREIGN KEY (`rela_materia_id_modulo2`) REFERENCES `materias` (`materia_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_divisiones_horarios_materias_materias_3` FOREIGN KEY (`rela_materia_id_modulo3`) REFERENCES `materias` (`materia_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_divisiones_horarios_materias_materias_4` FOREIGN KEY (`rela_materia_id_modulo4`) REFERENCES `materias` (`materia_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_divisiones_horarios_materias_materias_5` FOREIGN KEY (`rela_materia_id_modulo5`) REFERENCES `materias` (`materia_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_divisiones_horarios_materias_materias_6` FOREIGN KEY (`rela_materia_id_modulo6`) REFERENCES `materias` (`materia_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_divisiones_horarios_materias_materias_7` FOREIGN KEY (`rela_materia_id_modulo7`) REFERENCES `materias` (`materia_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_divisiones_horarios_materias_preceptores` FOREIGN KEY (`rela_preceptor_id`) REFERENCES `preceptores` (`preceptor_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_divisiones_horarios_materias_trayectos` FOREIGN KEY (`rela_trayecto_id`) REFERENCES `trayectos` (`trayecto_id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `divisiones_inasistencias`
--
ALTER TABLE `divisiones_inasistencias`
  ADD CONSTRAINT `FK_divisiones_asistencias_alumnos` FOREIGN KEY (`rela_alumno_id`) REFERENCES `alumnos` (`alumno_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_divisiones_asistencias_anos_lectivos` FOREIGN KEY (`rela_anolectivo_id`) REFERENCES `anos_lectivos` (`anolectivo_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_divisiones_asistencias_cursos` FOREIGN KEY (`rela_curso_id`) REFERENCES `cursos` (`curso_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_divisiones_asistencias_trayectos` FOREIGN KEY (`rela_trayecto_id`) REFERENCES `trayectos` (`trayecto_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_divisiones_inasistencias_documentos_personas` FOREIGN KEY (`rela_documentos_personas_id`) REFERENCES `documentos_personas` (`documento_id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `docentes`
--
ALTER TABLE `docentes`
  ADD CONSTRAINT `FK_docentes_estado_docentes` FOREIGN KEY (`rela_estadodocente_id`) REFERENCES `estado_docentes` (`estadodocente_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_docentes_personas` FOREIGN KEY (`rela_persona_id`) REFERENCES `personas` (`persona_id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `documentos_personas`
--
ALTER TABLE `documentos_personas`
  ADD CONSTRAINT `FK_documentospersonas_personas` FOREIGN KEY (`rela_persona_id`) REFERENCES `personas` (`persona_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_documentospersonas_tiposdocumentos` FOREIGN KEY (`rela_tipodocumento_id`) REFERENCES `tipos_documentos` (`tipodocumento_id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `documentos_varios`
--
ALTER TABLE `documentos_varios`
  ADD CONSTRAINT `FK_documentos_varios_tipos_documentos` FOREIGN KEY (`rela_tipodocumento_id`) REFERENCES `tipos_documentos` (`tipodocumento_id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `examenes`
--
ALTER TABLE `examenes`
  ADD CONSTRAINT `FK_examenes_alumnos` FOREIGN KEY (`rela_alumno_id`) REFERENCES `alumnos` (`alumno_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_examenes_anos_lectivos` FOREIGN KEY (`rela_anolectivo_id`) REFERENCES `anos_lectivos` (`anolectivo_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_examenes_cursos` FOREIGN KEY (`rela_curso_id`) REFERENCES `cursos` (`curso_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_examenes_docentes` FOREIGN KEY (`rela_docente_id_1`) REFERENCES `docentes` (`docente_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_examenes_docentes_2` FOREIGN KEY (`rela_docente_id_2`) REFERENCES `docentes` (`docente_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_examenes_docentes_3` FOREIGN KEY (`rela_docente_id_3`) REFERENCES `docentes` (`docente_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_examenes_etapas_escolares` FOREIGN KEY (`rela_etapaescolar_id`) REFERENCES `etapas_escolares` (`etapaescolar_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_examenes_materias` FOREIGN KEY (`rela_materia_id`) REFERENCES `materias` (`materia_id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `historiales_alumnos`
--
ALTER TABLE `historiales_alumnos`
  ADD CONSTRAINT `FK_historiales_alumnos_alumnos` FOREIGN KEY (`rela_alumno_id`) REFERENCES `alumnos` (`alumno_id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `historiales_docentes`
--
ALTER TABLE `historiales_docentes`
  ADD CONSTRAINT `FK_historiales_docentes_docentes` FOREIGN KEY (`rela_docente_id`) REFERENCES `docentes` (`docente_id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `historiales_personal`
--
ALTER TABLE `historiales_personal`
  ADD CONSTRAINT `FK_historiales_personal_personales` FOREIGN KEY (`rela_personal_id`) REFERENCES `personales` (`personal_id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `localidades`
--
ALTER TABLE `localidades`
  ADD CONSTRAINT `FK_localidades_provincias` FOREIGN KEY (`rela_provincia_id`) REFERENCES `provincias` (`provincia_id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `log`
--
ALTER TABLE `log`
  ADD CONSTRAINT `FK_log_usuarios` FOREIGN KEY (`rela_usuario_id`) REFERENCES `usuarios` (`usuario_id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `notas`
--
ALTER TABLE `notas`
  ADD CONSTRAINT `FK_notas_alumnos` FOREIGN KEY (`rela_alumno_id`) REFERENCES `alumnos` (`alumno_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_notas_anos_lectivos` FOREIGN KEY (`rela_anolectivo_id`) REFERENCES `anos_lectivos` (`anolectivo_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_notas_cursos` FOREIGN KEY (`rela_curso_id`) REFERENCES `cursos` (`curso_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_notas_etapas_escolares` FOREIGN KEY (`rela_etapaescolar_id`) REFERENCES `etapas_escolares` (`etapaescolar_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_notas_materias` FOREIGN KEY (`rela_materia_id`) REFERENCES `materias` (`materia_id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `personales`
--
ALTER TABLE `personales`
  ADD CONSTRAINT `FK_personales_cargos` FOREIGN KEY (`rela_cargo_id`) REFERENCES `cargos` (`cargol_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_personales_personas` FOREIGN KEY (`rela_persona_id`) REFERENCES `personas` (`persona_id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `personas`
--
ALTER TABLE `personas`
  ADD CONSTRAINT `FK_personas_sexos` FOREIGN KEY (`rela_sexo_id`) REFERENCES `sexos` (`sexo_id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `preceptores`
--
ALTER TABLE `preceptores`
  ADD CONSTRAINT `FK_preceptores_personas` FOREIGN KEY (`rela_persona_id`) REFERENCES `personas` (`persona_id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `provincias`
--
ALTER TABLE `provincias`
  ADD CONSTRAINT `FK_provincias_paises` FOREIGN KEY (`rela_pais_id`) REFERENCES `paises` (`pais_id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `telefonos`
--
ALTER TABLE `telefonos`
  ADD CONSTRAINT `FK_telefonos_personas` FOREIGN KEY (`rela_persona_id`) REFERENCES `personas` (`persona_id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `FK_usuarios_roles` FOREIGN KEY (`rela_rol_id`) REFERENCES `roles` (`rol_id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
