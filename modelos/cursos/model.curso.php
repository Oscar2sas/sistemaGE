<?php 

function obtenerCursos(){

        $descripcionCursos = array();  // creo un array que va a almacenar la informacion de los curso

        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql_cursos = "SELECT * FROM cursos"; // busca todos los curso

        $statement = $conexion->prepare($sql_cursos);

        $statement->execute();
        
        if (!$statement){
            // no se encontraron paises
        }else{
            // reviso el retorno

            while($resultado = $statement->fetch(PDO::FETCH_ASSOC)){
                $descripcionCursos[] = $resultado;
            }
        }
        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);
        return $descripcionCursos;
    }

function buscarCurso($arg_id_curso){

    $descripcionCurso = array();  // creo un array que va a almacenar la informacion de los curso

        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql_curso = "SELECT * FROM cursos WHERE curso_id = :argcurso_id"; // busca todos los curso

        $statement = $conexion->prepare($sql_curso);

        $statement->bindParam(':argcurso_id' , $arg_id_curso);  // reemplazo los parametros enlazados 
        $statement->execute();
        
        if (!$statement){
            // no se encontraron paises
        }else{
            // reviso el retorno

            while($resultado = $statement->fetch(PDO::FETCH_ASSOC)){
                $descripcionCurso[] = $resultado;
            }
        }
        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);
        return $descripcionCurso;
    }