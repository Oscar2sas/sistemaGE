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
  include ($absolute_include."modelos/alumnos/model.alumnos.php");
  include ($absolute_include."modelos/cursos/model.curso.php");
  include ($absolute_include."modelos/cambioinstitucionalumnos/model.cambioinstitucionalumnos.php");
  include ($absolute_include."modelos/documentosPersonas/model.documentospersonas.php");
  include ($absolute_include."modelos/historialesAlumnos/model.historialesalumnos.php");
  include ($absolute_include."modelos/reincorporacionesAlumnos/model.reincorporacionesalumnos.php");

  //verifica si se llamo a una accion determinada en el controlador
  $accion="";
// verifica si esta especificando un filtro
  $textoabuscar="";
  if (isset($_REQUEST['accion'])) {   // si existe una variable tipo REQUEST que llama a una accion / funcion

  	$accion=$_REQUEST['accion'];
  }


  if ( $accion == "" OR $accion=="index" )  {

  	cambio_instituciones_alumnos_index();

  }elseif ($accion == "buscar_division_cambio_institucion_alumnos") {
    buscar_division_cambio_institucion_alumnos($_POST['datosFormularioCambioInstitucionAlumnos']);
  }elseif ($accion == "guardar_cambio_institucion_alumnos") {

    guardar_cambio_institucion_alumnos($_POST, $_FILES);

  }
 // ===============================================================================
 // FUNCION QUE INTERACTUAN CON EL MODELO
 // ===============================================================================


  function cambio_instituciones_alumnos_index(){

  	$absolute_include = $GLOBALS['absolute_include'];
  	$carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    $claseActivoCambioInstitucionAlumnos = true;

    $result_ano_lectivo = buscar_Ano_Lectivo_Activo();
    $result_cursos = obtenerCursos();
    include $absolute_include."vistas/cambioInstitucionAlumnos/index.php";
  }

  function buscar_division_cambio_institucion_alumnos($arg_datos_formulario_cambio_institucion_alumnos){

   $datos_formulario_cambio_institucion_alumnos = json_decode($arg_datos_formulario_cambio_institucion_alumnos); 

   $id_ano_lectivo = $datos_formulario_cambio_institucion_alumnos->idCambioInstitucionAlumnoAnoLectivo;
   
   $id_curso = $datos_formulario_cambio_institucion_alumnos->idCambioInstitucionAlumnosCurso;

   $resultado_busqueda_cambio_institucion_alumnos = buscar_division_alumnos($id_ano_lectivo, $id_curso);

   if (!empty($resultado_busqueda_cambio_institucion_alumnos)) {

    $result_tabla_cambio_institucion_alumnos = armar_tabla_cambio_institucion_alumnos($resultado_busqueda_cambio_institucion_alumnos);

    $respuestaBusquedaDivisionCambioInstitucionAlumnos = array('estado' => true,'mensaje' => $result_tabla_cambio_institucion_alumnos);

  }else{
    $respuestaBusquedaDivisionCambioInstitucionAlumnos = array('estado' => false,'mensaje' => 'ESTA DIVISION NO EXISTE, POR FAVOR VERIFIQUE');
  }

  echo json_encode($respuestaBusquedaDivisionCambioInstitucionAlumnos);
}



function guardar_cambio_institucion_alumnos($arg_POST, $arg_FILES){

  $datosGuardarCambioInstitucionAlumnos = json_decode($arg_POST['datosGuardarCambioInstitucionAlumnos']);

  $descCambioInstitucionAlumnos = $datosGuardarCambioInstitucionAlumnos->descCambioInstitucionAlumnos;

  $idCambioInstitucionAlumnos = $datosGuardarCambioInstitucionAlumnos->idCambioInstitucionAlumnos;

  // echo $descCambioInstitucionAlumnos;
  // var_dump($idCambioInstitucionAlumnos);

  // var_dump($arg_FILES);

  $result_subida_archivo_cambio_institucion_alumno = guardar_documento_cambio_institucion_alumno($arg_FILES['archivoGuardarCambioInstitucionAlumnos']);


  for ($i=0; $i <count($idCambioInstitucionAlumnos) ; $i++) { 


    if ($result_subida_archivo_cambio_institucion_alumno['estado']) {

      $result_datos_alumnos = obtener_datos_alumnos($idCambioInstitucionAlumnos[$i]);

      if (!empty($result_datos_alumnos)) {

        $persona_id = $result_datos_alumnos[0]['persona_id']; 

        $result_insert_documento_persona = insertar_documento_persona('14', $persona_id, $result_subida_archivo_cambio_institucion_alumno['mensaje']);

        // se obtiene el ano lectivo actual activo
        
        $id_ano_lectivo = buscar_Ano_Lectivo_Activo();

        if ($result_insert_documento_persona['estado']) {

          $result_insert_historial_alumno = insertar_historial_alumno($descCambioInstitucionAlumnos, $idCambioInstitucionAlumnos[$i]);

          if ($result_insert_historial_alumno['estado']) {
              
            $result_modif_est_alumno = modificar_estado_alumno($idCambioInstitucionAlumnos[$i], '3', '2');

            if ($result_modif_est_alumno['estado']) {
            
            $respuestaGuardadoCambioInstitucionAlumnos = array('estado' => true,'mensaje' => 'Baja de alumno exitosa!');

            }else{
            
            $respuestaGuardadoCambioInstitucionAlumnos = array('estado' => false,'mensaje' => $result_modif_est_alumno['mensaje']);

            }

          }else{
            $respuestaGuardadoCambioInstitucionAlumnos = array('estado' => false,'mensaje' => $result_insert_documento_persona['mensaje']);

          }
        }else{

          $respuestaGuardadoCambioInstitucionAlumnos = array('estado' => false,'mensaje' => $result_insert_documento_persona['mensaje']);

        }


      }else{
        $respuestaGuardadoCambioInstitucionAlumnos = array('estado' => false,'mensaje' => 'No se encuetra al alumno, por favor verifique!');

      }

    }else{
      $respuestaGuardadoCambioInstitucionAlumnos = array('estado' => false,'mensaje' => $result_subida_archivo_cambio_institucion_alumno['mensaje']);
    }


  }


  echo json_encode($respuestaGuardadoCambioInstitucionAlumnos);


}