<?php
// seccion que permite resolver problemas de inclusion de archivos
$carpeta_trabajo="";
$seccion_trabajo="/controladores";

if (strpos($_SERVER["PHP_SELF"] , $seccion_trabajo) >1 ) {
   $carpeta_trabajo=substr($_SE0RVER["PHP_SELF"],1, strpos($_SERVER["PHP_SELF"] , $seccion_trabajo)-1);  // saca la carpeta de trabajo del sistema
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

  include ($absolute_include."modelos/calles/model.calles.php");   // para manejar los paises



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

    calle_index($textoabuscar);
  } 
  elseif ( $accion == "crear")  
  {
    calles_crear();
  }
  elseif ( $accion == "editar")  
  {

    if (isset( $_REQUEST['calle_id'] )) { 
      $calle_id=$_REQUEST['calle_id'];
    }  

    calles_editar($calle_id);
  }
  elseif ( $accion == "mostrar")  
  {

    if (isset( $_REQUEST['calle_id'] )) { 
      $calle_id=$_REQUEST['calle_id'];
    }  

    calles_mostrar($calle_id);
  }
  elseif ( $accion == "insertar")  
  {

    // verifico que el pedido sea desde un formulario del sistema
    $token=$_POST['token'];

    if($_SESSION['token'] == $token){
      calles_insertar($_POST);
    } 
    else {
      calle_index($textoabuscar);
    } 
  }
  elseif ( $accion == "actualizar")  
  {
    // verifico que el pedido sea desde un formulario del sistema
    $token=$_POST['token'];

    if($_SESSION['token'] == $token){
      calles_actualizar($_POST);
    } 
    else {
      calle_index($textoabuscar);
    } 
  }
  elseif ( $accion == "eliminar")  
  {
    // verifico que el pedido sea desde un formulario del sistema
    $token=$_POST['token'];

    if($_SESSION['token'] == $token){
      calles_eliminar($_POST);
    } 
    else {
      calle_index($textoabuscar);
    } 
  }
  elseif ( $accion == "imprimir")  
  {
    // verifico que el pedido sea desde un formulario del sistema
    $token=$_POST['token'];

    if($_SESSION['token'] == $token){
      calles_imprimir($textoabuscar);
    } 
    else {
      calle_index($textoabuscar);
    } 
  }
  elseif ( $accion == "pdf")  
  {
    // verifico que el pedido sea desde un formulario del sistema
    $token=$_POST['token'];

    if($_SESSION['token'] == $token){
      calles_pdf($textoabuscar);
    } 
    else {
      calle_index($textoabuscar);
    } 
  }

  
  function calle_index($arg_textoabuscar){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // busca los paises en la base de datos

    $calle = buscar_calle($arg_textoabuscar);

    // llama a la vista de index de paises

    include ($absolute_include."vistas/calles/index.php"); 

  }

  function calles_crear(){
    
    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // llama a la vista para crear paises

    include ($absolute_include."vistas/calles/crear.php");

  }


  function calles_editar($arg_calle_id){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // busca el pais en la base de datos

    $calle = buscar_una_calle($arg_calle_id);

    // llama a la vista para editar persona

    include ($absolute_include."vistas/calles/editar.php"); 

  }


  function calles_mostrar($arg_calle_id){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // busca la calle en la base de datos

    $calle = buscar_una_calle($arg_calle_id);

    // llama a la vista para editar calles

    include ($absolute_include."vistas/calles/mostrar.php"); 

  }


  function calles_insertar($arg_POST){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // aqui se pueden hacer validaciones de los datos que vienen
    // del formulario y devolver un error 

    
    
    $cnombre_calle = strtoupper($arg_POST['cnombre_calle']);


    
    // llamo a la funcion en el modelo para grabar una persona
    $ultimo_calle_id=insertar_calle($cnombre_calle);

    // llamo a la funcion en el modelo para grabar el log

    $cdescripcion_log =" Creacion de Calle :".$cnombre_calle." con ID: $ultimo_calle_id";
    insertar_log( $cdescripcion_log);


    // llama al controlador de paises para ir al inicio
    header("Location: ".$carpeta_trabajo."/controladores/calles/controller.calles.php");

   }

  function calles_actualizar($arg_POST){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // aqui se pueden hacer validaciones de los datos que vienen
    // del formulario y devolver un error 

    $calle_id=$arg_POST['calle_id'];
    $cnombre_calle = strtoupper($arg_POST['cnombre_calle']);

    
    // llamo a la funcion en el modelo para grabar un pais
    actualizar_calle($calle_id,$cnombre_calle);

    // llama al controlador de paises para ir al inicio
    header("Location: ".$carpeta_trabajo."/controladores/calles/controller.calles.php");

    
  }

  function calles_eliminar($arg_POST){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // aqui se pueden hacer validaciones de los datos que vienen
    // del formulario y devolver un error 

    $calle_id = $arg_POST['calle_id'];
   
    
    // llamo a la funcion en el modelo para grabar un pais
    eliminar_calle($calle_id);

    // llamo a la funcion en el modelo para grabar el log


    // llama al controlador de paises para ir al inicio
    header("Location: ".$carpeta_trabajo."/controladores/calles/controller.calles.php");

    
  }
  
  function calles_imprimir($arg_textoabuscar){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // busca los paises en la base de datos

    $calle = buscar_calle($arg_textoabuscar);

    // llama a la vista de index de paises

    include ($absolute_include."vistas/calles/imprimir.php"); 

    include ($absolute_include."vistas/plantillas/footer_imprimir_calles.php"); 
 

  }

  function calles_pdf($arg_textoabuscar){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // busca los paises en la base de datos

    $calle = buscar_calle($arg_textoabuscar);

    $html2pdf = new Html2Pdf('P','A4','es','true',"UTF-8'");   // crea un nuevo objeto
    
    ob_start();   // creo un buffer en memoria que va a recoger todo lo que se deberia mostrar en pantalla
    
    include ($absolute_include."vistas/calles/imprimir.php"); 

    include ($absolute_include."vistas/plantillas/footer_pdf.php"); 
 
    $mihtml=ob_get_clean();   // guardo todo lo de buffer en una variable  
    ob_end_clean();

    $html2pdf->writeHTML($mihtml);
    $html2pdf->output('calles.pdf');

    
  }


?>
