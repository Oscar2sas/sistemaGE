<?php 

    session_start();

    // seccion que permite resolver problemas de inclusion de archivos
    $carpeta_trabajo="";
    $seccion_trabajo="/administracion";

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

    include ($absolute_include."modelos/log/model.log.php");   // para manejar los log

    // llamo a la funcion en el modelo para grabar el log

    $cdescripcion_log =" Salida del sistema : ".$_SESSION['NombreUsuario']." con ID: ".$_SESSION['usuario_id'];
    insertar_log( $cdescripcion_log);

    
    // cerrar sesion
    session_destroy();
  
    // lo llevo a la pagina de login
    header("Location: ".$carpeta_trabajo."/administracion/login.php");
    
  
?>