<?php 

// ========================================================================================
// VERIFICAR HORARIOS PARA PODER REALIZAR LA ASISTENCIA
// NOTA: EL USUARIO NO DEBERIA PODER REALIZAR LA ASISTENCIA DE UN CURSO QUE NO TIENE CLASES ESE DIA
// ========================================================================================

function buscar_horarios_curso($resultHorariosCursos, $fechaAsistencia){
	
	// ===================================================================
	// Verificar que la fecha para la asistencia, sea valida para el curso
	// ===================================================================

	$resultDiaHorarios = obtenerFechaClases($resultHorariosCursos['cdias_horario']);


	if (!is_array($resultDiaHorarios)) {
		return $resultDiaHorarios;
	}

	$resultDiaHoy = obtener_nombre_del_dia($fechaAsistencia);

// recorro los dias que tiene asignado el curso segun el trayecto
// En caso de que haya coincidencia retornar true
// Caso contrario retornar false
	for ($i=0; $i <count($resultDiaHorarios); $i++) { 
		if ($resultDiaHorarios[$i] == $resultDiaHoy) {
			return true;
		}
	}

	return false;

	
}

// Funcion para obtener el dia dependiendo del formato de fecha: 0000000

function obtenerFechaClases($argCdias_Horario){

	if (strlen($argCdias_Horario) === 7) {
		
		$caracterDiasEnNumeros = str_split($argCdias_Horario);

		$diasClases = [];
		for ($i=0; $i < count($caracterDiasEnNumeros); $i++) { 

			$diasDeSemanas = ["Lunes","Martes","Miercoles","Jueves","Viernes","Sabado", "Domingo"];
	// 1=> un dia con clases
	// 0=> un dia sin clases		
			if ($caracterDiasEnNumeros[$i] == 1) {
				array_push($diasClases, $diasDeSemanas[$i]);
			}	
		}
		if (empty($diasClases)) {
			return "Caracteres ingresados no concuerda con ningun dia de la semana!";
		}
		return $diasClases;
		
	}else{
		return "Cadena ingresada no puede ser mayor o menor a 7 caracteres";
	}
}


// Funcion para obtener el dia de la semana a partir de una fecha en concreto
function obtener_nombre_del_dia($nombredia) {
	$dias = array("", "Lunes","Martes","Miercoles","Jueves","Viernes","Sabado", "Domingo");
	$fecha = $dias[date("N", strtotime($nombredia))];
	return $fecha;
}

// ALGORITMO
// 1) VERIFICAR EN LA TABLA DIVISIONES_INASISTENCIAS SI NO HAY REGISTROS GUARDADOS
// 2) EN CASO DE A VER REGISTROS QUE COINCIDAN CON LAS -FECHA, ID ANO LECTIVO, ID TRAYECTO, ALUMNO ID
// 3) MOSTRAR ESOS REGISTROS
// 4) SI NO HAY REGISTROS QUE COINCIDAN
// 5) MOSTRAR LOS ALUMNOS DE LA DIVISION, SEGUN EL ID ANO LECTIVO, ID CURSO


