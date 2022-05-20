<?php 

function mostrar_anos_lectivos(){

        $anos_lectivos = array();  // creo un array que va a almacenar la informacion de los anos lectivos

        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql_anos_lectivos = "SELECT * FROM anos_lectivos"; // busca todos los anos lectivos

        $statement = $conexion->prepare($sql_anos_lectivos);

        $statement->execute();
        
        if (!$statement){
            // no se encontraron paises
        }else{
            // reviso el retorno

            while($resultado = $statement->fetch(PDO::FETCH_ASSOC)){
                $anos_lectivos[] = $resultado;
            }
        }
        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);
        return $anos_lectivos;
    }

// Funcion para obtener un ano lectivo
    function buscar_ano_lectivo($argID){

        $ano_lectivo = array();  // creo un array que va a almacenar la informacion de los anos lectivos

        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql_ano_lectivo = "SELECT * FROM anos_lectivos WHERE anolectivo_id = :arganolectivo_id"; // busca todos los anos lectivos

        $statement = $conexion->prepare($sql_ano_lectivo);

        $statement->bindParam(':arganolectivo_id' , $argID);  // reemplazo los parametros enlazados 

        $statement->execute();
        
        if (!$statement){
            // no se encontraron paises
        }else{
            // reviso el retorno

            while($resultado = $statement->fetch(PDO::FETCH_ASSOC)){
                $ano_lectivo = $resultado;
            }
        }
        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);
        return $ano_lectivo;

    }

// Funcion para insertar nuevo ano lectivo
    function insertar_nuevo_ano_lectivo($arg_POST_Ano){
        // var_dump($arg_POST_Ano);
        $ultimo_id=0;
        $estado_ano_lectivo_por_defecto = 0;
        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "INSERT INTO anos_lectivos(ndescripcion_anolectivo, dfechainicio_anolectivo, dfechafinclases_anolectivo, dfechafin_anolectivo, bactivo_anolectivo) 
        VALUES (
        :argndescripcionanolectivo, :argdfechainicio_anolectivo, 
        :argdfechafinclases_anolectivo, :argdfechafin_anolectivo, 
        :argbactivo_anolectivo
    )";


        // preparo el sql para enviar   se puede usar prepare y bindparam 
    $statement = $conexion->prepare($sql);

        $statement->bindParam(':argndescripcionanolectivo' , $arg_POST_Ano['descripcionAnoLectivo']);  // reemplazo los parametros enlazados 
        $statement->bindParam(':argdfechainicio_anolectivo' , $arg_POST_Ano['fechaInicio']);  // reemplazo los parametros enlazados 
        $statement->bindParam(':argdfechafinclases_anolectivo' , $arg_POST_Ano['fechaFinClases']);  // reemplazo los parametros enlazados 
        $statement->bindParam(':argdfechafin_anolectivo' , $arg_POST_Ano['fechaFinAnoLectivo']);  // reemplazo los parametros enlazados
        $statement->bindParam(':argbactivo_anolectivo' , $estado_ano_lectivo_por_defecto);  // reemplazo los parametros enlazados
        

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

// Funcion para actualizar ano lectivo
    function actualizar_ano_lectivo($arg_POST_Ano){

        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "UPDATE anos_lectivos 
        SET ndescripcion_anolectivo= :argndescripcion_anolectivo,
        dfechainicio_anolectivo=:argdfechainicio_anolectivo,
        dfechafinclases_anolectivo=:argdfechafinclases_anolectivo,
        dfechafin_anolectivo=:argdfechafin_anolectivo,
        bactivo_anolectivo= :argbactivo_anolectivo 
        WHERE anolectivo_id = :arganolectivo_id";
        
        // preparo el sql para enviar   se puede usar prepare   y bindparam 
        $statement = $conexion->prepare($sql);
        
        $statement->bindParam(':argndescripcion_anolectivo' , $arg_POST_Ano['descripcionAnoLectivo']);  // reemplazo los parametros enlazados 
        $statement->bindParam(':argdfechainicio_anolectivo' , $arg_POST_Ano['fechaInicio']);  // reemplazo los parametros enlazados   
        $statement->bindParam(':argdfechafinclases_anolectivo' , $arg_POST_Ano['fechaFinClases']);  // reemplazo los parametros enlazados   
        $statement->bindParam(':argdfechafin_anolectivo' , $arg_POST_Ano['fechaFinAnoLectivo']);  // reemplazo los parametros enlazados   
        $statement->bindParam(':argbactivo_anolectivo' , $arg_POST_Ano['estadoAnoLectivo']);  // reemplazo los parametros enlazados   
        $statement->bindParam(':arganolectivo_id' , $arg_POST_Ano['idAnoLectivo']);  // reemplazo los parametros enlazados   
        
        if(!$statement){
            echo "Error al crear el registro";
        }else{
            $statement->execute();
        }

        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);

    }
// Funcion para verificar si existe un ano lectivo por medio de la descripcion
    function buscar_Descripcion_Ano_Lectivo($arg_Descripcion_Ano_Lectivo){

     $db = new ConexionDB;
     $conexion = $db->retornar_conexion();

     $sql = "SELECT * FROM anos_lectivos WHERE ndescripcion_anolectivo = :argndescripcion_anolectivo";

     try {

        // preparo el sql para enviar   se puede usar prepare   y bindparam 
        $statement = $conexion->prepare($sql);
        $statement->bindParam(':argndescripcion_anolectivo' , $arg_Descripcion_Ano_Lectivo);  // reemplazo los parametros enlazados 
        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
        // $coincidencias_Encontradas = $statement->rowCount(); 
        
        // $statement = $db->cerrar_conexion($conexion);
        
        // return $coincidencias_Encontradas; 

    } catch (PDOException $e) {
        echo "Mensaje de la excepción: ".$e->getMessage()."<br>";
    }
}

// Funcion para verificar el estado de un ano lectivo por medio de su ID
function buscar_Estado_Ano_Lectivo_Id($argID){

    $db = new ConexionDB;
    $conexion = $db->retornar_conexion();

    $sql = "SELECT * FROM `anos_lectivos` WHERE `bactivo_anolectivo` =  :arg_id_anolectivo";

    try {

       // preparo el sql para enviar   se puede usar prepare   y bindparam 
       $statement = $conexion->prepare($sql);
       $statement->bindParam(':arg_id_anolectivo' , $argID);  // reemplazo los parametros enlazados 
       $statement->execute();

       return $statement->fetch(PDO::FETCH_ASSOC);
       // $coincidencias_Encontradas = $statement->rowCount(); 
       
       // $statement = $db->cerrar_conexion($conexion);

   } catch (PDOException $e) {
       echo "Mensaje de la excepción: ".$e->getMessage()."<br>";
   }

}

function buscar_Ano_Lectivo_Activo(){
  $db = new ConexionDB;
  $conexion = $db->retornar_conexion();

  $sql = "SELECT * FROM anos_lectivos WHERE bactivo_anolectivo = 1";

  try {

       // preparo el sql para enviar   se puede usar prepare   y bindparam 
   $statement = $conexion->prepare($sql); 
   $statement->execute();

   return $statement->fetch(PDO::FETCH_ASSOC);
       // $coincidencias_Encontradas = $statement->rowCount(); 
   
       // $statement = $db->cerrar_conexion($conexion);

} catch (PDOException $e) {
   echo "Mensaje de la excepción: ".$e->getMessage()."<br>";
}

}