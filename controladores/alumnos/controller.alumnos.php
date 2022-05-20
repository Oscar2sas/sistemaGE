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

  include ($absolute_include."modelos/direcciones/model.direcciones.php");   // para manejar las direcciones
  include ($absolute_include."modelos/telefonos/model.telefonos.php");   // para manejar los telefonos
  include ($absolute_include."modelos/personas/model.personas.php");   // para manejar las personas
  
  include ($absolute_include."modelos/alumnos/model.alumnos.php");   // para manejar los alumnos



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
    if (isset( $_REQUEST['textoabuscar'] )) { 
      $textoabuscar=$_REQUEST['textoabuscar'];
    }  

    alumnos_index($textoabuscar);
  } 
  elseif ( $accion == "crear")  
  {
    alumnos_crear();
  }
  elseif ( $accion == "editar")  
  {

    if (isset( $_REQUEST['alumno_id'] )) { 
      $alumno_id=$_REQUEST['alumno_id'];
    }  

    alumnos_editar($alumno_id);
  }
  elseif ( $accion == "mostrar")  
  {

    if (isset( $_REQUEST['alumno_id'] )) { 
      $alumno_id=$_REQUEST['alumno_id'];
    }  

    alumnos_mostrar($alumno_id);
  }
  elseif ( $accion == "insertar")  
  {
    // verifico que el pedido sea desde un formulario del sistema
    $token=$_POST['token'];

    if($_SESSION['token'] == $token){
      alumnos_insertar($_POST);
    } 
    else {
      alumnos_index($textoabuscar);
    } 
  }
  elseif ( $accion == "actualizar")  
  {
    // verifico que el pedido sea desde un formulario del sistema
    $token=$_POST['token'];

    if($_SESSION['token'] == $token){
      alumnos_actualizar($_POST);
    } 
    else {
      alumnos_index($textoabuscar);
    } 
  }
  elseif ( $accion == "eliminar")  
  {
    // verifico que el pedido sea desde un formulario del sistema
    $token=$_POST['token'];

    if($_SESSION['token'] == $token){
      alumnos_eliminar($_POST);
    } 
    else {
      alumnos_index($textoabuscar);
    } 
  }
  elseif ( $accion == "buscar")  
  {
    alumnos_buscar_persona($_POST);
  }  
  elseif ( $accion == "imprimir")  
  {
    // verifico que el pedido sea desde un formulario del sistema
    $token=$_POST['token'];

    if($_SESSION['token'] == $token){
      alumnos_imprimir($textoabuscar);
    } 
    else {
      alumnos_index($textoabuscar);
    } 
  }
  elseif ( $accion == "pdf")  
  {
    // verifico que el pedido sea desde un formulario del sistema
    $token=$_POST['token'];

    if($_SESSION['token'] == $token){
      alumnos_pdf($textoabuscar);
    } 
    else {
      alumnos_index($textoabuscar);
    } 
  }
  
  elseif ( $accion == "creartelefono")  
  {
    alumnos_crear_telefono($_POST);
  }
  elseif ( $accion == "insertartelefono")  
  {
    // verifico que el pedido sea desde un formulario del sistema
    $token=$_POST['token'];

    if($_SESSION['token'] == $token){
      alumnos_insertar_telefono($_POST);
    } 
    else {
      alumnos_index($textoabuscar);
    } 
  }
  elseif ( $accion == "actualizartelefono")  
  {
    // verifico que el pedido sea desde un formulario del sistema
    $token=$_POST['token'];

    if($_SESSION['token'] == $token){
      alumnos_actualizar_telefono($_POST);
    } 
    else {
      alumnos_index($textoabuscar);
    } 
  }
  elseif ( $accion == "editartelefono")  
  {
    // verifico que el pedido sea desde un formulario del sistema
    $token=$_POST['token'];

    if($_SESSION['token'] == $token){
      alumnos_editar_telefono($_POST);
    } 
    else {
      alumnos_index($textoabuscar);
    } 
  }
  elseif ( $accion == "mostrartelefono")  
  {
    alumnos_mostrar_telefono($_POST);
  }
  elseif ( $accion == "eliminartelefono")  
  {
    alumnos_eliminar_telefono($_POST);
  }
  elseif ( $accion == "creardireccion")  
  {
    alumnos_crear_direccion($_POST);
  }
  elseif ( $accion == "insertardireccion")  
  {
    // verifico que el pedido sea desde un formulario del sistema
    $token=$_POST['token'];

    if($_SESSION['token'] == $token){
      alumnos_insertar_direccion($_POST);
    } 
    else {
      alumnos_index($textoabuscar);
    } 
  }
  elseif ( $accion == "actualizardireccion")  
  {
    // verifico que el pedido sea desde un formulario del sistema
    $token=$_POST['token'];

    if($_SESSION['token'] == $token){
      alumnos_actualizar_direccion($_POST);
    } 
    else {
      alumnos_index($textoabuscar);
    } 
  }
  elseif ( $accion == "editardireccion")  
  {
    // verifico que el pedido sea desde un formulario del sistema
    $token=$_POST['token'];

    if($_SESSION['token'] == $token){
      alumnos_editar_direccion($_POST);
    } 
    else {
      alumnos_index($textoabuscar);
    } 
  }
  elseif ( $accion == "mostrardireccion")  
  {
    alumnos_mostrar_direccion($_POST);
  }
  elseif ( $accion == "eliminardireccion")  
  {
    alumnos_eliminar_direccion($_POST);
  }
  


  function alumnos_index($arg_textoabuscar){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

   
    // busca las alumnos en la base de datos

    $alumnos = buscar_alumnos($arg_textoabuscar);

    // llama a la vista de index de alumnos

    include ($absolute_include."vistas/alumnos/index.php"); 

  }

  function alumnos_crear(){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // primero llama a la vista para buscar un alumno/persona en la base de datos

    include ($absolute_include."vistas/alumnos/buscaralumno.php"); 

  }

 
  function alumnos_agregar(){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];


    
    // busca todos los sexos para mostrar en un select 
    $sexos= buscar_sexos("");

    // busca las calles en el modelo de calles para el select de calles
    $calles = buscar_calles("");

    // busca los barrios en el modelo de barrios para el select de barrios
    $barrios = buscar_barrios("");
    
    // busca las localidades en el modelo de localidades para el select de localidades
    $localidades = buscar_localidades("");

    // llama a la vista para crear alumnos

    include ($absolute_include."vistas/alumnos/crear.php"); 

  }


  function alumnos_editar($arg_alumno_id){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // busca todos los sexos para mostrar en un select 
    $sexos= buscar_sexos("");

    // busca las calles en el modelo de calles para el select de calles
    $calles = buscar_calles("");

    // busca los barrios en el modelo de barrios para el select de barrios
    $barrios = buscar_barrios("");
    
    // busca las localidades en el modelo de localidades para el select de localidades
    $localidades = buscar_localidades("");

    // busca la alumno en la base de datos
    $alumno = buscar_una_alumno($arg_alumno_id);

    // busca las direcciones de la alumno en la base de datos
    $direcciones=buscar_direcciones_de_una_alumno($arg_alumno_id);
 
    // busca los telefonos de la alumno en la base de datos
    $telefonos=buscar_telefonos_de_una_alumno($arg_alumno_id);


    // llama a la vista para editar alumnos

    include ($absolute_include."vistas/alumnos/editar.php"); 

  }


  function alumnos_mostrar($arg_alumno_id){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

     // busca el alumno en la base de datos
     $alumno = buscar_un_alumno($arg_alumno_id);
   
     // busca la persona con los otros datos en la base de datos
     $alumno_datospersonales = buscar_una_persona($alumno['rela_persona_id']);

    // busca las direcciones de la persona en la base de datos
    $alumno_direcciones=buscar_direcciones_de_una_persona($alumno['rela_persona_id']);
    
    // busca los telefonos de la persona en la base de datos
    $alumno_telefonos=buscar_telefonos_de_una_persona($alumno['rela_persona_id']);

  
    // llama a la vista para mostrar alumnos

    include ($absolute_include."vistas/alumnos/mostrar.php"); 

  }


  function alumnos_insertar($arg_POST){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // validaciones de los datos del formulario
   
    $validacion_errores = array();   // array que contiene los errores de validacion
   
    $validacion_errores = alumnos_validar($arg_POST,0);   // le paso a la funcion de validacion todos los datos
                                                       // del formulario 

    if ( count($validacion_errores)<>0 ){

        // si hay errores
        // llama a la vista para mostrar ERRORES

        include ($absolute_include."vistas/alumnos/errores.php"); 
    }
    else {

        // si no hay errores
        // controlo los contenidos de los campos

        // datos basicos
        $capellidos_alumno = strtoupper($arg_POST['capellidos_alumno']);
        $cnombres_alumno = strtoupper($arg_POST['cnombres_alumno']);
        $ndni_alumno = $arg_POST['ndni_alumno'];
        $ncuil_alumno = $arg_POST['ncuil_alumno'];
        $cemail_alumno = strtolower($arg_POST['cemail_alumno']);
        $dfechanac_alumno = $arg_POST['dfechanac_alumno'];
        $rela_sexo_id =$arg_POST['rela_sexo_id'];

        //direcciones
        $cdescripcion_direccion = strtoupper($arg_POST['cdescripcion_direccion']);
        $cmanzana_direccion = $arg_POST['cmanzana_direccion'];
        $nnumero_direccion = $arg_POST['nnumero_direccion'];
        $cparcela_direccion = $arg_POST['cparcela_direccion'];
        $csector_direccion = strtoupper($arg_POST['csector_direccion']);
        $ccasa_direccion = $arg_POST['ccasa_direccion'];
        $clote_direccion = $arg_POST['clote_direccion'];
        $rela_calle_id =$arg_POST['rela_calle_id'];
        $rela_barrio_id =$arg_POST['rela_barrio_id'];
        $rela_localidad_id =$arg_POST['rela_localidad_id'];

        //telefonos
        $ntipo_telefono = $arg_POST['ntipo_telefono'];
        $cnumero_telefono = $arg_POST['cnumero_telefono'];


        // llamo a la funcion en el modelo para grabar una alumno
        $ultima_alumno_id=insertar_alumno($capellidos_alumno,$cnombres_alumno,$ndni_alumno,$ncuil_alumno,$cemail_alumno,$dfechanac_alumno,$rela_sexo_id);

        // llamo a la funcion en el modelo para grabar una direccion
        $ultima_direccion_id=insertar_direccion($cdescripcion_direccion,$cmanzana_direccion,$csector_direccion,$ccasa_direccion,$clote_direccion,$cparcela_direccion,$nnumero_direccion,$ultima_alumno_id,$rela_calle_id,$rela_barrio_id,$rela_localidad_id );

        // llamo a la funcion en el modelo para grabar una direccion
        $ultimo_telefono_id=insertar_telefono($ntipo_telefono,$cnumero_telefono,$ultima_alumno_id);

        // llamo a la funcion en el modelo para grabar el log

        $cdescripcion_log =" Creacion de alumno : ".$capellidos_alumno." ".$cnombres_alumno." con ID: $ultima_alumno_id";
        insertar_log( $cdescripcion_log);

        // llama al controlador de alumnos para ir al inicio
        header("Location: ".$carpeta_trabajo."/controladores/alumnos/controller.alumnos.php");
    }    

  }


  function alumnos_actualizar($arg_POST){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // cuando estoy actualizando debo guardar los datos viejos para saber si hay cambios
    // busca el alumno en la base de datos para guardar los datos viejos

    $alumno_olddata = buscar_una_alumno($arg_POST['alumno_id']);

   
    // validaciones de los datos del formulario
    $validacion_errores = array();   // array que contiene los errores de validacion
      
    $validacion_errores = alumnos_validar($arg_POST,$arg_POST['alumno_id']);   // le paso a la funcion de validacion todos los datos
                                                                            // del formulario 

    if ( count($validacion_errores)<>0 ){

        // si hay errores
        // llama a la vista para mostrar ERRORES

        include ($absolute_include."vistas/alumnos/errores.php"); 
    }
    else {

        // si no hay errores
        
        // controlo si hay cambios en los datos

        $validacion_cambios = array();   // array que contiene los cambios

        $validacion_cambios = alumnos_buscarcambios($arg_POST, $alumno_olddata);
        
        if ( count($validacion_cambios)<>0 ){   // si no hay cambios realmente
        
          // controlo los contenidos de los campos

          $alumno_id=$arg_POST['alumno_id'];
          $capellidos_alumno = strtoupper($arg_POST['capellidos_alumno']);
          $cnombres_alumno = strtoupper($arg_POST['cnombres_alumno']);
          $ndni_alumno = $arg_POST['ndni_alumno'];
          $ncuil_alumno = $arg_POST['ncuil_alumno'];
          $cemail_alumno = strtolower($arg_POST['cemail_alumno']);
          $dfechanac_alumno = $arg_POST['dfechanac_alumno'];
          $rela_sexo_id =$arg_POST['rela_sexo_id'];

          // llamo a la funcion en el modelo para actualizar una alumno
          actualizar_alumno($alumno_id,$capellidos_alumno,$cnombres_alumno,$ndni_alumno,$ncuil_alumno,$cemail_alumno,$dfechanac_alumno,$rela_sexo_id);

          // llamo a la funcion en el modelo para grabar el log
         
          $cdescripcion_log ="";

          foreach ($validacion_cambios as $validacion_cambio) {

             $cdescripcion_log = $cdescripcion_log .$validacion_cambio. PHP_EOL ;
          }

          insertar_log( $cdescripcion_log);


          // llama al controlador de alumnos para ir al inicio
          header("Location: ".$carpeta_trabajo."/controladores/alumnos/controller.alumnos.php");
        }  
    }
    
  }

  function alumnos_eliminar($arg_POST){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // cuando estoy eliminando debo guardar los datos viejos para el log
    // busca el alumno en la base de datos para guardar los datos viejos

    $alumno_olddata = buscar_una_alumno($arg_POST['alumno_id']);

    $alumno_id=$arg_POST['alumno_id'];
   
    // antes de eliminar una alumno debo primero eliminar 
    // los registros de las tablas relacionadas
    // en este caso telefonos y direcciones
    
    // elimino las direcciones de una alumno modelo direcciones
    eliminar_direcciones_de_una_alumno($alumno_id);

    // elimino los telefonos de una alumno modelo telefonos
     eliminar_telefonos_de_una_alumno($alumno_id);

    // llamo a la funcion en el modelo para eliminar un alumno
    eliminar_alumno($alumno_id);


    // llamo a la funcion en el modelo para grabar el log

    $cdescripcion_log =" Elimino la alumno  ".$alumno_olddata['capellidos_alumno']." ".$alumno_olddata['cnombres_alumno']." con ID: $alumno_id";
    insertar_log( $cdescripcion_log);


    // llama al controlador de alumnos para ir al inicio
    header("Location: ".$carpeta_trabajo."/controladores/alumnos/controller.alumnos.php");

    
  }
  
  function alumnos_imprimir($arg_textoabuscar){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // busca los alumnos en la base de datos

    $alumnos = buscar_alumnos($arg_textoabuscar);

    // llama a la vista de impresion de alumnos

    include ($absolute_include."vistas/alumnos/imprimir.php"); 

    include ($absolute_include."vistas/plantillas/footer_imprimir.php"); 
 

  }

  function alumnos_pdf($arg_textoabuscar){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // busca los alumnos en la base de datos

    $alumnos = buscar_alumnos($arg_textoabuscar);

    $html2pdf = new Html2Pdf('P','A4','es','true',"UTF-8'");   // crea un nuevo objeto
    
    ob_start();   // creo un buffer en memoria que va a recoger todo lo que se deberia mostrar en pantalla
    
    include ($absolute_include."vistas/alumnos/imprimir_pdf.php"); 

    include ($absolute_include."vistas/plantillas/footer_pdf.php"); 
 
    $mihtml=ob_get_clean();   // guardo todo lo de buffer en una variable  
    ob_end_clean();

    $html2pdf->writeHTML($mihtml);
    $html2pdf->output('alumnos.pdf');

    
  }
  
  function alumnos_validar($arg_POST,$arg_alumno_id){

    $errores = array();  // creo un array para guardar los errores
   
    $ndni_alumno = $arg_POST['ndni_alumno'];
    $ncuil_alumno = $arg_POST['ncuil_alumno'];
   
    // VALIDACIONES
    // verifico que no exista un alumno en la tabla con el mismo DNI O CUIL

    $alumno=buscar_una_alumno_por($ndni_alumno,$ncuil_alumno,$arg_alumno_id);

    if ( count($alumno)<>0 ){
        // existe un alumno en la tabla con los mismos datos

        if($ndni_alumno == $alumno['ndni_alumno']){
            $errores['error'] ="Ya existe una alumno con el DNI : ".$ndni_alumno;
        } elseif ($ncuil_alumno == $alumno['ncuil_alumno']){
            $errores['error'] ="Ya existe una alumno con el CUIL/CUIT : ".$ncuil_alumno;
        } else {
            $errores['error'] ="Ya existe una alumno con los mismos Datos ";
        }
   
    }

    // otras validaciones de los datos del formulario

    //tamaño del dni y del cuil/cuit
    if (strlen(strval($ndni_alumno))<8 OR strlen(strval($ndni_alumno))>10){
      $errores['error'] ="El DNI no parece Valido : ".$ndni_alumno;
    }
    
    if (strlen(strval($ncuil_alumno))<11 OR strlen(strval($ncuil_alumno))>15){
      $errores['error'] ="El CUIL/CUIT no parece Valido : ".$ncuil_alumno;
    }
    
    if ( count($errores)<>0 ){
      $errores['alumno_id'] = $arg_alumno_id;
    }
    
    return $errores;
  }

  function alumnos_buscarcambios($arg_POST,$arg_olddata){

    $cambios = array();  // creo un array para guardar los cambios

    $capellidos_alumno = strtoupper($arg_POST['capellidos_alumno']);
    $cnombres_alumno = strtoupper($arg_POST['cnombres_alumno']);
    $ndni_alumno = $arg_POST['ndni_alumno'];
    $ncuil_alumno = $arg_POST['ncuil_alumno'];
    $cemail_alumno = strtolower($arg_POST['cemail_alumno']);
    $dfechanac_alumno = $arg_POST['dfechanac_alumno'];
    $rela_sexo_id =$arg_POST['rela_sexo_id'];

    

    if ((trim($cnombres_alumno) <> trim($arg_olddata['cnombres_alumno'])) OR (trim($capellidos_alumno) <> trim($arg_olddata['capellidos_alumno']))) {

        $cambios[] =" Modificacion de alumno - ".$arg_olddata['capellidos_alumno']." ".$arg_olddata['cnombres_alumno']." cambio a ".$capellidos_alumno." ".$cnombres_alumno
          ." con ID: ".$arg_olddata['alumno_id'];

    }

    if ($ndni_alumno <> $arg_olddata['ndni_alumno']) {

        $cambios[] =" Modificacion de alumno - ".$capellidos_alumno." ".$cnombres_alumno." DNI ".$arg_olddata['ndni_alumno']." cambio a ".$ndni_alumno
          ." con ID: ".$arg_olddata['alumno_id'];

    }

    if ($ncuil_alumno <> $arg_olddata['ncuil_alumno']) {

        $cambios[] =" Modificacion de alumno - ".$capellidos_alumno." ".$cnombres_alumno." CUIL/CUIT ".$arg_olddata['ncuil_alumno']." cambio a ".$ncuil_alumno
          ." con ID: ".$arg_olddata['alumno_id'];

    }

    if ($cemail_alumno <> $arg_olddata['cemail_alumno']) {

        $cambios[] =" Modificacion de alumno - ".$capellidos_alumno." ".$cnombres_alumno." EMAIL ".$arg_olddata['cemail_alumno']." cambio a ".$cemail_alumno
          ." con ID: ".$arg_olddata['alumno_id'];

    }
    
    if ($dfechanac_alumno <> $arg_olddata['dfechanac_alumno']) {

      $cambios[] =" Modificacion de alumno - ".$capellidos_alumno." ".$cnombres_alumno." Fec.Nac ".$arg_olddata['dfechanac_alumno']." cambio a ".$dfechanac_alumno
        ." con ID: ".$arg_olddata['alumno_id'];

  }
    return $cambios;
  }

  
  //
  // funciones para personas
  //
   function alumnos_buscar_persona(){

        $absolute_include = $GLOBALS['absolute_include'];
        $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

       
        // verifico si busco por dni/ cuil o por nombre

        if (isset($_POST['buscapordniocuil'])) {

            // verifico que haya metido un dni
        }
        else{
            // verifico que busca por nombre

        }


        // primero llama a la vista para buscar un alumno/persona en la base de datos

        include ($absolute_include."vistas/alumnos/buscaralumno.php"); 

   }


  
  //
  // funciones para direcciones
  //
  function alumnos_crear_direccion($arg_POST){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // busca las calles en el modelo de calles para el select de calles
    $calles = buscar_calles("");

    // busca los barrios en el modelo de barrios para el select de barrios
    $barrios = buscar_barrios("");
    
    // busca las localidades en el modelo de localidades para el select de localidades
    $localidades = buscar_localidades("");

    $alumno = buscar_una_alumno($arg_POST['alumno_id']);

    // llama a la vista para crear direcciones de las alumnos

    include ($absolute_include."vistas/direcciones/crear.php"); 

  }

  function alumnos_editar_direccion($arg_POST){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];


    // busca las calles en el modelo de calles para el select de calles
    $calles = buscar_calles("");

    // busca los barrios en el modelo de barrios para el select de barrios
    $barrios = buscar_barrios("");
    
    // busca las localidades en el modelo de localidades para el select de localidades
    $localidades = buscar_localidades("");

    // busca la direccion de la alumno en la base de datos
    
    $direccion = buscar_una_direccion($arg_POST['direccion_id']);

    // llama a la vista para editar direcciones de alumnos

    include ($absolute_include."vistas/direcciones/editar.php"); 

  }

  function alumnos_insertar_direccion($arg_POST){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // validaciones de los datos del formulario
   
    $validacion_errores_direcciones = array();   // array que contiene los errores de validacion
   
    //$validacion_errores_direcciones = direcciones_validar($arg_POST,0);   // le paso a la funcion de validacion todos los datos
                                                       // del formulario 

    if ( count($validacion_errores_direcciones)<>0 ){

        // si hay errores
        // llama a la vista para mostrar ERRORES

        include ($absolute_include."vistas/alumnos/errores.php"); 
    }
    else {

        // si no hay errores
        // controlo los contenidos de los campos

        $alumno_id=$arg_POST['alumno_id'];
     
        //direcciones
        $cdescripcion_direccion = strtoupper($arg_POST['cdescripcion_direccion']);
        $cmanzana_direccion = $arg_POST['cmanzana_direccion'];
        $nnumero_direccion = $arg_POST['nnumero_direccion'];
        $cparcela_direccion = $arg_POST['cparcela_direccion'];
        $csector_direccion = strtoupper($arg_POST['csector_direccion']);
        $ccasa_direccion = $arg_POST['ccasa_direccion'];
        $clote_direccion = $arg_POST['clote_direccion'];
        $rela_calle_id =$arg_POST['rela_calle_id'];
        $rela_barrio_id =$arg_POST['rela_barrio_id'];
        $rela_localidad_id =$arg_POST['rela_localidad_id'];
        $capellidos_alumno= $arg_POST['capellidos_alumno'];
        $cnombres_alumno= $arg_POST['cnombres_alumno'];


        // llamo a la funcion en el modelo para grabar una direccion
        $ultima_direccion_id=insertar_direccion($cdescripcion_direccion,$cmanzana_direccion,$csector_direccion,$ccasa_direccion,$clote_direccion,$cparcela_direccion,$nnumero_direccion,$alumno_id,$rela_calle_id,$rela_barrio_id,$rela_localidad_id );

        // llamo a la funcion en el modelo para grabar el log

        $cdescripcion_log =" Creacion de Direccion de alumno : ".$capellidos_alumno." ".$cnombres_alumno." con ID: $alumno_id // Direccion :". $cdescripcion_direccion;
        insertar_log( $cdescripcion_log);

        // llama a la vista para volver a editar alumnos

        include ($absolute_include."vistas/alumnos/volveraeditar.php"); 
     
    }    

  }

  function alumnos_actualizar_direccion($arg_POST){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // cuando estoy actualizando debo guardar los datos viejos para saber si hay cambios
    // busca la alumno en la base de datos para guardar los datos viejos

    $direccion_olddata = buscar_una_direccion($arg_POST['direccion_id']);
    
    // validaciones de los datos del formulario
    $validacion_errores_direcciones = array();   // array que contiene los errores de validacion
      
    if ( count($validacion_errores_direcciones)<>0 ){

        // si hay errores
        // llama a la vista para mostrar ERRORES

        include ($absolute_include."vistas/alumnos/errores.php"); 
    }
    else {

        // si no hay errores
        
        // controlo si hay cambios en los datos

        $validacion_cambios_direcciones = array();   // array que contiene los cambios

        $validacion_cambios_direcciones = alumnos_buscarcambios_direcciones($arg_POST, $direccion_olddata);
        
        if ( count($validacion_cambios_direcciones)<>0 ){   // si no hay cambios realmente
        
        // si no hay errores
        // controlo los contenidos de los campos

        $alumno_id=$arg_POST['alumno_id'];
     
        //direcciones
        $direccion_id =$arg_POST['direccion_id'];
        $cdescripcion_direccion = strtoupper($arg_POST['cdescripcion_direccion']);
        $cmanzana_direccion = $arg_POST['cmanzana_direccion'];
        $nnumero_direccion = $arg_POST['nnumero_direccion'];
        $cparcela_direccion = $arg_POST['cparcela_direccion'];
        $csector_direccion = strtoupper($arg_POST['csector_direccion']);
        $ccasa_direccion = $arg_POST['ccasa_direccion'];
        $clote_direccion = $arg_POST['clote_direccion'];
        $rela_calle_id =$arg_POST['rela_calle_id'];
        $rela_barrio_id =$arg_POST['rela_barrio_id'];
        $rela_localidad_id =$arg_POST['rela_localidad_id'];
        $capellidos_alumno= $arg_POST['capellidos_alumno'];
        $cnombres_alumno= $arg_POST['cnombres_alumno'];

        // llamo a la funcion en el modelo para actualizar una direccion
        actualizar_direccion($direccion_id,$cdescripcion_direccion,$cmanzana_direccion,$csector_direccion,$ccasa_direccion,$clote_direccion,$cparcela_direccion,$nnumero_direccion,$alumno_id,$rela_calle_id,$rela_barrio_id,$rela_localidad_id );

          // llamo a la funcion en el modelo para grabar el log
         
          $cdescripcion_log ="";

          foreach ($validacion_cambios_direcciones as $validacion_cambio) {

             $cdescripcion_log = $cdescripcion_log .$validacion_cambio. PHP_EOL ;
          }

          insertar_log( $cdescripcion_log);


        // llama a la vista para volver a editar alumnos

        include ($absolute_include."vistas/alumnos/volveraeditar.php"); 
        }  
    }
    
  }


  function alumnos_mostrar_direccion($arg_POST){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    $direccion = buscar_una_direccion($arg_POST['direccion_id']);

    // llama a la vista para mostrar direcciones de las alumnos

    include ($absolute_include."vistas/direcciones/mostrar.php"); 

  }


  function alumnos_eliminar_direccion($arg_POST){
    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

     $alumno_id=$arg_POST['alumno_id'];
     
     $direccion_id=$arg_POST['direccion_id'];
     $cdescripcion_direccion = $arg_POST['cdescripcion_direccion'];
     $capellidos_alumno= $arg_POST['capellidos_alumno'];
     $cnombres_alumno= $arg_POST['cnombres_alumno'];

    // llamo a la funcion en el modelo para eliminar una direccion
    eliminar_direccion($direccion_id);


    // llamo a la funcion en el modelo para grabar el log

    $cdescripcion_log =" Eliminacion de Direccion de alumno : ".$capellidos_alumno." ".$cnombres_alumno." con ID: $alumno_id // Direccion :". $cdescripcion_direccion;
    insertar_log( $cdescripcion_log);

    // llama a la vista para volver a editar alumnos

    include ($absolute_include."vistas/alumnos/volveraeditar.php"); 
    
  }

  function alumnos_buscarcambios_direcciones($arg_POST,$arg_olddata){

    $cambios = array();  // creo un array para guardar los cambios

    $old_direccion=trim(strtoupper($arg_olddata['cdescripcion_direccion']))." "
      ."Numero: ".trim(strval($arg_olddata['nnumero_direccion']))." "
      ."Manzana: ".trim($arg_olddata['cmanzana_direccion'])." "
      ."Casa: ".trim($arg_olddata['ccasa_direccion'])." "
      ."Parcela: ".trim($arg_olddata['cparcela_direccion'])." "
      ."Sector: ".trim($arg_olddata['csector_direccion'])." "
      ."Lote: ".trim($arg_olddata['clote_direccion'])." "
      ."Calle: ".trim(strval($arg_olddata['rela_calle_id']))." "
      ."Barrio: ".trim(strval($arg_olddata['rela_barrio_id']))." "
      ."Localidad: ".trim(strval($arg_olddata['rela_localidad_id']));

    $direccion=trim(strtoupper($arg_POST['cdescripcion_direccion']))." "
      ."Numero: ".trim(strval($arg_POST['nnumero_direccion']))." "
      ."Manzana: ".trim($arg_POST['cmanzana_direccion'])." "
      ."Casa: ".trim($arg_POST['ccasa_direccion'])." "
      ."Parcela: ".trim($arg_POST['cparcela_direccion'])." "
      ."Sector: ".trim($arg_POST['csector_direccion'])." "
      ."Lote: ".trim($arg_POST['clote_direccion'])." "
      ."Calle: ".trim(strval($arg_POST['rela_calle_id']))." "
      ."Barrio: ".trim(strval($arg_POST['rela_barrio_id']))." "
      ."Localidad: ".trim(strval($arg_POST['rela_localidad_id']));

    if ($old_direccion <> $direccion) {
        
        $cambios[] =" Modificacion de Persona - ". $arg_olddata['capellidos_alumno']." ".$arg_olddata['cnombres_alumno']." cambio direccion de ".$old_direccion." a ".$direccion
          ." con ID: ".$arg_olddata['rela_alumno_id'];

    }

    return $cambios;
  }



  //
  // funciones para telefonos
  //

  function alumnos_crear_telefono($arg_POST){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    $alumno = buscar_una_alumno($arg_POST['alumno_id']);

    // llama a la vista para crear telefonos de las alumnos

    include ($absolute_include."vistas/telefonos/crear.php"); 

  }

  function alumnos_insertar_telefono($arg_POST){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // validaciones de los datos del formulario
   
    $validacion_errores_telefonos = array();   // array que contiene los errores de validacion
   
    //$validacion_errores_telefonos = telefonos_validar($arg_POST,0);   // le paso a la funcion de validacion todos los datos
                                                       // del formulario 

    if ( count($validacion_errores_telefonos)<>0 ){

        // si hay errores
        // llama a la vista para mostrar ERRORES

        include ($absolute_include."vistas/alumnos/errores.php"); 
    }
    else {

        // si no hay errores
        // controlo los contenidos de los campos

        $alumno_id=$arg_POST['alumno_id'];
     
        //telefonos
        $ntipo_telefono = $arg_POST['ntipo_telefono'];
        $cnumero_telefono = $arg_POST['cnumero_telefono'];
        $capellidos_alumno= $arg_POST['capellidos_alumno'];
        $cnombres_alumno= $arg_POST['cnombres_alumno'];

        // llamo a la funcion en el modelo para grabar una direccion
        $ultimo_telefono_id=insertar_telefono($ntipo_telefono,$cnumero_telefono,$alumno_id);

        // llamo a la funcion en el modelo para grabar el log

        $cdescripcion_log =" Creacion de Telefono de alumno : ".$capellidos_alumno." ".$cnombres_alumno." con ID: $alumno_id // Telefono :". $cnumero_telefono;
        insertar_log( $cdescripcion_log);

        // llama a la vista para volver a editar alumnos

        include ($absolute_include."vistas/alumnos/volveraeditar.php"); 
     
    }    

  }
  
  function alumnos_actualizar_telefono($arg_POST){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    // cuando estoy actualizando debo guardar los datos viejos para saber si hay cambios
    // busca la alumno en la base de datos para guardar los datos viejos

    $telefono_olddata = buscar_un_telefono($arg_POST['telefono_id']);
    
    // validaciones de los datos del formulario
    $validacion_errores_telefonos = array();   // array que contiene los errores de validacion
      
    if ( count($validacion_errores_telefonos)<>0 ){

        // si hay errores
        // llama a la vista para mostrar ERRORES

        include ($absolute_include."vistas/alumnos/errores.php"); 
    }
    else {

        // si no hay errores
        
        // controlo si hay cambios en los datos

        $validacion_cambios_telefonos = array();   // array que contiene los cambios

        $validacion_cambios_telefonos = alumnos_buscarcambios_telefonos($arg_POST, $telefono_olddata);
        
        if ( count($validacion_cambios_telefonos)<>0 ){   // si no hay cambios realmente
        
          // controlo los contenidos de los campos

          $telefono_id=$arg_POST['telefono_id'];
          $ntipo_telefono = $arg_POST['ntipo_telefono'];
          $cnumero_telefono = $arg_POST['cnumero_telefono'];
          $alumno_id =  $telefono_olddata['rela_alumno_id'];


          // llamo a la funcion en el modelo para actualizar un telefono
          actualizar_telefono($telefono_id,$ntipo_telefono,$cnumero_telefono);

          // llamo a la funcion en el modelo para grabar el log
         
          $cdescripcion_log ="";

          foreach ($validacion_cambios_telefonos as $validacion_cambio) {

             $cdescripcion_log = $cdescripcion_log .$validacion_cambio. PHP_EOL ;
          }

          insertar_log( $cdescripcion_log);


        // llama a la vista para volver a editar alumnos

        include ($absolute_include."vistas/alumnos/volveraeditar.php"); 
        }  
    }
    
  }

  function alumnos_editar_telefono($arg_POST){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    $telefono = buscar_un_telefono($arg_POST['telefono_id']);

    // llama a la vista para editar telefonos de las alumnos

    include ($absolute_include."vistas/telefonos/editar.php"); 

  }

  function alumnos_mostrar_telefono($arg_POST){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    $telefono = buscar_un_telefono($arg_POST['telefono_id']);

    // llama a la vista para mostrar telefonos de las alumnos

    include ($absolute_include."vistas/telefonos/mostrar.php"); 

  }


  function alumnos_eliminar_telefono($arg_POST){

    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

     $alumno_id=$arg_POST['alumno_id'];
     
     $telefono_id=$arg_POST['telefono_id'];
     $cnumero_telefono = $arg_POST['cnumero_telefono'];
     $capellidos_alumno= $arg_POST['capellidos_alumno'];
     $cnombres_alumno= $arg_POST['cnombres_alumno'];

    // llamo a la funcion en el modelo para eliminar un telefono
    eliminar_telefono($telefono_id);


    // llamo a la funcion en el modelo para grabar el log

    $cdescripcion_log =" Eliminacion de Telefono de alumno : ".$capellidos_alumno." ".$cnombres_alumno." con ID: $alumno_id // Telefono :". $cnumero_telefono;
    insertar_log( $cdescripcion_log);

    // llama a la vista para volver a editar alumnos

    include ($absolute_include."vistas/alumnos/volveraeditar.php"); 
    
  }


  function alumnos_buscarcambios_telefonos($arg_POST,$arg_olddata){

    $cambios = array();  // creo un array para guardar los cambios

    $ntipo_telefono = strtoupper($arg_POST['ntipo_telefono']);
    $cnumero_telefono = strtoupper($arg_POST['cnumero_telefono']);
    

    if ($ntipo_telefono <> $arg_olddata['ntipo_telefono']) {
        
        if( $ntipo_telefono== 1) { 
          $tipo= "Celular/Movil";
        }
        elseif ($ntipo_telefono== 2) 
        { $tipo= "Teléfono Fijo";
        }
        else { 
          $tipo="Otros";
        } 

        $cambios[] =" Modificacion de Persona - ". $arg_olddata['capellidos_alumno']." ".$arg_olddata['cnombres_alumno']." cambio tipo telefono a ".$tipo." ".$cnumero_telefono
          ." con ID: ".$arg_olddata['rela_alumno_id'];

    }

    if ($cnumero_telefono <> $arg_olddata['cnumero_telefono']) {

      $cambios[] =" Modificacion de Persona - ". $arg_olddata['capellidos_alumno']." ".$arg_olddata['cnombres_alumno']." cambio numero de telefono ".arg_olddata['cnumero_telefono']." a ".$cnumero_telefono
        ." con ID: ".$arg_olddata['rela_alumno_id'];

    }

    return $cambios;
  }


?>