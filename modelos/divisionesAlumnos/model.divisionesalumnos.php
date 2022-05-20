<?php 

function insertar_alumnos_division($arg_id_alumno, $arg_id_ano_lectivo, $arg_id_curso){

    $db = new ConexionDB;
    $conexion = $db->retornar_conexion();

    try {

        $sql_buscar_division_ano_lectivo = "INSERT INTO divisiones_alumnos(rela_anolectivo_id, rela_curso_id, rela_alumno_id) VALUES (:argrela_anolectivo_id, :argrela_curso_id, :argrela_alumno_id)"; // guarda los datos de los alumnos en divisiones

        $statement = $conexion->prepare($sql_buscar_division_ano_lectivo);

        $statement->bindParam(':argrela_anolectivo_id' , $arg_id_ano_lectivo);  // reemplazo los parametros enlazados 
        $statement->bindParam(':argrela_curso_id' , $arg_id_curso);  // reemplazo los parametros enlazados 
        
        $statement->bindParam(':argrela_alumno_id' , $arg_id_alumno);  // reemplazo los parametros enlazados 

        if (!$statement->execute()) {
            return array('estado' => false,'mensaje' => $statement->errorInfo());
        }

    } catch (PDOException $e) {
        return array('estado' => false,'mensaje' => "Mensaje de la excepción: ".$e->getMessage()."<br>");
    }
        // cierro la conexion
    $statement = $db->cerrar_conexion($conexion);

    return array('estado' => true,'mensaje' => 'DIVISION ALUMNO GUARDADO CORRECTAMENTE');

}


function eliminar_alumno_division($arg_id_alumno, $arg_id_ano_lectivo){

    $db = new ConexionDB;
    $conexion = $db->retornar_conexion();

    try {

        $sql_buscar_division_ano_lectivo = "DELETE FROM divisiones_alumnos WHERE rela_alumno_id = :argrela_alumno_id AND rela_anolectivo_id = :argrela_anolectivo_id"; // guarda los datos de los alumnos en divisiones

        $statement = $conexion->prepare($sql_buscar_division_ano_lectivo);

        $statement->bindParam(':argrela_anolectivo_id' , $arg_id_ano_lectivo);  // reemplazo los parametros enlazados 
        $statement->bindParam(':argrela_alumno_id' , $arg_id_alumno);  // reemplazo los parametros enlazados 

        if (!$statement->execute()) {
            return array('estado' => false,'mensaje' => $statement->errorInfo());
        }

    } catch (PDOException $e) {
        return array('estado' => false,'mensaje' => "Mensaje de la excepción: ".$e->getMessage()."<br>");
    }
        // cierro la conexion
    $statement = $db->cerrar_conexion($conexion);

    return array('estado' => true,'mensaje' => 'ALUMNO ELIMINADO DE LA DIVISION CORRECTAMENTE');

}


function eliminar_curso_division_alumno($arg_id_curso, $arg_id_ano_lectivo){

    $db = new ConexionDB;
    $conexion = $db->retornar_conexion();

    try {

        $sql_buscar_division_ano_lectivo = "DELETE FROM divisiones_alumnos WHERE rela_curso_id = :argrela_curso_id AND rela_anolectivo_id = :argrela_anolectivo_id"; // guarda los datos de los alumnos en divisiones

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

    return array('estado' => true,'mensaje' => 'DIVISION ALUMNOS BORRADO CORRECTAMENTE');

}


function modificar_alumno_division($arg_id_curso, $arg_id_ano_lectivo, $arg_id_alumno){

    $db = new ConexionDB;
    $conexion = $db->retornar_conexion();

    try {

        $sql_buscar_division_ano_lectivo = "UPDATE divisiones_alumnos SET rela_curso_id= :argrela_curso_id WHERE rela_alumno_id = :argrela_alumno_id AND rela_anolectivo_id = :argrela_anolectivo_id"; // guarda los datos de los alumnos en divisiones

        $statement = $conexion->prepare($sql_buscar_division_ano_lectivo);

        $statement->bindParam(':argrela_curso_id' , $arg_id_curso);  // reemplazo los parametros enlazados 
        $statement->bindParam(':argrela_anolectivo_id' , $arg_id_ano_lectivo);  // reemplazo los parametros enlazados 
        $statement->bindParam(':argrela_alumno_id' , $arg_id_alumno);  // reemplazo los parametros enlazados 

        if (!$statement->execute()) {
            return array('estado' => false,'mensaje' => $statement->errorInfo());
        }

    } catch (PDOException $e) {
        return array('estado' => false,'mensaje' => "Mensaje de la excepción: ".$e->getMessage()."<br>");
    }
        // cierro la conexion
    $statement = $db->cerrar_conexion($conexion);

    return array('estado' => true,'mensaje' => 'CAMBIO DE ALUMNO EXITOSO!');

}
