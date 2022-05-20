<?php 

function verificar_horarios_docentes($arg_id_docente){

  $result_horarios_docentes = array();

  $db = new ConexionDB;
  $conexion = $db->retornar_conexion();

  try {

    $sql_modificar_registro_justificacion_alumno = '
    SELECT md.docente_id,md.curso_id,md.materia_id,md.ndia_cursohorariomateria,

    (CASE WHEN md.ndia_cursohorariomateria = 1 THEN "LUNES"
    WHEN md.ndia_cursohorariomateria  = 2 THEN "MARTES"
    WHEN md.ndia_cursohorariomateria  = 3 THEN "MIERCOLES"  
    WHEN md.ndia_cursohorariomateria  = 4 THEN "JUEVES"  
    WHEN md.ndia_cursohorariomateria  = 5 THEN "VIERNES"  
    ELSE "FIN DE SEMANA" END) AS cdia ,

    md.horario,cursos.cdescripcion_curso,materias.cnombre_materia

    FROM (

    (SELECT rela_docente_id1 AS docente_id, rela_curso_id AS curso_id,
    rela_materia_id_modulo1 AS materia_id,ndia_cursohorariomateria,
    concat(chora_desdemodulo1," a ",chora_hastamodulo1) AS horario FROM cursos_horarios_materias
    WHERE rela_docente_id1 = :argrela_docente_id)

    UNION ALL

    (SELECT rela_docente_id2 AS docente_id, rela_curso_id AS curso_id,
    rela_materia_id_modulo2 AS materia_id,ndia_cursohorariomateria,
    concat(chora_desdemodulo2," a ",chora_hastamodulo2) AS horario FROM cursos_horarios_materias
    WHERE rela_docente_id2 = :argrela_docente_id)

    UNION ALL

    (SELECT rela_docente_id3 AS docente_id, rela_curso_id AS curso_id,
    rela_materia_id_modulo3 AS materia_id, ndia_cursohorariomateria,
    concat(chora_desdemodulo3," a ",chora_hastamodulo3) AS horario FROM cursos_horarios_materias
    WHERE rela_docente_id3 = :argrela_docente_id)

    UNION ALL

    (SELECT rela_docente_id4 AS docente_id, rela_curso_id AS curso_id,
    rela_materia_id_modulo4 AS materia_id, ndia_cursohorariomateria,
    concat(chora_desdemodulo4," a ",chora_hastamodulo4) AS horario FROM cursos_horarios_materias
    WHERE rela_docente_id4 = :argrela_docente_id)

    UNION ALL

    (SELECT rela_docente_id5 AS docente_id, rela_curso_id AS curso_id,
    rela_materia_id_modulo5 AS materia_id, ndia_cursohorariomateria,
    concat(chora_desdemodulo5," a ",chora_hastamodulo5) AS horario FROM cursos_horarios_materias
    WHERE rela_docente_id5 = :argrela_docente_id)

    UNION ALL

    (SELECT rela_docente_id6 AS docente_id, rela_curso_id AS curso_id,
    rela_materia_id_modulo6 AS materia_id,ndia_cursohorariomateria,
    concat(chora_desdemodulo6," a ",chora_hastamodulo6) AS horario FROM cursos_horarios_materias
    WHERE rela_docente_id6 = :argrela_docente_id)

    UNION ALL

    (SELECT rela_docente_id7 AS docente_id, rela_curso_id AS curso_id,
    rela_materia_id_modulo7 AS materia_id,ndia_cursohorariomateria,
    concat(chora_desdemodulo7," a ",chora_hastamodulo7) AS horario FROM cursos_horarios_materias
    WHERE rela_docente_id7 = :argrela_docente_id)


    ) AS md

    LEFT JOIN cursos ON cursos.curso_id = md.curso_id
    LEFT JOIN materias ON materias.materia_id = md.materia_id

    ORDER BY ndia_cursohorariomateria,horario';

    $statement = $conexion->prepare($sql_modificar_registro_justificacion_alumno);

        $statement->bindParam(':argrela_docente_id' , $arg_id_docente);  // reemplazo los parametros enlazados 

        if (!$statement->execute()) {
          return array('estado' => false,'mensaje' => $statement->errorInfo());
        }

        while($resultado = $statement->fetch(PDO::FETCH_ASSOC)){
          $result_horarios_docentes[] = $resultado;
        }

      } catch (PDOException $e) {
        return array('estado' => false,'mensaje' => "Mensaje de la excepción: ".$e->getMessage()."<br>");
      }
        // cierro la conexion
      $statement = $db->cerrar_conexion($conexion);

      return array('estado' => true,'mensaje' => $result_horarios_docentes);

    }


    function armar_tabla_verificar_horarios_docentes($arg_result_docentes_horarios){

      $fecha_actual = date('Y-m-d');
      $i = strtotime($fecha_actual);

      $dia_hoy = jddayofweek(cal_to_jd(CAL_GREGORIAN, date("m",$i),date("d",$i), date("Y",$i)) , 0 );

      $tabla_verificar_horarios_docentes = "<div class='table-responsive'>
      <h4>Fecha: <b>".$fecha_actual."</b></h4>
      <table id='' class='table table-stripped table-bordered nowrap cellspacing=' width='100%'>

      <thead class='thead-dark'>
      <tr>

      <th class='text-center'>Dia</th>
      <th class='text-center'>Horario</th>
      <th class='text-center'>Curso</th>
      <th class='text-center'>Materia</th>

      </tr>
      </thead>

      <tbody>";


      foreach ($arg_result_docentes_horarios as $row_horario) {
        
        $claseFila = ($dia_hoy == $row_horario['ndia_cursohorariomateria']) ? 'bg-success' : '';

          $tabla_verificar_horarios_docentes .= "<tr class='".$claseFila."'>
          <td class='text-center'>
          ".$row_horario['cdia']."
          </td>
          <td class='text-center'>
          ".$row_horario['horario']."
          </td>
          <td class='text-center'>
          ".$row_horario['cdescripcion_curso']."
          </td>
          <td class='text-center'>
          ".$row_horario['cnombre_materia']."
          </td>
          </tr>";
        }



      $tabla_verificar_horarios_docentes .= "</tbody></table>";

      return $tabla_verificar_horarios_docentes;
    }