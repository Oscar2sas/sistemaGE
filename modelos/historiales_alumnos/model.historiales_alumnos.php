<?php
    
    function buscar_historiales_alumnos(){

        $carreras = array();  // creo un array que va a almacenar la informacion de las carreras

        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "SELECT personas.persona_id, alumnos.alumno_id, historiales_alumnos.historialalumno_id, personas.capellidos_persona, personas.cnombres_persona, personas.ndni_persona, personas.ncuil_persona, historiales_alumnos.dfecha_historial, historiales_alumnos.historial_alumno,alumnos.balumno_regular, alumnos.nsituacion_alumno, estado_alumnos.cdescripcion_estadoalumno, alumnos.rela_persona_id_tutor1, alumnos.rela_persona_id_tutor2, alumnos.rela_persona_id_tutor3 FROM `historiales_alumnos` INNER JOIN alumnos INNER JOIN personas INNER JOIN estado_alumnos WHERE rela_alumno_id = alumnos.alumno_id AND alumnos.rela_persona_id = personas.persona_id AND estado_alumnos.estadoalumno_id = alumnos.rela_estadoalumno_id"; // busca todas las localidades

        $statement = $conexion->prepare($sql);
        
        if(!$statement){
            echo "Error al crear el registro";
        }else{
            $statement->execute();
        }

        if (!$statement) {
            //no se encontraron localidades
        }
        else {
        
            //reviso el retorno

            while($resultado = $statement->fetch(PDO::FETCH_ASSOC)){
                $carreras[] = $resultado;
            }
        }

        //cierro la conexion
        $statement = $db->cerrar_conexion($conexion);

        return $carreras;
    }

    function modificar_datos($arg_historialalumno_id, $arg_historial_alumno){
        
        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "UPDATE historiales_alumnos SET historial_alumno = :arg_historial_alumno WHERE historiales_alumnos.historialalumno_id = :arg_historialalumno_id";
        
        //preparo el sql para enviar se puede usar prepare y bindparam 
        $statement = $conexion->prepare($sql);
        
        $statement->bindParam(':arg_historialalumno_id' , $arg_historialalumno_id);  //reemplazo los parametros enlazados 
        $statement->bindParam(':arg_historial_alumno' , $arg_historial_alumno);  //reemplazo los parametros 
        
        if(!$statement){
            echo "Error al editar el registro";
        }else{
            if ($statement->execute()) {
                return true;
            }else{
                return false;
            }
        }

        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);

    }
    
    function eliminar_materia($arg_historialalumno_id){

        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "DELETE FROM `historiales_alumnos` WHERE historialalumno_id = :arg_historialalumno_id";
        
        // preparo el sql para enviar   se puede usar prepare   y bindparam 
        $statement = $conexion->prepare($sql);
        
        $statement->bindParam(':arg_historialalumno_id' , $arg_historialalumno_id);  // reemplazo los parametros enlazados   
        
        if(!$statement){
            echo "Error eliminar registro";
        }else{
            $statement->execute();
        }

        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);

    }

    function buscar_historiales_notas($arg_alumno_id){

        $carreras = array();  // creo un array que va a almacenar la informacion de las carreras

        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "SELECT alumnos.alumno_id, personas.capellidos_persona, personas.cnombres_persona, personas.ndni_persona, materias.cnombre_materia, notas.ncalificacion, cursos.cdescripcion_curso, anos_lectivos.ndescripcion_anolectivo, etapas_escolares.cdescripcion_etapa FROM alumnos INNER JOIN personas INNER JOIN notas INNER JOIN materias INNER JOIN cursos INNER JOIN anos_lectivos INNER JOIN etapas_escolares WHERE alumnos.rela_persona_id = personas.persona_id AND notas.rela_alumno_id = alumnos.alumno_id AND notas.rela_materia_id = materias.materia_id AND notas.rela_curso_id = cursos.curso_id AND notas.rela_anolectivo_id = anos_lectivos.anolectivo_id AND notas.rela_etapaescolar_id = etapas_escolares.etapaescolar_id AND alumnos.alumno_id = :arg_alumno_id AND anos_lectivos.ndescripcion_anolectivo = YEAR(NOW())"; // busca todas las localidades

        $statement = $conexion->prepare($sql);

        $statement->bindParam(':arg_alumno_id' , $arg_alumno_id);
        
        if(!$statement){
            echo "Error al crear el registro";
        }else{
            $statement->execute();
        }

        if (!$statement) {
            //no se encontraron localidades
        }
        else {
        
            //reviso el retorno

            while($resultado = $statement->fetch(PDO::FETCH_ASSOC)){
                $carreras[] = $resultado;
            }
        }

        //cierro la conexion
        $statement = $db->cerrar_conexion($conexion);

        return $carreras;
    }

    function buscar_historiales_alumnos2($arg_alumno_id){

        $carreras = array();  // creo un array que va a almacenar la informacion de las carreras

        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "SELECT personas.persona_id, alumnos.alumno_id, personas.capellidos_persona, personas.cnombres_persona, personas.ndni_persona, personas.ncuil_persona, dfecha_historial, historialalumno_id, historial_alumno,alumnos.balumno_regular, alumnos.nsituacion_alumno, estado_alumnos.cdescripcion_estadoalumno, alumnos.rela_persona_id_tutor1, alumnos.rela_persona_id_tutor2, alumnos.rela_persona_id_tutor3 FROM `historiales_alumnos` INNER JOIN alumnos INNER JOIN personas INNER JOIN estado_alumnos WHERE rela_alumno_id = alumnos.alumno_id AND alumnos.rela_persona_id = personas.persona_id AND estado_alumnos.estadoalumno_id = alumnos.rela_estadoalumno_id AND alumnos.alumno_id = :arg_alumno_id"; // busca todas las localidades

        $statement = $conexion->prepare($sql);

        $statement->bindParam(':arg_alumno_id' , $arg_alumno_id);
        
        if(!$statement){
            echo "Error al buscar el registro";
        }else{
            $statement->execute();
        }

        if (!$statement) {
            //no se encontraron localidades
        }
        else {
        
            //reviso el retorno

            while($resultado = $statement->fetch(PDO::FETCH_ASSOC)){
                $carreras[] = $resultado;
            }
        }

        //cierro la conexion
        $statement = $db->cerrar_conexion($conexion);

        return $carreras;
    }

    function buscar_datos_tutores1($arg_rela_persona_id_tutor1){

        $carreras = array();  // creo un array que va a almacenar la informacion de las carreras

        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "SELECT personas.capellidos_persona, personas.cnombres_persona, personas.ndni_persona, personas.cemail_persona, personas.ncuil_persona, telefonos.cnumero_telefono FROM personas INNER JOIN telefonos WHERE telefonos.rela_persona_id = personas.persona_id AND personas.persona_id = :arg_rela_persona_id_tutor1"; // busca todas las localidades

        $statement = $conexion->prepare($sql);

        $statement->bindParam(':arg_rela_persona_id_tutor1' , $arg_rela_persona_id_tutor1);
        
        if(!$statement){
            echo "Error al buscar el registro";
        }else{
            $statement->execute();
        }

        if (!$statement) {
            //no se encontraron localidades
        }
        else {
        
            //reviso el retorno

            while($resultado = $statement->fetch(PDO::FETCH_ASSOC)){
                $carreras[] = $resultado;
            }
        }

        //cierro la conexion
        $statement = $db->cerrar_conexion($conexion);

        return $carreras;
    }

    function buscar_datos_tutores2($arg_rela_persona_id_tutor2){

        $carreras = array();  // creo un array que va a almacenar la informacion de las carreras

        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "SELECT personas.capellidos_persona, personas.cnombres_persona, personas.ndni_persona, personas.cemail_persona, personas.ncuil_persona, telefonos.cnumero_telefono FROM personas INNER JOIN telefonos WHERE telefonos.rela_persona_id = personas.persona_id AND personas.persona_id = :arg_rela_persona_id_tutor2"; // busca todas las localidades

        $statement = $conexion->prepare($sql);

        $statement->bindParam(':arg_rela_persona_id_tutor2' , $arg_rela_persona_id_tutor2);
        
        if(!$statement){
            echo "Error al buscar el registro";
        }else{
            $statement->execute();
        }

        if (!$statement) {
            //no se encontraron localidades
        }
        else {
        
            //reviso el retorno

            while($resultado = $statement->fetch(PDO::FETCH_ASSOC)){
                $carreras[] = $resultado;
            }
        }

        //cierro la conexion
        $statement = $db->cerrar_conexion($conexion);

        return $carreras;
    }

    function buscar_datos_tutores3($arg_rela_persona_id_tutor3){

        $carreras = array();  // creo un array que va a almacenar la informacion de las carreras

        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "SELECT personas.capellidos_persona, personas.cnombres_persona, personas.ndni_persona, personas.cemail_persona, personas.ncuil_persona, telefonos.cnumero_telefono FROM personas INNER JOIN telefonos WHERE telefonos.rela_persona_id = personas.persona_id AND personas.persona_id = :arg_rela_persona_id_tutor3"; // busca todas las localidades

        $statement = $conexion->prepare($sql);

        $statement->bindParam(':arg_rela_persona_id_tutor3' , $arg_rela_persona_id_tutor3);
        
        if(!$statement){
            echo "Error al buscar el registro";
        }else{
            $statement->execute();
        }

        if (!$statement) {
            //no se encontraron localidades
        }
        else {
        
            //reviso el retorno

            while($resultado = $statement->fetch(PDO::FETCH_ASSOC)){
                $carreras[] = $resultado;
            }
        }

        //cierro la conexion
        $statement = $db->cerrar_conexion($conexion);

        return $carreras;
    }
 ?>