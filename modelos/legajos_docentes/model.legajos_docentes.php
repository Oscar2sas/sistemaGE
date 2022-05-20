<?php 
    
    function buscar_legajos_docentes(){

        $carreras = array();  // creo un array que va a almacenar la informacion de las carreras

        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "SELECT personas.persona_id, docentes.docente_id, personas.capellidos_persona, personas.cnombres_persona, personas.ndni_persona, personas.ncuil_persona, personas.cemail_persona, personas.dfechanac_persona, docentes.cnumlegajo_docente, docentes.cnumregistro_docente, docentes.cestado_legajo, telefonos.ntipo_telefono, telefonos.cnumero_telefono, direcciones.cmanzana_direccion, direcciones.ccasa_direccion, direcciones.csector_direccion, direcciones.clote_direccion, direcciones.cparcela_direccion, direcciones.cdescripcion_direccion, barrios.cnombre_barrio, calles.cnombre_calle FROM docentes INNER JOIN personas INNER JOIN telefonos INNER JOIN direcciones INNER JOIN barrios INNER JOIN calles WHERE docentes.rela_persona_id = personas.persona_id AND telefonos.rela_persona_id = personas.persona_id AND direcciones.rela_persona_id = personas.persona_id AND barrios.barrio_id = direcciones.rela_barrio_id AND direcciones.rela_calle_id = calles.calle_id" ; // busca todas las localidades

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

    function buscar_historiales_materias($arg_docente_id){

        $carreras = array();  // creo un array que va a almacenar la informacion de las carreras

        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "SELECT md.docente_id,md.curso_id,md.materia_id,

(CASE WHEN md.nsituacion_docente = 1 THEN 'TITULAR' 
  WHEN md.nsituacion_docente = 2 THEN 'INTERINO' 
  WHEN md.nsituacion_docente = 3 THEN 'SUPLENTE'  
  ELSE 'SUPLENTE' END) AS situacion_docente ,
  
cursos.cdescripcion_curso,materias.cnombre_materia 

FROM (

  (SELECT rela_docente_id1 AS docente_id, rela_curso_id AS curso_id,
       rela_materia_id_modulo1 AS materia_id, nsituacion_docente1 AS nsituacion_docente FROM cursos_horarios_materias
       WHERE rela_docente_id1 = :arg_docente_id )
       
  UNION ALL
       
    (SELECT rela_docente_id2 AS docente_id, rela_curso_id AS curso_id,
       rela_materia_id_modulo2 AS materia_id, nsituacion_docente2 AS nsituacion_docente FROM cursos_horarios_materias
       WHERE rela_docente_id2 = :arg_docente_id ) 
       
  UNION ALL
       
    (SELECT rela_docente_id3 AS docente_id, rela_curso_id AS curso_id,
       rela_materia_id_modulo3 AS materia_id, nsituacion_docente3 AS nsituacion_docente FROM cursos_horarios_materias
       WHERE rela_docente_id3 = :arg_docente_id ) 
             
  UNION ALL
       
    (SELECT rela_docente_id4 AS docente_id, rela_curso_id AS curso_id,
       rela_materia_id_modulo4 AS materia_id, nsituacion_docente4 AS nsituacion_docente FROM cursos_horarios_materias
       WHERE rela_docente_id4 = :arg_docente_id ) 
                   
  UNION ALL
       
    (SELECT rela_docente_id5 AS docente_id, rela_curso_id AS curso_id,
       rela_materia_id_modulo5 AS materia_id, nsituacion_docente5 AS nsituacion_docente FROM cursos_horarios_materias
       WHERE rela_docente_id5 = :arg_docente_id ) 
                   
  UNION ALL
       
    (SELECT rela_docente_id6 AS docente_id, rela_curso_id AS curso_id,
       rela_materia_id_modulo6 AS materia_id, nsituacion_docente6 AS nsituacion_docente FROM cursos_horarios_materias
       WHERE rela_docente_id6 = :arg_docente_id ) 
       
  UNION ALL
       
    (SELECT rela_docente_id7 AS docente_id, rela_curso_id AS curso_id,
       rela_materia_id_modulo7 AS materia_id, nsituacion_docente7 AS nsituacion_docente FROM cursos_horarios_materias
       WHERE rela_docente_id7 = :arg_docente_id ) 
             

) AS md 

LEFT JOIN cursos ON cursos.curso_id = md.curso_id
LEFT JOIN materias ON materias.materia_id = md.materia_id 

GROUP BY cdescripcion_curso,cnombre_materia,situacion_docente

  "; // busca todas las localidades

        $statement = $conexion->prepare($sql);

        $statement->bindParam(':arg_docente_id' , $arg_docente_id);
        
        if(!$statement){
            echo "Error al crear el registro";
        }else{
            $statement->execute();
        }

        if (!$statement) {
            //no se encontraron localidades
        }
        else {
        
            //reviso el retorno

            while($resultado = $statement->fetch(PDO::FETCH_ASSOC)){
                $carreras[] = $resultado;
            }
        }

        //cierro la conexion
        $statement = $db->cerrar_conexion($conexion);

        return $carreras;
    }
 ?>