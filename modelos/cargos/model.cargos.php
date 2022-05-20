<?php 

   
    function buscar_cargos($arg_textoabuscar){

        $cargos = array();  // creo un array que va a almacenar la informacion de los cargos

        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "SELECT cargo_id,cdescripcion_cargo FROM cargos"; // busca todos los cargos

        if (!empty($arg_textoabuscar)) {
        
            $sql = $sql." WHERE cdescripcion_cargo LIKE :arg_textoabuscar";   // filtra busqueda 

            $arg_textoabuscar="%".TRIM($arg_textoabuscar)."%";
        }

        $sql = $sql." ORDER BY cdescripcion_cargo";  
        
        $statement = $conexion->prepare($sql);
        
        $statement->bindParam(':arg_textoabuscar' , $arg_textoabuscar);  // reemplazo los parametros enlazados 
        
        
        if(!$statement){
            echo "Error al crear el registro";
        }else{
            $statement->execute();
        }

        if (!$statement) {
            // no se encontraron cargos
        }
        else {
        
            // reviso el retorno

            while($resultado = $statement->fetch(PDO::FETCH_ASSOC)){

                $cargos[] = $resultado;

            }
        }

        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);

        return $cargos;

    }

    function buscar_un_cargo($arg_cargo_id){

        $cargo = array();  // creo un array que va a almacenar la informacion del cargo

        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "SELECT cargo_id,cdescripcion_cargo FROM cargos WHERE cargo_id =:arg_cargo_id";  // busca un solo registro
        
        $statement = $conexion->prepare($sql);
        
        $statement->bindParam(':arg_cargo_id' , $arg_cargo_id);  // reemplazo los parametros enlazados 
        
        
        if(!$statement){
            echo "Error al crear el registro";
        }else{
            $statement->execute();
        }

        if (!$statement) {
            // no se encontraron cargos
        }
        else {
        
            $cargo = $statement->fetch(PDO::FETCH_ASSOC);   // porque es un solo resultado
           
            if (!$cargo) { // si el valor es falso
                $cargo = array();  // vuelvo a crear un array que va a almacenar la informacion del cargo
            }

        }

        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);

        return $cargo;

    }


    function insertar_cargo($arg_cdescripcion_cargo){

        $ultimo_id=0;
       
        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "INSERT INTO cargos (cdescripcion_cargo) VALUES (:arg_cdescripcion_cargo)";
        
        // preparo el sql para enviar   se puede usar prepare   y bindparam 
        $statement = $conexion->prepare($sql);
        
        $statement->bindParam(':arg_cdescripcion_cargo' , $arg_cdescripcion_cargo);  // reemplazo los parametros enlazados 
        
        
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


    function actualizar_cargo($arg_cargo_id,$arg_cdescripcion_cargo){

       
        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "UPDATE cargos set cdescripcion_cargo = :arg_cdescripcion_cargo WHERE cargo_id = :arg_cargo_id";
        
        // preparo el sql para enviar   se puede usar prepare   y bindparam 
        $statement = $conexion->prepare($sql);
        
        $statement->bindParam(':arg_cdescripcion_cargo' , $arg_cdescripcion_cargo);  // reemplazo los parametros enlazados 
        $statement->bindParam(':arg_cargo_id' , $arg_cargo_id);  // reemplazo los parametros enlazados   
        
        if(!$statement){
            echo "Error al crear el registro";
        }else{
            $statement->execute();
        }

        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);

    }
    
    
    function eliminar_cargo($arg_cargo_id){

       
        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "DELETE FROM cargos WHERE cargo_id = :arg_cargo_id";
        
        // preparo el sql para enviar   se puede usar prepare   y bindparam 
        $statement = $conexion->prepare($sql);
        
        $statement->bindParam(':arg_cargo_id' , $arg_cargo_id);  // reemplazo los parametros enlazados   
        
        if(!$statement){
            echo "Error al crear el registro";
        }else{
            $statement->execute();
        }

        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);

    }

    // funciones para control de duplicados y otros

    function buscar_un_cargo_por($arg_condicion_busqueda,$arg_cargo_id){

        $cargo = array();  // creo un array que va a almacenar la informacion del cargo

        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "SELECT cargo_id FROM cargos WHERE ".$arg_condicion_busqueda;
       
        $sql = $sql ." AND cargo_id <> :arg_cargo_id ";  // busca un solo registro

        // preparo el sql para enviar   se puede usar prepare   y bindparam 
        $statement = $conexion->prepare($sql);
                
        $statement->bindParam(':arg_cargo_id' , $arg_cargo_id);  // reemplazo los parametros enlazados   
        
        if(!$statement){
            echo "Error al crear el registro";
        }else{
            $statement->execute();
        }

        if (!$statement) {
            // no se encontraron cargos
        }
        else {
        
            $cargo = $statement->fetch(PDO::FETCH_ASSOC);   // porque es un solo resultado

            if (!$cargo) { // si el valor es falso
                $cargo = array();  // vuelvo a crear un array que va a almacenar la informacion del cargo
            }

        }
        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);

        return $cargo;

    }

?> 