function buscar_Inasistencia_Alumnos($argFechaAsistencia, $argIdAnoLectivo, $argIdTrayectos, $argIdCurso){

		//============================================================================================
		//Verifico las inasistencia de la division del dia 
		//============================================================================================

		$resultado_inasistencia_alumnos = array();  // creo un array que va a almacenar la informacion de las inasistencias de los alumnos

		$db = new ConexionDB;
		$conexion = $db->retornar_conexion();

		$sql_inasistencia_alumnos = "
		SELECT *

		FROM divisiones_inasistencias d1, alumnos a1, personas p1, estado_alumnos e1, cursos c1

        WHERE d1.rela_anolectivo_id = :argrela_anolectivo_id AND d1.rela_trayecto_id = :argrela_trayecto_id AND d1.rela_alumno_id = a1.alumno_id AND d1.dfecha_inasistencia = :argdfecha_inasistencia AND d1.rela_curso_id = c1.curso_id AND c1.curso_id = :argrela_curso_id AND a1.rela_persona_id = p1.persona_id AND a1.rela_estadoalumno_id = e1.estadoalumno_id AND (e1.cdescripcion_estadoalumno = 'CURSANTE' OR e1.cdescripcion_estadoalumno = 'REPITENTE' OR e1.cdescripcion_estadoalumno = 'LIBRE')"; // busca las inasistencias que coincidad con esa fecha

        $statement = $conexion->prepare($sql_inasistencia_alumnos);

        $statement->bindParam(':argrela_anolectivo_id' , $argIdAnoLectivo);  // reemplazo los parametros enlazados 

		$statement->bindParam(':argrela_trayecto_id' , $argIdTrayectos);  // reemplazo los parametros enlazados 
		
		$statement->bindParam(':argdfecha_inasistencia' , $argFechaAsistencia);  // reemplazo los parametros enlazados 

        $statement->bindParam(':argrela_curso_id' , $argIdCurso);  // reemplazo los parametros enlazados 

        $statement->execute();

        
        if (!$statement){
            // no se encontraron paises
        }else{
            // reviso el retorno
        	while($resultado = $statement->fetch(PDO::FETCH_ASSOC)){
        		$resultado_inasistencia_alumnos[]= $resultado;
        	}
        }
        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);
        
        // $resultado_Tabla_Asistencia_Alumnos = armar_Tabla_Asistencia_Alumnos($argDivision_alumnos, $resultado_inasistencia_alumnos, $argFechaAsistencia, $argIdAnoLectivo, $argIdTrayectos, $argIdCurso);

        return $resultado_inasistencia_alumnos;
        
      }


      function buscar_Tardanzas_Alumnos($argFechaAsistencia, $argIdAnoLectivo, $argIdTrayectos, $argIdCurso){

		//============================================================================================
		//Busco las tardanzas del dia
		//============================================================================================

		$resultado_tardanzas_alumnos = array();  // creo un array que va a almacenar la informacion de las inasistencias de los alumnos

		$db = new ConexionDB;
		$conexion = $db->retornar_conexion();

		$sql_tardanza_alumnos = "
		SELECT *

		FROM divisiones_inasistencias d1, alumnos a1, personas p1, estado_alumnos e1, cursos c1

        WHERE d1.rela_anolectivo_id = :argrela_anolectivo_id AND d1.rela_trayecto_id = :argrela_trayecto_id AND d1.rela_alumno_id = a1.alumno_id AND d1.dfecha_inasistencia = :argdfecha_inasistencia AND d1.rela_curso_id = c1.curso_id AND c1.curso_id = :argrela_curso_id AND a1.rela_persona_id = p1.persona_id AND a1.rela_estadoalumno_id = e1.estadoalumno_id AND (e1.cdescripcion_estadoalumno = 'CURSANTE' OR e1.cdescripcion_estadoalumno = 'REPITENTE' OR e1.cdescripcion_estadoalumno = 'LIBRE') AND btardanza_asistencia = 1"; // busca las inasistencias que coincidad con esa fecha

        $statement = $conexion->prepare($sql_tardanza_alumnos);

        $statement->bindParam(':argrela_anolectivo_id' , $argIdAnoLectivo);  // reemplazo los parametros enlazados 

		$statement->bindParam(':argrela_trayecto_id' , $argIdTrayectos);  // reemplazo los parametros enlazados 
		
		$statement->bindParam(':argdfecha_inasistencia' , $argFechaAsistencia);  // reemplazo los parametros enlazados 

        $statement->bindParam(':argrela_curso_id' , $argIdCurso);  // reemplazo los parametros enlazados 

        $statement->execute();

        
        if (!$statement){
            // no se encontraron paises
        }else{
            // reviso el retorno
        	while($resultado = $statement->fetch(PDO::FETCH_ASSOC)){
        		$resultado_tardanzas_alumnos[]= $resultado;
        	}
        }
        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);
        
        // $resultado_Tabla_Asistencia_Alumnos = armar_Tabla_Asistencia_Alumnos($argDivision_alumnos, $resultado_tardanzas_alumnos, $argFechaAsistencia, $argIdAnoLectivo, $argIdTrayectos, $argIdCurso);

        return $resultado_tardanzas_alumnos;
        
      }

    // Funcion para armar la estructura de la tabla
      function armar_Tabla_Asistencia_Alumnos($arg_result_division_alumnos, $arg_resultado_inasistencia_alumnos, $argFechaAsistencia, $argIdAnoLectivo, $argIdTrayectos, $argIdCurso){

    	// var_dump($arg_resultado_inasistencia_alumnos);

       $db = new ConexionDB;
       $conexion = $db->retornar_conexion();
        // Cabecera tabla asistencia alumnos
       $tabla_asistencia_alumnos = "

       <div id='tablaAsistenciaAlumnos'>
       <button id='exportarParteDiarioAlumnos' class='btn btn-info'>Exportar parte diario</button> Fecha: $argFechaAsistencia <br><br>
       <table id='table' class='table table-stripped table-bordered nowrap cellspacing=' width='100%'>

       <thead class='thead-dark'>
       <tr>
       <th class='text-center'>Apellido</th>
       <th class='text-center'>Nombre</th>
       <th class='text-center'>Dni</th>
       <th class='text-center'>Estado Alumno</th>
       <th class='text-center'>Valor Total Inasistencia</th>
       <th class='text-center'>Porcentaje de Inasistencia</th>
       <th class='text-center'>Inasistencias</th>
       <th class='text-center'>P/A[x]</th>
       <th class='text-center'>J[x]</th>
       <th class='text-center'>T[x]</th>
       </tr>
       </thead>

       <tbody>";

        // CUERPO TABLA

       foreach ($arg_result_division_alumnos as $key => $division_alumnos) {

            // obtener total valor de la inasistencia de un alumno
        $cantInasistenciaAlumno = obtener_Total_Valor_Inasistencia_Alumnos($argIdAnoLectivo, $division_alumnos['alumno_id'], $argIdTrayectos, $argIdCurso);
            // obtener total valor de la tardanza de un alumno
            // var_dump($division_alumnos);
        $cantTardanzaAlumno = obtener_Total_Valor_Tardanza_Alumnos($argIdAnoLectivo, $division_alumnos['alumno_id'], $argIdTrayectos, $argIdCurso);

        $cantInasistenciaAlumno += $cantTardanzaAlumno;

            // obtener valor de los parametros del sistema
        $resultParametros = obtener_valores_parametros();

            // verificar el estado del alumno
        $estadoAlumno = ($cantInasistenciaAlumno > $resultParametros['nmaximo_inasitencias']) ? true : false;

            // se elige clase de css segun la cantidad de faltas obtenidas 
        $colorClase = ($estadoAlumno) ? 'bg-warning' : 'bg-success';


        if ($cantInasistenciaAlumno >= $resultParametros['nvalor_reincorporacion'] || $division_alumnos['cdescripcion_estadoalumno'] == "REINCORPORAR") {

          modificar_estado_alumno($division_alumnos['alumno_id'], '10', '1');

          $propCheck = 'disabled';

          $colorClase = 'bg-danger';            

        }else{

          $propCheck = '';
        }
            // se elige la estado de los check segun las faltas obtenidas

        $tabla_asistencia_alumnos.= "<tr class='".$colorClase."'>
        <td class='text-center'>".$division_alumnos['capellidos_persona']."</td>
        <td class='text-center'>".$division_alumnos['cnombres_persona']."</td>
        <td class='text-center'>".$division_alumnos['ndni_persona']."</td>
        <td class='text-center'>".$division_alumnos['cdescripcion_estadoalumno']."</td>
        <td class='text-center'>".$cantInasistenciaAlumno."</td>
        <td class='text-center'>".
        obtener_porcentaje_inasistencia_alumno($argIdAnoLectivo, $argIdCurso, $argIdTrayectos, $division_alumnos['alumno_id'])
        ."%</td>
        <td class='text-center'>".
        count(obtener_Total_Inasistencia_Alumnos($argIdAnoLectivo, $division_alumnos['alumno_id'], $argIdTrayectos)).
        "</td>";
    		// Seccion checkbox
        if (!empty($arg_resultado_inasistencia_alumnos)) {

    			// Consulto la asistencia de un alumno en el dia segun el trayecto
         $tabla_asistencia_alumnos.= verificar_Asistencia_Alumnos($arg_resultado_inasistencia_alumnos, $division_alumnos['alumno_id'], $propCheck);

    			// Consulto si esta justificada la inasistencia si es que falto
         $tabla_asistencia_alumnos .= verificar_Justificacion_Inasistencia_Alumno($arg_resultado_inasistencia_alumnos, $division_alumnos['alumno_id'], $propCheck);
    			// Consulto si tiene tardanza el alumno
         $tabla_asistencia_alumnos .= verificar_Tardanza_Asistencia_Alumno($arg_resultado_inasistencia_alumnos, $division_alumnos['alumno_id'], $propCheck);

       }else{

         $tabla_asistencia_alumnos .= "<td class='text-center'><input type='checkbox' class='form-check-input' ".$propCheck." checked id='checkInasistencia' value=".$division_alumnos['alumno_id']."></td>";
         $tabla_asistencia_alumnos .= "<td class='text-center'><input type='checkbox' class='form-check-input' ".$propCheck." id='checkAsistenciaJustificacion' disabled></td>";

         $tabla_asistencia_alumnos .= "<td class='text-center'><input type='checkbox' class='form-check-input' ".$propCheck." id='checkAsistenciaTardanza' value=".$division_alumnos['alumno_id']."></td>";
       }


     }
     $tabla_asistencia_alumnos .= "</tbody></table><br>";
     $tabla_asistencia_alumnos .= obtener_Preceptor_Division_Alumnos($argIdCurso, $argIdTrayectos);

     $tabla_asistencia_alumnos .= "<input type='button' name='guardarInasistencia' id='guardarInasistencia' class='float-right btn btn-success' value='Guardar Inasistencias'>";

     $tabla_asistencia_alumnos .= "</div>";
     return $tabla_asistencia_alumnos;

   }

