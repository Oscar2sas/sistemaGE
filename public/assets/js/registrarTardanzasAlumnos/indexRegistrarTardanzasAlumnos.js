$(document).ready(function() {


    $("#dniRegistrarTardanzaAlumno").keypress(function(e) {

        const code = (e.keyCode ? e.keyCode : e.which);
        if(code==13){
            obtenerDatosFormularioRegistrarTardanzasAlumnos();
        }
    });

    $('#btnRegistrarTardanzasAlumnos').click(function(e) {

      e.preventDefault();

      obtenerDatosFormularioRegistrarTardanzasAlumnos();

  });



    const obtenerDatosFormularioRegistrarTardanzasAlumnos = ()=>{

      const dniRegistrarTardanzaAlumno = $("#dniRegistrarTardanzaAlumno").val();

      if(dniRegistrarTardanzaAlumno.length != 8) {  

         $("#dniRegistrarTardanzaAlumno").focus();

         Swal.fire({
            title: `El dni ingresado debe contener 8 digitos, por favor verifique!`,
            icon: `error`,
            confirmButtonColor: '#3085d6',
            confirmButtonText: `OK`
        })
         return;
     } 

     guardarDatosFormularioRegistrarTardanzasAlumnos(dniRegistrarTardanzaAlumno);
 };


 const guardarDatosFormularioRegistrarTardanzasAlumnos = async(argDniRegistrarTardanzaAlumno)=>{

		// console.log(argDniRegistrarTardanzaAlumno);

    	// Creacion del objeto form que guardara todos los datos para el envio
    	const data = new FormData();

		// Se guarda los datos para el guardado de los datos del formulario
		// y se le especifica el metodo para el controlador
		data.append('accion', 'guardar_registro_tardanzas_alumnos');

		data.append('datosGuardarRegistrarTardanzasAlumnos', JSON.stringify(argDniRegistrarTardanzaAlumno));

		// Especifico hacia que controlador quiero enviar mi peticion
		const URL = 'sistema/controladores/registrartardanzasalumnos/controller.registrartardanzasalumnos.php';
        // Especifico la configuracion de mi peticion y tambien los datos a enviar
        const CONFIG = {
        	method: 'POST',
        	body: data
        };

        // Realizo la peticion

        try {

        	const resultPeticionGuardarRegistrarTardanzasAlumnos = await fetch(URL, CONFIG);
        	const resultGuardadoRegistrarTardanzasAlumnos = await resultPeticionGuardarRegistrarTardanzasAlumnos.json();

        	// console.log(resultGuardadoRegistrarTardanzasAlumnos);

        	if (!resultGuardadoRegistrarTardanzasAlumnos.estado) {

                Swal.fire({
                 title: `${resultGuardadoRegistrarTardanzasAlumnos.mensaje}`,
                 icon: `error`,
                 confirmButtonColor: '#3085d6',
                 confirmButtonText: `OK`
             })

                return;
            }


            Swal.fire({
              title: `${resultGuardadoRegistrarTardanzasAlumnos.mensaje}`,
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

});