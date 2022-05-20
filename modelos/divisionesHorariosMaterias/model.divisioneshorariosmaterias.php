<?php 

function buscar_asistencia_division_horarios_materias($fechaAsistencia, $idCursos, $idTrayectos, $idAnoLectivo){


   $db = new ConexionDB;
   $conexion = $db->retornar_conexion();

   $sqlDivisionHorariosMaterias = "SELECT * FROM divisiones_horarios_materias d1, cursos_horarios c1, preceptores p1, personas p2 WHERE d1.dfecha_horario = :argdfecha_horario AND d1.rela_curso_id = :argrela_curso_id AND d1.rela_anolectivo_id = :argrela_anolectivo_id AND d1.rela_trayecto_id = :argrela_trayecto_id AND d1.rela_cursohorario_id = c1.cursoshorarios_id AND d1.rela_preceptor_id = p1.preceptor_id AND p1.rela_persona_id = p2.persona_id";

   try {

        // preparo el sqlDivisionHorariosMaterias para enviar   se puede usar prepare   y bindparam 
    $statement = $conexion->prepare($sqlDivisionHorariosMaterias);

        $statement->bindParam(':argdfecha_horario' , $fechaAsistencia);  // reemplazo los parametros enlazados 

        $statement->bindParam(':argrela_curso_id' , $idCursos);  // reemplazo los parametros enlazados 
        
        $statement->bindParam(':argrela_trayecto_id' , $idTrayectos);  // reemplazo los parametros enlazados 
        
        $statement->bindParam(':argrela_anolectivo_id' , $idAnoLectivo);  // reemplazo los parametros enlazados 
        
        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
        // $coincidencias_Encontradas = $statement->rowCount(); 
        
        // $statement = $db->cerrar_conexion($conexion);

    } catch (PDOException $e) {
        return "Mensaje de la excepción: ".$e->getMessage()."<br>";
    }

}



