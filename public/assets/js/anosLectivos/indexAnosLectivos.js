$(document).ready(function() {

    // Constarnte global donde se guarda la accion del formulario
    const accionFormulario = $('input[name=accion]').val();
    // Constante global donde se guarda el valor del ano lectivo, si es que esta en formulario de modificar en caso contrario
    // No almacena ningun valor
    const valorModificarAnoLectivo = $('#descripcionAnoLectivo').length > 0 ? $('#descripcionAnoLectivo').val() : '';

    // ====================================================================================
    // Funcion para la validacion del campo de descripcion de la interfaz de nuevo ano lectivo
    // Y de la interfaz de modificar ano lectivo
    // ====================================================================================

    $('#descripcionAnoLectivo').click('click', function(e){
        $(this).focus();
    });
    // Funcion que captura el evento blur del input donde se ingresa y se muestra
    // La descripcion del ano lectivo en ambos formularios
    $('#descripcionAnoLectivo').on('blur', function(e) {

        // Se previene el comportamiento por defecto del input
        e.preventDefault();
        // Se vacian los contenedores donde se muestran los mensajes
        $("#advertenciaDescripcionAnoLectivo").empty();
        // $("#advertenciaFechaInicioAnoLectivo").empty();
        // $("#advertenciaFechaFinClases").empty();
        // $("#advertenciasFinAnoLectivo").empty();
        // $("#advertenciasEstadoAnoLectivo").empty();

        // Se guarda el dato ingresado del input
        const descripcionAnoLectivo = $(this).val();

        // Se realiza una validacion en donde el
        // El campo no tiene que estar vacio,
        // Tiene que ser un dato mayor a 3 digitos
        // Y menor a 5
        if (descripcionAnoLectivo != '' && descripcionAnoLectivo.length > 3 && descripcionAnoLectivo.length < 5) {
            // Creacion del objeto form que guardara todos los datos para el envio
            const data = new FormData();
            // Se guarda la descripcion del nuevo año lectivo ingresado por el usuario
            // y se le especifica el metodo para el controlador
            data.append('accion', 'verificar_ano_lectivo');
            // console.log(descripcionAnoLectivo)
            data.append('descAnoLectivo', descripcionAnoLectivo);

            // Se llama a la funcion y se le pasa el formulario con los datos
            // En caso de que resuelva conrrectamente la promesa se ejectura el then
            // Caso contra se ejecutara el catch
            verificarAnoLectivo(data)
                .then((data) => {
                    // Si veririca la accion del formulario
                    // Accion insertar en la BD
                    if (accionFormulario === 'insertar') {
                        // Se desabilitara el boton de guardar
                        // Si el resultado de peticion de diferente a false se añadira una clase red al input
                        // Se colocara el focus
                        // Y se añadira un mensaje en el div
                        if (data != false) {
                            $("input[type='submit']").prop('disabled', true);
                            $(this).addClass("red");
                            $(this).focus();
                            $("#advertenciaDescripcionAnoLectivo").append("<small class='text-dark'><b>LA DESCRIPCIÒN INGRESADA YA EXISTE EN LA BASE DE DATOS VERIFIQUE!</b></small>");
                            return;
                        } else {
                            // Caso contrario
                            // Se habilitara el boton
                            // Se removera la clase
                            // Y se limpiara los div
                            $("input[type='submit']").prop('disabled', false);
                            $(this).removeClass("red");
                            $("#advertenciaDescripcionAnoLectivo").empty();
                            return;
                        }
                    } else {
                        // Accion modificar registro en la bd
                        // Si la descripcion ingresada es igual al de modificar, no se realizara ninguna accion
                        if (data.ndescripcion_anolectivo === valorModificarAnoLectivo) {
                            // console.log('valido')
                            $(this).removeClass("red");

                        } else if (data == false) {
                             // Si la descripcion ingresada es diferente a la de modificar y no esta guardado en la BD,
                             // no se realizara ninguna accion
                            // console.log('valido')
                            $(this).removeClass("red");

                        } else {
                            // Si la descripcion ingresada ya tiene un registro en la bd se procedera a
                             // desabilitar el boton, añadir una clase roja al input, añadir el focus y mostrar un mensaje en el div
                            $("input[type='submit']").prop('disabled', true);
                            $(this).addClass("red");
                            $(this).focus();
                            $("#advertenciaDescripcionAnoLectivo").append("<small class='text-dark'><b>LA DESCRIPCIÒN INGRESADA YA EXISTE EN LA BASE DE DATOS VERIFIQUE!</b></small>");
                            return;
                        }
                    }

                })
                .catch((e) => {
                    // Caso de que ocurra algun error en la peticion se mostrara por consolta
                    console.log(e);
                })
        } else {
            // En caso de que no se cumpla la primer condicion
            // Se desabilitara el boton, se añadira una clase roja, se añadira el focus y se mostrara un mensaje por pantalla
            $("input[type='submit']").prop('disabled', true);
            $(this).addClass("red");
            $(this).focus();
            $("#advertenciaDescripcionAnoLectivo").append("<small class='text-dark'><b>LA DESCRIPCIÒN INGRESADA ES INVALIDA VERIFIQUE!</b></small>");

        }
    });


    // ====================================================================================
    // Funcion para validar campo de fecha de inicio de año lectivo
    // ====================================================================================

    $('#fechaInicio').on('blur', function(e) {
        e.preventDefault();
        $("#advertenciaFechaInicioAnoLectivo").empty();
        const fechaInicio = $(this).val();
        const fechaFinClases = $('#fechaFinClases') ? $('#fechaFinClases').val() : null;
        // console.log(result)
        if (fechaInicio != '') {
            const result = verificarFechaAnoLectivo(fechaInicio);

            if (result.valido === 'no' && result.fechaMayor == 'si') {
                $("input[type='submit']").prop('disabled', true);
                $(this).addClass("red");
                $("#advertenciaFechaInicioAnoLectivo").append("<small class='text-dark'><b>LA FECHA INGRESADA ES MAYOR A LA DESCRIPCIÒN VERIFIQUE!</b></small>");
                $('#descripcionAnoLectivo').focus();
                return;
            } else if (result.valido === 'no' && result.fechaMayor == 'no') {
                $("input[type='submit']").prop('disabled', true);
                $(this).addClass("red");
                $("#advertenciaFechaInicioAnoLectivo").append("<small class='text-dark'><b>LA FECHA INGRESADA ES MENOR A LA DESCRIPCIÒN VERIFIQUE!</b></small>");
                $('#descripcionAnoLectivo').focus();
                return;
            } else if (fechaInicio >= fechaFinClases && fechaFinClases != '') {
                $("input[type='submit']").prop('disabled', true);
                $(this).addClass("red");
                $("#advertenciaFechaInicioAnoLectivo").append("<small class='text-dark'><b>LA FECHA INGRESADA ES MAYOR O IGUAL A LA FECHA DE FIN DE CLASES VERIFIQUE!</b></small>");
                // $(this).focus();
                $('#fechaFinClases').focus();
                return;
            } else {
                $("input[type='submit']").prop('disabled', false);
                $(this).removeClass("red");
                $("#fechaFinClases").empty();
                $("#advertenciaFechaFinClases").empty();
                $("#advertenciaFechaInicioAnoLectivo").empty();
                return;
            }
        }

    });

    // ====================================================================================
    // Funcion para validar campo de fecha fin de clases de ano lectivo
    // ====================================================================================

    $('#fechaFinClases').on('blur', function(e) {
        e.preventDefault();
        $("#advertenciaFechaFinClases").empty();
        const fechaFinClases = $(this).val();
        const fechaInicio = $('#fechaInicio') ? $('#fechaInicio').val() : null;

        // console.log(fechaFinClases);

        if (fechaFinClases != '') {
            const result = verificarFechaAnoLectivo(fechaFinClases);

            if (result.valido === 'no' && result.fechaMayor == 'si') {
                $("input[type='submit']").prop('disabled', true);
                $(this).addClass("red");
                $("#advertenciaFechaFinClases").append("<small class='text-dark'><b>LA FECHA INGRESADA ES MAYOR A LA DESCRIPCIÒN VERIFIQUE!</b></small>");
                $(this).focus();
                return;
            } else if (result.valido === 'no' && result.fechaMayor == 'no') {
                $("input[type='submit']").prop('disabled', true);
                $(this).addClass("red");
                $("#advertenciaFechaFinClases").append("<small class='text-dark'><b>LA FECHA INGRESADA ES MENOR A LA DESCRIPCIÒN VERIFIQUE!</b></small>");
                $(this).focus();
                return;
            } else if (fechaFinClases <= fechaInicio && fechaInicio != '') {
                $("input[type='submit']").prop('disabled', true);
                $(this).addClass("red");
                $("#advertenciaFechaFinClases").append("<small class='text-dark'><b>LA FECHA INGRESADA ES MENOR O IGUAL A LA FECHA DE INICIO DE CLASES, VERIFIQUE!</b></small>");
                $('#fechaInicio').focus();

                return;
            } else {
                $("input[type='submit']").prop('disabled', false);
                $(this).removeClass("red");
                $('#fechaInicio').removeClass("red");
                $("#advertenciaFechaFinClases").empty();
                $("#advertenciaFechaInicioAnoLectivo").empty();

                return;
            }
        }
    });

    $('#fechaFinAnoLectivo').on('blur', function(e) {
        e.preventDefault();
        $("#advertenciasFinAnoLectivo").empty();
        const fechaFinAnoLectivo = $('#fechaFinAnoLectivo') ? $('#fechaFinAnoLectivo').val() : null;

        if (fechaFinAnoLectivo != '') {
            const result = verificarFechaAnoLectivo(fechaFinAnoLectivo, true);
            if (result.valido === 'no' && result.fechaMayor == 'si') {
                $("input[type='submit']").prop('disabled', true);
                $(this).addClass("red");
                $("#advertenciasFinAnoLectivo").append("<small class='text-dark'><b>LA FECHA INGRESADA DEBERIA SER SOLO 1 AÑO MAYOR A LA DESCRIPCIÒN VERIFIQUE!</b></small>");
                $(this).focus();
                return;
            } else if (result.valido === 'no' && result.fechaMayor == 'no') {
                $("input[type='submit']").prop('disabled', true);
                $(this).addClass("red");
                $("#advertenciasFinAnoLectivo").append("<small class='text-dark'><b>LA FECHA INGRESADA DEBERIA SER 1 AÑO MAYOR A LA DESCRIPCIÒN VERIFIQUE!</b></small>");
                $(this).focus();
                return;
            } else {
                $("input[type='submit']").prop('disabled', false);
                $(this).removeClass("red");
                $("#advertenciasFinAnoLectivo").empty();

                return;
            }
        }
    });

    // ====================================================================================
    // Funcion para validar si un ano lectivo esta: Activo o Inactivo
    const idEstadoAnoLectivoOriginal = $('#estadoAnoLectivo').val();
    $('#estadoAnoLectivo').on('change', function(e){
        // console.log('desde el select');
        e.preventDefault();
        $("#advertenciasEstadoAnoLectivo").empty();
        $("input[type='submit']").prop('disabled', false);
        $(this).removeClass("red");
        
        const idEstadoAnoLectivo = $(this).val();
        // Creacion del objeto form que guardara todos los datos para el envio
        const data = new FormData();
        // Se guarda el id del estado del año lectivo
        // y se le especifica el metodo para el controlador
        data.append('accion', 'verificar_estado_ano_lectivo');
        data.append('idEstadoAnoLectivo', idEstadoAnoLectivo);

            // Se llama a la funcion y se le pasa el formulario con los datos
            // En caso de que resuelva conrrectamente la promesa se ejectura el then
            // Caso contra se ejecutara el catch
            if(idEstadoAnoLectivo != '0' && idEstadoAnoLectivo != idEstadoAnoLectivoOriginal){
                verificarAnoLectivo(data)
                    .then((data)=>{
                        if(data){
                            $("input[type='submit']").prop('disabled', true);
                            $(this).addClass("red");
                            $("#advertenciasEstadoAnoLectivo").append(`<small class='text-dark'><b>PARA CAMBIAR EL ESTADO DEL AÑO LECTIVO DEBE CAMBIAR EL ESTADO DEL ANO LECTIVO: ${ data.ndescripcion_anolectivo} VERIFIQUE!</b></small>`);
                        }
                    })
            }
    });

    // ====================================================================================

    // ====================================================================================
    // Funcion para validar las fechas del ano lectivo
    // ====================================================================================
    const verificarFechaAnoLectivo = (argFecha, argFechaFinAño = false) => {

        let fechaDescripcionAnoLectivo = $('#descripcionAnoLectivo').val().split("-")[0];

        if (argFechaFinAño == false) {
            const fechaArgAnoLectivo = argFecha.split("-")[0];

            if (fechaArgAnoLectivo > fechaDescripcionAnoLectivo) {
                return {
                    'valido': 'no',
                    'fechaMayor': 'si'
                }
            } else if (fechaArgAnoLectivo < fechaDescripcionAnoLectivo) {
                return {
                    'valido': 'no',
                    'fechaMayor': 'no'
                }
            } else {
                return {
                    'valido': 'si'
                }
            }
        } else {
            // console.log(argFecha);
            let fechaFinAnoLectivo = argFecha.split("-")[0];

            let fechaFinAnoLectivoValida = parseInt(fechaDescripcionAnoLectivo);

            fechaFinAnoLectivoValida = fechaFinAnoLectivoValida + 1;

            if (fechaFinAnoLectivo == fechaFinAnoLectivoValida) {
                return {
                    'valido': 'si'
                }
            } else if (fechaFinAnoLectivo >= fechaFinAnoLectivoValida) {
                return {
                    'valido': 'no',
                    'fechaMayor': 'si'
                }
            } else {
                return {
                    'valido': 'no',
                    'fechaMayor': 'no'
                }
            }

        }

    }

    // ====================================================================================
    // Funcion para verificar descripcion de ano lectivo y estado
    // ====================================================================================
    const verificarAnoLectivo = async(data) => {
        // Especifico hacia que controlador quiero enviar mi peticion
        const URL = 'sistema/controladores/anoLectivos/controller.anolectivos.php';
        // Especifico la configuracion de mi peticion y tambien los datos a enviar
        const CONFIG = {
            method: 'POST',
            body: data
        };

        // Realizo la peticion

        try {
            const resultPeticion = await fetch(URL, CONFIG);
            const resultTexto = await resultPeticion.json();
            // console.log(resultTexto)
            return resultTexto;
        } catch (e) {
            console.log(e);
        }
    }
});