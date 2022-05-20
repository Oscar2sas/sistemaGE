<?php 

   
    function buscar_barrios($arg_textoabuscar){

        $barrios = array();  // creo un array que va a almacenar la informacion de los paises

        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "SELECT barrio_id,cnombre_barrio FROM barrios"; // busca todos loa paises

        if (!empty($arg_textoabuscar)) {
        
            $sql = $sql." WHERE cnombre_barrio LIKE :arg_textoabuscar";   // filtra busqueda 

            $arg_textoabuscar="%".TRIM($arg_textoabuscar)."%";
        }

        $sql = $sql." ORDER BY cnombre_barrio";  
        
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

                $barrios[] = $resultado;

            }
        }

        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);

        return $barrios;

    }

    function buscar_un_barrio($arg_barrio_id){

        $pais = array();  // creo un array que va a almacenar la informacion del pais

        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "SELECT barrio_id,cnombre_barrio FROM barrios WHERE barrio_id =:arg_barrio_id";  // busca un solo registor
        
        $statement = $conexion->prepare($sql);
        
        $statement->bindParam(':arg_barrio_id' , $arg_barrio_id);  // reemplazo los parametros enlazados 
        
        
        if(!$statement){
            echo "Error al crear el registro";
        }else{
            $statement->execute();
        }

        if (!$statement) {
            // no se encontraron paises
        }
        else {
        
            $barrio = $statement->fetch(PDO::FETCH_ASSOC);   // porque es un solo resultado

        }

        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);

        return $barrio;

    }


    function insertar_barrio($arg_cnombre_barrio){

        $ultimo_id=0;
       
        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "INSERT INTO barrios (cnombre_barrio) VALUES (:arg_cnombre_barrio)";
        
        // preparo el sql para enviar   se puede usar prepare   y bindparam 
        $statement = $conexion->prepare($sql);
        
        $statement->bindParam(':arg_cnombre_barrio' , $arg_cnombre_barrio);  // reemplazo los parametros enlazados 
        
        
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


    function actualizar_barrio($arg_barrio_id,$arg_cnombre_barrio){

       
        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "UPDATE barrios set cnombre_barrio = :arg_cnombre_barrio WHERE barrio_id = :arg_barrio_id";
        
        // preparo el sql para enviar   se puede usar prepare   y bindparam 
        $statement = $conexion->prepare($sql);
        
        $statement->bindParam(':arg_cnombre_barrio' , $arg_cnombre_barrio);  // reemplazo los parametros enlazados 
        $statement->bindParam(':arg_barrio_id' , $arg_barrio_id);  // reemplazo los parametros enlazados   
        
        if(!$statement){
            echo "Error al crear el registro";
        }else{
            $statement->execute();
        }

        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);

    }
    
    
    function eliminar_barrio($arg_barrio_id){

       
        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "DELETE FROM barrios WHERE barrio_id = :arg_barrio_id";
        
        // preparo el sql para enviar   se puede usar prepare   y bindparam 
        $statement = $conexion->prepare($sql);
        
        $statement->bindParam(':arg_barrio_id' , $arg_barrio_id);  // reemplazo los parametros enlazados   
        
        if(!$statement){
            echo "Error al crear el registro";
        }else{
            $statement->execute();
        }

        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);

    }


?> 