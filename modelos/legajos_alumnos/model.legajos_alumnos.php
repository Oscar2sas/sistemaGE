<?php 
    
    function buscar_legajos_alumnos(){

        $carreras = array();  // creo un array que va a almacenar la informacion de las carreras

        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "SELECT personas.persona_id, alumnos.alumno_id, personas.capellidos_persona, personas.cnombres_persona, personas.ndni_persona, alumnos.cnumlegajo_alumno, personas.ncuil_persona, personas.cemail_persona, personas.dfechanac_persona, sexos.cdescripcion_sexo, alumnos.cestado_legajo, alumnos.nsituacion_alumno, alumnos.balumno_regular, telefonos.ntipo_telefono, telefonos.cnumero_telefono, direcciones.cmanzana_direccion, direcciones.ccasa_direccion, direcciones.csector_direccion, direcciones.clote_direccion, direcciones.cparcela_direccion, direcciones.cdescripcion_direccion, barrios.cnombre_barrio, calles.cnombre_calle, alumnos.rela_persona_id_tutor1, alumnos.rela_persona_id_tutor2, alumnos.rela_persona_id_tutor3 FROM alumnos INNER JOIN personas INNER JOIN sexos INNER JOIN telefonos INNER JOIN direcciones INNER JOIN barrios INNER JOIN calles WHERE alumnos.rela_persona_id = personas.persona_id AND personas.rela_sexo_id = sexos.sexo_id AND telefonos.rela_persona_id = personas.persona_id AND direcciones.rela_persona_id = personas.persona_id AND barrios.barrio_id = direcciones.rela_barrio_id AND direcciones.rela_calle_id = calles.calle_id" ; // busca todas las localidades

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