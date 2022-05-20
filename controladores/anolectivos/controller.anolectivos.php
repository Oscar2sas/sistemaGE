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
  include ($absolute_include."modelos/anoLectivos/model.anoslectivos.php");   // se incluye el modelo de ciclos lectivos

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
  	
  	// if (isset( $_REQUEST['textoabuscar'] )) { 
  	// 	$textoabuscar=$_REQUEST['textoabuscar'];
  	// }  
  	// Se llama a la funcion para mostrara el listado de anos lectivos
  	ano_lectivo_index();

  }elseif ($accion == "agregar") { //Mostrar vista de agregar nuevo ano lectivo

  	agregar_ano_lectivo();

  }elseif ($accion == "insertar") { //Guardar nuevo ano lectivo

  	if($_SESSION['token'] == $_POST['token']){
  		guardar_nuevo_ano_lectivo($_POST);
  	}else{
  		ano_lectivo_index();
  	} 

  }elseif ($accion == "editar") {//Mostrar Vista de modificacion de anos lectivos
  	$anolectivo_id=$_REQUEST['anolectivo_id'];

  	modificar_ano_lectivo($anolectivo_id);  	

  }elseif ($accion == "modificar") { //Funcion para guardar las modificaciones
  	if($_SESSION['token'] == $_POST['token']){

  		guardar_modificacion_ano_lectivo($_POST);
  	}else{
  		ano_lectivo_index();
  	}
  }elseif ($accion == "verificar_ano_lectivo") {
  		$descripcionAnoLectivo = $_POST['descAnoLectivo'];
  		// echo json_encode();
  		// LLamo a mi funcion para verificar si existe alguna descripcion igual a la enviada

  		$resultAnoLectivo = verificar_Descripcion_Ano_Lectivo($descripcionAnoLectivo);

  		echo json_encode($resultAnoLectivo);
  }else if($accion == "verificar_estado_ano_lectivo"){

	$idEstadoAnoLectivo = $_POST['idEstadoAnoLectivo'];

	// echo $idEstadoAnoLectivo;

	$resultEstadoAnoLectivo = verificarEstadoAnoLectivo($idEstadoAnoLectivo);
	echo json_encode($resultEstadoAnoLectivo);
  }elseif ($accion == "obtener_Ano_Lectivo_Activo") {

    obtener_Ano_Lectivo_Activo();
  }
    # code$accion == 'verificar_estado_ano_lectivo'  }

 // ===============================================================================
 // FUNCION QUE INTERACTUAN CON EL MODELO
 // ===============================================================================

// Funcion para que el controlador liste los anos lectivos
  function ano_lectivo_index(){

  	$absolute_include = $GLOBALS['absolute_include'];
  	$carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

  	$result_anos_lectivos = mostrar_anos_lectivos();
  	// mostrar_anos_lectivos();

  	include $absolute_include."vistas/anolectivos/index.php";
  }
// Funcion para que el controlador muestre vista de agregar nuevo ano lectivo
  function agregar_ano_lectivo(){
  	
  	$absolute_include = $GLOBALS['absolute_include'];
  	$carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

  	include $absolute_include."vistas/anolectivos/agregarAnoLectivo.php";
  }
// Funcion para que el controlador guarde el nuevo ano lectivo
  function guardar_nuevo_ano_lectivo($arg_POST){
  	$absolute_include = $GLOBALS['absolute_include'];
  	$carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

  	// Funcion para insertar en la bd la informacion sobre el nuevo ano lectivo
  	$ultimo_id_ano_lectivo = insertar_nuevo_ano_lectivo($arg_POST);

   	// llamo a la funcion en el modelo para grabar el log

  	$cdescripcion_log = "Se inserto en la base el nuevo año lectivo :".$arg_POST['descripcionAnoLectivo']. " con el ID: $ultimo_id_ano_lectivo";
  	// echo $cdescripcion_log;
  	insertar_log( $cdescripcion_log);

    // llama al controlador de paises para ir al inicio
  	// header("Location: ".$carpeta_trabajo."/controladores/anolectivos/controller.anolectivos.php");

  	mensaje_alerta("Se a agregado el nuevo año lectivo correctamente!");
  }
  
// Funcion para que el controlador muestre la vista de modificar ano lectivo,
// Pasando el id del ano lectivo seleccionado
  function modificar_ano_lectivo($argID){
  	$absolute_include = $GLOBALS['absolute_include'];
  	$carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

  	$result_ano_lectivo = buscar_ano_lectivo($argID);

  	include $absolute_include."vistas/anolectivos/modificarAnoLectivo.php";

  }

// Funcion para que el controlador guarde las modificaciones del ano lectivo
  function guardar_modificacion_ano_lectivo($argPOST){
  	$absolute_include = $GLOBALS['absolute_include'];
  	$carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

  	
  	$absolute_include = $GLOBALS['absolute_include'];
  	$carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

  	actualizar_ano_lectivo($argPOST);
  	
  	// header("Location: ".$carpeta_trabajo."/controladores/anolectivos/controller.anolectivos.php");
  	mensaje_alerta("Se a modificado el año lectivo correctamente!");


  }

  function verificar_Descripcion_Ano_Lectivo($arg_Descripcion_Ano_Lectivo){
  	
  	return buscar_Descripcion_Ano_Lectivo($arg_Descripcion_Ano_Lectivo);

  }
  function verificarEstadoAnoLectivo($arg_Id_Ano_Lectivo){

	return buscar_Estado_Ano_Lectivo_Id($arg_Id_Ano_Lectivo);
  }

  // function obtener_Ano_Lectivo_Activo(){
    
  //   $resultAnoLectivoActivo = buscar_Ano_Lectivo_Activo();

  //   echo json_encode($resultAnoLectivoActivo);
  // }
  
  function mensaje_alerta($arg_mensaje){
  	$absolute_include = $GLOBALS['absolute_include'];
  	$carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

  	echo"<script type=\"text/javascript\">
  			alert(\"$arg_mensaje\"); 
  			self.location = \"$carpeta_trabajo/controladores/anolectivos/controller.anolectivos.php\";
  		</script>"; 
  }