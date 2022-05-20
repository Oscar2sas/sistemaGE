$(document).ready(function() {

    buscarCursoHistorialReportesListadosAlumnos();

    $('#cicloLectivoListadosReportesAlumnos').change(function(){

      buscarCursoHistorialReportesListadosAlumnos();
  });

});

// FUNCIONES

const buscarCursoHistorialReportesListadosAlumnos = ()=>{

		// Obtener valores de los inputs y selects
		const idCicloLectivoListadosReportesAlumnos = $("#cicloLectivoListadosReportesAlumnos option:selected").val();

		if (idCicloLectivoListadosReportesAlumnos == '0'){ return;}

		const datosParamentrosReportesListadosAlumnos = {
			idCicloLectivoListadosReportesAlumnos
		};

		obtenerDivisionReportesListadosAlumnos(datosParamentrosReportesListadosAlumnos);
	};


	const obtenerDivisionReportesListadosAlumnos = async(argDatosParamentrosReportesListadosAlumnos)=>{

		// console.log(argDatosParamentrosReportesListadosAlumnos);

		$('#errorReportesListadosAlumnos').empty();
		$('#tablaReportesListadosAlumnos').remove();
		// Creacion del objeto form que guardara todos los datos para el envio
		const data = new FormData();

		// Se guarda los datos para la busqueda de la division
		// y se le especifica el metodo para el controlador
		data.append('accion', 'obtener_curso_division_alumnos');

		data.append('datosDivisionAlumnos', JSON.stringify(argDatosParamentrosReportesListadosAlumnos));
		
		// Especifico hacia que controlador quiero enviar mi peticion
		const URL = 'sistema/controladores/reporteslistadosalumnos/controller.reporteslistadosalumnos.php';
        // Especifico la configuracion de mi peticion y tambien los datos a enviar
        const CONFIG = {
        	method: 'POST',
        	body: data
        };

         // Realizo la peticion

         try {
        	// Seccion verificar si la fecha es valida para la asistencia
        	const resultPeticionDivisionReportesListadosAlumnos = await fetch(URL, CONFIG);
        	const resultDivisionReportesListadosAlumnos = await resultPeticionDivisionReportesListadosAlumnos.json();
        	// console.log(resultDivisionReportesListadosAlumnos)

        	if (!resultDivisionReportesListadosAlumnos.estado) {
        		$('#errorReportesListadosAlumnos').append(`
        			<h3 class="text-dark">
        			<b>
        			${resultDivisionReportesListadosAlumnos.mensaje}
        			</b>
        			</h3>`);
        		return false;
        	}

        	$('#contenedorFormReportesListadosAlumnos').append(resultDivisionReportesListadosAlumnos.mensaje);
        	// Inicializacion de datatable

        	if ($.fn.DataTable.isDataTable('#table')) {
        		$('#table').DataTable().destroy();

        		$('#errorReportesListadosAlumnos').empty();
        		$('#tablaReportesListadosAlumnos').remove();
        	}
        	$('#table').DataTable(window.configDatatables);

        } catch (e) {
        	// console.log(e);
        }
    };

    $("#contenedorFormReportesListadosAlumnos").on("click", "#exportarReportesListadosAlumnos", function(){ 
    	let idEstadosReportesListadosAlumnos = [];
    	const anoLectivo = $('#cicloLectivoListadosReportesAlumnos option:selected').html();

    	$(".text-center").parent("tr").find("td").each(function() {


    		if ($(this).attr("id") != undefined) {
    			idEstadosReportesListadosAlumnos.push($(this).attr("id"));
    		}

    	});

    	idEstadosReportesListadosAlumnos =  [...new Set(idEstadosReportesListadosAlumnos)];

    	// console.log(idEstadosReportesListadosAlumnos);

    	const caracteristicasVentanaReporteListadoAlumnos = "height=700,width=800,scrollTo,resizable=1,scrollbars=1,location=0";
    	window.open(`sistema/controladores/reporteslistadosalumnos/controller.reporteslistadosalumnos.php?accion=imprimir_reporte_listado_alumnos&parametros_reporte_listado_alumno=${JSON.stringify(idEstadosReportesListadosAlumnos)}&ano_lectivo=${JSON.stringify(anoLectivo)}`, 'Popup', caracteristicasVentanaReporteListadoAlumnos);
    	return false;
    });
