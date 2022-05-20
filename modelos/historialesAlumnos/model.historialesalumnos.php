<?php 

function insertar_historial_alumno($arg_desc_historial_alumno, $arg_id_alumno){

    $db = new ConexionDB;
    $conexion = $db->retornar_conexion();

    try {

        $sql_insertar_historial_alumno = "INSERT INTO historiales_alumnos(dfecha_historial, historial_alumno, rela_alumno_id) VALUES (NOW(), :arghistorial_alumno, :argrela_alumno_id)";

        $statement = $conexion->prepare($sql_insertar_historial_alumno);

        $statement->bindParam(':arghistorial_alumno' , $arg_desc_historial_alumno);  // reemplazo los parametros enlazados 
        $statement->bindParam(':argrela_alumno_id' , $arg_id_alumno);  // reemplazo los parametros enlazados 

        if (!$statement->execute()) {
            return array('estado' => false,'mensaje' => $statement->errorInfo());
        }

    } catch (PDOException $e) {
        return array('estado' => false,'mensaje' => "Mensaje de la excepción: ".$e->getMessage()."<br>");
    }
        // cierro la conexion
    $statement = $db->cerrar_conexion($conexion);

    return array('estado' => true,'mensaje' => 'Historial del alumno guardado correctamente');

}

function buscar_historiales_alumno($arg_id_alumno){

    $db = new ConexionDB;
    $conexion = $db->retornar_conexion();

    $resultado_buscar_historiales_alumnos = array();

    try {

        $sql_insertar_historial_alumno = "SELECT * FROM historiales_alumnos WHERE rela_alumno_id = :argrela_alumno_id";

        $statement = $conexion->prepare($sql_insertar_historial_alumno);

        $statement->bindParam(':argrela_alumno_id' , $arg_id_alumno);  // reemplazo los parametros enlazados 

        if (!$statement->execute()) {
            return array('estado' => false,'mensaje' => $statement->errorInfo());
        }

    } catch (PDOException $e) {
        return array('estado' => false,'mensaje' => "Mensaje de la excepción: ".$e->getMessage()."<br>");
    }
    while($resultado = $statement->fetch(PDO::FETCH_ASSOC)){
        $resultado_buscar_historiales_alumnos[]= $resultado;
    }

        // cierro la conexion
    $statement = $db->cerrar_conexion($conexion);

    return array('estado' => true,'mensaje' => $resultado_buscar_historiales_alumnos);

}


function buscar_historiales(){

    $db = new ConexionDB;
    $conexion = $db->retornar_conexion();

    $resultado_datos_historiales_alumnos = array();

    try {

        $sql_insertar_historial_alumno = "SELECT * FROM historiales_alumnos h1, alumnos a1, personas p1 WHERE h1.rela_alumno_id = a1.alumno_id AND a1.rela_persona_id = p1.persona_id ORDER BY h1.dfecha_historial DESC LIMIT 4";

        $statement = $conexion->prepare($sql_insertar_historial_alumno);

        if (!$statement->execute()) {
            return array('estado' => false,'mensaje' => $statement->errorInfo());
        }

    } catch (PDOException $e) {
        return array('estado' => false,'mensaje' => "Mensaje de la excepción: ".$e->getMessage()."<br>");
    }
    while($resultado = $statement->fetch(PDO::FETCH_ASSOC)){
        $resultado_datos_historiales_alumnos[]= $resultado;
    }

        // cierro la conexion
    $statement = $db->cerrar_conexion($conexion);

    return array('estado' => true,'mensaje' => $resultado_datos_historiales_alumnos);

}