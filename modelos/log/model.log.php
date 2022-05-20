<?php 

 
    function buscar_log($arg_textoabuscar,$arg_fechabuscar){

        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "SELECT `log_id`, `dfecha_log`, `chora_log`, `cdescripcion_log`, `rela_usuario_id`, `cnombre_usuario` FROM `log`,`usuarios` WHERE log.rela_usuario_id = usuarios.usuario_id AND dfecha_log = :arg_fechabuscar"; // busca todos los logs

        if (!empty($arg_textoabuscar)) {
        
            $sql = $sql." AND (cdescripcion_log LIKE :arg_textoabuscar OR cnombre_usuario LIKE :arg_textoabuscar)";   // filtra busqueda 

            $arg_textoabuscar="%".TRIM($arg_textoabuscar)."%";
        }
        
        //$statement = $conexion->query($sql);
        $statement = $conexion->prepare($sql);

        
        if (!empty($arg_textoabuscar)) {
            $statement->bindParam(':arg_textoabuscar' , $arg_textoabuscar);  // reemplazo los parametros enlazados 
        }
        $statement->bindParam(':arg_fechabuscar' , $arg_fechabuscar);  // reemplazo los parametros enlazados 
    

        if(!$statement){
            echo "Error al crear el registro";
        }else{
            $statement->execute();
        }

        if (!$statement) {
            // no se encontraron paises
        }
        else {
        
            $logs = array();  // creo un array que va a almacenar la informacion de los logs

            // reviso el retorno
    
            while($resultado = $statement->fetch(PDO::FETCH_ASSOC)){
    
                $logs[] = $resultado;
    
            }
        }

        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);

        return $logs;
      
    }

    function buscar_un_log($arg_log_id){

        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "SELECT `log_id`, `dfecha_log`, `chora_log`, `cdescripcion_log`, `rela_usuario_id`, `cnombre_usuario` FROM `log`,`usuarios` WHERE usuarios.usuario_id = rela_usuario_id AND log.log_id = :arg_log_id "; //Busca el usuario
        
        //$statement = $conexion->query($sql);
        $statement = $conexion->prepare($sql);
        
        $statement->bindParam(':arg_log_id' , $arg_log_id);  // reemplazo los parametros enlazados 


        if(!$statement){
            echo "Error al crear el registro";
        }else{
            $statement->execute();
        }

        if (!$statement) {
            // no se encontraron datos
        }
        else {
        
            $log = $statement->fetch(PDO::FETCH_ASSOC);
        }

        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);

        return $log;
   
    }


    function insertar_log($arg_cdescripcion_log){

        //preparo las variables del log

        $dfecha_log=date("Y/m/d");
        $chora_log=date( "H:i:s",time());
        $usuario_id=$_SESSION['usuario_id']; 

       
        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "INSERT INTO log (dfecha_log,chora_log,cdescripcion_log,rela_usuario_id) VALUES
             (:arg_dfecha_log,:arg_chora_log,:arg_cdescripcion_log,:arg_rela_usuario_id)";
        
        // preparo el sql para enviar   se puede usar prepare   y bindparam 
        $statement = $conexion->prepare($sql);
        
        $statement->bindParam(':arg_dfecha_log' , $dfecha_log);  // reemplazo los parametros enlazados 
        $statement->bindParam(':arg_chora_log' , $chora_log);  // reemplazo los parametros enlazados 
        $statement->bindParam(':arg_cdescripcion_log' , $arg_cdescripcion_log);  // reemplazo los parametros enlazados 
        $statement->bindParam(':arg_rela_usuario_id' , $usuario_id);  // reemplazo los parametros enlazados 
             
        
        if(!$statement){
            echo "Error al crear el registro";
        }else{
            $statement->execute();
        }

        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);

    }

    function insertar_user_log($arg_cdescripcion_log,$arg_usuario){

        //preparo las variables del log

        $dfecha_log=date("y/m/d");
        $chora_log=date( "H:i:s",time());
        $usuario_id=$arg_usuario;

       
        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "INSERT INTO log (dfecha_log,chora_log,cdescripcion_log,rela_usuario_id) VALUES
             (:arg_dfecha_log,:arg_chora_log,:arg_cdescripcion_log,:arg_rela_usuario_id)";
        
        // preparo el sql para enviar   se puede usar prepare   y bindparam 
        $statement = $conexion->prepare($sql);
        
        $statement->bindParam(':arg_dfecha_log' , $dfecha_log);  // reemplazo los parametros enlazados 
        $statement->bindParam(':arg_chora_log' , $chora_log);  // reemplazo los parametros enlazados 
        $statement->bindParam(':arg_cdescripcion_log' , $arg_cdescripcion_log);  // reemplazo los parametros enlazados 
        $statement->bindParam(':arg_rela_usuario_id' , $usuario_id);  // reemplazo los parametros enlazados 
             
        
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



    function actualizar_log($arg_log_id,$arg_cdescripcion_log){
        //preparo las variables del log

        $dfecha_log=date("Y/m/d");
        $chora_log=date( "H:i:s",time());
        $usuario_id=$_SESSION['usuario_id']; 

       
        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "UPDATE `log` SET `dfecha_log`=:arg_dfecha_log, `chora_log`=:arg_chora_log, `cdescripcion_log`=:arg_cdescripcion_log, `rela_usuario_id`=:arg_rela_usuario_id WHERE log_id = :arg_log_id ";
        
        // preparo el sql para enviar   se puede usar prepare   y bindparam 
        $statement = $conexion->prepare($sql);
        
        $statement->bindParam(':arg_dfecha_log' , $dfecha_log);  // reemplazo los parametros enlazados 
        $statement->bindParam(':arg_chora_log' , $chora_log);  // reemplazo los parametros enlazados 
        $statement->bindParam(':arg_cdescripcion_log' , $arg_cdescripcion_log);  // reemplazo los parametros enlazados 
        $statement->bindParam(':arg_rela_usuario_id' , $usuario_id);  // reemplazo los parametros enlazados 
        $statement->bindParam(':arg_log_id' , $arg_log_id);  // reemplazo los parametros enlazados 
             
        
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
    
    
    function eliminar_log($arg_log_id){
        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "DELETE FROM log WHERE log_id = :arg_log_id";
        
        // preparo el sql para enviar   se puede usar prepare   y bindparam 
        $statement = $conexion->prepare($sql);
        
        $statement->bindParam(':arg_log_id' , $arg_log_id);  // reemplazo los parametros enlazados   
        
        if(!$statement){
            echo "Error al crear el registro";
        }else{
            $statement->execute();
        }

        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);
    
    }


?> 