// Funcion para obtener al preceptor del curso
   function obtener_Preceptor_Division_Alumnos($argIdCurso,$argIdTrayectos){

	//Obtengo a todos los preceptores activos
     $resultadoPreceptores = buscar_preceptores();

	// Obtengo al preceptor del curso actual
     $resultadoPreceptorCurso = verificarHorariosCursos($argIdCurso,$argIdTrayectos);


     $listaPreceptores="<select class='form-control' name='preceptores_asistencia_alumnos' id='preceptores_asistencia_alumnos'>";

     $listaPreceptores .= "<option disabled value='0'>Elija un Preceptor:</option>";

     foreach ($resultadoPreceptores as $key => $preceptor) {

      if ($resultadoPreceptorCurso['rela_preceptor_id'] == $preceptor['preceptor_id']) {

       $listaPreceptores .= "<option selected disabled value=". $preceptor['preceptor_id'] .">".$preceptor['capellidos_persona']." ".$preceptor['cnombres_persona']."</option>";

     }else{
       $listaPreceptores .= "<option value=". $preceptor['preceptor_id'] .">".$preceptor['capellidos_persona']." ".$preceptor['cnombres_persona']."</option>";
     }

   }

   $listaPreceptores .= "</select><br>";

   return $listaPreceptores;
 }


