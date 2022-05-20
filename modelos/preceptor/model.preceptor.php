<?php 

function buscar_preceptores(){
	
	$resultado_preceptores = array();  // creo un array que va a almacenar la informacion de los anos lectivos

	$db = new ConexionDB;
	$conexion = $db->retornar_conexion();

    $sql_division_preceptores = "SELECT * FROM preceptores p1, personas p2 WHERE p1.rela_persona_id = p2.persona_id"; // busca a todos los preceptor

    $statement = $conexion->prepare($sql_division_preceptores);

    $statement->execute();

    if (!$statement){
            // no se encontraron paises
    }else{
            // reviso el retorno

    	while($resultado = $statement->fetch(PDO::FETCH_ASSOC)){
    		$resultado_preceptores[]= $resultado;
    	}
    }
        // cierro la conexion
    $statement = $db->cerrar_conexion($conexion);
    return $resultado_preceptores;


}

?>