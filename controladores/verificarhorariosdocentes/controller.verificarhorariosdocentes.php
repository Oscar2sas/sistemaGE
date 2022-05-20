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
  
  include ($absolute_include."modelos/verificarhorariosdocentes/model.verificarhorariosdocentes.php");

  //verifica si se llamo a una accion determinada en el controlador
  $accion="";
// verifica si esta especificando un filtro
  $textoabuscar="";
  if (isset($_REQUEST['accion'])) {   // si existe una variable tipo REQUEST que llama a una accion / funcion

  	$accion=$_REQUEST['accion'];
  }


  if ( $accion == "" OR $accion=="index" )  {

  	verificar_horarios_docentes_index();

  }

 // ===============================================================================
 // FUNCION QUE INTERACTUAN CON EL MODELO
 // ===============================================================================

  function verificar_horarios_docentes_index(){

  	$absolute_include = $GLOBALS['absolute_include'];
  	$carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    $claseActivoVerificarHorariosDocentes = true;


    $result_horarios_docentes = verificar_horarios_docentes('1');

    if (!$result_horarios_docentes['estado']) {

      $respuestaBusquedaHorariosDocentes = array('estado' => false,'mensaje' => "NO AHI NINGUN HORARIO ASIGNADO PARA ESTE DOCENTE!");

      echo json_encode($respuestaBusquedaHorariosDocentes);

      return;
    }
    



    $result_tabla_horarios = armar_tabla_verificar_horarios_docentes($result_horarios_docentes['mensaje']);

    include $absolute_include."vistas/verificarHorariosDocentes/index.php";
  }


