<?php
  include ($absolute_include."vistas/plantillas/head.php"); 
  include ($absolute_include."vistas/plantillas/sidebar.php"); 
  include ($absolute_include."vistas/plantillas/navbar.php");
	?>

<div class="container" id="container">
  <div class="table-responsive-xl" align="center">
    <h2>Divisiones</h2>
    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <span class="input-group-text" id="inputGroup-sizing-default">BUSCAR</span>
      </div>
      <input type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" id="buscar" onkeyup="buscar()" placeholder="Buscar division">
    </div>
    <table class="table" id="tabla">
    
    <thead class="table table-striped table-dark">
      <tr align="center">
        <th>Curso</th>
        <th>Carrera</th>
        <th>Año lectivo</th>
      </tr>
    </thead>
    <?php foreach ($resultado_carreras as $rowdivisiones) : ?>
    <tr align="center">
    	<td><?php echo $rowdivisiones['cdescripcion_curso'];?></td>
    	<td><?php echo $rowdivisiones['cdescripcion_carrera'];?></td>
    	<td><?php echo $rowdivisiones['ndescripcion_anolectivo'];?></td>
    </tr>
    <?php endforeach; ?>
    </table>
  </div>
</div>

  <?php 
   include ($absolute_include."vistas/plantillas/footer.php"); 
?> 