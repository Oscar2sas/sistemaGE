$(document).ready(function() {
	
	localStorage.clear();

	$('#cicloLectivoHistoriaAlumnos').change(function(){

		buscarCursoHistorialAlumnos();
	});

	$('#cursosHistorialAlumno').change(function(){

		buscarCursoHistorialAlumnos();
	});

	$('#trayectosHistorialAlumno').change(function(){

		buscarCursoHistorialAlumnos();
		
	});

	// FUNCION PARA BUSCAR EL CURSO SEGUN LOS PARAMETROS RECIBIDOS

	const buscarCursoHistorialAlumnos = ()=>{

		// Obtener valores de los inputs y selects
		const idCicloLectivoHistoriaAlumnos = $("#cicloLectivoHistoriaAlumnos option:selected").val();
		const idCursosHistorialAlumno = $("#cursosHistorialAlumno option:selected").val();
		const idTrayectosHistorialAlumno = $("#trayectosHistorialAlumno option:selected").val();

		if (idCursosHistorialAlumno == '0' || idTrayectosHistorialAlumno == '0'){ return;}


		const datosParamentrosHistorialAlumnos = {
			idCicloLectivoHistoriaAlumnos,
			idCursosHistorialAlumno,
			idTrayectosHistorialAlumno
		};

		// Funcion para buscar la division correspondiente

		obtenerDivisionAlumnos(datosParamentrosHistorialAlumnos);


	};
	//FUNCION PARA OBTENER A LOS ALUMNOS DE LA DIVISION 
	const obtenerDivisionAlumnos = async(datosParamentrosHistorialAlumnos)=>{

		$('#errorHistorialAlumnos').empty();
		$('#tablaHistorialAlumnos').remove();
		$('#descripcionHistorialAlumno').remove();

		// Creacion del objeto form que guardara todos los datos para el envio
		const data = new FormData();

		// Se guarda los datos para la busqueda de la division
		// y se le especifica el metodo para el controlador
		data.append('accion', 'obtener_division_alumnos');

		data.append('datosDivisionAlumnos', JSON.stringify(datosParamentrosHistorialAlumnos));
		
		// Especifico hacia que controlador quiero enviar mi peticion
		const URL = 'sistema/controladores/historialalumnos/controller.historialalumnos.php';
        // Especifico la configuracion de mi peticion y tambien los datos a enviar
        const CONFIG = {
        	method: 'POST',
        	body: data
        };

         // Realizo la peticion

         try {
        	// Seccion verificar si la fecha es valida para la asistencia
        	const resultPeticionDivisionAlumnos = await fetch(URL, CONFIG);
        	const resultDivisionAlumnos = await resultPeticionDivisionAlumnos.json();
        	// console.log(resultDivisionAlumnos)

        	if (resultDivisionAlumnos == 'no_existe_division') {
        		$('#errorHistorialAlumnos').append(`
        			<h3 class="text-dark">
        			<b>
        			No existe la divisiòn elegida, por favor verifique!
        			</b>
        			</h3>`);
        		return false;
        	}

        	$('#contenedorFormHistorialAlumnos').append(resultDivisionAlumnos);
        	// Inicializacion de datatable

        	if ($.fn.DataTable.isDataTable('#table')) {
        		$('#table').DataTable().destroy();

        		$('#errorHistorialAlumnos').empty();
        		$('#tablaHistorialAlumnos').remove();
        	}
        	$('#table').DataTable(window.configDatatables);

        } catch (e) {
        	console.log(e);
        }
    };
    $("#contenedorFormHistorialAlumnos").on("click", "#detalleHistorialAlumnos", function(){ 

        // console.log($(this).val());
        const idArgAlumno = $(this).val();
        localStorage.setItem('idAlumno',idArgAlumno);
        obtener_historial_alumno(idArgAlumno);
        
    });

	// FUNCION PARA OBTENER EL HISTORIAL DEL ALUMNO
	const obtener_historial_alumno = async(idArgAlumno)=>{

		$('#descripcionHistorialAlumno').remove();
		$('#errorHistorialAlumnos').empty();

		const fechaInicioHistorialAlumnos = $('#fechaInicioHistorialAlumnos').val();
		const fechaFinHistorialAlumnos = $('#fechaFinHistorialAlumnos').val();

		if (!validarCamposFechaHistorialAlumno(fechaInicioHistorialAlumnos)) {
			$('#contenedorFormHistorialAlumnos').append(`
				<div class='form-group' id='descripcionHistorialAlumno'>
				<h3 class="text-dark">
				<b>
				Verifique la fecha de Inicio!
				</b>
				</h3>
				</div>`);
			return false;
		}

		if (!validarCamposFechaHistorialAlumno(fechaFinHistorialAlumnos)){
			$('#contenedorFormHistorialAlumnos').append(`
				<div class='form-group overflow-auto' id='descripcionHistorialAlumno'>
				<h3 class="text-dark">
				<b>
				Verifique la fecha de Fin!
				</b>
				</h3>
				</div>`);
			return false;
		}

		const datosBusquedaHistorialAlumnos = {
			fechaInicioHistorialAlumnos,
			fechaFinHistorialAlumnos,
			idArgAlumno
		}

	 	// Creacion del objeto form que guardara todos los datos para el envio
	 	const data = new FormData();

		// Se guarda los datos para la busqueda del historial del alumno
		// y se le especifica el metodo para el controlador
		data.append('accion', 'obtener_historial_alumnos');

		data.append('datosHistorialAlumno', JSON.stringify(datosBusquedaHistorialAlumnos));

		// Especifico hacia que controlador quiero enviar mi peticion
		const URL = 'sistema/controladores/historialalumnos/controller.historialalumnos.php';
	    // Especifico la configuracion de mi peticion y tambien los datos a enviar
	    const CONFIG = {
	    	method: 'POST',
	    	body: data
	    };

	     // Realizo la peticion

	     try {
        	// Seccion verificar si la fecha es valida para la asistencia
        	const resultPeticionHistorialAlumnos = await fetch(URL, CONFIG);
        	const resultHistorialAlumnos = await resultPeticionHistorialAlumnos.json();

        	$('#contenedorFormHistorialAlumnos').append(`
        		<div class='overflow-auto' id='descripcionHistorialAlumno'>
        		<h3 class="text-dark">
        		<b>
        		${resultHistorialAlumnos}
        		</b>
        		</h3>
        		</div>`);
        	return false;

        } catch (e) {
        	console.log(e);
        }
    };



// FUNCION PARA VALIDAR LA FECHA DE LOS CAMPOS
const validarCamposFechaHistorialAlumno = (valorFecha)=> {
	const regEx = /^\d{4}-\d{2}-\d{2}$/;

	  if(!valorFecha.match(regEx)) return false;  // Invalid format
	  
	  const fechaCampo = new Date(valorFecha);
	  
	  if(Number.isNaN(fechaCampo.getTime())) return false; // Invalid date
	  
	  return fechaCampo.toISOString().slice(0,10) === valorFecha;
	};

// FUNCION PARA IMPRIMIR

$("#contenedorFormHistorialAlumnos").on("click", "#exportarHistorialAlumnos", function(){ 
	// $('#descripcionHistorialAlumno').remove();
	$('#errorHistorialAlumnos').empty();

	const fechaInicioHistorialAlumnos = $('#fechaInicioHistorialAlumnos').val();
	const fechaFinHistorialAlumnos = $('#fechaFinHistorialAlumnos').val();
	const idAlumno = localStorage.getItem('idAlumno');
	if (!idAlumno) {
		$('#contenedorFormHistorialAlumnos').append(`
			<div class='form-group' id='descripcionHistorialAlumno'>
			<h3 class="text-dark">
			<b>
			Debe seleccionar primero el historial de un alumno!
			</b>
			</h3>
			</div>`);

		return false;
	}

	if (!validarCamposFechaHistorialAlumno(fechaInicioHistorialAlumnos)) {
		$('#contenedorFormHistorialAlumnos').append(`
			<div class='form-group' id='descripcionHistorialAlumno'>
			<h3 class="text-dark">
			<b>
			Verifique la fecha de Inicio!
			</b>
			</h3>
			</div>`);

		return false;
	}

	if (!validarCamposFechaHistorialAlumno(fechaFinHistorialAlumnos)){
		$('#contenedorFormHistorialAlumnos').append(`
			<div class='form-group overflow-auto' id='descripcionHistorialAlumno'>
			<h3 class="text-dark">
			<b>
			Verifique la fecha de Fin!
			</b>
			</h3>
			</div>`);
		
		return false;
	}
		$('#descripcionHistorialAlumno').remove();

	const datosBusquedaHistorialAlumnos = {
		fechaInicioHistorialAlumnos,
		fechaFinHistorialAlumnos,
		idAlumno
	};

	const caracteristicasVentanaHistorialAlumnos = "height=700,width=800,scrollTo,resizable=1,scrollbars=1,location=0";
	window.open(`sistema/controladores/historialalumnos/controller.historialalumnos.php?accion=imprimir_historial_alumnos&parametros_historial_alumno=${JSON.stringify(datosBusquedaHistorialAlumnos)}`, 'Popup', caracteristicasVentanaHistorialAlumnos);
	return false;

});

});