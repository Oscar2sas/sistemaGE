<?php 
  
  // seccion que permite resolver problemas de inclusion de archivos

  $carpeta_trabajo="";
  $seccion_trabajo="/index.php";

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
  
  // para autenticar al usuario

  include($absolute_include."administracion/sesion.php");

  // si el usuario esta autenticado 

  // llamo al controlador de inicio del sistema


  header("Location: ".$carpeta_trabajo."/controladores/inicio/controller.inicio.php");
  

?>   