<?php
  include ($absolute_include."vistas/plantillas/head.php"); 
  include ($absolute_include."vistas/plantillas/sidebar.php"); 
  include ($absolute_include."vistas/plantillas/navbar.php");
  ?>

<div id="container" class="container">
		
		<form action="<?php echo $carpeta_trabajo;?>/controladores/consultas/historiales_personal/controller.historiales_personal.php" method="POST" autocomplete="off">
			<?php foreach ($resultadoBusquedaCarrera as $datos) :?>
			<div class="form-group">
				<h1>Modificar Historial</h1>
				<label>Historial del personal: <?php echo $datos['capellidos_persona']." ".$datos['cnombres_persona']; ?> </label><br>
				<label>DNI: <?php echo $datos['ndni_persona']; ?></label>
				<textarea class="form-control" name="historial_personal" rows="4" value="<?php echo $datos['historial_personal']; ?>"><?php echo $datos['historial_personal']; ?></textarea>
			</div>
			<div>
				<input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">  
            	<input type="hidden" name="accion" value="guardar_modificacion">

            	<input type="hidden"  name="historialpersonal_id" value="<?php echo $datos['historialpersonal_id']; ?>">
			</div>
			<div class="form-group">
				<input type="submit" class="btn btn-primary" name="" value="EDITAR">
			</div>
			<div>
				<button type="button" class="btn btn-info" onClick = "window.location.href = '<?php echo $carpeta_trabajo;?>/controladores/consultas/historiales_personal/controller.historiales_personal.php ?>';">CANCELAR</button><br><br>
			</div>
			<?php endforeach; ?>
		</form>
		
	
</div>