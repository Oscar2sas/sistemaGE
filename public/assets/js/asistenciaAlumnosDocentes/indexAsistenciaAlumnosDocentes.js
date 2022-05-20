$(document).ready(function() {

	$('#cicloLectivoAsistenciaAlumnosDocentes').change(function(){

		obtenerDatosBuscarMateriasAsistenciaAlumnosDocentes();
	});

	$('#fechaAsistenciaAlumnosDocentes').change(function(){

		obtenerDatosBuscarMateriasAsistenciaAlumnosDocentes();
		
	});

	$('#cursosAsistenciaAlumnosDocentes').change(function(){

		obtenerDatosBuscarMateriasAsistenciaAlumnosDocentes();
	});

	$('#trayectosAsistenciaAlumnosDocentes').change(function(){

		obtenerDatosBuscarMateriasAsistenciaAlumnosDocentes();
	});



	const obtenerDatosBuscarMateriasAsistenciaAlumnosDocentes = ()=>{


		const idCicloLectivoAsistenciaAlumnosDocentes = $("#cicloLectivoAsistenciaAlumnosDocentes option:selected").val();
		const fechaAsistenciaAlumnosDocentes = $('#fechaAsistenciaAlumnosDocentes').val();
		const idCursosAsistenciaAlumnosDocentes = $("#cursosAsistenciaAlumnosDocentes option:selected").val();
		const idTrayectosAsistenciaAlumnosDocentes = $("#trayectosAsistenciaAlumnosDocentes option:selected").val();

		if (!verificarFecha(fechaAsistenciaAlumnosDocentes)) {
			return;
		}

		if (idCicloLectivoAsistenciaAlumnosDocentes == '0' || idTrayectosAsistenciaAlumnosDocentes == '0'){ return;}

		const datosParamentrosAsistenciaAlumnosDocentes = {
			idCicloLectivoAsistenciaAlumnosDocentes,
			fechaAsistenciaAlumnosDocentes,
			idCursosAsistenciaAlumnosDocentes,
			idTrayectosAsistenciaAlumnosDocentes
		};

		buscarMateriasAsistenciaAlumnosDocentes(datosParamentrosAsistenciaAlumnosDocentes);
	};


	const buscarMateriasAsistenciaAlumnosDocentes = async(argDatosParamentrosAsistenciaAlumnosDocentes)=>{

		$('#errorAsistenciaAlumnosDocentes').empty();
		$('#tablaAsistenciaAlumnosDocentes').remove();


		// console.log(argDatosParamentrosAsistenciaAlumnosDocentes)

		// Creacion del objeto form que guardara todos los datos para el envio
		const data = new FormData();

        // Se guarda los datos para la busqueda del curso ingresado por el usuario
        // y se le especifica el metodo para el controlador
        data.append('accion', 'buscar_materias_asistencia_alumnos_docentes');

        data.append('datosDatosParametrosBuscarMateriasDocentes', JSON.stringify(argDatosParamentrosAsistenciaAlumnosDocentes));

        // Especifico hacia que controlador quiero enviar mi peticion
        const URL = `sistema/controladores/asistenciaalumnosdocentes/controller.asistenciaalumnosdocentes.php`;
        // Especifico la configuracion de mi peticion y tambien los datos a enviar
        const CONFIG = {
        	method: 'POST',
        	body: data
        };
        // Realizo la peticion

        try {

        	const resultPeticionBuscarMateriasDocentes = await fetch(URL, CONFIG);
        	const resultDatosBuscarMateriasDocentes = await resultPeticionBuscarMateriasDocentes.json();
            // console.log(resultDatosBuscarMateriasDocentes)

            if (!resultDatosBuscarMateriasDocentes.estado) {
            	$('#descrMateriasDocentes').append(`
            		<h3 class="text-dark">
            		<b>
            		${resultDatosBuscarMateriasDocentes.mensaje}
            		</b>
            		</h3>`);
            	return false;
            }

            $('#descrMateriasDocentes').append(`${ resultDatosBuscarMateriasDocentes.mensaje }`);

        } catch (e) {
        	console.log(e);
        }


    };



    $("#contenedorFormAsistenciaAlumnosDocentes").on("change", "#materiasAsistenciaAlumnosDocentes", function(){ 

    	obtenerDatosBuscarAsistenciaAlumnosDocentes();

    });


    const obtenerDatosBuscarAsistenciaAlumnosDocentes = ()=>{


    	const idCicloLectivoAsistenciaAlumnosDocentes = $("#cicloLectivoAsistenciaAlumnosDocentes option:selected").val();
    	const fechaAsistenciaAlumnosDocentes = $('#fechaAsistenciaAlumnosDocentes').val();
    	const idCursosAsistenciaAlumnosDocentes = $("#cursosAsistenciaAlumnosDocentes option:selected").val();
    	const idTrayectosAsistenciaAlumnosDocentes = $("#trayectosAsistenciaAlumnosDocentes option:selected").val();
    	const idMateriasAsistenciaAlumnosDocentes = $("#materiasAsistenciaAlumnosDocentes option:selected").val();

    	// // if (!verificarFecha(fechaAsistenciaAlumnosDocentes)) {
    	// // 	return;
    	// // }

    	// if (idCicloLectivoAsistenciaAlumnosDocentes == '0' || idTrayectosAsistenciaAlumnosDocentes == '0' || idMateriasAsistenciaAlumnosDocentes == '0'){ return;}

    	const datosParamentrosAsistenciaAlumnosDocentes = {
    		idCicloLectivoAsistenciaAlumnosDocentes,
    		fechaAsistenciaAlumnosDocentes,
    		idCursosAsistenciaAlumnosDocentes,
    		idTrayectosAsistenciaAlumnosDocentes,
    		idMateriasAsistenciaAlumnosDocentes
    	};

    	buscarAsistenciaAlumnosDocentes(datosParamentrosAsistenciaAlumnosDocentes);
    };

    const buscarAsistenciaAlumnosDocentes = async(argDatosParamentrosAsistenciaAlumnosDocentes)=>{

		// console.log(argDatosParamentrosAsistenciaAlumnosDocentes);

		// Creacion del objeto form que guardara todos los datos para el envio
		const data = new FormData();

        // Se guarda los datos para la busqueda del curso ingresado por el usuario
        // y se le especifica el metodo para el controlador
        data.append('accion', 'buscar_asistencia_alumnos_docentes');

        data.append('datosDatosParametrosAsistenciaAlumnosDocentes', JSON.stringify(argDatosParamentrosAsistenciaAlumnosDocentes));

        // Especifico hacia que controlador quiero enviar mi peticion
        const URL = `sistema/controladores/asistenciaalumnosdocentes/controller.asistenciaalumnosdocentes.php`;
        // Especifico la configuracion de mi peticion y tambien los datos a enviar
        const CONFIG = {
        	method: 'POST',
        	body: data
        };
        // Realizo la peticion

        try {

        	const resultPeticionAsistenciasAlumnosDocentes = await fetch(URL, CONFIG);
        	const resultDatosAsistenciasAlumnosDocentes = await resultPeticionAsistenciasAlumnosDocentes.json();
        	console.log(resultDatosAsistenciasAlumnosDocentes)
        	$('#errorAsistenciaAlumnosDocentes').remove();
        	$('#tablaAsistenciaAlumnosDocentes').remove();
        	if (!resultDatosAsistenciasAlumnosDocentes.estado) {
        		$('#contenedorFormAsistenciaAlumnosDocentes').append(`
        			<div class="form-group" id="errorAsistenciaAlumnosDocentes">
        			<h3 class="text-dark">
        			<b>
        			${resultDatosAsistenciasAlumnosDocentes.mensaje}
        			</b>
        			</h3>
        			</div>
        			`);

        		return false;
        	}

        	$('#contenedorFormAsistenciaAlumnosDocentes').append(resultDatosAsistenciasAlumnosDocentes.mensaje);
        	// Inicializacion de datatable

        	if ($.fn.DataTable.isDataTable('#table')) {
        		$('#table').DataTable().destroy();

        		$('#errorAsistenciaAlumnosDocentes').empty();
        		$('#tablaAsistenciaAlumnosDocentes').remove();
        	}
        	$('#table').DataTable(window.configDatatables);


        } catch (e) {
        	console.log(e);
        }


    };

	// ====================================================================================
    // Funcion para guardar los id de los checks modificados
    // ====================================================================================
    let idAsistenciaAlumnosDocentes = [];

    $("#contenedorFormAsistenciaAlumnosDocentes").on("change", "#checkInasistenciaAlumnosDocentes", function(){ 

    	if (idAsistenciaAlumnosDocentes.includes($(this).val())) { 
    		idAsistenciaAlumnosDocentes.splice(idAsistenciaAlumnosDocentes.indexOf($(this).val()), 1);
    	}else{
    		idAsistenciaAlumnosDocentes.push($(this).val());
    	}

    	// console.log(idAsistenciaAlumnosDocentes);
    });    


    // Funcion click del boton para guardar los datos
    $("#contenedorFormAsistenciaAlumnosDocentes").on("click", "#guardarInasistenciaAlumnosDocentes", function(){ 

    	obtenerDatosGuardarAsistenciaAlumnosDocentes();

    });

    const obtenerDatosGuardarAsistenciaAlumnosDocentes = ()=>{


    	const idCicloLectivoAsistenciaAlumnosDocentes = $("#cicloLectivoAsistenciaAlumnosDocentes option:selected").val();
    	const fechaAsistenciaAlumnosDocentes = $('#fechaAsistenciaAlumnosDocentes').val();
    	const idCursosAsistenciaAlumnosDocentes = $("#cursosAsistenciaAlumnosDocentes option:selected").val();
    	const idTrayectosAsistenciaAlumnosDocentes = $("#trayectosAsistenciaAlumnosDocentes option:selected").val();
    	const idMateriasAsistenciaAlumnosDocentes = $("#materiasAsistenciaAlumnosDocentes option:selected").val();

    	if (idCicloLectivoAsistenciaAlumnosDocentes == '0' || idTrayectosAsistenciaAlumnosDocentes == '0' || idMateriasAsistenciaAlumnosDocentes == '0'){ return;}

    	const datosParamentrosGuardarAsistenciaAlumnosDocentes = {
    		idCicloLectivoAsistenciaAlumnosDocentes,
    		fechaAsistenciaAlumnosDocentes,
    		idCursosAsistenciaAlumnosDocentes,
    		idTrayectosAsistenciaAlumnosDocentes,
    		idMateriasAsistenciaAlumnosDocentes,
    		idAsistenciaAlumnosDocentes
    	};

    	if (idAsistenciaAlumnosDocentes == '') {
    		mostrarMensajeAlerta('Debe Modificar Alguna Asistencia, Verifique');
    	}else{
    		guardarAsistenciaAlumnosDocentes(datosParamentrosGuardarAsistenciaAlumnosDocentes);
    	}

    };


    const guardarAsistenciaAlumnosDocentes = async(argDatosParamentrosGuardarAsistenciaAlumnosDocentes)=>{

		// console.log(argDatosParamentrosGuardarAsistenciaAlumnosDocentes);

		// Creacion del objeto form que guardara todos los datos para el envio
		const data = new FormData();

        // Se guarda los datos para la busqueda del curso ingresado por el usuario
        // y se le especifica el metodo para el controlador
        data.append('accion', 'guardar_asistencia_alumnos_docentes');

        data.append('datosParametrosGuardarAsistenciaAlumnosDocentes', JSON.stringify(argDatosParamentrosGuardarAsistenciaAlumnosDocentes));

        // Especifico hacia que controlador quiero enviar mi peticion
        const URL = `sistema/controladores/asistenciaalumnosdocentes/controller.asistenciaalumnosdocentes.php`;
        // Especifico la configuracion de mi peticion y tambien los datos a enviar
        const CONFIG = {
        	method: 'POST',
        	body: data
        };
        // Realizo la peticion

        try {

        	const resultPeticionGuardarAsistenciasAlumnosDocentes = await fetch(URL, CONFIG);
        	const resultDatosGuardarAsistenciasAlumnosDocentes = await resultPeticionGuardarAsistenciasAlumnosDocentes.json();
        	console.log(resultDatosGuardarAsistenciasAlumnosDocentes);

        	idAsistenciaAlumnosDocentes = [];

        	mostrarMensajeAlerta(resultDatosGuardarAsistenciasAlumnosDocentes.mensaje);

        } catch (e) {
        	console.log(e);
        }


    };

    const mostrarMensajeAlerta = (alertTitulo)=>{
    	Swal.fire({
    		title: `${alertTitulo}`,
    		icon: `info`,
    		confirmButtonColor: '#3085d6',
    		confirmButtonText: `OK`
    	}).then((result) => {
    		if (result.value) {
    			obtenerDatosBuscarAsistenciaAlumnosDocentes();
    		}else{
    			obtenerDatosBuscarAsistenciaAlumnosDocentes();
    		}
    	})

    };

	// ====================================================================================
    // Funcion para validar las fecha de asistencia
    // ====================================================================================
    const verificarFecha = (argFecha) => {

    	$('#descrMateriasDocentes').empty();

    	const fecha = argFecha.split("-")[0];
    	const anoLectivo = $('#cicloLectivoAsistenciaAlumnosDocentes').text().trim();

    	if (argFecha == '') {

    		$('#descrMateriasDocentes').append(`
    			<h3 class="text-dark">
    			<b>
    			No puede dejar la fecha de la asistencia vacia, por favor verifique!
    			</b>
    			</h3>`);
    		return false;
    	}

    	if (fecha != anoLectivo) {

    		$('#descrMateriasDocentes').append(`
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