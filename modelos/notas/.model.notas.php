<?php 

   
 function buscar_notas($arg_textoabuscar){

        $notas = array();  // creo un array que va a almacenar la informacion de las provincias

        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "SELECT notas_id,rela_anolectivo_id,rela_curso_id,rela_materia_id,cdescripcion_etapa,ncalificacion, cnombre_materia, ndescripcion_anolectivo, capellidos_persona, cnombres_persona, cdescripcion_curso FROM notas"
               . " LEFT JOIN anos_lectivos ON notas.rela_anolectivo_id = anos_lectivos.anolectivo_id"
               . " LEFT JOIN materias ON notas.rela_materia_id = materias.materia_id" 
               . " LEFT JOIN (SELECT alumno_id, capellidos_persona, cnombres_persona, persona_id FROM alumnos LEFT JOIN personas ON alumnos.rela_persona_id = personas.persona_id) AS alumnos ON alumnos.alumno_id = notas.rela_alumno_id"
               . " LEFT JOIN cursos ON notas.rela_curso_id = cursos.curso_id"
               . " LEFT JOIN etapas_escolares ON notas.rela_etapaescolar_id = etapas_escolares.etapaescolar_id";

                                          
        if (!empty($arg_textoabuscar)) {
                                            
            $sql="SELECT N1.notas_id,N1.ncalificacion,N1.rela_anolectivo_id,N1.rela_curso_id,N1.rela_alumno_id, N1.rela_materia_id, N1.rela_etapaescolar_id, E1.etapaescolar_id, E1.cdescripcion_etapa, M1.cnombre_materia, M1.materia_id, A1.anolectivo_id, A1.ndescripcion_anolectivo, P1.persona_id, P1.capellidos_persona, P1.cnombres_persona, C1.cdescripcion_curso, C1.curso_id, A2.alumno_id, A2.rela_persona_id FROM notas N1, anos_lectivos A1, etapas_escolares E1, materias M1, alumnos A2, cursos C1, personas P1 WHERE A2.rela_persona_id=P1.persona_id AND N1.rela_alumno_id=A2.alumno_id AND N1.rela_materia_id=M1.materia_id AND N1.rela_etapaescolar_id=E1.etapaescolar_id AND N1.rela_curso_id=C1.curso_id AND N1.rela_anolectivo_id=A1.anolectivo_id AND( P1.capellidos_persona LIKE :arg_textoabuscar OR P1.cnombres_persona LIKE :arg_textoabuscar)";
            $arg_textoabuscar="%".TRIM($arg_textoabuscar)."%";
        }
                                                    
        $sql = $sql." ORDER BY ncalificacion";  
        
        $statement = $conexion->prepare($sql);
        
        $statement->bindParam(':arg_textoabuscar' , $arg_textoabuscar);  // reemplazo los parametros enlazados 
        
        
        if(!$statement){
            echo "Error al crear el registro";
        }else{
            $statement->execute();
        }

        if (!$statement) {
            
        }
        else {
        
            // reviso el retorno

            while($resultado = $statement->fetch(PDO::FETCH_ASSOC)){

                $notas[] = $resultado;

            }
        }

        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);

        return $notas;

    }

function buscar_una_nota($arg_notas_id){

        $notas = array();  // creo un array que va a almacenar la informacion de la provincia

        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "SELECT 	notas_id,rela_anolectivo_id,rela_curso_id,rela_materia_id,rela_etapaescolar_id,ncalificacion FROM notas where notas_id = $arg_notas_id";  // busca un solo registro
        
        $statement = $conexion->query($sql);
        
        //$statement->bindParam(':arg_notas_id' , $arg_notas_id);  // reemplazo los parametros enlazados 
        
        
        //if(!$statement){
            //echo "Error al crear el registro";
       // }else{
            //$statement->execute();
       // }

        if (!$statement) {
            // no se encontraron provincias
        }
        else {
        
            $nota = $statement->fetch(PDO::FETCH_ASSOC);   // porque es un solo resultado
            //var_dump($notas);
            //die();
           
            if (!$nota) { // si el valor es falso
                $nota = array();  // vuelvo a crear un array que va a almacenar la informacion del provincia
            }

        }

        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);

        return $nota;

    }

