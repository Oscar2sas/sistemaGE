<?php 


// NOTA: FALTA, OBTENER PORCENTAJE DE ASISTENCIAS, OBTENER SI TUVO TARDANZA EN EL DIA, GUARDAR LA ASISTENCIA
// EXPORTAR EL PARTE DIARIO Y VALIDAR LA SITUACION DEL DIA

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

  include ($absolute_include."modelos/cursosHorarios/model.cursoshorarios.php");   // se incluye el modelo de curso horarios

  include ($absolute_include."modelos/asistenciaAlumnos/model.asistenciaalumnos.php");   // se incluye el modelo de asistencia alumnos

  include ($absolute_include."modelos/alumnos/model.alumnos.php");   // se incluye el modelo de alumnos

  include ($absolute_include."modelos/preceptor/model.preceptor.php");   // se incluye el modelo de preceptor
  
  include ($absolute_include."modelos/divisionesHorariosMaterias/model.divisioneshorariosmaterias.php");   // se incluye el modelo de divisiones horarios materias
  
  include ($absolute_include."modelos/parametros/model.parametros.php");   // se incluye el modelo de parametros

  include ($absolute_include."modelos/reincorporacionesAlumnos/model.reincorporacionesalumnos.php");   // se incluye el modelo de reincorporaciones alumnos



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


  }elseif ($accion == "obtener_alumnos_curso") {

    $parametrosParaBuscarAlumnos = $_REQUEST['datosHorarios'];

    obtener_Alumnos_Curso($parametrosParaBuscarAlumnos);
  }elseif ($accion == "guardar_asistencias_alumnos") {

    $paramentrosIdAlumnosAsistencia = $_POST['datosIdAlumnosAsistencia'];
    $paramentrosFormularioAsistenciaAlumnos = $_POST['datosEstadoSituacionDia'];
    $paramentrosDatosIdAlumnosTardanza = $_POST['datosIdAlumnosTardanza'];

    // var_dump($paramentrosIdAlumnosAsistencia);
    guardar_Asistencia_Alumnos($paramentrosIdAlumnosAsistencia, $paramentrosFormularioAsistenciaAlumnos, $paramentrosDatosIdAlumnosTardanza);
  }elseif ($accion == "imprimir_parte_diario") {

    $parametros_parte_diario = $_REQUEST['parametros_parte_diario'];

    imprimir_parte_diario($parametros_parte_diario);

  }


  // ===============================================================================
 // FUNCION QUE INTERACTUAN CON EL MODELO
 // ===============================================================================


