$(function() {
	// Obtengo el valor del ano lectivo activo del input
	const anoLectivoValido = $('#anoLectivoActivo') ? $('#anoLectivoActivo').val() : '' ; 

	// Se guarda la accion del formulario seleccionado
	const accionFormulario = $('input[name=accion]').val();

	// En caso de que el formulario elegido sea modificar
	// Guardo el valor original del input
    const valorModificarFechaCalendario = $('#fechaCalendario').length > 0 ? $('#fechaCalendario').val() : '';

    // Funcion para mostrar mensaje de eliminacion de fecha del calendario
   

    $(document).on('click', '[id=eliminarFechaCalendario]', function(e) {
    	e.preventDefault();

    	const swalWithBootstrapButtons = Swal.mixin({
    		customClass: {
    			confirmButton: 'btn btn-success',
    			cancelButton: 'btn btn-danger'
    		}
    	})

    	swalWithBootstrapButtons.fire({
    		title: 'Fechas del calendario',
    		text: "¿Està seguro de borrar la fecha?",
    		icon: 'warning',
    		showCancelButton: true,
    		confirmButtonText: 'Si!',
    		cancelButtonText: 'No!',
    		reverseButtons: true
    	}).then((result) => {
    		if (result.value) {
    			swalWithBootstrapButtons.fire(
    				'Borrado Exitoso!',
    				'La fecha ha sido borrado correctamente',
    				'success'
    				)
    			$(`#eliminarFecha${ $(this).data('idcalendario')}`).submit();
    		} else if (
    			/* Read more about handling dismissals below */
    			result.dismiss === Swal.DismissReason.cancel
    			) {
    			swalWithBootstrapButtons.fire(
    				'Cancelado',
    				'Ha cancelado la eliminaciòn',
    				'error'
    				)
    		}
    	})


    });

	// ====================================================================================
    // Funcion para la validacion del campo ingresar fecha calendario
    // ====================================================================================


    $('#fechaCalendario').on('blur', function(e) {
    	e.preventDefault();
    	$("#advertenciaFechaCalendario").empty();
    	$(this).removeClass("red");
    	$("input[type='submit']").prop('disabled', false);

    	const fechaCalendario = $(this).val();

    	// Si el valor de la fecha ingresada tiene un ano diferente al activo
    	// Se mostrara un mensaje
    	if (!validarAnoFechaCalendario(fechaCalendario)) {
    		$("input[type='submit']").prop('disabled', true);
    		$(this).addClass("red");
    		$(this).focus();
    		$('#advertenciaFechaCalendario').append("<small class='text-dark'><b>LA FECHA INGRESADA NO CORRESPONDE AL AÑO LECTIVO ACTIVO, VERIFIQUE!</b></small>");
    		return;
    	}

    	// Si el valor de la fecha ingresada es diferente a vacio ejecuto el codigo de verificacion

    	if (fechaCalendario != '') {

				 // Creacion del objeto form que guardara todos los datos para el envio
				 const data = new FormData();

	            // Se guarda la descripcion de la fecha calendario ingresado por el usuario
	            // y se le especifica el metodo para el controlador
	            data.append('accion', 'verificar_fecha_calendario');

	            data.append('descFechaCalendario', fechaCalendario);

	            // Llamo a mi funcion que se encarga de verificar si la fecha ingresada ya esta guardada en ld bd
	            verificarFechaCalendario(data)
	            .then((data)=>{
	            	
	            	// Hago una destructuracion para obtener el valor de la fecha
	            	const {dfecha_calendario} = data;

					// Verifico que tipo de accion tiene el formulario
	            	if (accionFormulario == 'insertar') {
	            		// Si la fecha ingresada es igual a la fecha que se obtuvo de la bd
	            		// Arrojo un mensaje de advertencia
	            		if (fechaCalendario == dfecha_calendario) {
	            			$("input[type='submit']").prop('disabled', true);
	            			$(this).addClass("red");
	            			$(this).focus();
	            			$('#advertenciaFechaCalendario').append("<small class='text-dark'><b>LA FECHA INGRESADA YA ESTA GUARDADA EN LA BASE DE DATOS, VERIFIQUE!</b></small>");
	            		}
	            	}else{ 
	            		// En caso de que la accion del formulario sea diferente 

	            		// Si el valor ingresado es igual a la fecha que a modificar no realizo ninguna accion
	            		if (valorModificarFechaCalendario == fechaCalendario) {
	            			// No hago nada
	            		}else if (dfecha_calendario == fechaCalendario) {
	            			// En caso de que la fecha ingresada sea igual a la fecha que se obtuvo de la bd
	            			// Arrojo una advertencia

							$("input[type='submit']").prop('disabled', true);
	            			$(this).addClass("red");
	            			$(this).focus();
	            			$('#advertenciaFechaCalendario').append("<small class='text-dark'><b>LA FECHA INGRESADA YA ESTA GUARDADA EN LA BASE DE DATOS, VERIFIQUE!</b></small>");
	            			return;
	            		}
	            	}
	            })
	            .catch((e) => {
                    // Caso de que ocurra algun error en la peticion se mostrara por consolta
                    console.log(e);
                })

	        }else{
	        	// En caso de que el formulario este vacio se mostrara una advertencia
	        	$("input[type='submit']").prop('disabled', true);
	        	$(this).addClass("red");
	        	$(this).focus();
	        	$("#advertenciaFechaCalendario").append("<small class='text-dark'><b>LA FECHA INGRESADA ES INVALIDA, VERIFIQUE!</b></small>");
	        	return;
	        }

	    });

	// ====================================================================================
    // Funcion para verificar si la fecha ingresada corresponde al ano lectivo correspondiente
    // ====================================================================================

    const validarAnoFechaCalendario = (argFechaCalendario)=>{
    	let anoFechaCalendario = argFechaCalendario.split("-")[0];

    	if (anoFechaCalendario === anoLectivoValido) {
    		return true;
    	}
    	return false;

    };

	// ====================================================================================
    // Funcion para verificar si la fecha ingresada esta guardada en la base de datos
    // ====================================================================================

    const verificarFechaCalendario = async(data) => {
        // Especifico hacia que controlador quiero enviar mi peticion
        const URL = 'sistema/controladores/calendarios/controller.calendarios.php';
        // Especifico la configuracion de mi peticion y tambien los datos a enviar
        const CONFIG = {
        	method: 'POST',
        	body: data
        };

        // Realizo la peticion

        try {
        	const resultPeticion = await fetch(URL, CONFIG);
        	const resultFechaCalendario = await resultPeticion.json();
            // console.log(resultTexto)
            return resultFechaCalendario;
        } catch (e) {
        	console.log(e);
        }
    }

});
