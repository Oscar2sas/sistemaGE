<?php 

   
    function buscar_estadoalumnos($arg_textoabuscar){

        $estadoalumnos = array();  // creo un array que va a almacenar la informacion de los estados de los alumnos

        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "SELECT estadoalumno_id,cdescripcion_estadoalumno FROM estado_alumnos"; // busca todos los estados de los alumnos

        if (!empty($arg_textoabuscar)) {
        
            $sql = $sql." WHERE cdescripcion_estadoalumno LIKE :arg_textoabuscar";   // filtra busqueda 

            $arg_textoabuscar="%".TRIM($arg_textoabuscar)."%";
        }

        $sql = $sql." ORDER BY cdescripcion_estadoalumno";  
        
        $statement = $conexion->prepare($sql);
        
        $statement->bindParam(':arg_textoabuscar' , $arg_textoabuscar);  // reemplazo los parametros enlazados 
        
        
        if(!$statement){
            echo "Error al crear el registro";
        }else{
            $statement->execute();
        }

        if (!$statement) {
            // no se encontraron estadoalumnos
        }
        else {
        
            // reviso el retorno

            while($resultado = $statement->fetch(PDO::FETCH_ASSOC)){

                $estadoalumnos[] = $resultado;

            }
        }

        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);

        return $estadoalumnos;

    }

    function buscar_un_estadoalumno($arg_estadoalumno_id){

        $estadoalumno = array();  // creo un array que va a almacenar la informacion del estadoalumno

        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "SELECT estadoalumno_id,cdescripcion_estadoalumno FROM estado_alumnos WHERE estadoalumno_id =:arg_estadoalumno_id";  // busca un solo registro
        
        $statement = $conexion->prepare($sql);
        
        $statement->bindParam(':arg_estadoalumno_id' , $arg_estadoalumno_id);  // reemplazo los parametros enlazados 
        
        
        if(!$statement){
            echo "Error al crear el registro";
        }else{
            $statement->execute();
        }

        if (!$statement) {
            // no se encontraron estadoalumnos
        }
        else {
        
            $estadoalumno = $statement->fetch(PDO::FETCH_ASSOC);   // porque es un solo resultado
           
            if (!$estadoalumno) { // si el valor es falso
                $estadoalumno = array();  // vuelvo a crear un array que va a almacenar la informacion del estadoalumno
            }

        }

        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);

        return $estadoalumno;

    }


    function insertar_estadoalumno($arg_cdescripcion_estadoalumno){

        $ultimo_id=0;
       
        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "INSERT INTO estado_alumnos (cdescripcion_estadoalumno) VALUES (:arg_cdescripcion_estadoalumno)";
        
        // preparo el sql para enviar   se puede usar prepare   y bindparam 
        $statement = $conexion->prepare($sql);
        
        $statement->bindParam(':arg_cdescripcion_estadoalumno' , $arg_cdescripcion_estadoalumno);  // reemplazo los parametros enlazados 
        
        
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


    function actualizar_estadoalumno($arg_estadoalumno_id,$arg_cdescripcion_estadoalumno){

       
        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "UPDATE estado_alumnos set cdescripcion_estadoalumno = :arg_cdescripcion_estadoalumno WHERE estadoalumno_id = :arg_estadoalumno_id";
        
        // preparo el sql para enviar   se puede usar prepare   y bindparam 
        $statement = $conexion->prepare($sql);
        
        $statement->bindParam(':arg_cdescripcion_estadoalumno' , $arg_cdescripcion_estadoalumno);  // reemplazo los parametros enlazados 
        $statement->bindParam(':arg_estadoalumno_id' , $arg_estadoalumno_id);  // reemplazo los parametros enlazados   
        
        if(!$statement){
            echo "Error al crear el registro";
        }else{
            $statement->execute();
        }

        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);

    }
    
    
    function eliminar_estadoalumno($arg_estadoalumno_id){

       
        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "DELETE FROM estado_alumnos WHERE estadoalumno_id = :arg_estadoalumno_id";
        
        // preparo el sql para enviar   se puede usar prepare   y bindparam 
        $statement = $conexion->prepare($sql);
        
        $statement->bindParam(':arg_estadoalumno_id' , $arg_estadoalumno_id);  // reemplazo los parametros enlazados   
        
        if(!$statement){
            echo "Error al crear el registro";
        }else{
            $statement->execute();
        }

        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);

    }

    // funciones para control de duplicados y otros

    function buscar_un_estadoalumno_por($arg_condicion_busqueda,$arg_estadoalumno_id){

        $estadoalumno = array();  // creo un array que va a almacenar la informacion del estadoalumno

        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "SELECT estadoalumno_id FROM estado_alumnos WHERE ".$arg_condicion_busqueda;
      
        $sql = $sql ." AND estadoalumno_id <> :arg_estadoalumno_id ";  // busca un solo registro

        // preparo el sql para enviar   se puede usar prepare   y bindparam 
        $statement = $conexion->prepare($sql);
                
        $statement->bindParam(':arg_estadoalumno_id' , $arg_estadoalumno_id);  // reemplazo los parametros enlazados   
        
        if(!$statement){
            echo "Error al crear el registro";
        }else{
            $statement->execute();
        }

        if (!$statement) {
            // no se encontraron estadoalumnos
        }
        else {
        
            $estadoalumno = $statement->fetch(PDO::FETCH_ASSOC);   // porque es un solo resultado

            if (!$estadoalumno) { // si el valor es falso
                $estadoalumno = array();  // vuelvo a crear un array que va a almacenar la informacion del estadoalumno
            }

        }
        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);

        return $estadoalumno;

    }

?> 