// Funcion para que el controlador liste los alumnos para la asistencia
  function alumno_asistencia_index(){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // variable que se usa para agregar la clase active al link
    $claseActivoAsistenciaAlumnos = true;

    $resultFechaCalendario = buscar_Descripcion_Fecha_Calendario('');
    
    if ($resultFechaCalendario) {
      include $absolute_include."vistas/asistenciaAlumnos/errorAsistenciaAlumnos.php";
      return;
    }

    $resultAnoLectivoActivo = buscar_Ano_Lectivo_Activo();

    $fechaHoy = date('Y-m-d');

    $cursos = obtenerCursos();

    $trayectos = obtenerTrayectos();

    // $i = strtotime($fechaHoy);
    
    // echo jddayofweek(cal_to_jd(CAL_GREGORIAN, date("m",$i),date("d",$i), date("Y",$i)) , 0 );
    
    include $absolute_include."vistas/asistenciaAlumnos/index.php";

  }


  function verificar_horarios_curso($argDatosParaBuscarHorarios){

    // Decodifico la informacion en json
    $argDatosParaBuscarHorarios = json_decode($argDatosParaBuscarHorarios);
    
    // Recibo los datos enviado desde el formulario
    $fechaAsistencia = $argDatosParaBuscarHorarios->fechaAsistencia;
    $idCursos = $argDatosParaBuscarHorarios->idCursos;
    $idTrayectos = $argDatosParaBuscarHorarios->idTrayectos;

    // Desde el modelo de cursoshorarios
    // Recibo los resultados de los horarios, segun los parametros recibidos
    $resultHorariosCursos = verificarHorariosCursos($idCursos, $idTrayectos);

    if (!empty($resultHorariosCursos)) {

      // Desde el modelo de asistenciaaslumnos
      // Recibo si los datos recibido son validos para la toma de asistencia
      $resultBusquedaHorarios = buscar_horarios_curso($resultHorariosCursos, $fechaAsistencia);

      echo json_encode($resultBusquedaHorarios);
    }else{
      echo json_encode("Curso no posee aun horarios, verifique!");
    }
    return;

  }

  function obtener_Alumnos_Curso($argDatosParaBuscarAlumnos){

    $argDatosParaBuscarAlumnos = json_decode($argDatosParaBuscarAlumnos);

    $idAnoLectivo = $argDatosParaBuscarAlumnos->idAnoLectivo;
    $fechaAsistencia = $argDatosParaBuscarAlumnos->fechaAsistencia;
    $idCursos = $argDatosParaBuscarAlumnos->idCursos;
    $idTrayectos = $argDatosParaBuscarAlumnos->idTrayectos;

    // verifico que se haya tomado primero la asistencia de los docentes

    // $result_asistencia_division_horarios_materias = buscar_asistencia_division_horarios_materias($fechaAsistencia, $idCursos, $idTrayectos, $idAnoLectivo);

    // if (!empty($result_asistencia_division_horarios_materias)) {

      //Obtengo los alumnos del ano lectivo  
    $resultado_division_alumnos = buscar_division_alumnos($idAnoLectivo, $idCursos);


    if (!empty($resultado_division_alumnos)) {

      $resultado_inasistencias_alumnos = buscar_Inasistencia_Alumnos($fechaAsistencia, $idAnoLectivo, $idTrayectos, $idCursos);
      // var_dump($resultado_inasistencias_alumnos);
      $resultado_tabla_asistencia_alumnos = armar_Tabla_Asistencia_Alumnos($resultado_division_alumnos, $resultado_inasistencias_alumnos, $fechaAsistencia, $idAnoLectivo, $idTrayectos, $idCursos);

        // echo $resultado_inasistencias_alumnos;
      echo json_encode($resultado_tabla_asistencia_alumnos);
    }else{
      echo json_encode("No existe aun la divisiòn, verifique!");
    }
    return;
    // }else{
    //   echo json_encode("tomar_asistencia_curso");
    // }

  }


  function guardar_Asistencia_Alumnos($argParamentrosIdAlumnosAsistencia, $argParamentrosFormularioAsistenciaAlumnos, $argParamentrosDatosIdAlumnosTardanza){

    // Decodificacion de los parametros enviados
    // datos del formulario
    $argParamentrosFormularioAsistenciaAlumnos = json_decode($argParamentrosFormularioAsistenciaAlumnos);

    $idSituacionDia = $argParamentrosFormularioAsistenciaAlumnos->idSituacionDia;
    $idAnoLectivo = $argParamentrosFormularioAsistenciaAlumnos->idAnoLectivo;
    $fechaAsistencia = $argParamentrosFormularioAsistenciaAlumnos->fechaAsistencia;
    $idCursos = $argParamentrosFormularioAsistenciaAlumnos->idCursos;
    $idTrayectos = $argParamentrosFormularioAsistenciaAlumnos->idTrayectos;
    $token = $argParamentrosFormularioAsistenciaAlumnos->token;

    // datos de los alumnos
    $idAlumnosAsistencia = json_decode($argParamentrosIdAlumnosAsistencia);

    // datos de las tardanzas a los alumnos
    $idAlumnosTardanza = json_decode($argParamentrosDatosIdAlumnosTardanza);
    

    if ($token == $_SESSION['token']) {


      $resultOperacionAsistenciaAlumnos = false;

      for ($i=0; $i <count($idAlumnosAsistencia); $i++) { 


        $resultBusquedaInasistenciaAlumnos = buscar_Inasistencia_Alumnos($fechaAsistencia, $idAnoLectivo, $idTrayectos, $idCursos);

        $situacionDelDia = ($idSituacionDia == 1) ? 0 : 1;

        if (!empty($resultBusquedaInasistenciaAlumnos)) {

          $resultComparacionInasistencia = comparar_inasistencia_alumno($resultBusquedaInasistenciaAlumnos, $idAlumnosAsistencia[$i]);

          if ($resultComparacionInasistencia) {
            // ELIMINAR LA INASISTENCIA DEL ALUMNO

            $resultModificacionAsistenciaAlumnos = modificar_Asistencia_Alumnos($fechaAsistencia, $situacionDelDia, $idAnoLectivo, $idCursos, $idTrayectos, $idAlumnosAsistencia[$i]);

            $resultOperacionAsistenciaAlumnos = ($resultModificacionAsistenciaAlumnos == true) ? 'Inasistencias Borradas Correctamente' : 'Error Inasistencias Borrar';

          }else{
            // INSERTAR INASISTENCIA ALUMNO SI SE MODIFICO
            $resultGuardadoAsistenciaAlumnos = insertar_Asistencia_Alumnos($fechaAsistencia, $situacionDelDia, $idAnoLectivo, $idCursos, $idTrayectos, $idAlumnosAsistencia[$i]);

            $resultOperacionAsistenciaAlumnos = ($resultGuardadoAsistenciaAlumnos == true) ? 'Inasistencias Editadas Correctamente' : 'Error Inasistencias Edtitar';
          }

        }else{
          // INSERTAR LA INASISTENCIA A TODOS LO ALUMNOS (SI ES LA PRIMERA VEZ EN EL DIA)
          $resultGuardadoAsistenciaAlumnos = insertar_Asistencia_Alumnos($fechaAsistencia, $situacionDelDia, $idAnoLectivo, $idCursos, $idTrayectos, $idAlumnosAsistencia[$i]);

          $resultOperacionAsistenciaAlumnos = ($resultGuardadoAsistenciaAlumnos == true) ? 'Inasistencias Registradas Correctamente' : 'Error Inasistencias Registrar';
        }
      }


      if (!empty($idAlumnosTardanza)) {
        $resultBusquedaTardanzasAlumnos = buscar_Tardanzas_Alumnos($fechaAsistencia, $idAnoLectivo, $idTrayectos, $idCursos);

        for ($i=0; $i < count($idAlumnosTardanza) ; $i++) { 

        // echo json_encode($idAlumnosTardanza[$i]);

          $resultComparacionTardanza = comparar_tardanza_alumno($resultBusquedaTardanzasAlumnos, $idAlumnosTardanza[$i]);

          if ($resultComparacionTardanza) {

            $resultModificacionTardanzasAlumnos = modificar_Tardanza_Asistencia_Alumnos($fechaAsistencia, $idAnoLectivo, $idCursos, $idTrayectos, $idAlumnosTardanza[$i]);

            $resultOperacionAsistenciaAlumnos = ($resultModificacionTardanzasAlumnos == true) ? 'Tardanzas Borradas Correctamente' : 'Error Tardanzas Borrar';
          }else{

            $resultInsertTardanzaAlumno = insertar_Tardanza_Asistencia_Alumnos($fechaAsistencia, $idAnoLectivo, $idCursos, $idTrayectos, $idAlumnosTardanza[$i]);

            $resultOperacionAsistenciaAlumnos = ($resultInsertTardanzaAlumno == true) ? 'Tardanzas Registradas Correctamente' : 'Error Inasistencias Tardanzas';

          }
        } 
      }
      echo json_encode($resultOperacionAsistenciaAlumnos);

    }else{
      echo json_encode("TOKEN ENVIADO NO VALIDO, POR FAVOR VUELVA A INICIAR SESIÒN");

    }
  }

