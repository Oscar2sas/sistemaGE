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
  
  include ($absolute_include."modelos/asistenciaalumnos/model.asistenciaalumnos.php");   // se incluye el modelo de historial alumnos

  include ($absolute_include."modelos/justificacionesAlumnos/model.justificacionesalumnos.php");   // se incluye el modelo de historial alumnos
  
  include ($absolute_include."modelos/documentosPersonas/model.documentospersonas.php");   // se incluye el modelo de historial alumnos
  



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
    justificaciones_alumnos_index();
  }elseif ($accion == "buscar_alumnos_curso") {

    $datosFormularioBuscarAlumnosCurso = $_POST['datosFormularioBuscarAlumnosCurso'];

    // var_dump($datosFormularioBuscarAlumnosCurso);

    buscar_alumnos_curso($datosFormularioBuscarAlumnosCurso);
  }elseif ($accion == "buscar_curso_inasistencias_alumno") {

    $datosFormularioCursoJustificacionAlumnos = $_POST['datosFormularioCursoJustificacionAlumnos'];

    // var_dump($datosFormularioCursoJustificacionAlumnos);
    buscar_curso_inasistencias_alumno($datosFormularioCursoJustificacionAlumnos);

  }elseif ($accion == "guardar_justificaciones_alumnos") {
    $datosGuardarJustificacionAlumnos = $_POST['datosGuardarJustificacionAlumnos'];

    $archivo_justificacion_alumno = isset($_FILES['archivoGuardarJustificacionAlumnos']) ? $_FILES['archivoGuardarJustificacionAlumnos'] : null;
    
    guardar_justificaciones_alumnos($datosGuardarJustificacionAlumnos, $archivo_justificacion_alumno);
  }

// ===============================================================================
// FUNCION QUE INTERACTUAN CON EL MODELO
// ===============================================================================

// Funcion para que el controlador muestre las opciones que podra elegir
  function justificaciones_alumnos_index(){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    $justificacionesAlumnos = true;

    $resultAnoLectivoActivo = buscar_Ano_Lectivo_Activo();

    $resultCursos = obtenerCursos();

    $resultTrayectos = obtenerTrayectos(); 
    include $absolute_include."vistas/justificacionesAlumnos/index.php";

  }


  function buscar_alumnos_curso($argDatosFormularioBuscarAlumnosCurso){

   $argDatosFormularioBuscarAlumnosCurso = json_decode($argDatosFormularioBuscarAlumnosCurso);

   $idCicloLectivoJustificacionAlumnos = $argDatosFormularioBuscarAlumnosCurso->idCicloLectivoJustificacionAlumnos;

   $idCursosJustificacionesAlumnos = $argDatosFormularioBuscarAlumnosCurso->idCursosJustificacionesAlumnos;

   $idTrayectosJustificacionAlumnos = $argDatosFormularioBuscarAlumnosCurso->idTrayectosJustificacionAlumnos;

   $resultado_busqueda_division__alumnos = buscar_division_alumnos($idCicloLectivoJustificacionAlumnos, $idCursosJustificacionesAlumnos);


   if (!empty($resultado_busqueda_division__alumnos)) {

    $resultado_lista_alumnos_curso = armar_lista_curso_alumnos($resultado_busqueda_division__alumnos);

    $respuestaBusquedaCursoAlumnos = array('estado' => true,'mensaje' => $resultado_lista_alumnos_curso);

  }else{

    $respuestaBusquedaCursoAlumnos = array('estado' => false,'mensaje' => 'NO EXISTE LA DIVISION, POR FAVOR VERIFIQUE');
  }
  echo json_encode($respuestaBusquedaCursoAlumnos);
}

