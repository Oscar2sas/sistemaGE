<?php
 	include ($absolute_include."vistas/plantillas/head.php"); 
	include ($absolute_include."vistas/plantillas/sidebar.php"); 
	include ($absolute_include."vistas/plantillas/navbar.php");
	?>

<div class="container" id="container">
  <div class="table-responsive-xl" align="center">
    <h2>DATOS DEL TUTOR</h2>

    <table class="table" align="center" id="tabla">
    
    <thead class="table table-striped table-dark">
      <tr align="center">
        <th>Apellidos y Nombres</th>
        <th>DNI</th>
        <th>Correo electrónico</th>
        <th>Teléfono</th>
      </tr>
    </thead>
  
    <?php foreach ($resultado_carreras as $rowtutor) : ?>
    <tr align="center">
    	<td><?php echo $rowtutor['capellidos_persona']." ".$rowtutor['cnombres_persona']; ?></td>
    	<td><?php echo $rowtutor['ndni_persona']; ?></td>
    	<td><?php echo $rowtutor['cemail_persona']; ?></td>
    	<td><?php echo $rowtutor['cnumero_telefono']; ?></td>
    </tr>
    <?php endforeach; ?>
    </table>
  </div>
</div>
<?php 
   include ($absolute_include."vistas/plantillas/footer.php"); 
  ?> 