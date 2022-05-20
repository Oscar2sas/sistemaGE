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

  include ($absolute_include."modelos/estadodocentes/model.estadodocentes.php");   // para manejar los estadodocentes



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

    estadodocentes_index($textoabuscar);
  } 
  elseif ( $accion == "crear")  
  {
    estadodocentes_crear();
  }
  elseif ( $accion == "editar")  
  {

    if (isset( $_REQUEST['estadodocente_id'] )) { 
      $estadodocente_id=$_REQUEST['estadodocente_id'];
    }  

    estadodocentes_editar($estadodocente_id);
  }
  elseif ( $accion == "mostrar")  
  {

    if (isset( $_REQUEST['estadodocente_id'] )) { 
      $estadodocente_id=$_REQUEST['estadodocente_id'];
    }  

    estadodocentes_mostrar($estadodocente_id);
  }
  elseif ( $accion == "insertar")  
  {
    // verifico que el pedido sea desde un formulario del sistema
    $token=$_POST['token'];

    if($_SESSION['token'] == $token){
      estadodocentes_insertar($_POST);
    } 
    else {
      estadodocentes_index($textoabuscar);
    } 
  }
  elseif ( $accion == "actualizar")  
  {
    // verifico que el pedido sea desde un formulario del sistema
    $token=$_POST['token'];

    if($_SESSION['token'] == $token){
      estadodocentes_actualizar($_POST);
    } 
    else {
      estadodocentes_index($textoabuscar);
    } 
  }
  elseif ( $accion == "eliminar")  
  {
    // verifico que el pedido sea desde un formulario del sistema
    $token=$_POST['token'];

    if($_SESSION['token'] == $token){
      estadodocentes_eliminar($_POST);
    } 
    else {
      estadodocentes_index($textoabuscar);
    } 
  }
  elseif ( $accion == "imprimir")  
  {
    // verifico que el pedido sea desde un formulario del sistema
    $token=$_POST['token'];

    if($_SESSION['token'] == $token){
      estadodocentes_imprimir($textoabuscar);
    } 
    else {
      estadodocentes_index($textoabuscar);
    } 
  }
  elseif ( $accion == "pdf")  
  {
    // verifico que el pedido sea desde un formulario del sistema
    $token=$_POST['token'];

    if($_SESSION['token'] == $token){
      estadodocentes_pdf($textoabuscar);
    } 
    else {
      estadodocentes_index($textoabuscar);
    } 
  }

  
  function estadodocentes_index($arg_textoabuscar){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // busca los estadodocentes en la base de datos

    $estadodocentes = buscar_estadodocentes($arg_textoabuscar);

    // llama a la vista de index de estadodocentes

    include ($absolute_include."vistas/estadodocentes/index.php"); 

  }

  function estadodocentes_crear(){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // llama a la vista para crear estadodocentes

    include ($absolute_include."vistas/estadodocentes/crear.php"); 

  }


  function estadodocentes_editar($arg_estadodocente_id){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // busca el estadodocente en la base de datos

    $estadodocente = buscar_un_estadodocente($arg_estadodocente_id);

    // llama a la vista para editar estadodocentes

    include ($absolute_include."vistas/estadodocentes/editar.php"); 

  }


  function estadodocentes_mostrar($arg_estadodocente_id){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // busca el estadodocente en la base de datos

    $estadodocente = buscar_un_estadodocente($arg_estadodocente_id);

    // llama a la vista para mostrar estadodocentes

    include ($absolute_include."vistas/estadodocentes/mostrar.php"); 

  }


  function estadodocentes_insertar($arg_POST){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // validaciones de los datos del formulario
   
    $validacion_errores = array();   // array que contiene los errores de validacion
   
    $validacion_errores = estadodocentes_validar($arg_POST,0);   // le paso a la funcion de validacion todos los datos
                                                       // del formulario 

    if ( count($validacion_errores)<>0 ){

        // si hay errores
        // llama a la vista para mostrar ERRORES

        include ($absolute_include."vistas/estadodocentes/errores.php"); 
    }
    else {

        // si no hay errores
        // controlo los contenidos de los campos

        $cdescripcion_estadodocente = strtoupper($arg_POST['cdescripcion_estadodocente']);

        // llamo a la funcion en el modelo para grabar un estadodocente
        $ultimo_estadodocente_id=insertar_estadodocente($cdescripcion_estadodocente);

        // llamo a la funcion en el modelo para grabar el log

        $cdescripcion_log =" Creacion de Estado de Docente :".$cdescripcion_estadodocente." con ID: $ultimo_estadodocente_id";
        insertar_log( $cdescripcion_log);


        // llama al controlador de estadodocentes para ir al inicio
        header("Location: ".$carpeta_trabajo."/controladores/estadodocentes/controller.estadodocentes.php");
    }    

  }


  function estadodocentes_actualizar($arg_POST){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // cuando estoy actualizando debo guardar los datos viejos para saber si hay cambios
    // busca el estadodocente en la base de datos para guardar los datos viejos

    $estadodocente_olddata = buscar_un_estadodocente($arg_POST['estadodocente_id']);

    // validaciones de los datos del docente
    $validacion_errores = array();   // array que contiene los errores de validacion
      
    $validacion_errores = estadodocentes_validar($arg_POST,$arg_POST['estadodocente_id']);   // le paso a la funcion de validacion todos los datos
                                                                            // del formulario 

    if ( count($validacion_errores)<>0 ){

        // si hay errores
        // llama a la vista para mostrar ERRORES

        include ($absolute_include."vistas/estadodocentes/errores.php"); 
    }
    else {

        // si no hay errores
        
        // controlo si hay cambios en los datos

        $validacion_cambios = array();   // array que contiene los cambios

        $validacion_cambios = estadodocentes_buscarcambios($arg_POST, $estadodocente_olddata);
        
        if ( count($validacion_cambios)<>0 ){   // si no hay cambios realmente
        
          // controlo los contenidos de los campos

          $estadodocente_id=$arg_POST['estadodocente_id'];
          $cdescripcion_estadodocente = strtoupper($arg_POST['cdescripcion_estadodocente']);

          // llamo a la funcion en el modelo para actualizar un estadodocente
          actualizar_estadodocente($estadodocente_id,$cdescripcion_estadodocente);

          // llamo a la funcion en el modelo para grabar el log
         
          $cdescripcion_log ="";

          foreach ($validacion_cambios as $validacion_cambio) {

             $cdescripcion_log = $cdescripcion_log .$validacion_cambio. PHP_EOL ;
          }

          insertar_log( $cdescripcion_log);


          // llama al controlador de estadodocentes para ir al inicio
          header("Location: ".$carpeta_trabajo."/controladores/estadodocentes/controller.estadodocentes.php");
        }  
    }
    
  }

  function estadodocentes_eliminar($arg_POST){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // cuando estoy eliminando debo guardar los datos viejos para el log
    // busca el estadodocente en la base de datos para guardar los datos viejos

    $estadodocente_olddata = buscar_un_estadodocente($arg_POST['estadodocente_id']);

    $estadodocente_id=$arg_POST['estadodocente_id'];
   
    // llamo a la funcion en el modelo para eliminar un estadodocente
    eliminar_estadodocente($estadodocente_id);

    // llamo a la funcion en el modelo para grabar el log

    $cdescripcion_log =" Elimino el Estado de Docente  ".$estadodocente_olddata['cdescripcion_estadodocente']." con ID: $estadodocente_id";
    insertar_log( $cdescripcion_log);


    // llama al controlador de estadodocentes para ir al inicio
    header("Location: ".$carpeta_trabajo."/controladores/estadodocentes/controller.estadodocentes.php");

    
  }
  
  function estadodocentes_imprimir($arg_textoabuscar){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // busca los estadodocentes en la base de datos

    $estadodocentes = buscar_estadodocentes($arg_textoabuscar);

    // llama a la vista de impresion de estadodocentes

    include ($absolute_include."vistas/estadodocentes/imprimir.php"); 

    include ($absolute_include."vistas/plantillas/footer_imprimir.php"); 
 

  }

  function estadodocentes_pdf($arg_textoabuscar){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // busca los estadodocentes en la base de datos

    $estadodocentes = buscar_estadodocentes($arg_textoabuscar);

    $html2pdf = new Html2Pdf('P','A4','es','true',"UTF-8'");   // crea un nuevo objeto
    
    ob_start();   // creo un buffer en memoria que va a recoger todo lo que se deberia mostrar en pantalla
    
    include ($absolute_include."vistas/estadodocentes/imprimir_pdf.php"); 

    include ($absolute_include."vistas/plantillas/footer_pdf.php"); 
 
    $mihtml=ob_get_clean();   // guardo todo lo de buffer en una variable  
    ob_end_clean();

    $html2pdf->writeHTML($mihtml);
    $html2pdf->output('estadodocentes.pdf');

 }
  
  function estadodocentes_validar($arg_POST,$arg_estadodocente_id){

    $errores = array();  // creo un array para guardar los errores
   
    $cdescripcion_estadodocente = strtoupper($arg_POST['cdescripcion_estadodocente']);

    
    // validaciones de los datos del formulario
    // verifico que no exista un estadodocente en la tabla con el mismo nombre

    $estadodocente=buscar_un_estadodocente_por("cdescripcion_estadodocente LIKE '".$cdescripcion_estadodocente."'",$arg_estadodocente_id);

    if ( count($estadodocente)<>0 ){
        // existe un estadodocente en la tabla con los mismos datos
      
      $errores['error'] ="Ya existe un Estado de Docente con la Descripcion :".$cdescripcion_estadodocente;
      $errores['estadodocente_id'] = $arg_estadodocente_id;
    
    }

    return $errores;
  }

  function estadodocentes_buscarcambios($arg_POST,$arg_olddata){

    $cambios = array();  // creo un array para guardar los cambios

    $cdescripcion_estadodocente = strtoupper($arg_POST['cdescripcion_estadodocente']);

    if (trim($cdescripcion_estadodocente) <> trim($arg_olddata['cdescripcion_estadodocente'])) {

        $cambios[] =" Modificacion de Estado de Docente - ".$arg_olddata['cdescripcion_estadodocente']." cambio a ".$cdescripcion_estadodocente
          ." con ID: ".$arg_olddata['estadodocente_id'];

    }
    
    return $cambios;
  }


?>