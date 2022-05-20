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





  include ($absolute_include."config/global.php");   // variables de configuracion
  
  include ($absolute_include."clases/class.conexion.php");   // clase para conexion de base de datos

  include ($absolute_include."administracion/sesion.php") ;

  include ($absolute_include."modelos/log/model.log.php");   // para manejar los log

  include ($absolute_include."modelos/parametros/model.parametro.php");   // para manejar los paises



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

    parametros_index($textoabuscar);
  } 
  elseif ( $accion == "crear")  
  {
    parametro_crear();
  }
  elseif ( $accion == "editar")  
  {

    if (isset( $_REQUEST['id_parametro'] )) { 
      $parametro_id=$_REQUEST['id_parametro'];
    }  

    parametros_editar($parametro_id);
  }
  elseif ( $accion == "mostrar")  
  {

    if (isset( $_REQUEST['id_parametro'] )) { 
      $parametro_id=$_REQUEST['id_parametro'];
    }  

    parametros_mostrar($parametro_id);
  }
  elseif ( $accion == "insertar")  
  {
    // verifico que el pedido sea desde un formulario del sistema
    $token=$_POST['token'];

    if($_SESSION['token'] == $token){
      parametro_insertar($_POST);
    } 
    else {
      parametros_index($textoabuscar);
    } 
  }
  
  elseif ( $accion == "actualizar")  
  {
    // verifico que el pedido sea desde un formulario del sistema
    $token=$_POST['token'];

    if($_SESSION['token'] == $token){
      parametros_actualizar($_POST);
    } 
    else {
      parametros_index($textoabuscar);
    } 
  }
  elseif ( $accion == "eliminar")  
  {
    // verifico que el pedido sea desde un formulario del sistema
    $token=$_POST['token'];

    if($_SESSION['token'] == $token){
      parametro_eliminar($_POST);
    } 
    else {
      parametros_index($textoabuscar);
    } 
  }
  

  
  function parametros_index($arg_textoabuscar){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // busca los paises en la base de datos

    $parametros = buscar_parametros($arg_textoabuscar);
    
    // llama a la vista de index de paises

    include ($absolute_include."vistas/parametros/index.php"); 

  }

  

  function parametros_editar($arg_parametro_id){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // busca el pais en la base de datos

    $parametro = buscar_un_parametro($arg_parametro_id);
    $tipos_parametros = buscar_tipos();

    // llama a la vista para editar paises

    include ($absolute_include."vistas/parametros/editar.php"); 

  }

  function parametro_crear(){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // llama a la vista para crear paises
    $tipos_parametros = buscar_tipos();

    include ($absolute_include."vistas/parametros/crear.php"); 

  }



  function parametro_insertar($arg_POST){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // aqui se pueden hacer validaciones de los datos que vienen
    // del formulario y devolver un error 

    $descripcion = strtoupper($arg_POST['descripcion']);
    $valor = strtoupper($arg_POST['valor']);
    $tipo_parametro = strtoupper($arg_POST['parametro_tipo_id']);

    
    // llamo a la funcion en el modelo para grabar un pais
    $ultimo_parametro_id=insertar_parametro($descripcion, $valor, $tipo_parametro);

    // llamo a la funcion en el modelo para grabar el log

    $cdescripcion_log =" Creacion de Parametro :".$descripcion." con valor: $valor";
    insertar_log( $cdescripcion_log);


    // llama al controlador de paises para ir al inicio
    header("Location: ".$carpeta_trabajo."/controladores/parametros/controller.parametros.php");

   }

  function parametros_actualizar($arg_POST){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // aqui se pueden hacer validaciones de los datos que vienen
    // del formulario y devolver un error 

    $parametro_id=$arg_POST['id_parametro'];
    $descrip_parametro = strtoupper($arg_POST['descripcion']);
    $valor_parametro = strtoupper($arg_POST['valor']);
    $parametro_tipo = strtoupper($arg_POST['parametro_tipo_id']);

    
    // llamo a la funcion en el modelo para grabar un pais
    actualizar_parametro($parametro_id,$descrip_parametro, $valor_parametro, $parametro_tipo);

    // llamo a la funcion en el modelo para grabar el log

    $cdescripcion_log =" Modificacion de Parametro - Nuevo nombre : ".$descrip_parametro." con valor: $valor_parametro";
    insertar_log( $cdescripcion_log);



    // llama al controlador de paises para ir al inicio
    header("Location: ".$carpeta_trabajo."/controladores/parametros/controller.parametros.php");

    
  }
  function parametros_mostrar($arg_parametro_id){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // busca el pais en la base de datos

    $parametro = buscar_un_parametro($arg_parametro_id);

    // llama a la vista para editar paises

    include ($absolute_include."vistas/parametros/eliminar.php"); 

  }


  function parametro_eliminar($arg_POST){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // aqui se pueden hacer validaciones de los datos que vienen
    // del formulario y devolver un error 

    $parametro_id=$arg_POST['id_parametro'];
    $parametro_desc=$arg_POST['descripcion'];
    
    // llamo a la funcion en el modelo para grabar un parametro
    eliminar_parametro($parametro_id);

    // llamo a la funcion en el modelo para grabar el log

    $cdescripcion_log =" Elimino el Parametro con ID: $parametro_id y nombre: $parametro_desc";
    insertar_log( $cdescripcion_log);


    // llama al controlador de parametros para ir al inicio
    header("Location: ".$carpeta_trabajo."/controladores/parametros/controller.parametros.php");

    
  }



?>
