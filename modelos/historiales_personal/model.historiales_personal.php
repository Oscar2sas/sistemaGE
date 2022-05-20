<?php 
    
    function buscar_historiales_personal(){

        $carreras = array();  // creo un array que va a almacenar la informacion de las carreras

        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "SELECT historiales_personal.historialpersonal_id, personas.persona_id, personas.ncuil_persona, personas.cemail_persona, personas.dfechanac_persona, personales.personal_id, personas.capellidos_persona, personas.cnombres_persona, personas.ndni_persona, dfecha_historial, historial_personal, personales.nsituacion_personal, cargos.cdescripcion_cargo, sexos.cdescripcion_sexo, telefonos.ntipo_telefono, telefonos.cnumero_telefono, direcciones.cmanzana_direccion, direcciones.ccasa_direccion, barrios.cnombre_barrio, calles.cnombre_calle FROM `historiales_personal` INNER JOIN personales INNER JOIN personas INNER JOIN cargos INNER JOIN sexos INNER JOIN telefonos INNER JOIN direcciones INNER JOIN barrios INNER JOIN calles WHERE historiales_personal.rela_personal_id = personales.personal_id AND personas.persona_id = personales.rela_persona_id AND personales.rela_cargo_id = cargos.cargol_id AND personas.rela_sexo_id = sexos.sexo_id AND telefonos.rela_persona_id = personas.persona_id AND direcciones.rela_persona_id = personas.persona_id AND barrios.barrio_id = direcciones.rela_barrio_id AND direcciones.rela_calle_id = calles.calle_id GROUP BY historiales_personal.historialpersonal_id" ;   //busca todas las localidades

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

    function modificar_datos($arg_historialpersonal_id, $arg_historial_personal){
        
        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "UPDATE historiales_personal SET historial_personal = :arg_historial_personal WHERE historiales_personal.historialpersonal_id = :arg_historialpersonal_id";
        
        //preparo el sql para enviar se puede usar prepare y bindparam 
        $statement = $conexion->prepare($sql);
        
        $statement->bindParam(':arg_historialpersonal_id' , $arg_historialpersonal_id);  //reemplazo los parametros enlazados 
        $statement->bindParam(':arg_historial_personal' , $arg_historial_personal);  //reemplazo los parametros 
        
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
    
    function eliminar_materia($arg_historialpersonal_id){
        
        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "DELETE FROM historiales_personal WHERE historialpersonal_id = :arg_historialpersonal_id";
        
        // preparo el sql para enviar   se puede usar prepare   y bindparam 
        $statement = $conexion->prepare($sql);
        
        $statement->bindParam(':arg_historialpersonal_id' , $arg_historialpersonal_id);  // reemplazo los parametros enlazados   
        
        if(!$statement){
            echo "Error eliminar registro";
        }else{
            $statement->execute();
        }

        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);

    }

    function buscar_historiales_personal2($arg_personal_id){

        $carreras = array();  // creo un array que va a almacenar la informacion de las carreras

        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "SELECT historiales_personal.historialpersonal_id, personas.persona_id, personas.ncuil_persona, personas.cemail_persona, personas.dfechanac_persona, personales.personal_id, personas.capellidos_persona, personas.cnombres_persona, personas.ndni_persona, dfecha_historial, historial_personal, personales.nsituacion_personal, cargos.cdescripcion_cargo, sexos.cdescripcion_sexo, telefonos.ntipo_telefono, telefonos.cnumero_telefono, direcciones.cmanzana_direccion, direcciones.ccasa_direccion, barrios.cnombre_barrio, calles.cnombre_calle FROM `historiales_personal` INNER JOIN personales INNER JOIN personas INNER JOIN cargos INNER JOIN sexos INNER JOIN telefonos INNER JOIN direcciones INNER JOIN barrios INNER JOIN calles WHERE historiales_personal.rela_personal_id = personales.personal_id AND personas.persona_id = personales.rela_persona_id AND personales.rela_cargo_id = cargos.cargol_id AND personas.rela_sexo_id = sexos.sexo_id AND telefonos.rela_persona_id = personas.persona_id AND direcciones.rela_persona_id = personas.persona_id AND barrios.barrio_id = direcciones.rela_barrio_id AND direcciones.rela_calle_id = calles.calle_id AND personales.personal_id = :arg_personal_id GROUP BY historiales_personal.historialpersonal_id"; // busca todas las localidades

        $statement = $conexion->prepare($sql);

        $statement->bindParam(':arg_personal_id' , $arg_docente_id);
        
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