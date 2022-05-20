$(document).ready(function() {


	$('#movimientosAlumnosDivision').change(function(e) {

		obtenerDatosFormMovimientosAlumnos();
	});


	const obtenerDatosFormMovimientosAlumnos = ()=>{

		const idMovimientosAlumnosAnoLectivo = $("#movimientosAlumnosAnoLectivo option:selected").val();
		const idMovimientosAlumnosCurso = $("#movimientosAlumnosDivision option:selected").val();

		// console.log(idPasajeCurso + idPasajeAnoLectivo)

		const datosBusquedaDivisionMovimientosAlumnos = {
			idMovimientosAlumnosAnoLectivo,			
			idMovimientosAlumnosCurso
		};

		// console.log(datosBusquedaDivisionAlumnos);
		obtenerDivisionMovimientosAlumnos(datosBusquedaDivisionMovimientosAlumnos);
	};


	const obtenerDivisionMovimientosAlumnos = async(argDatosBusquedaDivisionMovimientosAlumnos)=>{

		// console.log(argDatosBusquedaDivisionMovimientosAlumnos)


		// console.log(argDatosBusquedaMovimientosDivisiones);
		$('#errorPasajeMovimientosAlumnos').empty();
		$('#tablaMovimientosAlumnos').remove();	

		// Creacion del objeto form que guardara todos los datos para el envio
		const data = new FormData();

		// Se guarda los datos para la busqueda del curso ingresado por el usuario
		// y se le especifica el metodo para el controlador
		data.append('accion', 'buscar_division_movimientos_alumnos');

		data.append('datosFormularioPasajeMovimientosAlumnos', JSON.stringify(argDatosBusquedaDivisionMovimientosAlumnos));
		
		// Especifico hacia que controlador quiero enviar mi peticion
		const URL = 'sistema/controladores/movimientosalumnos/controller.movimientosalumnos.php';
        // Especifico la configuracion de mi peticion y tambien los datos a enviar
        const CONFIG = {
        	method: 'POST',
        	body: data
        };

        // Realizo la peticion

        try {

        	const resultPeticionMovimientosAlumnos = await fetch(URL, CONFIG);
        	const resultBusquedaMovimientosAlumno = await resultPeticionMovimientosAlumnos.json();

        	// console.log(resultBusquedaMovimientosAlumno);

        	if (!resultBusquedaMovimientosAlumno.estado) {
        		$('#errorPasajeMovimientosAlumnos').append(`
        			<h3 class="text-dark">
        			<b>
        			${resultBusquedaMovimientosAlumno.mensaje}
        			</b>
        			</h3>
        			`);
        		return;
        	}
        	$('#contenedorFormPasajeAlumnosCurso').append(resultBusquedaMovimientosAlumno.mensaje);
        	// Inicializacion de datatable

        	if ($.fn.DataTable.isDataTable('#table')) {
        		$('#table').DataTable().destroy();

        		$('#errorPasajeMovimientosAlumnos').empty();
        		$('#tablaMovimientosAlumnos').remove();
        	}
        	$('#table').DataTable(window.configDatatables);
        } catch (e) {
        	console.log(e);
        }

    };

    // ====================================================================================
    // Funcion para guardar los id de los checks modificados
    // ====================================================================================
    let idMovimientosAlumnos = [];

    $("#contenedorFormPasajeAlumnosCurso").on("change", "#checkAlumnoPasaje", function(){ 


    	if (idMovimientosAlumnos.includes($(this).val())) { 
    		idMovimientosAlumnos.splice(idMovimientosAlumnos.indexOf($(this).val()), 1);
    	}else{
    		idMovimientosAlumnos.push($(this).val());
    	}

    	// console.log(idMovimientosAlumnos)
    });


     // ====================================================================================
	// Boton guardar
	// ====================================================================================

	$("#contenedorFormPasajeAlumnosCurso").on("click", "#btnMovimientosAlumnosGuardar", function(e){ 
		e.preventDefault();
		obtenerDatosFormularioMovimientosAlumno();
	});

    // Funcion para mandar datos para guardar

    const obtenerDatosFormularioMovimientosAlumno = async()=>{
    	
    	const archivoMovimientosAlumnos = $('#archivoMovimientosAlumnos')[0].files[0];

    	// console.log(archivoMovimientosAlumnos)

    	// Obtener valores de los inputs y selects
    	const idCursoPasajeDivisionSiguiente = $("#cursoPasajeDivisionSiguiente option:selected").val();
    	const idMovimientosAlumnosDivision = $("#movimientosAlumnosDivision option:selected").val();

    	
    	const datosGuardarMovimientosAlumnos = {
    		idCursoPasajeDivisionSiguiente,
    		idMovimientosAlumnos,
    	};


    	if (idCursoPasajeDivisionSiguiente == idMovimientosAlumnosDivision) {
    		
    		Swal.fire({
    			title: `Debe seleccionar a un curso diferente para realizar el pasaje, por favor verifique!`,
    			icon: `warning`,
    			confirmButtonColor: '#3085d6',
    			confirmButtonText: `OK`
    		})
    		return;
    	}

    	if (idMovimientosAlumnos == '') {
    		
    		Swal.fire({
    			title: `Debe seleccionar a un alumno para realizar el pasaje, por favor verifique!`,
    			icon: `warning`,
    			confirmButtonColor: '#3085d6',
    			confirmButtonText: `OK`
    		})
    		return;
    	}

    	if (idCursoPasajeDivisionSiguiente == '0') {
    		
    		Swal.fire({
    			title: `Debe seleccionar un curso para realizar el pasaje, por favor verifique!`,
    			icon: `warning`,
    			confirmButtonColor: '#3085d6',
    			confirmButtonText: `OK`
    		})
    		return;
    	}


    	if (archivoMovimientosAlumnos == null) {

    		Swal.fire({
    			title: `No selecciono algun documento para subir, por favor verifique!`,
    			icon: `warning`,
    			confirmButtonColor: '#3085d6',
    			confirmButtonText: `OK`
    		})
    		return;
    	}

    	// console.log(datosGuardarMovimientosAlumnos);
    	// console.log(archivoMovimientosAlumnos);
    	guardarDatosFormularioMovimientosAlumnos(datosGuardarMovimientosAlumnos, archivoMovimientosAlumnos);

    };

// funcion para guardar los datos del formulario de movimientos de alumnos
    const guardarDatosFormularioMovimientosAlumnos = async(argDatosGuardarMovimientosAlumnos, argArchivoMovimientosAlumnos)=>{

    	// console.log(argDatosGuardarJustificacionAlumnos)

    	// Creacion del objeto form que guardara todos los datos para el envio
    	const data = new FormData();

		// Se guarda los datos para el guardado de los datos del formulario
		// y se le especifica el metodo para el controlador
		data.append('accion', 'guardar_pasaje_alumno_nuevo_curso');

		data.append('datosGuardarMovimientosAlumnos', JSON.stringify(argDatosGuardarMovimientosAlumnos));
		data.append('archivoGuardarMovimientosAlumnos', argArchivoMovimientosAlumnos);
		
		// Especifico hacia que controlador quiero enviar mi peticion
		const URL = 'sistema/controladores/movimientosalumnos/controller.movimientosalumnos.php';
        // Especifico la configuracion de mi peticion y tambien los datos a enviar
        const CONFIG = {
        	method: 'POST',
        	body: data
        };

        // Realizo la peticion

        try {

        	const resultPeticionGuardarMovimientosAlumnos = await fetch(URL, CONFIG);
        	const resultGuardadoMovimientosAlumnos = await resultPeticionGuardarMovimientosAlumnos.json();

        	// console.log(resultGuardadoMovimientosAlumnos);

        	if (!resultGuardadoMovimientosAlumnos.estado) {
        		$('#errorJustificacionesAlumnos').append(`
        			<h3 class="text-dark">
        			<b>
        			${resultGuardadoMovimientosAlumnos.mensaje}
        			</b>
        			</h3>
        			`);
        		return;
        	}

        	mostrarMensajeAlertaMovimientosAlumnos(resultGuardadoMovimientosAlumnos.mensaje);
        } catch (e) {
        	console.log(e);
        }

    };


    // funcion para emitir un mensaje de alerta
    const mostrarMensajeAlertaMovimientosAlumnos = (alertTitulo)=>{
    	Swal.fire({
    		title: `${alertTitulo}`,
    		icon: `info`,
    		confirmButtonColor: '#3085d6',
    		confirmButtonText: `OK`
    	}).then((result) => {
    		idMovimientosAlumnos = [];
    		if (result.value) {
    			obtenerDatosFormMovimientosAlumnos();
    		}else{
    			obtenerDatosFormMovimientosAlumnos();
    		}
    	})

    };

});