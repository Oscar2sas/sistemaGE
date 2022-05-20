<?php 


function armar_tabla_movimientos_alumnos($arg_result_division_alumnos, $arg_result_cursos){
	

	// Cabecera tabla asistencia alumnos
 $tabla_movimientos_alumnos = "

 <div id='tablaMovimientosAlumnos' class='form-group'>

 <table id='table' class='table table-stripped table-bordered nowrap cellspacing=' width='100%'>

 <thead class='thead-dark'>
 <tr>
 <th class='text-center'>Apellido</th>
 <th class='text-center'>Nombre</th>
 <th class='text-center'>Dni</th>
 <th class='text-center'>Fecha Nacimiento</th>
 <th class='text-center'>Estado Alumno</th>
 <th class='text-center'>[x]</th>
 </tr>
 </thead>

 <tbody>";

        // CUERPO TABLA

 foreach ($arg_result_division_alumnos as $key => $division_alumnos) {

  $tabla_movimientos_alumnos.= "<tr>
  <td class='text-center'>".$division_alumnos['capellidos_persona']."</td>
  <td class='text-center'>".$division_alumnos['cnombres_persona']."</td>
  <td class='text-center'>".$division_alumnos['ndni_persona']."</td>
  <td class='text-center'>".$division_alumnos['dfechanac_persona']."</td>
  <td class='text-center'>".$division_alumnos['cdescripcion_estadoalumno']."</td>
  ";
    		// Seccion checkbox
  $tabla_movimientos_alumnos .= "<td class='text-center'><input type='checkbox' class='form-check-input' id='checkAlumnoPasaje' value=".$division_alumnos['alumno_id']."></td>";


}
$tabla_movimientos_alumnos .= "</tbody></table><br>";

    	// combo de cursos
$tabla_movimientos_alumnos .= "<br>
<label for='cursoPasajeDivisionSiguiente'>Seleccionar curso destino</label>
<select class='form-control' id='cursoPasajeDivisionSiguiente'>
<option value='0' selected disabled>Seleccione un curso</option>

";


foreach ($arg_result_cursos as $key => $cursos) {

 $tabla_movimientos_alumnos .= "<option value=". $cursos['curso_id']. ">". $cursos['cdescripcion_curso']." </option>";

}
$tabla_movimientos_alumnos .= "</select>
<div id='erroCursoPasaje'></div>
<br>";

$tabla_movimientos_alumnos .= "
<div class='form-group'>
<label for='archivoMovimientosAlumnos'>Elija documento de pase</label>
<input type='file' class='form-control' name='archivoMovimientosAlumnos' id='archivoMovimientosAlumnos'>
</div>
";

$tabla_movimientos_alumnos .= "<input type='button' name='btnMovimientosAlumnosGuardar' id='btnMovimientosAlumnosGuardar' class='float-right btn btn-success' value='Realizar pase de curso a seleccionados'>";

$tabla_movimientos_alumnos .= "</div>";

return $tabla_movimientos_alumnos;

}

// Funcion para subir el archivo al servidor
function guardar_documento_cambio_curso_alumno($arg_archivo_cambio_curso_alumno){

// Recibo los datos de la imagen
    $nombre_img = "imagen_".date("dmYHis") .".". pathinfo($arg_archivo_cambio_curso_alumno['name'],PATHINFO_EXTENSION);
    $tipo = $arg_archivo_cambio_curso_alumno['type'];
    $tamano = $arg_archivo_cambio_curso_alumno['size'];

    //Si existe imagen y tiene un tamaño correcto
    if ($nombre_img == !NULL && $arg_archivo_cambio_curso_alumno['size'] <= 500000){
   //indicamos los formatos que permitimos subir a nuestro servidor
        if (($arg_archivo_cambio_curso_alumno["type"] == "image/pdf")
            || ($arg_archivo_cambio_curso_alumno["type"] == "image/jpeg")
            || ($arg_archivo_cambio_curso_alumno["type"] == "image/jpg")
            || ($arg_archivo_cambio_curso_alumno["type"] == "image/png")){
      // Ruta donde se guardarán las imágenes que subamos
            $directorio = '../../storage/documentos/cambiocurso/';
      // Muevo la imagen desde el directorio temporal a nuestra ruta indicada anteriormente
        $result_subida = move_uploaded_file($arg_archivo_cambio_curso_alumno['tmp_name'],$directorio.$nombre_img);

        if ($result_subida) {
            // si se subio el archivo con exito
            return array('estado' => true,'mensaje' => $directorio.$nombre_img);
        }else{
            // si hubo algun error al subir el archivo
            return array('estado' => false,'mensaje' => 'Error al subir al archivo');
        }
    }else{
       //si no cumple con el formato
        return array('estado' => false,'mensaje' => 'No se puede subir una imagen con ese formato');
    }
}else{
   //si existe la variable pero se pasa del tamaño permitido
    if($nombre_img == !NULL){
        return array('estado' => false,'mensaje' => 'La imagen es demasiado grande');
    }
}

}