<?php 


include ($absolute_include."vistas/plantillas/head.php"); 
include ($absolute_include."vistas/plantillas/sidebar.php"); 
include ($absolute_include."vistas/plantillas/navbar.php"); 
include ($absolute_include."vistas/plantillas/tabHeadAsistencias.php"); 

?> 



<div id="contenedorAsistenciaDocente" class="col-md-12 col-sm-12 col-xs-12">

    <!-- Titulos de la pantalla -->
    <div class="text-center">
        <h3>Asistencia Docentes</h3>
    </div>

  <div class="form-group">
    <label for="cicloLectivoHorariosMaterias">Seleccione Año Lectivo</label>
    <select class="form-control" id="cicloLectivoHorariosMaterias">
      <option value="<?php echo $resultAnoLectivo['anolectivo_id']; ?>" selected><?php echo $resultAnoLectivo['ndescripcion_anolectivo']; ?></option>
  </select>
</div>

<div class="form-group">
    <label for="fechaAsistenciaHorariosMaterias">Seleccione Fecha de Asistencia</label>
    <input type="date" name="fechaAsistencia" id="fechaAsistenciaHorariosMaterias" class="form-control" value="<?php echo $fechaHoy; ?>">   
</div>

<div class="form-group">
    <label for="cursosHorariosMaterias">Seleccione Curso</label>
    <select class="form-control" name="curso" id="cursosHorariosMaterias">
        <option selected disabled value="0">Elija un Curso:</option>
        <?php foreach ($cursos as $rowCursos): ?>
            <option value="<?php echo $rowCursos['curso_id'] ?>"><?php echo $rowCursos['cdescripcion_curso']; ?></option>
        <?php endforeach; ?>
    </select>
</div>

<div class="form-group">
    <label for="trayectosHorariosMaterias">Seleccione el Trayecto</label>
    <select class="form-control" id="trayectosHorariosMaterias">
      <option selected disabled value="0">Elija un Trayecto:</option>
        <?php foreach ($trayectos as $rowTrayectos): ?>
            <option value="<?php echo $rowTrayectos['trayecto_id'] ?>"><?php echo $rowTrayectos['cdescripcion_trayecto']; ?></option>
        <?php endforeach; ?>
  </select>
</div>

<div class="form-group" id="errorHorariosMaterias">
    
</div>
<input type="hidden" name="token" id="token" value="<?php echo $_SESSION['token']; ?>"> 

</div>


<?php 

include ($absolute_include."vistas/plantillas/footer.php"); 

?> 
