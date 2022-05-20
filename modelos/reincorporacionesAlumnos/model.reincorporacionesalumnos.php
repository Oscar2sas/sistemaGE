<?php 

function guardar_documento_reincorporacion_alumno($arg_archivo_reincorporacion_alumno){

// Recibo los datos de la imagen
	$nombre_img = "imagen_".date("dmYHis") .".". pathinfo($arg_archivo_reincorporacion_alumno['name'],PATHINFO_EXTENSION);
	$tipo = $arg_archivo_reincorporacion_alumno['type'];
	$tamano = $arg_archivo_reincorporacion_alumno['size'];

//Si existe imagen y tiene un tamaño correcto
	if ($nombre_img == !NULL && $arg_archivo_reincorporacion_alumno['size'] <= 500000){
   //indicamos los formatos que permitimos subir a nuestro servidor
		if (($arg_archivo_reincorporacion_alumno["type"] == "image/pdf")
			|| ($arg_archivo_reincorporacion_alumno["type"] == "image/jpeg")
			|| ($arg_archivo_reincorporacion_alumno["type"] == "image/jpg")
			|| ($arg_archivo_reincorporacion_alumno["type"] == "image/png")){
      // Ruta donde se guardarán las imágenes que subamos
			$directorio = '../../storage/documentos/reincorporaciones/';
      // Muevo la imagen desde el directorio temporal a nuestra ruta indicada anteriormente
		$result_subida = move_uploaded_file($arg_archivo_reincorporacion_alumno['tmp_name'],$directorio.$nombre_img);

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


function modificar_estado_alumno($arg_id_alumno, $arg_id_estado_alumno, $arg_sit_alumno){
	$db = new ConexionDB;

	$conexion = $db->retornar_conexion();

	try {
			$sql_reincorporacion_alumno = "UPDATE alumnos SET nsituacion_alumno = :argnsituacion_alumno, rela_estadoalumno_id = :argrela_estadoalumno_id WHERE alumno_id = :argalumno_id ";

			$statement = $conexion->prepare($sql_reincorporacion_alumno);

	        $statement->bindParam(':argalumno_id' , $arg_id_alumno);  // reemplazo los parametros enlazados 

			$statement->bindParam(':argrela_estadoalumno_id' , $arg_id_estado_alumno);  // reemplazo los parametros enlazados 
			$statement->bindParam(':argnsituacion_alumno' , $arg_sit_alumno);  // reemplazo los parametros enlazados 
			
			if (!$statement->execute()) {
				return array('estado' => false,'mensaje' => $statement->errorInfo());
			}

			$id_insertado = $conexion->lastInsertId();

		} catch (PDOException $e) {
			return array('estado' => false,'mensaje' => "Mensaje de la excepción: ".$e->getMessage()."<br>");
		}
        // cierro la conexion
		$statement = $db->cerrar_conexion($conexion);

		return array('estado' => true,'mensaje' => 'Alumnos reincorporado correctamente!');

	}