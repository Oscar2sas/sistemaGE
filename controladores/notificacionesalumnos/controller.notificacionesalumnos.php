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

  include ($absolute_include."modelos/alumnos/model.alumnos.php");   // se incluye el modelo de historial alumnos
  include ($absolute_include."modelos/notificacionesAlumnos/model.notificacionesalumnos.php");   // se incluye el modelo de notificacionesAlumnos
  


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
    notificaciones_alumnos_index();
  }elseif ($accion == "enviar_notificacion_alumnos") {

    $datosNotificacionAlumnos = $_POST['datosNotificacionAlumnos'];

    enviar_notificacion_alumnos($datosNotificacionAlumnos);

  }

// ===============================================================================
// FUNCION QUE INTERACTUAN CON EL MODELO
// ===============================================================================

// Funcion para que el controlador muestre las opciones que podra elegir
  function notificaciones_alumnos_index(){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    $claseActivoNotificacionesAlumnos = true;

    $resultAnoLectivoActivo = buscar_Ano_Lectivo_Activo();

    $resultCursos = obtenerCursos();

    include $absolute_include."vistas/notificacionesAlumnos/index.php";

  }

  function enviar_notificacion_alumnos($datosNotificacionAlumnos){

    $datosNotificacionAlumnos = json_decode($datosNotificacionAlumnos);

    $idCicloLectivoNotificacionesAlumnos = $datosNotificacionAlumnos->idCicloLectivoNotificacionesAlumnos;
    $idCursosNotificacionesAlumnos = $datosNotificacionAlumnos->idCursosNotificacionesAlumnos;
    $descripcionMensajeNotificacionAlumnos = $datosNotificacionAlumnos->descripcionMensajeNotificacionAlumnos;

  //Obtengo los alumnos del ano lectivo  
    $resultado_notificacion_division_alumnos = buscar_division_alumnos($idCicloLectivoNotificacionesAlumnos, $idCursosNotificacionesAlumnos);

    // echo json_encode($resultado_notificacion_division_alumnos);


    if (!empty($resultado_notificacion_division_alumnos)) {

      // echo json_encode($resultado_Tabla_Historial_Alumnos);
      $respuestaNotificacionAlumnos = enviarMensajeNotificacionAlumnos($resultado_notificacion_division_alumnos, $descripcionMensajeNotificacionAlumnos);
    }else{

     $respuestaNotificacionAlumnos = array('estado' => false,'mensaje' => 'NO EXISTE LA DIVISION, POR FAVOR VERIFIQUE');
   }

   echo json_encode($respuestaNotificacionAlumnos);
 } 

