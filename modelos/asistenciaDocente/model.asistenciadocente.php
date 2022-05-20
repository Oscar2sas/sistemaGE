<?php 

// Funcion para armar la tabla de los horarios de las materias de un curso
function armar_tabla_cursos_horarios_materias($argResultHorariosMaterias, $accion){
	
	// Cabecera tabla curso horarios materias
	$tabla_horarios_materias = "
	<div id='tablaHorariosMaterias'>

	<input type='hidden' id='cursoHorarioId' name='cursoHorarioId' value=". (isset($argResultHorariosMaterias['rela_cursohorarios_id']) ? $argResultHorariosMaterias['rela_cursohorarios_id'] : $argResultHorariosMaterias['rela_cursohorario_id']).">

	<input type='hidden' id='accion' name='accion' value='".$accion."'>

	<input type='hidden' id='idDivisionHorario' name='idDivisionHorario' value='".

	(isset($argResultHorariosMaterias['divisionhorario_id']) ? $argResultHorariosMaterias['divisionhorario_id'] : "0")
	."'>

	<table id='table' class='table table-stripped table-bordered nowrap cellspacing=' width='100%'>
	<h3 class='text-center'>".strtoupper($accion)."</h3>

	<thead class='thead-dark'>
	<tr>
	<th class='text-center'>Modulo Nº</th>
	<th class='text-center'>Profesor</th>
	<th class='text-center'>Sit Docente</th>
	<th class='text-center'>Horario</th>
	<th class='text-center'>Materia</th>
	<th class='text-center'>P/A[x]</th>
	</tr>
	</thead>

	<tbody>";

// FILAS TABLAS
	for ($i=1; $i <= 7 ; $i++) { 
		$tabla_horarios_materias.= "
		<tr>
		<td class='text-center numeroModulo'>".$i."</td>

		<td class='text-center'>".
		obtener_datos_docente_horarios_materias($argResultHorariosMaterias["rela_docente_id".$i.""], $i)
		."</td>

		<td class='text-center'>".
		obtener_situacion_docente_horario_materia($argResultHorariosMaterias["nsituacion_docente".$i.""], $i)
		."</td>

		<td class='text-center datosModulosHoras'>".
		$argResultHorariosMaterias["chora_desdemodulo".$i.""] ."-".$argResultHorariosMaterias["chora_hastamodulo".$i.""]
		."</td>

		<td class='text-center'>".
		obtener_datos_docente_materia($argResultHorariosMaterias["rela_materia_id_modulo".$i.""], $i)
		."</td>

		<td class='text-center'><input type='checkbox' ".
		verificar_asistencia_docente_horario_materia($argResultHorariosMaterias, $i, $accion)
		
		." class='form-check-input' id='checkAsistenciaDocente".$i."' name='checkAsistenciaDocente".$i."'></td>
		</tr>";
	}

	// Cierre de tabla
	$tabla_horarios_materias .= "</table> <br>";

	// Valor de la inasistencia
	$tabla_horarios_materias .= "
	<div class='form-group'>
	<label for='valorInasistenciaCursoHorariosMaterias'>Seleccione Valor Inasistencia</label>".
	obtener_valor_inasistencia_curso_horario_materia($argResultHorariosMaterias['nvalor_inasistencia'], $i).
	"</div>";

	// Preceptor a cargo del curso
	$tabla_horarios_materias .= "
	<div class='form-group'>
	<label for='preceptorCursoHorariosMaterias'>Seleccione el Preceptor</label>".
	obtener_preceptor_curso_horario_materia($argResultHorariosMaterias['preceptor_id']).
	"</div>";

	// Boton para guardar las asistencias
	$tabla_horarios_materias .= "
	<div class='form-group'>
	<input type='button' name='guardarAsistenciaDocentesCursosHorariosMaterias' id='guardarAsistenciaDocentesCursosHorariosMaterias' class='float-right btn btn-success' value='Guardar Asistencias'>
	</div>";


	return $tabla_horarios_materias;

}


function verificar_asistencia_docente_horario_materia($argResultHorariosMaterias, $i ,$accion){
	
	if ($accion == "editar") {
		if ($argResultHorariosMaterias["bdocente_presente".$i.""] != "0") {
			return "checked";
		}
	}else{
		if ($argResultHorariosMaterias["rela_docente_id".$i.""] != "0") {
			return "checked";
		}
	}
}

// Funcion para obtener los datos de un docente en un horario

function obtener_datos_docente_horarios_materias($argIdDocente, $indice){

	$resultDatosDocente = obtener_docentes();

	$listaDocentesHorariosMaterias="<select class='form-control' name='docentesHorariosMaterias".$indice."' id='docentesHorariosMaterias".$indice."'>";

	$listaDocentesHorariosMaterias .= "<option value='0'>Sin Profesor</option>";

	foreach ($resultDatosDocente as $key => $docente) {

		if ($argIdDocente == $docente['docente_id']) {

			$listaDocentesHorariosMaterias .= "<option selected value=". $docente['docente_id'] .">".$docente['capellidos_persona']." ".$docente['cnombres_persona']."</option>";

		}else{
			$listaDocentesHorariosMaterias .= "<option value=". $docente['docente_id'] .">".$docente['capellidos_persona']." ".$docente['cnombres_persona']."</option>";
		}

	}

	$listaDocentesHorariosMaterias .= "</select><br>";

	return $listaDocentesHorariosMaterias;
}

