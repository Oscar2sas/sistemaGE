<?php 

// seccion que permite resolver problemas de inclusion de archivos
$carpeta_trabajo="";
$seccion_trabajo="/controladores";

if (strpos($_SERVER["PHP_SELF"] , $seccion_trabajo) >1 ) {
   $carpeta_trabajo=substr($_SERVER["PHP_SELF"],1, strpos($_SERVER["PHP_SELF"] , $seccion_trabajo)-1);  // saca la carpeta de trabajo del sistema
}


  $absolute_include = str_repeat("../",substr_count($_SERVER["PHP_SELF"] , "/")-1).$carpeta_trabajo; //resuelve problemas de profundidad de carpetas

  if (!empty($carpeta_trabajo)) {
  	$absolute_include = $absolute_include."/";
  	$carpeta_trabajo = "/".$carpeta_trabajo;      
  }
  // fin seccion 


  require $absolute_include.'public/vendor/autoload.php';  // carga el archivo de librerias pdf

  use Spipu\Html2Pdf\Html2Pdf;   // carga la clase y la usa para generar pdf


  include ($absolute_include."config/global.php");   // variables de configuracion
  
  include ($absolute_include."clases/class.conexion.php");   // clase para conexion de base de datos

  include ($absolute_include."administracion/sesion.php") ;

  include ($absolute_include."modelos/log/model.log.php");   // para manejar los log
  
  include ($absolute_include."modelos/anoLectivos/model.anoslectivos.php");   // se incluye el modelo de ciclos lectivos

  include ($absolute_include."modelos/cursos/model.curso.php");   // se incluye el modelo de cursos

  include ($absolute_include."modelos/trayectos/model.trayecto.php");   // se incluye el modelo de trayectos
  
  include ($absolute_include."modelos/historialAlumnos/model.historialalumnos.php");   // se incluye el modelo de historial alumnos

  include ($absolute_include."modelos/alumnos/model.alumnos.php");   // se incluye el modelo de historial alumnos
  
  include ($absolute_include."modelos/asistenciaAlumnos/model.asistenciaalumnos.php");   // se incluye el modelo de historial alumnos
  
  include ($absolute_include."modelos/consultarAsistenciasAlumnos/model.consultarasistenciasalumnos.php");   // se incluye el modelo de historial alumnos
  
  include ($absolute_include."modelos/historialesAlumnos/model.historialesalumnos.php");   // se incluye el modelo de historial alumnos
  
  include ($absolute_include."modelos/cursosHorariosMaterias/model.cursoshorariosmaterias.php");   // se incluye el modelo de historial alumnos



  //verifica si se llamo a una accion determinada en el controlador
  $accion="";
// verifica si esta especificando un filtro
  $textoabuscar="";
  if (isset($_REQUEST['accion'])) {   // si existe una variable tipo REQUEST que llama a una accion / funcion

  	$accion=$_REQUEST['accion'];
  }

// Se valida si hay alguna accion enviada desde el front-end 
// en caso de que haya enviado la accion de tipo index
// o la accion este vacia
// se mostrara el listado de los alumnos para la asistencia 

  if ( $accion == "" OR $accion=="index" )  {

    // Se llama a la funcion para mostrara el listado de alumnos para la asistencia
  	registrar_tardanzas_alumnos_index();
  }elseif ($accion == "guardar_registro_tardanzas_alumnos") {

  	guardar_registro_tardanzas_alumnos($_POST);

  }
