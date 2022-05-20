<?php 

    function login_usuario($arg_usuario,$arg_password){

        // uso la clase PDO para conectar a la base de datos
        //  tambien se puede hacer sin clases   con mysqli_connect()


        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "SELECT * FROM usuarios where TRIM(cemail_usuario) = :arg_usuario LIMIT 1";   // aqui va el sql para recuperar el usuario

        // preparo el sql para enviar   se puede usar prepare   y bindparam 
        $statement = $conexion->prepare($sql);
        
        $statement->bindParam(':arg_usuario' , $arg_usuario);  // reemplazo los parametros enlazados
        
        if(!$statement){
            echo "Error al crear el registro";
        }else{
            $statement->execute();
        }


        // o puedo usar directamente  ->query()
        
        // $statement = $conexion->query($sql)


        $resultado = $statement->fetch( PDO::FETCH_ASSOC );   // porque es un solo resultado
        
        // si tuviera mas resultados
        // $resultados = array();  // creo un array que va a almacenar la informacion del usuario


        // reviso el retorno

        //while($resultado = $statement->fetch()){

            //  $resultados[] = $resultado;

        //}

        // return $resultados;


        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);

        return $resultado;
    }


    function buscar_usuarios(){

        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "SELECT * FROM usuarios";   // busca todos los usuarios 
        
        $statement = $conexion->query($sql);

        $usuarios = array();  // creo un array que va a almacenar la informacion de los usuarios

        // reviso el retorno

        while($resultado = $statement->fetch(PDO::FETCH_ASSOC)){

            $usuarios[] = $resultado;

        }

        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);

        return $usuarios;

    }


    function guardar_password($arg_usuario_id, $arg_password){

        // genero el hash del password
        $hash = password_hash(trim($arg_password), PASSWORD_DEFAULT);

       
        // uso la clase PDO para conectar a la base de datos
        //  tambien se puede hacer sin clases   con mysqli_connect()


        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "UPDATE usuarios SET cpassword_usuario= :arg_hash  WHERE usuario_id = :arg_usuario_id ";    // graba la contraseña de un usuario 
        
        // preparo el sql para enviar   se puede usar prepare   y bindparam 
        $statement = $conexion->prepare($sql);
                
        $statement->bindParam(':arg_usuario_id' , $arg_usuario_id);  // reemplazo los parametros enlazados
        $statement->bindParam(':arg_hash' , $hash);  

        if(!$statement){
            echo "Error al crear el registro";
        }else{
            $statement->execute();
        }

        // cierro la conexion
        $db->cerrar_conexion($conexion);

        return true ;

    }



?> 