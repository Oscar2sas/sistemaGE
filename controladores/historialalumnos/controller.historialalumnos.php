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
    historial_alumnos_index();
  }elseif ($accion == "obtener_division_alumnos") {

    $datosDivisionAlumnos = $_POST['datosDivisionAlumnos'];

    // var_dump($datosDivisionAlumnos);

    obtener_division_alumnos($datosDivisionAlumnos);
  }elseif ($accion == "obtener_historial_alumnos") {

    $datosHistorialAlumno = $_POST['datosHistorialAlumno'];

    obtener_historial_alumnos($datosHistorialAlumno);
  }elseif ($accion == "imprimir_historial_alumnos") {
    $parametros_historial_alumno = $_REQUEST['parametros_historial_alumno'];
    
    imprimir_historial_alumnos($parametros_historial_alumno);
  }

// ===============================================================================
// FUNCION QUE INTERACTUAN CON EL MODELO
// ===============================================================================

// Funcion para que el controlador muestre las opciones que podra elegir
  function historial_alumnos_index(){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    $claseActivoHistorialAlumnos = true;

    $resultAnoLectivoActivo = buscar_Ano_Lectivo_Activo();

    $resultCursos = obtenerCursos();

    $resultTrayectos = obtenerTrayectos();
    
    
    $docente = ( isset($_REQUEST['docente'])) ? true : false;  
    
    
    include $absolute_include."vistas/historialAlumnos/index.php";

  }

  function obtener_division_alumnos($datosDivisionAlumnos){

    $datosDivisionAlumnos = json_decode($datosDivisionAlumnos);

    $idCicloLectivoHistoriaAlumnos = $datosDivisionAlumnos->idCicloLectivoHistoriaAlumnos;
    $idCursosHistorialAlumno = $datosDivisionAlumnos->idCursosHistorialAlumno;
    $idTrayectosHistorialAlumno = $datosDivisionAlumnos->idTrayectosHistorialAlumno;

    //Obtengo los alumnos del ano lectivo  
    $resultado_historial_division_alumnos = buscar_division_alumnos($idCicloLectivoHistoriaAlumnos, $idCursosHistorialAlumno);

    // echo json_encode($resultado_historial_division_alumnos);
    if (!empty($resultado_historial_division_alumnos)) {


      $resultado_Tabla_Historial_Alumnos = armar_tabla_historial_alumnos($resultado_historial_division_alumnos, $idCicloLectivoHistoriaAlumnos, $idTrayectosHistorialAlumno, $idCursosHistorialAlumno);

        // echo $resultado_inasistencias_alumnos;
      echo json_encode($resultado_Tabla_Historial_Alumnos);
    }else{
      echo json_encode("no_existe_division");
    }
  }

  function obtener_historial_alumnos($datosHistorialAlumno){

    $datosHistorialAlumno = json_decode($datosHistorialAlumno);
    $idArgAlumno = $datosHistorialAlumno->idArgAlumno;
    $fechaInicioHistorialAlumnos = $datosHistorialAlumno->fechaInicioHistorialAlumnos;
    $fechaFinHistorialAlumnos = $datosHistorialAlumno->fechaFinHistorialAlumnos;


    $result_busqueda_historial_alumno = buscar_historial_alumno($idArgAlumno, $fechaInicioHistorialAlumnos, $fechaFinHistorialAlumnos);

    // echo $result_busqueda_historial_alumno;
    if (!empty($result_busqueda_historial_alumno)) {
      $result_tarjetas_historial_alumno = armar_tarjetas_historial_alumnos($result_busqueda_historial_alumno);
      echo json_encode($result_tarjetas_historial_alumno);
    }else{
      echo json_encode("No se han encontrado coincidencias, por favor verifique las fechas!");
    }
  }

  function imprimir_historial_alumnos($arg_parametros_historial_alumno){
    
    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    $arg_parametros_historial_alumno = json_decode($arg_parametros_historial_alumno);

    $fechaInicioHistorialAlumnos = $arg_parametros_historial_alumno->fechaInicioHistorialAlumnos;
    $fechaFinHistorialAlumnos = $arg_parametros_historial_alumno->fechaFinHistorialAlumnos;
    $idAlumno = $arg_parametros_historial_alumno->idAlumno;

    $result_busqueda_historial_alumno = buscar_historial_alumno($idAlumno, $fechaInicioHistorialAlumnos, $fechaFinHistorialAlumnos);

    include ($absolute_include."vistas/historialAlumnos/imprimirHistorialAlumnos.php"); 

  }