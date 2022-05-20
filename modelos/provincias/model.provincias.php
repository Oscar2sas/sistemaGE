<?php 

   
    function buscar_provincias($arg_textoabuscar){

        $provincias = array();  // creo un array que va a almacenar la informacion de los paises

        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "SELECT provincias.provincia_id, provincias.cnombre_provincia, paises.cnombre_pais FROM provincias LEFT JOIN paises ON provincias.rela_pais_id = paises.pais_id";  // busca un solo registor
        
        $statement = $conexion->query($sql);

            // reviso el retorno

            while($resultado = $statement->fetch(PDO::FETCH_ASSOC)){

                $provincias[] = $resultado;

            }

        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);

        return $provincias;

    }

    function buscar_una_provincia($arg_provincia_id){

        $provincia = array();  // creo un array que va a almacenar la informacion del pais

        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "SELECT provincias.provincia_id, provincias.cnombre_provincia, paises.cnombre_pais FROM provincias LEFT JOIN paises ON provincias.rela_pais_id = paises.pais_id WHERE provincias.provincia_id = $arg_provincia_id";  // busca un solo registor
        
        $statement = $conexion->query($sql);
        
        $provincia = $statement->fetch(PDO::FETCH_ASSOC);
          // reemplazo los parametros enlazados 
        

        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);

        return $provincia;

    }


    function insertar_provincia($arg_cnombre_provincia, $rela_pais_id){


        $ultimo_id=0;
       
        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "INSERT INTO provincias (cnombre_provincia, rela_pais_id) VALUES ('$arg_cnombre_provincia', $rela_pais_id)";
        
        // preparo el sql para enviar   se puede usar prepare   y bindparam 
        $statement = $conexion->query($sql);
        
        $ultimo_id = $conexion->lastinsertid();
       
        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);

        return $ultimo_id;
    }


    function actualizar_provincia($arg_provincia_id,$arg_cnombre_provincia){

       
        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "UPDATE provincias set cnombre_provincia = '$arg_cnombre_provincia' WHERE provincia_id = $arg_provincia_id";
        
        // preparo el sql para enviar   se puede usar prepare   y bindparam 
        $statement = $conexion->query($sql); // reemplazo los parametros enlazados   

        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);

    }
    
    
    function eliminar_provincia($arg_provincia_id){

       
        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "DELETE FROM provincias WHERE provincia_id = $arg_provincia_id";

        
        
        // preparo el sql para enviar   se puede usar prepare   y bindparam 
        $statement = $conexion->query($sql);// reemplazo los parametros enlazados   
        
        if(!$statement){
            echo "Error al crear el registro";
        }else{
            $statement->execute();
        }

        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);

    }


?> 