// Funcion para obtener el total de la inasistencia de un alumno
 function obtener_Total_Inasistencia_Alumnos($argIdAnoLectivo, $argIdAlumno, $argIdTrayectos){

   $resultado_total_inasistencia_alumno = array();

   $db = new ConexionDB;

   $conexion = $db->retornar_conexion();

   $sql_inasistencias_alumnos_trayectos = "
   SELECT * FROM divisiones_inasistencias d1, alumnos a1, personas p1, estado_alumnos e1 WHERE d1.rela_anolectivo_id = :argrela_anolectivo_id AND d1.rela_trayecto_id = :argrela_trayecto_id AND d1.rela_alumno_id = a1.alumno_id AND a1.rela_persona_id = p1.persona_id AND a1.rela_estadoalumno_id = e1.estadoalumno_id AND (e1.cdescripcion_estadoalumno = 'CURSANTE' OR e1.cdescripcion_estadoalumno = 'REPITENTE' OR e1.cdescripcion_estadoalumno = 'LIBRE' OR e1.cdescripcion_estadoalumno = 'REINCORPORAR') AND d1.btardanza_asistencia = 0 AND a1.alumno_id = :alumno_id
   ";

   $statement = $conexion->prepare($sql_inasistencias_alumnos_trayectos);

	        $statement->bindParam(':alumno_id' , $argIdAlumno);  // reemplazo los parametros enlazados 
	        $statement->bindParam(':argrela_trayecto_id' , $argIdTrayectos);  // reemplazo los parametros enlazados 
	        $statement->bindParam(':argrela_anolectivo_id' , $argIdAnoLectivo);  // reemplazo los parametros enlazados 

	        $statement->execute();

	        while($resultado = $statement->fetch(PDO::FETCH_ASSOC)){
	        	$resultado_total_inasistencia_alumno[]= $resultado;
	        }
	        return $resultado_total_inasistencia_alumno;
       }


// Funcion para verificar la asistencia de un alumno en el dia, dependiendo del trayecto
       function verificar_Asistencia_Alumnos($arg_resultado_inasistencia_alumnos, $argIdAlumno, $arg_PropCheck){

        $checkAsistencia="";
        foreach ($arg_resultado_inasistencia_alumnos as $key => $inasistencia_alumnos) {

         if ($inasistencia_alumnos['rela_alumno_id'] == $argIdAlumno && $inasistencia_alumnos['btardanza_asistencia'] == 0) {

          $checkAsistencia .= "<td class='text-center'><input type='checkbox' class='form-check-input' id='checkInasistencia' ".$arg_PropCheck." value=".$argIdAlumno."></td>"; 
        }

      }

      if (!empty($checkAsistencia)) {
       return $checkAsistencia;
     }else{
       return "<td class='text-center'><input type='checkbox' class='form-check-input' id='checkInasistencia' ".$arg_PropCheck." checked value=".$argIdAlumno."></td>";	
     }

   }

// Funcion para obtener si la falta esta justificada

   function obtener_Justificacion_Inasistencia_Alumno($arg_resultado_inasistencia_alumnos, $arg_Id_Alumno){

	    	// return $arg_resultado_inasistencia_alumnos;
    $db = new ConexionDB;

    $conexion = $db->retornar_conexion();
    try {


     foreach ($arg_resultado_inasistencia_alumnos as $key => $inasistencia_alumnos) {

    		// return $inasistencia_alumnos['dfecha_inasistencia'];

      $sql_justificacion_alumnos = "SELECT * FROM divisiones_inasistencias WHERE binasistencia_justificada > 0 AND rela_alumno_id = :argrela_alumno_id AND rela_trayecto_id = :argrela_trayecto_id AND dfecha_inasistencia = :ardfecha_inasistencia AND rela_anolectivo_id = :argrela_anolectivo_id AND rela_curso_id = :argrela_curso_id";

      $statement = $conexion->prepare($sql_justificacion_alumnos);

		        $statement->bindParam(':argrela_alumno_id' , $arg_Id_Alumno);  // reemplazo los parametros enlazados 
		        $statement->bindParam(':argrela_trayecto_id' , $inasistencia_alumnos['rela_trayecto_id']);  // reemplazo los parametros enlazados 
		        $statement->bindParam(':argrela_anolectivo_id' , $inasistencia_alumnos['rela_anolectivo_id']);  // reemplazo los parametros enlazados 
		        $statement->bindParam(':argrela_curso_id' , $inasistencia_alumnos['rela_curso_id']);  // reemplazo los parametros enlazados 
		        
		        $statement->bindParam(':ardfecha_inasistencia' , $inasistencia_alumnos['dfecha_inasistencia']);  // reemplazo los parametros enlazados 

		        $statement->execute();
		        

		        if (!$statement){
		            // no se encontraron paises
		        }
		        // cierro la conexion
		        // $statement = $conexion->cerrar_conexion();
          }

          return $statement->rowCount();

        } catch (PDOException $e) {
    //Do your error handling here
         $message = $e->getMessage();
       }
     }

