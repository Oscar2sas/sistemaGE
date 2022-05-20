<?php 
    
    function buscar_historiales_docentes(){

        $carreras = array();  // creo un array que va a almacenar la informacion de las carreras

        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "SELECT historiales_docentes.historialdocente_id, personas.capellidos_persona, personas.cnombres_persona, personas.ndni_persona, personas.ncuil_persona, personas.cemail_persona, personas.dfechanac_persona, sexos.cdescripcion_sexo, docentes.nsituacion_docente, docentes.cnumlegajo_docente, docentes.cnumregistro_docente, docentes.cestado_legajo, docentes.cobservaciones_docente, estado_docentes.cdescripcion_estadodocente, historiales_docentes.dfecha_historial, historiales_docentes.historial_docente, telefonos.ntipo_telefono, telefonos.cnumero_telefono, direcciones.cmanzana_direccion, direcciones.ccasa_direccion, barrios.cnombre_barrio, calles.cnombre_calle FROM personas INNER JOIN docentes INNER JOIN sexos INNER JOIN estado_docentes INNER JOIN historiales_docentes INNER JOIN telefonos INNER JOIN direcciones INNER JOIN barrios INNER JOIN calles WHERE docentes.rela_persona_id = personas.persona_id AND personas.rela_sexo_id = sexos.sexo_id AND docentes.rela_estadodocente_id = estado_docentes.estadodocente_id AND historiales_docentes.rela_docente_id = docentes.docente_id AND direcciones.rela_persona_id = personas.persona_id AND barrios.barrio_id = direcciones.rela_barrio_id AND direcciones.rela_calle_id = calles.calle_id GROUP BY historiales_docentes.historialdocente_id" ; // busca todas las localidades

        $statement = $conexion->prepare($sql);
        
        if(!$statement){
            echo "Error al crear el registro";
        }else{
            $statement->execute();
        }

        if (!$statement) {
            // no se encontraron localidades
        }
        else {
            // reviso el retorno

            while($resultado = $statement->fetch(PDO::FETCH_ASSOC)){

                $carreras[] = $resultado;
            }
        }

        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);

        return $carreras;

    }

    function modificar_datos($arg_historialdocente_id, $arg_historial_docente){
        
        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "UPDATE historiales_docentes SET historial_docente = :arg_historial_docente WHERE historiales_docentes.historialdocente_id = :arg_historialdocente_id";
        
        //preparo el sql para enviar se puede usar prepare y bindparam 
        $statement = $conexion->prepare($sql);
        
        $statement->bindParam(':arg_historialdocente_id' , $arg_historialdocente_id);  //reemplazo los parametros enlazados 
        $statement->bindParam(':arg_historial_docente' , $arg_historial_docente);  //reemplazo los parametros 
        
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
    
    function eliminar_materia($arg_historialdocente_id){

        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "DELETE FROM historiales_docentes WHERE historialdocente_id = :arg_historialdocente_id";
        
        // preparo el sql para enviar   se puede usar prepare   y bindparam 
        $statement = $conexion->prepare($sql);
        
        $statement->bindParam(':arg_historialdocente_id' , $arg_historialdocente_id);  // reemplazo los parametros enlazados   
        
        if(!$statement){
            echo "Error eliminar registro";
        }else{
            $statement->execute();
        }

        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);

    }
    function buscar_historiales_docentes2($arg_docente_id){

        $carreras = array();  // creo un array que va a almacenar la informacion de las carreras

        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "SELECT docentes.docente_id, historiales_docentes.historialdocente_id, personas.capellidos_persona, personas.cnombres_persona, personas.ndni_persona, personas.ncuil_persona, personas.cemail_persona, personas.dfechanac_persona, sexos.cdescripcion_sexo, docentes.nsituacion_docente, docentes.cnumlegajo_docente, docentes.cnumregistro_docente, docentes.cestado_legajo, docentes.cobservaciones_docente, estado_docentes.cdescripcion_estadodocente, historiales_docentes.dfecha_historial, historiales_docentes.historial_docente, telefonos.ntipo_telefono, telefonos.cnumero_telefono, direcciones.cmanzana_direccion, direcciones.ccasa_direccion, barrios.cnombre_barrio, calles.cnombre_calle FROM personas INNER JOIN docentes INNER JOIN sexos INNER JOIN estado_docentes INNER JOIN historiales_docentes INNER JOIN telefonos INNER JOIN direcciones INNER JOIN barrios INNER JOIN calles WHERE docentes.rela_persona_id = personas.persona_id AND personas.rela_sexo_id = sexos.sexo_id AND docentes.rela_estadodocente_id = estado_docentes.estadodocente_id AND historiales_docentes.rela_docente_id = docentes.docente_id AND direcciones.rela_persona_id = personas.persona_id AND barrios.barrio_id = direcciones.rela_barrio_id AND direcciones.rela_calle_id = calles.calle_id AND docentes.docente_id = :arg_docente_id GROUP BY historiales_docentes.historialdocente_id"; // busca todas las localidades

        $statement = $conexion->prepare($sql);

        $statement->bindParam(':arg_docente_id' , $arg_docente_id);
        
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
 ?>