<?php 

function obtenerTrayectos(){

        $descripcionTrayectos = array();  // creo un array que va a almacenar la informacion de los curso

        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql_calendario = "SELECT * FROM trayectos"; // busca todos los curso

        $statement = $conexion->prepare($sql_calendario);

        $statement->execute();
        
        if (!$statement){
            // no se encontraron paises
        }else{
            // reviso el retorno

            while($resultado = $statement->fetch(PDO::FETCH_ASSOC)){
                $descripcionTrayectos[] = $resultado;
            }
        }
        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);
        return $descripcionTrayectos;
    }

    function obtenerTrayectosCursoDia($arg_id_curso){

        $resulta_trayecto_curso_dia = array();

        $horaHoyLike = "%".TRIM(date("H"))."%";

        $fechaHoy = date('Y-m-d');

        $i = strtotime($fechaHoy);

        $dia_curso_horario_materia = jddayofweek(cal_to_jd(CAL_GREGORIAN, date("m",$i),date("d",$i), date("Y",$i)) , 0 );


        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        try {


            $sql_obtener_trayecto_curso_dia = "
            SELECT 

                CASE

                WHEN c1.chora_hastamodulo1 LIKE :arghora THEN c1.rela_trayecto_id
                WHEN c1.chora_hastamodulo2 LIKE :arghora THEN c1.rela_trayecto_id
                WHEN c1.chora_hastamodulo3 LIKE :arghora THEN c1.rela_trayecto_id
                WHEN c1.chora_hastamodulo4 LIKE :arghora THEN c1.rela_trayecto_id
                WHEN c1.chora_hastamodulo5 LIKE :arghora THEN c1.rela_trayecto_id
                WHEN c1.chora_hastamodulo6 LIKE :arghora THEN c1.rela_trayecto_id
                WHEN c1.chora_hastamodulo7 LIKE :arghora THEN c1.rela_trayecto_id
                
                ELSE NULL
                
                END AS 'idTrayecto'

            FROM cursos_horarios_materias c1, cursos_horarios c2 WHERE c1.rela_cursohorarios_id = c2.cursoshorarios_id AND c2.rela_curso_id = :argrela_curso_id AND c1.ndia_cursohorariomateria = :argndia_cursohorariomateria";

            $statement = $conexion->prepare($sql_obtener_trayecto_curso_dia);

        $statement->bindParam(':argrela_curso_id' , $arg_id_curso);  // reemplazo los parametros enlazados 
        $statement->bindParam(':argndia_cursohorariomateria' , $dia_curso_horario_materia);  // reemplazo los parametros enlazados 
        $statement->bindParam(':arghora' , $horaHoyLike);  // reemplazo los parametros enlazados 

        if (!$statement->execute()) {
            return array('estado' => false,'mensaje' => $statement->errorInfo());
        }

    } catch (PDOException $e) {
        return array('estado' => false,'mensaje' => "Mensaje de la excepción: ".$e->getMessage()."<br>");
    }
        // cierro la conexion
    while($resultado = $statement->fetch(PDO::FETCH_ASSOC)){
        $resulta_trayecto_curso_dia[]= $resultado;
    }
    $statement = $db->cerrar_conexion($conexion);

    return array('estado' => true,'mensaje' => $resulta_trayecto_curso_dia);

}