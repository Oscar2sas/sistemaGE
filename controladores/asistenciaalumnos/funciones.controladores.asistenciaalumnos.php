<?php 


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
    
    // Recibo los datos enviado desde el formulario
    $fechaAsistencia = $argDatosParaBuscarHorarios[2];
    $idCursos = $argDatosParaBuscarHorarios[3];
    $idTrayectos = $argDatosParaBuscarHorarios[4];

    // Desde el modelo de cursoshorarios
    // Recibo los resultados de los horarios, segun los parametros recibidos
    $resultHorariosCursos = verificarHorariosCursos($idCursos, $idTrayectos);
    
    if (!empty($resultHorariosCursos)) {

      // Desde el modelo de asistenciaaslumnos
      // Recibo si los datos recibido son validos para la toma de asistencia
      $resultBusquedaHorarios = buscar_horarios_curso($resultHorariosCursos, $fechaAsistencia);

      if($resultBusquedaHorarios == " "){
        $resultBusquedaHorarios = false;
      }
       
    }else{
      $resultBusquedaHorarios = "Curso no posee aun horarios, verifique!";
    }

    return $resultBusquedaHorarios;

  }

  function obtener_Alumnos_Curso($argDatosParaBuscarAlumnos){

    $idAnoLectivo = $argDatosParaBuscarAlumnos[1];
    $fechaAsistencia = $argDatosParaBuscarAlumnos[2];
    $idCursos = $argDatosParaBuscarAlumnos[3];
    $idTrayectos = $argDatosParaBuscarAlumnos[4];



    // verifico que se haya tomado primero la asistencia de los docentes

    // $result_asistencia_division_horarios_materias = buscar_asistencia_division_horarios_materias($fechaAsistencia, $idCursos, $idTrayectos, $idAnoLectivo);

    // if (!empty($result_asistencia_division_horarios_materias)) {

      //Obtengo los alumnos del ano lectivo  
    $resultado_division_alumnos = buscar_division_alumnos($idAnoLectivo, $idCursos);

    if (!empty($resultado_division_alumnos)) {

      $resultado_inasistencias_alumnos = buscar_Inasistencia_Alumnos($fechaAsistencia, $idAnoLectivo, $idTrayectos, $idCursos);

      $resultado_tabla_asistencia_alumnos = armar_Tabla_Asistencia_Alumnos($resultado_division_alumnos, $resultado_inasistencias_alumnos, $fechaAsistencia, $idAnoLectivo, $idTrayectos, $idCursos);

      echo $resultado_tabla_asistencia_alumnos;
    }else{
      echo "la divicion aun no existe,verifique!";
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

?>