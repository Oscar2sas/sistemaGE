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


  include ($absolute_include."config/global.php");  // variables de configuracion
  
  include ($absolute_include."clases/class.conexion.php");   // clase para conexion de base de datos

  include ($absolute_include."administracion/sesion.php");

  include ($absolute_include."modelos/log/model.log.php");   // para manejar los log

  include ($absolute_include."modelos/etapasescolares/estapas_escolares.php");   // para manejar las etapas
  



  //verifica si se llamo a una accion determinada en el controlador
  $accion="";
  // verifica si esta especificando un filtro
  $textoabuscar="";

  if (isset($_REQUEST['accion'])) {   // si existe una variable tipo REQUEST que llama a una accion / funcion

    $accion=$_REQUEST['accion'];
  } 
  
  // define la accion a realizar 

  if ( $accion=="" OR $accion=="index" )  
  {
    if (isset( $_REQUEST['textoabuscar'] )) { 
      $textoabuscar=$_REQUEST['textoabuscar'];
    }  

    etapasescolares_index($textoabuscar);
  } 
  elseif ( $accion == "crear")  
  {

    etapasescolares_crear();
  }
  elseif ( $accion == "editar")  
  {

    if (isset( $_REQUEST['etapaescolar_id'] )) { 
      $etapaescolar_id=$_REQUEST['etapaescolar_id'];
    }  

    etapasescolares_editar($etapaescolar_id);
  }
  elseif ( $accion == "mostrar")  
  {

    if (isset( $_REQUEST['etapaescolar_id'] )) { 
      $etapaescolar_id=$_REQUEST['etapaescolar_id'];
    }  
                    
    etapasescolares_mostrar($etapaescolar_id);
  }
  elseif ( $accion == "insertar")  
  {
    // verifico que el pedido sea desde un formulario del sistema
    $token=$_POST['token'];

    if($_SESSION['token'] == $token){
      etapasescolares_insertar($_POST);
    } 
    else {
      etapasescolares_index($textoabuscar);
    } 
  }  elseif ( $accion == "actualizar")  
  {
    // verifico que el pedido sea desde un formulario del sistema
    $token=$_POST['token'];

    if($_SESSION['token'] == $token){
      etapasescolares_actualizar($_POST);
    } 
    else {
      etapasescolares_index($textoabuscar);
    } 
  }
  elseif ( $accion == "eliminar")  
  {
    // verifico que el pedido sea desde un formulario del sistema
    $token=$_POST['token'];

    if($_SESSION['token'] == $token){
      etapasescolares_eliminar($_POST);
    } 
    else {
      etapasescolares_index($textoabuscar);
    } 
  }
  elseif ( $accion == "imprimir")  
  {
    // verifico que el pedido sea desde un formulario del sistema
    $token=$_POST['token'];

    if($_SESSION['token'] == $token){
      etapasescolares_imprimir($textoabuscar);
    } 
    else {
      etapasescolares_index($textoabuscar);
    } 
  }
  elseif ( $accion == "pdf")  
  {
    // verifico que el pedido sea desde un formulario del sistema
    $token=$_POST['token'];

    if($_SESSION['token'] == $token){
      etapasescolares_pdf($textoabuscar);
    } 
    else {
      etapasescolares_index($textoabuscar);
    } 
  }

  
  function etapasescolares_index($arg_textoabuscar){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // busca las etapas en la base de datos

    $etapas = buscar_etapas_escolares($arg_textoabuscar);

    // llama a la vista de index de etapasescolares

    include ($absolute_include."vistas/etapasescolares/index.php"); 

  }

  function etapasescolares_crear(){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // llama a la vista para crear las etapas

    include ($absolute_include."vistas/etapasescolares/crear.php"); 

  }


  function etapasescolares_editar($arg_etapaescolar_id){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // busca el pais en la base de datos

    $etapas = buscar_una_etapa($arg_etapaescolar_id);

    // llama a la vista para editar paises

    include ($absolute_include."vistas/etapasescolares/editar.php"); 

  }


  function etapasescolares_mostrar($arg_etapaescolar_id){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // busca la etapa en la base de datos

    $etapas = buscar_una_etapa($arg_etapaescolar_id);

    // llama a la vista para mostrar etapas 

    include ($absolute_include."vistas/etapasescolares/mostrar.php"); 

  }


  function etapasescolares_insertar($arg_POST){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // validaciones de los datos del formulario
   
    $validacion_errores = array();   // array que contiene los errores de validacion
   
    $validacion_errores = etapas_validar($arg_POST,0);   // le paso a la funcion de validacion todos los datos
                                                       // del formulario 

    if ( count($validacion_errores)<>0 ){

        // si hay errores
        // llama a la vista para mostrar ERRORES

        include ($absolute_include."vistas/etapasescolares/errores.php"); 
    }
    else {

        // si no hay errores
        // controlo los contenidos de los campos

        $cdescripcion_etapa = strtoupper($arg_POST['cdescripcion_etapa']);

        // llamo a la funcion en el modelo para grabar un pais
        $ultima_etapa_id=insertar_etapa($cdescripcion_etapa);

        // llamo a la funcion en el modelo para grabar el log

        // $cdescripcion_etapa =" Creacion de Etapas :".$cdescripcion_etapa." con ID: $ultima_etapa_id";
        // insertar_etapa( $cdescripcion_etapa);

        // llama al controlador de paises para ir al inicio
        header("Location: ".$carpeta_trabajo."/controladores/etapasescolares/controller.etapasescolares.php");
    }    

  }


  function etapasescolares_actualizar($arg_POST){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // cuando estoy actualizando debo guardar los datos viejos para saber si hay cambios
    // busca el pais en la base de datos para guardar los datos viejos

    $etapas_olddata = buscar_una_etapa($arg_POST['etapaescolar_id']);

    // validaciones de los datos del formulario
    $validacion_errores = array();   // array que contiene los errores de validacion
      
    $validacion_errores = etapas_validar($arg_POST,$arg_POST['etapaescolar_id']);   // le paso a la funcion de validacion todos los datos
                                                                            // del formulario 

    if ( count($validacion_errores)<>0 ){

        // si hay errores
        // llama a la vista para mostrar ERRORES

        include ($absolute_include."vistas/etapasescolares/errores.php"); 
    }
    else {

        // si no hay errores
        
        // controlo si hay cambios en los datos

        $validacion_cambios = array();   // array que contiene los cambios

        $validacion_cambios = etapas_buscarcambios($arg_POST, $etapa_olddata);
        
        if ( count($validacion_cambios)<>0 ){   // si no hay cambios realmente
        
          // controlo los contenidos de los campos

          $etapaescolar_id=$arg_POST['etapaescolar_id'];
          $cdescripcion_etapa = strtoupper($arg_POST['cdescripcion_etapa']);

          // llamo a la funcion en el modelo para actualizar un pais
          actualizar_etapa($etapaescolar_id,$cdescripcion_etapa);

          // llamo a la funcion en el modelo para grabar el log
         
          $cdescripcion_etapa ="";

          foreach ($validacion_cambios as $validacion_cambios) {

             $cdescripcion_etapa = $cdescripcion_etapa .$validacion_cambios. PHP_EOL ;
          }

          // insertar_etapa( $cdescripcion_etapa);


          // llama al controlador de paises para ir al inicio
          header("Location: ".$carpeta_trabajo."/controladores/etapasescolares/controller.etapasescolares.php");
        }  
    }
    
  }

  function etapasescolares_eliminar($arg_POST){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // cuando estoy eliminando debo guardar los datos viejos para el log
    // busca el pais en la base de datos para guardar los datos viejos

    $etapas_olddata = buscar_una_etapa($arg_POST['etapaescolar_id']);

    $etapaescolar_id=$arg_POST['etapaescolar_id'];
   
    // llamo a la funcion en el modelo para eliminar un etapa
    eliminar_etapa($etapaescolar_id);

    // llamo a la funcion en el modelo para grabar el log

    // $cdescripcion_etapa =" Elimino la Etapa  ".$etapa_olddata['cdescripcion_etapa']." con ID: $etapaescolar_id";
    // insertar_etapa( $cdescripcion_etapa);


    // llama al controlador de etapas para ir al inicio
    header("Location: ".$carpeta_trabajo."/controladores/etapasescolares/controller.etapasescolares.php");

    
  }
  
  function etapasescolares_imprimir($arg_textoabuscar){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // busca los paises en la base de datos

    $etapas = buscar_una_etapa($arg_textoabuscar);

    // llama a la vista de impresion de paises

    include ($absolute_include."vistas/etapasescolares/imprimir.php"); 

    include ($absolute_include."vistas/plantillas/footer_imprimir.php"); 
 

  }

  function etapas_pdf($arg_textoabuscar){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // busca los paises en la base de datos

    $etapas = buscar_etapas($arg_textoabuscar);

    $html2pdf = new Html2Pdf('P','A4','es','true',"UTF-8'");   // crea un nuevo objeto
    
    ob_start();   // creo un buffer en memoria que va a recoger todo lo que se deberia mostrar en pantalla
    
    include ($absolute_include."vistas/etapasescolares/imprimir_pdf.php"); 

    include ($absolute_include."vistas/plantillas/footer_pdf.php"); 
 
    $mihtml=ob_get_clean();   // guardo todo lo de buffer en una variable  
    ob_end_clean();

    $html2pdf->writeHTML($mihtml);
    $html2pdf->output('paises.pdf');

    
  }
  
  function etapas_validar($arg_POST,$arg_etapaescolar_id){

    $errores = array();  // creo un array para guardar los errores
  
    $cdescripcion_etapa = strtoupper($arg_POST['cdescripcion_etapa']);

    
    // validaciones de los datos del formulario
    // verifico que no exista un dato en la tabla con el mismo nombre

    $etapas=buscar_una_etapa_por("cdescripcion_etapa LIKE '".$cdescripcion_etapa."'",$arg_etapaescolar_id);

    if ( count($etapas)<>0 ){
        // existe una etapa en la tabla con los mismos datos
      
      $errores['error'] ="Ya existe una etapa con el Nombre :".$cdescripcion_etapa;
      $errores['etapaescolar_id'] = $arg_etapaescolar_id;
    
    }

    return $errores;
  }

  function etapas_buscarcambios($arg_POST,$arg_olddata){

    $cambios = array();  // creo un array para guardar los cambios

    $cdescripcion_etapa = strtoupper($arg_POST['cdescripcion_etapa']);

    if (trim($cdescripcion_etapa) <> trim($arg_olddata['cdescripcion_etapa'])) {

        $cambios[] =" Modificacion de Etapas - ".$arg_olddata['cdescripcion_etapa']." cambio a ".$cdescripcion_etapa
          ." con ID: ".$arg_olddata['etapaescolar_id'];

    }
    
    return $cambios;
  }


?>