// Funcion para armar las casillas de la justificacion de la inasistencia de alumnos

     function verificar_Justificacion_Inasistencia_Alumno($arg_resultado_inasistencia_alumnos, $arg_Id_Alumno, $arg_PropCheck){

      $resultJustificacionInasitenciaAlumnos = obtener_Justificacion_Inasistencia_Alumno($arg_resultado_inasistencia_alumnos, $arg_Id_Alumno);

      $inputCheckJustificacionAlumnos = "";

      if ($resultJustificacionInasitenciaAlumnos > 0) {
       $inputCheckJustificacionAlumnos = "<td class='text-center'><input type='checkbox' class='form-check-input' id='checkAsistenciaJustificacion' ".$arg_PropCheck." checked disabled></td>";
     }else{
       $inputCheckJustificacionAlumnos = "<td class='text-center'><input type='checkbox' class='form-check-input' id='checkAsistenciaJustificacion' ".$arg_PropCheck." disabled></td>";
     }
     return $inputCheckJustificacionAlumnos;

   }

// Funcion para obtener la tardanza de un alumno

   function verificar_Tardanza_Alumno($arg_resultado_inasistencia_alumnos, $arg_Id_Alumno){

	    	// return $arg_resultado_inasistencia_alumnos;
    $db = new ConexionDB;

    $conexion = $db->retornar_conexion();
    try {


     foreach ($arg_resultado_inasistencia_alumnos as $key => $inasistencia_alumnos) {

    		// return $inasistencia_alumnos['dfecha_inasistencia'];

      $sql_tardanza_alumnos = "SELECT * FROM divisiones_inasistencias WHERE btardanza_asistencia > 0 AND rela_alumno_id = :argrela_alumno_id AND rela_trayecto_id = :argrela_trayecto_id AND dfecha_inasistencia = :ardfecha_inasistencia AND rela_anolectivo_id = :argrela_anolectivo_id AND rela_curso_id = :argrela_curso_id";

      $statement = $conexion->prepare($sql_tardanza_alumnos);

		        $statement->bindParam(':argrela_alumno_id' , $arg_Id_Alumno);  // reemplazo los parametros enlazados 
		        $statement->bindParam(':argrela_trayecto_id' , $inasistencia_alumnos['rela_trayecto_id']);  // reemplazo los parametros enlazados 
		        $statement->bindParam(':argrela_anolectivo_id' , $inasistencia_alumnos['rela_anolectivo_id']);  // reemplazo los parametros enlazados 
		        $statement->bindParam(':argrela_curso_id' , $inasistencia_alumnos['rela_curso_id']);  // reemplazo los parametros enlazados 
		        
		        $statement->bindParam(':ardfecha_inasistencia' , $inasistencia_alumnos['dfecha_inasistencia']);  // reemplazo los parametros enlazados 

		        $statement->execute();
		        

		        if (!$statement){
		            // no se encontraron paises
		        }
		        // cierro la conexion
		        // $statement = $conexion->cerrar_conexion();
          }

          return $statement->rowCount();

        } catch (PDOException $e) {
    //Do your error handling here
         $message = $e->getMessage();
       }
     }

// Funcion para armar las casillas de la tardanza de la asistencia de alumnos

     function verificar_Tardanza_Asistencia_Alumno($arg_resultado_inasistencia_alumnos, $arg_Id_Alumno, $arg_PropCheck){

      $resultTardanzaAsitenciaAlumnos = verificar_Tardanza_Alumno($arg_resultado_inasistencia_alumnos, $arg_Id_Alumno);

      $inputCheckTardanzaAlumnos = "";

      if ($resultTardanzaAsitenciaAlumnos > 0) {
       $inputCheckTardanzaAlumnos = "<td class='text-center'><input type='checkbox' class='form-check-input' id='checkAsistenciaTardanza' ".$arg_PropCheck." checked value=".$arg_Id_Alumno."></td>";
     }else{
       $inputCheckTardanzaAlumnos = "<td class='text-center'><input type='checkbox' class='form-check-input' id='checkAsistenciaTardanza' ".$arg_PropCheck." value=".$arg_Id_Alumno."></td>";
     }
     return $inputCheckTardanzaAlumnos;

   }






// obtener total de dias de clases del curso
   function obtener_total_asistencias($argIdAnoLectivo, $argIdCurso, $argIdTrayectos){
    $db = new ConexionDB;

    $conexion = $db->retornar_conexion();

    $sql_inasistencias_alumnos_trayectos = "SELECT * FROM divisiones_horarios_materias d1 WHERE d1.rela_anolectivo_id = :argrela_anolectivo_id AND d1.rela_curso_id = :rela_curso_id AND d1.rela_trayecto_id = :argrela_trayecto_id";

    $statement = $conexion->prepare($sql_inasistencias_alumnos_trayectos);

		$statement->bindParam(':rela_curso_id' , $argIdCurso);  // reemplazo los parametros enlazados 
		$statement->bindParam(':argrela_trayecto_id' , $argIdTrayectos);  // reemplazo los parametros enlazados 
		$statement->bindParam(':argrela_anolectivo_id' , $argIdAnoLectivo);  // reemplazo los parametros enlazados 

		$statement->execute();

		return $statement->rowCount();

	}

