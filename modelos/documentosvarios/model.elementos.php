<?php 
    
    function MostrarElementos(){

        $carreras = array();  // creo un array que va a almacenar la informacion de las carreras

        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "SELECT * FROM documentos_varios";   

        $statement = $conexion->prepare($sql);
        
        
        if(!$statement){
            echo "Error al crear el registro";
        }else{
            $statement->execute();
        }

        if (!$statement) {
            // no se encontraron localidades
        }
        else {
        
            // reviso el retorno

            while($resultado = $statement->fetch(PDO::FETCH_ASSOC)){

                $carreras[] = $resultado;

            }
        }
        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);
        return $carreras;
    }

     function eliminar_Elemento($arg_documento_id){

        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "DELETE FROM `documentos_varios` WHERE `documento_id` = $arg_documento_id";
        
        // preparo el sql para enviar   se puede usar prepare   y bindparam 
        $statement = $conexion->prepare($sql);
        
        $statement->bindParam(':arg_documento_id' , $arg_documento_id);  // reemplazo los parametros enlazados   
        
        if(!$statement){
            echo "Error eliminar registro";
        }else{
            $statement->execute();
        }

        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);
    }

    function modificar_datos($arg_documento_id, $arg_cdescripcion_documento){
        
        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "UPDATE documentos_varios SET cdescripcion_documento = :arg_cdescripcion_documento WHERE documentos_varios.documento_id = :arg_documento_id";
        
        //preparo el sql para enviar se puede usar prepare y bindparam 
        $statement = $conexion->prepare($sql);
        
        $statement->bindParam(':arg_documento_id' , $arg_documento_id);  //reemplazo los parametros enlazados 
        $statement->bindParam(':arg_cdescripcion_documento' , $arg_cdescripcion_documento);  //reemplazo los parametros enlazados
        
        if(!$statement){
        echo "Error al editar el registro";
        }else{
        if ($statement->execute()) {
            return true;
        }else{
            return false;
            }
        }

        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);

        }
 ?>