function buscar_anoslectivos(){
        $anoslectivos=array(); 

        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();
        
        $sql= "SELECT anolectivo_id, ndescripcion_anolectivo, dfechainicio_anolectivo, dfechafinclases_anolectivo, dfechafin_anolectivo, bactivo_anolectivo FROM anos_lectivos";  

   $statement = $conexion->prepare($sql);

   if(!$statement){
    echo "Error al crear el registro";
   }else{
    $statement->execute();
   }

   if (!$statement) {
   // no se encontraron personas
   }else{

   // reviso el retorno

       while($resultado = $statement->fetch(PDO::FETCH_ASSOC)){

        $anoslectivos[] = $resultado;

       }
   }

   // cierro la conexion
   $statement = $db->cerrar_conexion($conexion);

   return $anoslectivos;
}

    function buscar_alumnos(){
        $alumnos=array(); //creo un array que va a almacenar la informacion de las personas

        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();
        
        $sql= "SELECT alumno_id,cnumlegajo_alumno,nsituacion_alumno,balumno_regular,rela_estadoalumno_id,rela_persona_id,rela_persona_id_tutor1,rela_persona_id_tutor2,rela_persona_id_tutor3,persona_id,capellidos_persona,
        cnombres_persona,ndni_persona,ncuil_persona,cemail_persona,dfechanac_persona FROM alumnos 
        INNER JOIN personas ON alumnos.rela_persona_id=personas.persona_id"; //Busacar todos los alumnos 

           $sql = $sql." ORDER BY capellidos_persona,cnombres_persona";  

   $statement = $conexion->prepare($sql);

   if(!$statement){
    echo "Error al crear el registro";
   }else{
    $statement->execute();
   }

   if (!$statement) {
   // no se encontraron personas
   }else{

   // reviso el retorno

       while($resultado = $statement->fetch(PDO::FETCH_ASSOC)){

        $alumnos[] = $resultado;

       }
   }

   // cierro la conexion
   $statement = $db->cerrar_conexion($conexion);

   return $alumnos;
}


function buscar_cursos(){
    $cursos=array(); //creo un array que va a almacenar la informacion de las cursos

    $db = new ConexionDB;
    $conexion = $db->retornar_conexion();
    
    $sql= "SELECT curso_id, cdescripcion_curso, rela_carrera_id FROM cursos";  

$statement = $conexion->prepare($sql);

if(!$statement){
echo "Error al crear el registro";
}else{
$statement->execute();
}

if (!$statement) {
// no se encontraron cursos
}else{

// reviso el retorno

   while($resultado = $statement->fetch(PDO::FETCH_ASSOC)){

    $cursos[] = $resultado;

   }
}

// cierro la conexion
$statement = $db->cerrar_conexion($conexion);

return $cursos;
}

function buscar_materias(){
    $materias=array(); //creo un array que va a almacenar la informacion de las personas

    $db = new ConexionDB;
    $conexion = $db->retornar_conexion();
    
    $sql= "SELECT materia_id,cnombre_materia FROM materias"; //Busacar todos los alumnos  

$statement = $conexion->prepare($sql);

if(!$statement){
echo "Error al crear el registro";
}else{
$statement->execute();
}

if (!$statement) {
// no se encontraron personas
}else{

// reviso el retorno

   while($resultado = $statement->fetch(PDO::FETCH_ASSOC)){

    $materias[] = $resultado;

   }
}

// cierro la conexion
$statement = $db->cerrar_conexion($conexion);

return $materias;
}

function buscar_etapas(){
    $etapas=array(); //creo un array que va a almacenar la informacion de las personas

    $db = new ConexionDB;
    $conexion = $db->retornar_conexion();
    
    $sql= "SELECT etapaescolar_id,cdescripcion_etapa FROM etapas_escolares"; //Busacar todos los alumnos  

$statement = $conexion->prepare($sql);

if(!$statement){
echo "Error al crear el registro";
}else{
$statement->execute();
}

if (!$statement) {

}else{

// reviso el retorno

   while($resultado = $statement->fetch(PDO::FETCH_ASSOC)){

    $etapas[] = $resultado;

   }
}

// cierro la conexion
$statement = $db->cerrar_conexion($conexion);

return $etapas;
}


