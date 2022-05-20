<?php 

   
    function buscar_tiposdoc($arg_textoabuscar){

        $tiposdoc = array();  // creo un array que va a almacenar la informacion de los paises

        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "SELECT * FROM tipos_documentos"; // busca todos loa paises

        if (!empty($arg_textoabuscar)) {
        
            $sql = $sql." WHERE cdescripcion_tipodocumento	 LIKE :arg_textoabuscar";   // filtra busqueda 

            $arg_textoabuscar="%".TRIM($arg_textoabuscar)."%";
        }

        $sql = $sql." ORDER BY cdescripcion_tipodocumento";  
        
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

                $tiposdoc[] = $resultado;

            }
        }

        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);

        return $tiposdoc;

    }

    function buscar_un_tipodoc($arg_tipodoc_id){

        $tipodoc = array();  // creo un array que va a almacenar la informacion del pais

        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "SELECT * FROM tipos_documentos WHERE tipodocumento_id =:arg_rol_id";  // busca un solo registor
        
        $statement = $conexion->prepare($sql);
        
        $statement->bindParam(':arg_rol_id' , $arg_tipodoc_id);  // reemplazo los parametros enlazados 
        
        
        if(!$statement){
            echo "Error al crear el registro";
        }else{
            $statement->execute();
        }

        if (!$statement) {
            // no se encontraron paises
        }
        else {
        
            $tipodoc = $statement->fetch(PDO::FETCH_ASSOC);   // porque es un solo resultado

        }

        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);

        return $tipodoc;

    }


    function insertar_tipodoc($arg_cdescripcion_tipodocumento,$arg_ccarpeta_documento){

        $ultimo_id=0;
       
        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();


        $sql = "INSERT INTO tipos_documentos (cdescripcion_tipodocumento,ccarpeta_documento) VALUES (:arg_cdescripcion_tipodocumento,:arg_ccarpeta_documento)";
        
        // preparo el sql para enviar   se puede usar prepare   y bindparam 
        $statement = $conexion->prepare($sql);
        
        $statement->bindParam(':arg_cdescripcion_tipodocumento' , $arg_cdescripcion_tipodocumento);  // reemplazo los parametros enlazados 
        $statement->bindParam(':arg_ccarpeta_documento' , $arg_ccarpeta_documento);  // reemplazo los parametros enlazados 
        
        
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


    function actualizar_tipodoc($arg_tipodoc_id,$arg_cdescripcion_tipodocumento,$arg_ccarpeta_documento){

       
        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "UPDATE tipos_documentos set cdescripcion_tipodocumento = :arg_cdescripcion_tipodocumento, ccarpeta_documento = :arg_ccarpeta_documento  WHERE tipodocumento_id = :arg_tipodocumento_id";
        
        // preparo el sql para enviar   se puede usar prepare   y bindparam 
        $statement = $conexion->prepare($sql);
        
        $statement->bindParam(':arg_cdescripcion_tipodocumento' , $arg_cdescripcion_tipodocumento);  // reemplazo los parametros enlazados 
        $statement->bindParam(':arg_ccarpeta_documento' , $arg_ccarpeta_documento);  // reemplazo los parametros enlazados
        $statement->bindParam(':arg_tipodocumento_id' , $arg_tipodoc_id);  // reemplazo los parametros enlazados   
        
        if(!$statement){
            echo "Error al crear el registro";
        }else{
            $statement->execute();
        }

        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);

    }
    
    
    function eliminar_tipodoc($arg_tipodoc_id){

       
        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "DELETE FROM `tipos_documentos` WHERE tipodocumento_id = :arg_tipodocumento_id";
        
        // preparo el sql para enviar   se puede usar prepare   y bindparam 
        $statement = $conexion->prepare($sql);
        
        $statement->bindParam(':arg_tipodocumento_id' , $arg_tipodoc_id);  // reemplazo los parametros enlazados   
        
        if(!$statement){
            echo "Error al crear el registro";
        }else{
            $statement->execute();
        }

        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);

    }


?> 