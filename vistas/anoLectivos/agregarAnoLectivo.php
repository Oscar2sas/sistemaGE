<?php

include ($absolute_include."vistas/plantillas/head.php"); 
include ($absolute_include."vistas/plantillas/sidebar.php"); 
include ($absolute_include."vistas/plantillas/navbar.php"); 

?>

<div class="col-md-12">

	<h1 class="text-center">Agregar Nuevo Año Lectivo</h1>
	<form id="formularioAnosLectivos" action="<?php echo $carpeta_trabajo;?>/controladores/anoLectivos/controller.anolectivos.php" method="POST">
		
		<input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">  
		<input type="hidden" name="accion" value="insertar">

		<div class="form-group">
			<label for="descripcionAnoLectivo">Ingrese Descripcion Año Lectivo</label>
			<input type="number" name="descripcionAnoLectivo" autofocus required class="form-control" id="descripcionAnoLectivo">
			<div id="advertenciaDescripcionAnoLectivo"></div>
		</div>
		<div class="form-group">
			<label for="fechaInicio">Ingrese Fecha Inicio de Año Lectivo</label>
			<input type="date" name="fechaInicio" required class="form-control" id="fechaInicio">
			<div id="advertenciaFechaInicioAnoLectivo"></div>

		</div>
		<div class="form-group">
			<label for="fechaFinClases">Ingrese Fecha Fin de Clases</label>
			<input type="date" required name="fechaFinClases" class="form-control" id="fechaFinClases">
			<div id="advertenciaFechaFinClases"></div>

		</div>
		<div class="form-group">
			<label for="fechaFinAnoLectivo">Ingrese Fecha Fin Año Lectivo</label>
			<input type="date" required name="fechaFinAnoLectivo" class="form-control" id="fechaFinAnoLectivo">
			<div id="advertenciasFinAnoLectivo"></div>

		</div>
		<input type="submit" id="guardarNuevoAnoLectivo" class="btn btn-success btn-block" value="Guardar Año Lectivo">
		<input type="button" class="btn btn-warning btn-block" onClick="history.back()" value="Cancelar">
	</form>
</div>

<?php

include ($absolute_include."vistas/plantillas/footer.php"); 
?>   