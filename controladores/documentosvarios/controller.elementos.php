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

  include ($absolute_include."modelos/documentosvarios/model.elementos.php");

  //verifica si se llamo a una accion determinada en el controlador
  $accion="";

  if (isset($_REQUEST['accion'])) {   // si existe una variable tipo REQUEST que llama a una accion / funcion

    $accion=$_REQUEST['accion'];
  }
   
  
  // define la accion a realizar

  if ($accion == "" OR $accion=="index" )  
  {
    archivos_index();
  }elseif($accion == 'editar'){
    $token=$_POST['token'];

    if($_SESSION['token'] == $token){
      editar_elemento($_POST);
    }else{
      archivos_index();
    }

  }elseif($accion == "guardar_modificacion"){
    actualizar_carrera($_POST);
  }elseif ( $accion == "eliminar"){
    // verifico que el pedido sea desde un formulario del sistema
    $token=$_POST['token'];
    if($_SESSION['token'] == $token){
      elemento_eliminar($_POST);
    }
  }

  function archivos_index(){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];
    $result = MostrarElementos();
       
    // llama a la vista de index de archivos

    include ($absolute_include."vistas/archivos/elementos.php"); 

  }


  function elemento_eliminar($arg_POST){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    $eliminarElemento = eliminar_Elemento($_POST['eliminar']);

    if ($eliminarElemento) {
      echo '<script language = javascript>alert("El documento se ha eliminado correctamente")
        self.location =  "'.$carpeta_trabajo.'/controladores/documentosvarios/controller.elementos.php ?>"
      </script>';
    }else{
      echo '<script language = javascript>alert("Error al eliminar el documento, intente nuevamente")
        self.location =  "'.$carpeta_trabajo.'/controladores/documentosvarios/controller.elementos.php ?>"
      </script>';
    }
    
  }

  function editar_elemento($arg_POST){
    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    $resultadoBusquedaCarrera = MostrarElementos($arg_POST['documento_id']);
    //var_dump($resultadoBusquedaCarrera);
    include ($absolute_include."vistas/archivos/modificar.php"); 
  }

  function actualizar_carrera($arg_POST){
    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    $actualizarCarrera = modificar_datos($arg_POST['documento_id'], $arg_POST['cdescripcion_documento']);
    
    /*if ($actualizarCarrera) {
      echo '<script language = javascript>alert("El documento se ha modificado correctamente")
        self.location =  "'.$carpeta_trabajo.'/controladores/documentosvarios/controller.elementos.php ?>"
      </script>';
    }else{
      echo '<script language = javascript>alert("Error al modificar el documento, intente nuevamente")
        self.location =  "'.$carpeta_trabajo.'/controladores/documentosvarios/controller.elementos.php ?>"
      </script>';
    }*/

  }
?>