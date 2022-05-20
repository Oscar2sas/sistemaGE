<?php 

   
    function buscar_carreras(){

        $carreras = array();  // creo un array que va a almacenar la informacion de las carreras

        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "SELECT * FROM carreras" ; // busca todas las localidades

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
    function carrera_buscar($arg_carrera_id){

        $carreras = array();  // creo un array que va a almacenar la informacion de las carreras

        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "SELECT * FROM carreras WHERE carrera_id = :arg_carrera_id" ; // busca todas las localidades

        $statement = $conexion->prepare($sql);
        
        $statement->bindParam(':arg_carrera_id' , $arg_carrera_id);
        
        if(!$statement){
            echo "buscando registro";
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


    function modificar_datos_carrera($arg_carrera_id, $arg_cdescripcion_carrera, $arg_netapastemporales_carrera, $arg_cdescripcionetapastemporal_carrera)
    {
        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "UPDATE carreras SET cdescripcion_carrera = :arg_cdescripcion_carrera,netapastemporales_carrera = :arg_netapastemporales_carrera, cdescripcionetapatemporal_carrera = :arg_cdescripcionetapastemporal_carrera WHERE carrera_id = :arg_carrera_id";
        
        // preparo el sql para enviar   se puede usar prepare   y bindparam 
        $statement = $conexion->prepare($sql);
        
        $statement->bindParam(':arg_carrera_id' , $arg_carrera_id);  // reemplazo los parametros enlazados 
        $statement->bindParam(':arg_cdescripcion_carrera' , $arg_cdescripcion_carrera);  // reemplazo los parametros enlazados 
        $statement->bindParam(':arg_netapastemporales_carrera' , $arg_netapastemporales_carrera);
        $statement->bindParam(':arg_cdescripcionetapastemporal_carrera' , $arg_cdescripcionetapastemporal_carrera);  // reemplazo los parametros enlazados
        
        if(!$statement){
            echo "Error al crear el registro";
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


    function crear_carreras($arg_POST, $semestres)
    {
        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "INSERT INTO carreras(cdescripcion_carrera, netapastemporales_carrera, cdescripcionetapatemporal_carrera) VALUES (:arg_cdescripcion_carrera,:arg_netapastemporales_carrera,:arg_cdescripcionetapastemporal_carrera)";
        
        // preparo el sql para enviar   se puede usar prepare   y bindparam 
        $statement = $conexion->prepare($sql);
        
        $statement->bindParam(':arg_cdescripcion_carrera' , $arg_POST['descripcion']);  // reemplazo los parametros enlazados 
        $statement->bindParam(':arg_netapastemporales_carrera' , $arg_POST['semestrals']);
        $statement->bindParam(':arg_cdescripcionetapastemporal_carrera' , $semestres);  // reemplazo los parametros enlazados   
        
        if(!$statement){
            echo "Error al crear el registro";
        }else{
            if ($statement->execute()) {
                return true;
            }else{
                return false;
            }
        }
    }
?> 