<?php 


function verificarHorariosCursos($argIdCurso, $argIdTrayecto){


	$resultadoHorariosCursos = array();  // creo un array que va a almacenar la informacion de horarios de un curso

	$db = new ConexionDB;
	$conexion = $db->retornar_conexion();

        $sql_horarios_cursos = "SELECT * FROM cursos_horarios WHERE rela_curso_id = :argrela_curso_id AND rela_trayecto_id = :argrela_trayecto_id AND bhorario_activo = 1"; // busca una fecha del calendario

        $statement = $conexion->prepare($sql_horarios_cursos);

        $statement->bindParam(':argrela_curso_id' , $argIdCurso);  // reemplazo los parametros enlazados 
        $statement->bindParam(':argrela_trayecto_id' , $argIdTrayecto);  // reemplazo los parametros enlazados 

        $statement->execute();
        
        if (!$statement){
            // no se encontraron paises
        }else{
            // reviso el retorno

        	while($resultado = $statement->fetch(PDO::FETCH_ASSOC)){
        		$resultadoHorariosCursos = $resultado;
        	}
        }
        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);
        return $resultadoHorariosCursos;

    }