// ===============================================================================
// FUNCION QUE INTERACTUAN CON EL MODELO
// ===============================================================================


  function registrar_tardanzas_alumnos_index(){

  	$absolute_include = $GLOBALS['absolute_include'];
  	$carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

  	include $absolute_include."vistas/registrarTardanzasAlumnos/index.php";

  }

  function guardar_registro_tardanzas_alumnos($arg_POST){


  	$argDniAlumno = json_decode($arg_POST['datosGuardarRegistrarTardanzasAlumnos']);

  	if (!is_numeric($argDniAlumno)) {

  		$respuestaGuardadoRegistroTardanzaAlumnos = array('estado' => false,'mensaje' => "EL DNI INGRESADO NO ES UN NUMERO, POR FAVOR VERIFIQUE!");

  		echo json_encode($respuestaGuardadoRegistroTardanzaAlumnos);
  		return;
  	}

  	if (strlen($argDniAlumno) > 8) {
  		$respuestaGuardadoRegistroTardanzaAlumnos = array('estado' => false,'mensaje' => "EL DNI INGRESADO ES MAYOR A 8 DIGITOS, POR FAVOR VERIFIQUE!");
  		echo json_encode($respuestaGuardadoRegistroTardanzaAlumnos);
  		return;

  	}

  	if (strlen($argDniAlumno) < 8) {
  		$respuestaGuardadoRegistroTardanzaAlumnos = array('estado' => false,'mensaje' => "EL DNI INGRESADO ES MENOR A 8 DIGITOS, POR FAVOR VERIFIQUE!");
  		echo json_encode($respuestaGuardadoRegistroTardanzaAlumnos);
  		return;

  	}

  	$ano_lectivo_activo = buscar_Ano_Lectivo_Activo();

  	if (empty($ano_lectivo_activo)) {
  		$respuestaGuardadoRegistroTardanzaAlumnos = array('estado' => false,'mensaje' => "NO AHI NINGUN AÑO ACTIVO, POR FAVOR CONTACTE AL ADMINISTRADOR DEL SISTEMA!");

  		echo json_encode($respuestaGuardadoRegistroTardanzaAlumnos);


  		return;
  	}

  	$trayectos = obtenerTrayectos();

  	if (empty($trayectos)) {

  		$respuestaGuardadoRegistroTardanzaAlumnos = array('estado' => false,'mensaje' => "NO AHI NINGUN TRAYECTO CARGADO, POR FAVOR CONTACTE AL ADMINISTRADOR DEL SISTEMA!");

  		echo json_encode($respuestaGuardadoRegistroTardanzaAlumnos);

  		return;
  	}

  	$result_datos_alumnos = obtener_datos_alumnos_dni($argDniAlumno, $ano_lectivo_activo['anolectivo_id']);

  	if (empty($result_datos_alumnos)) {
  		$respuestaGuardadoRegistroTardanzaAlumnos = array('estado' => false,'mensaje' => "NO HAY NINGUN ALUMNO GUARDADO CON EL DNI INGRESADO POR FAVOR VERIFIQUE!");

  		echo json_encode($respuestaGuardadoRegistroTardanzaAlumnos);

  		return;
  	}

  	if ($result_datos_alumnos[0]['nsituacion_alumno'] != 1) {

  		$respuestaGuardadoRegistroTardanzaAlumnos = array('estado' => false,'mensaje' => "EL DNI INGRESADO ESTA INACTIVO, POR FAVOR VERIFIQUE!");

  		echo json_encode($respuestaGuardadoRegistroTardanzaAlumnos);

  		return;	
  	}

  	// verificar que el alumno tenga clases hoy

  	$fecha_actual = date('Y-m-d');

  	$result_id_trayecto_curso = obtenerTrayectosCursoDia($result_datos_alumnos[0]['rela_curso_id']);

  	$id_trayecto_filtrado;

  	foreach ($result_id_trayecto_curso['mensaje'] as $result_id_trayectos) {

  		if ($result_id_trayectos['idTrayecto'] != NULL) {
  			$id_trayecto_filtrado = $result_id_trayectos['idTrayecto'];
  		}
  	}

  	if (empty($id_trayecto_filtrado)) {
  		
  		$respuestaGuardadoRegistroTardanzaAlumnos = array('estado' => false,'mensaje' => "EL DNI INGRESADO NO POSEE CLASES HOY, POR FAVOR VERIFIQUE!");

  		echo json_encode($respuestaGuardadoRegistroTardanzaAlumnos);

  		return;	
  	}

  	// verificar que la tardanza del alumno no este marcado segun el trayecto

  	$result_tardanza_alumno = buscar_Tardanzas_Alumnos($fecha_actual, $ano_lectivo_activo['anolectivo_id'], $id_trayecto_filtrado, $result_datos_alumnos[0]['rela_curso_id']);

  	if (!empty($result_tardanza_alumno)) {
  		$respuestaGuardadoRegistroTardanzaAlumnos = array('estado' => false,'mensaje' => "EL DNI INGRESADO YA POSEE UNA TARDANZA EN EL TRAYECTO ACTUAL, POR FAVOR VERIFIQUE!");

  		echo json_encode($respuestaGuardadoRegistroTardanzaAlumnos);

  		return;	
  	}

  	// guardar la tardanza

  	$result_insertar_tardanza_alumno = insertar_Tardanza_Asistencia_Alumnos($fecha_actual, $ano_lectivo_activo['anolectivo_id'], $result_datos_alumnos[0]['rela_curso_id'], $id_trayecto_filtrado, $result_datos_alumnos[0]['alumno_id']);

  	$respuestaInsertRegistroTardanzaAlumnos = ($result_insertar_tardanza_alumno == true) ? 'Tardanza Registrada Correctamente' : 'Error Inasistencias Tardanzas';

  		$respuestaGuardadoRegistroTardanzaAlumnos = array('estado' => true,'mensaje' =>$respuestaInsertRegistroTardanzaAlumnos);


  	echo json_encode($respuestaGuardadoRegistroTardanzaAlumnos);

  }

