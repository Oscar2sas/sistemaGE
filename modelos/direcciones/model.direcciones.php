<?php 

   
    function buscar_direcciones($arg_textoabuscar){

        $direcciones = array();  // creo un array que va a almacenar la informacion de los paises

        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "SELECT direcciones.*, personas.cnombres_persona, personas.capellidos_persona, calles.cnombre_calle, barrios.cnombre_barrio, localidades.cnombre_localidad FROM direcciones LEFT JOIN personas ON direcciones.rela_persona_id = personas.persona_id LEFT JOIN calles ON direcciones.rela_calle_id = calles.calle_id LEFT JOIN barrios ON direcciones.rela_barrio_id = barrios.barrio_id LEFT JOIN localidades ON direcciones.rela_localidad_id = localidades.localidad_id";  // busca un solo registor
        
        if (!empty($arg_textoabuscar)) {
        
            $sql = $sql." WHERE cdescripcion_direccion LIKE :arg_textoabuscar OR capellidos_persona LIKE :arg_textoabuscar OR cnombres_persona LIKE :arg_textoabuscar";   // filtra busqueda 

            $arg_textoabuscar="%".TRIM($arg_textoabuscar)."%";
        }

        $statement = $conexion->prepare($sql);
        
        $statement->bindParam(':arg_textoabuscar' , $arg_textoabuscar);  // reemplazo los parametros enlazados 

            // reviso el retorno
        if(!$statement){
                echo "Error al crear el registro";
        }else{
                $statement->execute();
        }
    
        if (!$statement) {
                // no se encontraron paises
        }
        else {
            while($resultado = $statement->fetch(PDO::FETCH_ASSOC)){

                $direcciones[] = $resultado;

            }
        }
        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);
        return $direcciones;

    }

    function buscar_una_direccion($arg_direccion_id){

        $direccion = array();  // creo un array que va a almacenar la informacion del pais

        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "SELECT direcciones.*, personas.cnombres_persona, personas.capellidos_persona, calles.cnombre_calle, barrios.cnombre_barrio, localidades.cnombre_localidad FROM direcciones LEFT JOIN personas ON direcciones.rela_persona_id = personas.persona_id LEFT JOIN calles ON direcciones.rela_calle_id = calles.calle_id LEFT JOIN barrios ON direcciones.rela_barrio_id = barrios.barrio_id LEFT JOIN localidades ON direcciones.rela_localidad_id = localidades.localidad_id WHERE direccion_id = :arg_direccion_id";  // busca un solo registor
        
        $statement = $conexion->prepare($sql);
        
        $statement->bindParam(':arg_direccion_id' , $arg_direccion_id);  // reemplazo los parametros enlazados
        
        if(!$statement){
            echo "Error al crear el registro";
        }else{
            $statement->execute();
        }

        if (!$statement) {
            // no se encontraron paises
        }
        else {
        
            $direccion = $statement->fetch(PDO::FETCH_ASSOC);   // porque es un solo resultado

        }

        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);

        return $direccion;

    }


    function insertar_direccion($arg_cmanzana_direccion, $arg_ccasa_direccion, $arg_csector_direccion, $arg_clote_direccion, $arg_cparcela_direccion, $arg_cdescripcion_direccion, $arg_rela_calle_id, $arg_rela_barrio_id, $arg_rela_localidad_id, $arg_rela_persona_id){
        
        $ultimo_id=0;
       
        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "INSERT INTO direcciones (cmanzana_direccion, ccasa_direccion, csector_direccion, clote_direccion, cparcela_direccion, cdescripcion_direccion, rela_calle_id, rela_barrio_id, rela_localidad_id, rela_persona_id) VALUES (:arg_cmanzana_direccion, :arg_ccasa_direccion, :arg_csector_direccion, :arg_clote_direccion, :arg_cparcela_direccion, :arg_cdescripcion_direccion, :arg_rela_calle_id, :arg_rela_barrio_id, :arg_rela_localidad_id, :arg_rela_persona_id)";
        
        // preparo el sql para enviar   se puede usar prepare   y bindparam 
        $statement = $conexion->prepare($sql);
        
        $statement->bindParam(':arg_cmanzana_direccion' , $arg_cmanzana_direccion);
        $statement->bindParam(':arg_ccasa_direccion' , $arg_ccasa_direccion);
        $statement->bindParam(':arg_csector_direccion' , $arg_csector_direccion);
        $statement->bindParam(':arg_clote_direccion' , $arg_clote_direccion);
        $statement->bindParam(':arg_cparcela_direccion' , $arg_cparcela_direccion);
        $statement->bindParam(':arg_cdescripcion_direccion' , $arg_cdescripcion_direccion);
        $statement->bindParam(':arg_rela_calle_id' , $arg_rela_calle_id);
        $statement->bindParam(':arg_rela_barrio_id' , $arg_rela_barrio_id);
        $statement->bindParam(':arg_rela_localidad_id' , $arg_rela_localidad_id);
        $statement->bindParam(':arg_rela_persona_id' , $arg_rela_persona_id);
        
        if(!$statement){
            echo "Error al crear el registro";
        }else{
            $statement->execute();
        }
        
        $ultimo_id = $conexion->lastinsertid();
        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);

        return $ultimo_id;
    }


    function actualizar_direccion($arg_direccion_id, $arg_cmanzana_direccion, $arg_ccasa_direccion, $arg_csector_direccion, $arg_clote_direccion, $arg_cparcela_direccion, $arg_cdescripcion_direccion, $arg_rela_calle_id, $arg_rela_barrio_id, $arg_rela_localidad_id, $arg_rela_persona_id){

       
        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "UPDATE direcciones set cmanzana_direccion = :arg_cmanzana_direccion, ccasa_direccion = :arg_ccasa_direccion, csector_direccion = :arg_csector_direccion, clote_direccion = :arg_clote_direccion, cparcela_direccion = :arg_cparcela_direccion, cdescripcion_direccion = :arg_cdescripcion_direccion, rela_calle_id = :arg_rela_calle_id, rela_barrio_id = :arg_rela_barrio_id, rela_localidad_id = :arg_rela_localidad_id, rela_persona_id = :arg_rela_persona_id WHERE direccion_id = :arg_direccion_id";
        
        // preparo el sql para enviar   se puede usar prepare   y bindparam 
        $statement = $conexion->prepare($sql);
        
        $statement->bindParam(':arg_direccion_id' , $arg_direccion_id);
        $statement->bindParam(':arg_cmanzana_direccion' , $arg_cmanzana_direccion);
        $statement->bindParam(':arg_ccasa_direccion' , $arg_ccasa_direccion);
        $statement->bindParam(':arg_csector_direccion' , $arg_csector_direccion);
        $statement->bindParam(':arg_clote_direccion' , $arg_clote_direccion);
        $statement->bindParam(':arg_cparcela_direccion' , $arg_cparcela_direccion);
        $statement->bindParam(':arg_cdescripcion_direccion' , $arg_cdescripcion_direccion);
        $statement->bindParam(':arg_rela_calle_id' , $arg_rela_calle_id);
        $statement->bindParam(':arg_rela_barrio_id' , $arg_rela_barrio_id);
        $statement->bindParam(':arg_rela_localidad_id' , $arg_rela_localidad_id);
        $statement->bindParam(':arg_rela_persona_id' , $arg_rela_persona_id);
        
        if(!$statement){
            echo "Error al crear el registro";
        }else{
            $statement->execute();
        }

        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);

    }
    
    
    function eliminar_direccion($arg_direccion_id){
        
       
        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "DELETE FROM direcciones WHERE direccion_id = $arg_direccion_id";
        
        // preparo el sql para enviar   se puede usar prepare   y bindparam 
        $statement = $conexion->query($sql);

        if(!$statement){
            echo "Error al crear el registro";
        }else{
            $statement->execute();
        }

        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);

    }


?> 