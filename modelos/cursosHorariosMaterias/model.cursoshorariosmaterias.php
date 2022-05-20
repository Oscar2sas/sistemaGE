<?php 

function buscar_horarios_materias($argFechaAsistencia, $argIdCursos, $argIdTrayectos){
	
	$diafechaAsistencia = strtotime($argFechaAsistencia);

	$dia_cursohorariomateria = jddayofweek(cal_to_jd(CAL_GREGORIAN, date("m",$diafechaAsistencia),date("d",$diafechaAsistencia), date("Y",$diafechaAsistencia)) , 0 );

	$resultadoHorariosCursosMaterias = array();  // creo un array que va a almacenar la informacion de horarios de un curso

	$db = new ConexionDB;
	$conexion = $db->retornar_conexion();

	$sql_horarios_cursos = "

	SELECT c1.cdescripcion_cursohorario, c2.*, p1.preceptor_id, p1.nsituacion_preceptor, p2.capellidos_persona, p2.cnombres_persona 

	FROM cursos_horarios c1, cursos_horarios_materias c2, preceptores p1, personas p2 

        WHERE c1.cursoshorarios_id = c2.rela_cursohorarios_id AND c1.rela_curso_id = :argrela_curso_id AND c1.rela_trayecto_id = :argrela_trayecto_id AND c1.rela_preceptor_id = p1.preceptor_id AND p1.rela_persona_id = p2.persona_id AND c2.ndia_cursohorariomateria = :ndia_cursohorariomateria AND c1.bhorario_activo = 1 AND c2.bhorario_activo = 1"; // busca una fecha del calendario

        $statement = $conexion->prepare($sql_horarios_cursos);

        $statement->bindParam(':argrela_curso_id' , $argIdCursos);  // reemplazo los parametros enlazados 
        $statement->bindParam(':argrela_trayecto_id' , $argIdTrayectos);  // reemplazo los parametros enlazados 
        $statement->bindParam(':ndia_cursohorariomateria' , $dia_cursohorariomateria);  // reemplazo los parametros enlazados 

        $statement->execute();
        
        if (!$statement){
            // no se encontraron paises
        }else{
            // reviso el retorno

        	while($resultado = $statement->fetch(PDO::FETCH_ASSOC)){
        		$resultadoHorariosCursosMaterias = $resultado;
        	}
        }
        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);
        return $resultadoHorariosCursosMaterias;

    }

