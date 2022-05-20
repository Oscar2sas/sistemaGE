<?php 


include ($absolute_include."vistas/plantillas/head.php"); 
include ($absolute_include."vistas/plantillas/sidebar.php"); 
include ($absolute_include."vistas/plantillas/navbar.php"); 
include ($absolute_include."vistas/plantillas/tabHeadAsistencias.php"); 

?> 



	<h1 class="text-dark">Error, no puede tomar asistencia hoy, por favor verifique el 
		<a clas="btn btn-warning" href="<?php echo $carpeta_trabajo ?>/controladores/calendarios/controller.calendarios.php">calendario de fechas!</a>
	</h1>




<?php 

include ($absolute_include."vistas/plantillas/footer.php"); 

?> 
