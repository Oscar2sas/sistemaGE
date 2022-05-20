<?php 


function armar_lista_materias_docentes($arg_result_materias_docentes){
	
	$lista_materias_docentes = "<label for='materiasAsistenciaAlumnosDocentes'>Seleccione la Materia</label>";
	
	$lista_materias_docentes .= "<select class='form-control' id='materiasAsistenciaAlumnosDocentes'>
	<option selected disabled value='0'>Elija una materia:</option>";




	foreach ($arg_result_materias_docentes as $result_materias) {
		
		$lista_materias_docentes .= "<option value=".$result_materias['materia_id'].">".$result_materias['cnombre_materia']."</option>";
	}

	$lista_materias_docentes .= "</select>";


	return $lista_materias_docentes;
}


function buscar_inasistencias_alumnos_docentes($argIdAnoLectivo, $argFechaInasistencia, $argIdMateria, $argIdTrayecto, $argIdCursos){
	

	// cambiar por session
	$arg_id_docente = 1;

	$resultadoAsistenciaAlumnosDocentes = array();	

	$db = new ConexionDB;
	$conexion = $db->retornar_conexion();
	try {
		$sql_asistencia_alumnos_docentes = "SELECT * FROM inasistencia_alumno_docentes i1 WHERE i1.rela_anolectivo_id = :argrela_anolectivo_id AND i1.dfecha_inasistencia = :argdfecha_inasistencia AND i1.rela_docente_id = :argrela_docente_id AND i1.rela_materia_id = :argrela_materia_id AND i1.rela_trayecto_id = :argrela_trayecto_id AND i1.rela_curso_id = :argrela_curso_id";

		$statement = $conexion->prepare($sql_asistencia_alumnos_docentes);

        $statement->bindParam(':argrela_anolectivo_id' , $argIdAnoLectivo);  // reemplazo los parametros enlazados 
        $statement->bindParam(':argdfecha_inasistencia' , $argFechaInasistencia);  // reemplazo los parametros enlazados 
        $statement->bindParam(':argrela_docente_id' , $arg_id_docente);  // reemplazo los parametros enlazados 
        $statement->bindParam(':argrela_materia_id' , $argIdMateria);  // reemplazo los parametros enlazados 
        $statement->bindParam(':argrela_trayecto_id' , $argIdTrayecto);  // reemplazo los parametros enlazados 
        $statement->bindParam(':argrela_curso_id' , $argIdCursos);  // reemplazo los parametros enlazados 

        if (!$statement->execute()) {
        	return array('estado' => false,'mensaje' => $statement->errorInfo());
        }

        while($resultado = $statement->fetch(PDO::FETCH_ASSOC)){
        	$resultadoAsistenciaAlumnosDocentes[] = $resultado;
        }

    } catch (PDOException $e) {
    	return array('estado' => false,'mensaje' => "Mensaje de la excepción: ".$e->getMessage()."<br>");
    }
        // cierro la conexion
    $statement = $db->cerrar_conexion($conexion);

    return array('estado' => true,'mensaje' => $resultadoAsistenciaAlumnosDocentes);

}


