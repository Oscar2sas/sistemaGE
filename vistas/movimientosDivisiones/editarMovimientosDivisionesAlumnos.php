<?php 


include ($absolute_include."vistas/plantillas/head.php"); 
include ($absolute_include."vistas/plantillas/sidebar.php"); 
include ($absolute_include."vistas/plantillas/navbar.php"); 

// var_dump($result_division_alumnos);
?> 

<div id="contenedorFormPasajeCursoEditarAnoLectivo" class="col-md-12 col-sm-12 col-xs-12">

  <!-- Titulos de la pantalla -->
  <div class="text-center">
    <h3>Modificar pasaje de curso a año lectivo</h3>
  </div>
  <br>
  <?php foreach ($result_cursos as $key => $curso): ?>

    <h5>Curso: <?php echo $curso['cdescripcion_curso'] ?> | Año Lectivo: <?php echo $result_ano_lectivo_actual['ndescripcion_anolectivo'] ?> </h5>
    <input type="hidden" value="<?php echo $curso['curso_id'] ?>" name="idCurso" id="idCurso">

  <?php endforeach ?>
  <br><br>

  <table id="table" class="table table-stripped table-bordered nowrap cellspacing=" width="100%">

    <thead class="thead-dark">
      <tr>

        <th class="text-center">Nombre</th>
        <th class="text-center">Dni</th>
        <th class="text-center">Fecha Nac</th>
        <th class="text-center">[x]</th>

      </tr>
    </thead>

    <tbody>
      <?php foreach ($result_division_alumnos as $alumnos): ?>
        <tr>
          <td class="text-center"><?php echo $alumnos['capellidos_persona']." ".$alumnos['cnombres_persona'] ?></td>
          <td class="text-center"><?php echo $alumnos['ndni_persona']; ?></td>
          <td class="text-center"><?php echo $alumnos['dfechanac_persona']; ?></td>
          <td class="text-center">
            <input type="checkbox" class="form-check-input" checked id="checkAlumnoQuitar" value="<?php echo $alumnos['alumno_id'] ?>">
          </td>

        </tr>
      <?php endforeach; ?>

    </tbody>
  </table>


  <!-- <div id="errorPasajeMovimientosDivisiones">

  </div> -->
  <br>
  
  
  <input type="button" id="quitarAlumnosCurso" class="btn-block btn btn-warning" value="Quitar del curso">

  <input type="button" class="btn-block btn btn-info" onClick="location.href='<?php echo $absolute_include ?>controladores/movimientosdivisiones/controller.movimientosdivisiones.php'" value="Volver Atras">

</div>
<?php 

include ($absolute_include."vistas/plantillas/footer.php"); 

?> 
