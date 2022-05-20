<?php 


include ($absolute_include."vistas/plantillas/head.php"); 
include ($absolute_include."vistas/plantillas/sidebar.php"); 
include ($absolute_include."vistas/plantillas/navbar.php"); 
include ($absolute_include."vistas/plantillas/tabHeadMovimientosAlumnos.php"); 

?> 

<div id="contenedorFormReincorporacionesAlumnos" class="col-md-12 col-sm-12 col-xs-12">

  <!-- Titulos de la pantalla -->
  <div class="text-center">
    <h3>Reincorporaciones Alumnos</h3>
  </div>

  <div class="form-group">
    <!-- <div class="col-md-12 col-sm-12 col-xs-12"> -->
      <label for="reincorporacionesAlumnosAnoLectivo">Año Lectivo Activo</label>
      <select class="form-control" disabled id="reincorporacionesAlumnosAnoLectivo">

        <option value="<?php echo $result_ano_lectivo['anolectivo_id']; ?>" selected disabled><?php echo $result_ano_lectivo['ndescripcion_anolectivo']; ?></option>

      </select>
    </div>

    <div class="form-group">

      <table id="table" class="table table-stripped table-bordered nowrap cellspacing=" width="100%">

        <thead class="thead-dark">
          <tr>

            <th class="text-center">Apellido</th>
            <th class="text-center">Nombre</th>
            <th class="text-center">Dni</th>
            <th class="text-center">Fecha Nacimiento</th>
            <th class="text-center">Curso</th>
            <th class="text-center">Estado</th>
            <th class="text-center">[x]</th>

          </tr>
        </thead>

        <tbody>
          <?php foreach ($result_alumnos_reincorporar as $alumnos_reincorporar): ?>
            <tr>

              <td class="text-center"><?php echo $alumnos_reincorporar['capellidos_persona']; ?></td>
              <td class="text-center"><?php echo $alumnos_reincorporar['cnombres_persona']; ?></td>
              <td class="text-center"><?php echo $alumnos_reincorporar['ndni_persona']; ?></td>
              <td class="text-center"><?php echo $alumnos_reincorporar['dfechanac_persona']; ?></td>
              <td class="text-center"><?php echo $alumnos_reincorporar['cdescripcion_curso']; ?></td>
              <td class="text-center"><?php echo $alumnos_reincorporar['cdescripcion_estadoalumno']; ?></td>
              <td class='text-center'><input type='checkbox' class='form-check-input' id='checkReincorporacionAlumnos' value="<?php echo $alumnos_reincorporar['alumno_id'] ?>"></td>
            </tr>
          <?php endforeach; ?>

        </tbody>

      </table>
    </div>

    <div class="form-group">
      <label for="archivoReincorporacionAlumnos">Seleccione Archivo Reincorporacion</label>
      <input type="file" class="form-control" name="archivoReincorporacionAlumnos" id="archivoReincorporacionAlumnos">
    </div>

    <input type="button" class="float-right btn btn-success" name="reincorporarAlumno" id="reincorporarAlumno" value="reincorporar Alumnos">
    <div id="errorReincorporacionesAlumnos">

    </div>
    <?php 

    include ($absolute_include."vistas/plantillas/footer.php"); 

    ?> 
