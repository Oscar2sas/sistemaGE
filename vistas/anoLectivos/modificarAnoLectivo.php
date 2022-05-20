<?php

include ($absolute_include."vistas/plantillas/head.php"); 
include ($absolute_include."vistas/plantillas/sidebar.php"); 
include ($absolute_include."vistas/plantillas/navbar.php"); 
?>

<div class="col-md-12">
	<h1 class="text-center">Modificar Año Lectivo</h1>
	<form action="<?php echo $carpeta_trabajo;?>/controladores/anoLectivos/controller.anolectivos.php" method="POST">
		
		<input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">  
		<input type="hidden" name="accion" value="modificar">
		<input type="hidden" name="idAnoLectivo" value="<?php echo $result_ano_lectivo['anolectivo_id'] ?>">

		<div class="form-group">
			<label for="descripcionAnoLectivo">Editar Descripcion Año Lectivo</label>
			<input type="number" name="descripcionAnoLectivo" autofocus required class="form-control" id="descripcionAnoLectivo" value="<?php echo $result_ano_lectivo['ndescripcion_anolectivo'] ?>">
			<!-- <small id="cajaAdvertencia" class="text-danger">Aca va ir una advertencia</small> -->
			<div id="advertenciaDescripcionAnoLectivo"></div>

		</div>
		<div class="form-group">
			<label for="fechaInicio">Editar Fecha Inicio de Año Lectivo</label>
			<input type="date" name="fechaInicio" required class="form-control" id="fechaInicio" value="<?php echo $result_ano_lectivo['dfechainicio_anolectivo'] ?>">
			<div id="advertenciaFechaInicioAnoLectivo"></div>

		</div>
		<div class="form-group">
			<label for="fechaFinClases">Editar Fecha Fin de Clases</label>
			<input type="date" required name="fechaFinClases" class="form-control" id="fechaFinClases" value="<?php echo $result_ano_lectivo['dfechafinclases_anolectivo'] ?>">
			<div id="advertenciaFechaFinClases"></div>

		</div>
		<div class="form-group">
			<label for="fechaFinAnoLectivo">Editar Fecha Fin Año Lectivo</label>
			<input type="date" required name="fechaFinAnoLectivo" class="form-control" id="fechaFinAnoLectivo" value="<?php echo $result_ano_lectivo['dfechafin_anolectivo'] ?>">
			<div id="advertenciasFinAnoLectivo"></div>

		</div>
		<div class="form-group">
			<label for="estadoAnoLectivo">Cambiar Estado de Año Lectivo</label>
			<select name="estadoAnoLectivo" class="custom-select" id="estadoAnoLectivo">
				<?php 

				if ($result_ano_lectivo['bactivo_anolectivo'] == 1) {
					echo "<option selected value='1'>Activo</option>";
					echo "<option value='0'>Inactivo</option>";
				}else{
					echo "<option selected value='0'>Inactivo</option>";
					echo "<option value='1'>Activo</option>";
				}

				?>
				
			</select>
			<div id="advertenciasEstadoAnoLectivo"></div>
		</div>
		<input type="submit" class="btn btn-success btn-block" value="Guardar Año Lectivo">
		<input type="button" class="btn btn-warning btn-block" onClick="history.back()" value="Cancelar">
	</form>
</div>

<?php

include ($absolute_include."vistas/plantillas/footer.php"); 
?>   