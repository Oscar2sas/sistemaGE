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

  include ($absolute_include."modelos/provincias/model.provincias.php");   // para manejar los paises

  include ($absolute_include."modelos/paises/model.paises.php"); 



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

    provincias_index($textoabuscar);
  } 
  elseif ( $accion == "crear")  
  {
    provincias_crear();
  }
  elseif ( $accion == "editar")  
  {

    if (isset( $_REQUEST['provincia_id'] )) { 
      $provincia_id=$_REQUEST['provincia_id'];
    }  

    provincias_editar($provincia_id);
  }
  elseif ( $accion == "mostrar")  
  {

    if (isset( $_REQUEST['provincia_id'] )) { 
      $provincia_id=$_REQUEST['provincia_id'];
    }  

    provincias_mostrar($provincia_id);
  }
  elseif ( $accion == "insertar")  
  {
    // verifico que el pedido sea desde un formulario del sistema
    $token=$_POST['token'];

    if($_SESSION['token'] == $token){
      provincias_insertar($_POST);
    } 
    else {
      provincias_index($textoabuscar);
    } 
  }
  elseif ( $accion == "actualizar")  
  {
    // verifico que el pedido sea desde un formulario del sistema
    $token=$_POST['token'];

    if($_SESSION['token'] == $token){
      provincias_actualizar($_POST);
    } 
    else {
      provincias_index($textoabuscar);
    } 
  }
  elseif ( $accion == "eliminar")  
  {
    // verifico que el pedido sea desde un formulario del sistema
    $token=$_POST['token'];

    if($_SESSION['token'] == $token){
      provincias_eliminar($_POST);
    } 
    else {
      provincias_index($textoabuscar);
    } 
  }
  elseif ( $accion == "imprimir")  
  {
    // verifico que el pedido sea desde un formulario del sistema
    $token=$_POST['token'];

    if($_SESSION['token'] == $token){
      provincias_imprimir($textoabuscar);
    } 
    else {
      provincias_index($textoabuscar);
    } 
  }
  elseif ( $accion == "pdf")  
  {
    // verifico que el pedido sea desde un formulario del sistema
    $token=$_POST['token'];

    if($_SESSION['token'] == $token){
      provincias_pdf($textoabuscar);
    } 
    else {
      provincias_index($textoabuscar);
    } 
  }

  
  function provincias_index($arg_textoabuscar){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // busca los paises en la base de datos

    $provincias = buscar_provincias($arg_textoabuscar);

    // llama a la vista de index de paises

    include ($absolute_include."vistas/provincias/index.php"); 

  }

  function provincias_crear(){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    //busca los paises de la base de datos 
    $paises = buscar_paises("");
    // llama a la vista para crear paises


    include ($absolute_include."vistas/provincias/crear.php"); 

  }


  function provincias_editar($arg_provincia_id){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // busca el pais en la base de datos

    $provincia = buscar_una_provincia($arg_provincia_id);

    // llama a la vista para editar paises

    include ($absolute_include."vistas/provincias/editar.php"); 

  }


  function provincias_mostrar($arg_provincia_id){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // busca el pais en la base de datos

    $provincia = buscar_una_provincia($arg_provincia_id);
    // llama a la vista para editar paises

    include ($absolute_include."vistas/provincias/mostrar.php"); 

  }


  function provincias_insertar($arg_POST){


    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // aqui se pueden hacer validaciones de los datos que vienen
    // del formulario y devolver un error 

    $cnombre_provincia = strtoupper($arg_POST['cnombre_provincia']);
    $rela_pais_id = strtoupper($arg_POST['rela_pais_id']);

    
    // llamo a la funcion en el modelo para grabar un pais
    $ultimo_provincia_id=insertar_provincia($cnombre_provincia, $rela_pais_id);

    // llamo a la funcion en el modelo para grabar el log

    $cdescripcion_log =" Creacion de Provincia :".$cnombre_provincia." con ID: $ultimo_provincia_id";
    insertar_log( $cdescripcion_log);



    // llama al controlador de paises para ir al inicio
    header("Location: ".$carpeta_trabajo."/controladores/provincias/controller.provincias.php");

   }

  function provincias_actualizar($arg_POST){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // aqui se pueden hacer validaciones de los datos que vienen
    // del formulario y devolver un error 

    $provincia_id=$arg_POST['provincia_id'];
    $cnombre_provincia = strtoupper($arg_POST['cnombre_provincia']);

    
    // llamo a la funcion en el modelo para grabar un pais
    actualizar_provincia($provincia_id,$cnombre_provincia);

    // llamo a la funcion en el modelo para grabar el log

    $cdescripcion_log =" Modificacion de Provincia - Nuevo nombre : ".$cnombre_provincia." con ID: $provincia_id";
    insertar_log( $cdescripcion_log);



    // llama al controlador de paises para ir al inicio
    header("Location: ".$carpeta_trabajo."/controladores/provincias/controller.provincias.php");

    
  }

  function provincias_eliminar($arg_POST){
    

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // aqui se pueden hacer validaciones de los datos que vienen
    // del formulario y devolver un error 

    $provincia_id=$arg_POST['provincia_id'];
   
    
    // llamo a la funcion en el modelo para grabar un pais
    eliminar_provincia($provincia_id);

    // llamo a la funcion en el modelo para grabar el log

    $cdescripcion_log =" Elimino la Provincia con ID: $provincia_id";
    insertar_log( $cdescripcion_log);


    // llama al controlador de paises para ir al inicio
    header("Location: ".$carpeta_trabajo."/controladores/provincias/controller.provincias.php");

    
  }
  
  function provincias_imprimir($arg_textoabuscar){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // busca los paises en la base de datos

    $provincias = buscar_provincias($arg_textoabuscar);

    // llama a la vista de index de paises

    include ($absolute_include."vistas/provincias/imprimir.php"); 

    include ($absolute_include."vistas/plantillas/footer_imprimir_provincias.php"); 
 

  }

  function provincias_pdf($arg_textoabuscar){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // busca los paises en la base de datos

    $provincias = buscar_provincias($arg_textoabuscar);

    $html2pdf = new Html2Pdf('P','A4','es','true',"UTF-8'");   // crea un nuevo objeto
    
    ob_start();   // creo un buffer en memoria que va a recoger todo lo que se deberia mostrar en pantalla
    
    include ($absolute_include."vistas/provincias/imprimir.php"); 

    include ($absolute_include."vistas/plantillas/footer_pdf.php"); 
 
    $mihtml=ob_get_clean();   // guardo todo lo de buffer en una variable  
    ob_end_clean();

    $html2pdf->writeHTML($mihtml);
    $html2pdf->output('provincia.pdf');

    
  }



?>