// Funcion para obtener total de inasistencias justificadas de un alumno

	function obtener_Total_Inasistencias_Justificadas_Alumnos($argIdAnoLectivo, $argIdCurso, $argIdTrayectos, $argIdAlumno){

		$db = new ConexionDB;

		$conexion = $db->retornar_conexion();

		$sql_inasistencias_alumnos_trayectos = "SELECT * FROM divisiones_inasistencias d1 WHERE d1.rela_anolectivo_id = :argrela_anolectivo_id AND d1.rela_curso_id = :rela_curso_id AND d1.rela_trayecto_id = :argrela_trayecto_id AND d1.rela_alumno_id = :argrela_alumno_id AND d1.binasistencia_justificada = 1";

		$statement = $conexion->prepare($sql_inasistencias_alumnos_trayectos);

		$statement->bindParam(':rela_curso_id' , $argIdCurso);  // reemplazo los parametros enlazados 
		$statement->bindParam(':argrela_trayecto_id' , $argIdTrayectos);  // reemplazo los parametros enlazados 
		$statement->bindParam(':argrela_anolectivo_id' , $argIdAnoLectivo);  // reemplazo los parametros enlazados 
		
		$statement->bindParam(':argrela_alumno_id' , $argIdAlumno);  // reemplazo los parametros enlazados 

		$statement->execute();

		return $statement->rowCount();
	}
// obtener el porcentaje de asistencia de un alumno
	function obtener_porcentaje_inasistencia_alumno($argIdAnoLectivo, $argIdCurso, $argIdTrayectos, $argIdAlumno){

		// 100%
		$total_asistencia = obtener_total_asistencias($argIdAnoLectivo, $argIdCurso, $argIdTrayectos);

		// 2
		$total_inasistencia_alumno = count(obtener_Total_Inasistencia_Alumnos($argIdAnoLectivo, $argIdAlumno, $argIdTrayectos));
		
		$total_inasistencia_alumno_justificado = obtener_Total_Inasistencias_Justificadas_Alumnos($argIdAnoLectivo, $argIdCurso, $argIdTrayectos, $argIdAlumno);

		// return $total_inasistencia_alumno - $total_inasistencia_alumno_justificado;
		if ($total_inasistencia_alumno > 0) {

			$total_inasistencia_alumno = $total_inasistencia_alumno- $total_inasistencia_alumno_justificado;
			
			$result_asistencia_alumno = $total_inasistencia_alumno/$total_asistencia;
			$result_asistencia_alumno = $result_asistencia_alumno * 100;
		}else{	
			$result_asistencia_alumno = 0;
		}

		// $total_asistencia_alumno = 100;

		return $result_asistencia_alumno;

	}

// insertar la inasistencia de un alumno
	function insertar_Asistencia_Alumnos($argFechaAsistencia, $argJustificacionSituacionDia, $argIdAnoLectivo, $argIdCursos, $argIdTrayectos, $argIdAlumnosAsistencia){

		try {

			$db = new ConexionDB;

			$conexion = $db->retornar_conexion();

			$sql_asistencia_alumnos = "INSERT INTO divisiones_inasistencias(dfecha_inasistencia, binasistencia_justificada, rela_anolectivo_id, rela_curso_id, rela_trayecto_id, rela_alumno_id, rela_documentos_personas_id) VALUES (:argdfecha_inasistencia, :argbinasistencia_justificada, :argrela_anolectivo_id, :argrela_curso_id, :argrela_trayecto_id, :argrela_alumno_id, 0)";

			$statement = $conexion->prepare($sql_asistencia_alumnos);

			$statement->bindParam(':argdfecha_inasistencia' , $argFechaAsistencia);  // reemplazo los parametros enlazados 
			$statement->bindParam(':argbinasistencia_justificada' , $argJustificacionSituacionDia);  // reemplazo los parametros enlazados 
			$statement->bindParam(':argrela_anolectivo_id' , $argIdAnoLectivo);  // reemplazo los parametros enlazados 
			$statement->bindParam(':argrela_curso_id' , $argIdCursos);  // reemplazo los parametros enlazados 
			$statement->bindParam(':argrela_trayecto_id' , $argIdTrayectos);  // reemplazo los parametros enlazados 
			$statement->bindParam(':argrela_alumno_id' , $argIdAlumnosAsistencia);  // reemplazo los parametros enlazados 

			if (!$statement->execute()) {
				return($statement->errorInfo());
			}
			return true;

		} catch (PDOException $e) {
			echo "Mensaje de la excepción: ".$e->getMessage()."<br>";
			return false;
		}
	}

