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
    consultar_asistencia_alumnos_index();
  }elseif ($accion == "consultar_asitencias_alumnos") {

    consultar_asitencias_alumnos($_POST);

  }
// ===============================================================================
// FUNCION QUE INTERACTUAN CON EL MODELO
// ===============================================================================


  function consultar_asistencia_alumnos_index(){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    include $absolute_include."vistas/consultarAsistenciaAlumnos/index.php";

  }

  function consultar_asitencias_alumnos($arg_POST){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    $dniAlumno = $arg_POST['dniAlumno'];

    if (!is_numeric($dniAlumno)) {
      
      mensaje_alerta("EL DNI INGRESADO NO ES UN NUMERO, POR FAVOR VERIFIQUE!");
      return;
    }

    if (strlen($dniAlumno) > 8) {
      
      mensaje_alerta("EL DNI INGRESADO ES MAYOR A 8 DIGITOS, POR FAVOR VERIFIQUE!");
      return;
    }

    $ano_lectivo_activo = buscar_Ano_Lectivo_Activo();

    if (empty($ano_lectivo_activo)) {
      mensaje_alerta("NO AHI NINGUN AÑO ACTIVO, POR FAVOR CONTACTE AL ADMINISTRADOR DEL SISTEMA!");
      return;
    }

    $trayectos = obtenerTrayectos();

    if (empty($trayectos)) {
      mensaje_alerta("NO AHI NINGUN TRAYECTO CARGADO, POR FAVOR CONTACTE AL ADMINISTRADOR DEL SISTEMA!");
      return;
    }

    $result_datos_alumnos = obtener_datos_alumnos_dni($dniAlumno, $ano_lectivo_activo['anolectivo_id']);

    if (empty($result_datos_alumnos)) {
      mensaje_alerta("NO HAY NINGUN ALUMNO GUARDADO CON EL DNI INGRESADO POR FAVOR VERIFIQUE!");
      return;
    }

    $result_consulta_inasistencia_alumnos = array();

    foreach ($trayectos as $trayecto) {

      $result_total_inasitencias_alumnos = buscar_historial_inasistencias_alumno($ano_lectivo_activo['anolectivo_id'], $result_datos_alumnos[0]['rela_curso_id'], $trayecto['trayecto_id'], $result_datos_alumnos[0]['alumno_id']);


      $result_historiales_alumnos = buscar_historiales_alumno($result_datos_alumnos[0]['alumno_id']);
      
      // var_dump($result_historiales_alumnos);

      $result_consulta_inasistencia_alumnos[] = armar_tabla_consultar_asistencias_alumnos($result_total_inasitencias_alumnos, $ano_lectivo_activo['anolectivo_id'], $trayecto['trayecto_id'], $result_datos_alumnos[0]['rela_curso_id'], $trayecto['cdescripcion_trayecto'], $result_datos_alumnos[0]['alumno_id'], $result_historiales_alumnos);
    }


    // var_dump($result_consulta_inasistencia_alumnos);
    include $absolute_include."vistas/consultarAsistenciaAlumnos/listadoInasistenciasAlumnos.php";

  }

  function mensaje_alerta($arg_mensaje){
    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    echo"<script type=\"text/javascript\">
    alert(\"$arg_mensaje\"); 
    self.location = \"$carpeta_trabajo/controladores/consultarasistenciasalumnos/controller.consultarasistenciasalumnos.php\";
    </script>"; 
  }