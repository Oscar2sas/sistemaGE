<?php 

function armar_tabla_historial_alumnos($arg_resultado_historial_division_alumnos, $arg_idCicloLectivoHistoriaAlumnos, $arg_idTrayectosHistorialAlumno, $arg_idCursosHistorialAlumno){
	
		// Cabecera tabla historial alumnos
	$tabla_historial_alumnos = "
	<div id='tablaHistorialAlumnos'>
	<input type='date' name='fechaInicioHistorialAlumnos' id='fechaInicioHistorialAlumnos'>
	<input type='date' name='fechaFinHistorialAlumnos' id='fechaFinHistorialAlumnos'>
	<button class='btn btn-info' id='exportarHistorialAlumnos'>Exportar Historial</button><br><br>

	<table id='table' class='table table-stripped table-bordered nowrap cellspacing=' width='100%'>

	<thead class='thead-dark'>
	<tr>
	<th class='text-center'>Apellido</th>
	<th class='text-center'>Nombre</th>
	<th class='text-center'>Dni</th>
	<th class='text-center'>Fecha Nacimiento</th>
	<th class='text-center'>Porcentaje de Inasistencia</th>
	<th class='text-center'>Inasistencias</th>
	<th class='text-center'>Opciones</th>
	</tr>
	</thead>

	<tbody>";
	
	foreach ($arg_resultado_historial_division_alumnos as $key => $division_historial_alumnos) {
		$tabla_historial_alumnos.= "<tr>
		<td class='text-center'>".$division_historial_alumnos['capellidos_persona']."</td>
		<td class='text-center'>".$division_historial_alumnos['cnombres_persona']."</td>
		<td class='text-center'>".$division_historial_alumnos['ndni_persona']."</td>
		<td class='text-center'>".$division_historial_alumnos['dfechanac_persona']."</td>
		<td class='text-center'>".
		obtener_porcentaje_inasistencia_alumno($arg_idCicloLectivoHistoriaAlumnos, $arg_idCursosHistorialAlumno, $arg_idTrayectosHistorialAlumno, $division_historial_alumnos['alumno_id'])
		."%</td>
		<td class='text-center'>".
		count(obtener_Total_Inasistencia_Alumnos($arg_idCicloLectivoHistoriaAlumnos, $division_historial_alumnos['alumno_id'], $arg_idTrayectosHistorialAlumno)).
		"</td>
		<td class='text-center'><button class='btn btn-warning' name='detalleHistorialAlumnos' id='detalleHistorialAlumnos' value='".$division_historial_alumnos['alumno_id']."'>Ver Detalle</button></td>";
	}
	$tabla_historial_alumnos .= "</tbody></table><br>";

	return $tabla_historial_alumnos;
}


function buscar_historial_alumno($arg_id_alumno, $arg_fecha_inicio_historial_alumnos, $arg_fecha_fin_historial_alumnos){

		//============================================================================================
		//Busco el hsitorial de los alumnos
		//============================================================================================

		$resultado_datos_historial_alumnos = array();  // creo un array que va a almacenar la informacion de las inasistencias de los alumnos

		$db = new ConexionDB;
		$conexion = $db->retornar_conexion();
		$sql_historial_alumnos = "
		SELECT h1.*, p1.capellidos_persona, p1.cnombres_persona 

		FROM historiales_alumnos h1, alumnos a1, personas p1 

		WHERE h1.rela_alumno_id = :argrela_alumno_id AND h1.dfecha_historial >= :dfecha_historial_inicio AND h1.dfecha_historial <= :dfecha_historial_fin AND h1.rela_alumno_id = a1.alumno_id AND a1.alumno_id = p1.persona_id"; // busca el historial del alumno

		$statement = $conexion->prepare($sql_historial_alumnos);

        $statement->bindParam(':argrela_alumno_id' , $arg_id_alumno);  // reemplazo los parametros enlazados 

		$statement->bindParam(':dfecha_historial_inicio' , $arg_fecha_inicio_historial_alumnos);  // reemplazo los parametros enlazados 
		
		$statement->bindParam(':dfecha_historial_fin' , $arg_fecha_fin_historial_alumnos);  // reemplazo los parametros enlazados 


		if (!$statement->execute()) {
			return($statement->errorInfo());
		}else{
			while($resultado = $statement->fetch(PDO::FETCH_ASSOC)){
				$resultado_datos_historial_alumnos[]= $resultado;
			}
		}

		return $resultado_datos_historial_alumnos;
	}


	function armar_tarjetas_historial_alumnos($arg_result_busqueda_historial_alumno){
		$tarjeta_historia_alumno="";
		foreach ($arg_result_busqueda_historial_alumno as $key => $result_historial_alumnos) {
			$tarjeta_historia_alumno .= "
			<hr>
			<h1 class='display-4'>Profesores: ".$result_historial_alumnos['historial_alumno']."</h1>
			<p class='lead'>Fecha: ".$result_historial_alumnos['dfecha_historial']."</p>
			";
			
		}

		return $tarjeta_historia_alumno;
	}