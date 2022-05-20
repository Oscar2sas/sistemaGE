<?php 
function armar_Tabla_Justificacion_Alumnos($arg_resultado_inasistencias_justificacion_alumnos){

	$tabla_justificacion_alumnos = "

	<div id='tablaJustificacionAlumnos'>
	<table id='table' class='table table-stripped table-bordered nowrap cellspacing=' width='100%'>

	<thead class='thead-dark'>
	<tr>
	<th class='text-center'>Apellido</th>
	<th class='text-center'>Nombre</th>
	<th class='text-center'>Dni</th>
	<th class='text-center'>Fecha Nacimiento</th>
	<th class='text-center'>Fecha Inasistencia</th>
	<th class='text-center'>J[x]</th>
	</tr>
	</thead>

	<tbody>";

	foreach ($arg_resultado_inasistencias_justificacion_alumnos as $key => $inasistencia_alumno) {
		$tabla_justificacion_alumnos.= "<tr>
		<td class='text-center'>".$inasistencia_alumno['capellidos_persona']."</td>
		<td class='text-center'>".$inasistencia_alumno['cnombres_persona']."</td>
		<td class='text-center'>".$inasistencia_alumno['ndni_persona']."</td>
		<td class='text-center'>".$inasistencia_alumno['dfechanac_persona']."</td>
		<td class='text-center'>".$inasistencia_alumno['dfecha_inasistencia']."</td>";
    		// Seccion checkbox
		if ($inasistencia_alumno['binasistencia_justificada'] > 0) {
			$tabla_justificacion_alumnos.= "<td class='text-center'><input type='checkbox' class='form-check-input' checked id='checkInasistenciaJustificacion' value=".$inasistencia_alumno['dfecha_inasistencia']."></td>";
		}else{
			$tabla_justificacion_alumnos.= "<td class='text-center'><input type='checkbox' class='form-check-input' id='checkInasistenciaJustificacion' value=".$inasistencia_alumno['dfecha_inasistencia']."></td>";

		}
	}

	$tabla_justificacion_alumnos .= "</tbody></table><br>";
	$tabla_justificacion_alumnos .= "
	<div class='form-group'>
	<label for='archivoJustificacionAlumnos'>Seleccione Archivo Justificacion</label>
	<input type='file' class='form-control' name='archivoJustificacionAlumnos' id='archivoJustificacionAlumnos'>
	</div>";
	$tabla_justificacion_alumnos .= "<input type='button' name='guardarJustificacionAlumno' id='guardarJustificacionAlumno' class='float-right btn btn-success' value='Guardar Justificaciòn'>";

	$tabla_justificacion_alumnos .= "</div>";
	return $tabla_justificacion_alumnos;

}


function armar_lista_curso_alumnos($arg_resultado_busqueda_division__alumnos){
	
	$lista_curso_alumnos ="<div id='resultadoListaBusquedaCursoAlumno' class='form-group'>
	<label for='busquedaCursoAlumnos'>Seleccione a un alumno</label>
	<select class='form-control' id='busquedaCursoAlumnos'>";

	$lista_curso_alumnos .= "<option selected disabled value='0'>Elija un Alumno:</option>";
	foreach ($arg_resultado_busqueda_division__alumnos as $key => $curso_alumnos) {

		$lista_curso_alumnos .= "<option value=".$curso_alumnos['alumno_id'].">".$curso_alumnos['capellidos_persona']." ".$curso_alumnos['cnombres_persona']."</option>";	
	}

	$lista_curso_alumnos .= "</select>
	</div>";
	

	return $lista_curso_alumnos;

}


