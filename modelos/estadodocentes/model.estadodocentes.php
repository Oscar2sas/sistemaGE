<?php 

   
    function buscar_estadodocentes($arg_textoabuscar){

        $estadodocentes = array();  // creo un array que va a almacenar la informacion de los estados de los docentes

        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "SELECT estadodocente_id,cdescripcion_estadodocente FROM estado_docentes"; // busca todos los estados de los docentes

        if (!empty($arg_textoabuscar)) {
        
            $sql = $sql." WHERE cdescripcion_estadodocente LIKE :arg_textoabuscar";   // filtra busqueda 

            $arg_textoabuscar="%".TRIM($arg_textoabuscar)."%";
        }

        $sql = $sql." ORDER BY cdescripcion_estadodocente";  
        
        $statement = $conexion->prepare($sql);
        
        $statement->bindParam(':arg_textoabuscar' , $arg_textoabuscar);  // reemplazo los parametros enlazados 
        
        
        if(!$statement){
            echo "Error al crear el registro";
        }else{
            $statement->execute();
        }

        if (!$statement) {
            // no se encontraron estadodocentes
        }
        else {
        
            // reviso el retorno

            while($resultado = $statement->fetch(PDO::FETCH_ASSOC)){

                $estadodocentes[] = $resultado;

            }
        }

        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);

        return $estadodocentes;

    }

    function buscar_un_estadodocente($arg_estadodocente_id){

        $estadodocente = array();  // creo un array que va a almacenar la informacion del estadodocente

        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "SELECT estadodocente_id,cdescripcion_estadodocente FROM estado_docentes WHERE estadodocente_id =:arg_estadodocente_id";  // busca un solo registro
        
        $statement = $conexion->prepare($sql);
        
        $statement->bindParam(':arg_estadodocente_id' , $arg_estadodocente_id);  // reemplazo los parametros enlazados 
        
        
        if(!$statement){
            echo "Error al crear el registro";
        }else{
            $statement->execute();
        }

        if (!$statement) {
            // no se encontraron estadodocentes
        }
        else {
        
            $estadodocente = $statement->fetch(PDO::FETCH_ASSOC);   // porque es un solo resultado
           
            if (!$estadodocente) { // si el valor es falso
                $estadodocente = array();  // vuelvo a crear un array que va a almacenar la informacion del estadodocente
            }

        }

        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);

        return $estadodocente;

    }


    function insertar_estadodocente($arg_cdescripcion_estadodocente){

        $ultimo_id=0;
       
        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "INSERT INTO estado_docentes (cdescripcion_estadodocente) VALUES (:arg_cdescripcion_estadodocente)";
        
        // preparo el sql para enviar   se puede usar prepare   y bindparam 
        $statement = $conexion->prepare($sql);
        
        $statement->bindParam(':arg_cdescripcion_estadodocente' , $arg_cdescripcion_estadodocente);  // reemplazo los parametros enlazados 
        
        
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


    function actualizar_estadodocente($arg_estadodocente_id,$arg_cdescripcion_estadodocente){

       
        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "UPDATE estado_docentes set cdescripcion_estadodocente = :arg_cdescripcion_estadodocente WHERE estadodocente_id = :arg_estadodocente_id";
        
        // preparo el sql para enviar   se puede usar prepare   y bindparam 
        $statement = $conexion->prepare($sql);
        
        $statement->bindParam(':arg_cdescripcion_estadodocente' , $arg_cdescripcion_estadodocente);  // reemplazo los parametros enlazados 
        $statement->bindParam(':arg_estadodocente_id' , $arg_estadodocente_id);  // reemplazo los parametros enlazados   
        
        if(!$statement){
            echo "Error al crear el registro";
        }else{
            $statement->execute();
        }

        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);

    }
    
    
    function eliminar_estadodocente($arg_estadodocente_id){

       
        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "DELETE FROM estado_docentes WHERE estadodocente_id = :arg_estadodocente_id";
        
        // preparo el sql para enviar   se puede usar prepare   y bindparam 
        $statement = $conexion->prepare($sql);
        
        $statement->bindParam(':arg_estadodocente_id' , $arg_estadodocente_id);  // reemplazo los parametros enlazados   
        
        if(!$statement){
            echo "Error al crear el registro";
        }else{
            $statement->execute();
        }

        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);

    }

    // funciones para control de duplicados y otros

    function buscar_un_estadodocente_por($arg_condicion_busqueda,$arg_estadodocente_id){

        $estadodocente = array();  // creo un array que va a almacenar la informacion del estadodocente

        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "SELECT estadodocente_id FROM estado_docentes WHERE ".$arg_condicion_busqueda;
      
        $sql = $sql ." AND estadodocente_id <> :arg_estadodocente_id ";  // busca un solo registro

        // preparo el sql para enviar   se puede usar prepare   y bindparam 
        $statement = $conexion->prepare($sql);
                
        $statement->bindParam(':arg_estadodocente_id' , $arg_estadodocente_id);  // reemplazo los parametros enlazados   
        
        if(!$statement){
            echo "Error al crear el registro";
        }else{
            $statement->execute();
        }

        if (!$statement) {
            // no se encontraron estadodocentes
        }
        else {
        
            $estadodocente = $statement->fetch(PDO::FETCH_ASSOC);   // porque es un solo resultado

            if (!$estadodocente) { // si el valor es falso
                $estadodocente = array();  // vuelvo a crear un array que va a almacenar la informacion del estadodocente
            }

        }
        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);

        return $estadodocente;

    }

?> 