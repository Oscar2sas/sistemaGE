<?php 

// Funcion para obtener las materias
function obtener_materias(){

        $resultMaterias = array();  // creo un array que va a almacenar la informacion de los anos lectivos

        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql_materias = "SELECT * FROM materias"; // busca a todos los profesores

        $statement = $conexion->prepare($sql_materias);

        $statement->execute();
        
        if (!$statement){
            // no se encontraron paises
        }else{
            // reviso el retorno

            while($resultado = $statement->fetch(PDO::FETCH_ASSOC)){
                $resultMaterias[] = $resultado;
            }
        }
        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);
        return $resultMaterias;

    }

    function buscar_materias_docentes($argFechaAsistencia, $argIdCursos, $argIdTrayectos){

        $diafechaAsistenciaAlumnosDocentes = strtotime($argFechaAsistencia);

        $dia_fechaAsistenciaAlumnosDocentes = jddayofweek(cal_to_jd(CAL_GREGORIAN, date("m",$diafechaAsistenciaAlumnosDocentes),date("d",$diafechaAsistenciaAlumnosDocentes), date("Y",$diafechaAsistenciaAlumnosDocentes)) , 0 );

        $resultadoMateriasAsistenciaAlumnosDocentes = array();

        $id_docente = 1;
        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();
        try {
            $sql_horarios_cursos = "
            SELECT DISTINCT 

            md.materia_id, materias.cnombre_materia

            FROM (

            (SELECT rela_curso_id AS curso_id,
            rela_materia_id_modulo1 AS materia_id, ndia_cursohorariomateria, rela_trayecto_id AS trayecto_id, bhorario_activo AS horario_activo FROM cursos_horarios_materias
            WHERE rela_docente_id1 = :argrela_docente_id)

            UNION ALL

            (SELECT rela_curso_id AS curso_id,
            rela_materia_id_modulo2 AS materia_id, ndia_cursohorariomateria, rela_trayecto_id AS trayecto_id, bhorario_activo AS horario_activo FROM cursos_horarios_materias
            WHERE rela_docente_id2 = :argrela_docente_id)

            UNION ALL

            (SELECT rela_curso_id AS curso_id,
            rela_materia_id_modulo3 AS materia_id, ndia_cursohorariomateria, rela_trayecto_id AS trayecto_id, bhorario_activo AS horario_activo FROM cursos_horarios_materias
            WHERE rela_docente_id3 = :argrela_docente_id)

            UNION ALL

            (SELECT rela_curso_id AS curso_id,
            rela_materia_id_modulo4 AS materia_id, ndia_cursohorariomateria, rela_trayecto_id AS trayecto_id, bhorario_activo AS horario_activo FROM cursos_horarios_materias
            WHERE rela_docente_id4 = :argrela_docente_id)

            UNION ALL

            (SELECT rela_curso_id AS curso_id,
            rela_materia_id_modulo5 AS materia_id, ndia_cursohorariomateria, rela_trayecto_id AS trayecto_id, bhorario_activo AS horario_activo FROM cursos_horarios_materias
            WHERE rela_docente_id5 = :argrela_docente_id)

            UNION ALL

            (SELECT rela_curso_id AS curso_id,
            rela_materia_id_modulo6 AS materia_id, ndia_cursohorariomateria, rela_trayecto_id AS trayecto_id, bhorario_activo AS horario_activo FROM cursos_horarios_materias
            WHERE rela_docente_id6 = :argrela_docente_id)

            UNION ALL

            (SELECT rela_curso_id AS curso_id,
            rela_materia_id_modulo7 AS materia_id, ndia_cursohorariomateria, rela_trayecto_id AS trayecto_id, bhorario_activo AS horario_activo FROM cursos_horarios_materias
            WHERE rela_docente_id7 = :argrela_docente_id)


            ) AS md


            LEFT JOIN materias ON materias.materia_id = md.materia_id

            WHERE md.ndia_cursohorariomateria = :argndia_cursohorariomateria AND md.trayecto_id = :argrela_trayecto_id AND md.curso_id = :argrela_curso_id AND md.horario_activo = 1";

            $statement = $conexion->prepare($sql_horarios_cursos);

        $statement->bindParam(':argrela_curso_id' , $argIdCursos);  // reemplazo los parametros enlazados 
        $statement->bindParam(':argrela_trayecto_id' , $argIdTrayectos);  // reemplazo los parametros enlazados 
        $statement->bindParam(':argndia_cursohorariomateria' , $dia_fechaAsistenciaAlumnosDocentes);  // reemplazo los parametros enlazados 
        $statement->bindParam(':argrela_docente_id' , $id_docente);  // reemplazo los parametros enlazados 

        if (!$statement->execute()) {
          return array('estado' => false,'mensaje' => $statement->errorInfo());
      }

      while($resultado = $statement->fetch(PDO::FETCH_ASSOC)){
          $resultadoMateriasAsistenciaAlumnosDocentes[] = $resultado;
      }

  } catch (PDOException $e) {
    return array('estado' => false,'mensaje' => "Mensaje de la excepción: ".$e->getMessage()."<br>");
}
        // cierro la conexion
$statement = $db->cerrar_conexion($conexion);

return array('estado' => true,'mensaje' => $resultadoMateriasAsistenciaAlumnosDocentes);

}