// modificar la inasistencia de un alumno
	function modificar_Asistencia_Alumnos($argFechaAsistencia, $argJustificacionSituacionDia, $argIdAnoLectivo, $argIdCursos, $argIdTrayectos, $argIdAlumnosAsistencia){

		try {

			$db = new ConexionDB;

			$conexion = $db->retornar_conexion();

			$sql_asistencia_alumnos = "DELETE FROM divisiones_inasistencias WHERE dfecha_inasistencia = :argdfecha_inasistencia AND rela_anolectivo_id = :argrela_anolectivo_id AND rela_curso_id = :argrela_curso_id AND rela_trayecto_id = :argrela_trayecto_id AND rela_alumno_id = :argrela_alumno_id";

			$statement = $conexion->prepare($sql_asistencia_alumnos);

			$statement->bindParam(':argdfecha_inasistencia' , $argFechaAsistencia);  // reemplazo los parametros enlazados 
			// $statement->bindParam(':argbinasistencia_justificada' , $argJustificacionSituacionDia);  // reemplazo los parametros enlazados 
			$statement->bindParam(':argrela_anolectivo_id' , $argIdAnoLectivo);  // reemplazo los parametros enlazados 
			$statement->bindParam(':argrela_curso_id' , $argIdCursos);  // reemplazo los parametros enlazados 
			$statement->bindParam(':argrela_trayecto_id' , $argIdTrayectos);  // reemplazo los parametros enlazados 
			$statement->bindParam(':argrela_alumno_id' , $argIdAlumnosAsistencia);  // reemplazo los parametros enlazados 

			if (!$statement->execute()) {
				return($statement->errorInfo());
			}
			return true;

		} catch (PDOException $e) {
			return "Mensaje de la excepción: ".$e->getMessage()."<br>";
			// return false;
		}
	}


	function buscar_Inasistencia_Fecha_Alumno($argIdAnoLectivo, $argIdTrayectos, $argIdAlumno, $fechaJustificacionAlumno){

		//============================================================================================
		//Busco las inasistencias de un alumno en una fecha
		//============================================================================================

		$resultado_fecha_inasistencia_alumno = array();  // creo un array que va a almacenar la informacion de las inasistencias de los alumnos

		$db = new ConexionDB;
		$conexion = $db->retornar_conexion();

		$sql_total_inasistencia_alumno = "SELECT * FROM divisiones_inasistencias d1, alumnos a1, personas p1 WHERE d1.rela_alumno_id = a1.alumno_id AND a1.rela_persona_id = p1.persona_id AND d1.rela_anolectivo_id = :argrela_anolectivo_id AND d1.rela_trayecto_id = :argrela_trayecto_id AND d1.rela_alumno_id = :rela_alumno_id AND d1.dfecha_inasistencia = :argdfecha_inasistencia AND d1.binasistencia_justificada = 0"; // busca las inasistencias que coincidad con esa fecha

		$statement = $conexion->prepare($sql_total_inasistencia_alumno);

        $statement->bindParam(':argrela_anolectivo_id' , $argIdAnoLectivo);  // reemplazo los parametros enlazados 

		$statement->bindParam(':argrela_trayecto_id' , $argIdTrayectos);  // reemplazo los parametros enlazados 

        $statement->bindParam(':rela_alumno_id' , $argIdAlumno);  // reemplazo los parametros enlazados 

        $statement->bindParam(':argdfecha_inasistencia' , $fechaJustificacionAlumno);  // reemplazo los parametros enlazados 
        

        $statement->execute();

        
        if (!$statement){
            // no se encontraron paises
        }else{
            // reviso el retorno
        	while($resultado = $statement->fetch(PDO::FETCH_ASSOC)){
        		$resultado_fecha_inasistencia_alumno[]= $resultado;
        	}
        }
        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);
        

        return $resultado_fecha_inasistencia_alumno;
        
      }


// insertar la tardanza de un alumno
      function insertar_Tardanza_Asistencia_Alumnos($argFechaAsistencia, $argIdAnoLectivo, $argIdCursos, $argIdTrayectos, $argIdAlumnosTardanza){

       try {

        $db = new ConexionDB;

        $conexion = $db->retornar_conexion();

        $sql_asistencia_alumnos = "INSERT INTO divisiones_inasistencias(dfecha_inasistencia, btardanza_asistencia, rela_anolectivo_id, rela_curso_id, rela_trayecto_id, rela_alumno_id, rela_documentos_personas_id) VALUES (:argdfecha_inasistencia, 1, :argrela_anolectivo_id, :argrela_curso_id, :argrela_trayecto_id, :argrela_alumno_id, 0)";

        $statement = $conexion->prepare($sql_asistencia_alumnos);

			$statement->bindParam(':argdfecha_inasistencia' , $argFechaAsistencia);  // reemplazo los parametros enlazados 
			// $statement->bindParam(':argbinasistencia_justificada' , $argJustificacionSituacionDia);  // reemplazo los parametros enlazados 
			$statement->bindParam(':argrela_anolectivo_id' , $argIdAnoLectivo);  // reemplazo los parametros enlazados 
			// $statement->bindParam(':argbtardanza_asistencia' , "1");  // reemplazo los parametros enlazados 
			$statement->bindParam(':argrela_curso_id' , $argIdCursos);  // reemplazo los parametros enlazados 
			$statement->bindParam(':argrela_trayecto_id' , $argIdTrayectos);  // reemplazo los parametros enlazados 
			$statement->bindParam(':argrela_alumno_id' , $argIdAlumnosTardanza);  // reemplazo los parametros enlazados 

			if (!$statement->execute()) {
				return($statement->errorInfo());
			}
			return true;

		} catch (PDOException $e) {
			return "Mensaje de la excepción: ".$e->getMessage()."<br>";
			// return false;
		}
	}

