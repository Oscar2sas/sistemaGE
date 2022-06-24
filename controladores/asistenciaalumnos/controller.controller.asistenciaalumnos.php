<?php 

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
    include ($absolute_include."vistas/plantillas/head.php"); 

    include ($absolute_include."vistas/plantillas/sidebar.php"); 

    include ($absolute_include."vistas/plantillas/navbar.php"); 

    include ($absolute_include."vistas/plantillas/tabHeadAsistencias.php"); 

    include ($absolute_include."clases/class.conexion.php"); //conexion con la base de datos

    include($absolute_include."controladores/asistenciaalumnos/funciones.controladores.asistenciaalumnos.php"); //separe las funciones del controlador 

    include($absolute_include."modelos/cursosHorarios/model.cursoshorarios.php");//modelo de cursos horarios

    include ($absolute_include."modelos/asistenciaAlumnos/model.asistenciaalumnos.php");//modelo de asistencia

    include ($absolute_include."modelos/alumnos/model.alumnos.php");   // se incluye el modelo de alumnos

    include ($absolute_include."modelos/preceptor/model.preceptor.php");

    include ($absolute_include."modelos/reincorporacionesAlumnos/model.reincorporacionesalumnos.php");

    function buscarCursos(){

        $idAsistenciasAlumnos = array();
        $idAlumnosAsistenciaTardanza = array();
        
        //cargamos todos los valores en sus respectivas variables
        $idSituacionDia = $_POST["situacionDelDia"];
        $idAnoLectivo = $_POST["cicloLectivo"];
        $fechaAsistencia = $_POST["fechaAsistencia"];
        $idCursos = $_POST["curso"];
        $idTrayectos = $_POST["trayectos"];
        
       //verifica si se puede tomar asistencia o no
       if(!verificarFecha($fechaAsistencia)){
            
       }

       //verifica si curso o trayecto esta vacio, si esta vacio lo envia al formulario
       if($idCursos == 0 || $idTrayectos == 0){header("Location: ".$_SERVER['HTTP_REFERER']."");}

       //si no esta vacio crea un array
       $datosParamentros = array();

       //Las variables que se creo anteriormente se lo introduce en el array datosParametros
       array_push($datosParamentros,$idSituacionDia);
       array_push($datosParamentros,$idAnoLectivo);
       array_push($datosParamentros,$fechaAsistencia);
       array_push($datosParamentros,$idCursos);
       array_push($datosParamentros,$idTrayectos);

       //Y por ultimo se lo introduce en una funcion
		   verificarFechaHorariosAsistencias($datosParamentros);
       
    }

    function verificarFechaHorariosAsistencias($argsDatosParametros){
       $resultado = verificar_horarios_curso($argsDatosParametros);
      
       try {
          if ($resultado){
            echo "<h1>El curso seleccionado no tiene clases hoy, por favor verifique el trayecto o la fecha!</h1>";
          }
          elseif ($resultado === "Curso no posee aun horarios, verifique!") {
          echo "<h1>".$resultado."</h1>";
          }

          obtener_Alumnos_Curso($argsDatosParametros);



       } catch (\Throwable $th) {
          echo $th;
       }
       


    }
              

    function verificarFecha($argFecha){
      $idAnoLectivo = $_POST["cicloLectivo"];

      $anoLectivo =  obtenerAnolectivo($idAnoLectivo);

      foreach($anoLectivo as $que){

      $fecha = substr($argFecha,0,4);

        if(empty($argFecha)){
         echo "<h1>No debe de dejar la fecha vacia</h1>";
        }
        if($fecha != $que ){
         echo "<h1>Fecha asistencia no coincide con el año lectivo, por favor verifique!</h1>";
        }
      }
    }


    if(isset($_POST["ayuda"])){
        buscarCursos();
    }

    


?>