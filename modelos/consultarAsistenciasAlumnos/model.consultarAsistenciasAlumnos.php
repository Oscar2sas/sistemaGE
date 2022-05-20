<?php 
function buscar_historial_inasistencias_alumno($arg_id_ano_lectivo, $arg_id_curso, $arg_id_trayecto, $arg_id_alumno){
	


	$resultado_historial_inasistencias_alumnos = array();  // creo un array que va a almacenar la informacion de los anos lectivos

	$db = new ConexionDB;
	$conexion = $db->retornar_conexion();

	$sql_datos_historial_inasistencias_alumnos = "SELECT * FROM divisiones_inasistencias d1, alumnos a1, personas p1 WHERE d1.rela_alumno_id = a1.alumno_id AND a1.rela_persona_id = p1.persona_id AND d1.rela_anolectivo_id = :argrela_anolectivo_id AND d1.rela_curso_id = :argrela_curso_id AND d1.rela_trayecto_id = :argrela_trayecto_id AND d1.rela_alumno_id = :argrela_alumno_id";

	$statement = $conexion->prepare($sql_datos_historial_inasistencias_alumnos);

        $statement->bindParam(':argrela_anolectivo_id' , $arg_id_ano_lectivo);  // reemplazo los parametros enlazados 
        $statement->bindParam(':argrela_curso_id' , $arg_id_curso);  // reemplazo los parametros enlazados 
        $statement->bindParam(':argrela_trayecto_id' , $arg_id_trayecto);  // reemplazo los parametros enlazados 
        $statement->bindParam(':argrela_alumno_id' , $arg_id_alumno);  // reemplazo los parametros enlazados 
        
        $statement->execute();
        
        if (!$statement){
            // no se encontraron paises
        }else{
            // reviso el retorno

        	while($resultado = $statement->fetch(PDO::FETCH_ASSOC)){
        		$resultado_historial_inasistencias_alumnos[]= $resultado;
        	}
        }
        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);
        return $resultado_historial_inasistencias_alumnos;
    }



    function armar_tabla_consultar_asistencias_alumnos($arg_resultado_inasistencias_alumno, $arg_idAnolectivo, $arg_idTrayectosHistorialAlumno, $arg_idCursosHistorialAlumno, $arg_desc_trayecto, $arg_id_alumno, $arg_historiales_alumno){

        // Cabecera tabla asistencia alumnos
    	$tabla_consultar_asistencia_alumnos = "
    	<hr>
    	<div id='tablaAsistenciaAlumnos'>
    	<h4><b>Trayecto: ".$arg_desc_trayecto."</b></h4>	
    	<table class='table table-stripped table-bordered nowrap cellspacing' width='100%'>

    	<thead class='thead-dark'>
    	<tr>
    	<th class='text-center'>Apellido</th>
    	<th class='text-center'>Nombre</th>
    	<th class='text-center'>Fecha</th>
    	<th class='text-center'>Observaciones</th>
    	<th class='text-center'>A[x]</th>
    	<th class='text-center'>T[x]</th>
    	<th class='text-center'>J[x]</th>
    	</tr>
    	</thead>

    	<tbody>";

        // CUERPO TABLA

    	foreach ($arg_resultado_inasistencias_alumno as $key => $division_alumnos) {


    		$tabla_consultar_asistencia_alumnos.= "<tr>
    		<td class='text-center'>".$division_alumnos['capellidos_persona']."</td>
    		<td class='text-center'>".$division_alumnos['cnombres_persona']."</td>
    		<td class='text-center'>".$division_alumnos['dfecha_inasistencia']."</td>";

    		// se busca posible observacion del alumno
    		foreach ($arg_historiales_alumno['mensaje'] as  $his_alumno) {
    			if ($his_alumno['dfecha_historial'] == $division_alumnos['dfecha_inasistencia']) {
    				$tabla_consultar_asistencia_alumnos.= "<td class='text-center'>".$his_alumno['historial_alumno']."</td>";
    			}else{
    				$tabla_consultar_asistencia_alumnos.= "<td class='text-center'></td>";

    			}
    		}
    		// Seccion checkbox
		// verificacion de check para la tardanza
    		$propCheckAusente = ($division_alumnos['btardanza_asistencia'] == '0') ? 'checked' : '';

    		$tabla_consultar_asistencia_alumnos .= "<td class='text-center'><input type='checkbox' class='form-check-input' ".$propCheckAusente." disabled id='checkInasistencia'></td>";

		// verificacion de check para la asistencia
    		$propCheckTardanza = ($division_alumnos['btardanza_asistencia'] == '1') ? 'checked' : '';

    		$tabla_consultar_asistencia_alumnos .= "<td class='text-center'><input type='checkbox' class='form-check-input' ".$propCheckTardanza." disabled id='checkTardanza'></td>";

		// verificacion de check para la inasistencia justificada
    		$propCheckJustificado = ($division_alumnos['binasistencia_justificada'] == '1') ? 'checked' : '';

    		$tabla_consultar_asistencia_alumnos .= "<td class='text-center'><input type='checkbox' class='form-check-input' ".$propCheckJustificado." disabled id='checkTardanza'></td>";


    	}
    	$tabla_consultar_asistencia_alumnos .= "</tbody></table><br>";

        $resultPorcentajaInasistenciaAlumno = obtener_porcentaje_inasistencia_alumno($arg_idAnolectivo, $arg_idCursosHistorialAlumno, $arg_idTrayectosHistorialAlumno, $arg_id_alumno);

    	$tabla_consultar_asistencia_alumnos .= "<h6> PORCENTAJE DE INASISTENCIAS: ".$resultPorcentajaInasistenciaAlumno."%<h6>";

    	$tabla_consultar_asistencia_alumnos .= "<h6> TOTAL DE INASISTENCIAS: ".count(obtener_Total_Inasistencia_Alumnos($arg_idAnolectivo, $arg_id_alumno, $arg_idTrayectosHistorialAlumno))."<h6>";
        if ($resultPorcentajaInasistenciaAlumno > 50) {

            $tabla_consultar_asistencia_alumnos .= "<h6 class='bg-warning'> ADVERTENCIA: USTED ESTA A PUNTO DE QUEDAR LIBRE!<h6>";

        }
    	$tabla_consultar_asistencia_alumnos .= "</div>";
    	return $tabla_consultar_asistencia_alumnos;
    }
