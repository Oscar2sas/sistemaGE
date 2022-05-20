<?php 

function obtener_divisiones_ano_lectivo($arg_id_ano_lectivo){

    $resultado_division_ano_lectivo = array();

    $db = new ConexionDB;
    $conexion = $db->retornar_conexion();

    try {

        $sql_buscar_division_ano_lectivo = "SELECT * FROM divisiones d1, cursos c1 WHERE d1.rela_curso_id = c1.curso_id AND d1.rela_anolectivo_id = :argrela_anolectivo_id  ORDER BY c1.cdescripcion_curso ASC"; // busca todas la divisiones de un ano lectivo determinado

        $statement = $conexion->prepare($sql_buscar_division_ano_lectivo);

        $statement->bindParam(':argrela_anolectivo_id' , $arg_id_ano_lectivo);  // reemplazo los parametros enlazados 

        if (!$statement->execute()) {
            return array('estado' => false,'mensaje' => $statement->errorInfo());
        }

        while($resultado = $statement->fetch(PDO::FETCH_ASSOC)){
            $resultado_division_ano_lectivo[] = $resultado;
        }
    } catch (PDOException $e) {
        return array('estado' => false,'mensaje' => "Mensaje de la excepción: ".$e->getMessage()."<br>");
    }
        // cierro la conexion
    $statement = $db->cerrar_conexion($conexion);

    return array('estado' => true,'mensaje' => $resultado_division_ano_lectivo);


}


function obtener_divisiones_ano_lectivo_curso($arg_id_ano_lectivo, $arg_id_curso){

    $resultado_division_ano_lectivo_curso = array();

    $db = new ConexionDB;
    $conexion = $db->retornar_conexion();

    try {

        $sql_buscar_division_ano_lectivo = "SELECT * FROM divisiones WHERE rela_curso_id = :argrela_curso_id AND rela_anolectivo_id = :argrela_anolectivo_id"; // busca todas la divisiones de un ano lectivo determinado

        $statement = $conexion->prepare($sql_buscar_division_ano_lectivo);

        $statement->bindParam(':argrela_anolectivo_id' , $arg_id_ano_lectivo);  // reemplazo los parametros enlazados 
        $statement->bindParam(':argrela_curso_id' , $arg_id_curso);  // reemplazo los parametros enlazados 

        if (!$statement->execute()) {
            return array('estado' => false,'mensaje' => $statement->errorInfo());
        }

        while($resultado = $statement->fetch(PDO::FETCH_ASSOC)){
            $resultado_division_ano_lectivo_curso[] = $resultado;
        }
    } catch (PDOException $e) {
        return array('estado' => false,'mensaje' => "Mensaje de la excepción: ".$e->getMessage()."<br>");
    }
        // cierro la conexion
    $statement = $db->cerrar_conexion($conexion);

    return array('estado' => true,'mensaje' => $resultado_division_ano_lectivo_curso);


}


function insertar_division($arg_id_ano_lectivo, $arg_id_curso){

    $db = new ConexionDB;
    $conexion = $db->retornar_conexion();

    try {

        $sql_buscar_division_ano_lectivo = "INSERT INTO divisiones(rela_anolectivo_id, rela_curso_id) VALUES (:argrela_anolectivo_id, :argrela_curso_id)"; // guarda los datos de la division

        $statement = $conexion->prepare($sql_buscar_division_ano_lectivo);

        $statement->bindParam(':argrela_anolectivo_id' , $arg_id_ano_lectivo);  // reemplazo los parametros enlazados 
        $statement->bindParam(':argrela_curso_id' , $arg_id_curso);  // reemplazo los parametros enlazados 

        if (!$statement->execute()) {
            return array('estado' => false,'mensaje' => $statement->errorInfo());
        }

    } catch (PDOException $e) {
        return array('estado' => false,'mensaje' => "Mensaje de la excepción: ".$e->getMessage()."<br>");
    }
        // cierro la conexion
    $statement = $db->cerrar_conexion($conexion);

    return array('estado' => true,'mensaje' => 'DIVISION GUARDADA CORRECTAMENTE');


}

function eliminar_division($arg_id_ano_lectivo, $arg_id_curso){

    $db = new ConexionDB;
    $conexion = $db->retornar_conexion();

    try {

        $sql_buscar_division_ano_lectivo = "DELETE FROM divisiones WHERE rela_anolectivo_id = :argrela_anolectivo_id AND rela_curso_id = :argrela_curso_id"; // guarda los datos de la division

        $statement = $conexion->prepare($sql_buscar_division_ano_lectivo);

        $statement->bindParam(':argrela_anolectivo_id' , $arg_id_ano_lectivo);  // reemplazo los parametros enlazados 
        $statement->bindParam(':argrela_curso_id' , $arg_id_curso);  // reemplazo los parametros enlazados 

        if (!$statement->execute()) {
            return array('estado' => false,'mensaje' => $statement->errorInfo());
        }

    } catch (PDOException $e) {
        return array('estado' => false,'mensaje' => "Mensaje de la excepción: ".$e->getMessage()."<br>");
    }
        // cierro la conexion
    $statement = $db->cerrar_conexion($conexion);

    return array('estado' => true,'mensaje' => 'DIVISION ELIMINADA CORRECTAMENTE');


}