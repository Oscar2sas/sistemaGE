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

  include ($absolute_include."modelos/barrios/model.barrios.php");   // para manejar los paises



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

    barrios_index($textoabuscar);
  } 
  elseif ( $accion == "crear")  
  {
    barrios_crear();
  }
  elseif ( $accion == "editar")  
  {

    if (isset( $_REQUEST['barrio_id'] )) { 
      $barrio_id=$_REQUEST['barrio_id'];
    }  

    barrios_editar($barrio_id);
  }
  elseif ( $accion == "mostrar")  
  {

    if (isset( $_REQUEST['barrio_id'] )) { 
      $barrio_id=$_REQUEST['barrio_id'];
    }  

    barrios_mostrar($barrio_id);
  }
  elseif ( $accion == "insertar")  
  {
    // verifico que el pedido sea desde un formulario del sistema
    $token=$_POST['token'];

    if($_SESSION['token'] == $token){
      barrios_insertar($_POST);
    } 
    else {
      barrios_index($textoabuscar);
    } 
  }
  elseif ( $accion == "actualizar")  
  {
    // verifico que el pedido sea desde un formulario del sistema
    $token=$_POST['token'];

    if($_SESSION['token'] == $token){
      barrios_actualizar($_POST);
    } 
    else {
      barrios_index($textoabuscar);
    } 
  }
  elseif ( $accion == "eliminar")  
  {
    // verifico que el pedido sea desde un formulario del sistema
    $token=$_POST['token'];

    if($_SESSION['token'] == $token){
      barrios_eliminar($_POST);
    } 
    else {
     barrios_index($textoabuscar);
    } 
  }
  elseif ( $accion == "imprimir")  
  {
    // verifico que el pedido sea desde un formulario del sistema
    $token=$_POST['token'];

    if($_SESSION['token'] == $token){
      barrios_imprimir($textoabuscar);
    } 
    else {
      barrios_index($textoabuscar);
    } 
  }
  elseif ( $accion == "pdf")  
  {
    // verifico que el pedido sea desde un formulario del sistema
    $token=$_POST['token'];

    if($_SESSION['token'] == $token){
      barrios_pdf($textoabuscar);
    } 
    else {
      barrios_index($textoabuscar);
    } 
  }

  
  function barrios_index($arg_textoabuscar){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // busca los paises en la base de datos

    $barrios = buscar_barrios($arg_textoabuscar);

    // llama a la vista de index de paises

    include ($absolute_include."vistas/barrios/index.php"); 

  }

  function barrios_crear(){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // llama a la vista para crear paises

    include ($absolute_include."vistas/barrios/crear.php"); 

  }


  function barrios_editar($arg_barrio_id){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // busca el pais en la base de datos

    $barrio = buscar_un_barrio($arg_barrio_id);

    // llama a la vista para editar paises

    include ($absolute_include."vistas/barrios/editar.php"); 

  }


  function barrios_mostrar($arg_barrio_id){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // busca el pais en la base de datos

    $barrio = buscar_un_barrio($arg_barrio_id);

    // llama a la vista para editar paises

    include ($absolute_include."vistas/barrios/mostrar.php"); 

  }


  function barrios_insertar($arg_POST){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // aqui se pueden hacer validaciones de los datos que vienen
    // del formulario y devolver un error 

    $cnombre_barrio = strtoupper($arg_POST['cnombre_barrio']);

    
    // llamo a la funcion en el modelo para grabar un pais
    $ultimo_barrio_id=insertar_barrio($cnombre_barrio);

    // llamo a la funcion en el modelo para grabar el log

    $cdescripcion_log =" Creacion de Barrio :".$cnombre_barrio." con ID: $ultimo_barrio_id";
    insertar_log( $cdescripcion_log);


    // llama al controlador de paises para ir al inicio
    header("Location: ".$carpeta_trabajo."/controladores/barrios/controller.barrios.php");

   }

  function barrios_actualizar($arg_POST){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // aqui se pueden hacer validaciones de los datos que vienen
    // del formulario y devolver un error 

    $barrio_id=$arg_POST['barrio_id'];
    $cnombre_barrio = strtoupper($arg_POST['cnombre_barrio']);

    
    // llamo a la funcion en el modelo para grabar un pais
    actualizar_barrio($barrio_id,$cnombre_barrio);

    // llamo a la funcion en el modelo para grabar el log

    $cdescripcion_log =" Modificacion de Barrio - Nuevo nombre : ".$cnombre_barrio." con ID: $barrio_id";
    insertar_log( $cdescripcion_log);



    // llama al controlador de paises para ir al inicio
    header("Location: ".$carpeta_trabajo."/controladores/barrios/controller.barrios.php");

    
  }

  function barrios_eliminar($arg_POST){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // aqui se pueden hacer validaciones de los datos que vienen
    // del formulario y devolver un error 

    $barrio_id=$arg_POST['barrio_id'];
   
    
    // llamo a la funcion en el modelo para grabar un pais
    eliminar_barrio($barrio_id);

    // llamo a la funcion en el modelo para grabar el log

    $cdescripcion_log =" Elimino el Barrio con ID: $barrio_id";
    insertar_log( $cdescripcion_log);


    // llama al controlador de paises para ir al inicio
    header("Location: ".$carpeta_trabajo."/controladores/barrios/controller.barrios.php");

    
  }
  
  function barrios_imprimir($arg_textoabuscar){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // busca los paises en la base de datos

    $barrios = buscar_barrios($arg_textoabuscar);

    // llama a la vista de index de paises

    include ($absolute_include."vistas/barrios/imprimir.php"); 

    include ($absolute_include."vistas/plantillas/footer_imprimir_barrios.php"); 
 

  }

  function barrios_pdf($arg_textoabuscar){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // busca los paises en la base de datos

    $barrios = buscar_barrios($arg_textoabuscar);

    $html2pdf = new Html2Pdf('P','A4','es','true',"UTF-8'");   // crea un nuevo objeto
    
    ob_start();   // creo un buffer en memoria que va a recoger todo lo que se deberia mostrar en pantalla
    
    include ($absolute_include."vistas/barrios/imprimir.php"); 

    include ($absolute_include."vistas/plantillas/footer_pdf.php"); 
 
    $mihtml=ob_get_clean();   // guardo todo lo de buffer en una variable  
    ob_end_clean();

    $html2pdf->writeHTML($mihtml);
    $html2pdf->output('barrios.pdf');

    
  }



?>