<?php 

   
    function buscar_telefonos($arg_textoabuscar){

        $telefonos = array();  // creo un array que va a almacenar la informacion de los paises

        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "SELECT telefonos.*, personas.cnombres_persona FROM telefonos LEFT JOIN personas ON telefonos.rela_persona_id = personas.persona_id";  // busca un solo registor
        
        
        $statement = $conexion->query($sql);
        
            // reviso el retorno
        if(!$statement){
                echo "Error al crear el registro";
        }else{
                $statement->execute();
        }
    
        if (!$statement) {
                // no se encontraron paises
        }
        else {
            while($resultado = $statement->fetch(PDO::FETCH_ASSOC)){

                $telefonos[] = $resultado;

            }
        }
        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);

        return $telefonos;

    }

    function buscar_un_telefono($arg_telefono_id){

        $telefono = array();  // creo un array que va a almacenar la informacion del pais

        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "SELECT telefonos.*, personas.cnombres_persona FROM telefonos LEFT JOIN personas ON telefonos.rela_persona_id = personas.persona_id WHERE telefonos.telefono_id = $arg_telefono_id";  // busca un solo registor
        
        $statement = $conexion->query($sql);
        
        if(!$statement){
            echo "Error al crear el registro";
        }else{
            $statement->execute();
        }

        if (!$statement) {
            // no se encontraron paises
        }
        else {
        
            $telefono = $statement->fetch(PDO::FETCH_ASSOC);   // porque es un solo resultado

        }
        
        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);
        
        return $telefono;

    }


    function insertar_telefono($arg_cnumero_telefono, $arg_ntipo_telefono, $arg_rela_persona_id){

        $ultimo_id=0;
       
        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "INSERT INTO telefonos (cnumero_telefono, ntipo_telefono, rela_persona_id) VALUES (:arg_cnumero_telefono, :arg_ntipo_telefono, :arg_rela_persona_id)";
        
        // preparo el sql para enviar   se puede usar prepare   y bindparam 
        $statement = $conexion->prepare($sql);
        
        $statement->bindParam(':arg_cnumero_telefono' , $arg_cnumero_telefono);
        $statement->bindParam(':arg_ntipo_telefono' , $arg_ntipo_telefono);
        $statement->bindParam(':arg_rela_persona_id' , $arg_rela_persona_id);
        
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


    function actualizar_telefono($arg_telefono_id,$arg_cnumero_telefono,$arg_ntipo_telefono,$arg_rela_persona_id){
    
        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "UPDATE telefonos set cnumero_telefono = $arg_cnumero_telefono, ntipo_telefono = $arg_ntipo_telefono, rela_persona_id = $arg_rela_persona_id WHERE telefono_id = $arg_telefono_id";
        
        // preparo el sql para enviar   se puede usar prepare   y bindparam 
        $statement = $conexion->query($sql);
        
        if(!$statement){
            echo "Error al crear el registro";
        }else{
            $statement->execute();
        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);
        }

    }
    
    
    function eliminar_telefono($arg_telefono_id){

       
        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "DELETE FROM telefonos WHERE telefono_id = $arg_telefono_id";

        // preparo el sql para enviar   se puede usar prepare   y bindparam 
        $statement = $conexion->query($sql);
        
        // reemplazo los parametros enlazados   
        
        if(!$statement){
            echo "Error al crear el registro";
        }else{
            $statement->execute();
        }

        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);

    }

?>