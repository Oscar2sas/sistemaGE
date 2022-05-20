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


  require $absolute_include.'public/vendor/autoload.php';  // carga el archivo de librerias pdf

  use Spipu\Html2Pdf\Html2Pdf;   // carga la clase y la usa para generar pdf


  include ($absolute_include."config/global.php");   // variables de configuracion
  
  include ($absolute_include."clases/class.conexion.php");   // clase para conexion de base de datos

  include ($absolute_include."administracion/sesion.php") ;

  include ($absolute_include."modelos/log/model.log.php");   // para manejar los log

  include ($absolute_include."modelos/notas/.model.notas.php");   // para manejar los log

  


  //verifica si se llamo a una accion determinada en el controlador
  $accion="";
  // verifica si esta especificando un filtro
  $textoabuscar="";

  if (isset($_REQUEST['accion'])) {   // si existe una variable tipo REQUEST que llama a una accion / funcion

    $accion=$_REQUEST['accion'];
  }
   

  // define la accion a realizar

  if ( $accion == "" OR $accion=="index" )  
  {
    if (isset( $_REQUEST['arg_textoabuscar'] )) { 
      $textoabuscar=$_REQUEST['arg_textoabuscar'];
    }  

    notas_index($textoabuscar);
  } 
  elseif ( $accion == "crear")  
  {
    notas_crear();
  }
  elseif ( $accion == "editar")  
  {

    if (isset( $_REQUEST['notas_id'] )) { 
      $notas_id=$_REQUEST['notas_id'];
    }  

    notas_editar($notas_id);
  }
  elseif ( $accion == "mostrar")  
  {

    if (isset( $_REQUEST['notas_id'] )) { 
      $notas_id=$_REQUEST['notas_id'];
    }  

    notas_mostrar($notas_id);
  }
  elseif ( $accion == "insertar")  
  {
    // verifico que el pedido sea desde un formulario del sistema
    $token=$_POST['token'];

    if($_SESSION['token'] == $token){
      notas_insertar($_POST);
    } 
    else {
      notas_index($textoabuscar);
    } 
  }
  elseif ( $accion == "actualizar")  
  {
    // verifico que el pedido sea desde un formulario del sistema
    $token=$_POST['token'];

    if($_SESSION['token'] == $token){
      notas_actualizar($_POST);
    } 
    else {
      notas_index($textoabuscar);
    } 
  }
  elseif ( $accion == "eliminar")  
  {
    // verifico que el pedido sea desde un formulario del sistema
    $token=$_POST['token'];

    if($_SESSION['token'] == $token){
      notas_eliminar($_POST);
    } 
    else {
      notas_index($textoabuscar);
    } 
  }
  elseif ( $accion == "imprimir")  
  {
    // verifico que el pedido sea desde un formulario del sistema
    $token=$_POST['token'];

    if($_SESSION['token'] == $token){
      notas_imprimir($textoabuscar);
    } 
    else {
      notas_index($textoabuscar);
    } 
  }
  elseif ( $accion == "pdf")  
  {
    // verifico que el pedido sea desde un formulario del sistema
    $token=$_POST['token'];

    if($_SESSION['token'] == $token){
      notas_pdf($textoabuscar);
    } 
    else {
      notas_index($textoabuscar);
    } 
  }

  
  function notas_index($arg_textoabuscar){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // busca las notas en la base de datos

    $notas= buscar_notas($arg_textoabuscar);
    //var_dump($notas);
    //die();

    // llama a la vista de index de notas

    include ($absolute_include."vistas/notas_roles_secundarios/index.php"); 

  }

  function notas_crear(){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // llama a la vista para crear provincias
    $anoslectivos = buscar_anoslectivos();
    $alumnos = buscar_alumnos();
    $cursos = buscar_cursos();
    $materias = buscar_materias();
    $etapas = buscar_etapas();
    //var_dump($alumnos);
    //die();

    include ($absolute_include."vistas/notas/crear.php"); 

  }


  function notas_editar($arg_notas_id){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // busca la nota en la base de datos

    $anoslectivos = buscar_anoslectivos();
    $alumnos = buscar_alumnos();
    $cursos = buscar_cursos();
    $materias = buscar_materias();
    $etapas = buscar_etapas(); 

    $nota = buscar_una_nota($arg_notas_id);
    
    //var_dump($nota);
    //die();

    include ($absolute_include."vistas/notas/editar.php"); 

  }


  function notas_mostrar($arg_notas_id){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    
    // busca el provincia en la base de datos

    $anoslectivos = buscar_anoslectivos();
    $alumnos = buscar_alumnos();
    $cursos = buscar_cursos();
    $materias = buscar_materias();
    $etapas = buscar_etapas();
    
    $nota = buscar_una_nota($arg_notas_id);
    //var_dump($alumnos);
    //die();

    include ($absolute_include."vistas/notas/mostrar.php"); 

  }


  function notas_insertar($arg_POST){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // aqui se pueden hacer validaciones de los datos que vienen
    // del formulario y devolver un error 

    
    $rela_anolectivo_id = strtoupper($arg_POST['rela_anolectivo_id']);
    $rela_curso_id = strtoupper($arg_POST['rela_curso_id']);
    $rela_materia_id = strtoupper($arg_POST['rela_materia_id']);
    $rela_alumno_id = strtoupper($arg_POST['rela_alumno_id']);
    $rela_etapaescolar_id = $arg_POST['rela_etapaescolar_id'];
    $ncalificacion = strtoupper($arg_POST['ncalificacion']);


    
    
    $ultimo_notas_id=insertar_nota($rela_anolectivo_id, $rela_curso_id, $rela_materia_id, $rela_alumno_id, $rela_etapaescolar_id, $ncalificacion);

    // llamo a la funcion en el modelo para grabar el log

    $cdescripcion_log =" Creacion de nuevos datos :".$notas_id." con ID: $ultimo_notas_id";
    insertar_log( $cdescripcion_log);

    header("Location: ".$carpeta_trabajo."/controladores/notas/controller.notas.php");    

  }


  function notas_actualizar ($arg_POST){
    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    $notas_id = $arg_POST['notas_id'];
    $rela_anolectivo_id = $arg_POST['rela_anolectivo_id'];
    $rela_curso_id = $arg_POST['rela_curso_id'];
    $rela_materia_id = $arg_POST['rela_materia_id'];
    $rela_alumno_id = $arg_POST['rela_alumno_id'];
    $rela_etapaescolar_id = $arg_POST['rela_etapaescolar_id'];
    $ncalificacion = $arg_POST['ncalificacion'];
    
    $ultimo_notas_id=actualizar_notas($notas_id, $rela_anolectivo_id, $rela_curso_id, $rela_materia_id, $rela_alumno_id, $rela_etapaescolar_id, $ncalificacion);

    // llamo a la funcion en el modelo para grabar el log

    $cdescripcion_log =" Modificacion de nuevos datos :".$notas_id." con ID: $ultimo_notas_id";
    insertar_log( $cdescripcion_log);
    
    header("Location: ".$carpeta_trabajo."/controladores/notas/controller.notas.php");    

  }

 function notas_eliminar($arg_POST){
    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    $notas_id = $arg_POST['notas_id'];
    
    $ultimo_notas_id=eliminar_notas($notas_id);

    // llamo a la funcion en el modelo para grabar el log

    $cdescripcion_log =" Elimino los datos  ".$notas_id." con ID: $ultimo_notas_id";
    insertar_log( $cdescripcion_log);


    // llama al controlador de provincias para ir al inicio
    header("Location: ".$carpeta_trabajo."/controladores/notas/controller.notas.php");

    
  }




  
  function notas_imprimir($arg_textoabuscar){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // busca las notas en la base de datos

    $notas = buscar_notas($arg_textoabuscar);

    // llama a la vista de impresion de notas

    include ($absolute_include."vistas/notas/imprimir.php"); 

    include ($absolute_include."vistas/plantillas/footer_imprimir.php"); 
 

  }

  function notas_pdf($arg_textoabuscar){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // busca las notas en la base de datos

    $notas = buscar_notas($arg_textoabuscar);

    $html2pdf = new Html2Pdf('P','A4','es','true',"UTF-8'");   // crea un nuevo objeto
    
    ob_start();   // creo un buffer en memoria que va a recoger todo lo que se deberia mostrar en pantalla
    
    include ($absolute_include."vistas/notas/imprimir_pdf.php"); 

    include ($absolute_include."vistas/plantillas/footer_pdf.php"); 
 
    $mihtml=ob_get_clean();   // guardo todo lo de buffer en una variable  
    ob_end_clean();

    $html2pdf->writeHTML($mihtml);
    $html2pdf->output('notas.pdf');

    
  }
  
  function notas_validar($arg_POST,$arg_notas_id){

    $errores = array();  // creo un array para guardar los errores
   
    $ncalificacion = strtoupper($arg_POST['ncalificacion']);

    
    // validaciones de los datos del formulario
    // verifico que no exista una nota en la tabla con el mismo nombre

    $notas=buscar_una_nota("ncalificacion LIKE '".$ncalificacion."'",$arg_notas_id);

    if ( count($notas)<>0 ){
        // existe una nota en la tabla con los mismos datos
      
      $errores['error'] ="Ya existe una nota con el Nombre :".$ncalificacion;
      $errores['notas_id'] = $arg_notas_id;
    
    }

    return $errores;
  }

  function notas_buscarcambios($arg_POST,$arg_olddata){

    $cambios = array();  // creo un array para guardar los cambios

    //$ncalificacion = strtoupper($arg_POST['ncalificacion']);
   // $rela_notas_id = $arg_POST['rela_notas_id'];

    //if (trim($) <> trim($arg_olddata['cnombre_provincia'])) {

       // $cambios[] =" Modificacion de provincia - ".$arg_olddata['cnombre_provincia']." cambio a ".$cnombre_provincia
         // ." con ID: ".$arg_olddata['provincia_id'];

    //}

   // if ($rela_pais_id <> $arg_olddata['rela_pais_id']) {

     // $pais=buscar_un_pais($rela_pais_id);
      //$cnombre_pais = $pais['cnombre_pais'];

     // $cambios[] =" Modificacion de provincia - ".$cnombre_provincia." Cambio pais de ".$arg_olddata['cnombre_pais']." a ".$cnombre_pais
       // ." con ID: ".$arg_olddata['provincia_id'];

// }
    
    return $cambios;
  }


?>