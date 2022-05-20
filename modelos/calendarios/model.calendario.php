<?php 

function mostrar_calendario(){

        $calendario = array();  // creo un array que va a almacenar la informacion de los anos lectivos

        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql_calendario = "SELECT a1.anolectivo_id, a1.ndescripcion_anolectivo, c1.calendario_id, c1.dfecha_calendario, c1.cdescripcion_calendario FROM anos_lectivos a1, calendario c1 WHERE a1.anolectivo_id = c1.rela_anolectivo_id"; // busca todos los anos lectivos

        $statement = $conexion->prepare($sql_calendario);

        $statement->execute();
        
        if (!$statement){
            // no se encontraron paises
        }else{
            // reviso el retorno

            while($resultado = $statement->fetch(PDO::FETCH_ASSOC)){
                $calendario[] = $resultado;
            }
        }
        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);
        return $calendario;
    }


    // Funcion para insertar nuevo ano lectivo
    function insertar_nueva_fecha_calendario($arg_POST_Fecha){
        $ultimo_id=0;
        $ano_Lectivo_Activo = buscar_Ano_Lectivo_Activo();
        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "INSERT INTO calendario(dfecha_calendario, cdescripcion_calendario, rela_anolectivo_id) 
        VALUES (
        :argdfechacalendario, 
        :argcdescripcion_calendario, 
        :argrela_anolectivo_id
    )";


        // preparo el sql para enviar   se puede usar prepare y bindparam 
    $statement = $conexion->prepare($sql);

        $statement->bindParam(':argdfechacalendario' , $arg_POST_Fecha['fechaCalendario']);  // reemplazo los parametros enlazados 
        $statement->bindParam(':argcdescripcion_calendario' , $arg_POST_Fecha['descripcionFechaCalendario']);  // reemplazo los parametros enlazados 
        $statement->bindParam(':argrela_anolectivo_id' , $ano_Lectivo_Activo['anolectivo_id']);  // reemplazo los parametros enlazados

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

    function buscar_fecha_calendario($argID){
         $fecha_calendario = array();  // creo un array que va a almacenar la informacion de las fecha calendario

         $db = new ConexionDB;
         $conexion = $db->retornar_conexion();

        $sql_fecha_calendario = "SELECT * FROM anos_lectivos a1, calendario c1 WHERE a1.anolectivo_id = c1.rela_anolectivo_id AND c1.calendario_id = :argcalendario_id"; // busca una fecha del calendario

        $statement = $conexion->prepare($sql_fecha_calendario);

        $statement->bindParam(':argcalendario_id' , $argID);  // reemplazo los parametros enlazados 

        $statement->execute();
        
        if (!$statement){
            // no se encontraron paises
        }else{
            // reviso el retorno

            while($resultado = $statement->fetch(PDO::FETCH_ASSOC)){
                $fecha_calendario = $resultado;
            }
        }
        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);
        return $fecha_calendario;

    }

    // Funcion para actualizar ano lectivo
    function actualizar_fecha_calendario($arg_POST_Fecha){
        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "UPDATE calendario SET 
        dfecha_calendario = :argdfecha_calendario, 
        cdescripcion_calendario = :argcdescripcion_calendario 
        WHERE calendario_id = :argcalendario_id";
        
        // preparo el sql para enviar   se puede usar prepare   y bindparam 
        $statement = $conexion->prepare($sql);
        
        $statement->bindParam(':argdfecha_calendario' , $arg_POST_Fecha['fechaCalendario']);  // reemplazo los parametros enlazados 
        $statement->bindParam(':argcdescripcion_calendario' , $arg_POST_Fecha['descripcionFechaCalendario']);  // reemplazo los parametros enlazados   
        $statement->bindParam(':argcalendario_id' , $arg_POST_Fecha['idFechaCalendario']);  // reemplazo los parametros enlazados   
        if(!$statement){
            echo "Error al crear el registro";
        }else{
            $statement->execute();
        }

        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);

    }

    function eliminar_fecha_calendario($argID){
        $db = new ConexionDB;

        $conexion = $db->retornar_conexion();

        $sql_fecha_calendario = "DELETE FROM calendario WHERE calendario_id = :argcalendario_id"; // elimina una fecha del calendario

        $statement = $conexion->prepare($sql_fecha_calendario);

        $statement->bindParam(':argcalendario_id' , $argID);  // reemplazo los parametros enlazados 

        $statement->execute();
        
        if (!$statement){
            echo "Error al eliminar el registro";
        }
        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);

    }

    function buscar_Descripcion_Fecha_Calendario($arg_Fecha_Calendario){
        $arg_Fecha_Calendario = ($arg_Fecha_Calendario != '') ? $arg_Fecha_Calendario : date('Y-m-d');

        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "SELECT * FROM calendario WHERE dfecha_calendario = :argFechaCalendario";

        try {

       // preparo el sql para enviar   se puede usar prepare   y bindparam 
         $statement = $conexion->prepare($sql); 
         $statement->bindParam(':argFechaCalendario' , $arg_Fecha_Calendario);  // reemplazo los parametros enlazados  
         $statement->execute();

         return $statement->fetch(PDO::FETCH_ASSOC);
       // $coincidencias_Encontradas = $statement->rowCount(); 

       // $statement = $db->cerrar_conexion($conexion);

     } catch (PDOException $e) {
         echo "Mensaje de la excepción: ".$e->getMessage()."<br>";
     }

 }