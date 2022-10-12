<?php 

    session_start();
    
    // seccion que permite resolver problemas de inclusion de archivos
    $carpeta_trabajo="";
    $seccion_trabajo="/administracion";

    if (strpos($_SERVER["PHP_SELF"] , $seccion_trabajo) >1) {
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

    include ($absolute_include."modelos/usuarios/model.usuarios.php");   // para manejar los usuarios
   

    // verifico si mando un usuario y una contraseña

    if (!isset($_POST['usuario']) && !isset($_POST['password']))
    {

        // si NO existen las variables de usuario y contraseña quiere decir que
        // no se llego a esta pagina por el formulario de login
        // lo llevo a la pagina de login para que se autentique

        header("Location: ".$carpeta_trabajo."/administracion/login.php");
    
    }
      
    // si mando un usuario y contraseña tengoque verificar que 
    // el usuario este activo en la base de datos

    $usuario_id = 0;
    $NombreUsuario = "Invitado";
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    //Codigos de error:
    //1 : Contraseña incorrecta
    //2 : Usuario no encontrado
    //3 : Usuario inhabilitado
    //4 : Esperando a habilitacion del administrador


    // llamo a una funcion en el modelo de usuarios
    
    $resultados = login_usuario( $usuario, $password );   
    
 
  
    if (!$resultados) {
        // no se encontro el usuario
        $usuario_id = 0;
        header("Location: ".$carpeta_trabajo."/administracion/login.php?error=2");
    }
    else 
    {    
        
        // reviso el retorno
        // si es uno solo

        $usuario_id = $resultados['usuario_id'];
        $NombreUsuario = $resultados['cnombre_usuario'];
        $usuario = $resultados['cemail_usuario'];
        $hash = $resultados['cpassword_usuario'];
        //$hash = password_hash("rasmuslerdorf", PASSWORD_DEFAULT)."\n";

        $rela_rol_id = $resultados['rela_rol_id'];
        $cimg_usuario = $resultados['cimg_usuario'];

        $rol = $resultados['cdescripcion_rol'];

        $estado_usuario = $resultados['nestado_usuario'];

        // reviso el password    
        if(!password_verify($password,$hash)){

             // no coinciden el password   
             $usuario_id = 0;
             header("Location: ".$carpeta_trabajo."/administracion/login.php?error=1");
        }
        if($rela_rol_id==20){
            $usuario_id = 0;
            header("Location: ".$carpeta_trabajo."/administracion/login.php?error=4");
        }
        if($estado_usuario==2){
            $usuario_id = 0;
            header("Location: ".$carpeta_trabajo."/administracion/login.php?error=3");
        }
    }

    //if ($usuario_id == 0) {

          // no se encontro usuario en la base de datos
         // lo llevo a la pagina de login para que se autentique

         //header("Location: ".$carpeta_trabajo."/administracion/login.php?error=2");
    
    //}

    $_SESSION['usuario_id'] = $usuario_id;
    $_SESSION['NombreUsuario'] = $NombreUsuario;
    $_SESSION['Usuario']=$usuario;
    $_SESSION['Password'] = $password;
    
    $_SESSION['rela_rol_id'] = $rela_rol_id;
    $_SESSION['Rol'] = $rol;
    $_SESSION['ImagenPerfil'] = $cimg_usuario;

    // preparo token de seguridad para formularios
    $hora = date('H:i');
    $session_id = session_id();
    $token = hash('sha256', $hora.$session_id);
 
    $_SESSION['token'] = $token;
    // $_SESSION['token'] = "cee8ff345149485f53ee367a529523e43e78d9e82759f0fbba8ebfd2c67e38d6";

    // llamo a la funcion en el modelo para grabar el log

    $cdescripcion_log =" Ingreso el sistema : ".$_SESSION['NombreUsuario']." con ID: ".$_SESSION['usuario_id'];
    insertar_log( $cdescripcion_log);

    // si el usuario existe y esta habilitado vamos a la pagina principal del sistema
    if (($usuario_id != 0) and ($rela_rol_id==1) or ($rela_rol_id==2) or ($rela_rol_id==3) or ($rela_rol_id==4) or ($rela_rol_id==5) or ($rela_rol_id==6)) {
        header("Location: ".$carpeta_trabajo."/index.php");
    }
    if (($usuario_id != 0) and ($rela_rol_id==7) or ($rela_rol_id==8) or ($rela_rol_id==9)) {
        header("Location: ".$carpeta_trabajo."/controladores/notas_secundarios/controller.notas.php");
    } 

 

?> 