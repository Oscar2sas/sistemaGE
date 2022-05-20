<?php 
 
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

 
  include ($absolute_include."config/global.php"); 

  include ($absolute_include."clases/class.conexion.php");   // clase para conexion de base de datos
  include ($absolute_include."modelos/usuarios/model.usuarios.php");   // modelo de usuarios
  //include ($absolute_include."modelos/log/model.log.php");


  $accion="";

  if (isset($_REQUEST['accion'])) {   // si existe una variable tipo REQUEST que llama a una accion / funcion

    $accion=$_REQUEST['accion'];
  }

  if ( $accion == "" OR $accion=="index" )  
  {
    include ($absolute_include."vistas/register/index.php"); 
  }else if( $accion == "registrar" ){
    usuarios_insertar($_POST,$_FILES);
  }

  function numero_random(){
    $num = '';
    for($i=1;$i<=5;$i++){
      $num = $num.mt_rand(0,9);
    }
    return $num;
  }
  
  function usuarios_insertar($arg_POST,$arg_FILES){
    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // aqui se pueden hacer validaciones de los datos que vienen
    // del formulario y devolver un error 

    $cnombre_usuario = strtoupper($arg_POST['cnombre_usuario']);

    $rela_rol_id = 20;

    if($arg_FILES['cimg_usuario']['size']==0){
      $img_perfil = "default.png";
    }else{
      $num = numero_random();
      $img_perfil = "IMG".date("dmy").$num.".png";

      move_uploaded_file($arg_FILES['cimg_usuario']['tmp_name'], $absolute_include."/storage/usuarios/".$img_perfil );
    }

    $arraydat = [
        "cimg_usuario"       => $img_perfil,
        "cnombre_usuario"    => trim($arg_POST['cnombre_usuario']),
        "cemail_usuario"     => trim($arg_POST['cemail_usuario']), 
        "cpassword_usuario"  => strtolower(trim($arg_POST['cpassword_usuario'])),
        "rela_rol_id"  => $rela_rol_id,
    ];

    
    // llamo a la funcion en el modelo para grabar un pais
    $ultimo_usuario_id=insertar_usuario($arraydat);

    // llamo a la funcion en el modelo para grabar el log

    //$cdescripcion_log =" Creacion de Usuario :".$arraydat['cnombre_usuario'].", Email:".$arraydat['cemail_usuario']." con ID: $ultimo_usuario_id ";
    //insertar_log( $cdescripcion_log);


    // llama al controlador de usuarios para ir al inicio
    header("Location: ".$carpeta_trabajo."/administracion/login.php");

  }
?> 