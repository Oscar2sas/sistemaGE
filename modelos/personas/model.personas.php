<?php 

   
    function buscar_persona($arg_textoabuscar){

        $personas = array();  // creo un array que va a almacenar la informacion de los paises

        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "SELECT *,telefonos.cnumero_telefono,telefonos.ntipo_telefono, sexos.cdescripcion_sexo FROM personas left join sexos on personas.rela_sexo_id = sexos.sexo_id left join telefonos on telefonos.rela_persona_id = personas.persona_id"; // busca todas las personas

        /*if (!empty($arg_textoabuscar)) {
        
            $sql = $sql." WHERE capellidos_persona LIKE ':arg_textoabuscar' OR cnombres_persona LIKE :arg_textoabuscar";   // filtra busqueda 

            $arg_textoabuscar="%".TRIM($arg_textoabuscar)."%";
        }*/

        $sql = $sql." ORDER BY cnombres_persona";  
        
        $statement = $conexion->prepare($sql);
        
        /*$statement->bindParam(':arg_textoabuscar' , $arg_textoabuscar);*/  // reemplazo los parametros enlazados 
        
        
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

                $personas[] = $resultado;

            }
        }

        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);

        return $personas;

    }

    function buscar_una_persona($arg_persona_id){

        $persona = array();  // creo un array que va a almacenar la informacion del pais

        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "SELECT * FROM personas WHERE persona_id =:arg_persona_id";  // busca un solo registor
        
        $statement = $conexion->prepare($sql);
        
        $statement->bindParam(':arg_persona_id' , $arg_persona_id);  // reemplazo los parametros enlazados 
        
        
        if(!$statement){
            echo "Error al crear el registro";
        }else{
            $statement->execute();
        }

        if (!$statement) {
            // no se encontraron paises
        }
        else {
        
            $persona = $statement->fetch(PDO::FETCH_ASSOC);   // porque es un solo resultado

        }

        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);

        return $persona;

    }


    function insertar_persona($arg_capellidos_persona, $arg_cnombres_persona, $arg_ndni_persona, $arg_ncuil_persona, $arg_cemail_persona, $arg_dfechanac_persona, $rela_sexo_id, $rela_pais_id){

        $ultimo_id=0;
        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();
    
        $sql = "INSERT INTO personas (capellidos_persona, cnombres_persona, ndni_persona, ncuil_persona, cemail_persona, dfechanac_persona, rela_sexo_id) VALUES  ('$arg_capellidos_persona', '$arg_cnombres_persona', $arg_ndni_persona, $arg_ncuil_persona, '$arg_cemail_persona', '$arg_dfechanac_persona', $rela_sexo_id)";

        // preparo el sql para enviar   se puede usar prepare   y bindparam 
        $statement = $conexion->prepare($sql);
        
        $statement->bindParam('$conexionarg_capellidos_persona' , $arg_capellidos_persona);  // reemplazo los parametros enlazados
        $statement->bindParam('$conexionarg_cnombres_persona' , $arg_cnombres_persona);
        $statement->bindParam(':arg_ndni_persona' , $arg_ndni_persona);
        $statement->bindParam(':arg_ncuil_persona' , $arg_ncuil_persona);
        $statement->bindParam(':arg_cemail_persona' , $arg_cemail_persona); 
        $statement->bindParam(':arg_dfechanac_persona' , $arg_dfechanac_persona); 
        
        
        if(!$statement){
            echo "Error al crear el registro";
        }else{
            $statement->execute();
        }
        
       
        $ultimo_id = $conexion->lastinsertid();
        
        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);

        //var_dump($arg_capellidos_persona, $arg_cnombres_persona, $arg_ndni_persona, $arg_ncuil_persona, $arg_cemail_persona, $arg_dfechanac_persona, $rela_sexo_id, $rela_calle_id, $rela_barrio_id, $rela_localidad_id,$rela_pais_id);
        //die();

        return $ultimo_id;
    }


    function actualizar_persona($arg_persona_id,$arg_capellidos_persona, $arg_cnombres_persona, $arg_ndni_persona, $arg_ncuil_persona, $arg_cemail_persona, $arg_dfechanac_persona){

       
        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "UPDATE personas set capellidos_persona = :arg_capellidos_persona, cnombres_persona = :arg_cnombres_persona, ndni_persona = :arg_ndni_persona, ncuil_persona = :arg_ncuil_persona, cemail_persona = :arg_cemail_persona, dfechanac_persona = :arg_dfechanac_persona WHERE persona_id = :arg_persona_id";
        
        
        // preparo el sql para enviar   se puede usar prepare   y bindparam 
        $statement = $conexion->prepare($sql); 

        $statement->bindParam(':arg_persona_id' , $arg_persona_id);  // reemplazo los parametros enlazados
        $statement->bindParam(':arg_capellidos_persona' , $arg_capellidos_persona); 
        $statement->bindParam(':arg_cnombres_persona' , $arg_cnombres_persona); 
        $statement->bindParam(':arg_ndni_persona' , $arg_ndni_persona); 
        $statement->bindParam(':arg_ncuil_persona' , $arg_ncuil_persona); 
        $statement->bindParam(':arg_cemail_persona' , $arg_cemail_persona);
        $statement->bindParam(':arg_dfechanac_persona' , $arg_dfechanac_persona);

        if(!$statement){
            echo "Error al crear el registro";
        }else{
            $statement->execute();
        }

        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);

    }
    
    
    function eliminar_persona($arg_persona_id){

       
        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        //telefono
        $sql_telefono = "DELETE FROM telefonos where rela_persona_id=:arg_persona_id";
        
        // preparo el sql para enviar   se puede usar prepare   y bindparam 
        $statement = $conexion->prepare($sql_telefono);
               
        $statement->bindParam(':arg_persona_id' , $arg_persona_id);  // reemplazo los parametros enlazados   
               
        if(!$statement){
            echo "Error al crear el registro";
        }else{
           $statement->execute();
        }
               

        //direccion
        $sql_direccion = "DELETE FROM direcciones WHERE rela_persona_id= :arg_persona_id";
        
        // preparo el sql para enviar   se puede usar prepare   y bindparam 
        $statement = $conexion->prepare($sql_direccion);
        
        $statement->bindParam(':arg_persona_id' , $arg_persona_id);  // reemplazo los parametros enlazados   
        
        if(!$statement){
            echo "Error al crear el registro";
        }else{
            $statement->execute();
        }

 
        //persona
        $sql_persona = "DELETE FROM personas WHERE persona_id = :arg_persona_id";
        
        // preparo el sql para enviar   se puede usar prepare   y bindparam 
        $statement = $conexion->prepare($sql_persona);
        
        $statement->bindParam(':arg_persona_id' , $arg_persona_id);  // reemplazo los parametros enlazados   
        
        if(!$statement){
            echo "Error al crear el registro";
        }else{
            $statement->execute();
        }

        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);

    }
    function mostrar_datos_personas($arg_persona_id){


        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();
        $sql="SELECT *, sexos.cdescripcion_sexo, telefonos.cnumero_telefono, telefonos.ntipo_telefono, direcciones.cmanzana_direccion, direcciones.ccasa_direccion,direcciones.csector_direccion, direcciones.clote_direccion, direcciones.clote_direccion, direcciones.cparcela_direccion , barrios.cnombre_barrio, calles.cnombre_calle, localidades.cnombre_localidad, provincias.cnombre_provincia, paises.cnombre_pais FROM personas LEFT JOIN sexos ON sexos.sexo_id = personas.rela_sexo_id LEFT JOIN telefonos ON telefonos.rela_persona_id= personas.persona_id, direcciones LEFT JOIN barrios ON barrios.barrio_id = direcciones.rela_barrio_id LEFT JOIN calles ON calles.calle_id = direcciones.rela_calle_id LEFT JOIN localidades ON direcciones.rela_localidad_id = localidades.localidad_id LEFT JOIN provincias ON provincias.provincia_id = localidades.rela_provincia_id LEFT JOIN paises ON paises.pais_id = provincias.rela_pais_id WHERE direcciones.rela_persona_id = personas.persona_id  AND personas.persona_id = :arg_persona_id";

        // preparo el sql para enviar   se puede usar prepare   y bindparam
        $statement = $conexion->prepare($sql);
        
        $statement->bindParam(':arg_persona_id' , $arg_persona_id);  // reemplazo los parametros enlazados   
    
        
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

                $datos[] = $resultado;

            }
        }
        
        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);
 
        return $datos;
    }


?> 