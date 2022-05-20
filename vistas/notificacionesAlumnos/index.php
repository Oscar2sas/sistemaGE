<?php 


include ($absolute_include."vistas/plantillas/head.php"); 
include ($absolute_include."vistas/plantillas/sidebar.php"); 
include ($absolute_include."vistas/plantillas/navbar.php"); 
include ($absolute_include."vistas/plantillas/tabHeadAsistencias.php"); 

?> 



<div id="contenedorFormNotificacionesAlumnos" class="col-md-12 col-sm-12 col-xs-12">

	<!-- Titulos de la pantalla -->
	<div class="text-center">
		<h3>Notificaciones Alumnos</h3>
	</div>

	<div class="form-group">
		<label for="cicloLectivoNotificacionesAllumnos">Seleccione Año Lectivo</label>
		<select class="form-control" id="cicloLectivoNotificacionesAllumnos">
			<option value="<?php echo $resultAnoLectivoActivo['anolectivo_id']; ?>" selected><?php echo $resultAnoLectivoActivo['ndescripcion_anolectivo']; ?></option>
		</select>
	</div>


	<div class="form-group">
		<label for="cursosNotificaionesAlumnos">Seleccione Curso</label>
		<select class="form-control" name="curso" id="cursosNotificaionesAlumnos">
			<option selected disabled value="0">Elija un Curso:</option>
			<?php foreach ($resultCursos as $rowCursos): ?>
				<option value="<?php echo $rowCursos['curso_id'] ?>"><?php echo $rowCursos['cdescripcion_curso']; ?></option>
			<?php endforeach; ?>
		</select>
	</div>

	<div class="form-group">
		<label for="descripcionMensajeNotificacionAlumnos">Escriba Su Mensaje</label>
		<textarea class="form-control" id="descripcionMensajeNotificacionAlumnos" rows="3"></textarea>
	</div>

	<div class="form-group">
		<input type="button" name="enviarNotificacionAlumnos" id="enviarNotificacionAlumnos" class="btn btn-success float-right" value="Enviar Notificacion">
	</div>
	<br><br>
	<div class="row col-md-12 form-group" id="mensajesNotificaionesAlumnos">

	</div>
	<input type="hidden" name="token" id="token" value="<?php echo $_SESSION['token']; ?>"> 

</div>


<?php 

include ($absolute_include."vistas/plantillas/footer.php"); 

?> 
