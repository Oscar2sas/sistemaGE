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

    include ($absolute_include."modelos/roles/model.roles.php");   // modelo de usuarios


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
      roles_index($textoabuscar);
    }
    //Llama a la funcion para crear un Usuario
    elseif ( $accion == "crear")  
    {
      roles_crear();
    }
    //Llama a la funcion para editar un Usuario
    elseif ( $accion == "editar")  
    {

        if (isset( $_REQUEST['rol_id'] )) { 
        $rol_id=$_REQUEST['rol_id'];
        }  

        roles_editar($rol_id);
    }
    //Llama a la funcion para mostrar la informacion de un Usuario
    elseif ( $accion == "mostrar")  
    {

        if (isset( $_REQUEST['rol_id'] )) { 
        $rol_id=$_REQUEST['rol_id'];
        }  

        roles_mostrar($rol_id);
    }
    //Llama a la funcion para insertar un nuevo usuario a la bd
    elseif ( $accion == "insertar")  
    {
      // verifico que el pedido sea desde un formulario del sistema
      $token=$_POST['token'];
  
      if($_SESSION['token'] == $token){
        roles_insertar($_POST);
      } 
      else {
        roles_index($textoabuscar);
      } 
    }
    //Llama a la funcion para modificar un usuario de la bd
    elseif ( $accion == "actualizar")  
    {
        // verifico que el pedido sea desde un formulario del sistema
        $token=$_POST['token'];

        if($_SESSION['token'] == $token){
        roles_actualizar($_POST);
        } 
        else {
        roles_index($textoabuscar);
        } 
    }
    //Llama a la funcion para eliminar un usuario de la bd
    elseif ( $accion == "eliminar")  
    {
        // verifico que el pedido sea desde un formulario del sistema
        $token=$_POST['token'];

        if($_SESSION['token'] == $token){
        roles_eliminar($_POST);
        } 
        else {
        roles_index($textoabuscar);
        } 
    }

    function roles_index($arg_textoabuscar){

        $absolute_include = $GLOBALS['absolute_include'];
        $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

        // recupera todos los roles de la base de datos

        $roles = buscar_roles($arg_textoabuscar);

        // llama a la vista de index de roles

        include ($absolute_include."vistas/roles/index.php"); 
        

    }

    function roles_crear(){
        
        $absolute_include = $GLOBALS['absolute_include'];
        $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

        // llama a la vista para crear roles

        include ($absolute_include."vistas/roles/crear.php");
    }

    function roles_editar($arg_rol_id){

      $absolute_include = $GLOBALS['absolute_include'];
      $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

      // recupera todos los roles de la base de datos
      $rol = buscar_un_rol($arg_rol_id);

      // llama a la vista de index de roles

      include ($absolute_include."vistas/roles/editar.php"); 

    }

    function roles_mostrar($arg_rol_id){

      $absolute_include = $GLOBALS['absolute_include'];
      $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

      // recupera todos los roles de la base de datos

      $rol = buscar_un_rol($arg_rol_id);

      // llama a la vista de index de roles

      include ($absolute_include."vistas/roles/mostrar.php"); 

    }
    
    function roles_insertar($arg_POST){
        $absolute_include = $GLOBALS['absolute_include'];
        $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];
    
        // aqui se pueden hacer validaciones de los datos que vienen
        // del formulario y devolver un error 
    
        $cdescripcion_rol = strtoupper($arg_POST['cdescripcion_rol']);
    
        
        // llamo a la funcion en el modelo para grabar un pais
        $ultimo_rol_id=insertar_rol($cdescripcion_rol);
    
        // llamo a la funcion en el modelo para grabar el log
    
        $cdescripcion_log =" Creacion de Rol :".$cdescripcion_rol." con ID: $ultimo_pais_id ";
        insertar_log( $cdescripcion_log);
    
    
        // llama al controlador de roles para ir al inicio
        header("Location: ".$carpeta_trabajo."/controladores/roles/controller.roles.php");
    
    }

    function roles_actualizar($arg_POST){

      $absolute_include = $GLOBALS['absolute_include'];
      $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];
  
      // aqui se pueden hacer validaciones de los datos que vienen
      // del formulario y devolver un error 
  
      //$cnombre_usuario = strtoupper($arg_POST['cnombre_usuario']);

      $rol_id = $arg_POST['rol_id'];
      $cdescripcion_rol = $arg_POST['cdescripcion_rol'];
  
      
      // llamo a la funcion en el modelo para grabar un pais
      $ultimo_rol_id=actualizar_rol($rol_id,$cdescripcion_rol);
  
      // llamo a la funcion en el modelo para grabar el log
  
      $cdescripcion_log =" Modificacion de Rol :".$cdescripcion_rol." con ID: $ultimo_rol_id ";
      insertar_log( $cdescripcion_log);
  
  
      // llama al controlador de roles para ir al inicio
      header("Location: ".$carpeta_trabajo."/controladores/roles/controller.roles.php");

    }

    function roles_eliminar($arg_POST){

      $absolute_include = $GLOBALS['absolute_include'];
      $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];
  
      // aqui se pueden hacer validaciones de los datos que vienen
      // del formulario y devolver un error 
  
      $rol_id=$arg_POST['rol_id'];
     
      
      // llamo a la funcion en el modelo para grabar un rol
      eliminar_rol($rol_id);
  
      // llamo a la funcion en el modelo para grabar el log
  
      $cdescripcion_log =" Elimino el Rol con ID: $usuario_id";
      insertar_log( $cdescripcion_log);
  
  
      // llama al controlador de paises para ir al inicio
      header("Location: ".$carpeta_trabajo."/controladores/roles/controller.roles.php");
  
      
    }

?> 