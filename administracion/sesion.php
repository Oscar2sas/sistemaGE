<?php 

  // iniciar sesion
   session_start();
 

   // necesito saber si ya hay un usuario autenticado
   // entonces pregunto si existe la variable $SESSION['Usuario'] que es la variable que contiene el id de usuario autenticado
    
   if (!isset($_SESSION['Usuario'])) 
  {
    // si la variable no existe quiere decir que no hay usuario autenticado
    // lo llevo a la pagina de login
    header("Location: ".$carpeta_trabajo."/administracion/login.php");
  
  }

  
  // si el usuario esta autenticado continuo
  if(!empty($usuarios_permitidos)){
    $permitidos = $usuarios_permitidos;
  }else{
    $permitidos = '';
  }
  
  if(!empty($permitidos)){
    if( !in_array( $_SESSION['rela_rol_id'], $permitidos) ){

      if(isset($_SERVER['HTTP_REFERER'])){
        $url_anterior = explode("/",$_SERVER['HTTP_REFERER'],4);
        header("Location: ".$url_anterior[3]);
      }
      else{
        header("Location: ".$carpeta_trabajo."/controladores/inicio/controller.inicio.php");
      }
      
    }
  }

?>