<?php 

    // seccion que permite resolver problemas de inclusion de archivos
    $carpeta_trabajo="";
    $seccion_trabajo="/controladores";


    $usuarios_permitidos = array(1,2);

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


    //verifica si se llamo a una accion determinada en el controlador
    $accion="";
    // verifica si esta especificando un filtro
    $textoabuscar="";

    if (isset($_REQUEST['accion'])) {   // si existe una variable tipo REQUEST que llama a una accion / funcion
        $accion=$_REQUEST['accion'];
    }

    if ( $accion == "" OR $accion=="index" )  
    {
      if (isset( $_REQUEST['textoabuscar'] )) { 
        $textoabuscar=$_REQUEST['textoabuscar'];
      }  
      usuarios_index($textoabuscar);
    }
    //Llama a la funcion para crear un Usuario
    elseif ( $accion == "crear")  
    {
      usuarios_crear();
    }
    //Llama a la funcion para editar un Usuario
    elseif ( $accion == "editar")  
    {

        if (isset( $_REQUEST['usuario_id'] )) { 
        $usuario_id=$_REQUEST['usuario_id'];
        }  

        usuarios_editar($usuario_id);
    }
    //Llama a la funcion para mostrar la informacion de un Usuario
    elseif ( $accion == "mostrar")  
    {

        if (isset( $_REQUEST['usuario_id'] )) { 
        $usuario_id=$_REQUEST['usuario_id'];
        }  

        usuarios_mostrar($usuario_id);
    }
    //Llama a la funcion para insertar un nuevo usuario a la bd
    elseif ( $accion == "insertar")  
    {
      // verifico que el pedido sea desde un formulario del sistema
      $token=$_POST['token'];
  
      if($_SESSION['token'] == $token){
        usuarios_insertar($_POST,$_FILES);
      } 
      else {
        usuarios_index($textoabuscar);
      } 
    }
    //Llama a la funcion para modificar un usuario de la bd
    elseif ( $accion == "actualizar")  
    {
        // verifico que el pedido sea desde un formulario del sistema
        $token=$_POST['token'];

        if($_SESSION['token'] == $token){
        usuarios_actualizar($_POST,$_FILES);
        } 
        else {
        usuarios_index($textoabuscar);
        } 
    }
    //Llama a la funcion para eliminar un usuario de la bd
    elseif ( $accion == "eliminar")  
    {
        // verifico que el pedido sea desde un formulario del sistema
        $token=$_POST['token'];

        if($_SESSION['token'] == $token){
        usuarios_eliminar($_POST);
        } 
        else {
        usuarios_index($textoabuscar);
        } 
    }

    function usuarios_index($arg_textoabuscar){

        $absolute_include = $GLOBALS['absolute_include'];
        $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

        // recupera todos los usuarios de la base de datos

        $usuarios = buscar_usuarios($arg_textoabuscar);

        // llama a la vista de index de usuarios

        include ($absolute_include."vistas/usuarios/index.php"); 
        

    }

    function usuarios_crear(){
        
        $absolute_include = $GLOBALS['absolute_include'];
        $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

        $roles = buscar_roles();
        // llama a la vista para crear usuarios

        include ($absolute_include."vistas/usuarios/crear.php");
    }

    function usuarios_editar($arg_usuario_id){

      $absolute_include = $GLOBALS['absolute_include'];
      $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

      // recupera todos los usuarios de la base de datos
      $roles = buscar_roles();
      $usuario = buscar_un_usuario($arg_usuario_id);

      // llama a la vista de index de usuarios

      include ($absolute_include."vistas/usuarios/editar.php"); 

    }

    function usuarios_mostrar($arg_usuario_id){

      $absolute_include = $GLOBALS['absolute_include'];
      $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

      // recupera todos los usuarios de la base de datos

      $usuario = buscar_un_usuario($arg_usuario_id);

      // llama a la vista de index de usuarios

      include ($absolute_include."vistas/usuarios/mostrar.php"); 

    }
    
    function usuarios_insertar($arg_POST,$arg_FILES){
        $absolute_include = $GLOBALS['absolute_include'];
        $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];
    
        // aqui se pueden hacer validaciones de los datos que vienen
        // del formulario y devolver un error 
    
        //$cnombre_usuario = strtoupper($arg_POST['cnombre_usuario']);

        /*if (isset( $arg_POST['rela_rol_id'] )) { 
          $rela_rol_id= $arg_POST['rela_rol_id'];
        }else{
          $rela_rol_id = 20;
        }*/

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
            "rela_rol_id"        => $arg_POST['rela_rol_id'],
        ];
    
        
        // llamo a la funcion en el modelo para grabar un pais
        $ultimo_usuario_id=insertar_usuario($arraydat);
    
        // llamo a la funcion en el modelo para grabar el log
    
        $cdescripcion_log =" Creacion de Usuario :".$arraydat['cnombre_usuario'].", Email:".$arraydat['cemail_usuario']." con ID:". $ultimo_usuario_id ;
        insertar_log( $cdescripcion_log);
    
    
        // llama al controlador de usuarios para ir al inicio
        header("Location: ".$carpeta_trabajo."/controladores/usuarios/controller.usuarios.php");
    
    }

    function numero_random(){
      $num = '';
      for($i=1;$i<=5;$i++){
        $num = $num.mt_rand(0,9);
      }
      return $num;
    }

    function usuarios_actualizar($arg_POST,$arg_FILES){

      $absolute_include = $GLOBALS['absolute_include'];
      $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

      $usuario = buscar_un_usuario($arg_POST['usuario_id']);
  
      // aqui se pueden hacer validaciones de los datos que vienen
      // del formulario y devolver un error 
  
      //$cnombre_usuario = strtoupper($arg_POST['cnombre_usuario']);

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
          "usuario_id"    => $arg_POST['usuario_id'],
          "cimg_usuario"       => $img_perfil,
          "cnombre_usuario"    => trim($arg_POST['cnombre_usuario']),
          "cemail_usuario"     => trim($arg_POST['cemail_usuario']), 
          "cpassword_usuario"  => strtolower(trim($arg_POST['cpassword_usuario'])),
          "rela_rol_id"  => $arg_POST['rela_rol_id'],
          "nestado_usuario"  => $arg_POST['nestado_usuario'],
      ];
  
      
      // llamo a la funcion en el modelo para grabar un pais
      $ultimo_usuario_id=actualizar_usuario($arraydat);
  
      // llamo a la funcion en el modelo para grabar el log
  
      $cdescripcion_log =" Modificacion de Usuario :".$arraydat['cnombre_usuario'].", Email:".$arraydat['cemail_usuario']." con ID: ".$arg_POST['usuario_id'] ;
      insertar_log( $cdescripcion_log);
  
  
      if($_SESSION['usuario_id'] == $arg_POST['usuario_id']){
        $_SESSION['ImagenPerfil'] = $img_perfil;
        $_SESSION['NombreUsuario'] = $arg_POST['cnombre_usuario'];
      }

      // llama al controlador de usuarios para ir al inicio
      header("Location: ".$carpeta_trabajo."/controladores/usuarios/controller.usuarios.php");

    }

    function usuarios_eliminar($arg_POST){

      $absolute_include = $GLOBALS['absolute_include'];
      $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];
  
      // aqui se pueden hacer validaciones de los datos que vienen
      // del formulario y devolver un error 
  
      $usuario_id=$arg_POST['usuario_id'];
     
      
      // llamo a la funcion en el modelo para grabar un usuario
      eliminar_usuario($usuario_id);
  
      // llamo a la funcion en el modelo para grabar el log
  
      $cdescripcion_log =" Desactivo el Usuario con ID: ".$usuario_id;
      insertar_log( $cdescripcion_log);
  
  
      // llama al controlador de usuarios para ir al inicio
      header("Location: ".$carpeta_trabajo."/controladores/usuarios/controller.usuarios.php");
  
      
    }

?> 