<?php 

   
function buscar_examenes($arg_textoabuscar){

    $examenes = array();  // creo un array que va a almacenar la informacion de los paises

    $db = new ConexionDB;
    $conexion = $db->retornar_conexion();

    $sql = "SELECT examen_id,rela_anolectivo_id,rela_curso_id,rela_materia_id,rela_alumno_id,rela_etapaescolar_id,dfecha_examen,ncalificacion,rela_docente_id_1,rela_docente_id_2,rela_docente_id_3,nnumacta_examen,nanoacta_examen,nnumlibro_examen,nnumfolio_examen,nnumpagina_examen,capellidos_persona,cnombres_persona, cnombre_materia, cdescripcion_curso FROM examenes LEFT JOIN (SELECT alumno_id,capellidos_persona, cnombres_persona,persona_id 
        FROM alumnos 
        LEFT JOIN personas ON alumnos.rela_persona_id = personas.persona_id) AS alumnos ON alumnos.alumno_id = examenes.rela_alumno_id 
        LEFT JOIN cursos ON examenes.rela_curso_id = cursos.curso_id 
        LEFT JOIN materias on examenes.rela_materia_id = materias.materia_id";


    if (!empty($arg_textoabuscar)) {
    
        /*$sql = "SELECT examen_id,rela_anolectivo_id,rela_curso_id,rela_materia_id,rela_alumno_id,rela_etapaescolar_id,dfecha_examen,ncalificacion,rela_docente_id_1,rela_docente_id_2,rela_docente_id_3,nnumacta_examen,nanoacta_examen,nnumlibro_examen,nnumfolio_examen,nnumpagina_examen,capellidos_persona,cnombres_persona, cnombre_materia, cdescripcion_curso FROM examenes LEFT JOIN (SELECT alumno_id,capellidos_persona, cnombres_persona,persona_id 
        FROM alumnos 
        LEFT JOIN personas ON alumnos.rela_persona_id = personas.persona_id) AS alumnos ON alumnos.alumno_id = examenes.rela_alumno_id 
        LEFT JOIN cursos ON examenes.rela_curso_id = cursos.curso_id 
        LEFT JOIN materias on examenes.rela_materia_id = materias.materia_id";*/
        $sql = "SELECT e1.examen_id, e1.rela_anolectivo_id, e1.rela_curso_id, e1.rela_materia_id, e1.rela_alumno_id, e1.rela_etapaescolar_id, e1.dfecha_examen, e1.ncalificacion, e1.rela_docente_id_1, e1.rela_docente_id_2, e1.rela_docente_id_3, e1.nnumacta_examen, e1.nanoacta_examen, e1.nnumlibro_examen, e1.nnumfolio_examen, e1.nnumpagina_examen, p1.persona_id, p1.capellidos_persona, p1.cnombres_persona, m1.materia_id ,m1.cnombre_materia, c1.curso_id, c1.cdescripcion_curso, a2.alumno_id, a2.rela_persona_id FROM examenes e1, personas p1, materias m1, cursos c1, alumnos a2 WHERE a2.rela_persona_id=p1.persona_id AND e1.rela_alumno_id=a2.alumno_id AND e1.rela_curso_id= c1.curso_id AND e1.rela_materia_id=m1.materia_id AND (p1.capellidos_persona LIKE :arg_textoabuscar OR p1.cnombres_persona LIKE :arg_textoabuscar)";
        $arg_textoabuscar="%".TRIM($arg_textoabuscar)."%";
    }

    $sql = $sql." ORDER BY dfecha_examen DESC";  
    
    $statement = $conexion->prepare($sql);
    
    $statement->bindParam(':arg_textoabuscar' , $arg_textoabuscar);  // reemplazo los parametros enlazados 
    
    
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

            $examenes[] = $resultado;

        }
    }

    // cierro la conexion
    $statement = $db->cerrar_conexion($conexion);

    return $examenes;

}

function buscar_un_examen($arg_examen_id){

    $examenes = array();  // creo un array que va a almacenar la informacion del pais

    $db = new ConexionDB;
    $conexion = $db->retornar_conexion();

    $sql = "SELECT * FROM anos_lectivos a1, examenes e1, alumnos a2, personas p1 WHERE e1.rela_alumno_id = a2.alumno_id AND e1.rela_anolectivo_id = a1.anolectivo_id AND a2.rela_persona_id = p1.persona_id AND e1.examen_id =:arg_examen_id";  // busca un solo registro    
    $statement = $conexion->prepare($sql);
    
    $statement->bindParam(':arg_examen_id' , $arg_examen_id);  // reemplazo los parametros enlazados 
    
    
    if(!$statement){
        echo "Error al crear el registro";
    }else{
        $statement->execute();
    }

    if (!$statement) {
        // no se encontraron paises
    }
    else {
    
        $examenes = $statement->fetch(PDO::FETCH_ASSOC);   // porque es un solo resultado

    }

    // cierro la conexion
    $statement = $db->cerrar_conexion($conexion);

    return $examenes;

}

