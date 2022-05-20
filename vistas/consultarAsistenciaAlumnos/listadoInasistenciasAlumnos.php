<?php 


include ($absolute_include."vistas/plantillas/head.php"); 
include ($absolute_include."vistas/plantillas/sidebar.php"); 
include ($absolute_include."vistas/plantillas/navbar.php"); 
?> 



<div id="contenedorFormConsultarAsistenciaAlumnos" class="col-md-12 col-sm-12 col-xs-12">
  <h2><ins>Historial de inasistencias del alumno:</ins> <?php echo $result_datos_alumnos[0]['capellidos_persona']. " " . $result_datos_alumnos[0]['cnombres_persona']; ?></h2>
  <?php 

  echo $result_consulta_inasistencia_alumnos[0];
  echo $result_consulta_inasistencia_alumnos[1];

  ?>
  <input type="button" class="btn-block btn btn-info" onClick="location.href='<?php echo $absolute_include ?>controladores/consultarasistenciasalumnos/controller.consultarasistenciasalumnos.php'" value="Volver Atras">

</div>


<?php 

include ($absolute_include."vistas/plantillas/footer.php"); 

?> 
