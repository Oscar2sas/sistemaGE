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
  
  include ($absolute_include."modelos/reportesListadosAlumnos/model.reporteslistadosalumnos.php");   // se incluye el modelo de reportes listados alumnos



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

    reportes_listados_alumnos_index();

  }elseif ($accion == "obtener_curso_division_alumnos") {
    obtener_curso_division_alumnos($_POST);
  }elseif ($accion = "imprimir_reporte_listado_alumnos") {
    imprimir_reporte_listado_alumnos($_REQUEST['parametros_reporte_listado_alumno'], $_REQUEST['ano_lectivo']);
  }

// ===============================================================================
// FUNCION QUE INTERACTUAN CON EL MODELO
// ===============================================================================

// Funcion para que el controlador muestre las opciones que podra elegir
  function reportes_listados_alumnos_index(){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    $claseActivoReportesListadosAlumnos = true;

    $resultAnoLectivos = mostrar_anos_lectivos();

    include $absolute_include."vistas/reportesListadosAlumnos/index.php";

  }

  function obtener_curso_division_alumnos($arg_POST){
    $arg_POST = json_decode($arg_POST['datosDivisionAlumnos']);

    $id_ano_lectivo = $arg_POST->idCicloLectivoListadosReportesAlumnos;
    $result_curso_division_alumnos = buscar_division_alumnos_ano_lectivo($id_ano_lectivo);

    if (!empty($result_curso_division_alumnos)) {

      $result_tabla_reportes_listados_alumnos = armar_tabla_reportes_listados_alumnos($result_curso_division_alumnos);

      $respuestaCursoDivisionAlumnos = array('estado' => true,'mensaje' => $result_tabla_reportes_listados_alumnos);


    }else{
      $respuestaCursoDivisionAlumnos = array('estado' => false,'mensaje' => 'EL AÑO LECTIVO SELECCIONANDO NO POSEE ALUMNOS, POR FAVOR VERIFIQUE');

    }
    echo json_encode($respuestaCursoDivisionAlumnos);
  }

  function imprimir_reporte_listado_alumnos($arg_id_estado_alumnos, $arg_ano_lectivo){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];


    $arg_id_estado_alumnos = json_decode($arg_id_estado_alumnos);
    $arg_ano_lectivo = json_decode($arg_ano_lectivo);
    $result_alumnos_segun_estado = array();

    for ($i=0; $i < count($arg_id_estado_alumnos); $i++) { 
      array_push($result_alumnos_segun_estado, obtener_alumnos_segun_estado($arg_id_estado_alumnos[$i]));
    }

  // var_dump($result_alumnos_segun_estado);
    include $absolute_include."vistas/reportesListadosAlumnos/imprimirReporteListadoAlumno.php";

  }