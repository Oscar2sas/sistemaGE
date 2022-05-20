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
  include ($absolute_include."modelos/calendarios/model.calendario.php");   // se incluye el modelo de calendario
  include ($absolute_include."modelos/anoLectivos/model.anoslectivos.php");   // se incluye el modelo de anos lectivos

  //verifica si se llamo a una accion determinada en el controlador
  $accion="";
// verifica si esta especificando un filtro
  $textoabuscar="";
  if (isset($_REQUEST['accion'])) {   // si existe una variable tipo REQUEST que llama a una accion / funcion

    $accion=$_REQUEST['accion'];

  }

// Se valida si hay alguna accion enviada desde el front-end 
// en caso de que haya enviado la accion de tipo index
// o la accion este vacia
// se mostrara el listado de los anos lectivos 

  if ( $accion == "" OR $accion=="index" )  {
  	

  	// Se llama a la funcion para mostrara el listado de anos lectivos
    calendario_index();

  }elseif ($accion == "agregar") { //Mostrar vista de agregar nuevo ano lectivo

  	agregar_calendario();

  }elseif ($accion == "insertar") { //Guardar nuevo ano lectivo

  	if($_SESSION['token'] == $_POST['token']){
  		// guardar_fecha_calendario($_POST);
      guardar_fecha_calendario($_POST);
    }else{
      calendario_index();
    } 
  }elseif ($accion == "editar") {//Mostrar Vista de modificacion de anos lectivos

  	$calendario_id=$_REQUEST['calendario_id'];
  	modificar_fecha_calendario($calendario_id);

  }elseif ($accion == "modificar") { //Funcion para guardar las modificaciones
  	if($_SESSION['token'] == $_POST['token']){

  		guardar_modificacion_fecha_calendario($_POST);
  	}else{
  		calendario_index();
  	}
  }elseif ($accion == "eliminar") {

    $calendario_id=$_REQUEST['calendario_id'];

    if($_SESSION['token'] == $_POST['token']){

      borrar_fecha_calendario($calendario_id);
    }else{
      calendario_index();
    }
  }elseif ($accion == "verificar_fecha_calendario") {
    $descripcionFechaCalendario = $_POST['descFechaCalendario'];
  		// LLamo a mi funcion para verificar si existe alguna fecha igual a la enviada

    // echo json_encode($descripcionFechaCalendario);

    $resultFechaCalendario = verificar_Fecha_Calendario($descripcionFechaCalendario);

  }
//   }else if($accion == 'verificar_estado_ano_lectivo'){

// 	$idEstadoAnoLectivo = $_POST['idEstadoAnoLectivo'];

// 	// echo $idEstadoAnoLectivo;

// 	$resultEstadoAnoLectivo = verificarEstadoAnoLectivo($idEstadoAnoLectivo);
// 	echo json_encode($resultEstadoAnoLectivo);
//   }

//  // ===============================================================================
//  // FUNCION QUE INTERACTUAN CON EL MODELO
//  // ===============================================================================

// // Funcion para que el controlador liste los registro de calendario
  function calendario_index(){

  	$absolute_include = $GLOBALS['absolute_include'];
  	$carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

  	$result_calendario = mostrar_calendario();
  	// mostrar_anos_lectivos();
  	include $absolute_include."vistas/calendarios/index.php";
  }
// // Funcion para que el controlador muestre vista de agregar nueva fecha del calendario
  function agregar_calendario(){

  	$absolute_include = $GLOBALS['absolute_include'];
  	$carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    $ano_Lectivo_Activo = buscar_Ano_Lectivo_Activo();

    $fechaHoy = date('Y-m-d');
    include $absolute_include."vistas/calendarios/agregarFechaCalendario.php";
  }
// // Funcion para que el controlador guarde el nuevo ano lectivo
  function guardar_fecha_calendario($arg_POST){
  	$absolute_include = $GLOBALS['absolute_include'];
  	$carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

  	// Funcion para insertar en la bd la informacion sobre el nuevo ano lectivo
  	$ultimo_id_fecha_calendario = insertar_nueva_fecha_calendario($arg_POST);
// echo $ultimo_id_fecha_calendario;
   	// llamo a la funcion en el modelo para grabar el log

  	$cdescripcion_log = "Se inserto en la base una nueva fecha calendario :".$arg_POST['fechaCalendario']. " con el ID: $ultimo_id_fecha_calendario";
  	// echo $cdescripcion_log;
  	insertar_log( $cdescripcion_log);

    // llama al controlador de paises para ir al inicio

  	mensaje_alerta("Se a agregado la nueva fecha calendario correctamente!");
  }
  
// Funcion para que el controlador muestre la vista de modificar ano lectivo,
// Pasando el id de la fecha calendario seleccionado
  function modificar_fecha_calendario($argID){
  	$absolute_include = $GLOBALS['absolute_include'];
  	$carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

  	$result_fecha_calendario = buscar_fecha_calendario($argID);

  	include $absolute_include."vistas/calendarios/modificarFechaCalendario.php";

  }

// Funcion para que el controlador guarde las modificaciones del ano lectivo
  function guardar_modificacion_fecha_calendario($argPOST){
  	$absolute_include = $GLOBALS['absolute_include'];
  	$carpeta_trabajo = $GLOBALS['carpeta_trabajo'];


  	$absolute_include = $GLOBALS['absolute_include'];
  	$carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

  	actualizar_fecha_calendario($argPOST);

  	// header("Location: ".$carpeta_trabajo."/controladores/anolectivos/controller.anolectivos.php");
  	mensaje_alerta("Se a modificado la fecha calendario correctamente!");


  }
  
  function borrar_fecha_calendario($argID){
    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];
    eliminar_fecha_calendario($argID);
    header("Location: ".$carpeta_trabajo."/controladores/calendarios/controller.calendarios.php");

    // mensaje_alerta("Se a eliminado correctamente la fecha del calendario");
  }

  function verificar_Fecha_Calendario($arg_Fecha_Calendario){

  	$resultFechaCalendario =  buscar_Descripcion_Fecha_Calendario($arg_Fecha_Calendario);
    echo json_encode($resultFechaCalendario);
  }
//   function verificarEstadoAnoLectivo($arg_Id_Ano_Lectivo){

// 	return buscar_Estado_Ano_Lectivo_Id($arg_Id_Ano_Lectivo);
//   }

  function mensaje_alerta($arg_mensaje){
  	$absolute_include = $GLOBALS['absolute_include'];
  	$carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

  	echo"<script type=\"text/javascript\">
   alert(\"$arg_mensaje\"); 
   self.location = \"$carpeta_trabajo/controladores/calendarios/controller.calendarios.php\";
   </script>"; 
 }