function armar_tabla_asistencias_alumnos($arg_resultado_inasistencia_alumnos_docente, $result_division_alumnos, $argIdAnoLectivo, $argIdMateria, $argIdCursos, $argIdTrayecto){
	

	$tabla_asistencia_alumnos_docentes = "

	<div id='tablaAsistenciaAlumnosDocentes'>
	<table id='table' class='table table-stripped table-bordered nowrap cellspacing=' width='100%'>

	<thead class='thead-dark'>
	<tr>
	<th class='text-center'>Apellido</th>
	<th class='text-center'>Nombre</th>
	<th class='text-center'>Dni</th>
	<th class='text-center'>Estado Alumno</th>
	<th class='text-center'>Porcentaje de Inasistencias</th>
	<th class='text-center'>P/A[x]</th>

	</tr>
	</thead>

	<tbody>";

        // CUERPO TABLA

	foreach ($result_division_alumnos as $key => $division_alumnos) {

		$total_porcentaje_inaasistencia_alumno = obtener_porcentaje_inasistencia_alumno_docentes($argIdAnoLectivo, $argIdMateria, $argIdCursos, $argIdTrayecto, $division_alumnos['alumno_id']);

		$class_porcentaje_asistencia = ($total_porcentaje_inaasistencia_alumno >= 50) ? 'bg-danger' : 'bg-success';

		$tabla_asistencia_alumnos_docentes.= "<tr class='".$class_porcentaje_asistencia."'>
		<td class='text-center'>".$division_alumnos['capellidos_persona']."</td>
		<td class='text-center'>".$division_alumnos['cnombres_persona']."</td>
		<td class='text-center'>".$division_alumnos['ndni_persona']."</td>
		<td class='text-center'>".$division_alumnos['cdescripcion_estadoalumno']."</td>
		<td class='text-center'>".$total_porcentaje_inaasistencia_alumno."%</td>

		";
		
    		// Seccion checkbox
		if (!empty($arg_resultado_inasistencia_alumnos_docente)) {

    			// Consulto la asistencia de un alumno en el dia segun el trayecto
			$tabla_asistencia_alumnos_docentes.= verificar_Asistencia_Alumnos_Docentes($arg_resultado_inasistencia_alumnos_docente, $division_alumnos['alumno_id']);

		}else{

			$tabla_asistencia_alumnos_docentes .= "<td class='text-center'><input type='checkbox' class='form-check-input'checked id='checkInasistenciaAlumnosDocentes' value=".$division_alumnos['alumno_id']."></td>";
		}


	}
	$tabla_asistencia_alumnos_docentes .= "</tbody></table><br>";

	$tabla_asistencia_alumnos_docentes .= "
	<div><label>(LOS ALUMNOS EN COLOR VERDE ESTAN APTO PARA RENDIR)</label></div>
	<div><label>(LOS ALUMNOS EN COLOR ROJO NO ESTAN APTO PARA RENDIR)</label></div>
	";

	$result_alumnos_no_aptos = obtener_alumnos_segun_estado('12');

	if (!empty($result_alumnos_no_aptos)) {

		$tabla_asistencia_alumnos_docentes .= "
			<div><label>NOTA(LOS SIGUIENTES ALUMNOS AUN NO ESTAN APTO PARA CURSAR: )</label></div>";

		foreach ($result_alumnos_no_aptos as $alum_no_aptos) {
			$tabla_asistencia_alumnos_docentes .= "
			<div><label>*".$alum_no_aptos['capellidos_persona']." ".$alum_no_aptos['cnombres_persona']."</label></div>";	
		}
	}

	$tabla_asistencia_alumnos_docentes .= "<input type='button' name='guardarInasistenciaAlumnos' id='guardarInasistenciaAlumnosDocentes' class='float-right btn btn-success' value='Guardar Inasistencias'>";

	$tabla_asistencia_alumnos_docentes .= "</div>";
	return $tabla_asistencia_alumnos_docentes;

}

// Funcion para verificar la asistencia de un alumno en el dia, dependiendo del trayecto
function verificar_Asistencia_Alumnos_Docentes($arg_resultado_inasistencia_alumnos_docentes, $argIdAlumno){

	$checkAsistencia="";
	foreach ($arg_resultado_inasistencia_alumnos_docentes as $inasistencia_alumnos_docentes) {

		if ($inasistencia_alumnos_docentes['rela_alumno_id'] == $argIdAlumno) {

			$checkAsistencia .= "<td class='text-center'><input type='checkbox' class='form-check-input' id='checkInasistenciaAlumnosDocentes' value=".$argIdAlumno."></td>"; 
		}

	}
	if (!empty($checkAsistencia)) {
		return $checkAsistencia;
	}else{
		return "<td class='text-center'><input type='checkbox' class='form-check-input' id='checkInasistenciaAlumnosDocentes' checked value=".$argIdAlumno."></td>";	
	}

}

