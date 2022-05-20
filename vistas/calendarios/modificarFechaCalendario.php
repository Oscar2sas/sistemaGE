<?php

include ($absolute_include."vistas/plantillas/head.php"); 
include ($absolute_include."vistas/plantillas/sidebar.php"); 
include ($absolute_include."vistas/plantillas/navbar.php"); 
?>

<div class="col-md-12">

	<h1 class="text-center">Modificar Fecha Calendario</h1>
	<form id="formularioFechaCalendario" action="<?php echo $carpeta_trabajo;?>/controladores/calendarios/controller.calendarios.php" method="POST">
		
		<input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">  
		<input type="hidden" name="accion" value="modificar">
		<input type="hidden" name="idFechaCalendario" value="<?php echo $result_fecha_calendario['calendario_id'] ?>">
		<div class="form-group">
			<label for="fechaCalendario">Ingrese Descripcion Fecha Calendario</label>
			<input type="date" name="fechaCalendario" autofocus id="fechaCalendario" required class="form-control" value="<?php echo $result_fecha_calendario['dfecha_calendario'] ?>">
			<div id="advertenciaFechaCalendario"></div>
		</div>
		<div class="form-group">
			<label for="descripcionFechaCalendario">Ingrese Descripcion Fecha Calendario</label>
			<input type="text" name="descripcionFechaCalendario" required class="form-control" value="<?php echo $result_fecha_calendario['cdescripcion_calendario'] ?>" id="descripcionFechaCalendario">
			<div id="advertenciaDescripcionFechaCalendario"></div>

		</div>
		<div class="form-group">
			<label for="anoLectivoActivo">Año Lectivo Activo</label>
			<input type="text" disabled name="anoLectivoActivo" class="form-control" id="anoLectivoActivo" value="<?php echo $result_fecha_calendario['ndescripcion_anolectivo'] ?>">
			<div id="advertenciaAnoLectivoActivo"></div>

		</div>
		<input type="submit" id="modificarFechaCalendario" class="btn btn-success btn-block" value="Modificar Fecha Calendario">
		<input type="button" class="btn btn-warning btn-block" onClick="history.back()" value="Cancelar">
	</form>
</div>

<?php

include ($absolute_include."vistas/plantillas/footer.php"); 
?>   