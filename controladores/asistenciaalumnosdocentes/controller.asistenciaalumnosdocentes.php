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

  include ($absolute_include."modelos/calendarios/model.calendario.php");   // se incluye el modelo de calendario 
  
  include ($absolute_include."modelos/anoLectivos/model.anoslectivos.php");   // se incluye el modelo de ano lectivos
  
  include ($absolute_include."modelos/cursos/model.curso.php");   // se incluye el modelo de cursos
  
  include ($absolute_include."modelos/trayectos/model.trayecto.php");   // se incluye el modelo de trayectos

  include ($absolute_include."modelos/alumnos/model.alumnos.php");   // se incluye el modelo de alumnos
  
  include ($absolute_include."modelos/materias/model.materias.php");   // se incluye el modelo de materias

  include ($absolute_include."modelos/asistenciaAlumnosDocentes/model.asistenciaalumnosdocentes.php");   // se incluye el modelo de asistencia alumnos docentes




  //verifica si se llamo a una accion determinada en el controlador
  $accion="";
  if (isset($_REQUEST['accion'])) {   // si existe una variable tipo REQUEST que llama a una accion / funcion

  	$accion=$_REQUEST['accion'];
  }

// Se valida si hay alguna accion enviada desde el front-end 
// en caso de que haya enviado la accion de tipo index
// o la accion este vacia
// se mostrara el listado de los alumnos para la asistencia 

  if ( $accion == "" OR $accion=="index" )  {

    // Se llama a la funcion para mostrara el listado de alumnos para la asistencia
    alumno_asistencia_index();
  }elseif ($accion == "verificar_horarios_curso") {

    $parametrosParaBuscarHorarios = $_REQUEST['datosHorarios'];

    verificar_horarios_curso($parametrosParaBuscarHorarios);

  }elseif ($accion == "buscar_materias_asistencia_alumnos_docentes") {
    buscar_materias_asistencia_alumnos_docentes($_POST);
  }elseif ($accion == "buscar_asistencia_alumnos_docentes") {

    buscar_asistencia_alumnos_docentes($_POST);

  }elseif ($accion == "guardar_asistencia_alumnos_docentes") {
    guardar_asistencia_alumnos_docentes($_POST);
  }


  // ===============================================================================
 // FUNCION QUE INTERACTUAN CON EL MODELO
 // ===============================================================================


