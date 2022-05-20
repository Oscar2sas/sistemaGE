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
  include ($absolute_include."modelos/alumnos/model.alumnos.php");
  include ($absolute_include."modelos/documentosPersonas/model.documentospersonas.php");
  include ($absolute_include."modelos/reincorporacionesAlumnos/model.reincorporacionesalumnos.php");

  //verifica si se llamo a una accion determinada en el controlador
  $accion="";
// verifica si esta especificando un filtro
  $textoabuscar="";
  if (isset($_REQUEST['accion'])) {   // si existe una variable tipo REQUEST que llama a una accion / funcion

  	$accion=$_REQUEST['accion'];
  }


  if ( $accion == "" OR $accion=="index" )  {

  	reicorporacione_alumnos_index();

  }elseif ($accion == "guardar_reincorporacion_alumnos") {

    guardar_reincorporacion_alumnos($_POST['datosGuardarReincorporacionAlumnos'], $_FILES);
  }

 // ===============================================================================
 // FUNCION QUE INTERACTUAN CON EL MODELO
 // ===============================================================================

// Funcion para que el controlador liste los anos lectivos
  function reicorporacione_alumnos_index(){

  	$absolute_include = $GLOBALS['absolute_include'];
  	$carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    $claseActivoReincorporacionesAlumnos = true;

    $result_ano_lectivo = buscar_Ano_Lectivo_Activo();

    $result_alumnos_reincorporar = obtener_alumnos_para_reincorporar($result_ano_lectivo['anolectivo_id']);

    include $absolute_include."vistas/reincorporacionesAlumnos/index.php";
  }


  function guardar_reincorporacion_alumnos($arg_POST, $arg_FILES){

    $datosGuardarReincorporacionAlumnos = json_decode($arg_POST);

    $archivoGuardarReincorporacionAlumnos = $arg_FILES['archivoGuardarReincorporacionAlumnos'];

    $id_anolectivo_activo = buscar_Ano_Lectivo_Activo();

    $id_anolectivo_activo = $id_anolectivo_activo['anolectivo_id'];
    

    // subir archivo
    // guardar ruta en la bd
    // cambiar estado del alumno

    $result_subida_archivo_reincorporacion = guardar_documento_reincorporacion_alumno($archivoGuardarReincorporacionAlumnos);

    if ($result_subida_archivo_reincorporacion['estado']) {

      for ($i=0; $i < count($datosGuardarReincorporacionAlumnos) ; $i++) { 

        // obtengo los datos del alumnos
        $result_datos_persona = obtener_datos_alumnos($datosGuardarReincorporacionAlumnos[$i]);

        // inserto la ruta de la imagen en la bd
        $result_insert_documento = insertar_documento_persona('13', $result_datos_persona[0]['persona_id'],$result_subida_archivo_reincorporacion['mensaje']);

        if ($result_insert_documento['estado']) {

          // modificar el estado del alumno

          $result_modificar_est_alumno = modificar_estado_alumno($datosGuardarReincorporacionAlumnos[$i], '4', '1');

          if ($result_modificar_est_alumno['estado']) {
            $respuestaReincorporacionAlumnos = array('estado' => true,'mensaje' => $result_modificar_est_alumno['mensaje']);
            
          }else{
            $respuestaReincorporacionAlumnos = array('estado' => false,'mensaje' => $result_modificar_est_alumno['mensaje']);

          }
        }else{
          $respuestaReincorporacionAlumnos = array('estado' => false,'mensaje' => $result_insert_documento['mensaje']);

        }

      }

    }else{
      $respuestaReincorporacionAlumnos = array('estado' => false,'mensaje' => $respuestaReincorporacionAlumnos['mensaje']);


    }
    echo json_encode($respuestaReincorporacionAlumnos);

  }