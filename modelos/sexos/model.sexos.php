<?php 

   
    function buscar_sexos($arg_textoabuscar){

        $sexos = array();  // creo un array que va a almacenar la informacion de los sexos

        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "SELECT sexo_id,cdescripcion_sexo FROM sexos"; // busca todos los sexos

        if (!empty($arg_textoabuscar)) {
        
            $sql = $sql." WHERE cdescripcion_sexo LIKE :arg_textoabuscar";   // filtra busqueda 

            $arg_textoabuscar="%".TRIM($arg_textoabuscar)."%";
        }

        $sql = $sql." ORDER BY cdescripcion_sexo";  
        
        $statement = $conexion->prepare($sql);
        
        $statement->bindParam(':arg_textoabuscar' , $arg_textoabuscar);  // reemplazo los parametros enlazados 
        
        
        if(!$statement){
            echo "Error al crear el registro";
        }else{
            $statement->execute();
        }

        if (!$statement) {
            // no se encontraron sexos
        }
        else {
        
            // reviso el retorno

            while($resultado = $statement->fetch(PDO::FETCH_ASSOC)){

                $sexos[] = $resultado;

            }
        }

        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);

        return $sexos;

    }

    function buscar_un_sexo($arg_sexo_id){

        $sexo = array();  // creo un array que va a almacenar la informacion del sexo

        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "SELECT sexo_id,cdescripcion_sexo FROM sexos WHERE sexo_id =:arg_sexo_id";  // busca un solo registor
        
        $statement = $conexion->prepare($sql);
        
        $statement->bindParam(':arg_sexo_id' , $arg_sexo_id);  // reemplazo los parametros enlazados 
        
        
        if(!$statement){
            echo "Error al crear el registro";
        }else{
            $statement->execute();
        }

        if (!$statement) {
            // no se encontraron sexos
        }
        else {
        
            $sexo = $statement->fetch(PDO::FETCH_ASSOC);   // porque es un solo resultado
           
            if (!$sexo) { // si el valor es falso
                $sexo = array();  // vuelvo a crear un array que va a almacenar la informacion del sexo
            }

        }

        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);

        return $sexo;

    }


    function insertar_sexo($arg_cdescripcion_sexo){

        $ultimo_id=0;
       
        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "INSERT INTO sexos (cdescripcion_sexo) VALUES (:arg_cdescripcion_sexo)";
        
        // preparo el sql para enviar   se puede usar prepare   y bindparam 
        $statement = $conexion->prepare($sql);
        
        $statement->bindParam(':arg_cdescripcion_sexo' , $arg_cdescripcion_sexo);  // reemplazo los parametros enlazados 
        
        
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


    function actualizar_sexo($arg_sexo_id,$arg_cdescripcion_sexo){

       
        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "UPDATE sexos set cdescripcion_sexo = :arg_cdescripcion_sexo WHERE sexo_id = :arg_sexo_id";
        
        // preparo el sql para enviar   se puede usar prepare   y bindparam 
        $statement = $conexion->prepare($sql);
        
        $statement->bindParam(':arg_cdescripcion_sexo' , $arg_cdescripcion_sexo);  // reemplazo los parametros enlazados 
        $statement->bindParam(':arg_sexo_id' , $arg_sexo_id);  // reemplazo los parametros enlazados   
        
        if(!$statement){
            echo "Error al crear el registro";
        }else{
            $statement->execute();
        }

        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);

    }
    
    
    function eliminar_sexo($arg_sexo_id){

       
        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "DELETE FROM sexos WHERE sexo_id = :arg_sexo_id";
        
        // preparo el sql para enviar   se puede usar prepare   y bindparam 
        $statement = $conexion->prepare($sql);
        
        $statement->bindParam(':arg_sexo_id' , $arg_sexo_id);  // reemplazo los parametros enlazados   
        
        if(!$statement){
            echo "Error al crear el registro";
        }else{
            $statement->execute();
        }

        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);

    }

    // funciones para control de duplicados y otros

    function buscar_un_sexo_por($arg_condicion_busqueda,$arg_sexo_id){

        $sexo = array();  // creo un array que va a almacenar la informacion del sexo

        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "SELECT sexo_id FROM sexos WHERE ".$arg_condicion_busqueda;
       
        $sql = $sql ." AND sexo_id <> :arg_sexo_id ";  // busca un solo registro

        // preparo el sql para enviar   se puede usar prepare   y bindparam 
        $statement = $conexion->prepare($sql);
                
        $statement->bindParam(':arg_sexo_id' , $arg_sexo_id);  // reemplazo los parametros enlazados   
        
        if(!$statement){
            echo "Error al crear el registro";
        }else{
            $statement->execute();
        }

        if (!$statement) {
            // no se encontraron sexos
        }
        else {
        
            $sexo = $statement->fetch(PDO::FETCH_ASSOC);   // porque es un solo resultado

            if (!$sexo) { // si el valor es falso
                $sexo = array();  // vuelvo a crear un array que va a almacenar la informacion del sexo
            }

        }
        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);

        return $sexo;

    }

?> 