// Funcion para que el controlador liste los alumnos para la asistencia
  function alumno_asistencia_index(){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // variable que se usa para agregar la clase active al link
    $claseActivoAsistenciaAlumnosDocentes = true;

    $resultFechaCalendario = buscar_Descripcion_Fecha_Calendario('');
    // var_dump($resultFechaCalendario);
    
    if ($resultFechaCalendario) {
      include $absolute_include."vistas/asistenciaAlumnosDocentes/errorAsistenciaAlumnosDocentes.php";
      return;
    }

    $resultAnoLectivoActivo = buscar_Ano_Lectivo_Activo();

    $fechaHoy = date('Y-m-d');

    $cursos = obtenerCursos();

    $trayectos = obtenerTrayectos();

    include $absolute_include."vistas/asistenciaAlumnosDocentes/index.php";

  }


  function buscar_materias_asistencia_alumnos_docentes($arg_POST){

    $datos_buscar_materias_docentes = json_decode($arg_POST['datosDatosParametrosBuscarMateriasDocentes']);

    $idCicloLectivoAsistenciaAlumnosDocentes = $datos_buscar_materias_docentes->idCicloLectivoAsistenciaAlumnosDocentes;

    $fechaAsistenciaAlumnosDocentes = $datos_buscar_materias_docentes->fechaAsistenciaAlumnosDocentes;

    $idCursosAsistenciaAlumnosDocentes = $datos_buscar_materias_docentes->idCursosAsistenciaAlumnosDocentes;

    $idTrayectosAsistenciaAlumnosDocentes = $datos_buscar_materias_docentes->idTrayectosAsistenciaAlumnosDocentes;

    $result_materias_docentes = buscar_materias_docentes($fechaAsistenciaAlumnosDocentes, $idCursosAsistenciaAlumnosDocentes, $idTrayectosAsistenciaAlumnosDocentes);

    if (!$result_materias_docentes['estado']) {

     $respuestaBusquedaMateriasDocentes = array('estado' => false,'mensaje' => $result_materias_docentes['mensaje']);

     echo json_encode($respuestaBusquedaMateriasDocentes);

     return;
   }

   if (!$result_materias_docentes['mensaje']) {

     $respuestaBusquedaMateriasDocentes = array('estado' => false,'mensaje' => "A USTED NO LE CORRESPONDE NIGUNA MATERIA EN EL DIA DE HOY, POR FAVOR VERIFIQUE EL TRAYECTO, EL CURSO O LA FECHA!");

     echo json_encode($respuestaBusquedaMateriasDocentes);

     return;
   }

   $result_lista_materias_docentes = armar_lista_materias_docentes($result_materias_docentes['mensaje']);

   $respuestaBusquedaMateriasDocentes = array('estado' => true,'mensaje' => $result_lista_materias_docentes);

   echo json_encode($respuestaBusquedaMateriasDocentes);
 }


 function buscar_asistencia_alumnos_docentes($arg_POST){

  $datos_buscar_asistencia_alumnos_docentes = json_decode($arg_POST['datosDatosParametrosAsistenciaAlumnosDocentes']);

  $idCicloLectivoAsistenciaAlumnosDocentes = $datos_buscar_asistencia_alumnos_docentes->idCicloLectivoAsistenciaAlumnosDocentes;

  $fechaAsistenciaAlumnosDocentes = $datos_buscar_asistencia_alumnos_docentes->fechaAsistenciaAlumnosDocentes;

  $idCursosAsistenciaAlumnosDocentes = $datos_buscar_asistencia_alumnos_docentes->idCursosAsistenciaAlumnosDocentes;

  $idTrayectosAsistenciaAlumnosDocentes = $datos_buscar_asistencia_alumnos_docentes->idTrayectosAsistenciaAlumnosDocentes;

  $idMateriasAsistenciaAlumnosDocentes = $datos_buscar_asistencia_alumnos_docentes->idMateriasAsistenciaAlumnosDocentes;


  $resultado_division_alumnos = buscar_division_alumnos($idCicloLectivoAsistenciaAlumnosDocentes, $idCursosAsistenciaAlumnosDocentes);

  if (empty($resultado_division_alumnos)) {

    $respuestaBusquedaAsistenciaAlumosDocentes = array('estado' => false,'mensaje' => "EL CURSO SELECCIONADO NO POSEE ALUMNOS, POR FAVOR VERIFIQUE");

    echo json_encode($respuestaBusquedaAsistenciaAlumosDocentes);

    return;
  }

  $result_inasistencia_alumnos_docentes = buscar_inasistencias_alumnos_docentes($idCicloLectivoAsistenciaAlumnosDocentes, $fechaAsistenciaAlumnosDocentes, $idMateriasAsistenciaAlumnosDocentes, $idTrayectosAsistenciaAlumnosDocentes, $idCursosAsistenciaAlumnosDocentes);


  if (!$result_inasistencia_alumnos_docentes['estado']) {
    $respuestaBusquedaAsistenciaAlumosDocentes = array('estado' => false,'mensaje' => $result_inasistencia_alumnos_docentes['mensaje']);

    echo json_encode($respuestaBusquedaAsistenciaAlumosDocentes);

    return;
  }


  $result_armar_tabla_asistencia_alumnos = armar_tabla_asistencias_alumnos($result_inasistencia_alumnos_docentes['mensaje'], $resultado_division_alumnos, $idCicloLectivoAsistenciaAlumnosDocentes, $idMateriasAsistenciaAlumnosDocentes, $idCursosAsistenciaAlumnosDocentes, $idTrayectosAsistenciaAlumnosDocentes);

  $respuestaBusquedaAsistenciaAlumosDocentes = array('estado' => true,'mensaje' => $result_armar_tabla_asistencia_alumnos);

  echo json_encode($respuestaBusquedaAsistenciaAlumosDocentes);


}

