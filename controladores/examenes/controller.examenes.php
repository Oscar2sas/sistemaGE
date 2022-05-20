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

  include ($absolute_include."modelos/examenes/model.examenes.php");   // para manejar los examenes



  //verifica si se llamo a una accion determinada en el controlador
  $accion="";
  // verifica si esta especificando un filtro
  $textoabuscar="";

  if (isset($_REQUEST['accion'])) {   // si existe una variable tipo REQUEST que llama a una accion / funcion

    $accion=$_REQUEST['accion'];
  }
   

  // define la accion a realizar

  if ( $accion == "" OR $accion=="index" )  
  {
    if (isset( $_REQUEST['textoabuscar'] )) { 
      $textoabuscar=$_REQUEST['textoabuscar'];
    }  

    examenes_index($textoabuscar);
  } 
  elseif ( $accion == "crear")  
  {
    examenes_crear();
  }
  elseif ( $accion == "editar")  
  {

    if (isset( $_REQUEST['examen_id'] )) { 
      $examen_id=$_REQUEST['examen_id'];
      
    }  
    //echo $examen_id;
    //die();
    examenes_editar($examen_id);
  }
  elseif ( $accion == "mostrar")  
  {

    if (isset( $_REQUEST['examen_id'] )) { 
      $examen_id=$_REQUEST['examen_id'];
    }  

    examenes_mostrar($examen_id);
  }
  elseif ( $accion == "insertar")  
  {

    // verifico que el pedido sea desde un formulario del sistema
    $token=$_POST['token'];

    if($_SESSION['token'] == $token){
      examenes_insertar($_POST);
    } 
    else {
      examenes_index($textoabuscar);
    } 
  }
  elseif ( $accion == "actualizar")  
  {
    // verifico que el pedido sea desde un formulario del sistema
    $token=$_POST['token'];

    if($_SESSION['token'] == $token){
      examenes_actualizar($_POST);
    } 
    else {
      examenes_index($textoabuscar);
    } 
  }
  elseif ( $accion == "eliminar")  
  {
    // verifico que el pedido sea desde un formulario del sistema
    $token=$_POST['token'];

    if($_SESSION['token'] == $token){
      examenes_eliminar($_POST);
    } 
    else {
      examenes_index($textoabuscar);
    } 
  }
  elseif ( $accion == "imprimir")  
  {
    // verifico que el pedido sea desde un formulario del sistema
    $token=$_POST['token'];

    if($_SESSION['token'] == $token){
      examenes_imprimir($textoabuscar);
    } 
    else {
      examenes_index($textoabuscar);
    } 
  }
  elseif ( $accion == "pdf")  
  {
    // verifico que el pedido sea desde un formulario del sistema
    $token=$_POST['token'];

    if($_SESSION['token'] == $token){
      examenes_pdf($textoabuscar);
    } 
    else {
      examenes_index($textoabuscar);
    } 
  }

  
  function examenes_index($arg_textoabuscar){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // busca los paises en la base de datos

    $examenes = buscar_examenes($arg_textoabuscar);
    //var_dump($examenes);
    //die();

    // llama a la vista de index de paises

    include ($absolute_include."vistas/examenes/index.php"); 

  }

  function examenes_crear(){
    
    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // llama a la vista para crear paises

    $alumnos = buscar_alumnos();
    //var_dump($alumnos);
    //die();

    $anolectivos = buscar_ano();
    //var_dump($anolectivos);
    //die();

    $curso = buscar_curso();

    $materia = buscar_materia();

    $etapas= buscar_etapas();





    
    include ($absolute_include."vistas/examenes/crear.php");

  }


  function examenes_editar($arg_examen_id){ //arg argumento, viene desde afuera, no dentro de esta funcion

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // busca el pais en la base de datos
    $alumnos = buscar_alumnos();
    //var_dump($alumnos);
    //echo "<p>";
    //die();

    $anolectivos = buscar_ano();
    //var_dump($anolectivos);
    //echo "<p>";
    //die();

    $curso = buscar_curso();
    //var_dump($curso);
    //echo "<p>";
    $materia = buscar_materia();
    //var_dump($materia);
    //echo "<p>";
    $etapas= buscar_etapas();
    //var_dump($etapas);
   // echo "<p>";
    

    $examenes = buscar_un_examen($arg_examen_id);
    //var_dump($examenes);
    //die();
    // llama a la vista para editar persona

    include ($absolute_include."vistas/examenes/editar.php"); 

  }


  function examenes_mostrar($arg_examen_id){

    //$absolute_include = $GLOBALS['absolute_include']; //EDITAR SI NO FUNCIONA
    //$carpeta_trabajo = $GLOBALS['carpeta_trabajo'];  //EDITAR SI NO FUNCIONA

    // busca el pais en la base de datos
    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // busca el pais en la base de datos
    $alumnos = buscar_alumnos();
    //var_dump($alumnos);
    //die();

    $anolectivos = buscar_ano();
    //var_dump($anolectivos);
    //die();

    $curso = buscar_curso();

    $materia = buscar_materia();

    $etapas= buscar_etapas();

    $examenes = buscar_un_examen($arg_examen_id);
    //var_dump($examenes);
    //die();
    // llama a la vista para editar personas

    include ($absolute_include."vistas/examenes/mostrar.php"); 

  }


  function examenes_insertar($arg_POST){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // aqui se pueden hacer validaciones de los datos que vienen
    // del formulario y devolver un error 

    
    $dfecha_examen = $arg_POST['dfecha_examen'];
    $rela_alumno_id = $arg_POST['rela_alumno_id'];
    $nnumlibro_examen = $arg_POST['nnumlibro_examen'];
    $nnumfolio_examen = $arg_POST['nnumfolio_examen'];
    $nnumpagina_examen = $arg_POST['nnumpagina_examen'];
    $nanoacta_examen= $arg_POST['nanoacta_examen'];
    $rela_anolectivo_id = $arg_POST['rela_anolectivo_id'];
    $rela_curso_id = $arg_POST['rela_curso_id'];
    $rela_materia_id = $arg_POST['rela_materia_id'];
    $ncalificacion= $arg_POST['ncalificacion'];
    $rela_etapaescolar_id = $arg_POST['rela_etapaescolar_id'];
   


    
    // llamo a la funcion en el modelo para grabar una persona
    $ultimo_examen_id=insertar_examenes($dfecha_examen,$rela_alumno_id, $nnumlibro_examen, $nnumfolio_examen, $nnumpagina_examen, $nanoacta_examen ,$rela_anolectivo_id, $rela_curso_id, $rela_materia_id, $ncalificacion,$rela_etapaescolar_id);

    // llamo a la funcion en el modelo para grabar el log

    $cdescripcion_log =" Creacion de Examen :con ID: $ultimo_examen_id";
    insertar_log( $cdescripcion_log);


    // llama al controlador de paises para ir al inicio
    header("Location: ".$carpeta_trabajo."/controladores/examenes/controller.examenes.php");

   }

  function examenes_actualizar($arg_POST){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // aqui se pueden hacer validaciones de los datos que vienen
    // del formulario y devolver un error 

    $examen_id = $arg_POST['examen_id'];
    $dfecha_examen = $arg_POST['dfecha_examen'];
    $rela_alumno_id = $arg_POST['rela_alumno_id'];
    $nnumlibro_examen = $arg_POST['nnumlibro_examen'];
    $nnumfolio_examen = $arg_POST['nnumfolio_examen'];
    $nnumpagina_examen = $arg_POST['nnumpagina_examen'];
    $nanoacta_examen= $arg_POST['nanoacta_examen'];
    $rela_anolectivo_id = $arg_POST['rela_anolectivo_id'];
    $rela_curso_id = $arg_POST['rela_curso_id'];
    $rela_materia_id = $arg_POST['rela_materia_id'];
    $ncalificacion= $arg_POST['ncalificacion'];
    $rela_etapaescolar_id = $arg_POST['rela_etapaescolar_id'];
    
    // llamo a la funcion en el modelo para grabar un pais
   actualizar_examenes($examen_id, $dfecha_examen,$rela_alumno_id, $nnumlibro_examen, $nnumfolio_examen, $nnumpagina_examen, $nanoacta_examen ,$rela_anolectivo_id, $rela_curso_id, $rela_materia_id, $ncalificacion,$rela_etapaescolar_id);
    // llamo a la funcion en el modelo para grabar el log

    $cdescripcion_log =" Modificacion de Examen - Nuevo nombre : ".$examen_id." con ID: $examen_id";
    insertar_log( $cdescripcion_log);



    // llama al controlador de paises para ir al inicio
    header("Location: ".$carpeta_trabajo."/controladores/examenes/controller.examenes.php");

    
  }

  function examenes_eliminar($arg_POST){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // aqui se pueden hacer validaciones de los datos que vienen
    // del formulario y devolver un error 

    $examen_id=$arg_POST['examen_id'];
   
    
    // llamo a la funcion en el modelo para grabar un pais
    eliminar_examenes($examen_id);

    // llamo a la funcion en el modelo para grabar el log

    $cdescripcion_log =" Elimino el Examen con ID: $examen_id";
    insertar_log( $cdescripcion_log);


    // llama al controlador de paises para ir al inicio
    header("Location: ".$carpeta_trabajo."/controladores/examenes/controller.examenes.php");

    
  }
  
  function examenes_imprimir($arg_textoabuscar){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // busca los paises en la base de datos

    $examenes = buscar_un_examen($arg_textoabuscar);

  

    include ($absolute_include."vistas/examenes/imprimir.php"); 

    include ($absolute_include."vistas/plantillas/footer_imprimir_examenes.php"); 
 

  }

  function examenes_pdf($arg_textoabuscar){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // busca los paises en la base de datos

    $examenes = buscar ($arg_textoabuscar);

    $html2pdf = new Html2Pdf('P','A4','es','true',"UTF-8'");   // crea un nuevo objeto
    
    ob_start();   // creo un buffer en memoria que va a recoger todo lo que se deberia mostrar en pantalla
    
    include ($absolute_include."vistas/examenes/imprimir.php"); 

    include ($absolute_include."vistas/plantillas/footer_pdf.php"); 
 
    $mihtml=ob_get_clean();   // guardo todo lo de buffer en una variable  
    ob_end_clean();

    $html2pdf->writeHTML($mihtml);
    $html2pdf->output('examenes.pdf');

    
  }


?>
