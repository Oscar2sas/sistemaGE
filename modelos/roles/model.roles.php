<?php 

   
    function buscar_roles($arg_textoabuscar){

        $roles = array();  // creo un array que va a almacenar la informacion de los paises

        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "SELECT rol_id,cdescripcion_rol FROM roles"; // busca todos loa paises

        if (!empty($arg_textoabuscar)) {
        
            $sql = $sql." WHERE cdescripcion_rol LIKE :arg_textoabuscar";   // filtra busqueda 

            $arg_textoabuscar="%".TRIM($arg_textoabuscar)."%";
        }

        $sql = $sql." ORDER BY cdescripcion_rol";  
        
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

                $roles[] = $resultado;

            }
        }

        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);

        return $roles;

    }

    function buscar_un_rol($arg_rol_id){

        $rol = array();  // creo un array que va a almacenar la informacion del pais

        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "SELECT rol_id,cdescripcion_rol FROM roles WHERE rol_id =:arg_rol_id";  // busca un solo registor
        
        $statement = $conexion->prepare($sql);
        
        $statement->bindParam(':arg_rol_id' , $arg_rol_id);  // reemplazo los parametros enlazados 
        
        
        if(!$statement){
            echo "Error al crear el registro";
        }else{
            $statement->execute();
        }

        if (!$statement) {
            // no se encontraron paises
        }
        else {
        
            $rol = $statement->fetch(PDO::FETCH_ASSOC);   // porque es un solo resultado

        }

        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);

        return $rol;

    }


    function insertar_rol($arg_cdescripcion_rol){

        $ultimo_id=0;
       
        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "INSERT INTO roles (cdescripcion_rol) VALUES (:arg_cdescripcion_rol)";
        
        // preparo el sql para enviar   se puede usar prepare   y bindparam 
        $statement = $conexion->prepare($sql);
        
        $statement->bindParam(':arg_cdescripcion_rol' , $arg_cdescripcion_rol);  // reemplazo los parametros enlazados 
        
        
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


    function actualizar_rol($arg_rol_id,$arg_cdescripcion_rol){

       
        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "UPDATE roles set cdescripcion_rol = :arg_cdescripcion_rol WHERE rol_id = :arg_rol_id";
        
        // preparo el sql para enviar   se puede usar prepare   y bindparam 
        $statement = $conexion->prepare($sql);
        
        $statement->bindParam(':arg_cdescripcion_rol' , $arg_cdescripcion_rol);  // reemplazo los parametros enlazados 
        $statement->bindParam(':arg_rol_id' , $arg_rol_id);  // reemplazo los parametros enlazados   
        
        if(!$statement){
            echo "Error al crear el registro";
        }else{
            $statement->execute();
        }

        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);

    }
    
    
    function eliminar_rol($arg_rol_id){

       
        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "DELETE FROM roles WHERE rol_id = :arg_rol_id";
        
        // preparo el sql para enviar   se puede usar prepare   y bindparam 
        $statement = $conexion->prepare($sql);
        
        $statement->bindParam(':arg_rol_id' , $arg_rol_id);  // reemplazo los parametros enlazados   
        
        if(!$statement){
            echo "Error al crear el registro";
        }else{
            $statement->execute();
        }

        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);

    }


?> 