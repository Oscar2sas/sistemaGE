<?php 


include ($absolute_include."vistas/plantillas/head.php"); 
include ($absolute_include."vistas/plantillas/sidebar.php"); 
include ($absolute_include."vistas/plantillas/navbar.php"); 
include ($absolute_include."vistas/plantillas/tabHeadOpcionesDocentes.php"); 


?> 



	<h1 class="text-dark">Error, no puede tomar asistencia hoy, por por motivo de: <?php echo $resultFechaCalendario['cdescripcion_calendario']; ?>
	</h1>




<?php 

include ($absolute_include."vistas/plantillas/footer.php"); 

?> 
