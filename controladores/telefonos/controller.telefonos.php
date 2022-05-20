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

  include ($absolute_include."modelos/telefonos/model.telefonos.php");   // para manejar los paises

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

    telefonos_index($textoabuscar);
  } 
  elseif ( $accion == "crear")  
  {
    telefonos_crear();
  }
  elseif ( $accion == "editar")  
  {
    
    if (isset( $_REQUEST['telefono_id'] )) { 
      $telefono_id=$_REQUEST['telefono_id'];
    }  

    telefonos_editar($telefono_id);
  }
  elseif ( $accion == "mostrar")  
  {

    if (isset( $_REQUEST['telefono_id'] )) { 
      $telefono_id=$_REQUEST['telefono_id'];
      
    }  

    telefonos_mostrar($telefono_id);
  }
  elseif ( $accion == "insertar")  
  {
    // verifico que el pedido sea desde un formulario del sistema
    $token=$_POST['token'];

    if($_SESSION['token'] == $token){
      telefonos_insertar($_POST);
    } 
    else {
      telefonos_index($textoabuscar);
    } 
  }
  elseif ( $accion == "actualizar")  
  {
    // verifico que el pedido sea desde un formulario del sistema
    $token=$_POST['token'];

    if($_SESSION['token'] == $token){
      telefonos_actualizar($_POST);
    } 
    else {
      telefonos_index($textoabuscar);
    } 
  }
  elseif ( $accion == "eliminar")  
  {
    // verifico que el pedido sea desde un formulario del sistema
    $token=$_POST['token'];

    if($_SESSION['token'] == $token){
      telefonos_eliminar($_POST);
    } 
    else {
      telefonos_index($textoabuscar);
    } 
  }
  elseif ( $accion == "imprimir")  
  {
    // verifico que el pedido sea desde un formulario del sistema
    $token=$_POST['token'];

    if($_SESSION['token'] == $token){
      telefonos_imprimir($textoabuscar);
    } 
    else {
      telefonos_index($textoabuscar);
    } 
  }
  elseif ( $accion == "pdf")  
  {
    // verifico que el pedido sea desde un formulario del sistema
    $token=$_POST['token'];

    if($_SESSION['token'] == $token){
      telefonos_pdf($textoabuscar);
    } 
    else {
      telefonos_index($textoabuscar);
    } 
  }

  
  function telefonos_index($arg_textoabuscar){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // busca los paises en la base de datos

    $telefonos = buscar_telefonos($arg_textoabuscar);

    // llama a la vista de index de paises

    include ($absolute_include."vistas/telefonos/index.php"); 

  }

  function telefonos_crear(){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    //busca los paises de la base de datos 
    $personas = buscar_persona("");
    // llama a la vista para crear paises


    include ($absolute_include."vistas/telefonos/crear.php"); 

  }


  function telefonos_editar($arg_telefono_id){
    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // busca el pais en la base de datos

    $telefono = buscar_un_telefono($arg_telefono_id);
    $personas = buscar_persona("");

    // llama a la vista para editar paises

    include ($absolute_include."vistas/telefonos/editar.php"); 

  }


  function telefonos_mostrar($arg_telefono_id){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // busca el pais en la base de datos

    $telefono = buscar_un_telefono($arg_telefono_id);
    // llama a la vista para editar paises

    include ($absolute_include."vistas/telefonos/mostrar.php"); 

  }


  function telefonos_insertar($arg_POST){


    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // aqui se pueden hacer validaciones de los datos que vienen
    // del formulario y devolver un error 

    $cnumero_telefono = strtoupper($arg_POST['cnumero_telefono']);
    $ntipo_telefono = strtoupper($arg_POST['ntipo_telefono']);
    $rela_persona_id = strtoupper($arg_POST['rela_persona_id']);

    
    // llamo a la funcion en el modelo para grabar un pais
    $ultimo_telefono_id=insertar_telefono($cnumero_telefono, $ntipo_telefono, $rela_persona_id);

    // llamo a la funcion en el modelo para grabar el log

    $cdescripcion_log =" Creacion de telefono :".$cnumero_telefono." con ID: $ultimo_telefono_id";
    insertar_log( $cdescripcion_log);



    // llama al controlador de paises para ir al inicio
    header("Location: ".$carpeta_trabajo."/controladores/telefonos/controller.telefonos.php");

   }

  function telefonos_actualizar($arg_POST){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // aqui se pueden hacer validaciones de los datos que vienen
    // del formulario y devolver un error 

    $telefono_id=$arg_POST['telefono_id'];
    $cnumero_telefono = strtoupper($arg_POST['cnumero_telefono']);
    $ntipo_telefono = strtoupper($arg_POST['ntipo_telefono']);
    $rela_persona_id = strtoupper($arg_POST['rela_persona_id']);

    // llamo a la funcion en el modelo para grabar un pais
    actualizar_telefono($telefono_id,$cnumero_telefono, $ntipo_telefono,$rela_persona_id);

    // llamo a la funcion en el modelo para grabar el log

    $cdescripcion_log =" Modificacion de telefono - Nuevo nombre : ".$cnumero_telefono." con ID: $telefono_id";
    insertar_log( $cdescripcion_log);



    // llama al controlador de paises para ir al inicio
    header("Location: ".$carpeta_trabajo."/controladores/telefonos/controller.telefonos.php");

    
  }

  function telefonos_eliminar($arg_POST){
    

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // aqui se pueden hacer validaciones de los datos que vienen
    // del formulario y devolver un error 

    $telefono_id=$arg_POST['telefono_id'];
    $cnumero_telefono = strtoupper($arg_POST['cnumero_telefono']);
    $ntipo_telefono = strtoupper($arg_POST['ntipo_telefono']);
    $rela_persona_id = strtoupper($arg_POST['rela_persona_id']);
   
    
    // llamo a la funcion en el modelo para grabar un pais
    eliminar_telefono($telefono_id, $cnumero_telefono, $ntipo_telefono, $rela_persona_id);

    // llamo a la funcion en el modelo para grabar el log

    $cdescripcion_log =" Elimino la telefono con ID: $telefono_id";
    insertar_log( $cdescripcion_log);


    // llama al controlador de paises para ir al inicio
    header("Location: ".$carpeta_trabajo."/controladores/telefonos/controller.telefonos.php");

    
  }
  
  function telefonos_imprimir($arg_textoabuscar){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // busca los paises en la base de datos

    $telefonos = buscar_telefonos($arg_textoabuscar);

    // llama a la vista de index de paises

    include ($absolute_include."vistas/telefonos/imprimir.php"); 

    include ($absolute_include."vistas/plantillas/footer_imprimir_telefonos.php"); 
 

  }

  function telefonos_pdf($arg_textoabuscar){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // busca los paises en la base de datos

    $telefonos = buscar_telefonos($arg_textoabuscar);

    $html2pdf = new Html2Pdf('P','A4','es','true',"UTF-8'");   // crea un nuevo objeto
    
    ob_start();   // creo un buffer en memoria que va a recoger todo lo que se deberia mostrar en pantalla
    
    include ($absolute_include."vistas/telefonos/imprimir.php"); 

    include ($absolute_include."vistas/plantillas/footer_pdf.php"); 
 
    $mihtml=ob_get_clean();   // guardo todo lo de buffer en una variable  
    ob_end_clean();

    $html2pdf->writeHTML($mihtml);
    $html2pdf->output('telefono.pdf');

    
  }



?>
