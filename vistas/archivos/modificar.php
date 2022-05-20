<?php
  include ($absolute_include."vistas/plantillas/head.php"); 
  include ($absolute_include."vistas/plantillas/sidebar.php"); 
  include ($absolute_include."vistas/plantillas/navbar.php");
  ?>

<div id="container" class="container">
	<?php foreach($resultadoBusquedaCarrera as $datos): ?>
		<form action="<?php echo $carpeta_trabajo;?>/controladores/documentosvarios/controller.elementos.php ?>" method="POST">
			<div class="form-group">
				<h1>Modificar Documento</h1>
				<label>Documento: <?php echo $datos['cnombre_documento']; ?> </label><br>
				<label>Descripción: </label>
				<textarea class="form-control" name="cdescripcion_documento" value="<?php echo $datos['cdescripcion_documento']; ?>" rows="4"><?php echo $datos['cdescripcion_documento']; ?></textarea>
			</div>
			<div>
				<input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">  
            	<input type="hidden" name="accion" value="guardar_modificacion">

            	<input type="hidden"  name="documento_id" value="<?php echo $datos['documento_id']; ?>">
			</div>
			<div class="form-group">
				<input type="submit" class="btn btn-primary" value="EDITAR">
			</div>
			<div>
				<button type="button" class="btn btn-info" onclick = "window.location.href='<?php echo $carpeta_trabajo;?>/controladores/documentosvarios/controller.elementos.php';" >CANCELAR</button><br><br>
			</div>
		</form>
			
	<?php endforeach;  ?>
</div>