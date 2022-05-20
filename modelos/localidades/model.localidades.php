<?php 

   
    function buscar_localidades($arg_textoabuscar){

        $localidades = array();  // creo un array que va a almacenar la informacion de los provincias

        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "select localidades.* , provincias.cnombre_provincia, paises.cnombre_pais from localidades left join provincias on localidades.rela_provincia_id = provincias.provincia_id left join paises on provincias.rela_pais_id = paises.pais_id";  // busca un solo registor
        
        $statement = $conexion->query($sql);

            // reviso el retorno

            while($resultado = $statement->fetch(PDO::FETCH_ASSOC)){

                $localidades[] = $resultado;

            }

        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);

        return $localidades;

    }

    function buscar_una_localidad($arg_localidad_id){

        $localidad = array();  // creo un array que va a almacenar la informacion del provincia

        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "select localidades.* , provincias.cnombre_provincia, paises.cnombre_pais from localidades left join provincias on localidades.rela_provincia_id = provincias.provincia_id left join paises on provincias.rela_pais_id = paises.pais_id";  // busca un solo registor
        
        $statement = $conexion->query($sql);
        
        $localidad = $statement->fetch(PDO::FETCH_ASSOC);
          // reemplazo los parametros enlazados 
        

        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);

        return $localidad;

    }


    function insertar_localidad($arg_cnombre_localidad, $rela_provincia_id){


        $ultimo_id=0;
       
        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "INSERT INTO localidades (cnombre_localidad, rela_provincia_id) VALUES ('$arg_cnombre_localidad', $rela_provincia_id)";
        
        // preparo el sql para enviar   se puede usar prepare   y bindparam 
        $statement = $conexion->query($sql);
        
        $ultimo_id = $conexion->lastinsertid();
       
        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);

        return $ultimo_id;
    }


    function actualizar_localidad($arg_localidad_id,$arg_cnombre_localidad, $arg_rela_provincia_id){
        
       
        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "UPDATE localidades set cnombre_localidad = :arg_cnombre_localidad, rela_provincia_id = :arg_rela_provincia_id WHERE localidad_id = :arg_localidad_id";
        
        // preparo el sql para enviar   se puede usar prepare   y bindparam 
        $statement = $conexion->prepare($sql);
        
        $statement->bindParam(':arg_localidad_id' , $arg_localidad_id);
        $statement->bindParam(':arg_cnombre_localidad' , $arg_cnombre_localidad);
        $statement->bindParam(':arg_rela_provincia_id' , $arg_rela_provincia_id);
        
        if(!$statement){
            echo "Error al crear el registro";
        }else{
            $statement->execute();
        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);
        }

    }
    
    
    function eliminar_localidad($arg_localidad_id){
        
       
        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "DELETE FROM localidades WHERE localidad_id = $arg_localidad_id";

        
        
        // preparo el sql para enviar   se puede usar prepare   y bindparam 
        $statement = $conexion->query($sql);// reemplazo los parametros enlazados   
        var_dump($statement);
        die();
        if(!$statement){
            echo "Error al crear el registro";
        }else{
            $statement->execute();
        }

        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);

    }


?> 