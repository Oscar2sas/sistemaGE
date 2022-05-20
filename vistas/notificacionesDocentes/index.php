<?php 
include ($absolute_include."vistas/plantillas/head.php"); 
include ($absolute_include."vistas/plantillas/sidebar2.php"); 
include ($absolute_include."vistas/plantillas/navbar.php"); 
include ($absolute_include."vistas/plantillas/tabHeadOpcionesDocentes.php"); 

?> 

<div id="contenedorFormVerificarHorariosDocentes" class="col-md-12 col-sm-12 col-xs-12">

  <!-- Titulos de la pantalla -->
  <div class="text-center">
    <h3>NOTIFICACIONES</h3>
  </div>
  <hr>

  <?php foreach ($result_historiales_alumnos as $row_historiales_alumnos): ?>

    <?php 

    $claseNotificaciones = ($row_historiales_alumnos['dfecha_historial'] == $fecha_hoy) ? 'bg-warning' : ''
     ?>

    <div class="form-group">
     <div class="card text-white <?php echo $claseNotificaciones ?> mb-3">
      <div class="card-header">Fecha: <?php echo $row_historiales_alumnos['dfecha_historial']?></div>
      <div class="card-body">
        <h5 class="card-title">Profesores: </h5>
        <p class="card-text">
          El alumno: 
          <?php echo $row_historiales_alumnos['capellidos_persona'] ." ".$row_historiales_alumnos['cnombres_persona'] ?>

          <?php echo $row_historiales_alumnos['historial_alumno']?>
            

          </p>
      </div>
    </div>

  </div>
<?php endforeach ?>

</div>


<?php 

include ($absolute_include."vistas/plantillas/footer.php"); 
?> 
