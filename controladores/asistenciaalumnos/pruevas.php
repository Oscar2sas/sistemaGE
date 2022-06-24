<?php
$carpeta_trabajo="";
$seccion_trabajo="/controladores";

if (strpos($_SERVER["PHP_SELF"] , $seccion_trabajo) >1 ) {
   $carpeta_trabajo=substr($_SERVER["PHP_SELF"],1, strpos($_SERVER["PHP_SELF"] , $seccion_trabajo)-1);  // saca la carpeta de trabajo del sistema
 }


  $absolute_include = str_repeat("../",substr_count($_SERVER["PHP_SELF"] , "/")-1).$carpeta_trabajo; //resuelve problemas de profundidad de carpetas

  if (!empty($carpeta_trabajo)) {
  	$absolute_include = $absolute_include."/";
  	$carpeta_trabajo = "/".$carpeta_trabajo;      
  }

  require $absolute_include.'public/vendor/autoload.php';  // carga el archivo de librerias pdf

  use Spipu\Html2Pdf\Html2Pdf;   // carga la clase y la usa para generar pdf
  include ($absolute_include."clases/class.conexion.php");
  include ($absolute_include."modelos/alumnos/model.alumnos.php");

  function obtener_Alumnos_Curso(){

    /*$argDatosParaBuscarAlumnos = json_decode($argDatosParaBuscarAlumnos);

    var_dump($argDatosParaBuscarAlumnos);*/

    /*$idAnoLectivo = $argDatosParaBuscarAlumnos->idAnoLectivo;
    $fechaAsistencia = $argDatosParaBuscarAlumnos->fechaAsistencia;
    $idCursos = $argDatosParaBuscarAlumnos->idCursos;
    $idTrayectos = $argDatosParaBuscarAlumnos->idTrayectos;*/

    $idAnoLectivo = 3;
    $fechaAsistencia = "20220610";
    $idCursos = 1;
    $idTrayectos = 1;

    // verifico que se haya tomado primero la asistencia de los docentes

    // $result_asistencia_division_horarios_materias = buscar_asistencia_division_horarios_materias($fechaAsistencia, $idCursos, $idTrayectos, $idAnoLectivo);

    // if (!empty($result_asistencia_division_horarios_materias)) {

      //Obtengo los alumnos del ano lectivo  
    $resultado_division_alumnos = buscar_division_alumnos($idAnoLectivo, $idCursos);
    var_dump($resultado_division_alumnos);
    die();


    if (!empty($resultado_division_alumnos)) {

      $resultado_inasistencias_alumnos = buscar_Inasistencia_Alumnos($fechaAsistencia, $idAnoLectivo, $idTrayectos, $idCursos);
      // var_dump($resultado_inasistencias_alumnos);
      $resultado_tabla_asistencia_alumnos = armar_Tabla_Asistencia_Alumnos($resultado_division_alumnos, $resultado_inasistencias_alumnos, $fechaAsistencia, $idAnoLectivo, $idTrayectos, $idCursos);

         echo $resultado_inasistencias_alumnos;
      echo json_encode($resultado_tabla_asistencia_alumnos);
    }else{
      echo "No existe aun la divisiòn, verifique!";
    }
    return;
    // }else{
    //   echo json_encode("tomar_asistencia_curso");
    // }

  }

  $respusta = buscar_division_alumnos(3,1);
  var_dump($respusta);
  echo "<br>";
  obtener_Alumnos_Curso();

 

 

?>