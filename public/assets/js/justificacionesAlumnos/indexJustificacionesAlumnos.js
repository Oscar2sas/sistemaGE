$(document).ready(function() {
	$('#cicloLectivoJustificacionAlumnos').change(function(){

		obtenerDatosFormularioParaBuscarCursoAlumnos();
		
	});

	$('#cursosJustificacionesAlumnos').change(function(){

		obtenerDatosFormularioParaBuscarCursoAlumnos();
	});

	$('#trayectosJustificacionAlumnos').change(function(){

		obtenerDatosFormularioParaBuscarCursoAlumnos();
	});


	// ====================================================================================
	// Funcion para obtener los datos del formulario
	// ====================================================================================
	const obtenerDatosFormularioParaBuscarCursoAlumnos = ()=>{

        // reseteo mi arreglo de id de checks
        idFechaJustificacionPersonaAlumno = [];
		// Obtener valores de los inputs y selects
		const idCicloLectivoJustificacionAlumnos = $("#cicloLectivoJustificacionAlumnos option:selected").val();
		const idCursosJustificacionesAlumnos = $("#cursosJustificacionesAlumnos option:selected").val();
		const idTrayectosJustificacionAlumnos = $("#trayectosJustificacionAlumnos option:selected").val();


		if (idCursosJustificacionesAlumnos == '0' || idTrayectosJustificacionAlumnos == '0'){ return;}


		const datosBusquedaCursoJustificacionAlumnos = {
			idCicloLectivoJustificacionAlumnos,
			idCursosJustificacionesAlumnos,
			idTrayectosJustificacionAlumnos
		};

		// console.log(datosBusquedaCursoJustificacionAlumnos)
		buscarAlumnosCurso(datosBusquedaCursoJustificacionAlumnos);
	};

	// ====================================================================================
	// Funcion para buscar a los alumnos de un curso
	// ====================================================================================
	const buscarAlumnosCurso = async(argDatosBusquedaCursoJustificacionAlumnos)=>{
		$('#errorJustificacionesAlumnos').empty();
		$('#resultadoListaBusquedaCursoAlumno').remove();
		$('#tablaJustificacionAlumnos').remove();

		// Creacion del objeto form que guardara todos los datos para el envio
		const data = new FormData();

		// Se guarda los datos para la busqueda del curso ingresado por el usuario
		// y se le especifica el metodo para el controlador
		data.append('accion', 'buscar_alumnos_curso');

		data.append('datosFormularioBuscarAlumnosCurso', JSON.stringify(argDatosBusquedaCursoJustificacionAlumnos));
		
		// Especifico hacia que controlador quiero enviar mi peticion
		const URL = 'sistema/controladores/justificacionesalumnos/controller.justificacionesAlumnos.php';
        // Especifico la configuracion de mi peticion y tambien los datos a enviar
        const CONFIG = {
        	method: 'POST',
        	body: data
        };

        // Realizo la peticion

        try {

        	const resultPeticionBuscarAlumnosCurso = await fetch(URL, CONFIG);
        	const resultBusquedaBuscarAlumnosCurso = await resultPeticionBuscarAlumnosCurso.json();


        	// console.log(resultBusquedaBuscarAlumnosCurso)

        	if (!resultBusquedaBuscarAlumnosCurso.estado) {

        		$('#errorJustificacionesAlumnos').append(`
        			<h3 class="text-dark">
        			<b>
        			${resultBusquedaBuscarAlumnosCurso.mensaje}
        			</b>
        			</h3>
        			`);
        		return;
        	}

        	$('#contenedorFormJustificacionAlumnos').append(resultBusquedaBuscarAlumnosCurso.mensaje);
        	

        } catch (e) {
        	console.log(e);
        }

    };

    $("#contenedorFormJustificacionAlumnos").on("change", "#busquedaCursoAlumnos", function(e){ 
    	e.preventDefault();
    	obtenerDatosFormularioBuscarInasistenciaAlumno();
    });


    const obtenerDatosFormularioBuscarInasistenciaAlumno = ()=>{

		// reseteo mi arreglo de id de checks
		idFechaJustificacionPersonaAlumno = [];
		// Obtener valores de los inputs y selects
		const idCicloLectivoJustificacionAlumnos = $("#cicloLectivoJustificacionAlumnos option:selected").val();
		const idCursosJustificacionesAlumnos = $("#cursosJustificacionesAlumnos option:selected").val();
		const idTrayectosJustificacionAlumnos = $("#trayectosJustificacionAlumnos option:selected").val();
		const idBusquedaCursoAlumnos = $("#busquedaCursoAlumnos option:selected").val();


		if (idCursosJustificacionesAlumnos == '0' || idTrayectosJustificacionAlumnos == '0' || idBusquedaCursoAlumnos == '0'){ return;}


		const datosBusquedaAlumnosInasistencias = {
			idCicloLectivoJustificacionAlumnos,
			idCursosJustificacionesAlumnos,
			idTrayectosJustificacionAlumnos,
			idBusquedaCursoAlumnos
		};

		// console.log(datosBusquedaAlumnosInasistencias)

		buscarCursoAlumnoInasistencia(datosBusquedaAlumnosInasistencias)
	} 

	// ====================================================================================
	// Funcion para buscar los datos del curso
	// ====================================================================================
	const buscarCursoAlumnoInasistencia = async(argdatosBusquedaAlumnosInasistencias)=>{
		$('#errorJustificacionesAlumnos').empty();
		$('#tablaJustificacionAlumnos').remove();

		// Creacion del objeto form que guardara todos los datos para el envio
		const data = new FormData();

		// Se guarda los datos para la busqueda del curso ingresado por el usuario
		// y se le especifica el metodo para el controlador
		data.append('accion', 'buscar_curso_inasistencias_alumno');

		data.append('datosFormularioCursoJustificacionAlumnos', JSON.stringify(argdatosBusquedaAlumnosInasistencias));
		
		// Especifico hacia que controlador quiero enviar mi peticion
		const URL = 'sistema/controladores/justificacionesalumnos/controller.justificacionesAlumnos.php';
        // Especifico la configuracion de mi peticion y tambien los datos a enviar
        const CONFIG = {
        	method: 'POST',
        	body: data
        };

        // Realizo la peticion

        try {

        	const resultPeticionCursoJustificacionAlumno = await fetch(URL, CONFIG);
        	const resultBusquedaCursoJustificacionAlumno = await resultPeticionCursoJustificacionAlumno.json();

        	// console.log(resultBusquedaCursoJustificacionAlumno);

        	if (!resultBusquedaCursoJustificacionAlumno.estado) {
        		$('#errorJustificacionesAlumnos').append(`
        			<h3 class="text-dark">
        			<b>
        			${resultBusquedaCursoJustificacionAlumno.mensaje}
        			</b>
        			</h3>
        			`);
        		return;
        	}
        	$('#contenedorFormJustificacionAlumnos').append(resultBusquedaCursoJustificacionAlumno.mensaje);
        	// Inicializacion de datatable

        	if ($.fn.DataTable.isDataTable('#table')) {
        		$('#table').DataTable().destroy();

        		$('#error').empty();
        		$('#tablaJustificacionAlumnos').remove();
        	}
        	$('#table').DataTable(window.configDatatables);

        } catch (e) {
        	console.log(e);
        }

    };

	// ====================================================================================
    // Funcion para guardar los id de los checks modificados
    // ====================================================================================
    let idFechaJustificacionPersonaAlumno = [];

    $("#contenedorFormJustificacionAlumnos").on("change", "#checkInasistenciaJustificacion", function(){ 


    	if (idFechaJustificacionPersonaAlumno.includes($(this).val())) { 
    		idFechaJustificacionPersonaAlumno.splice(idFechaJustificacionPersonaAlumno.indexOf($(this).val()), 1);
    	}else{
    		idFechaJustificacionPersonaAlumno.push($(this).val());
    	}

    	// console.log(idFechaJustificacionPersonaAlumno)
    });

    // ====================================================================================
	// Boton guardar
	// ====================================================================================

	$("#contenedorFormJustificacionAlumnos").on("click", "#guardarJustificacionAlumno", function(e){ 
		e.preventDefault();
		obtenerDatosFormularioJustificacionAlumno();
	});

    // Funcion para mandar datos para guardar

    const obtenerDatosFormularioJustificacionAlumno = async()=>{
    	
    	const archivoJustificacionAlumnos = $('#archivoJustificacionAlumnos')[0].files[0];

    	// console.log(archivoJustificacionAlumnos)

    	// Obtener valores de los inputs y selects
    	const idCicloLectivoJustificacionAlumnos = $("#cicloLectivoJustificacionAlumnos option:selected").val();
    	// const idCursosJustificacionesAlumnos = $("#cursosJustificacionesAlumnos option:selected").val();
    	const idTrayectosJustificacionAlumnos = $("#trayectosJustificacionAlumnos option:selected").val();
    	const idBusquedaCursoAlumnos = $("#busquedaCursoAlumnos option:selected").val();
    	
    	const datosGuardarJustificacionAlumnos = {
    		idCicloLectivoJustificacionAlumnos,
    		// idCursosJustificacionesAlumnos,
    		idTrayectosJustificacionAlumnos,
    		idBusquedaCursoAlumnos,
    		idFechaJustificacionPersonaAlumno
    	};

    	if (idFechaJustificacionPersonaAlumno == '') {
    		
    		Swal.fire({
    			title: `Debe realizar alguna modificacion, por favor verifique!`,
    			icon: `error`,
    			confirmButtonColor: '#3085d6',
    			confirmButtonText: `OK`
    		})
    		return;
    	}


    	if (archivoJustificacionAlumnos == null) {

    		const resultConfirJustificacion = await Swal.fire({
    			title: 'No selecciono algun documento para subir ¿Desea continuar?',
    			icon: 'warning',
    			showCancelButton: true,
    			confirmButtonColor: '#3085d6',
    			cancelButtonColor: '#d33',
    			confirmButtonText: 'Si, deseo continuar'
    		}).then((result) => {
    			if (result.value) {
    				guardarDatosFormularioJustificacionAlumno(datosGuardarJustificacionAlumnos, archivoJustificacionAlumnos);
    			} else if (result.dismiss === Swal.DismissReason.cancel){
    				return false;
    			}
    		});

    		if (!resultConfirJustificacion) {return;}
    	}

    	guardarDatosFormularioJustificacionAlumno(datosGuardarJustificacionAlumnos, archivoJustificacionAlumnos);

    };

// funcion para guardar los datos del formulario
    const guardarDatosFormularioJustificacionAlumno = async(argDatosGuardarJustificacionAlumnos, argArchivoJustificacionAlumnos)=>{
        
        $('#errorJustificacionesAlumnos').empty();
    	// console.log(argDatosGuardarJustificacionAlumnos)

    	// Creacion del objeto form que guardara todos los datos para el envio
    	const data = new FormData();

		// Se guarda los datos para el guardado de los datos del formulario
		// y se le especifica el metodo para el controlador
		data.append('accion', 'guardar_justificaciones_alumnos');

		data.append('datosGuardarJustificacionAlumnos', JSON.stringify(argDatosGuardarJustificacionAlumnos));
		data.append('archivoGuardarJustificacionAlumnos', argArchivoJustificacionAlumnos);
		
		// Especifico hacia que controlador quiero enviar mi peticion
		const URL = 'sistema/controladores/justificacionesalumnos/controller.justificacionesAlumnos.php';
        // Especifico la configuracion de mi peticion y tambien los datos a enviar
        const CONFIG = {
        	method: 'POST',
        	body: data
        };

        // Realizo la peticion

        try {

        	const resultPeticionGuardarJustificacionAlumnos = await fetch(URL, CONFIG);
        	const resultGuardadoJustificacionAlumnos = await resultPeticionGuardarJustificacionAlumnos.json();

        	// console.log(resultGuardadoJustificacionAlumnos);

        	if (!resultGuardadoJustificacionAlumnos.estado) {
        		$('#errorJustificacionesAlumnos').append(`
        			<h3 class="text-dark">
        			<b>
        			${resultGuardadoJustificacionAlumnos.mensaje}
        			</b>
        			</h3>
        			`);
        		return;
        	}

        	mostrarMensajeAlertaJustificacion(resultGuardadoJustificacionAlumnos.mensaje);
        } catch (e) {
        	console.log(e);
        }

    };

// funcion para emitir un mensaje de alerta
    const mostrarMensajeAlertaJustificacion = (alertTitulo)=>{
    	Swal.fire({
    		title: `${alertTitulo}`,
    		icon: `info`,
    		confirmButtonColor: '#3085d6',
    		confirmButtonText: `OK`
    	}).then((result) => {
    		if (result.value) {
    			obtenerDatosFormularioBuscarInasistenciaAlumno();
    		}else{
    			obtenerDatosFormularioBuscarInasistenciaAlumno();
    		}
    	})

    };
});