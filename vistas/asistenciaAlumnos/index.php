<?php 


include ($absolute_include."vistas/plantillas/head.php"); 
include ($absolute_include."vistas/plantillas/sidebar.php"); 
include ($absolute_include."vistas/plantillas/navbar.php"); 
include ($absolute_include."vistas/plantillas/tabHeadAsistencias.php"); 

?> 



<div id="contenedorForm" class="col-md-12 col-sm-12 col-xs-12">

    <!-- Titulos de la pantalla -->
    <div class="text-center">
        <h3>Asistencia Alumnos</h3>
    </div>
    
    <div class="form-group">
        <label for="situacionDelDia">Seleccione Situacion del Dia</label>
        <select class="form-control" id="situacionDelDia">
          <option value="1">Dia Normal</option>
          <option value="2">Dia Anormal</option>
      </select>
  </div>

  <div class="form-group">
    <label for="cicloLectivo">Seleccione Año Lectivo</label>
    <select class="form-control" id="cicloLectivo">
      <option value="<?php echo $resultAnoLectivoActivo['anolectivo_id']; ?>" selected><?php echo $resultAnoLectivoActivo['ndescripcion_anolectivo']; ?></option>
  </select>
</div>

<div class="form-group">
    <label for="fechaAsistencia">Seleccione Fecha de Asistencia</label>
    <input type="date" name="fechaAsistencia" id="fechaAsistencia" class="form-control" value="<?php echo $fechaHoy; ?>">   
</div>

<div class="form-group">
    <label for="cursos">Seleccione Curso</label>
    <select class="form-control" name="curso" id="cursos">
        <option selected disabled value="0">Elija un Curso:</option>
        <?php foreach ($cursos as $rowCursos): ?>
            <option value="<?php echo $rowCursos['curso_id'] ?>"><?php echo $rowCursos['cdescripcion_curso']; ?></option>
        <?php endforeach; ?>
    </select>
</div>

<div class="form-group">
    <label for="trayectos">Seleccione el Trayecto</label>
    <select class="form-control" id="trayectos">
      <option selected disabled value="0">Elija un Trayecto:</option>
        <?php foreach ($trayectos as $rowTrayectos): ?>
            <option value="<?php echo $rowTrayectos['trayecto_id'] ?>"><?php echo $rowTrayectos['cdescripcion_trayecto']; ?></option>
        <?php endforeach; ?>
  </select>
</div>

<div class="form-group" id="error">
    
</div>
<input type="hidden" name="token" id="token" value="<?php echo $_SESSION['token']; ?>"> 


</div>


<?php 

include ($absolute_include."vistas/plantillas/footer.php"); 

?> 
