<?php 


include ($absolute_include."vistas/plantillas/head.php"); 
include ($absolute_include."vistas/plantillas/sidebar.php"); 
include ($absolute_include."vistas/plantillas/navbar.php"); 
include ($absolute_include."vistas/plantillas/tabHeadMovimientosAlumnos.php"); 

?> 



<div id="contenedorFormReportesListadosAlumnos" class="col-md-12 col-sm-12 col-xs-12">

  <!-- Titulos de la pantalla -->
  <div class="text-center">
    <h3>Listados Alumnos</h3>
  </div>

  <div class="form-group">
    <label for="cicloLectivoListadosReportesAlumnos">Seleccione Año Lectivo</label>
    <select class="form-control" id="cicloLectivoListadosReportesAlumnos">
      <?php foreach ($resultAnoLectivos as $anoLectivos): ?>
        <?php if ($anoLectivos['bactivo_anolectivo'] == '1'): ?>

          <option value="<?php echo $anoLectivos['anolectivo_id']; ?>" selected><?php echo $anoLectivos['ndescripcion_anolectivo']; ?></option>
          <?php else: ?>

            <option value="<?php echo $anoLectivos['anolectivo_id']; ?>"><?php echo $anoLectivos['ndescripcion_anolectivo']; ?></option>
          <?php endif ?>

        <?php endforeach ?>
      </select>
    </div>


    <div class="form-group" id="errorReportesListadosAlumnos">

    </div>
    <input type="hidden" name="token" id="token" value="<?php echo $_SESSION['token']; ?>"> 

  </div>


  <?php 

  include ($absolute_include."vistas/plantillas/footer.php"); 

  ?> 