// Modificar tardanza de un alumno
  function modificar_Tardanza_Asistencia_Alumnos($argFechaAsistencia, $argIdAnoLectivo, $argIdCursos, $argIdTrayectos, $argIdAlumnosTardanza){

    try {

     $db = new ConexionDB;

     $conexion = $db->retornar_conexion();

     $sql_asistencia_alumnos = "DELETE FROM divisiones_inasistencias WHERE dfecha_inasistencia = :argdfecha_inasistencia AND rela_anolectivo_id = :argrela_anolectivo_id AND rela_curso_id = :argrela_curso_id AND rela_trayecto_id = :argrela_trayecto_id AND rela_alumno_id = :argrela_alumno_id";

     $statement = $conexion->prepare($sql_asistencia_alumnos);

			$statement->bindParam(':argdfecha_inasistencia' , $argFechaAsistencia);  // reemplazo los parametros enlazados 
			// $statement->bindParam(':argbinasistencia_justificada' , $argJustificacionSituacionDia);  // reemplazo los parametros enlazados 
			$statement->bindParam(':argrela_anolectivo_id' , $argIdAnoLectivo);  // reemplazo los parametros enlazados 
			$statement->bindParam(':argrela_curso_id' , $argIdCursos);  // reemplazo los parametros enlazados 
			$statement->bindParam(':argrela_trayecto_id' , $argIdTrayectos);  // reemplazo los parametros enlazados 
			$statement->bindParam(':argrela_alumno_id' , $argIdAlumnosTardanza);  // reemplazo los parametros enlazados 

			if (!$statement->execute()) {
				return($statement->errorInfo());
			}
			return true;

		} catch (PDOException $e) {
			return "Mensaje de la excepción: ".$e->getMessage()."<br>";
			// return false;
		}
	}



    // Funcion para obtener el valor total de la inasistencia de un alumno
  function obtener_Total_Valor_Inasistencia_Alumnos($argIdAnoLectivo, $argIdAlumno, $argIdTrayectos, $argIdCurso){

    $resultado_total_valor_inasistencia_alumno =  "";

    $db = new ConexionDB;

    $conexion = $db->retornar_conexion();

    $sql_total_valor_inasistencia_alumno = "
    SELECT SUM(d2.nvalor_inasistencia) AS 'valor_total_inasistencia' FROM divisiones_inasistencias d1, divisiones_horarios_materias d2 WHERE d1.dfecha_inasistencia = d2.dfecha_horario AND d1.binasistencia_justificada = 0 AND d1.btardanza_asistencia = 0 AND d1.rela_anolectivo_id = :argrela_anolectivo_id AND d1.rela_curso_id = :argrela_curso_id AND d1.rela_trayecto_id = :argrela_trayecto_id AND d1.rela_alumno_id = :argrela_alumno_id";

    $statement = $conexion->prepare($sql_total_valor_inasistencia_alumno);

            $statement->bindParam(':argrela_alumno_id' , $argIdAlumno);  // reemplazo los parametros enlazados 
            $statement->bindParam(':argrela_trayecto_id' , $argIdTrayectos);  // reemplazo los parametros enlazados 
            $statement->bindParam(':argrela_anolectivo_id' , $argIdAnoLectivo);  // reemplazo los parametros enlazados 
            $statement->bindParam(':argrela_curso_id' , $argIdCurso);  // reemplazo los parametros enlazados 

            $statement->execute();
            $resultado = $statement->fetch(PDO::FETCH_ASSOC);
            
            $resultado_total_valor_inasistencia_alumno = $resultado['valor_total_inasistencia'];
            
            return $resultado_total_valor_inasistencia_alumno;
          }

// Funcion para obtener el valor total de las tardanzas de un alumno
          function obtener_Total_Valor_Tardanza_Alumnos($argIdAnoLectivo, $argIdAlumno, $argIdTrayectos, $argIdCurso){

            $resultado_total_valor_tardanza_alumno =  "";

            $db = new ConexionDB;

            $conexion = $db->retornar_conexion();

            $sql_total_valor_tardanza_alumno = "
            SELECT 0.25 * COUNT(*) AS 'valor_total_tardanza' FROM divisiones_inasistencias d1, divisiones_horarios_materias d2 WHERE d1.dfecha_inasistencia = d2.dfecha_horario AND d1.binasistencia_justificada = 0 AND d1.btardanza_asistencia = 1 AND d1.rela_anolectivo_id = :argrela_anolectivo_id AND d1.rela_curso_id = :argrela_curso_id AND d1.rela_trayecto_id = :argrela_trayecto_id AND d1.rela_alumno_id = :argrela_alumno_id";

            $statement = $conexion->prepare($sql_total_valor_tardanza_alumno);

            $statement->bindParam(':argrela_alumno_id' , $argIdAlumno);  // reemplazo los parametros enlazados 
            $statement->bindParam(':argrela_trayecto_id' , $argIdTrayectos);  // reemplazo los parametros enlazados 
            $statement->bindParam(':argrela_anolectivo_id' , $argIdAnoLectivo);  // reemplazo los parametros enlazados 
            $statement->bindParam(':argrela_curso_id' , $argIdCurso);  // reemplazo los parametros enlazados 

            $statement->execute();
            $resultado = $statement->fetch(PDO::FETCH_ASSOC);
            
            $resultado_total_valor_tardanza_alumno = $resultado['valor_total_tardanza'];
            
            return $resultado_total_valor_tardanza_alumno;
          }
