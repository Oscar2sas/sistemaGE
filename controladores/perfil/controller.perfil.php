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
  
    include ($absolute_include."modelos/log/model.log.php");   // para manejar los log

    include ($absolute_include."modelos/usuarios/model.usuarios.php");   // modelo de usuarios


  $accion="";

  if (isset($_REQUEST['accion'])) {   // si existe una variable tipo REQUEST que llama a una accion / funcion

    $accion=$_REQUEST['accion'];
  }

  if ( $accion == "" OR $accion=="password" )  
  {
    password_cambiar();
  }else if( $accion == "cambiar" ){
    $token=$_POST['token'];
  
    if($_SESSION['token'] == $token){
      password_actualizar($_POST);
    } 
    else {
      password_cambiar();
    }
  }else if( $accion == "perfil" ){
    perfil_editar();
  }else if( $accion == "actualizar" ){
    $token=$_POST['token'];

    if($_SESSION['token'] == $token){
      perfil_actualizar($_POST,$_FILES);
    } 
    else {
      password_cambiar();
    }
  }

  function numero_random(){
    $num = '';
    for($i=1;$i<=5;$i++){
      $num = $num.mt_rand(0,9);
    }
    return $num;
  }
  
  function perfil_editar(){
    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // trae los datos de un usuario
    $usuario = buscar_un_usuario($_SESSION['usuario_id']);

    // llama a la vista de index de usuarios

    include ($absolute_include."vistas/perfil/perfil.php");
  }
  
  function perfil_actualizar($arg_POST,$arg_FILES){
    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // aqui se pueden hacer validaciones de los datos que vienen
    // del formulario y devolver un error 
    $usuario = buscar_un_usuario($_SESSION['usuario_id']);

    if($arg_FILES['cimg_usuario']['size']!=0){
      $num = numero_random();
      $img_perfil = "IMG".date("dmy").$num.".png";

      move_uploaded_file($arg_FILES['cimg_usuario']['tmp_name'], $absolute_include."/storage/usuarios/".$img_perfil );

      if($usuario['cimg_usuario']!='default.png'){
        unlink($absolute_include."/storage/usuarios/".$usuario['cimg_usuario']);
      }

    }else{
      $img_perfil = $usuario['cimg_usuario'];
    }

    $arraydat = [
        "usuario_id"         => $_SESSION['usuario_id'],
        "cimg_usuario"       => $img_perfil,
        "cnombre_usuario"    => trim($arg_POST['cnombre_usuario']),
        "cemail_usuario"     => trim($arg_POST['cemail_usuario']), 
    ];

    
    // llamo a la funcion en el modelo para grabar un pais
    $ultimo_usuario_id=actualizar_perfil($arraydat);

    $_SESSION['NombreUsuario'] = $arg_POST['cnombre_usuario'];
    $_SESSION['ImagenPerfil'] = $img_perfil;

    // llamo a la funcion en el modelo para grabar el log

    $cdescripcion_log =" Modificacion de Usuario :".$arraydat['cnombre_usuario'].", Email:".$arraydat['cemail_usuario']." con ID: ".$_SESSION['usuario_id'];
    insertar_log( $cdescripcion_log);


    // llama al controlador de usuarios para ir al inicio
    header("Location: ".$carpeta_trabajo."/controladores/inicio/controller.inicio.php");

  }

  function password_cambiar(){
    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // llama a la vista de index de perfil

    include ($absolute_include."vistas/perfil/password.php");
  }

  function password_actualizar($arg_POST){
    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // aqui se pueden hacer validaciones de los datos que vienen
    // del formulario y devolver un error 
    $usuario = buscar_un_usuario($_SESSION['usuario_id']);

    $password = $usuario['cpassword_usuario'];
    $oldpassword = strtolower(trim($arg_POST['old_password']));
    $newpassword = strtolower(trim($arg_POST['new_password']));


    if(password_verify($oldpassword,$password)){
      if(!password_verify($newpassword,$password)){
        guardar_password($_SESSION['usuario_id'], $newpassword);
        $cod = 1;
      }else{
        $cod = 2;
      }
    }else{
      $cod = 0;
    }

    $cdescripcion_log =" Modificacion de Contraseña de Usuario con ID:".$_SESSION['usuario_id'];
    insertar_log( $cdescripcion_log);

    // llama al controlador de usuarios para ir al inicio
    header("Location: ".$carpeta_trabajo."/controladores/perfil/controller.perfil.php?codigo=".$cod);
  }
?> 