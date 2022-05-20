$(document).ready(function() {
	$('#cicloLectivoHorariosMaterias').change(function(){

		buscarHorariosCurso();
	});

	$('#fechaAsistenciaHorariosMaterias').change(function(){

		buscarHorariosCurso();
		
	});

	$('#cursosHorariosMaterias').change(function(){

		buscarHorariosCurso();
	});

	$('#trayectosHorariosMaterias').change(function(){

		buscarHorariosCurso();
	});


	$("#contenedorAsistenciaDocente").on("click", "#guardarAsistenciaDocentesCursosHorariosMaterias", function(){ 
		
		obtenerValoresFormularioCursosHorariosMaterias();
	});

// ====================================================================================
// Funcion para obtener los datos ingresados en el formulario
// ====================================================================================

const obtenerValoresFormularioCursosHorariosMaterias = ()=>{

		// Obtener valores de los inputs y selects

		const idAnoLectivo = $("#cicloLectivoHorariosMaterias option:selected").val();
		const fechaAsistencia = $("#fechaAsistenciaHorariosMaterias").val();
		const idCursos = $("#cursosHorariosMaterias option:selected").val();
		const idTrayectos = $("#trayectosHorariosMaterias option:selected").val();

		const fecha = $('#fechaAsistenciaHorariosMaterias').val();

		if (!verificarFechaAsistenciaHorariosMaterias(fecha)) {
			$('#tablaHorariosMaterias').remove();
			return;
		}

		if (idCursos == '0' || idTrayectos == '0'){ return;}



		let datosParamentrosAsistencia = {
			idAnoLectivo,
			fechaAsistencia,
			idCursos,
			idTrayectos
		};

		$('#table tr').each(function(i) { 
			// let valorModuloCursoHorariosMaterias = $(this).find(".numeroModulo").html();  
			let valorDocenteCursoHorariosMaterias = $(`#docentesHorariosMaterias${i} option:selected`).val();  
			let valorDocenteSituacionMateria = $(`#docentesSituacionMateria${i} option:selected`).val();  
			let valorDocenteMaterias = $(`#docenteMaterias${i} option:selected`).val();  
			let valorDatosModuloCursoHorariosMaterias = $(this).find(".datosModulosHoras").html();  

		// Verifico si los datos obtenidos son validos
		if (valorDocenteCursoHorariosMaterias &&
			valorDocenteSituacionMateria &&
			valorDatosModuloCursoHorariosMaterias &&
			valorDocenteMaterias) {

				//Separo la hora desde y la hora hasta del modulo 
			valorDatosModuloCursoHorariosMaterias = valorDatosModuloCursoHorariosMaterias.split('-');

			datosParamentrosAsistencia[`idDocenteCursoHorariosMaterias${i}`] = valorDocenteCursoHorariosMaterias;
			datosParamentrosAsistencia[`valorDocenteSituacionMateria${i}`] = valorDocenteSituacionMateria;
			datosParamentrosAsistencia[`valorDesdeModuloCursoHorariosMaterias${i}`] = valorDatosModuloCursoHorariosMaterias[0];
			datosParamentrosAsistencia[`valorHastaModuloCursoHorariosMaterias${i}`] = valorDatosModuloCursoHorariosMaterias[1];
			datosParamentrosAsistencia[`idDocenteMaterias${i}`] = valorDocenteMaterias;
			datosParamentrosAsistencia[`docentePresente${i}`] =  $(`#checkAsistenciaDocente${i}`).is(':checked') ? '1' : '0';

		}
	}); 

		datosParamentrosAsistencia['valorInasistencia'] = $("#valorInasistenciaCursoHorariosMaterias option:selected").val();
		datosParamentrosAsistencia['idPreceptorCursoHorarioMateria'] = $("#preceptorCursoHorariosMaterias option:selected").val();
		datosParamentrosAsistencia['idCursoHorario'] =  $('#cursoHorarioId').val();
		datosParamentrosAsistencia['accion'] =  $('#accion').val();
		datosParamentrosAsistencia['idDivisionHorario'] =  $('#idDivisionHorario').val();

		// console.log(datosParamentrosAsistencia)
		guardarAsistenciaCursoHorarioMateria(datosParamentrosAsistencia);
	};

// ====================================================================================
// Funcion para guardar los datos ingresados del formulario
// ====================================================================================
const guardarAsistenciaCursoHorarioMateria = async(argDatosAsistencia)=>{

		// Creacion del objeto form que guardara todos los datos para el envio
		const datosAsistenciaCurso = new FormData();

		// Se guarda los datos para la busqueda del curso ingresado por el usuario
		// y se le especifica el metodo para el controlador
		datosAsistenciaCurso.append('accion', 'guardar_asistencia_docentes_cursos_horarios_materias');

		datosAsistenciaCurso.append('datosAsistenciaHorariosMaterias', JSON.stringify(argDatosAsistencia));
		
		// Especifico hacia que controlador quiero enviar mi peticion
		const URL = 'sistema/controladores/asistenciadocente/controller.asistenciadocente.php';
        // Especifico la configuracion de mi peticion y tambien los datos a enviar
        const CONFIG = {
        	method: 'POST',
        	body: datosAsistenciaCurso
        };

        try {

        	const resultPeticionAsistenciaHorariosMaterias = await fetch(URL, CONFIG);
        	const resultDatosAsistenciaCursosHorariosMaterias = await resultPeticionAsistenciaHorariosMaterias.json();
        	if (argDatosAsistencia['accion'] == 'agregar') {
        		if (resultDatosAsistenciaCursosHorariosMaterias) {
        			mostrarMensaje('DATOS GUARDADOS CORRECTAMENTE', 'ACEPTAR', 'success');
        		}else{
        			mostrarMensaje('ERROR AL GUARDAR LOS DATOS, VERIFIQUE', 'ACEPTAR', 'error');
        		}
        	}else{
        		if (resultDatosAsistenciaCursosHorariosMaterias) {
        			mostrarMensaje('DATOS MODIFICADOS CORRECTAMENTE', 'ACEPTAR', 'success');

        		}else{
        			mostrarMensaje('ERROR AL MODIFICAR LOS DATOS, VERIFIQUE', 'ACEPTAR', 'error');
        			
        		}
        	}

        } catch (e) {
        	console.log(e);
        }

    };


    const mostrarMensaje = (alertTitulo, alertaBoton, tipoAlerta)=>{

    	Swal.fire({
    		title: `${alertTitulo}`,
    		icon: `${tipoAlerta}`,
    		confirmButtonColor: '#3085d6',
    		confirmButtonText: `${alertaBoton}`
    	}).then((result) => {
    		if (result.value) {
    			buscarHorariosCurso();
    		}else{
    			buscarHorariosCurso();
    		}
    	})
    };


// ====================================================================================
// Funcion para obtener los horarios de un curso
// ====================================================================================
const buscarHorariosCurso = ()=>{

		// Obtener valores de los inputs y selects
		const idAnoLectivo = $("#cicloLectivoHorariosMaterias option:selected").val();
		const fechaAsistencia = $("#fechaAsistenciaHorariosMaterias").val();
		const idCursos = $("#cursosHorariosMaterias option:selected").val();
		const idTrayectos = $("#trayectosHorariosMaterias option:selected").val();
		const token = $('#token').val();
		const fecha = $('#fechaAsistenciaHorariosMaterias').val();

		if (!verificarFechaAsistenciaHorariosMaterias(fecha)) {
			$('#tablaHorariosMaterias').remove();
			return;
		}

		if (idCursos == '0' || idTrayectos == '0'){ return;}


		const datosParamentros = {
			idAnoLectivo,
			fechaAsistencia,
			idCursos,
			idTrayectos,
			token
		};

		// Funcion para obtener los horarios de un curso, segun la fecha y el trayecto

		verificarFechaHorariosAsistencias(datosParamentros);


	};

// ====================================================================================
// Funcion para validar la fecha de asistencia de un curso
// ====================================================================================

const verificarFechaHorariosAsistencias = async (datosParamentros)=>{

    $('#errorHorariosMaterias').empty();
    $('#tablaHorariosMaterias').remove();
    
    

    	// Creacion del objeto form que guardara todos los datos para el envio
    	const data = new FormData();

		// Se guarda los datos para la busqueda del curso ingresado por el usuario
		// y se le especifica el metodo para el controlador
		data.append('accion', 'verificar_horarios_materias');

		data.append('datosHorariosMaterias', JSON.stringify(datosParamentros));
		
		// Especifico hacia que controlador quiero enviar mi peticion
		const URL = 'sistema/controladores/asistenciadocente/controller.asistenciadocente.php';
        // Especifico la configuracion de mi peticion y tambien los datos a enviar
        const CONFIG = {
        	method: 'POST',
        	body: data
        };

        try {
        	// Seccion verificar si la fecha es valida para la asistencia
        	const resultPeticionCursoHorariosMaterias = await fetch(URL, CONFIG);
        	const resultDatosCursosHorariosMaterias = await resultPeticionCursoHorariosMaterias.json();
        	// console.log(resultDatosCursosHorariosMaterias);
        	if (!resultDatosCursosHorariosMaterias) {
        		$('#errorHorariosMaterias').append(`
        			<h3 class="text-dark">
        			<b>
        			El curso seleccionado no tiene clases hoy o no posee horarios, por favor verifique el trayecto o la fecha!
        			</b>
        			</h3>`);
        		return;
        	}else if (resultDatosCursosHorariosMaterias == 'token_no_valido') {
        		$('#errorHorariosMaterias').append(`
        			<h3 class="text-dark">
        			<b>
        			El token no es valido, por favor vuelva a inicar sesiòn!
        			</b>
        			</h3>`);
        		return;
        	}
        	$('#contenedorAsistenciaDocente').append(resultDatosCursosHorariosMaterias);
        	if ($.fn.DataTable.isDataTable('#table')) {
        		$('#table').DataTable().destroy();

        		$('#errorHorariosMaterias').empty();
        		$('#tablaHorariosMaterias').remove();
        	}
        	$('#table').DataTable(window.configDatatables);
        } catch (e) {
        	console.log(e);
        }

    }


	// ====================================================================================
    // Funcion para validar las fecha de asistencia
    // ====================================================================================
    const verificarFechaAsistenciaHorariosMaterias = (argFecha) => {

    	$('#errorHorariosMaterias').empty();

    	const fecha = argFecha.split("-")[0];
    	const anoLectivo = $('#cicloLectivoHorariosMaterias').text().trim();

        // console.log(anoLectivo.)

        if (argFecha == '') {

        	$('#errorHorariosMaterias').append(`
        		<h3 class="text-dark">
        		<b>
        		No puede dejar la fecha de la asistencia de los docentes vacia, por favor verifique!
        		</b>
        		</h3>`);
        	return false;
        }

        if (fecha != anoLectivo) {

        	$('#errorHorariosMaterias').append(`
        		<h3 class="text-dark">
        		<b>
        		Fecha asistencia no coincide con el año lectivo, por favor verifique!
        		</b>
        		</h3>`);
        	return false;
        }

        return true;
    }
});