// Funcion para obtener la situacion de un docente en una materia

function obtener_situacion_docente_horario_materia($argSituacionDocente, $indice){
	$resultSituacioDocente = "";
	
	$opcionesSituacionDocente = [
		1=>"Titular", 
		2=>"Interino", 
		3=>"Suplente"
	];

	$listaOpcionesSituacionDocente = "<select class='form-control' name='docentesSituacionMateria".$indice."' id='docentesSituacionMateria".$indice."'>";

	$listaOpcionesSituacionDocente .= "<option selected value='0'>Selecciona Situaciòn</option>";

	foreach ($opcionesSituacionDocente as $key => $sitDocente) {
		
		if ($key == $argSituacionDocente) {
			$listaOpcionesSituacionDocente .= "<option selected value=". $key .">".$sitDocente."</option>";
		}else{
			$listaOpcionesSituacionDocente .= "<option value=". $key .">".$sitDocente."</option>";
		}

	}
	$listaOpcionesSituacionDocente .= "</select><br>";

	return $listaOpcionesSituacionDocente;

}

// Funcion para obtener las materias de un docente

function obtener_datos_docente_materia($argIdMateria, $indice){
	
	$resultDatosMaterias = obtener_materias();

	$listaMateriasHorariosMaterias = "<select class='form-control' name='docenteMaterias".$indice."' id='docenteMaterias".$indice."'>";

	$listaMateriasHorariosMaterias .= "<option selected value='0'>Sin Materias</option>";

	foreach ($resultDatosMaterias as $materia) {

		if ($materia['materia_id'] == $argIdMateria) {
			$listaMateriasHorariosMaterias .= "<option selected value=". $materia['materia_id'] .">".$materia['cnombre_materia']."</option>";
		}else{
			$listaMateriasHorariosMaterias .= "<option value=". $materia['materia_id'] .">".$materia['cnombre_materia']."</option>";

		}

	}
	$listaMateriasHorariosMaterias .= "</select><br>";

	return $listaMateriasHorariosMaterias;

}

// Funcion para obtener al preceptor de un curso 

function obtener_preceptor_curso_horario_materia($argIdPreceptor){
	$resultPreceptores = buscar_preceptores();

	$listaPreceptorCursoHorariosMaterias = "<select class='form-control' name='preceptorCursoHorariosMaterias' id='preceptorCursoHorariosMaterias'>";

	$listaPreceptorCursoHorariosMaterias .= "<option disabled value='0'>Seleccione un Preceptor</option>";
	
	foreach ($resultPreceptores as $preceptor) {
		if ($preceptor['preceptor_id'] == $argIdPreceptor) {
			
			$listaPreceptorCursoHorariosMaterias .= "<option selected value=". $preceptor['preceptor_id'] .">".$preceptor['capellidos_persona']." ".$preceptor['cnombres_persona']."</option>";

		}else{
			$listaPreceptorCursoHorariosMaterias .= "<option value=". $preceptor['preceptor_id'] .">".$preceptor['capellidos_persona']." ".$preceptor['cnombres_persona']."</option>";

		}
		
	}
	$listaPreceptorCursoHorariosMaterias .= "</select>";

	return $listaPreceptorCursoHorariosMaterias;

}

// Funcion para obtener el valor de la inasistencia

function obtener_valor_inasistencia_curso_horario_materia($argValorInasistencia){
	
	$valorInasistencia = ['0.50' => 'Media Inasistencia', '1.00' => 'Completa Inasistencia'];

	$listaValorInasistenciaCursoHorariosMaterias = "<select class='form-control' name='valorInasistenciaCursoHorariosMaterias' id='valorInasistenciaCursoHorariosMaterias'>";

	$listaValorInasistenciaCursoHorariosMaterias .= "<option disabled value=''>Seleccione el Valor de la Inasistencia</option>";

	foreach ($valorInasistencia as $key => $valInasisntencia) {
		
		if ($key == $argValorInasistencia) {
			$listaValorInasistenciaCursoHorariosMaterias .= "<option selected value=". $key .">".$valInasisntencia." ($key)"."</option>";
		}else{
			$listaValorInasistenciaCursoHorariosMaterias .= "<option value=". $key .">".$valInasisntencia." ($key)"."</option>";
		}

	}

	$listaValorInasistenciaCursoHorariosMaterias .= "</select>";

	return $listaValorInasistenciaCursoHorariosMaterias;
}

// ================================================================================
// Funcion para guardar la asistencia de los docentes
// ================================================================================


function guardar_asistencia_curso_horario_materia($argDatosAsistenciaCursoHorarioMateria){

	$argDatosAsistencia = json_decode($argDatosAsistenciaCursoHorarioMateria);

	if ($argDatosAsistencia->accion == "agregar") {
		
		if (insertar_datos_asistencia_curso_horario_materia($argDatosAsistenciaCursoHorarioMateria)) {
			return true;
		}else{
			return false;
		}
	}else{
		if (actualizar_datos_asistencia_curso_horario_materias($argDatosAsistenciaCursoHorarioMateria)) {
			return true;
		}else{
			return false;
		}
	}

}

