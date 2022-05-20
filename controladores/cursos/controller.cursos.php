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


  function paises_mostrar($arg_pais_id){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // busca el pais en la base de datos

    $pais = buscar_un_pais($arg_pais_id);

    // llama a la vista para mostrar paises

    include ($absolute_include."vistas/paises/mostrar.php"); 

  }


  function paises_insertar($arg_POST){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // validaciones de los datos del formulario
   
    $validacion_errores = array();   // array que contiene los errores de validacion
   
    $validacion_errores = paises_validar($arg_POST,0);   // le paso a la funcion de validacion todos los datos
                                                       // del formulario 

    if ( count($validacion_errores)<>0 ){

        // si hay errores
        // llama a la vista para mostrar ERRORES

        include ($absolute_include."vistas/paises/errores.php"); 
    }
    else {

        // si no hay errores
        // controlo los contenidos de los campos

        $cnombre_pais = strtoupper($arg_POST['cnombre_pais']);

        // llamo a la funcion en el modelo para grabar un pais
        $ultimo_pais_id=insertar_pais($cnombre_pais);

        // llamo a la funcion en el modelo para grabar el log

        $cdescripcion_log =" Creacion de Pais :".$cnombre_pais." con ID: $ultimo_pais_id";
        insertar_log( $cdescripcion_log);

        // llama al controlador de paises para ir al inicio
        header("Location: ".$carpeta_trabajo."/controladores/paises/controller.paises.php");
    }    

  }


  function paises_actualizar($arg_POST){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // cuando estoy actualizando debo guardar los datos viejos para saber si hay cambios
    // busca el pais en la base de datos para guardar los datos viejos

    $pais_olddata = buscar_un_pais($arg_POST['pais_id']);

    // validaciones de los datos del formulario
    $validacion_errores = array();   // array que contiene los errores de validacion
      
    $validacion_errores = paises_validar($arg_POST,$arg_POST['pais_id']);   // le paso a la funcion de validacion todos los datos
                                                                            // del formulario 

    if ( count($validacion_errores)<>0 ){

        // si hay errores
        // llama a la vista para mostrar ERRORES

        include ($absolute_include."vistas/paises/errores.php"); 
    }
    else {

        // si no hay errores
        
        // controlo si hay cambios en los datos

        $validacion_cambios = array();   // array que contiene los cambios

        $validacion_cambios = paises_buscarcambios($arg_POST, $pais_olddata);
        
        if ( count($validacion_cambios)<>0 ){   // si no hay cambios realmente
        
          // controlo los contenidos de los campos

          $pais_id=$arg_POST['pais_id'];
          $cnombre_pais = strtoupper($arg_POST['cnombre_pais']);

          // llamo a la funcion en el modelo para actualizar un pais
          actualizar_pais($pais_id,$cnombre_pais);

          // llamo a la funcion en el modelo para grabar el log
         
          $cdescripcion_log ="";

          foreach ($validacion_cambios as $validacion_cambio) {

             $cdescripcion_log = $cdescripcion_log .$validacion_cambio. PHP_EOL ;
          }

          insertar_log( $cdescripcion_log);


          // llama al controlador de paises para ir al inicio
          header("Location: ".$carpeta_trabajo."/controladores/paises/controller.paises.php");
        }  
    }
    
  }

  function paises_eliminar($arg_POST){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // cuando estoy eliminando debo guardar los datos viejos para el log
    // busca el pais en la base de datos para guardar los datos viejos

    $pais_olddata = buscar_un_pais($arg_POST['pais_id']);

    $pais_id=$arg_POST['pais_id'];
   
    // llamo a la funcion en el modelo para eliminar un pais
    eliminar_pais($pais_id);

    // llamo a la funcion en el modelo para grabar el log

    $cdescripcion_log =" Elimino el Pais  ".$pais_olddata['cnombre_pais']." con ID: $pais_id";
    insertar_log( $cdescripcion_log);


    // llama al controlador de paises para ir al inicio
    header("Location: ".$carpeta_trabajo."/controladores/paises/controller.paises.php");

    
  }
  
  function paises_imprimir($arg_textoabuscar){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // busca los paises en la base de datos

    $paises = buscar_paises($arg_textoabuscar);

    // llama a la vista de impresion de paises

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
    
    include ($absolute_include."vistas/paises/imprimir_pdf.php"); 

    include ($absolute_include."vistas/plantillas/footer_pdf.php"); 
 
    $mihtml=ob_get_clean();   // guardo todo lo de buffer en una variable  
    ob_end_clean();

    $html2pdf->writeHTML($mihtml);
    $html2pdf->output('paises.pdf');

    
  }
  
  function paises_validar($arg_POST,$arg_pais_id){

    $errores = array();  // creo un array para guardar los errores
   
    $cnombre_pais = strtoupper($arg_POST['cnombre_pais']);

    
    // validaciones de los datos del formulario
    // verifico que no exista un pais en la tabla con el mismo nombre

    $pais=buscar_un_pais_por("cnombre_pais LIKE '".$cnombre_pais."'",$arg_pais_id);

    if ( count($pais)<>0 ){
        // existe un pais en la tabla con los mismos datos
      
      $errores['error'] ="Ya existe un pais con el Nombre :".$cnombre_pais;
      $errores['pais_id'] = $arg_pais_id;
    
    }

    return $errores;
  }

  function paises_buscarcambios($arg_POST,$arg_olddata){

    $cambios = array();  // creo un array para guardar los cambios

    $cnombre_pais = strtoupper($arg_POST['cnombre_pais']);

    if (trim($cnombre_pais) <> trim($arg_olddata['cnombre_pais'])) {

        $cambios[] =" Modificacion de Pais - ".$arg_olddata['cnombre_pais']." cambio a ".$cnombre_pais
          ." con ID: ".$arg_olddata['pais_id'];

    }
    
    return $cambios;
  }


?>