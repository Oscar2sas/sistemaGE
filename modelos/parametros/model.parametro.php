<?php 

   
    function buscar_parametros($arg_textoabuscar){

        $parametros = array();  // creo un array que va a almacenar la informacion de los paises

        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "SELECT parametros.id_parametro as id_parametro, parametros.descripcion as descripcion, parametros.valor as valor, parametros.parametro_tipo_id as id_tipo, tipo_parametros.parametro_tipo_id as tipo_id, tipo_parametros.tipo_parametro as tipo from parametros, tipo_parametros where parametros.parametro_tipo_id = tipo_parametros.parametro_tipo_id;"; // busca todos loa paises

        if (!empty($arg_textoabuscar)) {
        
            $sql = $sql." WHERE descripcion LIKE :arg_textoabuscar";   // filtra busqueda 

            $arg_textoabuscar="%".TRIM($arg_textoabuscar)."%";
        }

        $sql = $sql." ORDER BY descripcion";  
        
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

                $parametros[] = $resultado;

            }
        }

        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);

        return $parametros;

    }

    function buscar_tipos(){

        $tipos_parametros = array();  // creo un array que va a almacenar la informacion de los paises

        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "SELECT * from tipo_parametros;"; // busca todos loa paises

        $sql = $sql." ORDER BY descripcion";  
        
        $statement = $conexion->prepare($sql);
        
        
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

                $tipos_parametros[] = $resultado;

            }
        }

        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);

        return $tipos_parametros;

    }
 
    function buscar_un_parametro($arg_parametro_id){

        $parametro = array();  // creo un array que va a almacenar la informacion del pais

        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "SELECT id_parametro, descripcion, valor, parametro_tipo_id FROM parametros WHERE id_parametro =:arg_parametro_id";  // busca un solo registor
        
        $statement = $conexion->prepare($sql);
        
        $statement->bindParam(':arg_parametro_id' , $arg_parametro_id);  // reemplazo los parametros enlazados 
        
        
        if(!$statement){
            echo "Error al crear el registro";
        }else{
            $statement->execute();
        }

        if (!$statement) {
            // no se encontraron paises
        }
        else {
        
            $parametro = $statement->fetch(PDO::FETCH_ASSOC);   // porque es un solo resultado

        }

        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);

        return $parametro;

    }

    function insertar_parametro($arg_descripcion, $arg_valor, $arg_tipo_parametro){

        $ultimo_id=0;
       
        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "INSERT INTO parametros (descripcion, valor, parametro_tipo_id) VALUES ('$arg_descripcion', '$arg_valor', $arg_tipo_parametro)";
        // preparo el sql para enviar   se puede usar prepare   y bindparam 
        $statement = $conexion->prepare($sql);
        
        $statement->bindParam(':arg_descripcion' , $arg_descripcion);  // reemplazo los parametros enlazados 
        $statement->bindParam(':arg_valor' , $arg_valor);  // reemplazo los parametros enlazados 
        $statement->bindParam(':arg_tipo_parametro' , $arg_tipo_parametro);  // reemplazo los parametros enlazados 
        
        
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
    

    function actualizar_parametro($arg_parametro_id,$arg_descripcion, $arg_valor, $arg_tipo_parametro){

       
        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "UPDATE parametros set descripcion = :arg_descripcion, valor = :arg_valor, parametro_tipo_id = :arg_tipo_parametro WHERE id_parametro = :arg_parametro_id";
        
        // preparo el sql para enviar   se puede usar prepare   y bindparam 
        $statement = $conexion->prepare($sql);

        $statement->bindParam(':arg_descripcion' , $arg_descripcion);  // reemplazo los parametros enlazados 
        $statement->bindParam(':arg_valor' , $arg_valor);  // reemplazo los parametros enlazados 
        $statement->bindParam(':arg_tipo_parametro' , $arg_tipo_parametro);  // reemplazo los parametros enlazados 
        $statement->bindParam(':arg_parametro_id' , $arg_parametro_id);  // reemplazo los parametros enlazados   
        
        if(!$statement){
            echo "Error al crear el registro";
        }else{
            $statement->execute();
        }

        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);

    }


    function eliminar_parametro($arg_parametro_id){

       
        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "DELETE FROM parametros WHERE id_parametro = :arg_parametro_id";
        
        // preparo el sql para enviar   se puede usar prepare   y bindparam 
        $statement = $conexion->prepare($sql);
        
        $statement->bindParam(':arg_parametro_id' , $arg_parametro_id);  // reemplazo los parametros enlazados   
        
        if(!$statement){
            echo "Error al crear el registro";
        }else{
            $statement->execute();
        }

        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);

    }
    
?> 