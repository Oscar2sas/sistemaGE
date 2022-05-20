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

    include ($absolute_include."modelos/personas/model.personas.php");   // para manejar las personas

    include ($absolute_include."modelos/tipos_documentos/model.tipos_documentos.php");   // para manejar los tipos documentos

    include ($absolute_include."modelos/documentospersonas/model.documentospersonas.php");   // modelo de usuarios


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
      documentos_index($textoabuscar);
    }
    //Llama a la funcion para crear un Usuario
    elseif ( $accion == "crear")  
    {
      documentos_crear();
    }
    //Llama a la funcion para editar un Usuario
    elseif ( $accion == "editar")  
    {

        if (isset( $_REQUEST['documento_id'] )) { 
        $documento_id=$_REQUEST['documento_id'];
        }  

        documentos_editar($documento_id);
    }
    //Llama a la funcion para mostrar la informacion de un Usuario
    elseif ( $accion == "mostrar")  
    {

        if (isset( $_REQUEST['documento_id'] )) { 
        $documento_id=$_REQUEST['documento_id'];
        }  

        documentos_mostrar($documento_id);
    }
    //Llama a la funcion para insertar un nuevo documento a la bd
    elseif ( $accion == "insertar")  
    {
      // verifico que el pedido sea desde un formulario del sistema
      $token=$_POST['token'];
  
      if($_SESSION['token'] == $token){
        documentos_insertar($_POST,$_FILES);
      } 
      else {
        documentos_index($textoabuscar);
      } 
    }
    //Llama a la funcion para modificar un usuario de la bd
    elseif ( $accion == "actualizar")  
    {
        // verifico que el pedido sea desde un formulario del sistema
        $token=$_POST['token'];

        if($_SESSION['token'] == $token){
        documentos_actualizar($_POST,$_FILES);
        } 
        else {
        documentos_index($textoabuscar);
        } 
    }
    //Llama a la funcion para eliminar un usuario de la bd
    elseif ( $accion == "eliminar")  
    {
        // verifico que el pedido sea desde un formulario del sistema
        $token=$_POST['token'];

        if($_SESSION['token'] == $token){
        documentos_eliminar($_POST);
        } 
        else {
        documentos_index($textoabuscar);
        } 
    }

    elseif ( $accion == "imprimir")  
    {

        if (isset( $_REQUEST['documento_id'] )) { 
        $documento_id=$_REQUEST['documento_id'];
        }  

        tiposdoc_imprimir($_POST, $textoabuscar);
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

    function documentos_index($arg_textoabuscar){

        $absolute_include = $GLOBALS['absolute_include'];
        $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

        // recupera todos los usuarios de la base de datos

        $documentos = buscar_documentos($arg_textoabuscar);

        // llama a la vista de index de usuarios
        //print_r($documentos);
        include ($absolute_include."vistas/documentospersonas/index.php"); 
        

    }

    function documentos_crear(){
        
        $absolute_include = $GLOBALS['absolute_include'];
        $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

        $tiposdoc = buscar_tiposdoc("");
        $personas = buscar_persona("");
        // llama a la vista para crear documentos

        include ($absolute_include."vistas/documentospersonas/crear.php");
    }

    function documentos_editar($arg_documento_id){

      $absolute_include = $GLOBALS['absolute_include'];
      $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

      // recupera todos los usuarios de la base de datos
      $tiposdoc = buscar_tiposdoc("");
      $personas = buscar_persona("");
      $documento = buscar_un_documento($arg_documento_id);

      // llama a la vista de index de usuarios

      include ($absolute_include."vistas/documentospersonas/editar.php"); 

    }

    function documentos_mostrar($arg_documento_id){

      $absolute_include = $GLOBALS['absolute_include'];
      $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

      // recupera todos los documentos de la base de datos

      $documento = buscar_un_documento($arg_documento_id);

      // llama a la vista de index de usuarios

      include ($absolute_include."vistas/documentospersonas/mostrar.php"); 

    }

    function numero_random(){
      $num = '';
      for($i=1;$i<=4;$i++){
        $num = $num.mt_rand(0,9);
      }
      return $num;
    }
    
    function documentos_insertar($arg_POST,$arg_FILES){
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
        $direccion = buscar_un_tipodoc($arg_POST['rela_tipodocumento_id']);
        $nombre = $arg_FILES['cimg_documento']['name'];
        $guardado = $arg_FILES['cimg_documento']['tmp_name'];
        $tipo = $arg_FILES['cimg_documento']['type'];
        $descripcion = $arg_POST['descrip'];
        $select = $arg_POST['select'];

        if($arg_FILES['cimg_documento']['size']!=0){

          $nombre_archivo = $direccion['cdescripcion_tipodocumento'].date("dmy").$nombre;
          

          $img_documento = $absolute_include."storage/documentos/".$direccion['ccarpeta_documento']."/".$nombre_archivo;
          //.$arg_FILES['cimg_documento']['name']

          move_uploaded_file($arg_FILES['cimg_documento']['tmp_name'],$img_documento );
        

          $arraydat = [
            "cimg_documento"         => $nombre_archivo,
            "rela_persona_id"        => $arg_POST['rela_persona_id'],
            "rela_tipodocumento_id"  => $arg_POST['rela_tipodocumento_id'], 
          ];

        
    
        
          // llamo a la funcion en el modelo para grabar un pais
          $ultimo_documento_id=insertar_documento($arraydat);
      
          // llamo a la funcion en el modelo para grabar el log
      
          $cdescripcion_log =" Creacion de Documento :".$arg_FILES['cimg_documento']['name'].", Del tipo: ".$direccion['cdescripcion_tipodocumento']." con ID: $ultimo_documento_id ";
          insertar_log( $cdescripcion_log);
        }
        // llama al controlador de usuarios para ir al inicio
        header("Location: ".$carpeta_trabajo."/controladores/documentospersonas/controller.documentospersonas.php");
      
    
    }

    function documentos_actualizar($arg_POST,$arg_FILES){

      $absolute_include = $GLOBALS['absolute_include'];
      $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];
  
      // aqui se pueden hacer validaciones de los datos que vienen
      // del formulario y devolver un error 
  
      //$cnombre_usuario = strtoupper($arg_POST['cnombre_usuario']);

      $documento_id = $arg_POST['documento_id'];
      $documento = buscar_un_documento($documento_id);
      $nombre = $arg_FILES['cimg_documento']['name'];
      $guardado = $arg_FILES['cimg_documento']['tmp_name'];
      $tipo = $arg_FILES['cimg_documento']['type'];
      $descripcion = $arg_POST['descrip'];
      $select = $arg_POST['select'];
     
      
      // llamo a la funcion en el modelo para grabar un usuario

      if($arg_FILES['cimg_documento']['size']!=0){
        
        $nombre_archivo = $documento['cdescripcion_tipodocumento'].date("dmy").$nombre;

        $img_documento = $absolute_include."storage/documentos/".$documento['ccarpeta_documento']."/".$nombre_archivo;
        //.$arg_FILES['cimg_documento']['name']

        move_uploaded_file($arg_FILES['cimg_documento']['tmp_name'], $img_documento );
        unlink($absolute_include."storage/documentos/".$documento['ccarpeta_documento']."/".$documento['cimg_documento']);
      }else{
        $img_documento = $documento['cimg_documento'];
      }

      $arraydat = [
        "documento_id"          => $documento_id,
        "cimg_documento"        => $nombre_archivo,
        "rela_persona_id"       => $arg_POST['rela_persona_id'],
        "rela_tipodocumento_id" => $arg_POST['rela_tipodocumento_id'], 
      ];

  
      
      // llamo a la funcion en el modelo para grabar un pais
      $ultimo_documento_id=actualizar_documento($arraydat);
    
      // llamo a la funcion en el modelo para grabar el log
    
      $cdescripcion_log =" Modificacion de Documento :".$arg_FILES['cimg_documento']['name'].", Del tipo: ".$documento['cdescripcion_tipodocumento']." con ID: $ultimo_documento_id ";
      insertar_log( $cdescripcion_log);
  
      // llama al controlador de usuarios para ir al inicio
      header("Location: ".$carpeta_trabajo."/controladores/documentospersonas/controller.documentospersonas.php");

    }

    function documentos_eliminar($arg_POST){

      $absolute_include = $GLOBALS['absolute_include'];
      $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];
  
      // aqui se pueden hacer validaciones de los datos que vienen
      // del formulario y devolver un error 
  
      $documento_id=$arg_POST['documento_id'];

      $documento = buscar_un_documento($documento_id);

      unlink($absolute_include."storage/documentos/".$documento['ccarpeta_documento']."/".$documento['cimg_documento']);
     
      
      // llamo a la funcion en el modelo para grabar un documento
      eliminar_documento($documento_id);
  
      // llamo a la funcion en el modelo para grabar el log
  
      $cdescripcion_log =" Elimino el Documento con ID: $usuario_id";
      insertar_log( $cdescripcion_log);
  
  
      // llama al controlador de usuarios para ir al inicio
      header("Location: ".$carpeta_trabajo."/controladores/documentospersonas/controller.documentospersonas.php");
  
      
    }

    function tiposdoc_imprimir($arg_POST, $arg_textoabuscar){

      $absolute_include = $GLOBALS['absolute_include'];
      $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

      $documento_id=$arg_POST['documento_id'];
  
      // busca los paises en la base de datos
  
      $tiposdoc = buscar_documentos($documento_id);
  
      // llama a la vista de index de paises
  
      include ($absolute_include."vistas/documentospersonas/imprimir.php"); 
  
      include ($absolute_include."vistas/plantillas/footer_imprimir_docper.php"); 
   
  
    }
  
    function tiposdoc_pdf($arg_POST, $arg_textoabuscar){
  
      $absolute_include = $GLOBALS['absolute_include'];
      $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];
  

      $documento_id=$arg_POST['documento_id'];
  
      $tiposdoc = buscar_documentos($documento_id);
  
      $html2pdf = new Html2Pdf('P','A4','es','true',"UTF-8'");   // crea un nuevo objeto
      
      ob_start();   // creo un buffer en memoria que va a recoger todo lo que se deberia mostrar en pantalla
      
      include ($absolute_include."vistas/documentospersonas/imprimir.php"); 
  
      include ($absolute_include."vistas/plantillas/footer_pdf.php"); 
   
      $mihtml=ob_get_clean();   // guardo todo lo de buffer en una variable  
      ob_end_clean();
  
      $html2pdf->writeHTML($mihtml);
      $html2pdf->output('documentospersonas.pdf');
  
      
    }
    function obtener_tipo_imagen($cimg_documento){
  
      $absolute_include = $GLOBALS['absolute_include'];
      $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];
  

      $archivo = $cimg_documento; //archivo1.jpg
      $arrayString = explode(".", $archivo); //array(archivo1, jpg)
      $extension = end($arrayString); //jpg
      $imagen = "";
      

      if($extension == "docx"){
        $imagen = "\storage\iconos\word.png";
      }elseif($extension == "pdf"){
        $imagen = "\storage\iconos\pdf.png";
      }elseif($extension == "xlsx"){
        $imagen = "\storage\iconos\excel.png";
      }elseif($extension == "pptx"){
        $imagen = "\storage\iconos\power_point.png";
      }else{
        $imagen = "";
      }
      return $imagen;
    }

?> 