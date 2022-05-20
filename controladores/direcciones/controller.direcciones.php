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

  include ($absolute_include."modelos/direcciones/model.direcciones.php");   // para manejar los paises

  include ($absolute_include."modelos/barrios/model.barrios.php");

  include ($absolute_include."modelos/calles/model.calles.php");

  include ($absolute_include."modelos/localidades/model.localidades.php");

  include ($absolute_include."modelos/personas/model.personas.php"); 




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

    direcciones_index($textoabuscar);
  } 
  elseif ( $accion == "crear")  
  {
    direcciones_crear();
  }
  elseif ( $accion == "editar")  
  {

    if (isset( $_REQUEST['direccion_id'] )) { 
      $direccion_id=$_REQUEST['direccion_id'];
    }  

    direcciones_editar($direccion_id);
  }
  elseif ( $accion == "mostrar")  
  {

    if (isset( $_REQUEST['direccion_id'] )) { 
      $direccion_id=$_REQUEST['direccion_id'];
    }  

    direcciones_mostrar($direccion_id);
  }
  elseif ( $accion == "insertar")  
  {
    // verifico que el pedido sea desde un formulario del sistema
    $token=$_POST['token'];

    if($_SESSION['token'] == $token){
      direcciones_insertar($_POST);
    } 
    else {
      direcciones_index($textoabuscar);
    } 
  }
  elseif ( $accion == "actualizar")  
  {
    // verifico que el pedido sea desde un formulario del sistema
    $token=$_POST['token'];

    if($_SESSION['token'] == $token){
      direcciones_actualizar($_POST);
    } 
    else {
      direcciones_index($textoabuscar);
    } 
  }
  elseif ( $accion == "eliminar")  
  {
    // verifico que el pedido sea desde un formulario del sistema
    $token=$_POST['token'];

    if($_SESSION['token'] == $token){
      direcciones_eliminar($_POST);
    } 
    else {
      direcciones_index($textoabuscar);
    } 
  }
  elseif ( $accion == "imprimir")  
  {
    // verifico que el pedido sea desde un formulario del sistema
    $token=$_POST['token'];

    if($_SESSION['token'] == $token){
      direcciones_imprimir($textoabuscar);
    } 
    else {
      direcciones_index($textoabuscar);
    } 
  }
  elseif ( $accion == "pdf")  
  {
    // verifico que el pedido sea desde un formulario del sistema
    $token=$_POST['token'];

    if($_SESSION['token'] == $token){
      direcciones_pdf($textoabuscar);
    } 
    else {
      direcciones_index($textoabuscar);
    } 
  }

  
  function direcciones_index($arg_textoabuscar){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // busca los paises en la base de datos

    $direcciones = buscar_direcciones($arg_textoabuscar);

    // llama a la vista de index de paises

    include ($absolute_include."vistas/direcciones/index.php"); 

  }

  function direcciones_crear(){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    //busca los paises de la base de datos 
    $calles = buscar_calle("");
    $barrios = buscar_barrios("");
    $localidades = buscar_localidades("");
    $personas = buscar_persona("");
    // llama a la vista para crear paises


    include ($absolute_include."vistas/direcciones/crear.php"); 

  }


  function direcciones_editar($arg_direccion_id){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // busca el pais en la base de datos
    $calles = buscar_calle("");
    $barrios = buscar_barrios("");
    $localidades = buscar_localidades("");
    $personas = buscar_persona("");
    $direccion = buscar_una_direccion($arg_direccion_id);

    // llama a la vista para editar paises

    include ($absolute_include."vistas/direcciones/editar.php"); 

  }


  function direcciones_mostrar($arg_direccion_id){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // busca el pais en la base de datos

    
    

    $direccion = buscar_una_direccion($arg_direccion_id);

    // llama a la vista para editar paises

    include ($absolute_include."vistas/direcciones/mostrar.php"); 

  }


  function direcciones_insertar($arg_POST){


    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // aqui se pueden hacer validaciones de los datos que vienen
    // del formulario y devolver un error 

    $cmanzana_direccion = strtoupper($arg_POST['cmanzana_direccion']);
    $ccasa_direccion = strtoupper($arg_POST['ccasa_direccion']);
    $csector_direccion = strtoupper($arg_POST['csector_direccion']);
    $clote_direccion = strtoupper($arg_POST['clote_direccion']);
    $cparcela_direccion = strtoupper($arg_POST['cparcela_direccion']);
    $cdescripcion_direccion = strtoupper($arg_POST['cdescripcion_direccion']);
    $rela_calle_id = strtoupper($arg_POST['rela_calle_id']);
    $rela_barrio_id = strtoupper($arg_POST['rela_barrio_id']);
    $rela_localidad_id = strtoupper($arg_POST['rela_localidad_id']);
    $rela_persona_id = strtoupper($arg_POST['rela_persona_id']);

    
    // llamo a la funcion en el modelo para grabar un pais
    $ultimo_direccion_id=insertar_direccion($cmanzana_direccion, $ccasa_direccion, $csector_direccion, $clote_direccion, $cparcela_direccion, $cdescripcion_direccion, $rela_calle_id, $rela_barrio_id, $rela_localidad_id, $rela_persona_id);

    // llamo a la funcion en el modelo para grabar el log

    $cdescripcion_log =" Creacion de direccion :".$cnombre_direccion." con ID: $ultimo_direccion_id";
    insertar_log( $cdescripcion_log);



    // llama al controlador de paises para ir al inicio
    header("Location: ".$carpeta_trabajo."/controladores/direcciones/controller.direcciones.php");

   }

  function direcciones_actualizar($arg_POST){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // aqui se pueden hacer validaciones de los datos que vienen
    // del formulario y devolver un error 

    $direccion_id=$arg_POST['direccion_id'];
    $cmanzana_direccion = strtoupper($arg_POST['cmanzana_direccion']);
    $ccasa_direccion = strtoupper($arg_POST['ccasa_direccion']);
    $csector_direccion = strtoupper($arg_POST['csector_direccion']);
    $clote_direccion = strtoupper($arg_POST['clote_direccion']);
    $cparcela_direccion = strtoupper($arg_POST['cparcela_direccion']);
    $cdescripcion_direccion = strtoupper($arg_POST['cdescripcion_direccion']);
    $rela_calle_id = strtoupper($arg_POST['rela_calle_id']);
    $rela_barrio_id = strtoupper($arg_POST['rela_barrio_id']);
    $rela_localidad_id = strtoupper($arg_POST['rela_localidad_id']);
    $rela_persona_id = strtoupper($arg_POST['rela_persona_id']);

    
    // llamo a la funcion en el modelo para grabar un pais
    actualizar_direccion($direccion_id,$cmanzana_direccion, $ccasa_direccion, $csector_direccion, $clote_direccion, $cparcela_direccion, $cdescripcion_direccion, $rela_calle_id, $rela_barrio_id, $rela_localidad_id, $rela_persona_id);

    // llamo a la funcion en el modelo para grabar el log

    $cdescripcion_log =" Modificacion de direccion - Nuevo nombre : ".$cnombre_direccion." con ID: $direccion_id";
    insertar_log( $cdescripcion_log);



    // llama al controlador de paises para ir al inicio
    header("Location: ".$carpeta_trabajo."/controladores/direcciones/controller.direcciones.php");

    
  }

  function direcciones_eliminar($arg_POST){
    
    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // aqui se pueden hacer validaciones de los datos que vienen
    // del formulario y devolver un error 

    $direccion_id=$arg_POST['direccion_id'];
    $cmanzana_direccion = strtoupper($arg_POST['cmanzana_direccion']);
    $ccasa_direccion = strtoupper($arg_POST['ccasa_direccion']);
    $csector_direccion = strtoupper($arg_POST['csector_direccion']);
    $clote_direccion = strtoupper($arg_POST['clote_direccion']);
    $cparcela_direccion = strtoupper($arg_POST['cparcela_direccion']);
    $cdescripcion_direccion = strtoupper($arg_POST['cdescripcion_direccion']);
    $rela_calle_id = strtoupper($arg_POST['rela_calle_id']);
    $rela_barrio_id = strtoupper($arg_POST['rela_barrio_id']);
    $rela_localidad_id = strtoupper($arg_POST['rela_localidad_id']);
    $rela_persona_id = strtoupper($arg_POST['rela_persona_id']);
   
    
    // llamo a la funcion en el modelo para grabar un pais
    eliminar_direccion($direccion_id, $cmanzana_direccion, $ccasa_direccion, $csector_direccion, $clote_direccion, $cparcela_direccion, $cdescripcion_direccion, $rela_calle_id, $rela_barrio_id, $rela_localidad_id, $rela_persona_id);
    
    // llamo a la funcion en el modelo para grabar el log

    $cdescripcion_log =" Elimino la direccion con ID: $direccion_id";
    insertar_log($cdescripcion_log);


    // llama al controlador de paises para ir al inicio
    header("Location: ".$carpeta_trabajo."/controladores/direcciones/controller.direcciones.php");

    
  }
  
  function direcciones_imprimir($arg_textoabuscar){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // busca los paises en la base de datos

    $direcciones = buscar_direcciones($arg_textoabuscar);

    // llama a la vista de index de paises

    include ($absolute_include."vistas/direcciones/imprimir.php"); 

    include ($absolute_include."vistas/plantillas/footer_imprimir_direcciones.php"); 
 

  }

  function direcciones_pdf($arg_textoabuscar){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // busca los paises en la base de datos

    $direcciones = buscar_direcciones($arg_textoabuscar);

    $html2pdf = new Html2Pdf('P','A4','es','true',"UTF-8'");   // crea un nuevo objeto
    
    ob_start();   // creo un buffer en memoria que va a recoger todo lo que se deberia mostrar en pantalla
    
    include ($absolute_include."vistas/direcciones/imprimir.php"); 

    include ($absolute_include."vistas/plantillas/footer_pdf.php"); 
 
    $mihtml=ob_get_clean();   // guardo todo lo de buffer en una variable  
    ob_end_clean();

    $html2pdf->writeHTML($mihtml);
    $html2pdf->output('direccion.pdf');

    
  }



?>
