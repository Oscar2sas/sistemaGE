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

  include ($absolute_include."modelos/localidades/model.localidades.php");   // para manejar los provincias

  include ($absolute_include."modelos/provincias/model.provincias.php");
  
  include ($absolute_include."modelos/paises/model.paises.php"); 



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

    localidades_index($textoabuscar);
  } 
  elseif ( $accion == "crear")  
  {
    localidades_crear();
  }
  elseif ( $accion == "editar")  
  {

    if (isset( $_REQUEST['localidad_id'] )) { 
      $localidad_id=$_REQUEST['localidad_id'];
    }  

    localidades_editar($localidad_id);
  }
  elseif ( $accion == "mostrar")  
  {

    if (isset( $_REQUEST['localidad_id'] )) { 
      $localidad_id=$_REQUEST['localidad_id'];
    }  

    localidades_mostrar($localidad_id);
  }
  elseif ( $accion == "insertar")  
  {
    // verifico que el pedido sea desde un formulario del sistema
    $token=$_POST['token'];

    if($_SESSION['token'] == $token){
      localidades_insertar($_POST);
    } 
    else {
      localidades_index($textoabuscar);
    } 
  }
  elseif ( $accion == "actualizar")  
  {
    // verifico que el pedido sea desde un formulario del sistema
    $token=$_POST['token'];

    if($_SESSION['token'] == $token){
      localidades_actualizar($_POST);
    } 
    else {
      localidades_index($textoabuscar);
    } 
  }
  elseif ( $accion == "eliminar")  
  {
    // verifico que el pedido sea desde un formulario del sistema
    $token=$_POST['token'];

    if($_SESSION['token'] == $token){
      localidades_eliminar($_POST);
    } 
    else {
      localidades_index($textoabuscar);
    } 
  }
  elseif ( $accion == "imprimir")  
  {
    // verifico que el pedido sea desde un formulario del sistema
    $token=$_POST['token'];

    if($_SESSION['token'] == $token){
      localidades_imprimir($textoabuscar);
    } 
    else {
      localidades_index($textoabuscar);
    } 
  }
  elseif ( $accion == "pdf")  
  {
    // verifico que el pedido sea desde un formulario del sistema
    $token=$_POST['token'];

    if($_SESSION['token'] == $token){
      localidades_pdf($textoabuscar);
    } 
    else {
      localidades_index($textoabuscar);
    } 
  }

  
  function localidades_index($arg_textoabuscar){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // busca los provincias en la base de datos

    $localidades = buscar_localidades($arg_textoabuscar);

    // llama a la vista de index de provincias

    include ($absolute_include."vistas/localidades/index.php"); 

  }

  function localidades_crear(){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    //busca los provincias de la base de datos 
    $provincias = buscar_provincias("");
    // llama a la vista para crear provincias


    include ($absolute_include."vistas/localidades/crear.php"); 

  }


  function localidades_editar($arg_localidad_id){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // busca el provincia en la base de datos

    $localidad = buscar_una_localidad($arg_localidad_id);
    $provincias = buscar_provincias("");

    // llama a la vista para editar provincias

    include ($absolute_include."vistas/localidades/editar.php"); 

  }


  function localidades_mostrar($arg_localidad_id){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // busca el provincia en la base de datos

    $localidad = buscar_una_localidad($arg_localidad_id);
    // llama a la vista para editar provincias

    include ($absolute_include."vistas/localidades/mostrar.php"); 

  }


  function localidades_insertar($arg_POST){


    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // aqui se pueden hacer validaciones de los datos que vienen
    // del formulario y devolver un error 

    $cnombre_localidad = strtoupper($arg_POST['cnombre_localidad']);
    $rela_provincia_id = strtoupper($arg_POST['rela_provincia_id']);

    
    // llamo a la funcion en el modelo para grabar un provincia
    $ultimo_localidad_id=insertar_localidad($cnombre_localidad, $rela_provincia_id);

    // llamo a la funcion en el modelo para grabar el log

    $cdescripcion_log =" Creacion de localidad :".$cnombre_localidad." con ID: $ultimo_localidad_id";
    insertar_log( $cdescripcion_log);



    // llama al controlador de provincias para ir al inicio
    header("Location: ".$carpeta_trabajo."/controladores/localidades/controller.localidades.php");

   }

  function localidades_actualizar($arg_POST){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // aqui se pueden hacer validaciones de los datos que vienen
    // del formulario y devolver un error 

    $localidad_id=$arg_POST['localidad_id'];
    $cnombre_localidad = strtoupper($arg_POST['cnombre_localidad']);
    $rela_provincia_id = strtoupper($arg_POST['rela_provincia_id']);

    
    // llamo a la funcion en el modelo para grabar un provincia
    actualizar_localidad($localidad_id,$cnombre_localidad, $rela_provincia_id);

    // llamo a la funcion en el modelo para grabar el log

    $cdescripcion_log =" Modificacion de localidad - Nuevo nombre : ".$cnombre_localidad." con ID: $localidad_id";
    insertar_log( $cdescripcion_log);



    // llama al controlador de provincias para ir al inicio
    header("Location: ".$carpeta_trabajo."/controladores/localidades/controller.localidades.php");

    
  }

  function localidades_eliminar($arg_POST){
    

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // aqui se pueden hacer validaciones de los datos que vienen
    // del formulario y devolver un error 

    $localidad_id=$arg_POST['localidad_id'];
   
    
    // llamo a la funcion en el modelo para grabar un provincia
    eliminar_localidad($localidad_id);

    // llamo a la funcion en el modelo para grabar el log

    $cdescripcion_log =" Elimino la localidad con ID: $localidad_id";
    insertar_log( $cdescripcion_log);


    // llama al controlador de provincias para ir al inicio
    header("Location: ".$carpeta_trabajo."/controladores/localidades/controller.localidades.php");

    
  }
  
  function localidades_imprimir($arg_textoabuscar){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // busca los provincias en la base de datos

    $localidades = buscar_localidades($arg_textoabuscar);

    // llama a la vista de index de provincias

    include ($absolute_include."vistas/localidades/imprimir.php"); 

    include ($absolute_include."vistas/plantillas/footer_imprimir_localidades.php"); 
 

  }

  function localidades_pdf($arg_textoabuscar){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // busca los provincias en la base de datos

    $localidades = buscar_localidades($arg_textoabuscar);

    $html2pdf = new Html2Pdf('P','A4','es','true',"UTF-8'");   // crea un nuevo objeto
    
    ob_start();   // creo un buffer en memoria que va a recoger todo lo que se deberia mostrar en pantalla
    
    include ($absolute_include."vistas/localidades/imprimir.php"); 

    include ($absolute_include."vistas/plantillas/footer_pdf.php"); 
 
    $mihtml=ob_get_clean();   // guardo todo lo de buffer en una variable  
    ob_end_clean();

    $html2pdf->writeHTML($mihtml);
    $html2pdf->output('localidad.pdf');

    
  }



?>