function guardar_documento_justificacion_alumno($arg_archivo_justificacion_alumno){

// Recibo los datos de la imagen
	$nombre_img = "imagen_".date("dmYHis") .".". pathinfo($arg_archivo_justificacion_alumno['name'],PATHINFO_EXTENSION);
	$tipo = $arg_archivo_justificacion_alumno['type'];
	$tamano = $arg_archivo_justificacion_alumno['size'];

//Si existe imagen y tiene un tamaño correcto
	if ($nombre_img == !NULL && $arg_archivo_justificacion_alumno['size'] <= 500000){
   //indicamos los formatos que permitimos subir a nuestro servidor
		if (($arg_archivo_justificacion_alumno["type"] == "image/pdf")
			|| ($arg_archivo_justificacion_alumno["type"] == "image/jpeg")
			|| ($arg_archivo_justificacion_alumno["type"] == "image/jpg")
			|| ($arg_archivo_justificacion_alumno["type"] == "image/png")){
      // Ruta donde se guardarán las imágenes que subamos
			$directorio = '../../storage/documentos/justificacion/';
      // Muevo la imagen desde el directorio temporal a nuestra ruta indicada anteriormente
		$result_subida = move_uploaded_file($arg_archivo_justificacion_alumno['tmp_name'],$directorio.$nombre_img);

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

function modificar_registro_justificacion_alumno($arg_id_ciclo_lectivo, $arg_id_trayecto, $arg_id_alumno, $fecha_justificacion, $arg_id_justificacion, $arg_tipo_inasistencia){
	
	//============================================================================================
	//Guardo la justificacion del alumno
	//============================================================================================

	$db = new ConexionDB;
	$conexion = $db->retornar_conexion();


	try {

		$sql_modificar_registro_justificacion_alumno = "UPDATE divisiones_inasistencias SET binasistencia_justificada = :argbinasistencia_justificada, rela_documentos_personas_id = :argrela_documentos_personas_id WHERE dfecha_inasistencia = :argdfecha_inasistencia AND rela_anolectivo_id = :argrela_anolectivo_id AND rela_trayecto_id = :argrela_trayecto_id AND rela_alumno_id = :rela_alumno_id"; // modifica el registro de la inasistencia

		$statement = $conexion->prepare($sql_modificar_registro_justificacion_alumno);

        $statement->bindParam(':argbinasistencia_justificada' , $arg_tipo_inasistencia);  // reemplazo los parametros enlazados 
        $statement->bindParam(':argrela_documentos_personas_id' , $arg_id_justificacion);  // reemplazo los parametros enlazados 
        $statement->bindParam(':argdfecha_inasistencia' , $fecha_justificacion);  // reemplazo los parametros enlazados 
        $statement->bindParam(':argrela_anolectivo_id' , $arg_id_ciclo_lectivo);  // reemplazo los parametros enlazados 

		$statement->bindParam(':argrela_trayecto_id' , $arg_id_trayecto);  // reemplazo los parametros enlazados 

        $statement->bindParam(':rela_alumno_id' , $arg_id_alumno);  // reemplazo los parametros enlazados 

        if (!$statement->execute()) {
        	return array('estado' => false,'mensaje' => $statement->errorInfo());
        }

    } catch (PDOException $e) {
    	return array('estado' => false,'mensaje' => "Mensaje de la excepción: ".$e->getMessage()."<br>");
    }
        // cierro la conexion
    $statement = $db->cerrar_conexion($conexion);

    return array('estado' => true,'mensaje' => 'Modificaciones realizadas con exito!');
}


function eliminar_documento_justificacion_alumno($arg_id_documento){
	
	//============================================================================================
	//Elimino la justificacion del alumno
	//============================================================================================

	$db = new ConexionDB;
	$conexion = $db->retornar_conexion();

	try {

		$sql_eliminar_registro_justificacion_alumno = "DELETE FROM documentos_personas WHERE documento_id = :argdocumento_id"; // modifica el registro de la inasistencia

		$statement = $conexion->prepare($sql_eliminar_registro_justificacion_alumno);

        $statement->bindParam(':argdocumento_id' , $arg_id_documento);  // reemplazo los parametros enlazados 
        
        if (!$statement->execute()) {
        	return array('estado' => false,'mensaje' => $statement->errorInfo());
        }

    } catch (PDOException $e) {
    	return array('estado' => false,'mensaje' => "Mensaje de la excepción: ".$e->getMessage()."<br>");
    }
        // cierro la conexion
    $statement = $db->cerrar_conexion($conexion);

    return array('estado' => true,'mensaje' => 'Eliminacion de justificacion realizadas con exito!');
}


function buscar_inasistencia_justificada_alumnos($arg_id_ciclo_lectivo, $arg_id_trayecto, $arg_id_alumno, $fecha_justificacion){
	
	//============================================================================================
	//Obtengo la justificacion del alumno
	//============================================================================================

	$resultado_justificaciones_alumnos = array();

	$db = new ConexionDB;
	$conexion = $db->retornar_conexion();

	try {


		$sql_obtener_justificaciones_alumnos = "SELECT * FROM documentos_personas d1 , divisiones_inasistencias d2 WHERE d1.documento_id = d2.rela_documentos_personas_id AND d2.dfecha_inasistencia = :argdfecha_inasistencia AND d2.binasistencia_justificada = 1 AND d2.rela_anolectivo_id = :argrela_anolectivo_id AND d2.rela_trayecto_id = :argrela_trayecto_id AND d2.rela_alumno_id = :rela_alumno_id"; // modifica el registro de la inasistencia

		$statement = $conexion->prepare($sql_obtener_justificaciones_alumnos);

        $statement->bindParam(':argdfecha_inasistencia' , $fecha_justificacion);  // reemplazo los parametros enlazados 
        $statement->bindParam(':argrela_anolectivo_id' , $arg_id_ciclo_lectivo);  // reemplazo los parametros enlazados 

		$statement->bindParam(':argrela_trayecto_id' , $arg_id_trayecto);  // reemplazo los parametros enlazados 

        $statement->bindParam(':rela_alumno_id' , $arg_id_alumno);  // reemplazo los parametros enlazados 

        if (!$statement->execute()) {
        	return array('estado' => false,'mensaje' => $statement->errorInfo());
        }

    } catch (PDOException $e) {
    	return array('estado' => false,'mensaje' => "Mensaje de la excepción: ".$e->getMessage()."<br>");
    }
        // cierro la conexion
    while($resultado = $statement->fetch(PDO::FETCH_ASSOC)){
    	$resultado_justificaciones_alumnos[]= $resultado;
    }
    $statement = $db->cerrar_conexion($conexion);

    return array('estado' => true,'mensaje' => $resultado_justificaciones_alumnos);
}
