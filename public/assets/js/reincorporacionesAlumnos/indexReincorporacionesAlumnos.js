$(document).ready(function() {


	$('#reincorporarAlumno').click(function(){

		obtenerDatosFormularioReincorporarAlumnos();

	});


	const obtenerDatosFormularioReincorporarAlumnos = ()=>{

		const archivoReincorporacionAlumnos = $('#archivoReincorporacionAlumnos')[0].files[0];

		if (idReincorporacionAlumno == '') {
			mostrarMensajeAlertaReincorporacionAlumnos('Debe seleccionar a un alumno para realizar la reincorporacion!');
			return;
		}

		if (archivoReincorporacionAlumnos == null) {
			mostrarMensajeAlertaReincorporacionAlumnos('Debe seleccionar un archivo para realizar la reincorporacion!');
			return;
		}

		Swal.fire({
			title: '¿Esta seguro de reincorporar a este alumno?',
			text: "",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Si, Reincorporar!',
			cancelButtonText: 'Cancelar!'
		}).then((result) => {
			if (result.value) {
				guardarDatosFormularioReincorporarAlumnos(archivoReincorporacionAlumnos);
			}
		})
	};


	const guardarDatosFormularioReincorporarAlumnos = async(argArchivoReincorporacionAlumnos)=>{

		// console.log(argArchivoReincorporacionAlumnos);
		// console.log(idReincorporacionAlumno);

		$('#errorReincorporacionesAlumnos').empty();
    	// console.log(argDatosGuardarJustificacionAlumnos)

    	// Creacion del objeto form que guardara todos los datos para el envio
    	const data = new FormData();

		// Se guarda los datos para el guardado de los datos del formulario
		// y se le especifica el metodo para el controlador
		data.append('accion', 'guardar_reincorporacion_alumnos');

		data.append('datosGuardarReincorporacionAlumnos', JSON.stringify(idReincorporacionAlumno));
		data.append('archivoGuardarReincorporacionAlumnos', argArchivoReincorporacionAlumnos);
		
		// Especifico hacia que controlador quiero enviar mi peticion
		const URL = 'sistema/controladores/reincorporacionesalumnos/controller.reincorporacionesalumnos.php';
        // Especifico la configuracion de mi peticion y tambien los datos a enviar
        const CONFIG = {
        	method: 'POST',
        	body: data
        };

        // Realizo la peticion

        try {

        	const resultPeticionGuardarReincorporacionAlumnos = await fetch(URL, CONFIG);
        	const resultGuardadoReincorporacionAlumnos = await resultPeticionGuardarReincorporacionAlumnos.json();

        	// console.log(resultGuardadoReincorporacionAlumnos);

        	if (!resultGuardadoReincorporacionAlumnos.estado) {
        		$('#errorReincorporacionesAlumnos').append(`
        			<h3 class="text-dark">
        			<b>
        			${resultGuardadoReincorporacionAlumnos.mensaje}
        			</b>
        			</h3>
        			`);
        		return;
        	}


        	Swal.fire({
        		title: `${resultGuardadoReincorporacionAlumnos.mensaje}`,
        		icon: `success`,
        		confirmButtonColor: '#3085d6',
        		confirmButtonText: `OK`
        	}).then((result) => {
        		if (result.value) {
        			location.reload();
        		}else{
        			location.reload();
        		}
        	})
        } catch (e) {
        	console.log(e);
        }

    };

	// ====================================================================================
    // Funcion para guardar los id de los checks de los alumnos seleccionados
    // ====================================================================================
    let idReincorporacionAlumno = [];

    $("#contenedorFormReincorporacionesAlumnos").on("change", "#checkReincorporacionAlumnos", function(){ 


    	if (idReincorporacionAlumno.includes($(this).val())) { 
    		idReincorporacionAlumno.splice(idReincorporacionAlumno.indexOf($(this).val()), 1);
    	}else{
    		idReincorporacionAlumno.push($(this).val());
    	}

    	// console.log(idReincorporacionAlumno)
    });

    // funcion para emitir un mensaje de alerta
    const mostrarMensajeAlertaReincorporacionAlumnos = (alertTitulo)=>{
    	Swal.fire({
    		title: `${alertTitulo}`,
    		icon: `info`,
    		confirmButtonColor: '#3085d6',
    		confirmButtonText: `OK`
    	})
    };
});