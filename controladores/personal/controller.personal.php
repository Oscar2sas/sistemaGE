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

  include ($absolute_include."modelos/personal/model.personal.php");   // para manejar los paises



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

    personal_index($textoabuscar);
  } 
  elseif ( $accion == "crear")  
  {
    personal_crear();
    echo $accion;
    die();
  }
  elseif ( $accion == "editar")  
  {

    if (isset( $_REQUEST['personal_id'] )) { 
      $personal_id=$_REQUEST['personal_id'];
    }  

    personal_editar($personal_id);
  }
  elseif ( $accion == "mostrar")  
  {

    if (isset( $_REQUEST['personal_id'] )) { 
      $personal_id=$_REQUEST['personal_id'];
    }  

    personal_mostrar($personal_id);
  }
  elseif ( $accion == "insertar")  
  {

    // verifico que el pedido sea desde un formulario del sistema
    $token=$_POST['token'];

    if($_SESSION['token'] == $token){
      personal_insertar($_POST);
    } 
    else {
      personal_index($textoabuscar);
    } 
  }
  elseif ( $accion == "actualizar")  
  {
    // verifico que el pedido sea desde un formulario del sistema
    $token=$_POST['token'];

    if($_SESSION['token'] == $token){
      actualizar_personal($_POST);
    } 
    else {
      personal_index($textoabuscar);
    } 
  }
  elseif ( $accion == "eliminar")  
  {
    // verifico que el pedido sea desde un formulario del sistema
    $token=$_POST['token'];

    if($_SESSION['token'] == $token){
      //$personal_id=$_REQUEST['personal_id'];
      //echo "Personal_id= ", $personal_id;
      //die();
      personal_eliminar($_POST);
    } 
    else {
      $personal = buscar_personal($arg_textoabuscar);
    } 
  }
  elseif ( $accion == "imprimir")  
  {
    // verifico que el pedido sea desde un formulario del sistema
    $token=$_POST['token'];

    if($_SESSION['token'] == $token){
      personal_imprimir($textoabuscar);
      
    } 
    else {
      personal_index($textoabuscar);
    } 
  }
  elseif ( $accion == "pdf")  
  {
    // verifico que el pedido sea desde un formulario del sistema
    $token=$_POST['token'];

    if($_SESSION['token'] == $token){
      personal_pdf($textoabuscar);
    } 
    else {
      personal_index($textoabuscar);
    } 
  }

  
  function personal_index($arg_textoabuscar){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // busca los paises en la base de datos

    $personales = buscar_personal($arg_textoabuscar);

   // var_dump($personales);
   //die();

     // llama a la vista de index de paises

    include ($absolute_include."vistas/personal/index.php"); 

  }

  function personal_crear(){
    
    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // llama a la vista para crear paises
    $personales = buscar_personal();
    include ($absolute_include."vistas/personal/crear.php");

  }


  function personal_editar($arg_personal_id){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // busca el pais en la base de datos

    $personal = buscar_un_personal($arg_personal_id);

    // llama a la vista para editar persona

    include ($absolute_include."vistas/personal/editar.php"); 

  }


  function personal_mostrar($arg_personal_id){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // busca el pais en la base de datos

    $personal = buscar_un_personal($arg_personal_id);
    //var_dump($personal);
    //die();
    // llama a la vista para editar personal

    include ($absolute_include."vistas/personal/mostrar.php"); 

  }



  function personal_insertar($arg_POST){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // aqui se pueden hacer validaciones de los datos que vienen
    // del formulario y devolver un error
    
    //$personal_id = strtoupper($arg_POST['personal_id']);
    $cobservaciones_personal= strtoupper($arg_POST['observaciones']);
    $cnumlegajo_personal = strtoupper($arg_POST['legajo']);
    $rela_persona_id = $arg_POST['rela_persona_id'];
    $tipo_cargo_id = $arg_POST['tipo_cargo_id'];
  
    
    // llamo a la funcion en el modelo para grabar una persona
    $ultimo_personal_id=insertar_personal($cnumlegajo_personal,$cobservaciones_personal,$rela_persona_id,$tipo_cargo_id);

    // llamo a la funcion en el modelo para grabar el log

    $cdescripcion_log =" Creacion del personal :".$cobservaciones_personal." con ID: $ultimo_personal_id";
    insertar_log( $cdescripcion_log);


    // llama al controlador de paises para ir al inicio
    header("Location: ".$carpeta_trabajo."/controladores/personal/controller.personal.php");
  }

  function actualizar_persona($arg_POST){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // aqui se pueden hacer validaciones de los datos que vienen
    // del formulario y devolver un error 

    $capellidos_persona= $arg_POST['capellidos_persona'];
    //echo "capellidos_persona: $capellidos_persona";
    //echo "<br>";
    $cnombres_persona= $arg_POST['cnombres_persona'];
   // echo "cnombres_personal: $cnombres_persona";
    //echo "<br>";
    $ndni_persona = $arg_POST['ndni_persona'];
    //echo "ndni_persona: $ndni_persona";
    //echo "<br>";
    //die();
    
    // llamo a la funcion en el modelo para grabar un pais
    persona_actualizar($capellidos_persona, $cnombres_persona, $ndni_persona, $personal_id);

    // llamo a la funcion en el modelo para grabar el log

    $cdescripcion_log =" Modificacion del personal - Nuevo nombre : ".$nsituacion_personal." con ID: $personal_id";
    insertar_log( $cdescripcion_log);



    // llama al controlador de paises para ir al inicio
    header("Location: ".$carpeta_trabajo."/controladores/personal/controller.personal.php");

    
  
   }

  function actualizar_personal($arg_POST){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // aqui se pueden hacer validaciones de los datos que vienen
    // del formulario y devolver un error 

    $personal_id=$arg_POST['personal_id'];
    //echo "personal_id: $personal_id";
    //echo "<br>";
    $cobservaciones_personal  = strtoupper($arg_POST['cobservaciones_personal']);
   // echo "cobservaciones_personal: $cobservaciones_personal";
    //echo "<br>";
    $cnumlegajo_personal = $arg_POST['cnumlegajo_personal'];
    //echo "cnumlegajo_personal: $cnumlegajo_personal";
    //echo "<br>";
    $capellidos_persona= $arg_POST['capellidos_persona'];
    //echo "capellidos_persona: $capellidos_persona";
    //echo "<br>";
    $cnombres_persona= $arg_POST['cnombres_persona'];
   // echo "cnombres_personal: $cnombres_persona";
    //echo "<br>";
    $ndni_persona = $arg_POST['ndni_persona'];
  
    $rela_persona_id=$arg_POST['rela_persona_id'];
    
    
    // llamo a la funcion en el modelo para grabar un pais
    personal_actualizar($cobservaciones_personal, $cnumlegajo_personal, $personal_id);

    // llamo a la funcion en el modelo para grabar un pais
    persona_actualizar($capellidos_persona, $cnombres_persona, $ndni_persona, $rela_persona_id);


    // llamo a la funcion en el modelo para grabar el log

    $cdescripcion_log =" Modificacion del personal - Nuevo nombre : ".$nsituacion_personal." con ID: $personal_id";
    insertar_log( $cdescripcion_log);



    // llama al controlador de paises para ir al inicio
    header("Location: ".$carpeta_trabajo."/controladores/personal/controller.personal.php");

    
  }
  

  function personal_eliminar($arg_POST){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // aqui se pueden hacer validaciones de los datos que vienen
    // del formulario y devolver un error 

    $personal_id=$arg_POST['personal_id'];
   //echo $personal_id;
   //die();
    // llamo a la funcion en el modelo para grabar un personal
    eliminar_historial_del_personal($personal_id);
    eliminar_personal($personal_id);
    //echo $personal_id;
    //die();
    // llamo a la funcion en el modelo para grabar el log

    $cdescripcion_log =" Elimino el personal con ID: $personal_id";
    insertar_log( $cdescripcion_log);


    // llama al controlador de paises para ir al inicio
    header("Location: ".$carpeta_trabajo."/controladores/personal/controller.personal.php");

    
  }
  
  function personal_imprimir($arg_textoabuscar){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // busca los paises en la base de datos

   $personal = buscar_personal($arg_textoabuscar);

   // llama a la vista de index de paises

   include ($absolute_include."vistas/personal/imprimir.php"); 

   include ($absolute_include."vistas/plantillas/head_imprimir.php"); 

  }

  function personal_pdf($arg_textoabuscar){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // busca los paises en la base de datos

    $personal = buscar_personal($arg_textoabuscar);

    $html2pdf = new Html2Pdf('P','A4','es','true',"UTF-8'");   // crea un nuevo objeto
    
    ob_start();   // creo un buffer en memoria que va a recoger todo lo que se deberia mostrar en pantalla
    
    include ($absolute_include."vistas/personal/imprimir.php"); 

    include ($absolute_include."vistas/plantillal/footer_pdf.php"); 
 
    $mihtml=ob_get_clean();   // guardo todo lo de buffer en una variable  
    ob_end_clean();

    $html2pdf->writeHTML($mihtml);
    $html2pdf->output('personal.pdf');

    
  }

?>