<?php 


include ($absolute_include."vistas/plantillas/head.php"); 
include ($absolute_include."vistas/plantillas/sidebar2.php"); 
include ($absolute_include."vistas/plantillas/navbar.php"); 
include ($absolute_include."vistas/plantillas/tabHeadOpcionesDocentes.php"); 

?> 



<div id="contenedorFormAsistenciaAlumnosDocentes" class="col-md-12 col-sm-12 col-xs-12">

    <!-- Titulos de la pantalla -->
    <div class="text-center">
        <h3>Planilla personal docentes</h3>
    </div>
    
  <div class="form-group">
    <label for="cicloLectivoAsistenciaAlumnosDocentes">Seleccione Año Lectivo</label>
    <select class="form-control" id="cicloLectivoAsistenciaAlumnosDocentes">
      <option value="<?php echo $resultAnoLectivoActivo['anolectivo_id']; ?>" selected><?php echo $resultAnoLectivoActivo['ndescripcion_anolectivo']; ?></option>
  </select>
</div>

<div class="form-group">
    <label for="fechaAsistenciaAlumnosDocentes">Seleccione Fecha de Asistencia</label>
    <input type="date" name="fechaAsistenciaAlumnosDocentes" id="fechaAsistenciaAlumnosDocentes" class="form-control" value="<?php echo $fechaHoy; ?>">   
</div>

<div class="form-group">
    <label for="cursosAsistenciaAlumnosDocentes">Seleccione Curso</label>
    <select class="form-control" name="curso" id="cursosAsistenciaAlumnosDocentes">
        <option selected disabled value="0">Elija un Curso:</option>
        <?php foreach ($cursos as $rowCursos): ?>
            <option value="<?php echo $rowCursos['curso_id'] ?>"><?php echo $rowCursos['cdescripcion_curso']; ?></option>
        <?php endforeach; ?>
    </select>
</div>

<div class="form-group">
    <label for="trayectosAsistenciaAlumnosDocentes">Seleccione el Trayecto</label>
    <select class="form-control" id="trayectosAsistenciaAlumnosDocentes">
      <option selected disabled value="0">Elija un Trayecto:</option>
        <?php foreach ($trayectos as $rowTrayectos): ?>
            <option value="<?php echo $rowTrayectos['trayecto_id'] ?>"><?php echo $rowTrayectos['cdescripcion_trayecto']; ?></option>
        <?php endforeach; ?>
  </select>
</div>

<div class="form-group" id="descrMateriasDocentes">
    
</div>
<input type="hidden" name="token" id="token" value="<?php echo $_SESSION['token']; ?>"> 


</div>


<?php 

include ($absolute_include."vistas/plantillas/footer.php"); 

?> 