function insertar_inasistencia_alumnos_docentes($arg_id_ano_lectivo, $arg_alumno_id, $arg_fecha_inasistencia, $arg_docente_id, $arg_materia_id, $arg_trayecto_id, $arg_curso_id){


	$db = new ConexionDB;
	$conexion = $db->retornar_conexion();
	try {
		$sql_asistencia_alumnos_docentes = "INSERT INTO inasistencia_alumno_docentes(rela_anolectivo_id, rela_alumno_id, dfecha_inasistencia, rela_docente_id, rela_materia_id, rela_trayecto_id, rela_curso_id) VALUES (:argrela_anolectivo_id, :argrela_alumno_id, :argdfecha_inasistencia, :argrela_docente_id, :argrela_materia_id, :argrela_trayecto_id, :argrela_curso_id)";

		$statement = $conexion->prepare($sql_asistencia_alumnos_docentes);

        $statement->bindParam(':argrela_anolectivo_id' , $arg_id_ano_lectivo);  // reemplazo los parametros enlazados 
        $statement->bindParam(':argrela_alumno_id' , $arg_alumno_id);  // reemplazo los parametros enlazados 
        $statement->bindParam(':argdfecha_inasistencia' , $arg_fecha_inasistencia);  // reemplazo los parametros enlazados 
        $statement->bindParam(':argrela_docente_id' , $arg_docente_id);  // reemplazo los parametros enlazados 
        $statement->bindParam(':argrela_materia_id' , $arg_materia_id);  // reemplazo los parametros enlazados 
        $statement->bindParam(':argrela_trayecto_id' , $arg_trayecto_id);  // reemplazo los parametros enlazados 
        $statement->bindParam(':argrela_curso_id' , $arg_curso_id);  // reemplazo los parametros enlazados 

        if (!$statement->execute()) {
        	return array('estado' => false,'mensaje' => $statement->errorInfo());
        }

    } catch (PDOException $e) {
    	return array('estado' => false,'mensaje' => "Mensaje de la excepción: ".$e->getMessage()."<br>");
    }
        // cierro la conexion
    $statement = $db->cerrar_conexion($conexion);

    return array('estado' => true,'mensaje' => 'INASISTENCIA DE ALUMNOS GUARDADO CON EXITO!');

}

function modificar_inasistencia_alumnos_docentes($arg_id_ano_lectivo, $arg_alumno_id, $arg_fecha_inasistencia, $arg_docente_id, $arg_materia_id, $arg_trayecto_id, $arg_curso_id){


	$db = new ConexionDB;
	$conexion = $db->retornar_conexion();
	try {
		$sql_asistencia_alumnos_docentes = "DELETE FROM inasistencia_alumno_docentes WHERE rela_anolectivo_id = :argrela_anolectivo_id AND rela_alumno_id = :argrela_alumno_id AND dfecha_inasistencia = :argdfecha_inasistencia AND rela_docente_id = :argrela_docente_id AND rela_materia_id = :argrela_materia_id AND rela_trayecto_id = :argrela_trayecto_id AND rela_curso_id = :argrela_curso_id";

		$statement = $conexion->prepare($sql_asistencia_alumnos_docentes);

        $statement->bindParam(':argrela_anolectivo_id' , $arg_id_ano_lectivo);  // reemplazo los parametros enlazados 
        $statement->bindParam(':argrela_alumno_id' , $arg_alumno_id);  // reemplazo los parametros enlazados 
        $statement->bindParam(':argdfecha_inasistencia' , $arg_fecha_inasistencia);  // reemplazo los parametros enlazados 
        $statement->bindParam(':argrela_docente_id' , $arg_docente_id);  // reemplazo los parametros enlazados 
        $statement->bindParam(':argrela_materia_id' , $arg_materia_id);  // reemplazo los parametros enlazados 
        $statement->bindParam(':argrela_trayecto_id' , $arg_trayecto_id);  // reemplazo los parametros enlazados 
        $statement->bindParam(':argrela_curso_id' , $arg_curso_id);  // reemplazo los parametros enlazados 

        if (!$statement->execute()) {
        	return array('estado' => false,'mensaje' => $statement->errorInfo());
        }

    } catch (PDOException $e) {
    	return array('estado' => false,'mensaje' => "Mensaje de la excepción: ".$e->getMessage()."<br>");
    }
        // cierro la conexion
    $statement = $db->cerrar_conexion($conexion);

    return array('estado' => true,'mensaje' => 'INASISTENCIA DE ALUMNOS MODIFICADOS CON EXITO!');

}