// Funcion para insertar la asistencia
function insertar_datos_asistencia_curso_horario_materia($argDatosAsistenciaCursoHorarioMateria){
    // return $argDatosAsistenciaCursoHorarioMateria;
    $db = new ConexionDB;
    $conexion = $db->retornar_conexion();

    //Decodifico los datos mandado por JSON 
    $argDatos = json_decode($argDatosAsistenciaCursoHorarioMateria);

    // Obtengo la fecha de hoy pero numeros
    $diafechaAsistencia = strtotime($argDatos->fechaAsistencia);

    $dia_cursohorariomateria = jddayofweek(cal_to_jd(CAL_GREGORIAN, date("m",$diafechaAsistencia),date("d",$diafechaAsistencia), date("Y",$diafechaAsistencia)) , 0 );


    $sql_insertar_asistencia_cursos_horario_materias = "INSERT INTO divisiones_horarios_materias(dfecha_horario, rela_cursohorario_id, rela_anolectivo_id, rela_curso_id, rela_trayecto_id, rela_preceptor_id, ndia_cursohorariomateria, ";

    $sql_insertar_asistencia_cursos_horario_materias .= "
    rela_materia_id_modulo1, rela_docente_id1, nsituacion_docente1, bdocente_presente1, rela_materia_id_modulo2, rela_docente_id2, nsituacion_docente2, bdocente_presente2, rela_materia_id_modulo3, rela_docente_id3, nsituacion_docente3, bdocente_presente3, rela_materia_id_modulo4, rela_docente_id4, nsituacion_docente4, bdocente_presente4, rela_materia_id_modulo5, rela_docente_id5, nsituacion_docente5, bdocente_presente5, rela_materia_id_modulo6, rela_docente_id6, nsituacion_docente6, bdocente_presente6, rela_materia_id_modulo7, rela_docente_id7, nsituacion_docente7, bdocente_presente7, ";

    $sql_insertar_asistencia_cursos_horario_materias .= "chora_desdemodulo1, chora_hastamodulo1, chora_desdemodulo2, chora_hastamodulo2, chora_desdemodulo3, chora_hastamodulo3, chora_desdemodulo4, chora_hastamodulo4, chora_desdemodulo5, chora_hastamodulo5, chora_desdemodulo6, chora_hastamodulo6, chora_desdemodulo7, chora_hastamodulo7, nvalor_inasistencia)";

    $sql_insertar_asistencia_cursos_horario_materias .= "VALUES (:argdfecha_horario, :argrela_cursohorario_id, :argrela_anolectivo_id, :argrela_curso_id, :argrela_trayecto_id, :argrela_preceptor_id, :argndia_cursohorariomateria, :argrela_materia_id_modulo1, :argrela_docente_id1, :argnsituacion_docente1, :argbdocente_presente1, :rela_materia_id_modulo2, :rela_docente_id2, :nsituacion_docente2, :bdocente_presente2, :argrela_materia_id_modulo3, :argrela_docente_id3, :argnsituacion_docente3, :argbdocente_presente3, :argrela_materia_id_modulo4, :argrela_docente_id4, :argnsituacion_docente4, :argbdocente_presente4, :argrela_materia_id_modulo5, :argrela_docente_id5, :argnsituacion_docente5, :argbdocente_presente5, :argrela_materia_id_modulo6, :argrela_docente_id6, :argnsituacion_docente6, :argbdocente_presente6, :argrela_materia_id_modulo7, :argrela_docente_id7, :argnsituacion_docente7, :argbdocente_presente7, :argchora_desdemodulo1, :argchora_hastamodulo1, :argchora_desdemodulo2, :argchora_hastamodulo2, :argchora_desdemodulo3, :argchora_hastamodulo3, :argchora_desdemodulo4, :argchora_hastamodulo4, :argchora_desdemodulo5, :argchora_hastamodulo5, :argchora_desdemodulo6, :argchora_hastamodulo6, :argchora_desdemodulo7, :argchora_hastamodulo7, :argnvalor_inasistencia)";

        // $statement = $db->cerrar_conexion($conexion);

    try {

        // preparo el sql para enviar   se puede usar prepare   y bindparam 
        $statement = $conexion->prepare($sql_insertar_asistencia_cursos_horario_materias);

        $statement->bindParam(':argdfecha_horario' , $argDatos->fechaAsistencia);  // reemplazo los parametros enlazados 

        $statement->bindParam(':argrela_cursohorario_id' , $argDatos->idCursoHorario);  // reemplazo los parametros enlazados 
        
        $statement->bindParam(':argrela_anolectivo_id' , $argDatos->idAnoLectivo);  // reemplazo los parametros enlazados 
        
        $statement->bindParam(':argrela_curso_id' , $argDatos->idCursos);  // reemplazo los parametros enlazados 
        
        $statement->bindParam(':argrela_trayecto_id' , $argDatos->idTrayectos);  // reemplazo los parametros enlazados 
        
        $statement->bindParam(':argrela_preceptor_id' , $argDatos->idPreceptorCursoHorarioMateria);  // reemplazo los parametros enlazados 
        
        $statement->bindParam(':argndia_cursohorariomateria' , $dia_cursohorariomateria);  // reemplazo los parametros enlazados 
        
        // Modulo 1
        $statement->bindParam(':argrela_materia_id_modulo1' , $argDatos->idDocenteMaterias1);  // reemplazo los parametros enlazados 
        $statement->bindParam(':argrela_docente_id1' , $argDatos->idDocenteCursoHorariosMaterias1);  // reemplazo los parametros enlazados 
        $statement->bindParam(':argnsituacion_docente1' , $argDatos->valorDocenteSituacionMateria1);  // reemplazo los parametros enlazados 
        $statement->bindParam(':argbdocente_presente1' , $argDatos->docentePresente1);  // reemplazo los parametros enlazados

        // Modulo 2
        $statement->bindParam(':rela_materia_id_modulo2' , $argDatos->idDocenteMaterias2);  // reemplazo los parametros enlazados 
        $statement->bindParam(':rela_docente_id2' , $argDatos->idDocenteCursoHorariosMaterias2);  // reemplazo los parametros enlazados 
        $statement->bindParam(':nsituacion_docente2' , $argDatos->valorDocenteSituacionMateria2);  // reemplazo los parametros enlazados 
        $statement->bindParam(':bdocente_presente2' , $argDatos->docentePresente2);  // reemplazo los parametros enlazados

        // Modulo 3
        $statement->bindParam(':argrela_materia_id_modulo3' , $argDatos->idDocenteMaterias3);  // reemplazo los parametros enlazados 
        $statement->bindParam(':argrela_docente_id3' , $argDatos->idDocenteCursoHorariosMaterias3);  // reemplazo los parametros enlazados 
        $statement->bindParam(':argnsituacion_docente3' , $argDatos->valorDocenteSituacionMateria3);  // reemplazo los parametros enlazados 
        $statement->bindParam(':argbdocente_presente3' , $argDatos->docentePresente3);  // reemplazo los parametros enlazados

        // Modulo 4
        $statement->bindParam(':argrela_materia_id_modulo4' , $argDatos->idDocenteMaterias4);  // reemplazo los parametros enlazados 
        $statement->bindParam(':argrela_docente_id4' , $argDatos->idDocenteCursoHorariosMaterias4);  // reemplazo los parametros enlazados 
        $statement->bindParam(':argnsituacion_docente4' , $argDatos->valorDocenteSituacionMateria4);  // reemplazo los parametros enlazados 
        $statement->bindParam(':argbdocente_presente4' , $argDatos->docentePresente4);  // reemplazo los parametros enlazados

        // Modulo 5
        $statement->bindParam(':argrela_materia_id_modulo5' , $argDatos->idDocenteMaterias5);  // reemplazo los parametros enlazados 
        $statement->bindParam(':argrela_docente_id5' , $argDatos->idDocenteCursoHorariosMaterias5);  // reemplazo los parametros enlazados 
        $statement->bindParam(':argnsituacion_docente5' , $argDatos->valorDocenteSituacionMateria5);  // reemplazo los parametros enlazados 
        $statement->bindParam(':argbdocente_presente5' , $argDatos->docentePresente5);  // reemplazo los parametros enlazados

        // Modulo 6
        $statement->bindParam(':argrela_materia_id_modulo6' , $argDatos->idDocenteMaterias6);  // reemplazo los parametros enlazados 
        $statement->bindParam(':argrela_docente_id6' , $argDatos->idDocenteCursoHorariosMaterias6);  // reemplazo los parametros enlazados 
        $statement->bindParam(':argnsituacion_docente6' , $argDatos->valorDocenteSituacionMateria6);  // reemplazo los parametros enlazados 
        $statement->bindParam(':argbdocente_presente6' , $argDatos->docentePresente6);  // reemplazo los parametros enlazados

        // Modulo 7
        $statement->bindParam(':argrela_materia_id_modulo7' , $argDatos->idDocenteMaterias7);  // reemplazo los parametros enlazados 
        $statement->bindParam(':argrela_docente_id7' , $argDatos->idDocenteCursoHorariosMaterias7);  // reemplazo los parametros enlazados 
        $statement->bindParam(':argnsituacion_docente7' , $argDatos->valorDocenteSituacionMateria7);  // reemplazo los parametros enlazados 
        $statement->bindParam(':argbdocente_presente7' , $argDatos->docentePresente7);  // reemplazo los parametros enlazados
        
        // horas desde-hasta
        // Modulo 1
        $statement->bindParam(':argchora_desdemodulo1' , $argDatos->valorDesdeModuloCursoHorariosMaterias1);  // reemplazo los parametros enlazados
        $statement->bindParam(':argchora_hastamodulo1' , $argDatos->valorHastaModuloCursoHorariosMaterias1);  // reemplazo los parametros enlazados

        // Modulo 2
        $statement->bindParam(':argchora_desdemodulo2' , $argDatos->valorDesdeModuloCursoHorariosMaterias2);  // reemplazo los parametros enlazados
        $statement->bindParam(':argchora_hastamodulo2' , $argDatos->valorHastaModuloCursoHorariosMaterias2);  // reemplazo los parametros enlazados

     // Modulo 3
        $statement->bindParam(':argchora_desdemodulo3' , $argDatos->valorDesdeModuloCursoHorariosMaterias3);  // reemplazo los parametros enlazados
        $statement->bindParam(':argchora_hastamodulo3' , $argDatos->valorHastaModuloCursoHorariosMaterias3);  // reemplazo los parametros enlazados

     // Modulo 4
        $statement->bindParam(':argchora_desdemodulo4' , $argDatos->valorDesdeModuloCursoHorariosMaterias4);  // reemplazo los parametros enlazados
        $statement->bindParam(':argchora_hastamodulo4' , $argDatos->valorHastaModuloCursoHorariosMaterias4);  // reemplazo los parametros enlazados

     // Modulo 5
        $statement->bindParam(':argchora_desdemodulo5' , $argDatos->valorDesdeModuloCursoHorariosMaterias5);  // reemplazo los parametros enlazados
        $statement->bindParam(':argchora_hastamodulo5' , $argDatos->valorHastaModuloCursoHorariosMaterias5);  // reemplazo los parametros enlazados

     // Modulo 6
        $statement->bindParam(':argchora_desdemodulo6' , $argDatos->valorDesdeModuloCursoHorariosMaterias6);  // reemplazo los parametros enlazados
        $statement->bindParam(':argchora_hastamodulo6' , $argDatos->valorHastaModuloCursoHorariosMaterias6);  // reemplazo los parametros enlazados

     // Modulo 7
        $statement->bindParam(':argchora_desdemodulo7' , $argDatos->valorDesdeModuloCursoHorariosMaterias7);  // reemplazo los parametros enlazados
        $statement->bindParam(':argchora_hastamodulo7' , $argDatos->valorHastaModuloCursoHorariosMaterias7);  // reemplazo los parametros enlazados


        $statement->bindParam(':argnvalor_inasistencia' , $argDatos->valorInasistencia);  // reemplazo los parametros enlazados


        // $statement->execute();
        if (!$statement->execute()) {
            return($statement->errorInfo());
        }
        return true;
    } catch (PDOException $e) {
        echo "Mensaje de la excepción: ".$e->getMessage()."<br>";
        return false;
    }
}

