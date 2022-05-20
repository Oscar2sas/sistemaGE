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

  include ($absolute_include."modelos/historiales_alumnos/model.historiales_alumnos.php");

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

  }elseif ( $accion == "ver_notas"){
    // verifico que el pedido sea desde un formulario del sistema
    $token=$_POST['token'];
    if($_SESSION['token'] == $token){
      ver_notas_alumno($_POST);
    }
  }elseif ( $accion == "ir_historial"){
    // verifico que el pedido sea desde un formulario del sistema
    $token=$_POST['token'];
    if($_SESSION['token'] == $token){
      ir_historial($_POST);
    }
  }elseif ( $accion == "ir_datos_tutor1"){
    // verifico que el pedido sea desde un formulario del sistema
    $token=$_POST['token'];
    if($_SESSION['token'] == $token){
      ir_datos_tutor1($_POST);
    }
  }elseif ( $accion == "ir_datos_tutor2"){
    // verifico que el pedido sea desde un formulario del sistema
    $token=$_POST['token'];
    if($_SESSION['token'] == $token){
      ir_datos_tutor2($_POST);
    }
  }elseif ( $accion == "ir_datos_tutor3"){
    // verifico que el pedido sea desde un formulario del sistema
    $token=$_POST['token'];
    if($_SESSION['token'] == $token){
      ir_datos_tutor3($_POST);
    }
  }

  function archivos_index(){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];
    $resultado_carreras = buscar_historiales_alumnos();
       
    // llama a la vista de index de archivos
    include ($absolute_include."vistas/consultas/historiales_alumnos/historiales_alumnos.php"); 

  }

  function ir_historial($arg_POST){
    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    $resultado_carreras = buscar_historiales_alumnos2($arg_POST['alumno_id']);
    //var_dump($resultadoBusquedaCarrera);
    include ($absolute_include."vistas/consultas/historiales_alumnos/historiales_alumnos2.php"); 
  }

  function ir_datos_tutor1($arg_POST){
    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    $resultado_carreras = buscar_datos_tutores1($arg_POST['rela_persona_id_tutor1']);
    //var_dump($resultadoBusquedaCarrera);
    include ($absolute_include."vistas/consultas/historiales_alumnos/tutores.php"); 
  }

  function ir_datos_tutor2($arg_POST){
    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    $resultado_carreras = buscar_datos_tutores2($arg_POST['rela_persona_id_tutor2']);
    //var_dump($resultadoBusquedaCarrera);
    include ($absolute_include."vistas/consultas/historiales_alumnos/tutores.php"); 
  }

  function ir_datos_tutor3($arg_POST){
    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    $resultado_carreras = buscar_datos_tutores3($arg_POST['rela_persona_id_tutor3']);
    //var_dump($resultadoBusquedaCarrera);
    include ($absolute_include."vistas/consultas/historiales_alumnos/tutores.php"); 
  }

  function editar_historial($arg_POST){
    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    $resultadoBusquedaCarrera = buscar_historiales_alumnos($arg_POST['historialalumno_id']);
    //var_dump($resultadoBusquedaCarrera);
    include ($absolute_include."vistas/consultas/historiales_alumnos/editar.php"); 
  }

  function actualizar_carrera($arg_POST){
    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    $actualizarCarrera = modificar_datos($arg_POST['historialalumno_id'], $arg_POST['historial_alumno']);
    
    if ($actualizarCarrera) {
      echo '<script language = javascript>alert("Se ha modificado el historial correctamente")
        self.location =  "'.$carpeta_trabajo.'/controladores/consultas/historiales_alumnos/controller.historiales_alumnos.php ?>"
      </script>';
    }else{
      echo '<script language = javascript>alert("Error al modificar el historial, intente nuevamente")
        self.location =  "'.$carpeta_trabajo.'/controladores/consultas/historiales_alumnos/controller.historiales_alumnos.php ?>"
      </script>';
    }

  }

  function materias_eliminar($arg_POST){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    $eliminarMaterias = eliminar_materia($_POST['eliminar']);

    if ($eliminarMaterias) {
      echo '<script language = javascript>alert("Se ha eliminado el historial correctamente")
        self.location =  "'.$carpeta_trabajo.'/controladores/consultas/historiales_alumnos/controller.historiales_alumnos.php ?>"
      </script>';
    }else{
      echo '<script language = javascript>alert("Error al eliminar el historial, intente nuevamente")
        self.location =  "'.$carpeta_trabajo.'/controladores/consultas/historiales_alumnos/controller.historiales_alumnos.php ?>"
      </script>';
    }
    
  }

  function ver_notas_alumno($arg_POST){
    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    $resultado_carreras = buscar_historiales_notas($arg_POST['alumno_id']);
    //var_dump($resultadoBusquedaCarrera);
    include ($absolute_include."vistas/consultas/historiales_alumnos/notas.php"); 
  }

?>