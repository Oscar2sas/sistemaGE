<?php 


    function buscar_documentos($arg_textoabuscar){

        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "SELECT * FROM documentos_personas,personas,tipos_documentos WHERE documentos_personas.rela_tipodocumento_id = tipos_documentos.tipodocumento_id AND documentos_personas.rela_persona_id = personas.persona_id ";   // busca todos los usuarios

        if (!empty($arg_textoabuscar)) {
        
            $sql = $sql." AND (cnombres_persona LIKE :arg_textoabuscar OR capellidos_persona LIKE :arg_textoabuscar OR cdescripcion_tipodocumento LIKE :arg_textoabuscar)";   // filtra busqueda 

            $arg_textoabuscar="%".TRIM($arg_textoabuscar)."%";
        }

        $sql = $sql." ORDER BY cnombres_persona";   
        
        //$statement = $conexion->query($sql);
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
        
            $documentos = array();  // creo un array que va a almacenar la informacion de los documentos

            // reviso el retorno
    
            while($resultado = $statement->fetch(PDO::FETCH_ASSOC)){
    
                $documentos[] = $resultado;
    
            }
        }

        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);

        return $documentos;

    }



    function buscar_un_documento($arg_documento_id){

        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "SELECT * FROM documentos_personas,personas,tipos_documentos WHERE documentos_personas.rela_tipodocumento_id = tipos_documentos.tipodocumento_id AND documentos_personas.rela_persona_id = personas.persona_id AND documentos_personas.documento_id = :arg_documento_id"; //Busca el usuario

        //$statement = $conexion->query($sql);
        $statement = $conexion->prepare($sql);
        
        $statement->bindParam(':arg_documento_id' , $arg_documento_id);  // reemplazo los parametros enlazados 


        if(!$statement){
            echo "Error al crear el registro";
        }else{
            $statement->execute();
        }

        if (!$statement) {
            // no se encontraron usuarios
        }
        else {
        
            $documento = $statement->fetch(PDO::FETCH_ASSOC);
        }

        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);

        return $documento;

    }
    

    function insertar_documento($array){
        $ultimo_id=0;
       
        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        //$sql = "INSERT INTO paises (cnombre_pais) VALUES (:arg_cnombre_pais)";
        $sql = "INSERT INTO `documentos_personas`(`rela_tipodocumento_id`, `rela_persona_id`, `cimg_documento`) VALUES (:arg_rela_tipodocumento_id, :arg_rela_persona_id, :arg_cimg_documento)";
        
        // preparo el sql para enviar   se puede usar prepare   y bindparam 
        $statement = $conexion->prepare($sql);
        
        
        $statement->bindParam(':arg_cimg_documento' , $array['cimg_documento']);
        $statement->bindParam(':arg_rela_persona_id' , $array['rela_persona_id']);  // reemplazo los parametros enlazados 
        $statement->bindParam(':arg_rela_tipodocumento_id' , $array['rela_tipodocumento_id']);
        
        
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

    function actualizar_documento($array){

       
        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "UPDATE `documentos_personas` SET `rela_tipodocumento_id`= :arg_rela_tipodocumento_id, `rela_persona_id`= :arg_rela_persona_id";

        if( $array['cimg_documento'] != '' ){
            $sql = $sql.", `cimg_documento`= :arg_cimg_documento";
        }

        $sql = $sql." WHERE documentos_personas.documento_id = :arg_documento_id";
        
        // preparo el sql para enviar   se puede usar prepare   y bindparam 
        $statement = $conexion->prepare($sql);
        
        $statement->bindParam(':arg_documento_id' , $array['documento_id']);
        $statement->bindParam(':arg_rela_tipodocumento_id' , $array['rela_tipodocumento_id']);  // reemplazo los parametros enlazados 
        $statement->bindParam(':arg_rela_persona_id' , $array['rela_persona_id']);  // reemplazo los parametros enlazados 

        if( $array['cimg_documento'] != '' ){
            $statement->bindParam(':arg_cimg_documento' , $array['cimg_documento']);
        }
        
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


    function eliminar_documento($arg_documento_id){

       
        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "DELETE FROM `documentos_personas` WHERE documento_id = :arg_documento_id";
        
        // preparo el sql para enviar   se puede usar prepare   y bindparam 
        $statement = $conexion->prepare($sql);
        
        $statement->bindParam(':arg_documento_id' , $arg_documento_id);  // reemplazo los parametros enlazados   
        
        if(!$statement){
            echo "Error al crear el registro";
        }else{
            $statement->execute();
        }

        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);

    }


?> 