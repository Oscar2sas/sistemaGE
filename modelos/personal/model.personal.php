<?php 

function buscar_personal($arg_textoabuscar){
	
	$resultado_personal = array();  // creo un array que va a almacenar la informacion de los anos lectivos

	$db = new ConexionDB;
	$conexion = $db->retornar_conexion();

    $sql_personal = "SELECT personales.*,personas.capellidos_persona,personas.cnombres_persona,personas.ndni_persona FROM `personales` 
    left join personas on personales.rela_persona_id= personas.persona_id";

    if (!empty($arg_textoabuscar)){

        $sql_personal
    }


    $statement = $conexion->prepare($sql_personal);

    $statement->execute();

    if (!$statement){
            // no se encontraron paises
    }else{
            // reviso el retorno

    	while($resultado = $statement->fetch(PDO::FETCH_ASSOC)){
    		$resultado_personal[]= $resultado;
    	}
    }
        // cierro la conexion
    $statement = $db->cerrar_conexion($conexion);
    return $resultado_personal;


}

function buscar_un_personal($arg_personal_id){

    $personal = array();  // creo un array que va a almacenar la informacion del pais

    $db = new ConexionDB;
    $conexion = $db->retornar_conexion();

    $sql = "SELECT personales.*, personas.capellidos_persona as capellidos_persona, personas.cnombres_persona as cnombres_persona, personas.ndni_persona as ndni_persona from personales, personas where personales.personal_id = :arg_personal_id";
    
    $statement = $conexion->prepare($sql);
    
    $statement->bindParam(':arg_personal_id' , $arg_personal_id);  // reemplazo los parametros enlazados 
    
    
    if(!$statement){
        echo "Error al crear el registro";
    }else{
        $statement->execute();
    }

    if (!$statement) {
        // no se encontraron paises
    }
    else {
    
        $personal = $statement->fetch(PDO::FETCH_ASSOC);   // porque es un solo resultado

    }

    // cierro la conexion
    $statement = $db->cerrar_conexion($conexion);

    return $personal;

}

function insertar_personal($arg_cnumlegajo_personal,$arg_cobservaciones_personal,$arg_rela_persona_id,$arg_tipo_cargo_id){

    $ultimo_id=0;
   
    $db = new ConexionDB;
    $conexion = $db->retornar_conexion();

    $sql = "INSERT INTO personales (cnumlegajo_personal, cobservaciones_personal, rela_persona_id,  rela_cargo_id) VALUES ('$arg_cnumlegajo_personal', '$arg_cobservaciones_personal', $arg_rela_persona_id, $arg_tipo_cargo_id)";



    // preparo el sql para enviar   se puede usar prepare   y bindparam 
    $statement = $conexion->prepare($sql);
    
    /*$statement->bindParam(':arg_cobservaciones' , $arg_cobservaciones_personal);  // reemplazo los parametros enlazados 
    $statement->bindParam(':arg_cnumlegajo_personal' , $arg_cnumlegajo_personal);  // reemplazo los parametros enlazados 
    $statement->baindParam(':arg_rela_persona_id', $arg_rela_persona_id);
    $statement->baindParam(':arg_rela_cargo_id', $arg_rela_cargo_id);
    */

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
function eliminar_historial_del_personal($arg_personal_id){

       
    $db = new ConexionDB;
    $conexion = $db->retornar_conexion();

    $sql = "DELETE FROM historiales_personal WHERE rela_personal_id = $arg_personal_id";
    
    // preparo el sql para enviar   se puede usar prepare   y bindparam 
    $statement = $conexion->prepare($sql);
    
//echo $sql;
//die();
    if(!$statement){
        echo "Error al crear el registro";
    }else{
        $statement->execute();
    }

    // cierro la conexion
    $statement = $db->cerrar_conexion($conexion);
}

function eliminar_personal($arg_persona_id){

       
    $db = new ConexionDB;
    $conexion = $db->retornar_conexion();

    $sql = "DELETE FROM personales WHERE personal_id = $arg_persona_id";
    
    // preparo el sql para enviar   se puede usar prepare   y bindparam 
    $statement = $conexion->prepare($sql);
    
    //$statement->bindParam(':arg_persona_id' , $arg_persona_id);  // reemplazo los parametros enlazados   
//echo $sql;
//die();
    if(!$statement){
        echo "Error al crear el registro";
    }else{
        $statement->execute();
    }

    // cierro la conexion
    $statement = $db->cerrar_conexion($conexion);
}
function persona_actualizar($arg_cnombres_persona,$arg_capellidos_persona, $arg_ndni_persona, $arg_persona_id){

       
    $db = new ConexionDB;
    $conexion = $db->retornar_conexion();
    $sql = "UPDATE personas set  cnombres_persona = '$arg_cnombres_persona', capellidos_persona = '$arg_capellidos_persona', ndni_persona = $arg_ndni_persona WHERE persona_id = $arg_persona_id";

//echo $sql;
//die();

   
    // preparo el sql para enviar   se puede usar prepare   y bindparam 
    $statement = $conexion->prepare($sql);
 
    //$statement->bindParam(':arg_cnombres_persona' , $arg_cnombres_persona);  // reemplazo los parametros enlazados 
    //$statement->bindParam(':arg_capellidos_persona' , $arg_capellidos_persona);  // reemplazo los parametros enlazados   
    //$statement->bindParam(':arg_ndni_persona' , $arg_ndni_persona); 
    //$statement->bindParam(':arg_persona_id' , $arg_persona_id); 
    
    if(!$statement){
        echo "Error al crear el registro";
    }else{
        $statement->execute();
    }
}
function personal_actualizar( $arg_cobservaciones_personal, $arg_cnumlegajo_personal, $personal_id){

       
    $db = new ConexionDB;
    $conexion = $db->retornar_conexion();
    $sql = "UPDATE personales set  cobservaciones_personal = '$arg_cobservaciones_personal' ,cnumlegajo_personal = '$arg_cnumlegajo_personal' WHERE personal_id = $personal_id";

// $sql;
//die();

   
    // preparo el sql para enviar   se puede usar prepare   y bindparam 
    $statement = $conexion->prepare($sql);

    //$statement->bindParam(':arg_cobservaciones_personal' , $arg_cobservaciones_personal);  // reemplazo los parametros enlazados 
    //$statement->bindParam(':arg_cnumlegajo_personal' , $arg_cnumlegajo_personal);  // reemplazo los parametros enlazados 

    
    if(!$statement){
        echo "Error al crear el registro";
    }else{
        $statement->execute();
    }

    // cierro la conexion
    $statement = $db->cerrar_conexion($conexion);
}


?>