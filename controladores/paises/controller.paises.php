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

  include ($absolute_include."modelos/paises/model.paises.php");   // para manejar los paises



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

    paises_index($textoabuscar);
  } 
  elseif ( $accion == "crear")  
  {
    paises_crear();
  }
  elseif ( $accion == "editar")  
  {

    if (isset( $_REQUEST['pais_id'] )) { 
      $pais_id=$_REQUEST['pais_id'];
    }  

    paises_editar($pais_id);
  }
  elseif ( $accion == "mostrar")  
  {

    if (isset( $_REQUEST['pais_id'] )) { 
      $pais_id=$_REQUEST['pais_id'];
    }  

    paises_mostrar($pais_id);
  }
  elseif ( $accion == "insertar")  
  {
    // verifico que el pedido sea desde un formulario del sistema
    $token=$_POST['token'];

    if($_SESSION['token'] == $token){
      paises_insertar($_POST);
    } 
    else {
      paises_index($textoabuscar);
    } 
  }
  elseif ( $accion == "actualizar")  
  {
    // verifico que el pedido sea desde un formulario del sistema
    $token=$_POST['token'];

    if($_SESSION['token'] == $token){
      paises_actualizar($_POST);
    } 
    else {
      paises_index($textoabuscar);
    } 
  }
  elseif ( $accion == "eliminar")  
  {
    // verifico que el pedido sea desde un formulario del sistema
    $token=$_POST['token'];

    if($_SESSION['token'] == $token){
      paises_eliminar($_POST);
    } 
    else {
      paises_index($textoabuscar);
    } 
  }
  elseif ( $accion == "imprimir")  
  {
    // verifico que el pedido sea desde un formulario del sistema
    $token=$_POST['token'];

    if($_SESSION['token'] == $token){
      paises_imprimir($textoabuscar);
    } 
    else {
      paises_index($textoabuscar);
    } 
  }
  elseif ( $accion == "pdf")  
  {
    // verifico que el pedido sea desde un formulario del sistema
    $token=$_POST['token'];

    if($_SESSION['token'] == $token){
      paises_pdf($textoabuscar);
    } 
    else {
      paises_index($textoabuscar);
    } 
  }

  
  function paises_index($arg_textoabuscar){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // busca los paises en la base de datos

    $paises = buscar_paises($arg_textoabuscar);

    // llama a la vista de index de paises

    include ($absolute_include."vistas/paises/index.php"); 

  }

  function paises_crear(){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // llama a la vista para crear paises

    include ($absolute_include."vistas/paises/crear.php"); 

  }


  function paises_editar($arg_pais_id){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // busca el pais en la base de datos

    $pais = buscar_un_pais($arg_pais_id);

    // llama a la vista para editar paises

    include ($absolute_include."vistas/paises/editar.php"); 
  }


  function paises_mostrar($pais_id){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // busca el pais en la base de datos

    $pais = buscar_un_pais($pais_id);

    // llama a la vista para editar paises

    include ($absolute_include."vistas/paises/mostrar.php"); 

  }


  function paises_insertar($arg_POST){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // aqui se pueden hacer validaciones de los datos que vienen
    // del formulario y devolver un error 

    $cacortacion_pais = strtoupper($arg_POST['cacortacion_pais']);
    $cnombre_pais = strtoupper($arg_POST['cnombre_pais']);
    $cbandera = strtoupper($arg_POST['cbandera']);

    
    // llamo a la funcion en el modelo para grabar un pais
    $ultimo_pais_id=insertar_pais($cacortacion_pais, $cnombre_pais, $cbandera);

    // llamo a la funcion en el modelo para grabar el log

    $cdescripcion_log =" Creacion de Pais :".$cnombre_pais." con ID: $ultimo_pais_id";
    insertar_log( $cdescripcion_log);


    // llama al controlador de paises para ir al inicio
    header("Location: ".$carpeta_trabajo."/controladores/paises/controller.paises.php");

   }

  function paises_actualizar($arg_POST){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // aqui se pueden hacer validaciones de los datos que vienen
    // del formulario y devolver un error 

    $pais_id=$arg_POST['pais_id'];
    $cacortacion_pais = strtoupper($arg_POST['cacortacion_pais']);
    $cnombre_pais = strtoupper($arg_POST['cnombre_pais']);
    $cbandera = strtoupper($arg_POST['cbandera']);

    
    // llamo a la funcion en el modelo para grabar un pais
    actualizar_pais($pais_id, $cacortacion_pais, $cnombre_pais, $cbandera);

    // llamo a la funcion en el modelo para grabar el log

    $cdescripcion_log =" Modificacion de Pais - Nueva acortacion : ".$cacortacion_pais.", Nuevo nombre : ".$cnombre_pais." y Nueva bandera : ".$cbandera." con ID: $pais_id";
    insertar_log( $cdescripcion_log);



    // llama al controlador de paises para ir al inicio
    header("Location: ".$carpeta_trabajo."/controladores/paises/controller.paises.php");

    
  }

  function paises_eliminar($arg_POST){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // aqui se pueden hacer validaciones de los datos que vienen
    // del formulario y devolver un error 

    $pais_id = $arg_POST['pais_id'];
   
    
    // llamo a la funcion en el modelo para grabar un pais
    eliminar_pais($pais_id);

    // llamo a la funcion en el modelo para grabar el log

    $cdescripcion_log =" Elimino el Pais con ID: $pais_id";
    insertar_log( $cdescripcion_log);


    // llama al controlador de paises para ir al inicio
    header("Location: ".$carpeta_trabajo."/controladores/paises/controller.paises.php");
  }
  
  function paises_imprimir($arg_textoabuscar){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // busca los paises en la base de datos

    $paises = buscar_paises($arg_textoabuscar);

    // llama a la vista de index de paises

    include ($absolute_include."vistas/paises/imprimir.php"); 

    include ($absolute_include."vistas/plantillas/footer_imprimir.php"); 
 

  }

  function paises_pdf($arg_textoabuscar){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // busca los paises en la base de datos

    $paises = buscar_paises($arg_textoabuscar);

    $html2pdf = new Html2Pdf('P','A4','es','true',"UTF-8'");   // crea un nuevo objeto
    
    ob_start();   // creo un buffer en memoria que va a recoger todo lo que se deberia mostrar en pantalla
    
    include ($absolute_include."vistas/paises/imprimir.php"); 

    include ($absolute_include."vistas/plantillas/footer_pdf.php"); 
 
    $mihtml=ob_get_clean();   // guardo todo lo de buffer en una variable  
    ob_end_clean();

    $html2pdf->writeHTML($mihtml);
    $html2pdf->output('paises.pdf');

    
  }



?>
