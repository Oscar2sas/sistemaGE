<?php 


include ($absolute_include."vistas/plantillas/head.php"); 
include ($absolute_include."vistas/plantillas/sidebar.php"); 
include ($absolute_include."vistas/plantillas/navbar.php"); 


?> 

<div id="contenedorFormPasajeCursoNuevoAnoLectivo" class="col-md-12 col-sm-12 col-xs-12">

  <!-- Titulos de la pantalla -->
  <div class="text-center">
    <h3>Pasaje de curso a nuevo año lectivo</h3>
  </div>
    <a class="btn btn-info" onClick="location.href='<?php echo $absolute_include ?>controladores/movimientosdivisiones/controller.movimientosdivisiones.php'"><i class="fa fa-undo"></i> Volver Atras</a>
  

    <br><br>
  <div class="form-group">
    <!-- <div class="col-md-12 col-sm-12 col-xs-12"> -->
      <label for="pasajeAnoLectivo">Año Lectivo Anterior</label>
      <select class="form-control" disabled id="pasajeAnoLectivo">

        <option value="<?php echo $resultAnosLectivosAnterior['anolectivo_id']; ?>" selected><?php echo $resultAnosLectivosAnterior['ndescripcion_anolectivo']; ?></option>

      </select>
    </div>

    <div class="form-group">
      <!-- <div class="col-md-12 col-sm-12 col-xs-12"> -->
        <label for="pasajeCurso">Seleccione un Curso</label>
        <select class="form-control" id="pasajeCurso">

          <option value="0" selected disabled>Selecciona un Curso</option>

          <?php foreach ($resultCursos as $key => $cursos): ?>

            <option value="<?php echo $cursos['curso_id']; ?>"><?php echo $cursos['cdescripcion_curso']; ?></option>
          <?php endforeach ?>

        </select>
      </div>
      <br>


      <div id="errorPasajeMovimientosDivisiones">

      </div>
    </div>
    <!-- <input type="button" class="float-right btn btn-info"  value="Volver Atras"> -->
    <?php 

    include ($absolute_include."vistas/plantillas/footer.php"); 

    ?> 
