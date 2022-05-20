<?php 

 // seccion que permite resolver problemas de inclusion de archivos
 $carpeta_trabajo="";
 $seccion_trabajo="/controladores";

 //Asigna los permisos
 $usuarios_permitidos = array(1,2);

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

  //Incluye los permisos
  include ($absolute_include."config/permisos.php"); 

  include ($absolute_include."config/global.php");   // variables de configuracion
    
  include ($absolute_include."clases/class.conexion.php");   // clase para conexion de base de datos

  include ($absolute_include."administracion/sesion.php") ;

  include ($absolute_include."modelos/log/model.log.php");   // para manejar los log
  include ($absolute_include."modelos/usuarios/model.usuarios.php");   // para traerlos usuarios

  //verifica si se llamo a una accion determinada en el controlador
  $accion="";
  // verifica si esta especificando un filtro
  $textoabuscar="";

  $fechabuscar=date("Y-m-d");

  if (isset($_REQUEST['accion'])) {   // si existe una variable tipo REQUEST que llama a una accion / funcion

    $accion=$_REQUEST['accion'];
  }
  

  // define la accion a realizar

  if ( $accion == "" OR $accion=="index" )  
  {
    if (isset( $_REQUEST['textoabuscar'] )) { 
      $textoabuscar=$_REQUEST['textoabuscar'];
    }  

    if (isset( $_REQUEST['fechabuscar'] )) { 
      $fechabuscar=$_REQUEST['fechabuscar'];
    }  

    log_index($textoabuscar,$fechabuscar);
  } 
  elseif ( $accion == "crear")  
  {
    log_crear();
  }
  elseif ( $accion == "editar")  
  {

    if (isset( $_REQUEST['log_id'] )) { 
      $log_id=$_REQUEST['log_id'];
    }  

    log_editar($log_id);
  }
  elseif ( $accion == "mostrar")  
  {

    if (isset( $_REQUEST['log_id'] )) { 
      $log_id=$_REQUEST['log_id'];
    }  

    log_mostrar($log_id);
  }
  elseif ( $accion == "insertar")  
  {
    // verifico que el pedido sea desde un formulario del sistema
    $token=$_POST['token'];

    if($_SESSION['token'] == $token){
      log_insertar($_POST);
    } 
    else {
      log_index($textoabuscar,$fechabuscar);
    } 
  }
  elseif ( $accion == "actualizar")  
  {
    // verifico que el pedido sea desde un formulario del sistema
    $token=$_POST['token'];

    if($_SESSION['token'] == $token){
      log_actualizar($_POST);
    } 
    else {
      log_index($textoabuscar,$fechabuscar);
    } 
  }
  elseif ( $accion == "eliminar")  
  {
    // verifico que el pedido sea desde un formulario del sistema
    $token=$_POST['token'];

    if($_SESSION['token'] == $token){
      log_eliminar($_POST);
    } 
    else {
      log_index($textoabuscar,$fechabuscar);
    } 
  }
  elseif ( $accion == "imprimir")  
  {
    // verifico que el pedido sea desde un formulario del sistema
    $token=$_POST['token'];

    if($_SESSION['token'] == $token){
      log_imprimir($textoabuscar,$fechabuscar);
    } 
    else {
      log_index($textoabuscar,$fechabuscar);
    } 
  }
  elseif ( $accion == "pdf")  
  {
    // verifico que el pedido sea desde un formulario del sistema
    $token=$_POST['token'];

    if($_SESSION['token'] == $token){
      log_pdf($textoabuscar,$fechabuscar);
    } 
    else {
      log_index($textoabuscar,$fechabuscar);
    } 
  }


  function log_index($arg_textoabuscar,$arg_fechabuscar){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // busca los log en la base de datos

    $logs = buscar_log($arg_textoabuscar,$arg_fechabuscar);

    include ($absolute_include."vistas/log/index.php"); 

  }

  function log_crear(){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];
    
    // llama a la vista para crear log
    //$usuarios = buscar_usuarios("");

    include ($absolute_include."vistas/log/crear.php"); 

  }


  function log_editar($arg_log_id){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];
  
    // busca el log en la base de datos

    $log = buscar_un_log($arg_log_id);

    // llama a la vista para editar log

    include ($absolute_include."vistas/log/editar.php"); 

  }


  function log_mostrar($arg_log_id){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];
  
    // busca el pais en la base de datos

    $log = buscar_un_log($arg_log_id);

    // llama a la vista para editar log

    include ($absolute_include."vistas/log/mostrar.php"); 

  }


  function log_insertar($arg_POST){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // aqui se pueden hacer validaciones de los datos que vienen
    // del formulario y devolver un error

    $cdescripcion = trim($arg_POST['cdescripcion_log']);
    $user = $_SESSION['rela_usuario_id'];
    
    // llamo a la funcion en el modelo para grabar un pais
    $ultimo_log_id = insertar_user_log($cdescripcion,$user);

    // llama al controlador de log para ir al inicio
    //header("Location: ".$carpeta_trabajo."/controladores/log/controller.log.php");

  }

  function log_actualizar($arg_POST){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // aqui se pueden hacer validaciones de los datos que vienen
    // del formulario y devolver un error 

    $log_id=$arg_POST['log_id'];

    $cdescripcion_log = $arg_POST['cdescripcion_log'];
    
    // llamo a la funcion en el modelo para grabar un pais
    $ultimo_log_id= actualizar_log($log_id,$cdescripcion_log);

    //$cdescripcion_log =" Modificacion de Log: ".$cdescripcion_log." con ID: $ultimo_log_id ";
    //insertar_log( $cdescripcion_log);

    // llama al controlador de log para ir al inicio
    header("Location: ".$carpeta_trabajo."/controladores/log/controller.log.php");

    
  }

  function log_eliminar($arg_POST){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // aqui se pueden hacer validaciones de los datos que vienen
    // del formulario y devolver un error 

    $log_id=$arg_POST['log_id'];
  
    
    // llamo a la funcion en el modelo para grabar un pais
    eliminar_log($log_id);

    //$cdescripcion_log ="Elimino el Log con ID: $log_id";
    //insertar_log( $cdescripcion_log);

    // llama al controlador de log para ir al inicio
    header("Location: ".$carpeta_trabajo."/controladores/log/controller.log.php");

    
  }

  function log_imprimir($arg_textoabuscar,$arg_fechabuscar){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // busca los log en la base de datos

    $log = buscar_log($arg_textoabuscar,$arg_fechabuscar);

    // llama a la vista de index de log

    include ($absolute_include."vistas/log/imprimir.php"); 

    include ($absolute_include."vistas/plantillas/footer_imprimir.php"); 


  }

  function log_pdf($arg_textoabuscar,$arg_fechabuscar){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];
    
    // busca los log en la base de datos

    $log = buscar_log($arg_textoabuscar,$arg_fechabuscar);

    $html2pdf = new Html2Pdf('P','A4','es','true',"UTF-8'");   // crea un nuevo objeto
    
    ob_start();   // creo un buffer en memoria que va a recoger todo lo que se deberia mostrar en pantalla
    
    include ($absolute_include."vistas/log/imprimir.php"); 

    include ($absolute_include."vistas/plantillas/footer_pdf.php"); 

    $mihtml=ob_get_clean();   // guardo todo lo de buffer en una variable  
    ob_end_clean();

    $html2pdf->writeHTML($mihtml);
    $html2pdf->output('log.pdf');

    
  }



?>

