$(document).ready(function() {
	
	$('#situacionDelDia').change(function(){

		buscarCurso();
	});

	$('#cicloLectivo').change(function(){

		buscarCurso();
	});

	$('#fechaAsistencia').change(function(){

		buscarCurso();
		
	});

	$('#cursos').change(function(){

		buscarCurso();
	});

	$('#trayectos').change(function(){

		buscarCurso();
	});
	// Obtener id de los check de asistencia

	$("#contenedorForm").on("click", "#guardarInasistencia", function(){ 

        const idSituacionDia = $("#situacionDelDia option:selected").val();
        const idAnoLectivo = $("#cicloLectivo option:selected").val();
        const fechaAsistencia = $('#fechaAsistencia').val();
        const idCursos = $("#cursos option:selected").val();
        const idTrayectos = $("#trayectos option:selected").val();
        const fecha = $('#fechaAsistencia').val();
        const token = $("#token").val();

        if (!verificarFecha(fecha)) {
            return;
        }

        if (idCursos == '0' || idTrayectos == '0'){ return;}


        const datosParamentros = {
            idSituacionDia,
            idAnoLectivo,
            fechaAsistencia,
            idCursos,
            idTrayectos,
            token
        };
        if (idAsistenciasAlumnos == '' && idAlumnosAsistenciaTardanza == '') {
            mostrarMensajeAlerta('Debe Modificar Alguna Asistencia, Verifique');
        }else{
            guardarDatosInasistenciaAlumnos(idAsistenciasAlumnos, datosParamentros, idAlumnosAsistenciaTardanza);
        }
    });


    // ====================================================================================
    // Funcion para guardar los id de los checks modificados
    // ====================================================================================
    let idAsistenciasAlumnos = [];

    $("#contenedorForm").on("change", "#checkInasistencia", function(){ 

        // activar o desactivar checkbox de tardanza y eliminar id del array de tardanzar
        if(!$(this).is(':checked')){ 
          const inputCheck = $(this).closest('tr').find('#checkAsistenciaTardanza'); 
          inputCheck.prop('disabled', true).prop('checked', false);

          idAlumnosAsistenciaTardanza.splice(idAlumnosAsistenciaTardanza.indexOf(inputCheck.val()), 1);
         // console.log(idAlumnosAsistenciaTardanza)
     }else{
      $(this).closest('tr').find('#checkAsistenciaTardanza').prop('disabled', false); 
         // console.log(idAlumnosAsistenciaTardanza)

     } 

        // eliminar id del array de id de alumnos
        if (idAsistenciasAlumnos.includes($(this).val())) { 
            idAsistenciasAlumnos.splice(idAsistenciasAlumnos.indexOf($(this).val()), 1);
        }else{
            idAsistenciasAlumnos.push($(this).val());
            
        }
        
        // console.log(idAsistenciasAlumnos)
    });

    // ====================================================================================
    // Funcion para guardar los id de los checks modificados
    // ====================================================================================
    let idAlumnosAsistenciaTardanza = [];

    $("#contenedorForm").on("change", "#checkAsistenciaTardanza", function(){ 

        if($(this).is(':checked')){ 
          const inputCheckAsistencia = $(this).closest('tr').find('#checkInasistencia'); 
          // inputCheck.prop('disabled', true).prop('checked', false);
          if (!inputCheckAsistencia.is(':checked')) {
              idAlumnosAsistenciaTardanza.splice(idAlumnosAsistenciaTardanza.indexOf(inputCheckAsistencia.val()), 1);
              $(this).prop('disabled', true).prop('checked', false);
              Swal.fire({
                title: `Debe estar marcado el alumno, para poder agregarle la tardanza!`,
                icon: `info`,
                confirmButtonColor: '#3085d6',
                confirmButtonText: `OK`
            })
              return;
          }

            // console.log(idAlumnosAsistenciaTardanza)
        }

        if (idAlumnosAsistenciaTardanza.includes($(this).val())) { 
            idAlumnosAsistenciaTardanza.splice(idAlumnosAsistenciaTardanza.indexOf($(this).val()), 1);
        }else{
            idAlumnosAsistenciaTardanza.push($(this).val());
        }

    // console.log(idAlumnosAsistenciaTardanza);
});    


    // ====================================================================================
    // Funcion para guardar/modificar la asistencia
    // ====================================================================================
    const guardarDatosInasistenciaAlumnos = async(argIdAsistenciasAlumnos, argDatosParamentros, argIdAlumnosAsistenciaTardanza)=>{

        // Creacion del objeto form que guardara todos los datos para el envio
        const data = new FormData();

        // Se guarda los datos para la busqueda del curso ingresado por el usuario
        // y se le especifica el metodo para el controlador
        data.append('accion', 'guardar_asistencias_alumnos');

        data.append('datosIdAlumnosTardanza', JSON.stringify(argIdAlumnosAsistenciaTardanza));
        data.append('datosIdAlumnosAsistencia', JSON.stringify(argIdAsistenciasAlumnos));
        data.append('datosEstadoSituacionDia', JSON.stringify(argDatosParamentros));

        // Especifico hacia que controlador quiero enviar mi peticion
        const URL = 'sistema/controladores/asistenciaalumnos/controller.asistenciaalumnos.php';
        // Especifico la configuracion de mi peticion y tambien los datos a enviar
        const CONFIG = {
            method: 'POST',
            body: data
        };
        // Realizo la peticion

        try {
            // Seccion guardar la asistencia de los alumnos
            const resultPeticionGuardadoAsistenciaAlumnos = await fetch(URL, CONFIG);
            const resultDatosGuardadoAsistenciaAlumnos = await resultPeticionGuardadoAsistenciaAlumnos.json();
            // console.log(resultDatosGuardadoAsistenciaAlumnos)
            mostrarMensajeAlerta(resultDatosGuardadoAsistenciaAlumnos);
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
                buscarCurso();
            }else{
                buscarCurso();
            }
        })

    };

