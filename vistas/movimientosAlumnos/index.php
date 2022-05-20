<?php 


include ($absolute_include."vistas/plantillas/head.php"); 
include ($absolute_include."vistas/plantillas/sidebar.php"); 
include ($absolute_include."vistas/plantillas/navbar.php"); 
include ($absolute_include."vistas/plantillas/tabHeadMovimientosAlumnos.php"); 


?> 

<div id="contenedorFormPasajeAlumnosCurso" class="col-md-12 col-sm-12 col-xs-12">

  <!-- Titulos de la pantalla -->
  <div class="text-center">
    <h3>PASE DE ALUMNOS A NUEVO CURSO</h3>
  </div>

  <div class="form-group">
    <!-- <div class="col-md-12 col-sm-12 col-xs-12"> -->
      <label for="movimientosAlumnosAnoLectivo">Año Lectivo Activo</label>
      <select class="form-control" disabled id="movimientosAlumnosAnoLectivo">

        <option value="<?php echo $resultAnosLectivos['anolectivo_id']; ?>" selected disabled><?php echo $resultAnosLectivos['ndescripcion_anolectivo']; ?></option>

      </select>
    </div>

    <div class="form-group">
     <label for="movimientosAlumnosDivision">Elija Curso</label>
     <select class="form-control" id="movimientosAlumnosDivision">

      <option value="0" selected disabled>Elija un curso</option>

      <?php foreach ($resultado_divisiones_ano_lectivo['mensaje'] as $row_divisiones): ?>
        <option value="<?php echo $row_divisiones['curso_id']; ?>"><?php echo $row_divisiones['cdescripcion_curso']; ?></option>
      <?php endforeach ?>

    </select>
  </div>
<div id="errorPasajeMovimientosAlumnos">
  
</div>
  <?php 

  include ($absolute_include."vistas/plantillas/footer.php"); 

  ?> 
