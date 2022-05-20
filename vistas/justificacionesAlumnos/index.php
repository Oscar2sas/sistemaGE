<?php 


include ($absolute_include."vistas/plantillas/head.php"); 
include ($absolute_include."vistas/plantillas/sidebar.php"); 
include ($absolute_include."vistas/plantillas/navbar.php"); 
include ($absolute_include."vistas/plantillas/tabHeadAsistencias.php"); 

?> 



<div id="contenedorFormJustificacionAlumnos" class="col-md-12 col-sm-12 col-xs-12">

 <form action="#" method="post" enctype="multipart/form-data">
    <!-- Titulos de la pantalla -->
    <div class="text-center">
        <h3>Justificaciones Alumnos</h3>
    </div>

    <div class="form-group">
        <label for="cicloLectivoJustificacionAlumnos">Seleccione Año Lectivo</label>
        <select class="form-control" id="cicloLectivoJustificacionAlumnos">
          <option value="<?php echo $resultAnoLectivoActivo['anolectivo_id']; ?>" selected><?php echo $resultAnoLectivoActivo['ndescripcion_anolectivo']; ?></option>
      </select>
  </div>


  <div class="form-group">
    <label for="cursosJustificacionesAlumnos">Seleccione Curso</label>
    <select class="form-control" name="curso" id="cursosJustificacionesAlumnos">
        <option selected disabled value="0">Elija un Curso:</option>
        <?php foreach ($resultCursos as $rowCursos): ?>
            <option value="<?php echo $rowCursos['curso_id'] ?>"><?php echo $rowCursos['cdescripcion_curso']; ?></option>
        <?php endforeach; ?>
    </select>
</div>


<div class="form-group">
    <label for="trayectosJustificacionAlumnos">Seleccione el Trayecto</label>
    <select class="form-control" id="trayectosJustificacionAlumnos">
      <option selected disabled value="0">Elija un Trayecto:</option>
      <?php foreach ($resultTrayectos as $rowTrayectos): ?>
        <option value="<?php echo $rowTrayectos['trayecto_id'] ?>"><?php echo $rowTrayectos['cdescripcion_trayecto']; ?></option>
    <?php endforeach; ?>
</select>
</div>

<input type="hidden" name="token" id="token" value="<?php echo $_SESSION['token']; ?>"> 

</form>

</div>
<div class="container form-group" id="errorJustificacionesAlumnos">

</div>


<?php 

include ($absolute_include."vistas/plantillas/footer.php"); 

?> 
