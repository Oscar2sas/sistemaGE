$(document).ready(function() {
	
	$('#enviarNotificacionAlumnos').click(function(e) {
		e.preventDefault();

		const resultDatosFormularios = obtenerDatosFormularios();
		if (!resultDatosFormularios) {return;}

		enviarNotificacionAlumnos(resultDatosFormularios);
	});

	const enviarNotificacionAlumnos = async(resultDatosFormularios)=>{

		
		$('#enviarNotificacionAlumnos').attr("disabled", true);

		$('#contenedorFormNotificacionesAlumnos').append(`

			<div class="form-group" id='imagenEsperaNotificacionAlumnos'>
			<label>enviando notificaciones, por favor espere</label>
			<div class="d-flex justify-content-center">
			<div class="spinner-border" style="width: 3rem; height: 3rem;" role="status"></div>
			</div>
			</div>
			`
			);

		// Creacion del objeto form que guardara todos los datos para el envio
		const data = new FormData();

		// Se guarda los datos para el envio de la notificacion
		// y se le especifica el metodo para el controlador
		data.append('accion', 'enviar_notificacion_alumnos');

		data.append('datosNotificacionAlumnos', JSON.stringify(resultDatosFormularios));
		
		// Especifico hacia que controlador quiero enviar mi peticion
		const URL = 'sistema/controladores/notificacionesalumnos/controller.notificacionesalumnos.php';
        // Especifico la configuracion de mi peticion y tambien los datos a enviar
        const CONFIG = {
        	method: 'POST',
        	body: data
        };


        // Realizo la peticion

        try {
        	// Seccion verificar si la fecha es valida para la asistencia
        	const resultPeticionNotificacionAlumnos = await fetch(URL, CONFIG);
        	const resultNotificacionAlumnos = await resultPeticionNotificacionAlumnos.json();
        	// console.log(resultNotificacionAlumnos);
        	if (resultNotificacionAlumnos.estado) {
        		mostrarMensajeAlertaNotificacionAlumno(resultNotificacionAlumnos.mensaje, 'success');
        	}else{
        		mostrarMensajeAlertaNotificacionAlumno(resultNotificacionAlumnos.mensaje, 'error');
        	}

        } catch (e) {
        	console.log(e);
        }

    };


    const obtenerDatosFormularios = ()=>{

    	$('#mensajesNotificaionesAlumnos').empty();

		// Obtener valores del campo textarea y select
		const idCicloLectivoNotificacionesAlumnos = $("#cicloLectivoNotificacionesAllumnos option:selected").val();
		const idCursosNotificacionesAlumnos = $("#cursosNotificaionesAlumnos option:selected").val();
		const descripcionMensajeNotificacionAlumnos = $("#descripcionMensajeNotificacionAlumnos").val();

		if (idCicloLectivoNotificacionesAlumnos == '0' || 
			idCursosNotificacionesAlumnos == '0' || 
			descripcionMensajeNotificacionAlumnos == ''){
			$('#mensajesNotificaionesAlumnos').append(`
				<h3 class="text-dark">
				<b>
				Debe seleccionar una division y proporcionar un mensaje, por favor verifique!
				</b>
				</h3>`); 
		return false;
	}


	const datosParamentrosNotificacionesAlumnos = {
		idCicloLectivoNotificacionesAlumnos,
		idCursosNotificacionesAlumnos,
		descripcionMensajeNotificacionAlumnos
	};

	return datosParamentrosNotificacionesAlumnos;

};



const mostrarMensajeAlertaNotificacionAlumno = (alertTitulo, alertInfo)=>{
	Swal.fire({
		title: `${alertTitulo}`,
		icon: `${alertInfo}`,
		confirmButtonColor: '#3085d6',
		confirmButtonText: `OK`
	}).then((result) => {

		$('#enviarNotificacionAlumnos').attr("disabled", false);
		$('#imagenEsperaNotificacionAlumnos').remove();
	})

};


});