<?php 


function armar_tabla_cambio_institucion_alumnos($arg_result_division_alumnos){
	

	// Cabecera tabla cambio de institucion alumnos
 $tabla_cambio_institucion_alumnos = "

 <div id='tablaCambioInstitucionAlumnos' class='form-group'>

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

  $tabla_cambio_institucion_alumnos.= "<tr>
  <td class='text-center'>".$division_alumnos['capellidos_persona']."</td>
  <td class='text-center'>".$division_alumnos['cnombres_persona']."</td>
  <td class='text-center'>".$division_alumnos['ndni_persona']."</td>
  <td class='text-center'>".$division_alumnos['dfechanac_persona']."</td>
  <td class='text-center'>".$division_alumnos['cdescripcion_estadoalumno']."</td>
  ";
    		// Seccion checkbox
  $tabla_cambio_institucion_alumnos .= "<td class='text-center'><input type='checkbox' class='form-check-input' id='checkCambioInstitucionAlumno' value=".$division_alumnos['alumno_id']."></td>";


}
$tabla_cambio_institucion_alumnos .= "</tbody></table><br>";

// textarea
$tabla_cambio_institucion_alumnos .= "
<label for='descCambioInstitucionAlumnos'>Descripcion del motivo del cambio</label>
<textarea class='form-control' id='descCambioInstitucionAlumnos' rows='3'></textarea>
";


$tabla_cambio_institucion_alumnos .= "
<div class='form-group'>
<label for='archivoCambioInstitucionAlumnos'>Elija documento de pase</label>
<input type='file' class='form-control' name='archivoCambioInstitucionAlumnos' id='archivoCambioInstitucionAlumnos'>
</div>
";

$tabla_cambio_institucion_alumnos .= "<input type='button' name='btnCambioInstitucionAlumnosGuardar' id='btnCambioInstitucionAlumnosGuardar' class='float-right btn btn-success' value='Dar de baja a seleccionados'>";

$tabla_cambio_institucion_alumnos .= "
<br>
<div class='form-group'>
<div id='errorGuardadoCambioInstitucionAlumnos'></div>
</div>
";

$tabla_cambio_institucion_alumnos .= "</div>";

return $tabla_cambio_institucion_alumnos;

}

// Funcion para subir el archivo al servidor
function guardar_documento_cambio_institucion_alumno($arg_archivo_cambio_institucion_alumno){

// Recibo los datos de la imagen
  $nombre_img = "imagen_".date("dmYHis") .".". pathinfo($arg_archivo_cambio_institucion_alumno['name'],PATHINFO_EXTENSION);
  $tipo = $arg_archivo_cambio_institucion_alumno['type'];
  $tamano = $arg_archivo_cambio_institucion_alumno['size'];

    //Si existe imagen y tiene un tamaño correcto
  if ($nombre_img == !NULL && $arg_archivo_cambio_institucion_alumno['size'] <= 500000){
   //indicamos los formatos que permitimos subir a nuestro servidor
    if (($arg_archivo_cambio_institucion_alumno["type"] == "image/pdf")
      || ($arg_archivo_cambio_institucion_alumno["type"] == "image/jpeg")
      || ($arg_archivo_cambio_institucion_alumno["type"] == "image/jpg")
      || ($arg_archivo_cambio_institucion_alumno["type"] == "image/png")){
      // Ruta donde se guardarán las imágenes que subamos
      $directorio = '../../storage/documentos/cambioinstitucionalumnos/';
      // Muevo la imagen desde el directorio temporal a nuestra ruta indicada anteriormente
    $result_subida = move_uploaded_file($arg_archivo_cambio_institucion_alumno['tmp_name'],$directorio.$nombre_img);

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