// Funcion para actualizar los datos de la asistencia de los horarios de los docentes
function actualizar_datos_asistencia_curso_horario_materias($argDatosAsistenciaCursoHorarioMateria){

    // return $argDatosAsistenciaCursoHorarioMateria;
    $db = new ConexionDB;
    $conexion = $db->retornar_conexion();

    //Decodifico los datos mandado por JSON 
    $argDatos = json_decode($argDatosAsistenciaCursoHorarioMateria);

    // Obtengo la fecha de hoy pero numeros
    $diafechaAsistencia = strtotime($argDatos->fechaAsistencia);

    $dia_cursohorariomateria = jddayofweek(cal_to_jd(CAL_GREGORIAN, date("m",$diafechaAsistencia),date("d",$diafechaAsistencia), date("Y",$diafechaAsistencia)) , 0 );


    $sql_actualizar_asistencia_cursos_horario_materias = "UPDATE divisiones_horarios_materias SET  dfecha_horario =:argdfecha_horario, rela_cursohorario_id =:argrela_cursohorario_id, rela_anolectivo_id =:argrela_anolectivo_id, rela_curso_id =:argrela_curso_id, rela_trayecto_id =:argrela_trayecto_id, rela_preceptor_id =:argrela_preceptor_id, ndia_cursohorariomateria =:argndia_cursohorariomateria, rela_materia_id_modulo1 =:argrela_materia_id_modulo1, rela_docente_id1 =:argrela_docente_id1, nsituacion_docente1 =:argnsituacion_docente1, bdocente_presente1 =:argbdocente_presente1, rela_materia_id_modulo2 =:rela_materia_id_modulo2, rela_docente_id2 =:rela_docente_id2, nsituacion_docente2 =:nsituacion_docente2, bdocente_presente2 =:bdocente_presente2, rela_materia_id_modulo3 =:argrela_materia_id_modulo3, rela_docente_id3 =:argrela_docente_id3, nsituacion_docente3 =:argnsituacion_docente3, bdocente_presente3 =:argbdocente_presente3, rela_materia_id_modulo4 =:argrela_materia_id_modulo4, rela_docente_id4 =:argrela_docente_id4, nsituacion_docente4 =:argnsituacion_docente4, bdocente_presente4 =:argbdocente_presente4, rela_materia_id_modulo5 =:argrela_materia_id_modulo5, rela_docente_id5 =:argrela_docente_id5, nsituacion_docente5 =:argnsituacion_docente5, bdocente_presente5 =:argbdocente_presente5, rela_materia_id_modulo6 =:argrela_materia_id_modulo6, rela_docente_id6 =:argrela_docente_id6, nsituacion_docente6 =:argnsituacion_docente6, bdocente_presente6 =:argbdocente_presente6, rela_materia_id_modulo7 =:argrela_materia_id_modulo7, rela_docente_id7 =:argrela_docente_id7, nsituacion_docente7 =:argnsituacion_docente7, bdocente_presente7 =:argbdocente_presente7, chora_desdemodulo1 =:argchora_desdemodulo1, chora_hastamodulo1 =:argchora_hastamodulo1, chora_desdemodulo2 =:argchora_desdemodulo2, chora_hastamodulo2 =:argchora_hastamodulo2, chora_desdemodulo3 =:argchora_desdemodulo3, chora_hastamodulo3 =:argchora_hastamodulo3, chora_desdemodulo4 =:argchora_desdemodulo4, chora_hastamodulo4 =:argchora_hastamodulo4, chora_desdemodulo5 =:argchora_desdemodulo5, chora_hastamodulo5 =:argchora_hastamodulo5, chora_desdemodulo6 =:argchora_desdemodulo6, chora_hastamodulo6 =:argchora_hastamodulo6, chora_desdemodulo7 =:argchora_desdemodulo7, chora_hastamodulo7 =:argchora_hastamodulo7, nvalor_inasistencia =:argnvalor_inasistencia WHERE divisionhorario_id  = :argdivisionhorario_id
    ";

    try {

        // preparo el sql para enviar   se puede usar prepare   y bindparam 
        $statement = $conexion->prepare($sql_actualizar_asistencia_cursos_horario_materias);

        $statement->bindParam(':argdfecha_horario' , $argDatos->fechaAsistencia);  // reemplazo los parametros enlazados 


        $statement->bindParam(':argrela_cursohorario_id' , $argDatos->idCursoHorario);  // reemplazo los parametros enlazados 
        
        $statement->bindParam(':argrela_anolectivo_id' , $argDatos->idAnoLectivo);  // reemplazo los parametros enlazados 
        
        $statement->bindParam(':argrela_curso_id' , $argDatos->idCursos);  // reemplazo los parametros enlazados 
        
        $statement->bindParam(':argrela_trayecto_id' , $argDatos->idTrayectos);  // reemplazo los parametros enlazados 
        
        $statement->bindParam(':argrela_preceptor_id' , $argDatos->idPreceptorCursoHorarioMateria);  // reemplazo los parametros enlazados 
        
        $statement->bindParam(':argndia_cursohorariomateria' , $dia_cursohorariomateria);  // reemplazo los parametros enlazados 
        
        // Modulo 1
        $statement->bindParam(':argrela_materia_id_modulo1' , $argDatos->idDocenteMaterias1);  // reemplazo los parametros enlazados 
        $statement->bindParam(':argrela_docente_id1' , $argDatos->idDocenteCursoHorariosMaterias1);  // reemplazo los parametros enlazados 
        $statement->bindParam(':argnsituacion_docente1' , $argDatos->valorDocenteSituacionMateria1);  // reemplazo los parametros enlazados 
        $statement->bindParam(':argbdocente_presente1' , $argDatos->docentePresente1);  // reemplazo los parametros enlazados

        // Modulo 2
        $statement->bindParam(':rela_materia_id_modulo2' , $argDatos->idDocenteMaterias2);  // reemplazo los parametros enlazados 
        $statement->bindParam(':rela_docente_id2' , $argDatos->idDocenteCursoHorariosMaterias2);  // reemplazo los parametros enlazados 
        $statement->bindParam(':nsituacion_docente2' , $argDatos->valorDocenteSituacionMateria2);  // reemplazo los parametros enlazados 
        $statement->bindParam(':bdocente_presente2' , $argDatos->docentePresente2);  // reemplazo los parametros enlazados

        // Modulo 3
        $statement->bindParam(':argrela_materia_id_modulo3' , $argDatos->idDocenteMaterias3);  // reemplazo los parametros enlazados 
        $statement->bindParam(':argrela_docente_id3' , $argDatos->idDocenteCursoHorariosMaterias3);  // reemplazo los parametros enlazados 
        $statement->bindParam(':argnsituacion_docente3' , $argDatos->valorDocenteSituacionMateria3);  // reemplazo los parametros enlazados 
        $statement->bindParam(':argbdocente_presente3' , $argDatos->docentePresente3);  // reemplazo los parametros enlazados

        // Modulo 4
        $statement->bindParam(':argrela_materia_id_modulo4' , $argDatos->idDocenteMaterias4);  // reemplazo los parametros enlazados 
        $statement->bindParam(':argrela_docente_id4' , $argDatos->idDocenteCursoHorariosMaterias4);  // reemplazo los parametros enlazados 
        $statement->bindParam(':argnsituacion_docente4' , $argDatos->valorDocenteSituacionMateria4);  // reemplazo los parametros enlazados 
        $statement->bindParam(':argbdocente_presente4' , $argDatos->docentePresente4);  // reemplazo los parametros enlazados

        // Modulo 5
        $statement->bindParam(':argrela_materia_id_modulo5' , $argDatos->idDocenteMaterias5);  // reemplazo los parametros enlazados 
        $statement->bindParam(':argrela_docente_id5' , $argDatos->idDocenteCursoHorariosMaterias5);  // reemplazo los parametros enlazados 
        $statement->bindParam(':argnsituacion_docente5' , $argDatos->valorDocenteSituacionMateria5);  // reemplazo los parametros enlazados 
        $statement->bindParam(':argbdocente_presente5' , $argDatos->docentePresente5);  // reemplazo los parametros enlazados

        // Modulo 6
        $statement->bindParam(':argrela_materia_id_modulo6' , $argDatos->idDocenteMaterias6);  // reemplazo los parametros enlazados 
        $statement->bindParam(':argrela_docente_id6' , $argDatos->idDocenteCursoHorariosMaterias6);  // reemplazo los parametros enlazados 
        $statement->bindParam(':argnsituacion_docente6' , $argDatos->valorDocenteSituacionMateria6);  // reemplazo los parametros enlazados 
        $statement->bindParam(':argbdocente_presente6' , $argDatos->docentePresente6);  // reemplazo los parametros enlazados

        // Modulo 7
        $statement->bindParam(':argrela_materia_id_modulo7' , $argDatos->idDocenteMaterias7);  // reemplazo los parametros enlazados 
        $statement->bindParam(':argrela_docente_id7' , $argDatos->idDocenteCursoHorariosMaterias7);  // reemplazo los parametros enlazados 
        $statement->bindParam(':argnsituacion_docente7' , $argDatos->valorDocenteSituacionMateria7);  // reemplazo los parametros enlazados 
        $statement->bindParam(':argbdocente_presente7' , $argDatos->docentePresente7);  // reemplazo los parametros enlazados
        
        // horas desde-hasta
        // Modulo 1
        $statement->bindParam(':argchora_desdemodulo1' , $argDatos->valorDesdeModuloCursoHorariosMaterias1);  // reemplazo los parametros enlazados
        $statement->bindParam(':argchora_hastamodulo1' , $argDatos->valorHastaModuloCursoHorariosMaterias1);  // reemplazo los parametros enlazados

        // Modulo 2
        $statement->bindParam(':argchora_desdemodulo2' , $argDatos->valorDesdeModuloCursoHorariosMaterias2);  // reemplazo los parametros enlazados
        $statement->bindParam(':argchora_hastamodulo2' , $argDatos->valorHastaModuloCursoHorariosMaterias2);  // reemplazo los parametros enlazados

     // Modulo 3
        $statement->bindParam(':argchora_desdemodulo3' , $argDatos->valorDesdeModuloCursoHorariosMaterias3);  // reemplazo los parametros enlazados
        $statement->bindParam(':argchora_hastamodulo3' , $argDatos->valorHastaModuloCursoHorariosMaterias3);  // reemplazo los parametros enlazados

     // Modulo 4
        $statement->bindParam(':argchora_desdemodulo4' , $argDatos->valorDesdeModuloCursoHorariosMaterias4);  // reemplazo los parametros enlazados
        $statement->bindParam(':argchora_hastamodulo4' , $argDatos->valorHastaModuloCursoHorariosMaterias4);  // reemplazo los parametros enlazados

     // Modulo 5
        $statement->bindParam(':argchora_desdemodulo5' , $argDatos->valorDesdeModuloCursoHorariosMaterias5);  // reemplazo los parametros enlazados
        $statement->bindParam(':argchora_hastamodulo5' , $argDatos->valorHastaModuloCursoHorariosMaterias5);  // reemplazo los parametros enlazados

     // Modulo 6
        $statement->bindParam(':argchora_desdemodulo6' , $argDatos->valorDesdeModuloCursoHorariosMaterias6);  // reemplazo los parametros enlazados
        $statement->bindParam(':argchora_hastamodulo6' , $argDatos->valorHastaModuloCursoHorariosMaterias6);  // reemplazo los parametros enlazados

     // Modulo 7
        $statement->bindParam(':argchora_desdemodulo7' , $argDatos->valorDesdeModuloCursoHorariosMaterias7);  // reemplazo los parametros enlazados
        $statement->bindParam(':argchora_hastamodulo7' , $argDatos->valorHastaModuloCursoHorariosMaterias7);  // reemplazo los parametros enlazados


        $statement->bindParam(':argnvalor_inasistencia' , $argDatos->valorInasistencia);  // reemplazo los parametros enlazados
        
        $statement->bindParam(':argdivisionhorario_id' , $argDatos->idDivisionHorario);  // reemplazo los parametros enlazados

        $statement->execute();

        return true;
    } catch (PDOException $e) {
        echo "Mensaje de la excepción: ".$e->getMessage()."<br>";
        return false;
    }

}