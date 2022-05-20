<?php 

    // seccion que permite resolver problemas de inclusion de archivos
    $carpeta_trabajo="";
    $seccion_trabajo="/controladores";
    $carpeta_xampp = "D:/Programas/xampp/htdocs";

    if (strpos($_SERVER["PHP_SELF"] , $seccion_trabajo) >1 ) {
        $carpeta_trabajo=substr($_SERVER["PHP_SELF"],1, strpos($_SERVER["PHP_SELF"] , $seccion_trabajo)-1);  // saca la carpeta de trabajo del sistema
    }

  
    $absolute_include = str_repeat("../",substr_count($_SERVER["PHP_SELF"] , "/")-1).$carpeta_trabajo; //resuelve problemas de profundidad de carpetas

    if (!empty($carpeta_trabajo)) {
        $absolute_include = $absolute_include."/";
        $carpeta_trabajo = "/".$carpeta_trabajo;        
    }
    // fin seccion 

    require $absolute_include.'public/vendor/autoload.php';  // carga el archivo de librerias pdf

    use Spipu\Html2Pdf\Html2Pdf;   // carga la clase y la usa para generar pdf

    include ($absolute_include."config/global.php");   // variables de configuracion
  
    include ($absolute_include."clases/class.conexion.php");   // clase para conexion de base de datos
  
    include ($absolute_include."administracion/sesion.php") ;
  
    include ($absolute_include."modelos/log/model.log.php");   // para manejar los log

    include ($absolute_include."modelos/tipos_documentos/model.tipos_documentos.php");   // modelo de usuarios


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
      tiposdoc_index($textoabuscar);
    }
    //Llama a la funcion para crear un Usuario
    elseif ( $accion == "crear")  
    {
      tiposdoc_crear();
    }
    //Llama a la funcion para editar un Usuario
    elseif ( $accion == "editar")  
    {

        if (isset( $_REQUEST['rol_id'] )) { 
        $tipodoc_id=$_REQUEST['rol_id'];
        }  

        tiposdoc_editar($tipodoc_id);
    }
    //Llama a la funcion para mostrar la informacion de un Usuario
    elseif ( $accion == "mostrar")  
    {

        if (isset( $_REQUEST['rol_id'] )) { 
        $tipodoc_id=$_REQUEST['rol_id'];
        }  

        tiposdoc_mostrar($tipodoc_id);
    }
    //Llama a la funcion para insertar un nuevo usuario a la bd
    elseif ( $accion == "insertar")  
    {
      // verifico que el pedido sea desde un formulario del sistema
      $token=$_POST['token'];
  
      if($_SESSION['token'] == $token){
        tiposdoc_insertar($_POST);
      } 
      else {
        tiposdoc_index($textoabuscar);
      } 
    }
    //Llama a la funcion para modificar un usuario de la bd
    elseif ( $accion == "actualizar")  
    {
        // verifico que el pedido sea desde un formulario del sistema
        $token=$_POST['token'];

        if($_SESSION['token'] == $token){
        tiposdoc_actualizar($_POST);
        } 
        else {
        tiposdoc_index($textoabuscar);
        } 
    }
    //Llama a la funcion para eliminar un usuario de la bd
    elseif ( $accion == "eliminar")  
    {
        // verifico que el pedido sea desde un formulario del sistema
        $token=$_POST['token'];

        if($_SESSION['token'] == $token){
        tiposdoc_eliminar($_POST);
        } 
        else {
        tiposdoc_index($textoabuscar);
        } 
    }
    elseif ( $accion == "imprimir")  
    {
      // verifico que el pedido sea desde un formulario del sistema
      $token=$_POST['token'];
  
      if($_SESSION['token'] == $token){
        tiposdoc_imprimir($textoabuscar);
      } 
      else {
        tiposdoc_index($textoabuscar);
      } 
    }
    elseif ( $accion == "pdf")  
    {
      // verifico que el pedido sea desde un formulario del sistema
      $token=$_POST['token'];
  
      if($_SESSION['token'] == $token){
        tiposdoc_pdf($textoabuscar);
      } 
      else {
        tiposdoc_index($textoabuscar);
      } 
    }

    function tiposdoc_index($arg_textoabuscar){

        $absolute_include = $GLOBALS['absolute_include'];
        $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

        // recupera todos los tipodoc de la base de datos

        $tiposdoc = buscar_tiposdoc($arg_textoabuscar);

        // llama a la vista de index de roles

        include ($absolute_include."vistas/tipos_documentos/index.php"); 
        

    }

    function tiposdoc_crear(){
        
        $absolute_include = $GLOBALS['absolute_include'];
        $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

        // llama a la vista para crear roles

        include ($absolute_include."vistas/tipos_documentos/crear.php");
    }

    function tiposdoc_editar($arg_tipodoc_id){

      $absolute_include = $GLOBALS['absolute_include'];
      $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

      // recupera todos los roles de la base de datos
      $tipodoc = buscar_un_tipodoc($arg_tipodoc_id);
      $nombre_carpeta = explode("/",$tipodoc['ccarpeta_documento']);
      $nombre_carpeta = $nombre_carpeta[count($nombre_carpeta)-1];

      // llama a la vista de index de roles

      include ($absolute_include."vistas/tipos_documentos/editar.php"); 

    }

    function tiposdoc_mostrar($arg_tipodoc_id){

      $absolute_include = $GLOBALS['absolute_include'];
      $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

      // recupera todos los tipodoc de la base de datos

      $tipodoc = buscar_un_tipodoc($arg_tipodoc_id);

      // llama a la vista de index de roles

      include ($absolute_include."vistas/tipos_documentos/mostrar.php"); 

    }
    
    function tiposdoc_insertar($arg_POST){
        $absolute_include = $GLOBALS['absolute_include'];
        $carpeta_trabajo = $GLOBALS['ccarpeta_trabajo'];
    
        // aqui se pueden hacer validaciones de los datos que vienen
        // del formulario y devolver un error 
        $cdescripcion_tipodocumento = strtoupper($arg_POST['cdescripcion_tipodocumento']);
        $ccarpeta_documento = $carpeta_trabajo."".strtolower($arg_POST['ccarpeta_documento']);

        if(!file_exists($GLOBALS['carpeta_xampp'].$ccarpeta_documento)){
          mkdir($GLOBALS['carpeta_xampp'].$ccarpeta_documento,0777,true);
        }
        
        // llamo a la funcion en el modelo para grabar un pais
        $ultimo_tipodoc_id=insertar_tipodoc($cdescripcion_tipodocumento,$ccarpeta_documento);
    
        // llamo a la funcion en el modelo para grabar el log
    
        $cdescripcion_log =" Creacion de Tipo Documento :".$cdescripcion_tipodocumento." con ID: $ultimo_tipodoc_id ";
        insertar_log( $cdescripcion_log);
        
    
    
        // llama al controlador de roles para ir al inicio
        header("Location: ".$carpeta_trabajo."/SISTEMA%20ESCOLAR/controladores/tipos_documentos/controller.tipos_documentos.php");
    
    }

    function tiposdoc_actualizar($arg_POST){

      $absolute_include = $GLOBALS['absolute_include'];
      $carpeta_trabajo = $GLOBALS['ccarpeta_trabajo'];
  
      // aqui se pueden hacer validaciones de los datos que vienen
      // del formulario y devolver un error 
  
      //$cnombre_usuario = strtoupper($arg_POST['cnombre_usuario']);

      $tipodoc_id = $arg_POST['tipodocumento_id'];
      $oldcarpeta = buscar_un_tipodoc($tipodoc_id);
      $oldcarpeta = $oldcarpeta['ccarpeta_documento'];
      
      $cdescripcion_tipodocumento = $arg_POST['cdescripcion_tipodocumento'];
      $ccarpeta_documento = $carpeta_trabajo."".strtolower($arg_POST['ccarpeta_documento']);
      
      // llamo a la funcion en el modelo para actualizar un tipo
      $ultimo_tipodoc_id=actualizar_tipodoc($tipodoc_id,$cdescripcion_tipodocumento,$ccarpeta_documento);
      
      if(file_exists($GLOBALS['carpeta_xampp'].$oldcarpeta)){
        rename($GLOBALS['carpeta_xampp'].$oldcarpeta,$GLOBALS['carpeta_xampp'].$ccarpeta_documento);
      }
      

      // llamo a la funcion en el modelo para grabar el log
  
      $cdescripcion_log =" Modificacion de Tipo Documento :".$cdescripcion_tipodocumento." con ID: $ultimo_tipodoc_id ";
      insertar_log( $cdescripcion_log);
  
  
      // llama al controlador de roles para ir al inicio
      header("Location: ".$carpeta_trabajo."/SISTEMA%20ESCOLAR/controladores/tipos_documentos/controller.tipos_documentos.php");
    }

    function tiposdoc_eliminar($arg_POST){

      $absolute_include = $GLOBALS['absolute_include'];
      $carpeta_trabajo = $GLOBALS['ccarpeta_trabajo'];
  
      // aqui se pueden hacer validaciones de los datos que vienen
      // del formulario y devolver un error 
  
      $tipodoc_id=$arg_POST['tipodocumento_id'];
     
      
      // llamo a la funcion en el modelo para grabar un rol
      eliminar_tipodoc($tipodoc_id);
  
      // llamo a la funcion en el modelo para grabar el log
  
      $cdescripcion_log =" Elimino el Tipo de Documento con ID: ".$arg_POST['tipodocumento_id'];
      insertar_log( $cdescripcion_log);
  
      // llama al controlador de paises para ir al inicio
      header("Location: ".$carpeta_trabajo."/SISTEMA%20ESCOLAR/controladores/tipos_documentos/controller.tipos_documentos.php");
      
    }

    function tiposdoc_imprimir($arg_textoabuscar){

      $absolute_include = $GLOBALS['absolute_include'];
      $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];
  
      // busca los paises en la base de datos
  
      $tiposdoc = buscar_tiposdoc($arg_textoabuscar);
  
      // llama a la vista de index de paises
  
      include ($absolute_include."vistas/tipos_documentos/imprimir.php"); 
  
      include ($absolute_include."vistas/plantillas/footer_imprimir.php"); 
   
  
    }
  
    function tiposdoc_pdf($arg_textoabuscar){
  
      $absolute_include = $GLOBALS['absolute_include'];
      $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];
  
      // busca los paises en la base de datos
  
      $tiposdoc = buscar_tiposdoc($arg_textoabuscar);
  
      $html2pdf = new Html2Pdf('P','A4','es','true',"UTF-8'");   // crea un nuevo objeto
      
      ob_start();   // creo un buffer en memoria que va a recoger todo lo que se deberia mostrar en pantalla
      
      include ($absolute_include."vistas/tipos_documentos/imprimir.php"); 
  
      include ($absolute_include."vistas/plantillas/footer_pdf.php"); 
   
      $mihtml=ob_get_clean();   // guardo todo lo de buffer en una variable  
      ob_end_clean();
  
      $html2pdf->writeHTML($mihtml);
      $html2pdf->output('tipos_documentos.pdf');
  
      
    }

?> 