function buscar_curso_inasistencias_alumno($datosFormularioCursoJustificacionAlumnos){

  $datosFormularioCursoJustificacionAlumnos = json_decode($datosFormularioCursoJustificacionAlumnos);

  $idCicloLectivoJustificacionAlumnos = $datosFormularioCursoJustificacionAlumnos->idCicloLectivoJustificacionAlumnos;

  // $idCursosJustificacionesAlumnos = $datosFormularioCursoJustificacionAlumnos->idCursosJustificacionesAlumnos;

  $idTrayectosJustificacionAlumnos = $datosFormularioCursoJustificacionAlumnos->idTrayectosJustificacionAlumnos;

  $idBusquedaCursoAlumnos = $datosFormularioCursoJustificacionAlumnos->idBusquedaCursoAlumnos;


  $resultado_inasistencias_justificacion_alumno = obtener_Total_Inasistencia_Alumnos($idCicloLectivoJustificacionAlumnos, $idBusquedaCursoAlumnos, $idTrayectosJustificacionAlumnos);

      // var_dump($resultado_inasistencias_justificacion_alumno);

  if (!empty($resultado_inasistencias_justificacion_alumno)) {

    $resultado_tabla_justificacion_alumno = armar_Tabla_Justificacion_Alumnos($resultado_inasistencias_justificacion_alumno);

    $respuestaJustificacionesAlumno = array('estado' => true,'mensaje' => $resultado_tabla_justificacion_alumno);
  }else{
    $respuestaJustificacionesAlumno = array('estado' => false,'mensaje' => 'ESTE ALUMNO NO POSEE INASISTENCIAS, POR FAVOR VERIFIQUE');
  }
  echo json_encode($respuestaJustificacionesAlumno);
}


