<?php 

// Funcion para obtener a un docente
    function obtener_docentes(){

        $resultDocente = array();  // creo un array que va a almacenar la informacion de los anos lectivos

        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql_docente = "SELECT * FROM docentes d1, personas p1 WHERE d1.rela_persona_id = p1.persona_id AND d1.nsituacion_docente = 1"; // busca a todos los profesores

        $statement = $conexion->prepare($sql_docente);

        $statement->execute();
        
        if (!$statement){
            // no se encontraron paises
        }else{
            // reviso el retorno

            while($resultado = $statement->fetch(PDO::FETCH_ASSOC)){
                $resultDocente[] = $resultado;
            }
        }
        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);
        return $resultDocente;

    }