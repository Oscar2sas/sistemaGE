$(document).ready(function() {


	$('#pasajeCurso').change(function(e) {

		obtenerDatosDivision();
	});


	const obtenerDatosDivision = ()=>{

		const idPasajeCurso = $("#pasajeCurso option:selected").val();
		const idPasajeAnoLectivo = $("#pasajeAnoLectivo option:selected").val();

		// console.log(idPasajeCurso + idPasajeAnoLectivo)

		const datosBusquedaMovimientosDivisiones = {
			idPasajeCurso,
			idPasajeAnoLectivo			
		};

		obtenerDivisionAlumnosMovimientos(datosBusquedaMovimientosDivisiones);
	};

	const obtenerDivisionAlumnosMovimientos = async(argDatosBusquedaMovimientosDivisiones)=>{

		// console.log(argDatosBusquedaMovimientosDivisiones);
		$('#errorPasajeMovimientosDivisiones').empty();
		$('#tablaPasajeDivision').remove();

		// Creacion del objeto form que guardara todos los datos para el envio
		const data = new FormData();

		// Se guarda los datos para la busqueda del curso ingresado por el usuario
		// y se le especifica el metodo para el controlador
		data.append('accion', 'buscar_alumnos_movimientos_division');

		data.append('datosFormularioPasajeMovimientosDivisiones', JSON.stringify(argDatosBusquedaMovimientosDivisiones));
		
		// Especifico hacia que controlador quiero enviar mi peticion
		const URL = 'sistema/controladores/movimientosdivisiones/controller.movimientosdivisiones.php';
        // Especifico la configuracion de mi peticion y tambien los datos a enviar
        const CONFIG = {
        	method: 'POST',
        	body: data
        };

        // Realizo la peticion

        try {

        	const resultPeticionDivisionesMovimientos = await fetch(URL, CONFIG);
        	const resultBusquedaDivisionesMovimientos = await resultPeticionDivisionesMovimientos.json();

        	// console.log(resultBusquedaDivisionesMovimientos);

        	if (!resultBusquedaDivisionesMovimientos.estado) {
        		$('#errorPasajeMovimientosDivisiones').append(`
        			<h3 class="text-dark">
        			<b>
        			${resultBusquedaDivisionesMovimientos.mensaje}
        			</b>
        			</h3>
        			`);
        		return;
        	}
        	$('#contenedorFormPasajeCursoNuevoAnoLectivo').append(resultBusquedaDivisionesMovimientos.mensaje);
        	// Inicializacion de datatable

        	if ($.fn.DataTable.isDataTable('#table')) {
        		$('#table').DataTable().destroy();

        		$('#errorPasajeMovimientosDivisiones').empty();
        		$('#tablaPasajeDivision').remove();
        	}
        	$('#table').DataTable(window.configDatatables);
        } catch (e) {
        	console.log(e);
        }
    };


    // validar que no haya una division guardada previamente
    $("#contenedorFormPasajeCursoNuevoAnoLectivo").on("change", "#cursoPasajeDivisionSiguiente", function(){ 

    	const idCursoSiguiente = $(this).val();
    	const idAnoLectivoSiguiente = $("#anoLectivoSiguiente option:selected").val();


    	// console.log(idCursoSiguiente + idAnoLectivoSiguiente)
    	const datosVerificarDivisionPasaje = {
    		idCursoSiguiente,
    		idAnoLectivoSiguiente
    	};

    	verificarDivisionPasaje(datosVerificarDivisionPasaje);
    });

    const verificarDivisionPasaje = async(datosVerificarDivisionPasaje)=>{
    	// console.log(datosVerificarDivisionPasaje);
    	$('#erroCursoPasaje').empty();

    	// Creacion del objeto form que guardara todos los datos para el envio
    	const data = new FormData();

		// y se le especifica el metodo para el controlador
		data.append('accion', 'verificarDivisionPasaje');

		data.append('datosVerificarDivision', JSON.stringify(datosVerificarDivisionPasaje));
		
		// Especifico hacia que controlador quiero enviar mi peticion
		const URL = 'sistema/controladores/movimientosdivisiones/controller.movimientosdivisiones.php';
        // Especifico la configuracion de mi peticion y tambien los datos a enviar
        const CONFIG = {
        	method: 'POST',
        	body: data
        };

        // Realizo la peticion

        try {

        	const resultPeticionVerificarDivisionPasaje = await fetch(URL, CONFIG);
        	const resultBusquedaVerificarDivisionPasaje = await resultPeticionVerificarDivisionPasaje.json();

        	// console.log(resultBusquedaVerificarDivisionPasaje);

        	if (!resultBusquedaVerificarDivisionPasaje.estado) {
        		$('#erroCursoPasaje').append(`
        			<small class='text-dark'><b>${resultBusquedaVerificarDivisionPasaje.mensaje}</b></small>
        			`);
        		$("input[type='button']").prop('disabled', true);
        		return;
        	}

        	$("input[type='button']").prop('disabled', false);

        	
        } catch (e) {
        	console.log(e);
        }

    };



    $("#contenedorFormPasajeCursoNuevoAnoLectivo").on("click", "#btnPasarCursoNuevoAnoLectivo", function(){ 

    	const idCursoSiguiente = $("#cursoPasajeDivisionSiguiente option:selected").val();
    	const idAnoLectivoSiguiente = $("#anoLectivoSiguiente option:selected").val();

    	let idAlumnosCheck = [];

    	$("input[type=checkbox]:checked").each(function(){
    		idAlumnosCheck.push(this.value);
    	});

    	const datosGuardarDivisionPasaje = {
    		idCursoSiguiente,
    		idAnoLectivoSiguiente,
    		idAlumnosCheck
    	};

    	guardarAlumnosPasajeDivision(datosGuardarDivisionPasaje);
    });


    const guardarAlumnosPasajeDivision = async(datosGuardarDivisionPasaje)=>{

    	// console.log(datosGuardarDivisionPasaje);

    	// Creacion del objeto form que guardara todos los datos para el envio
    	const data = new FormData();

		// y se le especifica el metodo para el controlador
		data.append('accion', 'guardarAlumnosDivisionPasaje');

		data.append('datosAlumnosDivisionPasaje', JSON.stringify(datosGuardarDivisionPasaje));
		
		// Especifico hacia que controlador quiero enviar mi peticion
		const URL = 'sistema/controladores/movimientosdivisiones/controller.movimientosdivisiones.php';
        // Especifico la configuracion de mi peticion y tambien los datos a enviar
        const CONFIG = {
        	method: 'POST',
        	body: data
        };

        // Realizo la peticion

        try {

        	const resultPeticionGuardarAlumnosDivisionPasaje = await fetch(URL, CONFIG);
        	const resultBusquedaGuardarAlumnosDivisionPasaje = await resultPeticionGuardarAlumnosDivisionPasaje.json();

        	// console.log(resultBusquedaGuardarAlumnosDivisionPasaje);

        	if (!resultBusquedaGuardarAlumnosDivisionPasaje.estado) {
        		Swal.fire({
        			title: `Ha surgido algun error, por favor verifique!. Error: ${ resultBusquedaGuardarAlumnosDivisionPasaje.mensaje }`,
        			icon: `error`,
        			confirmButtonColor: '#3085d6',
        			confirmButtonText: `OK`
        		});
        		return;
        	}else{
        		Swal.fire({
        			title: `${ resultBusquedaGuardarAlumnosDivisionPasaje.mensaje }!`,
        			icon: `info`,
        			confirmButtonColor: '#3085d6',
        			confirmButtonText: `OK`
        		}).then((result) => {
        			if (result.value) {
        				location.reload();
        			}else{
        				location.reload();
        			}
        		})
        		// Recargo la página
        		
        		return;
        	}
        	
        } catch (e) {
        	console.log(e);
        }
    };

    $('#quitarAlumnosCurso').click(function(e) {

    	e.preventDefault();
    	
    	let idAlumnosQuitar = [];

    	$("input[type=checkbox]:checked").each(function(){
    		idAlumnosQuitar.push(this.value);
    	});

    	// console.log(idAlumnosQuitar);

    	if (idAlumnosQuitar.length) {
	    		const btnConfirmarQuitado = Swal.mixin({
	    			customClass: {
	    				confirmButton: 'btn btn-success',
	    				cancelButton: 'btn btn-danger'
	    			},
	    			buttonsStyling: true
	    		});

	    		btnConfirmarQuitado.fire({
	    			title: '¿Esta seguro de quitar estos alumnos de la division?',
	    			text: "",
	    			icon: 'warning',
	    			showCancelButton: true,
	    			confirmButtonText: 'Quitar!',
	    			cancelButtonText: 'Cancelar!',
	    			reverseButtons: true
	    		}).then((result) => {
	    			if (result.value) {
	    			// btnConfirmarQuitado.fire(
	    			// 	'Deleted!',
	    			// 	'Your file has been deleted.',
	    			// 	'success'
	    			// 	)

	    			modificarAlumnosDivision(idAlumnosQuitar);
	    		}
	    	});
    	}else{
    		Swal.fire({
        			title: `Debe haber algun alumno cargado en la division, por favor verifique!`,
        			icon: `error`,
        			confirmButtonColor: '#3085d6',
        			confirmButtonText: `OK`
        		});
    	}


    });

    const modificarAlumnosDivision = async(argIdAlumnosQuitar)=>{

    	// console.log(argIdAlumnosQuitar);
    	const idCurso = $('#idCurso').val();

    	// console.log(idCurso)
    	// Creacion del objeto form que guardara todos los datos para el envio
    	const data = new FormData();

		// y se le especifica el metodo para el controlador
		data.append('accion', 'quitarAlumnosDivisionPasaje');

		data.append('datosAlumnosQuitarDivision', JSON.stringify(argIdAlumnosQuitar));
		data.append('datosIdCursoAlumnosQuitarDivision', JSON.stringify(idCurso));
		
		// Especifico hacia que controlador quiero enviar mi peticion
		const URL = 'sistema/controladores/movimientosdivisiones/controller.movimientosdivisiones.php';
        // Especifico la configuracion de mi peticion y tambien los datos a enviar
        const CONFIG = {
        	method: 'POST',
        	body: data
        };

        // Realizo la peticion

        try {

        	const resultPeticionQuitarAlumnosDivision = await fetch(URL, CONFIG);
        	const resultModificacionAlumnosDivisionPasaje = await resultPeticionQuitarAlumnosDivision.json();

        	// console.log(resultModificacionAlumnosDivisionPasaje);

        	if (!resultModificacionAlumnosDivisionPasaje.estado) {
        		Swal.fire({
        			title: `Ha surgido algun error, por favor verifique!. Error: ${ resultModificacionAlumnosDivisionPasaje.mensaje }`,
        			icon: `error`,
        			confirmButtonColor: '#3085d6',
        			confirmButtonText: `OK`
        		});
        		return;
        	}else{
        		Swal.fire({
        			title: `${ resultModificacionAlumnosDivisionPasaje.mensaje }!`,
        			icon: `info`,
        			confirmButtonColor: '#3085d6',
        			confirmButtonText: `OK`
        		}).then((result) => {
        			if (result.value) {
        				location.reload();
        			}else{
        				location.reload();
        			}
        		})
        		return;
        	}
        	
        } catch (e) {
        	console.log(e);
        }
    };


    $('#eliminarDivisionAlumnoPasaje').click(function(e) {
    	e.preventDefault();

    	const cursoId = $('#cursoId').val();


    	Swal.fire({
    		title: '¿Esta seguro de borrar esta division?',
    		text: "",
    		icon: 'warning',
    		showCancelButton: true,
    		confirmButtonColor: '#3085d6',
    		cancelButtonColor: '#d33',
    		confirmButtonText: 'Si, eliminar!',
    		cancelButtonText: 'Cancelar!'
    	}).then((result) => {
    		if (result.value) {
    			// Swal.fire(
    			// 	'Deleted!',
    			// 	'Your file has been deleted.',
    			// 	'success'
    			// 	)
    			eliminarAlumnosDivision(cursoId);
    		}
    	})
    });


    const eliminarAlumnosDivision = async(argCursoId)=>{

    	// console.log(argIdAlumnosQuitar);
    	const idCurso = $('#idCurso').val();

    	// console.log(idCurso)
    	// Creacion del objeto form que guardara todos los datos para el envio
    	const data = new FormData();

		// y se le especifica el metodo para el controlador
		data.append('accion', 'eliminarAlumnosDivisionPasaje');

		data.append('datosIdCursoAlumnosEliminarDivision', JSON.stringify(argCursoId));
		
		// Especifico hacia que controlador quiero enviar mi peticion
		const URL = 'sistema/controladores/movimientosdivisiones/controller.movimientosdivisiones.php';
        // Especifico la configuracion de mi peticion y tambien los datos a enviar
        const CONFIG = {
        	method: 'POST',
        	body: data
        };

        // Realizo la peticion

        try {

        	const resultPeticionEliminarAlumnosDivision = await fetch(URL, CONFIG);
        	const resultEliminacionAlumnosDivisionPasaje = await resultPeticionEliminarAlumnosDivision.json();

        	// console.log(resultEliminacionAlumnosDivisionPasaje);

        	if (!resultEliminacionAlumnosDivisionPasaje.estado) {
        		Swal.fire({
        			title: `Ha surgido algun error, por favor verifique!. Error: ${ resultEliminacionAlumnosDivisionPasaje.mensaje }`,
        			icon: `error`,
        			confirmButtonColor: '#3085d6',
        			confirmButtonText: `OK`
        		});
        		return;
        	}else{
        		Swal.fire({
        			title: `${ resultEliminacionAlumnosDivisionPasaje.mensaje }!`,
        			icon: `info`,
        			confirmButtonColor: '#3085d6',
        			confirmButtonText: `OK`
        		}).then((result) => {
        			if (result.value) {
        				location.reload();
        			}else{
        				location.reload();
        			}
        		})
        		return;
        	}
        	
        } catch (e) {
        	console.log(e);
        }
    };
});