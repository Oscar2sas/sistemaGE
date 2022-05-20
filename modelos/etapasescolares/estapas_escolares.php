<?php 

   
    function buscar_etapas_escolares($arg_textoabuscar){

        $etapas = array();  // creo un array que va a almacenar la informacion de los paises

        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "SELECT etapaescolar_id,cdescripcion_etapa FROM etapas_escolares"; // busca todas las etapas

        if (!empty($arg_textoabuscar)) {
        
            $sql = $sql." WHERE cdescripcion_etapa LIKE :arg_textoabuscar";   // filtra busqueda 

            $arg_textoabuscar="%".TRIM($arg_textoabuscar)."%";
        }

        $sql = $sql." ORDER BY cdescripcion_etapa";  
        
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

                $etapas[] = $resultado;

            }
        }

        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);

        return $etapas;

    }

    function buscar_una_etapa($arg_etapaescolar_id){

        $etapas = array();  // creo un array que va a almacenar la informacion de la etapa

        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "SELECT etapaescolar_id,cdescripcion_etapa FROM etapas_escolares WHERE etapaescolar_id =:arg_etapaescolar_id";  // busca un solo registor
        
        $statement = $conexion->prepare($sql);
        
        $statement->bindParam(':arg_etapaescolar_id' , $arg_etapaescolar_id);  // reemplazo los parametros enlazados 
        
        
        if(!$statement){
            echo "Error al crear el registro";
        }else{
            $statement->execute();
        }

        if (!$statement) {
            // no se encontraron 
        }
        else {
        
            $etapas = $statement->fetch(PDO::FETCH_ASSOC);   // porque es un solo resultado
           
            if (!$etapas) { // si el valor es falso
                $etapas = array();  // vuelvo a crear un array que va a almacenar la informacion del pais
            }

        }

        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);

        return $etapas;

    }


    function insertar_etapa($arg_cdescripcion_etapa){

        $ultimo_id=0;
       
        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "INSERT INTO etapas_escolares (cdescripcion_etapa) VALUES (:arg_cdescripcion_etapa)";
        
        // preparo el sql para enviar   se puede usar prepare   y bindparam 
        $statement = $conexion->prepare($sql);
        
        $statement->bindParam(':arg_cdescripcion_etapa' , $arg_cdescripcion_etapa);  // reemplazo los parametros enlazados 
        
        
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


    function actualizar_etapa($arg_etapaescolar_id,$arg_cdescripcion_etapa){

       
        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "UPDATE etapas_escolares set cdescripcion_etapa = :arg_cdescripcion_etapa WHERE etapaescolar_id = :arg_etapaescolar_id";
        
        // preparo el sql para enviar   se puede usar prepare   y bindparam 
        $statement = $conexion->prepare($sql);
        
        $statement->bindParam(':arg_cdescripcion_etapa' , $arg_cdescripcion_etapa);  // reemplazo los parametros enlazados 
        $statement->bindParam(':arg_etapaescolar_id' , $arg_etapaescolar_id);  // reemplazo los parametros enlazados   
        
        if(!$statement){
            echo "Error al crear el registro";
        }else{
            $statement->execute();
        }

        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);

   }
    
    
    function eliminar_etapa($arg_etapaescolar_id){

       
        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "DELETE FROM etapas_escolares WHERE etapaescolar_id = :arg_etapaescolar_id";
        
        // preparo el sql para enviar   se puede usar prepare   y bindparam 
        $statement = $conexion->prepare($sql);
        
        $statement->bindParam(':arg_etapaescolar_id' , $arg_etapaescolar_id);  // reemplazo los parametros enlazados   
        
        if(!$statement){
            echo "Error al crear el registro";
        }else{
            $statement->execute();
        }

        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);

    }

    // funciones para control de duplicados y otros

    function buscar_una_etapa_por($arg_condicion_busqueda,$arg_etapaescolar_id){

        $pais = array();  // creo un array que va a almacenar la informacion del pais

        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "SELECT etapaescolar_id FROM etapas_escolares WHERE ".$arg_condicion_busqueda;
       
        $sql = $sql ." AND etapaescolar_id <> :arg_etapaescolar_id ";  // busca un solo registro

        // preparo el sql para enviar   se puede usar prepare   y bindparam 
        $statement = $conexion->prepare($sql);
                
        $statement->bindParam(':arg_etapaescolar_id' , $arg_etapaescolar_id);  // reemplazo los parametros enlazados   
        
        if(!$statement){
            echo "Error al crear el registro";
        }else{
            $statement->execute();
        }

        if (!$statement) {
            // no se encontraron paises
        }
        else {
        
            $etapas = $statement->fetch(PDO::FETCH_ASSOC);   // porque es un solo resultado

            if (!$etapas) { // si el valor es falso
                $etapas = array();  // vuelvo a crear un array que va a almacenar la informacion del pais
            }

        }
        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);

        return $etapas;

    }

?> 