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

  include ($absolute_include."modelos/carreras/model.carrera.php");

  //verifica si se llamo a una accion determinada en el controlador
  $accion="";

  if (isset($_REQUEST['accion'])) {   // si existe una variable tipo REQUEST que llama a una accion / funcion

    $accion=$_REQUEST['accion'];
  }
   

 
  // define la accion a realizar
  
  if ($accion == "" OR $accion=="index" ){
    carrera_index();

  }elseif($accion == 'editar'){
    $token=$_POST['token'];

    if($_SESSION['token'] == $token){
      editar_carrera($_POST);
    }else{
      carrera_index();
    }

  }elseif($accion == "guardar_modificacion_carrera"){
    actualizar_carrera($_POST);
  }elseif($accion == "nueva_carrera"){
    //var_dump($_POST);
    agregar_carreras();
  }elseif($accion == "guardar_carrera_nueva"){
    guardar_carrera($_POST);
  }




  function carrera_index(){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];
    $resultado_carreras = buscar_carreras();

       
    // llama a la vista de index de archivos

    include ($absolute_include."vistas/carreras/index.php"); 

  }


  function editar_carrera($arg_POST){
    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    $resultadoBusquedaCarrera = carrera_buscar($arg_POST['carrera_id']);
    //var_dump($resultadoBusquedaCarrera);
    include ($absolute_include."vistas/carreras/editar.php"); 
  }

  function actualizar_carrera($arg_POST){
    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    if ($arg_POST['semestre'] == 3) {
      $semestre = "TRIMESTRE";
    }else{
      $semestre = "CUATRIMESTRE";
    }

    $actualizarCarrera = modificar_datos_carrera($arg_POST['carrera_id'], $arg_POST['cdescripcion_carrera'], $arg_POST['semestre'], $semestre);
    /*carrera_index
    cdescripcion_carrera
    netapastemporales_carrera
    cdescripcionetapastemporal_carrera*/
    if ($actualizarCarrera) {
      echo '<script language="javascript">alert("DATOS GUARDADOS CORRECTAMENTE");window.location.href="http://192.168.2.103/htdocs/controladores/carreras/controller.carreras.php"</script>';
    }else{
      echo '<script language="javascript">alert("NO SE HA PODIDO GUARDAR LOS DATOS");window.location.href="http://192.168.2.103/htdocs/controladores/carreras/controller.carreras.php"</script>';
    }
  }



  function agregar_carreras(){
    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];
    
    include ($absolute_include."vistas/carreras/nueva_vista.php"); 
  }

  function guardar_carrera($arg_POST){
    if ($arg_POST['semestrals'] == 3) {
      $semestres = "TRIMESTRE";
    }else{
      $semestres = "CUATRIMESTRE";
    }
    $resultado_guardado_carrera = crear_carreras($arg_POST, $semestres);

    if ($resultado_guardado_carrera) {
      echo '<script language="javascript">alert("DATOS GUARDADOS CORRECTAMENTE");window.location.href="http://192.168.2.103/htdocs/controladores/carreras/controller.carreras.php"</script>';
    }else{
      echo '<script language="javascript">alert("NO SE HA PODIDO GUARDAR LOS DATOS");window.location.href="http://192.168.2.103/htdocs/controladores/carreras/controller.carreras.php"</script>';
    }
  }
?>