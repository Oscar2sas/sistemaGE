<?php 


function insertar_documento_persona($arg_tip_documento, $arg_id_persona, $nombre_documento_justificacion){
		$db = new ConexionDB;
		
		$conexion = $db->retornar_conexion();

		try {
			$sql_total_inasistencia_alumno = "INSERT INTO documentos_personas(rela_tipodocumento_id, rela_persona_id, cimg_documento) VALUES (:argrela_tipodocumento_id, :rela_persona_id, :argcimg_documento)"; // busca las inasistencias que coincidad con esa fecha

			$statement = $conexion->prepare($sql_total_inasistencia_alumno);

	        $statement->bindParam(':rela_persona_id' , $arg_id_persona);  // reemplazo los parametros enlazados 

			$statement->bindParam(':argcimg_documento' , $nombre_documento_justificacion);  // reemplazo los parametros enlazados 
			
			$statement->bindParam(':argrela_tipodocumento_id' , $arg_tip_documento);  // reemplazo los parametros enlazados 

			if (!$statement->execute()) {
				return array('estado' => false,'mensaje' => $statement->errorInfo());
			}

			$id_insertado = $conexion->lastInsertId();

		} catch (PDOException $e) {
			return array('estado' => false,'mensaje' => "Mensaje de la excepción: ".$e->getMessage()."<br>");
		}
        // cierro la conexion
		$statement = $db->cerrar_conexion($conexion);

		return array('estado' => true,'mensaje' => $id_insertado);

	}