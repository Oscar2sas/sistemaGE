<?php 

    function login_usuario($arg_usuario,$arg_password){

        // uso la clase PDO para conectar a la base de datos
        //  tambien se puede hacer sin clases   con mysqli_connect()


        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "SELECT * FROM usuarios,roles WHERE usuarios.rela_rol_id = roles.rol_id AND TRIM(cemail_usuario) = :arg_usuario LIMIT 1";   // aqui va el sql para recuperar el usuario

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


    function buscar_usuarios($arg_textoabuscar){

        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "SELECT * FROM usuarios,roles WHERE usuarios.rela_rol_id = roles.rol_id ";   // busca todos los usuarios

        if (!empty($arg_textoabuscar)) {
        
            $sql = $sql." AND (cnombre_usuario LIKE :arg_textoabuscar OR cemail_usuario LIKE :arg_textoabuscar OR cdescripcion_rol LIKE :arg_textoabuscar)";   // filtra busqueda 

            $arg_textoabuscar="%".TRIM($arg_textoabuscar)."%";
        }

        $sql = $sql." ORDER BY cnombre_usuario";   
        
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
        
            $usuarios = array();  // creo un array que va a almacenar la informacion de los usuarios

            // reviso el retorno
    
            while($resultado = $statement->fetch(PDO::FETCH_ASSOC)){
    
                $usuarios[] = $resultado;
    
            }
        }

        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);

        return $usuarios;

    }



    function buscar_un_usuario($arg_usuario_id){

        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "SELECT * FROM usuarios, roles WHERE usuarios.usuario_id =:arg_usuario_id AND usuarios.rela_rol_id = roles.rol_id "; //Busca el usuario
        
        //$statement = $conexion->query($sql);
        $statement = $conexion->prepare($sql);
        
        $statement->bindParam(':arg_usuario_id' , $arg_usuario_id);  // reemplazo los parametros enlazados 


        if(!$statement){
            echo "Error al crear el registro";
        }else{
            $statement->execute();
        }

        if (!$statement) {
            // no se encontraron usuarios
        }
        else {
        
            $usuario = $statement->fetch(PDO::FETCH_ASSOC);
        }

        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);

        return $usuario;

    }
    

    function insertar_usuario($array){
        $ultimo_id=0;
       
        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $hash = encriptar_password($array['cpassword_usuario']);

        //$sql = "INSERT INTO paises (cnombre_pais) VALUES (:arg_cnombre_pais)";
        $sql = "INSERT INTO `usuarios`(`cimg_usuario`, `cnombre_usuario`, `cemail_usuario`, `cpassword_usuario`, `rela_rol_id`) VALUES (:arg_cimg_usuario, :arg_cnombre_usuario,:arg_cemail_usuario,:arg_cpassword_usuario,:arg_rela_rol_id)";
        
        // preparo el sql para enviar   se puede usar prepare   y bindparam 
        $statement = $conexion->prepare($sql);
        
        
        $statement->bindParam(':arg_cimg_usuario' , $array['cimg_usuario']);
        $statement->bindParam(':arg_cnombre_usuario' , $array['cnombre_usuario']);  // reemplazo los parametros enlazados 
        $statement->bindParam(':arg_cemail_usuario' , $array['cemail_usuario']);
        $statement->bindParam(':arg_rela_rol_id' , $array['rela_rol_id']);
        $statement->bindParam(':arg_cpassword_usuario' , $hash);
        
        
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

    function actualizar_usuario($array){
        $ultimo_id=0;
       
        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "UPDATE usuarios set cimg_usuario = :arg_cimg_usuario, cnombre_usuario = :arg_cnombre_usuario, cemail_usuario = :arg_cemail_usuario, nestado_usuario = :arg_nestado_usuario , rela_rol_id = :arg_rela_rol_id WHERE usuario_id = :arg_usuario_id";
        
        // preparo el sql para enviar   se puede usar prepare   y bindparam 
        $statement = $conexion->prepare($sql);
        
        $statement->bindParam(':arg_cimg_usuario' , $array['cimg_usuario']);
        $statement->bindParam(':arg_cnombre_usuario' , $array['cnombre_usuario']);  // reemplazo los parametros enlazados 
        $statement->bindParam(':arg_cemail_usuario' , $array['cemail_usuario']);  // reemplazo los parametros enlazados 
        $statement->bindParam(':arg_nestado_usuario' , $array['nestado_usuario']);

        $statement->bindParam(':arg_rela_rol_id' , $array['rela_rol_id']);  // reemplazo los parametros enlazados 
        $statement->bindParam(':arg_usuario_id' , $array['usuario_id']);  // reemplazo los parametros enlazados   
        
        if(!$statement){
            echo "Error al crear el registro";
        }else{
            $statement->execute();
        }

        $ultimo_id = $conexion->lastinsertid();
        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);

        if($array['cpassword_usuario']!=""){
            guardar_password($array['usuario_id'], $array['cpassword_usuario']);
        }

        return $ultimo_id;
    }

    function encriptar_password($arg_password){
        $hash = password_hash(trim($arg_password), PASSWORD_DEFAULT);
        return $hash;
    }


    function guardar_password($arg_usuario_id, $arg_password){

        // genero el hash del password
        $hash = encriptar_password($arg_password);

       
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

    function buscar_roles(){

        $roles = array();  // creo un array que va a almacenar la informacion de los paises

        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "SELECT * FROM roles"; // busca todos loa paises  
        
        $statement = $conexion->prepare($sql);
        
        //$statement->bindParam(':arg_textoabuscar' , $arg_textoabuscar);  // reemplazo los parametros enlazados 
        
        
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


    function eliminar_usuario($arg_usuario_id){

       
        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "UPDATE usuarios SET nestado_usuario = 2  WHERE usuario_id = :arg_usuario_id";
        
        // preparo el sql para enviar   se puede usar prepare   y bindparam 
        $statement = $conexion->prepare($sql);
        
        $statement->bindParam(':arg_usuario_id' , $arg_usuario_id);  // reemplazo los parametros enlazados   
        
        if(!$statement){
            echo "Error al crear el registro";
        }else{
            $statement->execute();
        }

        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);

    }

    function actualizar_perfil($array){

       
        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "UPDATE usuarios set cimg_usuario = :arg_cimg_usuario, cnombre_usuario = :arg_cnombre_usuario, cemail_usuario = :arg_cemail_usuario WHERE usuario_id = :arg_usuario_id";
        
        // preparo el sql para enviar   se puede usar prepare   y bindparam 
        $statement = $conexion->prepare($sql);
        
        $statement->bindParam(':arg_cimg_usuario' , $array['cimg_usuario']);
        $statement->bindParam(':arg_cnombre_usuario' , $array['cnombre_usuario']);  // reemplazo los parametros enlazados 
        $statement->bindParam(':arg_cemail_usuario' , $array['cemail_usuario']);  // reemplazo los parametros enlazados 
        $statement->bindParam(':arg_usuario_id' , $array['usuario_id']);  // reemplazo los parametros enlazados   
        
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


?> 