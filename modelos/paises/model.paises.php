<?php 

   
    function buscar_paises($arg_textoabuscar){

        $paises = array();  // creo un array que va a almacenar la informacion de los paises

        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "SELECT pais_id, cacortacion_pais, cnombre_pais, cbandera FROM paises"; // busca todos los paises

        if (!empty($arg_textoabuscar)) {
            /*Intente probar cambiar el LIKE del sql por un =, pero salto un error de que no mostraba
            los datos y ahi me di cuenta de que esta funcion anda perfectamente 
            ya que esto lo que realmente hace no es del buscador, sino como un mostrador 
            mas abajo esta el buscador de verdad */

            $sql = $sql." WHERE cnombre_pais LIKE :arg_textoabuscar";   // filtra busqueda 

            $arg_textoabuscar="%".TRIM($arg_textoabuscar)."%";
        }

        $sql = $sql." ORDER BY cnombre_pais";  
        
        $statement = $conexion->prepare($sql);
        
        $statement->bindParam(':arg_textoabuscar' , $arg_textoabuscar);  // reemplazo los parametros enlazados 
        
        
        if(!$statement){
            echo "Error al crear el registro";
        }else{
            $statement->execute();
        }

        if (!$statement) {
            echo "No se encontraron paises";
            // no se encontraron paises
        }
        else {
        
            // reviso el retorno

            while($resultado = $statement->fetch(PDO::FETCH_ASSOC)){

                $paises[] = $resultado;

            }
        }

        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);

        return $paises;

    }

    function buscar_un_pais($arg_pais_id){

        $pais = array();  // creo un array que va a almacenar la informacion del pais

        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();
        
        //Esta es la funcion del buscador, yo lo que hice fue buscar exactamente a que estaba conectado la variable $arg_pais_id y le corregi esto. Creo que estaba diferente antes. Ya que le puse como el codigo que esta en el de la derecha y despues de eso funciono
        $sql = "SELECT pais_id,cnombre_pais FROM paises WHERE pais_id =:arg_pais_id";  // busca un solo registor
        
        $statement = $conexion->prepare($sql);
        
        $statement->bindParam(':arg_pais_id' , $arg_pais_id);  // reemplazo los parametros enlazados 
        
        
        if(!$statement){
            echo "Error al crear el registro";
        }else{
            $statement->execute();
        }

        if (!$statement) {
            // no se encontraron paises
        }
        else {
        
            $pais = $statement->fetch(PDO::FETCH_ASSOC);   // porque es un solo resultado

        }

        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);

        return $pais;

    }


    function insertar_pais($arg_cacortacion_pais, $arg_cnombre_pais, $arg_cbandera){

        $ultimo_id=0;
       
        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "INSERT INTO paises (cacortacion_pais, cnombre_pais, cbandera) VALUES ('$arg_cacortacion_pais', '$arg_cnombre_pais', '$arg_cbandera')";
        
        // preparo el sql para enviar   se puede usar prepare   y bindparam 
        $statement = $conexion->prepare($sql);
        
        $statement->bindParam(':arg_cacortacion_pais' , $arg_cacortacion_pais);  // reemplazo los parametros enlazados 
        $statement->bindParam(':arg_cnombre_pais' , $arg_cnombre_pais);
        $statement->bindParam(':arg_cbandera' , $arg_cbandera);
        

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


    function actualizar_pais($arg_pais_id, $arg_cacortacion_pais, $arg_cnombre_pais, $arg_cbandera){

        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "UPDATE paises SET cacortacion_pais = '$arg_cacortacion_pais', cnombre_pais = '$arg_cnombre_pais', cbandera = '$arg_cbandera' WHERE pais_id = $arg_pais_id";
        
        // preparo el sql para enviar   se puede usar prepare   y bindparam 
        $statement = $conexion->prepare($sql);
        
        /*
        $statement->bindParam(':arg_pais_id' , $arg_pais_id);  // reemplazo los parametros enlazados   
        $statement->bindParam(':arg_cacortacion_pais' , $arg_cacortacion_pais);  // reemplazo los parametros enlazados 
        $statement->bindParam(':arg_cnombre_pais' , $arg_cnombre_pais);
        $statement->bindParam(':arg_cbandera' , $arg_cbandera);
        */
        

        if(!$statement){
            echo "Error al crear el registro";
        }else{
            $statement->execute();
        }
        

        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);

    }
    
    
    function eliminar_pais($arg_pais_id){

       
        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "DELETE INTO paises WHERE pais_id = $arg_pais_id";
        
        // preparo el sql para enviar   se puede usar prepare   y bindparam 
        //$statement = $conexion->prepare($sql);
        $statement = $conexion->query($sql);
        
        /* $statement->bindParam(':arg_pais_id' , $arg_pais_id);  // reemplazo los parametros enlazados   */
        
        if(!$statement){
            echo "Error al crear el registro";
        }else{
            $statement->execute();
        }

        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);

    }
?> 