// obtener el porcentaje de asistencia de un alumno
function obtener_porcentaje_inasistencia_alumno_docentes($argIdAnoLectivo, $argIdMateria, $argIdCurso, $argIdTrayectos, $argIdAlumno){

		// 100%
	$total_asistencia_docentes = obtener_asistencias_docentes($argIdAnoLectivo, $argIdMateria, $argIdTrayectos, $argIdCurso);


		// 2
	$total_inasistencia_alumno = count(obtener_Total_Inasistencia_Alumnos_Docentes($argIdAnoLectivo, $argIdAlumno, $argIdMateria, $argIdTrayectos, $argIdCurso));


	$total_asistencia_docentes = $total_asistencia_docentes['mensaje'][0]['tota_asistencia_docente'];		

	if ($total_inasistencia_alumno > 0) {

		$result_asistencia_alumno = $total_inasistencia_alumno/$total_asistencia_docentes;

		$result_asistencia_alumno = $result_asistencia_alumno * 100;

	}else{	

		$result_asistencia_alumno = 0;

	}

		// $total_asistencia_alumno = 100;

	return $result_asistencia_alumno;

}


function obtener_asistencias_docentes($argIdAnoLectivo, $argIdMateria, $argIdTrayecto, $argIdCursos){
	

	// cambiar por session
	$arg_id_docente = 1;

	$resultadoAsistenciaDocentes = array();	

	$db = new ConexionDB;
	$conexion = $db->retornar_conexion();
	try {
		$sql_asistencia_alumnos_docentes = "SELECT COUNT(*) AS 'tota_asistencia_docente'

		FROM (

		(SELECT * FROM divisiones_horarios_materias d1 WHERE d1.rela_docente_id1 = :argrela_docente_id AND d1.rela_materia_id_modulo1 = :argrela_materia_id AND d1.bdocente_presente1 = 1)

		UNION ALL

		(SELECT * FROM divisiones_horarios_materias d1 WHERE d1.rela_docente_id2 = :argrela_docente_id AND d1.rela_materia_id_modulo2 = :argrela_materia_id AND d1.bdocente_presente2 = 1)

		UNION ALL

		(SELECT * FROM divisiones_horarios_materias d1 WHERE d1.rela_docente_id3 = :argrela_docente_id AND d1.rela_materia_id_modulo3 = :argrela_materia_id AND d1.bdocente_presente3 = 1)

		UNION ALL

		(SELECT * FROM divisiones_horarios_materias d1 WHERE d1.rela_docente_id4 = :argrela_docente_id AND d1.rela_materia_id_modulo4 = :argrela_materia_id AND d1.bdocente_presente4 = 1)

		UNION ALL

		(SELECT * FROM divisiones_horarios_materias d1 WHERE d1.rela_docente_id5 = :argrela_docente_id AND d1.rela_materia_id_modulo5 = :argrela_materia_id AND d1.bdocente_presente5 = 1)

		UNION ALL

		(SELECT * FROM divisiones_horarios_materias d1 WHERE d1.rela_docente_id6 = :argrela_docente_id AND d1.rela_materia_id_modulo6 = :argrela_materia_id AND d1.bdocente_presente6 = 1)

		UNION ALL

		(SELECT * FROM divisiones_horarios_materias d1 WHERE d1.rela_docente_id7 = :argrela_docente_id AND d1.rela_materia_id_modulo7 = :argrela_materia_id AND d1.bdocente_presente7 = 1)


		) AS dhm


		WHERE  dhm.rela_trayecto_id = :argrela_trayecto_id AND dhm.rela_curso_id = :argrela_curso_id AND dhm.rela_anolectivo_id = :argrela_anolectivo_id";

		$statement = $conexion->prepare($sql_asistencia_alumnos_docentes);

        $statement->bindParam(':argrela_anolectivo_id' , $argIdAnoLectivo);  // reemplazo los parametros enlazados 
        $statement->bindParam(':argrela_docente_id' , $arg_id_docente);  // reemplazo los parametros enlazados 
        $statement->bindParam(':argrela_materia_id' , $argIdMateria);  // reemplazo los parametros enlazados 
        $statement->bindParam(':argrela_trayecto_id' , $argIdTrayecto);  // reemplazo los parametros enlazados 
        $statement->bindParam(':argrela_curso_id' , $argIdCursos);  // reemplazo los parametros enlazados 

        if (!$statement->execute()) {
        	return array('estado' => false,'mensaje' => $statement->errorInfo());
        }

        while($resultado = $statement->fetch(PDO::FETCH_ASSOC)){
        	$resultadoAsistenciaDocentes[] = $resultado;
        }

    } catch (PDOException $e) {
    	return array('estado' => false,'mensaje' => "Mensaje de la excepción: ".$e->getMessage()."<br>");
    }
        // cierro la conexion
    $statement = $db->cerrar_conexion($conexion);

    return array('estado' => true,'mensaje' => $resultadoAsistenciaDocentes);

}