function buscar_alumnos(){
         $alumnos=array(); //creo un array que va a almacenar la informacion de las personas

         $db = new ConexionDB;
         $conexion = $db->retornar_conexion();
         
         $sql= "SELECT alumno_id,cnumlegajo_alumno,nsituacion_alumno,balumno_regular,rela_estadoalumno_id,rela_persona_id,rela_persona_id_tutor1,rela_persona_id_tutor2,rela_persona_id_tutor3,persona_id,capellidos_persona,cnombres_persona,ndni_persona,ncuil_persona,cemail_persona,dfechanac_persona,rela_sexo_id FROM alumnos INNER JOIN personas ON alumnos.rela_persona_id=personas.persona_id"; //Busacar todos los alumnos 

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

function buscar_ano(){
    $ano=array(); //creo un array que va a almacenar la informacion de las personas

    $db = new ConexionDB;
    $conexion = $db->retornar_conexion();
    
    $sql= "SELECT anolectivo_id,ndescripcion_anolectivo FROM anos_lectivos"; //Busacar todos los alumnos 

       $sql = $sql." ORDER BY ndescripcion_anolectivo desc";  

$statement = $conexion->query($sql);

//if(!$statement){
//echo "Error al crear el registro";
//}else{
//$statement->execute();
//}

if (!$statement) {
// no se encontraron personas
}else{

// reviso el retorno

   while($resultado = $statement->fetch(PDO::FETCH_ASSOC)){

    $ano[] = $resultado;

   }
}


// cierro la conexion
$statement = $db->cerrar_conexion($conexion);

return $ano;
}

function buscar_curso(){
    $curso=array(); //creo un array que va a almacenar la informacion de las personas

    $db = new ConexionDB;
    $conexion = $db->retornar_conexion();
    
    $sql= "SELECT curso_id, cdescripcion_curso FROM cursos"; //Busacar todos los alumnos 

       $sql = $sql." ORDER BY cdescripcion_curso desc";  

$statement = $conexion->query($sql);

//if(!$statement){
//echo "Error al crear el registro";
//}else{
//$statement->execute();
//}

if (!$statement) {
// no se encontraron personas
}else{

// reviso el retorno

   while($resultado = $statement->fetch(PDO::FETCH_ASSOC)){

    $curso[] = $resultado;

   }
}


// cierro la conexion
$statement = $db->cerrar_conexion($conexion);

return $curso;
}

function buscar_materia(){
    $materia=array(); //creo un array que va a almacenar la informacion de las personas

    $db = new ConexionDB;
    $conexion = $db->retornar_conexion();
    
    $sql= "SELECT materia_id, cnombre_materia FROM materias"; //Busacar todos los alumnos 

       $sql = $sql." ORDER BY cnombre_materia desc";  

$statement = $conexion->query($sql);

//if(!$statement){
//echo "Error al crear el registro";
//}else{
//$statement->execute();
//}

if (!$statement) {
// no se encontraron personas
}else{

// reviso el retorno

   while($resultado = $statement->fetch(PDO::FETCH_ASSOC)){

    $materia[] = $resultado;

   }
}


// cierro la conexion
$statement = $db->cerrar_conexion($conexion);

return $materia;
}


function buscar_etapas(){
    $etapas=array(); //creo un array que va a almacenar la informacion de las personas

    $db = new ConexionDB;
    $conexion = $db->retornar_conexion();
    
    $sql= "SELECT etapaescolar_id, cdescripcion_etapa FROM etapas_escolares"; //Busacar todos los alumnos 

      // $sql = $sql." ORDER BY cdescipcion_etapa desc";  

$statement = $conexion->query($sql);

if(!$statement){
echo "Error al crear el registro";
}else{
$statement->execute();
}

if (!$statement) {
        //no se encontraron etapas
}else{

//reviso el retorno

   while($resultado = $statement->fetch(PDO::FETCH_ASSOC)){

    $etapas[] = $resultado;

   }
}


// cierro la conexion
$statement = $db->cerrar_conexion($conexion);

return $etapas;
}

function insertar_examenes($dfecha_examen,$rela_alumno_id, $nnumlibro_examen, $nnumfolio_examen, $nnumpagina_examen, $nanoacta_examen, $rela_anolectivo_id, $rela_curso_id, $rela_materia_id,$ncalificacion,$rela_etapaescolar_id){

    $ultimo_id=0;
    
    $db = new ConexionDB;
    $conexion = $db->retornar_conexion();
    $sql = "INSERT INTO examenes (dfecha_examen, rela_alumno_id, nnumlibro_examen, nnumfolio_examen, nnumpagina_examen, nanoacta_examen, rela_anolectivo_id, rela_curso_id, rela_materia_id,ncalificacion, rela_etapaescolar_id,rela_docente_id_1, rela_docente_id_2, rela_docente_id_3, nnumacta_examen) VALUES ('$dfecha_examen', $rela_alumno_id,$nnumlibro_examen, $nnumfolio_examen, $nnumpagina_examen, $nanoacta_examen, $rela_anolectivo_id, $rela_curso_id, $rela_materia_id, $ncalificacion,$rela_etapaescolar_id, 3,5,3,1)";
    
    //Header ('location: archivo.php')    
   //echo $sql;
     //die();

    // preparo el sql para enviar   se puede usar prepare   y bindparam 
    $statement = $conexion->query($sql);
    
    //$statement->bindParam(':arg_dfecha_examen' , $arg_dfecha_examen);  // reemplazo los parametros enlazados
    //$statement->bindParam(':arg_rela_alumno_id' , $arg_rela_alumno_id); 
    //$statement->bindParam(':arg_nnumlibro_examen' , $arg_nnumlibro_examen); 
    //$statement->bindParam(':arg_nnumfolio_examen' , $arg_nnumfolio_examen); 
    //$statement->bindParam(':arg_nnumpagina_examen' , $arg_nnumpagina_examen); 
    //$statement->bindParam(':arg_nanoacta_examen' , $arg_nanoacta_examen);
    
    //if(!$statement){
        //echo "Error al crear el registro";
   // }//else{
        //$statement->execute();
    //}
    
    $ultimo_id = $conexion->lastinsertid();
   
    // cierro la conexion
    $statement = $db->cerrar_conexion($conexion);

    return $ultimo_id;
}


function actualizar_examenes($arg_examen_id,$arg_dfecha_examen,$arg_rela_alumno_id, $arg_nnumlibro_examen, $arg_nnumfolio_examen, $arg_nnumpagina_examen, $arg_nanoacta_examen, $arg_rela_anolectivo_id, $arg_rela_curso_id, $arg_rela_materia_id,$arg_ncalificacion,$arg_rela_etapaescolar_id){

   
    $db = new ConexionDB;
    $conexion = $db->retornar_conexion();

    $sql = "UPDATE `examenes` set `dfecha_examen` = '$arg_dfecha_examen', `rela_alumno_id` = '$arg_rela_alumno_id', `nnumlibro_examen` = '$arg_nnumlibro_examen', `nnumfolio_examen`= '$arg_nnumfolio_examen', `nnumpagina_examen` = '$arg_nnumpagina_examen' , `nanoacta_examen` = '$arg_nanoacta_examen', `rela_anolectivo_id` = '$arg_rela_anolectivo_id', `rela_curso_id` = '$arg_rela_curso_id', `rela_materia_id` = '$arg_rela_materia_id', `ncalificacion` = '$arg_ncalificacion', `rela_etapaescolar_id` = '$arg_rela_etapaescolar_id' WHERE `examen_id` = '$arg_examen_id'";
    
    
    // preparo el sql para enviar   se puede usar prepare   y bindparam 
    $statement = $conexion->query($sql); 

    
    //$statement->bindParam(':arg_examen_id' , $arg_examen_id);
    //$statement->bindParam(':dfecha_examen' , $dfecha_examen);  // reemplazo los parametros enlazados
    //$statement->bindParam(':capellidos_persona' , $capellidos_persona); 
    //$statement->bindParam(':nnumlibro_examen' , $nnumlibro_examen); 
    //$statement->bindParam(':nnumfolio_examen' , $nnumfolio_examen); 
    //$statement->bindParam(':nnumpagina_examen' , $nnumpagina_examen); 
    //$statement->bindParam(':nanoacta_examen' , $nanoacta_examen);

    //if(!$statement){
        //echo "Error al crear el registro";
    //}else{
        //$statement->execute();
    //}

    // cierro la conexion
    $statement = $db->cerrar_conexion($conexion);
}



function eliminar_examenes($arg_examen_id){

   
    $db = new ConexionDB;
    $conexion = $db->retornar_conexion();

    $sql = "DELETE FROM examenes WHERE examen_id = :arg_examen_id";
    
    // preparo el sql para enviar   se puede usar prepare   y bindparam 
    $statement = $conexion->prepare($sql);
    
    $statement->bindParam(':arg_examen_id' , $arg_examen_id);  // reemplazo los parametros enlazados   
    
    if(!$statement){
        echo "Error al crear el registro";
    }else{
        $statement->execute();
    }

    // cierro la conexion
    $statement = $db->cerrar_conexion($conexion);
}

 ?>