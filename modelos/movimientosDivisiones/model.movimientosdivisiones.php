<?php 


function armar_tabla_movimientos_division($arg_result_division_alumnos, $arg_result_ano_lectivo_siguiente, $arg_result_cursos){
	

	// Cabecera tabla asistencia alumnos
    	$tabla_asistencia_alumnos = "
    	
    	<div id='tablaPasajeDivision' class='form-group'>
    	
    	<table id='table' class='table table-stripped table-bordered nowrap cellspacing=' width='100%'>

    	<thead class='thead-dark'>
    	<tr>
    	<th class='text-center'>Apellido</th>
    	<th class='text-center'>Nombre</th>
    	<th class='text-center'>Dni</th>
    	<th class='text-center'>Fecha Nacimiento</th>
    	<th class='text-center'>Estado Alumno</th>
    	<th class='text-center'>[x]</th>
    	</tr>
    	</thead>

    	<tbody>";

        // CUERPO TABLA

    	foreach ($arg_result_division_alumnos as $key => $division_alumnos) {
    		
    		$tabla_asistencia_alumnos.= "<tr>
    		<td class='text-center'>".$division_alumnos['capellidos_persona']."</td>
    		<td class='text-center'>".$division_alumnos['cnombres_persona']."</td>
    		<td class='text-center'>".$division_alumnos['ndni_persona']."</td>
    		<td class='text-center'>".$division_alumnos['dfechanac_persona']."</td>
    		<td class='text-center'>".$division_alumnos['cdescripcion_estadoalumno']."</td>
    		";
    		// Seccion checkbox
    		$tabla_asistencia_alumnos .= "<td class='text-center'><input type='checkbox' class='form-check-input' checked id='checkAlumnoPasaje' value=".$division_alumnos['alumno_id']."></td>";


    	}
    	$tabla_asistencia_alumnos .= "</tbody></table><br>";
    	
    	// combo de ano lectivo
    	$tabla_asistencia_alumnos .= "
    	<label for='anoLectivoSiguiente'>Año Lectivo Siguiente</label>
      		<select class='form-control' disabled id='anoLectivoSiguiente'>
      	";

    	$tabla_asistencia_alumnos .= "<option value=". $arg_result_ano_lectivo_siguiente['anolectivo_id']. " selected>". $arg_result_ano_lectivo_siguiente['ndescripcion_anolectivo']." </option>";


    	$tabla_asistencia_alumnos .= "</select>";
    	
    	// combo de cursos
    	$tabla_asistencia_alumnos .= "<br>
    	<label for='cursoPasajeDivisionSiguiente'>Seleccionar curso destino</label>
      		<select class='form-control' id='cursoPasajeDivisionSiguiente'>
      	";


    	foreach ($arg_result_cursos as $key => $cursos) {
    	
    	$tabla_asistencia_alumnos .= "<option value=". $cursos['curso_id']. ">". $cursos['cdescripcion_curso']." </option>";

    	}
    	$tabla_asistencia_alumnos .= "</select>
    	<div id='erroCursoPasaje'></div>
    	<br>";

    	$tabla_asistencia_alumnos .= "<input type='button' name='btnPasarCursoNuevoAnoLectivo' id='btnPasarCursoNuevoAnoLectivo' class='float-right btn btn-success' value='Pasar curso a nuevo año lectivo'>";

    	$tabla_asistencia_alumnos .= "</div>";
    	return $tabla_asistencia_alumnos;

}