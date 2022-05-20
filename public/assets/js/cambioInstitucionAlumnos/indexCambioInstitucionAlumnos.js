$(document).ready(function() {

	$('#cambioInstitucionAlumnosCurso').change(function(e) {

		obtenerDatosFormCambioInstitucionAlumnos();
	});


	const obtenerDatosFormCambioInstitucionAlumnos = ()=>{

		const idCambioInstitucionAlumnoAnoLectivo = $("#cambioInstitucionAlumnosAnoLectivo option:selected").val();
		const idCambioInstitucionAlumnosCurso = $("#cambioInstitucionAlumnosCurso option:selected").val();

		// console.log(idCambioInstitucionAlumnoAnoLectivo + idCambioInstitucionAlumnosCurso)

		const datosBusquedaCambioInstitucionAlumnos = {
			idCambioInstitucionAlumnoAnoLectivo,			
			idCambioInstitucionAlumnosCurso
		};

		// console.log(datosBusquedaCambioInstitucionAlumnos);
		obtenerDivisionCambioInstitucionAlumnos(datosBusquedaCambioInstitucionAlumnos);
	};


	const obtenerDivisionCambioInstitucionAlumnos = async(argDatosBusquedaCambioInstitucionAlumnos)=>{

		// console.log(argDatosBusquedaCambioInstitucionAlumnos);



		$('#errorCambioInstitucionAlumnos').empty();
		$('#tablaCambioInstitucionAlumnos').remove();	

		// Creacion del objeto form que guardara todos los datos para el envio
		const data = new FormData();

		// Se guarda los datos para la busqueda del curso ingresado por el usuario
		// y se le especifica el metodo para el controlador
		data.append('accion', 'buscar_division_cambio_institucion_alumnos');

		data.append('datosFormularioCambioInstitucionAlumnos', JSON.stringify(argDatosBusquedaCambioInstitucionAlumnos));
		
		// Especifico hacia que controlador quiero enviar mi peticion
		const URL = 'sistema/controladores/cambioinstitucionalumnos/controller.cambioinstitucionalumnos.php';
        // Especifico la configuracion de mi peticion y tambien los datos a enviar
        const CONFIG = {
        	method: 'POST',
        	body: data
        };

        // Realizo la peticion

        try {

        	const resultPeticionDivisionCambioInstitucionAlumnos = await fetch(URL, CONFIG);
        	const resultBusquedaDivisionCambioInstitucionAlumnos = await resultPeticionDivisionCambioInstitucionAlumnos.json();

        	// console.log(resultBusquedaDivisionCambioInstitucionAlumnos);

        	if (!resultBusquedaDivisionCambioInstitucionAlumnos.estado) {
        		$('#errorCambioInstitucionAlumnos').append(`
        			<h3 class="text-dark">
        			<b>
        			${resultBusquedaDivisionCambioInstitucionAlumnos.mensaje}
        			</b>
        			</h3>
        			`);
        		return;
        	}
        	$('#contenedorFormCambioInstitucionAlumnos').append(resultBusquedaDivisionCambioInstitucionAlumnos.mensaje);
        	// Inicializacion de datatable

        	if ($.fn.DataTable.isDataTable('#table')) {
        		$('#table').DataTable().destroy();

        		$('#errorCambioInstitucionAlumnos').empty();
        		$('#tablaCambioInstitucionAlumnos').remove();
        	}
        	$('#table').DataTable(window.configDatatables);
        } catch (e) {
        	console.log(e);
        }
    };


	// ====================================================================================
    // Funcion para guardar los id de los alumnos a cambia de institucion
    // ====================================================================================
    let idCambioInstitucionAlumnos = [];

    $("#contenedorFormCambioInstitucionAlumnos").on("change", "#checkCambioInstitucionAlumno", function(){ 


    	if (idCambioInstitucionAlumnos.includes($(this).val())) { 
    		idCambioInstitucionAlumnos.splice(idCambioInstitucionAlumnos.indexOf($(this).val()), 1);
    	}else{
    		idCambioInstitucionAlumnos.push($(this).val());
    	}

    	// console.log(idCambioInstitucionAlumnos)
    });


     // ====================================================================================
	// Boton guardar
	// ====================================================================================

	$("#contenedorFormCambioInstitucionAlumnos").on("click", "#btnCambioInstitucionAlumnosGuardar", function(e){ 
		e.preventDefault();
		obtenerDatosFormularioCambioInstitucionAlumno();
	});

    // Funcion para mandar datos para guardar

    const obtenerDatosFormularioCambioInstitucionAlumno = async()=>{
    	
    	const archivoCambioInstitucionAlumnos = $('#archivoCambioInstitucionAlumnos')[0].files[0];

    	// console.log(archivoCambioInstitucionAlumnos)

    	// Obtener valores de los inputs y selects
    	const descCambioInstitucionAlumnos = $("#descCambioInstitucionAlumnos").val();

    	const datosGuardarCambioInstitucionAlumnos = {
    		descCambioInstitucionAlumnos,
    		idCambioInstitucionAlumnos
    	};

    	if (idCambioInstitucionAlumnos == '') {
    		
    		Swal.fire({
    			title: `Debe seleccionar a un alumno para realizar la baja, por favor verifique!`,
    			icon: `warning`,
    			confirmButtonColor: '#3085d6',
    			confirmButtonText: `OK`
    		})
    		return;
    	}

    	if (descCambioInstitucionAlumnos == '') {
    		
    		Swal.fire({
    			title: `Debe agregar una descripcion del motivo, por favor verifique!`,
    			icon: `warning`,
    			confirmButtonColor: '#3085d6',
    			confirmButtonText: `OK`
    		})
    		return;
    	}


    	if (archivoCambioInstitucionAlumnos == null) {

    		Swal.fire({
    			title: `No selecciono algun documento para subir, por favor verifique!`,
    			icon: `warning`,
    			confirmButtonColor: '#3085d6',
    			confirmButtonText: `OK`
    		})
    		return;
    	}

    	// console.log(datosGuardarCambioInstitucionAlumnos);
    	// console.log(archivoCambioInstitucionAlumnos);
    	Swal.fire({
    		title: '¿Esta seguro de dar de baja a este alumno?',
    		text: "",
    		icon: 'warning',
    		showCancelButton: true,
    		confirmButtonColor: '#3085d6',
    		cancelButtonColor: '#d33',
    		confirmButtonText: 'Si, Dar Baja!',
    		cancelButtonText: 'Cancelar!'
    	}).then((result) => {
    		if (result.value) {
    			guardarDatosFormularioCambioInstitucionAlumnos(datosGuardarCambioInstitucionAlumnos, archivoCambioInstitucionAlumnos);
    		}
    	})
    };


    const guardarDatosFormularioCambioInstitucionAlumnos = async(argDatosGuardarCambioInstitucionAlumnos, argArchivoCambioInstitucionAlumnos)=>{


    	// Creacion del objeto form que guardara todos los datos para el envio
    	const data = new FormData();

		// Se guarda los datos para el guardado de los datos del formulario
		// y se le especifica el metodo para el controlador
		data.append('accion', 'guardar_cambio_institucion_alumnos');

		data.append('datosGuardarCambioInstitucionAlumnos', JSON.stringify(argDatosGuardarCambioInstitucionAlumnos));
		data.append('archivoGuardarCambioInstitucionAlumnos', argArchivoCambioInstitucionAlumnos);
		
		// Especifico hacia que controlador quiero enviar mi peticion
		const URL = 'sistema/controladores/cambioinstitucionalumnos/controller.cambioinstitucionalumnos.php';
        // Especifico la configuracion de mi peticion y tambien los datos a enviar
        const CONFIG = {
        	method: 'POST',
        	body: data
        };

        // Realizo la peticion

        try {

        	const resultPeticionGuardarCambioInstitucionAlumnos = await fetch(URL, CONFIG);
        	const resultGuardadoCambioInstitucion = await resultPeticionGuardarCambioInstitucionAlumnos.json();

        	// console.log(resultGuardadoCambioInstitucion);

        	if (!resultGuardadoCambioInstitucion.estado) {
        		$('#errorGuardadoCambioInstitucionAlumnos').append(`
        			<h3 class="text-dark">
        			<b>
        			${resultGuardadoCambioInstitucion.mensaje}
        			</b>
        			</h3>
        			`);
        		return;
        	}

        	mostrarMensajeAlertaCambioInstitucionAlumnos(resultGuardadoCambioInstitucion.mensaje);
        } catch (e) {
        	console.log(e);
        }

    };


    // funcion para emitir un mensaje de alerta
    const mostrarMensajeAlertaCambioInstitucionAlumnos = (alertTitulo)=>{
    	Swal.fire({
    		title: `${alertTitulo}`,
    		icon: `success`,
    		confirmButtonColor: '#3085d6',
    		confirmButtonText: `OK`
    	}).then((result) => {
    		idCambioInstitucionAlumnos = [];
    		if (result.value) {
    			obtenerDatosFormCambioInstitucionAlumnos();
    		}else{
    			obtenerDatosFormCambioInstitucionAlumnos();
    		}
    	})

    };

});