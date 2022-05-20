<?php 
    
    function buscar_legajos_personal(){

        $carreras = array();  // creo un array que va a almacenar la informacion de las carreras

        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "SELECT personas.persona_id, personales.personal_id, personas.capellidos_persona, personas.cnombres_persona, personas.ndni_persona, personas.ncuil_persona, personas.cemail_persona, personas.dfechanac_persona, sexos.cdescripcion_sexo, personales.cnumlegajo_personal, personales.nsituacion_personal, personales.cobservaciones_personal, cargos.cdescripcion_cargo, telefonos.ntipo_telefono, telefonos.cnumero_telefono, direcciones.cmanzana_direccion, direcciones.ccasa_direccion, direcciones.csector_direccion, direcciones.clote_direccion, direcciones.cparcela_direccion, direcciones.cdescripcion_direccion, barrios.cnombre_barrio, calles.cnombre_calle FROM personales INNER JOIN personas INNER JOIN sexos INNER JOIN cargos INNER JOIN telefonos INNER JOIN direcciones INNER JOIN barrios INNER JOIN calles WHERE personales.rela_persona_id = personas.persona_id AND personas.rela_sexo_id = sexos.sexo_id AND personales.rela_cargo_id = cargos.cargol_id AND telefonos.rela_persona_id = personas.persona_id AND direcciones.rela_persona_id = personas.persona_id AND barrios.barrio_id = direcciones.rela_barrio_id AND direcciones.rela_calle_id = calles.calle_id" ; // busca todas las localidades

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
 ?>