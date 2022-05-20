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

  include ($absolute_include."modelos/personas/model.personas.php");   // para manejar los paises



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

    persona_index($textoabuscar);
  } 
  elseif ( $accion == "crear")  
  {
    personas_crear();
  }
  elseif ( $accion == "editar")  
  {

    if (isset( $_REQUEST['persona_id'] )) { 
      $persona_id=$_REQUEST['persona_id'];
    }  

    personas_editar($persona_id);
  }
  elseif ( $accion == "mostrar")  
  {

    if (isset( $_REQUEST['persona_id'] )) { 
      $persona_id=$_REQUEST['persona_id'];
    }  

    personas_mostrar($persona_id);
  }
  elseif ( $accion == "insertar")  
  {

    // verifico que el pedido sea desde un formulario del sistema
    $token=$_POST['token'];

    if($_SESSION['token'] == $token){
      personas_insertar($_POST);
    } 
    else {
      persona_index($textoabuscar);
    } 
  }
  elseif ( $accion == "actualizar")  
  {
    // verifico que el pedido sea desde un formulario del sistema
    $token=$_POST['token'];

    if($_SESSION['token'] == $token){
      personas_actualizar($_POST);
    } 
    else {
      persona_index($textoabuscar);
    } 
  }
  elseif ( $accion == "eliminar")  
  {
    // verifico que el pedido sea desde un formulario del sistema
    $token=$_POST['token'];

    if($_SESSION['token'] == $token){
      personas_eliminar($_POST);
    } 
    else {
      persona_index($textoabuscar);
    } 
  }
  elseif ( $accion == "imprimir")  
  {
    // verifico que el pedido sea desde un formulario del sistema
    $token=$_POST['token'];

    if($_SESSION['token'] == $token){
      personas_imprimir($textoabuscar);
    } 
    else {
      persona_index($textoabuscar);
    } 
  }
  elseif ( $accion == "pdf")  
  {
    // verifico que el pedido sea desde un formulario del sistema
    $token=$_POST['token'];

    if($_SESSION['token'] == $token){
      personas_pdf($textoabuscar);
    } 
    else {
      persona_index($textoabuscar);
    } 
  }

  
  function persona_index($arg_textoabuscar){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // busca los paises en la base de datos

    $persona = buscar_persona($arg_textoabuscar);

    // llama a la vista de index de paises

    include ($absolute_include."vistas/personas/index.php"); 

  }

  function personas_crear(){
    
    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // llama a la vista para crear paises

    include ($absolute_include."vistas/personas/crear.php");

  }


  function personas_editar($arg_persona_id){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // busca el pais en la base de datos

    $persona = buscar_una_persona($arg_persona_id);

    // llama a la vista para editar persona

    include ($absolute_include."vistas/personas/editar.php"); 

  }


  function personas_mostrar($arg_persona_id){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // busca el pais en la base de datos

    $persona = buscar_una_persona($arg_persona_id);

    // llama a la vista para editar personas

    include ($absolute_include."vistas/personas/mostrar.php"); 

  }


  function personas_insertar($arg_POST){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // aqui se pueden hacer validaciones de los datos que vienen
    // del formulario y devolver un error
    
    $capellido_persona = strtoupper($arg_POST['capellidos_persona']);
    $cnombres_persona = strtoupper($arg_POST['cnombres_persona']);
    $ndni_persona = strtoupper($arg_POST['ndni_persona']);
    $ncuil_persona = strtoupper($arg_POST['ncuil_persona']);
    $cemail_persona = $arg_POST['cemail_persona'];
    $dfechanac_persona = strtoupper($arg_POST['dfechanac_persona']);


    
    // llamo a la funcion en el modelo para grabar una persona
    $ultimo_persona_id=insertar_persona($capellido_persona, $cnombres_persona, $ndni_persona, $ncuil_persona, $cemail_persona, $dfechanac_persona);

    // llamo a la funcion en el modelo para grabar el log

    $cdescripcion_log =" Creacion de Persona :".$cnombre_persona." con ID: $ultimo_persona_id";
    insertar_log( $cdescripcion_log);


    // llama al controlador de paises para ir al inicio
    header("Location: ".$carpeta_trabajo."/controladores/personas/controller.personas.php");

   }

  function personas_actualizar($arg_POST){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // aqui se pueden hacer validaciones de los datos que vienen
    // del formulario y devolver un error 

    $persona_id=$arg_POST['persona_id'];
    $capellido_persona = strtoupper($arg_POST['capellidos_persona']);
    $cnombres_persona = strtoupper($arg_POST['cnombres_persona']);
    $ndni_persona = strtoupper($arg_POST['ndni_persona']);
    $ncuil_persona = strtoupper($arg_POST['ncuil_persona']);
    $cemail_persona = $arg_POST['cemail_persona'];
    $dfechanac_persona = strtoupper($arg_POST['dfechanac_persona']);

    
    // llamo a la funcion en el modelo para grabar un pais
    actualizar_persona($persona_id,$capellido_persona, $cnombres_persona, $ndni_persona, $ncuil_persona, $cemail_persona, $dfechanac_persona);

    // llamo a la funcion en el modelo para grabar el log

    $cdescripcion_log =" Modificacion de Persona - Nuevo nombre : ".$cnombres_persona." con ID: $persona_id";
    insertar_log( $cdescripcion_log);



    // llama al controlador de paises para ir al inicio
    header("Location: ".$carpeta_trabajo."/controladores/personas/controller.personas.php");

    
  }

  function personas_eliminar($arg_POST){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // aqui se pueden hacer validaciones de los datos que vienen
    // del formulario y devolver un error 

    $persona_id=$arg_POST['persona_id'];
   
    
    // llamo a la funcion en el modelo para grabar un pais
    eliminar_persona($persona_id);

    // llamo a la funcion en el modelo para grabar el log

    $cdescripcion_log =" Elimino la Persona con ID: $persona_id";
    insertar_log( $cdescripcion_log);


    // llama al controlador de paises para ir al inicio
    header("Location: ".$carpeta_trabajo."/controladores/personas/controller.personas.php");

    
  }
  
  function personas_imprimir($arg_textoabuscar){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // busca los paises en la base de datos

    $persona = buscar_persona($arg_textoabuscar);

    // llama a la vista de index de paises

    include ($absolute_include."vistas/personas/imprimir.php"); 

    include ($absolute_include."vistas/plantillas/footer_imprimir_personas.php"); 
 

  }

  function personas_pdf($arg_textoabuscar){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // busca los paises en la base de datos

    $persona = buscar_persona($arg_textoabuscar);

    $html2pdf = new Html2Pdf('P','A4','es','true',"UTF-8'");   // crea un nuevo objeto
    
    ob_start();   // creo un buffer en memoria que va a recoger todo lo que se deberia mostrar en pantalla
    
    include ($absolute_include."vistas/personas/imprimir.php"); 

    include ($absolute_include."vistas/plantillas/footer_pdf.php"); 
 
    $mihtml=ob_get_clean();   // guardo todo lo de buffer en una variable  
    ob_end_clean();

    $html2pdf->writeHTML($mihtml);
    $html2pdf->output('personas.pdf');

    
  }


?>