function insertar_nota($arg_rela_anolectivo_id, $arg_rela_curso_id, $arg_rela_materia_id, $arg_rela_alumno_id, $arg_rela_etapaescolar_id, $arg_ncalificacion){
        $ultimo_id=0;
       
        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "INSERT INTO notas (rela_anolectivo_id, rela_curso_id, rela_materia_id, rela_alumno_id, rela_etapaescolar_id,ncalificacion) VALUES ($arg_rela_anolectivo_id, $arg_rela_curso_id, $arg_rela_materia_id, $arg_rela_alumno_id, $arg_rela_etapaescolar_id, $arg_ncalificacion)";
        
        // preparo el sql para enviar   se puede usar prepare   y bindparam 
        $statement = $conexion->query($sql);
        
        //$statement->bindParam(':rela_alumno_id'  ,  $arg_rela_alumno_id);
        //$statement->bindParam(':capellidos_persona' , $arg_capellidos_persona);  // reemplazo los parametros enlazados
        //$statement->bindParam(':cnombres_persona' , $arg_cnombres_persona); 
        //$statement->bindParam(':cdescripcion_curso' , $arg_cdescripcion_curso); 
        //$statement->bindParam(':cnombre_materia' , $arg_cnombre_materia); 
        //$statement->bindParam(':cdescripcion_etapa' , $arg_cdescripcion_etapa); 
        //$statement->bindParam(':ndescripcion_anolectivo' , $arg_ndescripcion_anolectivo);
        //$statement->bindParam(':ncalificacion' , $arg_ncalificacion);  // reemplazo los parametros enlazados 
        
        //if(!$statement){
          //  echo "Error al crear el registro";
       // }else{
          //  $statement->execute();
       // }
        $ultimo_id = $conexion->lastinsertid();
        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);
        return $ultimo_id;
    }    //var_dump($cursos);
        //die();

 function actualizar_Notas($arg_notas_id, $arg_rela_anolectivo_id, $arg_rela_curso_id, $arg_rela_materia_id, $arg_rela_alumno_id, $arg_rela_etapaescolar_id, $arg_ncalificacion){
        $ultimo_id=0;
       
        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "UPDATE  notas set  ncalificacion = $arg_ncalificacion, rela_anolectivo_id = $arg_rela_anolectivo_id, rela_curso_id = $arg_rela_curso_id, rela_materia_id = $arg_rela_materia_id, rela_alumno_id = $arg_rela_alumno_id, rela_etapaescolar_id = $arg_rela_etapaescolar_id WHERE notas_id = $arg_notas_id";
        
         // preparo el sql para enviar   se puede usar prepare   y bindparam 
         $statement = $conexion->query($sql); 
         //$statement->bindParam(':rela_alumno_id'  ,  $arg_rela_alumno_id);
         //$statement->bindParam(':capellidos_persona' , $arg_capellidos_persona);  // reemplazo los parametros enlazados
         //$statement->bindParam(':cnombres_persona' , $arg_cnombres_persona); 
         //$statement->bindParam(':cdescripcion_curso' , $arg_cdescripcion_curso); 
         //$statement->bindParam(':cnombre_materia' , $arg_cnombre_materia); 
         //$statement->bindParam(':cdescripcion_etapa' , $arg_cdescripcion_etapa); 
         //$statement->bindParam(':ndescripcion_anolectivo' , $arg_ndescripcion_anolectivo);
         //$statement->bindParam(':ncalificacion' , $arg_ncalificacion);  // reemplazo los parametros enlazados 
         
         //if(!$statement){
           //  echo "Error al crear el registro";
        // }else{
           //  $statement->execute();
        // }
         $ultimo_id = $conexion->lastinsertid();
         // cierro la conexion
         $statement = $db->cerrar_conexion($conexion);
         return $ultimo_id;
     }    //var_dump($cursos);
         //die();
    
    
 function eliminar_notas($arg_notas_id){

        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "DELETE FROM notas WHERE notas_id = :arg_notas_id";
        
        // preparo el sql para enviar   se puede usar prepare   y bindparam 
        $statement = $conexion->prepare($sql);
        
        $statement->bindParam(':arg_notas_id' , $arg_notas_id);  // reemplazo los parametros enlazados   
        if(!$statement){
            echo "Error al crear el registro";
        }else{
            $statement->execute();
        }
        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);
    }
    // funciones para control de duplicados y otros

 function buscar_una_nota_por($arg_condicion_busqueda,$arg_notas_id){

        $notas = array();  // creo un array que va a almacenar la informacion del provincia

        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "SELECT notas_id FROM notas WHERE ".$arg_condicion_busqueda;
       
        $sql = $sql ." AND notas_id <> :arg_notas_id ";  // busca un solo registro

        // preparo el sql para enviar   se puede usar prepare   y bindparam 
        $statement = $conexion->prepare($sql);
                
        $statement->bindParam(':arg_notas_id' , $arg_notas_id);  // reemplazo los parametros enlazados   
        
        if(!$statement){
            echo "Error al crear el registro";
        }else{
            $statement->execute();
        }

        if (!$statement) {
            // no se encontraron provincias
        }
        else {
        
            $notas = $statement->fetch(PDO::FETCH_ASSOC);   // porque es un solo resultado

            if (!$notas) { // si el valor es falso
                $notas = array();  // vuelvo a crear un array que va a almacenar la informacion del provincia
            }

        }
        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);

        return $notas;

    }

?> 