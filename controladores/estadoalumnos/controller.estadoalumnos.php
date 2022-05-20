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

  include ($absolute_include."modelos/estadoalumnos/model.estadoalumnos.php");   // para manejar los estadoalumnos



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

    estadoalumnos_index($textoabuscar);
  } 
  elseif ( $accion == "crear")  
  {
    estadoalumnos_crear();
  }
  elseif ( $accion == "editar")  
  {

    if (isset( $_REQUEST['estadoalumno_id'] )) { 
      $estadoalumno_id=$_REQUEST['estadoalumno_id'];
    }  

    estadoalumnos_editar($estadoalumno_id);
  }
  elseif ( $accion == "mostrar")  
  {

    if (isset( $_REQUEST['estadoalumno_id'] )) { 
      $estadoalumno_id=$_REQUEST['estadoalumno_id'];
    }  

    estadoalumnos_mostrar($estadoalumno_id);
  }
  elseif ( $accion == "insertar")  
  {
    // verifico que el pedido sea desde un formulario del sistema
    $token=$_POST['token'];

    if($_SESSION['token'] == $token){
      estadoalumnos_insertar($_POST);
    } 
    else {
      estadoalumnos_index($textoabuscar);
    } 
  }
  elseif ( $accion == "actualizar")  
  {
    // verifico que el pedido sea desde un formulario del sistema
    $token=$_POST['token'];

    if($_SESSION['token'] == $token){
      estadoalumnos_actualizar($_POST);
    } 
    else {
      estadoalumnos_index($textoabuscar);
    } 
  }
  elseif ( $accion == "eliminar")  
  {
    // verifico que el pedido sea desde un formulario del sistema
    $token=$_POST['token'];

    if($_SESSION['token'] == $token){
      estadoalumnos_eliminar($_POST);
    } 
    else {
      estadoalumnos_index($textoabuscar);
    } 
  }
  elseif ( $accion == "imprimir")  
  {
    // verifico que el pedido sea desde un formulario del sistema
    $token=$_POST['token'];

    if($_SESSION['token'] == $token){
      estadoalumnos_imprimir($textoabuscar);
    } 
    else {
      estadoalumnos_index($textoabuscar);
    } 
  }
  elseif ( $accion == "pdf")  
  {
    // verifico que el pedido sea desde un formulario del sistema
    $token=$_POST['token'];

    if($_SESSION['token'] == $token){
      estadoalumnos_pdf($textoabuscar);
    } 
    else {
      estadoalumnos_index($textoabuscar);
    } 
  }

  
  function estadoalumnos_index($arg_textoabuscar){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // busca los estadoalumnos en la base de datos

    $estadoalumnos = buscar_estadoalumnos($arg_textoabuscar);

    // llama a la vista de index de estadoalumnos

    include ($absolute_include."vistas/estadoalumnos/index.php"); 

  }

  function estadoalumnos_crear(){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // llama a la vista para crear estadoalumnos

    include ($absolute_include."vistas/estadoalumnos/crear.php"); 

  }


  function estadoalumnos_editar($arg_estadoalumno_id){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // busca el estadoalumno en la base de datos

    $estadoalumno = buscar_un_estadoalumno($arg_estadoalumno_id);

    // llama a la vista para editar estadoalumnos

    include ($absolute_include."vistas/estadoalumnos/editar.php"); 

  }


  function estadoalumnos_mostrar($arg_estadoalumno_id){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // busca el estadoalumno en la base de datos

    $estadoalumno = buscar_un_estadoalumno($arg_estadoalumno_id);

    // llama a la vista para mostrar estadoalumnos

    include ($absolute_include."vistas/estadoalumnos/mostrar.php"); 

  }


  function estadoalumnos_insertar($arg_POST){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // validaciones de los datos del formulario
   
    $validacion_errores = array();   // array que contiene los errores de validacion
   
    $validacion_errores = estadoalumnos_validar($arg_POST,0);   // le paso a la funcion de validacion todos los datos
                                                       // del formulario 

    if ( count($validacion_errores)<>0 ){

        // si hay errores
        // llama a la vista para mostrar ERRORES

        include ($absolute_include."vistas/estadoalumnos/errores.php"); 
    }
    else {

        // si no hay errores
        // controlo los contenidos de los campos

        $cdescripcion_estadoalumno = strtoupper($arg_POST['cdescripcion_estadoalumno']);

        // llamo a la funcion en el modelo para grabar un estadoalumno
        $ultimo_estadoalumno_id=insertar_estadoalumno($cdescripcion_estadoalumno);

        // llamo a la funcion en el modelo para grabar el log

        $cdescripcion_log =" Creacion de Estado de Alumno :".$cdescripcion_estadoalumno." con ID: $ultimo_estadoalumno_id";
        insertar_log( $cdescripcion_log);


        // llama al controlador de estadoalumnos para ir al inicio
        header("Location: ".$carpeta_trabajo."/controladores/estadoalumnos/controller.estadoalumnos.php");
    }    

  }


  function estadoalumnos_actualizar($arg_POST){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // cuando estoy actualizando debo guardar los datos viejos para saber si hay cambios
    // busca el estadoalumno en la base de datos para guardar los datos viejos

    $estadoalumno_olddata = buscar_un_estadoalumno($arg_POST['estadoalumno_id']);

    // validaciones de los datos del formulario
    $validacion_errores = array();   // array que contiene los errores de validacion
      
    $validacion_errores = estadoalumnos_validar($arg_POST,$arg_POST['estadoalumno_id']);   // le paso a la funcion de validacion todos los datos
                                                                            // del formulario 

    if ( count($validacion_errores)<>0 ){

        // si hay errores
        // llama a la vista para mostrar ERRORES

        include ($absolute_include."vistas/estadoalumnos/errores.php"); 
    }
    else {

        // si no hay errores
        
        // controlo si hay cambios en los datos

        $validacion_cambios = array();   // array que contiene los cambios

        $validacion_cambios = estadoalumnos_buscarcambios($arg_POST, $estadoalumno_olddata);
        
        if ( count($validacion_cambios)<>0 ){   // si no hay cambios realmente
        
          // controlo los contenidos de los campos

          $estadoalumno_id=$arg_POST['estadoalumno_id'];
          $cdescripcion_estadoalumno = strtoupper($arg_POST['cdescripcion_estadoalumno']);

          // llamo a la funcion en el modelo para actualizar un estadoalumno
          actualizar_estadoalumno($estadoalumno_id,$cdescripcion_estadoalumno);

          // llamo a la funcion en el modelo para grabar el log
         
          $cdescripcion_log ="";

          foreach ($validacion_cambios as $validacion_cambio) {

             $cdescripcion_log = $cdescripcion_log .$validacion_cambio. PHP_EOL ;
          }

          insertar_log( $cdescripcion_log);


          // llama al controlador de estadoalumnos para ir al inicio
          header("Location: ".$carpeta_trabajo."/controladores/estadoalumnos/controller.estadoalumnos.php");
        }  
    }
    
  }

  function estadoalumnos_eliminar($arg_POST){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // cuando estoy eliminando debo guardar los datos viejos para el log
    // busca el estadoalumno en la base de datos para guardar los datos viejos

    $estadoalumno_olddata = buscar_un_estadoalumno($arg_POST['estadoalumno_id']);

    $estadoalumno_id=$arg_POST['estadoalumno_id'];
   
    // llamo a la funcion en el modelo para eliminar un estadoalumno
    eliminar_estadoalumno($estadoalumno_id);

    // llamo a la funcion en el modelo para grabar el log

    $cdescripcion_log =" Elimino el Estado de Alumno  ".$estadoalumno_olddata['cdescripcion_estadoalumno']." con ID: $estadoalumno_id";
    insertar_log( $cdescripcion_log);


    // llama al controlador de estadoalumnos para ir al inicio
    header("Location: ".$carpeta_trabajo."/controladores/estadoalumnos/controller.estadoalumnos.php");

    
  }
  
  function estadoalumnos_imprimir($arg_textoabuscar){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // busca los estadoalumnos en la base de datos

    $estadoalumnos = buscar_estadoalumnos($arg_textoabuscar);

    // llama a la vista de impresion de estadoalumnos

    include ($absolute_include."vistas/estadoalumnos/imprimir.php"); 

    include ($absolute_include."vistas/plantillas/footer_imprimir.php"); 
 

  }

  function estadoalumnos_pdf($arg_textoabuscar){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // busca los estadoalumnos en la base de datos

    $estadoalumnos = buscar_estadoalumnos($arg_textoabuscar);

    $html2pdf = new Html2Pdf('P','A4','es','true',"UTF-8'");   // crea un nuevo objeto
    
    ob_start();   // creo un buffer en memoria que va a recoger todo lo que se deberia mostrar en pantalla
    
    include ($absolute_include."vistas/estadoalumnos/imprimir_pdf.php"); 

    include ($absolute_include."vistas/plantillas/footer_pdf.php"); 
 
    $mihtml=ob_get_clean();   // guardo todo lo de buffer en una variable  
    ob_end_clean();

    $html2pdf->writeHTML($mihtml);
    $html2pdf->output('estadoalumnos.pdf');

 }
  
  function estadoalumnos_validar($arg_POST,$arg_estadoalumno_id){

    $errores = array();  // creo un array para guardar los errores
   
    $cdescripcion_estadoalumno = strtoupper($arg_POST['cdescripcion_estadoalumno']);

    
    // validaciones de los datos del formulario
    // verifico que no exista un estadoalumno en la tabla con el mismo nombre

    $estadoalumno=buscar_un_estadoalumno_por("cdescripcion_estadoalumno LIKE '".$cdescripcion_estadoalumno."'",$arg_estadoalumno_id);

    if ( count($estadoalumno)<>0 ){
        // existe un estadoalumno en la tabla con los mismos datos
      
      $errores['error'] ="Ya existe un Estado de Alumno con la Descripcion :".$cdescripcion_estadoalumno;
      $errores['estadoalumno_id'] = $arg_estadoalumno_id;
    
    }

    return $errores;
  }

  function estadoalumnos_buscarcambios($arg_POST,$arg_olddata){

    $cambios = array();  // creo un array para guardar los cambios

    $cdescripcion_estadoalumno = strtoupper($arg_POST['cdescripcion_estadoalumno']);

    if (trim($cdescripcion_estadoalumno) <> trim($arg_olddata['cdescripcion_estadoalumno'])) {

        $cambios[] =" Modificacion de Estado de Alumno - ".$arg_olddata['cdescripcion_estadoalumno']." cambio a ".$cdescripcion_estadoalumno
          ." con ID: ".$arg_olddata['estadoalumno_id'];

    }
    
    return $cambios;
  }


?>