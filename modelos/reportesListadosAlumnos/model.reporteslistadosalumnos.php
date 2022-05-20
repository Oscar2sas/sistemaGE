<?php 


function armar_tabla_reportes_listados_alumnos($arg_arg_resultado_curso_division_alumnos){
	
		// Cabecera tabla historial alumnos
	$tabla_reportes_listados_alumnos = "
	<div id='tablaReportesListadosAlumnos'>
	<button id='exportarReportesListadosAlumnos' class='btn btn-info'>Exportar Listado Alumnos</button><br><br>

	<table id='table' class='table table-stripped table-bordered nowrap cellspacing  tablaReportesAlumnos' width='100%'>

	<thead class='thead-dark'>
	<tr>
	<th class='text-center'>Apellido</th>
	<th class='text-center'>Nombre</th>
	<th class='text-center'>Dni</th>
	<th class='text-center'>Fecha Nacimiento</th>
	<th class='text-center'>Estado</th>
	</tr>
	</thead>

	<tbody>";
	
	foreach ($arg_arg_resultado_curso_division_alumnos as $key => $curso_division_alumnos) {
		$tabla_reportes_listados_alumnos.= "<tr>
		<td class='text-center'>".$curso_division_alumnos['capellidos_persona']."</td>
		<td class='text-center'>".$curso_division_alumnos['cnombres_persona']."</td>
		<td class='text-center'>".$curso_division_alumnos['ndni_persona']."</td>
		<td class='text-center'>".$curso_division_alumnos['dfechanac_persona']."</td>
		<td class='text-center' id='".$curso_division_alumnos['estadoalumno_id']."'>".$curso_division_alumnos['cdescripcion_estadoalumno']."</td>";
	}
	$tabla_reportes_listados_alumnos .= "</tbody></table><br>";

	return $tabla_reportes_listados_alumnos;
}