function guardar_justificaciones_alumnos($arg_datosGuardarJustificacionAlumnos ,$arg_archivo_justificacion_alumno){


  $arg_datosGuardarJustificacionAlumnos = json_decode($arg_datosGuardarJustificacionAlumnos);

  $idCicloLectivoJustificacionAlumnos = $arg_datosGuardarJustificacionAlumnos->idCicloLectivoJustificacionAlumnos;
// $idCursosJustificacionesAlumnos = $arg_datosGuardarJustificacionAlumnos->idCursosJustificacionesAlumnos;
  $idTrayectosJustificacionAlumnos = $arg_datosGuardarJustificacionAlumnos->idTrayectosJustificacionAlumnos;


  $idBusquedaCursoAlumnos = $arg_datosGuardarJustificacionAlumnos->idBusquedaCursoAlumnos;

  $idFechaJustificacionPersonaAlumno = $arg_datosGuardarJustificacionAlumnos->idFechaJustificacionPersonaAlumno;


// si el argumento que posee el archivo, significa que desde guardar las justificaciones
// caso contrario se de sea eliminar una justificacion
  if ($arg_archivo_justificacion_alumno) {

    $resultado_subida_documento_justificacion_alumno = guardar_documento_justificacion_alumno($arg_archivo_justificacion_alumno);

  // si el resultado de la subida de la imagen es correcta
    if ($resultado_subida_documento_justificacion_alumno['estado']) {

        // buscar la inasistencia por medio de la fecha
        // si hay coincidencia y no esta justificada accion=> guardar
        // caso contrario borrar

      // recorreo las fechas de las inasitencias enviadas
      foreach ($idFechaJustificacionPersonaAlumno as $key => $fecha_Justificacion) {

        // busco una inasistencia segun la fecha
       $result_busqueda_fecha_inasistencia_alumno = buscar_Inasistencia_Fecha_Alumno($idCicloLectivoJustificacionAlumnos, $idTrayectosJustificacionAlumnos, $idBusquedaCursoAlumnos, $fecha_Justificacion);

       // si no esta vacio mi resultado de busqueda de inasistencia por fecha

       if (!empty($result_busqueda_fecha_inasistencia_alumno)) {

        // guardo el documento de la justificacion y regreso el ID
        $result_id_documento_justificacion = insertar_documento_persona('11', $result_busqueda_fecha_inasistencia_alumno[0]['rela_persona_id'], $resultado_subida_documento_justificacion_alumno['mensaje']);

        // si el resultado de guardar el documento es valido se modificar la inasistencia
        if ($result_id_documento_justificacion['estado']) {


          // caso contrario se modifica la inasitencia
          $result_registro_justificacion_guardar = modificar_registro_justificacion_alumno($idCicloLectivoJustificacionAlumnos, $idTrayectosJustificacionAlumnos, $idBusquedaCursoAlumnos, $fecha_Justificacion, $result_id_documento_justificacion['mensaje'], 1);

          
          // si el resultado de la inasistencia es valida se envia un mensaje de exito a la vista
          if ($result_registro_justificacion_guardar['estado']) {

            $respuestaGuardadoJustificacionAlumno = array('estado' => true,'mensaje' => $result_registro_justificacion_guardar['mensaje']);

          }else{
            // caso contrario se envia un mensaje de error
            $respuestaGuardadoJustificacionAlumno = array('estado' => false,'mensaje' => 'Error al realizar modificaciones');
          }

        }else{
          // caso contrario se envia un mensaje de error
          $respuestaGuardadoJustificacionAlumno = array('estado' => false,'mensaje' => $result_id_documento_justificacion['mensaje']);
        }

      }else{

        // ELIMINAR JUSTIFICACION

        // caso contrario se elimina el registrod del documento de la justificacoin
       $result_inasistencia_justificada = buscar_inasistencia_justificada_alumnos($idCicloLectivoJustificacionAlumnos, $idTrayectosJustificacionAlumnos, $idBusquedaCursoAlumnos, $fecha_Justificacion);

       // if (!empty($result_inasistencia_justificada['mensaje'])) {

       $result_eliminacion_justificacion = eliminar_documento_justificacion_alumno($result_inasistencia_justificada['mensaje'][0]['documento_id']);

       if ($result_eliminacion_justificacion['estado']) {

          // se modifica el registro de la inasistencia
         $result_registro_justificacion_guardar = modificar_registro_justificacion_alumno($idCicloLectivoJustificacionAlumnos, $idTrayectosJustificacionAlumnos, $idBusquedaCursoAlumnos, $fecha_Justificacion, 0, 0);

          // si el resultado de la eliminacion es valida se envia un mensaje de exito a la vista
         if ($result_registro_justificacion_guardar['estado']) {

          $respuestaGuardadoJustificacionAlumno = array('estado' => true,'mensaje' => $result_registro_justificacion_guardar['mensaje']);

        }else{
              // caso contrario se envia un mensaje de error
          $respuestaGuardadoJustificacionAlumno = array('estado' => false,'mensaje' => 'Error al realizar eliminaciones');
        }

      }else{
            // caso contrario se envia un mensaje de error
        $respuestaGuardadoJustificacionAlumno = array('estado' => false,'mensaje' => $result_id_documento_justificacion['mensaje']);
      }
     
    }

      } //end foreach

    }else{
      // caso contrario enviar mensaje de error
      $respuestaGuardadoJustificacionAlumno = array('estado' => false,'mensaje' =>$resultado_subida_documento_justificacion_alumno['mensaje']);
    }

  }else{

 // ELIMINAR JUSTIFICACION

    foreach ($idFechaJustificacionPersonaAlumno as $key => $fecha_Justificacion) {

      // caso contrario se modifica la inasitencia

      $result_inasistencia_justificada = buscar_inasistencia_justificada_alumnos($idCicloLectivoJustificacionAlumnos, $idTrayectosJustificacionAlumnos, $idBusquedaCursoAlumnos, $fecha_Justificacion);

      // var_dump($result)

      if (!empty($result_inasistencia_justificada['mensaje'])) {

        $result_eliminacion_justificacion = eliminar_documento_justificacion_alumno($result_inasistencia_justificada['mensaje'][0]['documento_id']);
            // si el resultado de la inasistencia es valida se envia un mensaje de exito a la vista
        if ($result_eliminacion_justificacion['estado']) {

          $result_registro_justificacion_guardar = modificar_registro_justificacion_alumno($idCicloLectivoJustificacionAlumnos, $idTrayectosJustificacionAlumnos, $idBusquedaCursoAlumnos, $fecha_Justificacion, 0, 0);

          // si el resultado de la modificacion es valida se envia un mensaje de exito a la vista
          if ($result_registro_justificacion_guardar['estado']) {

            $respuestaGuardadoJustificacionAlumno = array('estado' => true,'mensaje' => $result_registro_justificacion_guardar['mensaje']);

          }else{
              // caso contrario se envia un mensaje de error
            $respuestaGuardadoJustificacionAlumno = array('estado' => false,'mensaje' => 'Error al realizar eliminaciones');
          }

        }else{
            // caso contrario se envia un mensaje de error
          $respuestaGuardadoJustificacionAlumno = array('estado' => false,'mensaje' => $result_id_documento_justificacion['mensaje']);
        }
      }else{
       $respuestaGuardadoJustificacionAlumno = array('estado' => false,'mensaje' => 'Debe seleccionar un documento de justificacion!');
     }


   }
 }

 echo json_encode($respuestaGuardadoJustificacionAlumno);

}