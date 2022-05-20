<?php 

   
    function buscar_cursos($arg_textoabuscar){

        $cursos = array();  // creo un array que va a almacenar la informacion de los cursos

        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "SELECT curso_id,cnombre_curso FROM cursos"; // busca todos loa cursos

        if (!empty($arg_textoabuscar)) {
        
            $sql = $sql." WHERE cnombre_curso LIKE :arg_textoabuscar";   // filtra busqueda 

            $arg_textoabuscar="%".TRIM($arg_textoabuscar)."%";
        }

        $sql = $sql." ORDER BY cnombre_curso";  
        
        $statement = $conexion->prepare($sql);
        
        $statement->bindParam(':arg_textoabuscar' , $arg_textoabuscar);  // reemplazo los parametros enlazados 
        
        
        if(!$statement){
            echo "Error al crear el registro";
        }else{
            $statement->execute();
        }

        if (!$statement) {
            // no se encontraron cursos
        }
        else {
        
            // reviso el retorno

            while($resultado = $statement->fetch(PDO::FETCH_ASSOC)){

                $cursos[] = $resultado;

            }
        }

        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);

        return $cursos;

    }

    function buscar_un_curso($arg_curso_id){

        $curso = array();  // creo un array que va a almacenar la informacion del curso

        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "SELECT curso_id,cnombre_curso FROM cursos WHERE curso_id =:arg_curso_id";  // busca un solo registor
        
        $statement = $conexion->prepare($sql);
        
        $statement->bindParam(':arg_curso_id' , $arg_curso_id);  // reemplazo los parametros enlazados 
        
        
        if(!$statement){
            echo "Error al crear el registro";
        }else{
            $statement->execute();
        }

        if (!$statement) {
            // no se encontraron cursos
        }
        else {
        
            $curso = $statement->fetch(PDO::FETCH_ASSOC);   // porque es un solo resultado
           
            if (!$curso) { // si el valor es falso
                $curso = array();  // vuelvo a crear un array que va a almacenar la informacion del curso
            }

        }

        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);

        return $curso;

    }


    function insertar_curso($arg_cnombre_curso){

        $ultimo_id=0;
       
        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "INSERT INTO cursos (cnombre_curso) VALUES (:arg_cnombre_curso)";
        
        // preparo el sql para enviar   se puede usar prepare   y bindparam 
        $statement = $conexion->prepare($sql);
        
        $statement->bindParam(':arg_cnombre_curso' , $arg_cnombre_curso);  // reemplazo los parametros enlazados 
        
        
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


    function actualizar_curso($arg_curso_id,$arg_cnombre_curso){

       
        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "UPDATE cursos set cnombre_curso = :arg_cnombre_curso WHERE curso_id = :arg_curso_id";
        
        // preparo el sql para enviar   se puede usar prepare   y bindparam 
        $statement = $conexion->prepare($sql);
        
        $statement->bindParam(':arg_cnombre_curso' , $arg_cnombre_curso);  // reemplazo los parametros enlazados 
        $statement->bindParam(':arg_curso_id' , $arg_curso_id);  // reemplazo los parametros enlazados   
        
        if(!$statement){
            echo "Error al crear el registro";
        }else{
            $statement->execute();
        }

        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);

    }
    
    
    function eliminar_curso($arg_curso_id){

       
        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "DELETE FROM cursos WHERE curso_id = :arg_curso_id";
        
        // preparo el sql para enviar   se puede usar prepare   y bindparam 
        $statement = $conexion->prepare($sql);
        
        $statement->bindParam(':arg_curso_id' , $arg_curso_id);  // reemplazo los parametros enlazados   
        
        if(!$statement){
            echo "Error al crear el registro";
        }else{
            $statement->execute();
        }

        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);

    }

    // funciones para control de duplicados y otros

    function buscar_un_curso_por($arg_condicion_busqueda,$arg_curso_id){

        $pais = array();  // creo un array que va a almacenar la informacion del pais

        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "SELECT pais_id FROM cursos WHERE ".$arg_condicion_busqueda;
       
        $sql = $sql ." AND pais_id <> :arg_pais_id ";  // busca un solo registro

        // preparo el sql para enviar   se puede usar prepare   y bindparam 
        $statement = $conexion->prepare($sql);
                
        $statement->bindParam(':arg_pais_id' , $arg_pais_id);  // reemplazo los parametros enlazados   
        
        if(!$statement){
            echo "Error al crear el registro";
        }else{
            $statement->execute();
        }

        if (!$statement) {
            // no se encontraron cursos
        }
        else {
        
            $pais = $statement->fetch(PDO::FETCH_ASSOC);   // porque es un solo resultado

            if (!$pais) { // si el valor es falso
                $pais = array();  // vuelvo a crear un array que va a almacenar la informacion del pais
            }

        }
        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);

        return $pais;

    }

?> 