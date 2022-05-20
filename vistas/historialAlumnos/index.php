<?php 


include ($absolute_include."vistas/plantillas/head.php"); 
include ($absolute_include."vistas/plantillas/sidebar2.php"); 
include ($absolute_include."vistas/plantillas/navbar.php"); 

if ($docente) {
  include ($absolute_include."vistas/plantillas/tabHeadOpcionesDocentes.php"); 
  
}else{

  include ($absolute_include."vistas/plantillas/tabHeadAsistencias.php"); 
}


?> 



<div id="contenedorFormHistorialAlumnos" class="col-md-12 col-sm-12 col-xs-12">

  <!-- Titulos de la pantalla -->
  <div class="text-center">
    <h3>Historial Alumnos</h3>
  </div>

  <div class="form-group">
    <label for="cicloLectivoHistoriaAlumnos">Seleccione Año Lectivo</label>
    <select class="form-control" id="cicloLectivoHistoriaAlumnos">
      <option value="<?php echo $resultAnoLectivoActivo['anolectivo_id']; ?>" selected><?php echo $resultAnoLectivoActivo['ndescripcion_anolectivo']; ?></option>
    </select>
  </div>


  <div class="form-group">
    <label for="cursosHistorialAlumno">Seleccione Curso</label>
    <select class="form-control" name="curso" id="cursosHistorialAlumno">
      <option selected disabled value="0">Elija un Curso:</option>
      <?php foreach ($resultCursos as $rowCursos): ?>
        <option value="<?php echo $rowCursos['curso_id'] ?>"><?php echo $rowCursos['cdescripcion_curso']; ?></option>
      <?php endforeach; ?>
    </select>
  </div>

  <div class="form-group">
    <label for="trayectosHistorialAlumno">Seleccione el Trayecto</label>
    <select class="form-control" id="trayectosHistorialAlumno">
      <option selected disabled value="0">Elija un Trayecto:</option>
      <?php foreach ($resultTrayectos as $rowTrayectos): ?>
        <option value="<?php echo $rowTrayectos['trayecto_id'] ?>"><?php echo $rowTrayectos['cdescripcion_trayecto']; ?></option>
      <?php endforeach; ?>
    </select>
  </div>

  <div class="form-group" id="errorHistorialAlumnos">

  </div>
  <input type="hidden" name="token" id="token" value="<?php echo $_SESSION['token']; ?>"> 

  <div class="form-group" id="descripcionHistorialAlumno">

  </div>

</div>


<?php 

include ($absolute_include."vistas/plantillas/footer.php"); 

?> 
