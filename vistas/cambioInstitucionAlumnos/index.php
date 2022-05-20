<?php 


include ($absolute_include."vistas/plantillas/head.php"); 
include ($absolute_include."vistas/plantillas/sidebar.php"); 
include ($absolute_include."vistas/plantillas/navbar.php"); 
include ($absolute_include."vistas/plantillas/tabHeadMovimientosAlumnos.php"); 

?> 

<div id="contenedorFormCambioInstitucionAlumnos" class="col-md-12 col-sm-12 col-xs-12">

  <!-- Titulos de la pantalla -->
  <div class="text-center">
    <h3>PASE DE ALUMNOS A NUEVA INSTITUCION</h3>
  </div>

  <div class="form-group">
    <!-- <div class="col-md-12 col-sm-12 col-xs-12"> -->
      <label for="cambioInstitucionAlumnosAnoLectivo">Año Lectivo Activo</label>
      <select class="form-control" disabled id="cambioInstitucionAlumnosAnoLectivo">

        <option value="<?php echo $result_ano_lectivo['anolectivo_id']; ?>" selected disabled><?php echo $result_ano_lectivo['ndescripcion_anolectivo']; ?></option>

      </select>
    </div>

    <div class="form-group">

      <label for="cambioInstitucionAlumnosCurso">Selecciona un curso</label>
      <select class="form-control" id="cambioInstitucionAlumnosCurso">

        <option value="0">Seleccionar un curso</option>

        <?php foreach ($result_cursos as $cursos): ?>
          
        <option value="<?php echo $cursos['curso_id']; ?>"><?php echo $cursos['cdescripcion_curso']; ?></option>
        <?php endforeach ?>

      </select>
      
    </div>

    <div id="errorCambioInstitucionAlumnos">
      
    </div>
    </div>
    <?php 

    include ($absolute_include."vistas/plantillas/footer.php"); 

    ?> 
