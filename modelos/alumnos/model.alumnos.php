<?php 

// Funcion para buscar a los alumnos de un curso,
// En un ano lectivo determinado
// En un trayecto determinado
    function buscar_division_alumnos($argIdAnoLectivo, $argIdCurso){

        $resultado_division_alumnos = array();  // creo un array que va a almacenar la informacion de los anos lectivos

        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql_division_alumnos = "SELECT * FROM divisiones_alumnos d1, alumnos a1, personas p1, estado_alumnos e1 WHERE d1.rela_alumno_id = a1.alumno_id AND a1.rela_persona_id = p1.persona_id AND a1.rela_estadoalumno_id = e1.estadoalumno_id AND (e1.cdescripcion_estadoalumno = 'CURSANTE' OR e1.cdescripcion_estadoalumno = 'REPITENTE' OR e1.cdescripcion_estadoalumno = 'LIBRE' OR e1.cdescripcion_estadoalumno = 'REINCORPORAR') AND d1.rela_anolectivo_id = :argrela_anolectivo_id AND d1.rela_curso_id = :argrela_curso_id"; // busca todos los anos lectivos

        $statement = $conexion->prepare($sql_division_alumnos);

        $statement->bindParam(':argrela_anolectivo_id' , $argIdAnoLectivo);  // reemplazo los parametros enlazados 
        $statement->bindParam(':argrela_curso_id' , $argIdCurso);  // reemplazo los parametros enlazados 

        $statement->execute();
        
        if (!$statement){
            // no se encontraron paises
        }else{
            // reviso el retorno

            while($resultado = $statement->fetch(PDO::FETCH_ASSOC)){
                $resultado_division_alumnos[]= $resultado;
            }
        }
        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);
        return $resultado_division_alumnos;

    }
    
    function obtener_datos_alumnos($argIdAlumno){

        $resultado_datos_alumnos = array();  // creo un array que va a almacenar la informacion de los anos lectivos

        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql_datos_alumnos = "SELECT * FROM alumnos a1, personas p1 WHERE a1.rela_persona_id = p1.persona_id AND a1.alumno_id  = :alumno_id"; // busca todos los anos lectivos

        $statement = $conexion->prepare($sql_datos_alumnos);

        $statement->bindParam(':alumno_id' , $argIdAlumno);  // reemplazo los parametros enlazados 
        
        $statement->execute();
        
        if (!$statement){
            // no se encontraron paises
        }else{
            // reviso el retorno

            while($resultado = $statement->fetch(PDO::FETCH_ASSOC)){
                $resultado_datos_alumnos[]= $resultado;
            }
        }
        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);
        return $resultado_datos_alumnos;

    }
    
function obtener_alumnos_para_reincorporar($argIdAnoLectivoActivo){

        $resultado_datos_alumnos_reincorporar = array();  // creo un array que va a almacenar la informacion de los anos lectivos

        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql_datos_alumnos_reincorporar = "SELECT * FROM alumnos a1, estado_alumnos e1, personas p1, cursos c1, divisiones_alumnos d1 WHERE a1.rela_persona_id = p1.persona_id AND a1.rela_estadoalumno_id = e1.estadoalumno_id AND e1.cdescripcion_estadoalumno = 'REINCORPORAR' AND a1.nsituacion_alumno = 1 AND d1.rela_alumno_id = a1.alumno_id AND d1.rela_curso_id = c1.curso_id AND d1.rela_anolectivo_id = :argrela_anolectivo_id";

        $statement = $conexion->prepare($sql_datos_alumnos_reincorporar);
        $statement->bindParam(':argrela_anolectivo_id' , $argIdAnoLectivoActivo);  // reemplazo los parametros enlazados 

        $statement->execute();
        
        if (!$statement){
            // no se encontraron paises
        }else{
            // reviso el retorno

            while($resultado = $statement->fetch(PDO::FETCH_ASSOC)){
                $resultado_datos_alumnos_reincorporar[]= $resultado;
            }
        }
        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);
        return $resultado_datos_alumnos_reincorporar;

    }


    function buscar_division_alumnos_ano_lectivo($argIdAnoLectivo){

        $resultado_division_alumnos_ano_lectivo = array();  // creo un array que va a almacenar la informacion de los anos lectivos

        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql_division_alumnos_ano_lectivo = "SELECT * FROM divisiones_alumnos d1, alumnos a1, personas p1, estado_alumnos e1 WHERE d1.rela_alumno_id = a1.alumno_id AND a1.rela_persona_id = p1.persona_id AND a1.rela_estadoalumno_id = e1.estadoalumno_id AND d1.rela_anolectivo_id = :argrela_anolectivo_id"; // busca todos los anos lectivos

        $statement = $conexion->prepare($sql_division_alumnos_ano_lectivo);

        $statement->bindParam(':argrela_anolectivo_id' , $argIdAnoLectivo);  // reemplazo los parametros enlazados  

        $statement->execute();
        
        if (!$statement){
            // no se encontraron paises
        }else{
            // reviso el retorno

            while($resultado = $statement->fetch(PDO::FETCH_ASSOC)){
                $resultado_division_alumnos_ano_lectivo[]= $resultado;
            }
        }
        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);
        return $resultado_division_alumnos_ano_lectivo;

    }


function obtener_alumnos_segun_estado($argIdEstadoAlumnos){

        $resultado_alumnos_segun_estado = array();  // creo un array que va a almacenar la informacion de los anos lectivos

        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql_alumnos_segun_estado = "SELECT * FROM divisiones_alumnos d1, alumnos a1, personas p1, estado_alumnos e1 WHERE d1.rela_alumno_id = a1.alumno_id AND a1.rela_persona_id = p1.persona_id AND a1.rela_estadoalumno_id = e1.estadoalumno_id AND e1.estadoalumno_id = :argestadoalumno_id"; // 

        $statement = $conexion->prepare($sql_alumnos_segun_estado);

        $statement->bindParam(':argestadoalumno_id' , $argIdEstadoAlumnos);  // reemplazo los parametros enlazados  

        $statement->execute();
        
        if (!$statement){
            // no se encontraron paises
        }else{
            // reviso el retorno

            while($resultado = $statement->fetch(PDO::FETCH_ASSOC)){
                $resultado_alumnos_segun_estado[]= $resultado;
            }
        }
        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);
        return $resultado_alumnos_segun_estado;

    }


     function obtener_datos_alumnos_dni($argDniAlumno, $idAnoLectivo){

        $resultado_datos_alumnos_dni = array();  // creo un array que va a almacenar la informacion de los anos lectivos

        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql_datos_alumnos_dni = "SELECT * FROM alumnos a1, personas p1, divisiones_alumnos d1 WHERE a1.rela_persona_id = p1.persona_id AND p1.ndni_persona = :argndni_persona AND a1.alumno_id = d1.rela_alumno_id"; // busca todos los anos lectivos

        $statement = $conexion->prepare($sql_datos_alumnos_dni);

        $statement->bindParam(':argndni_persona' , $argDniAlumno);  // reemplazo los parametros enlazados 
        
        $statement->execute();
        
        if (!$statement){
            // no se encontraron paises
        }else{
            // reviso el retorno

            while($resultado = $statement->fetch(PDO::FETCH_ASSOC)){
                $resultado_datos_alumnos_dni[]= $resultado;
            }
        }
        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);
        return $resultado_datos_alumnos_dni;

    }