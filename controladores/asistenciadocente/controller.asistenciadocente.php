<?php 

// seccion que permite resolver problemas de inclusion de archivos
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
  // fin seccion 


  require $absolute_include.'public/vendor/autoload.php';  // carga el archivo de librerias pdf

  use Spipu\Html2Pdf\Html2Pdf;   // carga la clase y la usa para generar pdf


  include ($absolute_include."config/global.php");   // variables de configuracion
  
  include ($absolute_include."clases/class.conexion.php");   // clase para conexion de base de datos

  include ($absolute_include."administracion/sesion.php") ;

  include ($absolute_include."modelos/log/model.log.php");   // para manejar los log
  
  include ($absolute_include."modelos/anoLectivos/model.anoslectivos.php");   // se incluye el modelo de ciclos lectivos

  include ($absolute_include."modelos/cursos/model.curso.php");   // se incluye el modelo de cursos

  include ($absolute_include."modelos/trayectos/model.trayecto.php");   // se incluye el modelo de trayectos

  include ($absolute_include."modelos/cursosHorariosMaterias/model.cursoshorariosmaterias.php");   // se incluye el modelo de cursoshorariosmaterias
  
  include ($absolute_include."modelos/asistenciaDocente/model.asistenciadocente.php");   // se incluye el modelo de asistencia docente
  
  include ($absolute_include."modelos/docente/model.docente.php");   // se incluye el modelo de docente

  include ($absolute_include."modelos/materias/model.materias.php");   // se incluye el modelo de materias
  
  include ($absolute_include."modelos/preceptor/model.preceptor.php");   // se incluye el modelo de preceptores
  
  include ($absolute_include."modelos/divisionesHorariosMaterias/model.divisioneshorariosmaterias.php");   // se incluye el modelo de preceptores



  //verifica si se llamo a una accion determinada en el controlador
  $accion="";
// verifica si esta especificando un filtro
  $textoabuscar="";
  if (isset($_REQUEST['accion'])) {   // si existe una variable tipo REQUEST que llama a una accion / funcion

  	$accion=$_REQUEST['accion'];
  }

// Se valida si hay alguna accion enviada desde el front-end 
// en caso de que haya enviado la accion de tipo index
// o la accion este vacia
// se mostrara el listado de los alumnos para la asistencia 

  if ( $accion == "" OR $accion=="index" )  {

    // if (isset( $_REQUEST['textoabuscar'] )) { 
    //  $textoabuscar=$_REQUEST['textoabuscar'];
    // }  
    // Se llama a la funcion para mostrara el listado de alumnos para la asistencia
    docente_asistencia_index();

  }elseif ($accion == "verificar_horarios_materias") {

    $datosHorariosMaterias = $_POST['datosHorariosMaterias'];

    verificar_horarios_materias($datosHorariosMaterias);
  }elseif ($accion == "guardar_asistencia_docentes_cursos_horarios_materias") {

    $datosAsistenciaCursoHorarioMateria = $_POST['datosAsistenciaHorariosMaterias'];
    
    guardar_asistencia_datos($datosAsistenciaCursoHorarioMateria);
  }


  // ===============================================================================
 // FUNCION QUE INTERACTUAN CON EL MODELO
 // ===============================================================================

// Funcion para que el controlador liste los alumnos para la asistencia
  function docente_asistencia_index(){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    $claseActivoAsistenciaDocente = true;

    $resultAnoLectivo = buscar_Ano_Lectivo_Activo();

    $fechaHoy = date('Y-m-d');

    $cursos = obtenerCursos();

    $trayectos = obtenerTrayectos();
    // $i = strtotime($fechaHoy);
    
    // echo jddayofweek(cal_to_jd(CAL_GREGORIAN, date("m",$i),date("d",$i), date("Y",$i)) , 0 );
    include $absolute_include."vistas/asistenciaDocente/index.php";

  }


  function verificar_horarios_materias($argDatosHorariosMaterias){

    $argDatosHorariosMaterias = json_decode($argDatosHorariosMaterias);

    $fechaAsistencia = $argDatosHorariosMaterias->fechaAsistencia;
    $idAnoLectivo = $argDatosHorariosMaterias->idAnoLectivo;
    $idCursos = $argDatosHorariosMaterias->idCursos;
    $idTrayectos = $argDatosHorariosMaterias->idTrayectos;

    $token = $argDatosHorariosMaterias->token;

    if ($token == $_SESSION['token']) {
      $resultDivisionHorariosMaterias = buscar_asistencia_division_horarios_materias($fechaAsistencia, $idCursos, $idTrayectos, $idAnoLectivo);

    // var_dump($resultDivisionHorariosMaterias);
      if (!empty($resultDivisionHorariosMaterias)) {

        $resultTablaDivisionHorariosMaterias = armar_tabla_cursos_horarios_materias($resultDivisionHorariosMaterias, "editar");
        echo json_encode($resultTablaDivisionHorariosMaterias);

      }else{
        $resultHorariosMaterias = buscar_horarios_materias($fechaAsistencia, $idCursos, $idTrayectos);

        if (empty($resultHorariosMaterias)) {
          echo json_encode(false);
        }else{
      // echo json_encode($resultHorariosMaterias);

          $resultTablaCursosHorariosMaterias = armar_tabla_cursos_horarios_materias($resultHorariosMaterias, "agregar");
          echo json_encode($resultTablaCursosHorariosMaterias);
        }
      }
    }else{
      echo json_encode("token_no_valido");
    }
  }

  function guardar_asistencia_datos($argDatosAsistenciaCursoHorarioMateria){
    $resultGuardarAsistencia = guardar_asistencia_curso_horario_materia($argDatosAsistenciaCursoHorarioMateria);

    echo json_encode($resultGuardarAsistencia);
  }