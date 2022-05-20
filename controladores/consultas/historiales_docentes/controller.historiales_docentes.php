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

  include ($absolute_include."administracion/sesion.php");

  include ($absolute_include."clases/class.conexion.php");

  include ($absolute_include."modelos/historiales_docentes/model.historiales_docentes.php");

  //verifica si se llamo a una accion determinada en el controlador
  $accion="";

  if (isset($_REQUEST['accion'])) {   // si existe una variable tipo REQUEST que llama a una accion / funcion

    $accion=$_REQUEST['accion'];
  }
 
  // define la accion a realizar
  
  if ($accion == "" OR $accion=="index" ){
    archivos_index();

  }elseif($accion == 'editar'){
    $token=$_POST['token'];

    if($_SESSION['token'] == $token){
      editar_historial($_POST);
    }else{
      archivos_index();
    }

  }elseif($accion == "guardar_modificacion"){
    actualizar_carrera($_POST);
  }elseif ( $accion == "eliminar"){
    // verifico que el pedido sea desde un formulario del sistema
    $token=$_POST['token'];
    if($_SESSION['token'] == $token){
      materias_eliminar($_POST);
    }

  }elseif ( $accion == "ir_historial"){
    // verifico que el pedido sea desde un formulario del sistema
    $token=$_POST['token'];
    if($_SESSION['token'] == $token){
      ir_historial($_POST);
    }
  }

  function archivos_index(){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];
    $resultado_carreras = buscar_historiales_docentes();
       
    // llama a la vista de index de archivos

    include ($absolute_include."vistas/consultas/historiales_docentes/historiales_docentes.php"); 

  }

  function ir_historial($arg_POST){
    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    $resultado_carreras = buscar_historiales_docentes2($arg_POST['docente_id']);
    //var_dump($resultado_carreras);
    include ($absolute_include."vistas/consultas/historiales_docentes/historiales_docentes2.php"); 
  }

  function editar_historial($arg_POST){
    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    $resultadoBusquedaCarrera = buscar_historiales_docentes($arg_POST['historialalumno_id']);
    //var_dump($resultadoBusquedaCarrera);
    include ($absolute_include."vistas/consultas/historiales_docentes/editar.php"); 
  }

  function actualizar_carrera($arg_POST){
    var_dump($_POST);
    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    $actualizarCarrera = modificar_datos($arg_POST['historialdocente_id'], $arg_POST['historial_docente']);
    
    if ($actualizarCarrera) {
      echo '<script language = javascript>alert("Se ha modificado el historial correctamente")
        self.location =  "'.$carpeta_trabajo.'/controladores/consultas/historiales_docentes/controller.historiales_docentes.php ?>"
      </script>';
    }else{
      echo '<script language = javascript>alert("Error al modificar el historial, intente nuevamente")
        self.location =  "'.$carpeta_trabajo.'/controladores/consultas/historiales_docentes/controller.historiales_docentes.php ?>"
      </script>';
    }
  }

  function materias_eliminar($arg_POST){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    $eliminarMaterias = eliminar_materia($_POST['eliminar']);
    
    if ($eliminarMaterias) {
      echo '<script language = javascript>alert("Se ha eliminado el historial correctamente")
        self.location =  "'.$carpeta_trabajo.'/controladores/consultas/historiales_docentes/controller.historiales_docentes.php ?>"
      </script>';
    }else{
      echo '<script language = javascript>alert("Error al eliminar el historial, intente nuevamente")
        self.location =  "'.$carpeta_trabajo.'/controladores/consultas/historiales_docentes/controller.historiales_docentes.php ?>"
      </script>';
    }
  }
?>