// Funcion para obtener el total de la inasistencia de un alumno
function obtener_Total_Inasistencia_Alumnos_Docentes($argIdAnoLectivo, $argIdAlumno, $argMateriaId, $argIdTrayectos, $rela_curso_id){


 	// CAMBIAR POR SESSION
	$argDocenteId = 1;

	$resultado_total_inasistencia_alumno_docentes = array();

	$db = new ConexionDB;

	$conexion = $db->retornar_conexion();

	$sql_inasistencias_alumnos_docentes = "
	SELECT * FROM inasistencia_alumno_docentes a1 WHERE a1.rela_anolectivo_id = :rela_anolectivo_id AND a1.rela_alumno_id = :argrela_alumno_id AND a1.rela_docente_id = :argrela_docente_id AND a1.rela_materia_id = :argrela_materia_id AND a1.rela_trayecto_id = :argrela_trayecto_id AND a1.rela_curso_id = :argrela_curso_id
	";

	$statement = $conexion->prepare($sql_inasistencias_alumnos_docentes);

	        $statement->bindParam(':rela_anolectivo_id' , $argIdAnoLectivo);  // reemplazo los parametros enlazados 
	        $statement->bindParam(':argrela_alumno_id' , $argIdAlumno);  // reemplazo los parametros enlazados 
	        $statement->bindParam(':argrela_docente_id' , $argDocenteId);  // reemplazo los parametros enlazados 
	        $statement->bindParam(':argrela_materia_id' , $argMateriaId);  // reemplazo los parametros enlazados 
	        $statement->bindParam(':argrela_trayecto_id' , $argIdTrayectos);  // reemplazo los parametros enlazados 
	        $statement->bindParam(':argrela_curso_id' , $rela_curso_id);  // reemplazo los parametros enlazados 

	        $statement->execute();

	        while($resultado = $statement->fetch(PDO::FETCH_ASSOC)){
	        	$resultado_total_inasistencia_alumno_docentes[]= $resultado;
	        }
	        return $resultado_total_inasistencia_alumno_docentes;
	    }	