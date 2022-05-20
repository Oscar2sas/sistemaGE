<?php 

   
    function buscar_calle($arg_textoabuscar){

        $calles = array();  // creo un array que va a almacenar la informacion de los paises

        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "SELECT * FROM calles"; // busca todas las personas

        if (!empty($arg_textoabuscar)) {
        
            $sql = $sql." WHERE cnombre_calle LIKE :arg_textoabuscar";   // filtra busqueda 

            $arg_textoabuscar="%".TRIM($arg_textoabuscar)."%";
        }

        $sql = $sql." ORDER BY cnombre_calle";  
        
        $statement = $conexion->prepare($sql);
        
        $statement->bindParam(':arg_textoabuscar' , $arg_textoabuscar);  // reemplazo los parametros enlazados 
        
        
        if(!$statement){
            echo "Error al crear el registro";
        }else{
            $statement->execute();
        }

        if (!$statement) {
            // no se encontraron paises
        }
        else {
        
            // reviso el retorno

            while($resultado = $statement->fetch(PDO::FETCH_ASSOC)){

                $calles[] = $resultado;

            }
        }

        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);

        return $calles;

    }

    function buscar_una_calle($arg_calle_id){

        $calle = array();  // creo un array que va a almacenar la informacion del pais

        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "SELECT * FROM calles WHERE calle_id =:arg_calle_id";  // busca un solo registor
        
        $statement = $conexion->prepare($sql);
        
        $statement->bindParam(':arg_calle_id' , $arg_calle_id);  // reemplazo los parametros enlazados 
        
        
        if(!$statement){
            echo "Error al crear el registro";
        }else{
            $statement->execute();
        }

        if (!$statement) {
            // no se encontraron paises
        }
        else {
        
            $calle = $statement->fetch(PDO::FETCH_ASSOC);   // porque es un solo resultado

        }

        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);

        return $calle;

    }


    function insertar_calle($arg_cnombre_calle){

        $ultimo_id=0;
        
        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "INSERT INTO calles (cnombre_calle) VALUES (:arg_cnombre_calle)";
        
        // preparo el sql para enviar   se puede usar prepare   y bindparam 
        $statement = $conexion->prepare($sql);
        
        $statement->bindParam(':arg_cnombre_calle' , $arg_cnombre_calle);  
        
        
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


    function actualizar_calle($arg_calle_id,$arg_cnombre_calle){

       
        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "UPDATE calles set cnombre_calle = :arg_cnombre_calle WHERE calle_id = :arg_calle_id";
        
        
        // preparo el sql para enviar   se puede usar prepare   y bindparam 
        $statement = $conexion->prepare($sql); 

        $statement->bindParam(':arg_cnombre_calle' , $arg_cnombre_calle);   // reemplazo los parametros enlazados 
        $statement->bindParam(':arg_calle_id' , $arg_calle_id);  // reemplazo los parametros enlazados 

        if(!$statement){
            echo "Error al crear el registro";
        }else{
            $statement->execute();
        }

        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);

    }
    
    
    function eliminar_calle($arg_calle_id){

       
        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "DELETE FROM calles WHERE calle_id = $arg_calle_id";
        
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