// ====================================================================================
// Funcion para buscar los datos del curso
// ====================================================================================
const buscarCurso = ()=>{

        // reseteo mi arreglo de id de checks
        idAsistenciasAlumnos = [];
        idAlumnosAsistenciaTardanza = [];
		// Obtener valores de los inputs y selects
        const idSituacionDia = $("#situacionDelDia option:selected").val();
        const idAnoLectivo = $("#cicloLectivo option:selected").val();
        const fechaAsistencia = $('#fechaAsistencia').val();
        const idCursos = $("#cursos option:selected").val();
        const idTrayectos = $("#trayectos option:selected").val();
        

        const fecha = $('#fechaAsistencia').val();

        if (!verificarFecha(fecha)) {
           return;
       }

       if (idCursos == '0' || idTrayectos == '0'){ return;}


       const datosParamentros = {
        idSituacionDia,
        idAnoLectivo,
        fechaAsistencia,
        idCursos,
        idTrayectos
    };

		// Funcion para verificar que la fecha este en el horario de un curso para realizar la asistencia
		// Caso contrario no se podra realizar la toma del mismo

		verificarFechaHorariosAsistencias(datosParamentros);


	};

	// ====================================================================================
    // Funcion para verificar los horarios del curso
    // ====================================================================================

    const verificarFechaHorariosAsistencias = async(datosParamentros)=>{
        $('#error').empty();
        $('#tablaAsistenciaAlumnos').remove();

    	// Creacion del objeto form que guardara todos los datos para el envio
    	const data = new FormData();

		// Se guarda los datos para la busqueda del curso ingresado por el usuario
		// y se le especifica el metodo para el controlador
		data.append('accion', 'verificar_horarios_curso');

		data.append('datosHorarios', JSON.stringify(datosParamentros));
		
		// Especifico hacia que controlador quiero enviar mi peticion
		const URL = 'sistema/controladores/asistenciaalumnos/controller.asistenciaalumnos.php';
        // Especifico la configuracion de mi peticion y tambien los datos a enviar
        const CONFIG = {
        	method: 'POST',
        	body: data
        };

        // Realizo la peticion

        try {
        	// Seccion verificar si la fecha es valida para la asistencia
        	const resultPeticionAsistencia = await fetch(URL, CONFIG);
        	const resultVerificacionAsistencia = await resultPeticionAsistencia.json();
        	// console.log(resultVerificacionAsistencia)
        	if (!resultVerificacionAsistencia) {
        		$('#error').append(`
        			<h3 class="text-dark">
        			<b>
        			El curso seleccionado no tiene clases hoy, por favor verifique el trayecto o la fecha!
        			</b>
        			</h3>`);
        		return;
        	}else if(resultVerificacionAsistencia === "Curso no posee aun horarios, verifique!"){
        		$('#error').append(`
        			<h3 class="text-dark">
        			<b>
        			${ resultVerificacionAsistencia }
        			</b>
        			</h3>`);
        		return;
        	}


        	// Seccion para obtener a los alumnos
        	// Reseteo la accion para buscar a los alumnos del curso
        	data.set('accion', 'obtener_alumnos_curso');
        	const resultPeticionAlumnos = await fetch(URL, CONFIG);
        	const resultBusquedaAlumnos = await resultPeticionAlumnos.json();

            // console.log(resultBusquedaAlumnos)
            // if (resultBusquedaAlumnos == 'tomar_asistencia_curso') {
            //     $('#error').append(`
            //         <h3 class="text-dark">
            //         <b>
            //         Debe realizar la <a href="sistemaProfesionalizantes/controladores/asistenciadocente/controller.asistenciadocente.php">asistencia</a> del curso primero, por favor verifique!
            //         </b>
            //         </h3>
            //         `);
            //     return;
            // }
            $('#contenedorForm').append(resultBusquedaAlumnos);
        	// Inicializacion de datatable

            if ($.fn.DataTable.isDataTable('#table')) {
                $('#table').DataTable().destroy();

                $('#error').empty();
                $('#tablaAsistenciaAlumnos').remove();
            }
            $('#table').DataTable(window.configDatatables);

        } catch (e) {
        	console.log(e);
        }
    };


	// ====================================================================================
    // Funcion para validar las fecha de asistencia
    // ====================================================================================
    const verificarFecha = (argFecha) => {

    	$('#error').empty();

    	const fecha = argFecha.split("-")[0];
    	const anoLectivo = $('#cicloLectivo').text().trim();

        // console.log(anoLectivo.)

        if (argFecha == '') {

        	$('#error').append(`
        		<h3 class="text-dark">
        		<b>
        		No puede dejar la fecha de la asistencia vacia, por favor verifique!
        		</b>
        		</h3>`);
        	return false;
        }

        if (fecha != anoLectivo) {

        	$('#error').append(`
        		<h3 class="text-dark">
        		<b>
        		Fecha asistencia no coincide con el año lectivo, por favor verifique!
        		</b>
        		</h3>`);
        	return false;
        }

        return true;
    }
// Funcion para imprimir pdf
$("#contenedorForm").on("click", "#exportarParteDiarioAlumnos", function(){ 
    const idAnoLectivo = $("#cicloLectivo option:selected").val();
    const fechaAsistencia = $('#fechaAsistencia').val();
    const idCursos = $("#cursos option:selected").val();
    const idTrayectos = $("#trayectos option:selected").val();
    const descTrayecto = $("#trayectos option:selected").text();
    const descCurso = $("#cursos option:selected").text();

    const datosParamentrosParteDiario = {
        idAnoLectivo,
        fechaAsistencia,
        idCursos,
        idTrayectos,
        descTrayecto,
        descCurso
    };
    const caracteristicas = "height=700,width=800,scrollTo,resizable=1,scrollbars=1,location=0";
    window.open(`sistemaProfesionalizantes/controladores/asistenciaalumnos/controller.asistenciaalumnos.php?accion=imprimir_parte_diario&parametros_parte_diario=${JSON.stringify(datosParamentrosParteDiario)}`, 'Popup', caracteristicas);
    return false;
});
});