// Funcion para comparar los id que se envia del formulario con los de la bd
  function comparar_inasistencia_alumno($resultBusquedaInasistenciaAlumnos, $idAlumnosAsistencia){
    foreach ($resultBusquedaInasistenciaAlumnos as $key => $inasistenciaAlumno) {

      if ($inasistenciaAlumno['rela_alumno_id'] == $idAlumnosAsistencia) {
        return true;
      }

    }
  }

// funcion comparar la tardanza de un alumno
  function comparar_tardanza_alumno($resultBusquedaTardanzaAlumnos, $idAlumnosTardanza){
    foreach ($resultBusquedaTardanzaAlumnos as $key => $tardanzaAlumno) {

     if ($tardanzaAlumno['rela_alumno_id'] == $idAlumnosTardanza && $tardanzaAlumno['btardanza_asistencia'] == 1) {
       return true;
     }

   }
 }


// Funcion para imprimir el parte diario
 function imprimir_parte_diario($parametros_parte_diario){

  $absolute_include = $GLOBALS['absolute_include'];
  $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

  $parametros_parte_diario = json_decode($parametros_parte_diario);

  $idAnoLectivo = $parametros_parte_diario->idAnoLectivo;
  $fechaAsistencia = $parametros_parte_diario->fechaAsistencia;
  $idCursos = $parametros_parte_diario->idCursos;
  $idTrayectos = $parametros_parte_diario->idTrayectos;

  $descTrayecto = $parametros_parte_diario->descTrayecto;
  $descCurso = $parametros_parte_diario->descCurso;

  $resultInasistenciaAlumnos = buscar_Inasistencia_Alumnos($fechaAsistencia, $idAnoLectivo, $idTrayectos, $idCursos);
  include ($absolute_include."vistas/asistenciaAlumnos/imprimirParteDiarioAlumnos.php"); 
}