function guardar_asistencia_alumnos_docentes($arg_POST){
  $datosParametrosGuardarAsistenciaAlumnosDocentes = json_decode($arg_POST['datosParametrosGuardarAsistenciaAlumnosDocentes']);

// var_dump($datosParametrosGuardarAsistenciaAlumnosDocentes);

  $idCicloLectivoAsistenciaAlumnosDocentes = $datosParametrosGuardarAsistenciaAlumnosDocentes->idCicloLectivoAsistenciaAlumnosDocentes;

  $fechaAsistenciaAlumnosDocentes = $datosParametrosGuardarAsistenciaAlumnosDocentes->fechaAsistenciaAlumnosDocentes;

  $idCursosAsistenciaAlumnosDocentes = $datosParametrosGuardarAsistenciaAlumnosDocentes->idCursosAsistenciaAlumnosDocentes;

  $idTrayectosAsistenciaAlumnosDocentes = $datosParametrosGuardarAsistenciaAlumnosDocentes->idTrayectosAsistenciaAlumnosDocentes;

  $idMateriasAsistenciaAlumnosDocentes = $datosParametrosGuardarAsistenciaAlumnosDocentes->idMateriasAsistenciaAlumnosDocentes;

  $idAsistenciaAlumnosDocentes = $datosParametrosGuardarAsistenciaAlumnosDocentes->idAsistenciaAlumnosDocentes;

  // CAMBIAR POR VARIABLE SESSION
  $usuario_id = 1;
// var_dump($idAsistenciaAlumnosDocentes);


  $result_inasistencia_alumnos_docentes = buscar_inasistencias_alumnos_docentes($idCicloLectivoAsistenciaAlumnosDocentes, $fechaAsistenciaAlumnosDocentes, $idMateriasAsistenciaAlumnosDocentes, $idTrayectosAsistenciaAlumnosDocentes, $idCursosAsistenciaAlumnosDocentes);

  for ($i=0; $i < count($idAsistenciaAlumnosDocentes); $i++) { 


    if (!empty($result_inasistencia_alumnos_docentes['mensaje'])) {

      $result_compar_asistencia_docente = comparar_inasistencia_alumno_docentes($result_inasistencia_alumnos_docentes['mensaje'], $idAsistenciaAlumnosDocentes[$i]);


      if ($result_compar_asistencia_docente) {
        // Eliminar la asistencia del alumno-docente

        $result_modificacion_inasistencia_alumnos = modificar_inasistencia_alumnos_docentes($idCicloLectivoAsistenciaAlumnosDocentes, $idAsistenciaAlumnosDocentes[$i], $fechaAsistenciaAlumnosDocentes, $usuario_id, $idMateriasAsistenciaAlumnosDocentes, $idTrayectosAsistenciaAlumnosDocentes, $idCursosAsistenciaAlumnosDocentes);

        $resultOperacionAsistenciaAlumnosDocentes = ($result_modificacion_inasistencia_alumnos['estado']) ? $result_modificacion_inasistencia_alumnos['mensaje'] : 'Error Inasistencias Modificar';

      }else{
        // Guardar la inasistencia del alumno-docente

        $result_guardado_inasistencia_alumnos = insertar_inasistencia_alumnos_docentes($idCicloLectivoAsistenciaAlumnosDocentes, $idAsistenciaAlumnosDocentes[$i], $fechaAsistenciaAlumnosDocentes, $usuario_id, $idMateriasAsistenciaAlumnosDocentes, $idTrayectosAsistenciaAlumnosDocentes, $idCursosAsistenciaAlumnosDocentes);

        $resultOperacionAsistenciaAlumnosDocentes = ($result_guardado_inasistencia_alumnos['estado']) ? $result_guardado_inasistencia_alumnos['mensaje'] : 'Error Inasistencias Guardar';

      }
    }else{
      // Guardar la inasistencia del alumno-docente
      $result_guardado_inasistencia_alumnos = insertar_inasistencia_alumnos_docentes($idCicloLectivoAsistenciaAlumnosDocentes, $idAsistenciaAlumnosDocentes[$i], $fechaAsistenciaAlumnosDocentes, $usuario_id, $idMateriasAsistenciaAlumnosDocentes, $idTrayectosAsistenciaAlumnosDocentes, $idCursosAsistenciaAlumnosDocentes);

      $resultOperacionAsistenciaAlumnosDocentes = ($result_guardado_inasistencia_alumnos['estado']) ? $result_guardado_inasistencia_alumnos['mensaje'] : 'Error Inasistencias Guardar';

    }

  }

  echo json_encode(array('estado' => true,'mensaje' => $resultOperacionAsistenciaAlumnosDocentes));
}

// Funcion para comparar los id que se envia del formulario con los de la bd
function comparar_inasistencia_alumno_docentes($resultBusquedaInasistenciaAlumnos, $idAlumnosAsistenciaDocentes){
  foreach ($resultBusquedaInasistenciaAlumnos as $inasistenciaAlumno) {

    if ($inasistenciaAlumno['rela_alumno_id'] == $idAlumnosAsistenciaDocentes) {
      return true;
    }

  }
}