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

  include ($absolute_include."modelos/cargos/model.cargos.php");   // para manejar los cargos



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

    cargos_index($textoabuscar);
  } 
  elseif ( $accion == "crear")  
  {
    cargos_crear();
  }
  elseif ( $accion == "editar")  
  {

    if (isset( $_REQUEST['cargo_id'] )) { 
      $cargo_id=$_REQUEST['cargo_id'];
    }  

    cargos_editar($cargo_id);
  }
  elseif ( $accion == "mostrar")  
  {

    if (isset( $_REQUEST['cargo_id'] )) { 
      $cargo_id=$_REQUEST['cargo_id'];
    }  

    cargos_mostrar($cargo_id);
  }
  elseif ( $accion == "insertar")  
  {
    // verifico que el pedido sea desde un formulario del sistema
    $token=$_POST['token'];

    if($_SESSION['token'] == $token){
      cargos_insertar($_POST);
    } 
    else {
      cargos_index($textoabuscar);
    } 
  }
  elseif ( $accion == "actualizar")  
  {
    // verifico que el pedido sea desde un formulario del sistema
    $token=$_POST['token'];

    if($_SESSION['token'] == $token){
      cargos_actualizar($_POST);
    } 
    else {
      cargos_index($textoabuscar);
    } 
  }
  elseif ( $accion == "eliminar")  
  {
    // verifico que el pedido sea desde un formulario del sistema
    $token=$_POST['token'];

    if($_SESSION['token'] == $token){
      cargos_eliminar($_POST);
    } 
    else {
      cargos_index($textoabuscar);
    } 
  }
  elseif ( $accion == "imprimir")  
  {
    // verifico que el pedido sea desde un formulario del sistema
    $token=$_POST['token'];

    if($_SESSION['token'] == $token){
      cargos_imprimir($textoabuscar);
    } 
    else {
      cargos_index($textoabuscar);
    } 
  }
  elseif ( $accion == "pdf")  
  {
    // verifico que el pedido sea desde un formulario del sistema
    $token=$_POST['token'];

    if($_SESSION['token'] == $token){
      cargos_pdf($textoabuscar);
    } 
    else {
      cargos_index($textoabuscar);
    } 
  }

  
  function cargos_index($arg_textoabuscar){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // busca los cargos en la base de datos

    $cargos = buscar_cargos($arg_textoabuscar);

    // llama a la vista de index de cargos

    include ($absolute_include."vistas/cargos/index.php"); 

  }

  function cargos_crear(){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // llama a la vista para crear cargos

    include ($absolute_include."vistas/cargos/crear.php"); 

  }


  function cargos_editar($arg_cargo_id){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // busca el cargo en la base de datos

    $cargo = buscar_un_cargo($arg_cargo_id);

    // llama a la vista para editar cargos

    include ($absolute_include."vistas/cargos/editar.php"); 

  }


  function cargos_mostrar($arg_cargo_id){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // busca el cargo en la base de datos

    $cargo = buscar_un_cargo($arg_cargo_id);

    // llama a la vista para mostrar cargos

    include ($absolute_include."vistas/cargos/mostrar.php"); 

  }


  function cargos_insertar($arg_POST){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // validaciones de los datos del formulario
   
    $validacion_errores = array();   // array que contiene los errores de validacion
   
    $validacion_errores = cargos_validar($arg_POST,0);   // le paso a la funcion de validacion todos los datos
                                                       // del formulario 

    if ( count($validacion_errores)<>0 ){

        // si hay errores
        // llama a la vista para mostrar ERRORES

        include ($absolute_include."vistas/cargos/errores.php"); 
    }
    else {

        // si no hay errores
        // controlo los contenidos de los campos

        $cdescripcion_cargo = strtoupper($arg_POST['cdescripcion_cargo']);

        // llamo a la funcion en el modelo para grabar un cargo
        $ultimo_cargo_id=insertar_cargo($cdescripcion_cargo);

        // llamo a la funcion en el modelo para grabar el log

        $cdescripcion_log =" Creacion de Cargo :".$cdescripcion_cargo." con ID: $ultimo_cargo_id";
        insertar_log( $cdescripcion_log);


        // llama al controlador de cargos para ir al inicio
        header("Location: ".$carpeta_trabajo."/controladores/cargos/controller.cargos.php");
    }    

  }


  function cargos_actualizar($arg_POST){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // cuando estoy actualizando debo guardar los datos viejos para saber si hay cambios
    // busca el cargo en la base de datos para guardar los datos viejos

    $cargo_olddata = buscar_un_cargo($arg_POST['cargo_id']);

    // validaciones de los datos del formulario
    $validacion_errores = array();   // array que contiene los errores de validacion
      
    $validacion_errores = cargos_validar($arg_POST,$arg_POST['cargo_id']);   // le paso a la funcion de validacion todos los datos
                                                                            // del formulario 

    if ( count($validacion_errores)<>0 ){

        // si hay errores
        // llama a la vista para mostrar ERRORES

        include ($absolute_include."vistas/cargos/errores.php"); 
    }
    else {

        // si no hay errores
        
        // controlo si hay cambios en los datos

        $validacion_cambios = array();   // array que contiene los cambios

        $validacion_cambios = cargos_buscarcambios($arg_POST, $cargo_olddata);
        
        if ( count($validacion_cambios)<>0 ){   // si no hay cambios realmente
        
          // controlo los contenidos de los campos

          $cargo_id=$arg_POST['cargo_id'];
          $cdescripcion_cargo = strtoupper($arg_POST['cdescripcion_cargo']);

          // llamo a la funcion en el modelo para actualizar un cargo
          actualizar_cargo($cargo_id,$cdescripcion_cargo);

          // llamo a la funcion en el modelo para grabar el log
         
          $cdescripcion_log ="";

          foreach ($validacion_cambios as $validacion_cambio) {

             $cdescripcion_log = $cdescripcion_log .$validacion_cambio. PHP_EOL ;
          }

          insertar_log( $cdescripcion_log);


          // llama al controlador de cargos para ir al inicio
          header("Location: ".$carpeta_trabajo."/controladores/cargos/controller.cargos.php");
        }  
    }
    
  }

  function cargos_eliminar($arg_POST){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // cuando estoy eliminando debo guardar los datos viejos para el log
    // busca el cargo en la base de datos para guardar los datos viejos

    $cargo_olddata = buscar_un_cargo($arg_POST['cargo_id']);

    $cargo_id=$arg_POST['cargo_id'];
   
    // llamo a la funcion en el modelo para eliminar un cargo
    eliminar_cargo($cargo_id);

    // llamo a la funcion en el modelo para grabar el log

    $cdescripcion_log =" Elimino el Cargo  ".$cargo_olddata['cdescripcion_cargo']." con ID: $cargo_id";
    insertar_log( $cdescripcion_log);


    // llama al controlador de cargos para ir al inicio
    header("Location: ".$carpeta_trabajo."/controladores/cargos/controller.cargos.php");

    
  }
  
  function cargos_imprimir($arg_textoabuscar){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // busca los cargos en la base de datos

    $cargos = buscar_cargos($arg_textoabuscar);

    // llama a la vista de impresion de cargos

    include ($absolute_include."vistas/cargos/imprimir.php"); 

    include ($absolute_include."vistas/plantillas/footer_imprimir.php"); 
 

  }

  function cargos_pdf($arg_textoabuscar){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // busca los cargos en la base de datos

    $cargos = buscar_cargos($arg_textoabuscar);

    $html2pdf = new Html2Pdf('P','A4','es','true',"UTF-8'");   // crea un nuevo objeto
    
    ob_start();   // creo un buffer en memoria que va a recoger todo lo que se deberia mostrar en pantalla
    
    include ($absolute_include."vistas/cargos/imprimir_pdf.php"); 

    include ($absolute_include."vistas/plantillas/footer_pdf.php"); 
 
    $mihtml=ob_get_clean();   // guardo todo lo de buffer en una variable  
    ob_end_clean();

    $html2pdf->writeHTML($mihtml);
    $html2pdf->output('cargos.pdf');

 }
  
  function cargos_validar($arg_POST,$arg_cargo_id){

    $errores = array();  // creo un array para guardar los errores
   
    $cdescripcion_cargo = strtoupper($arg_POST['cdescripcion_cargo']);

    
    // validaciones de los datos del formulario
    // verifico que no exista un cargo en la tabla con el mismo nombre

    $cargo=buscar_un_cargo_por("cdescripcion_cargo LIKE '".$cdescripcion_cargo."'",$arg_cargo_id);

    if ( count($cargo)<>0 ){
        // existe un cargo en la tabla con los mismos datos
      
      $errores['error'] ="Ya existe un cargo con la Descripcion :".$cdescripcion_cargo;
      $errores['cargo_id'] = $arg_cargo_id;
    
    }

    return $errores;
  }

  function cargos_buscarcambios($arg_POST,$arg_olddata){

    $cambios = array();  // creo un array para guardar los cambios

    $cdescripcion_cargo = strtoupper($arg_POST['cdescripcion_cargo']);

    if (trim($cdescripcion_cargo) <> trim($arg_olddata['cdescripcion_cargo'])) {

        $cambios[] =" Modificacion de Cargo - ".$arg_olddata['cdescripcion_cargo']." cambio a ".$cdescripcion_cargo
          ." con ID: ".$arg_olddata['cargo_id'];

    }
    
    return $cambios;
  }


?>