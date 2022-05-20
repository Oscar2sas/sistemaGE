$(document).ready(function() {

	
	$("#dniAlumno").keydown(function(event) {

        // Desactivamos cualquier combinación con shift
        if(event.shiftKey)
        	event.preventDefault();

        /*  
            No permite ingresar pulsaciones a menos que sean los siguientes
            KeyCode Permitidos
            keycode 8 Retroceso
            keycode 37 Flecha Derecha
            keycode 39  Flecha Izquierda
            keycode 46 Suprimir
            */
        //No permite mas de 8 caracteres Numéricos
        if (event.keyCode != 46 && event.keyCode != 8 && event.keyCode != 37 && event.keyCode != 39 && event.keyCode != 13) 
        	if($(this).val().length >= 8)
        		event.preventDefault();

        // Solo Numeros del 0 a 9 
        if (event.keyCode < 48 || event.keyCode > 57)
            //Solo Teclado Numerico 0 a 9
        if (event.keyCode < 96 || event.keyCode > 105)
                /*  
                    No permite ingresar pulsaciones a menos que sean los siguietes
                    KeyCode Permitidos
                    keycode 8 Retroceso
                    keycode 37 Flecha Derecha
                    keycode 39  Flecha Izquierda
                    keycode 46 Suprimir
                    */
                    if(event.keyCode != 46 && event.keyCode != 8 && event.keyCode != 37 && event.keyCode != 39 && event.keyCode != 13)
                    	event.preventDefault();


                });


	$('#btnConsultarAsistenciasAlumnos').click(function(e) {
		e.preventDefault();
		
		if($("#dniAlumno").val().length != 8) {  
			
			$("#dniAlumno").focus();
			
			Swal.fire({
				title: `El dni ingresado debe contener 8 digitos, por favor verifique!`,
				icon: `error`,
				confirmButtonColor: '#3085d6',
				confirmButtonText: `OK`
			})
			return;
		}   


		$('#formConsultarInasistenciaAlumnos').submit();
	});

});