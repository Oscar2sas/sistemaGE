<?php
 
  include ($absolute_include."vistas/plantillas/head.php"); 
  include ($absolute_include."vistas/plantillas/sidebar.php"); 
  include ($absolute_include."vistas/plantillas/navbar.php"); 
 
?> 

<div class="container">
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-12">
            <h4>Actualizacion de Datos</h4>

            <!-- este div es para mostrar los errorres de validacion 
                si hay errorres se muestra el div 
                y se hace un foreach de la coleccion de errores y se muestra
                en una lista -->

            <div class="alert alert-danger">
            </div>

            <!-- formulario para CARGA -->
            <form action="<?php echo $carpeta_trabajo;?>/controladores/notas/controller.notas.php" method="POST" autocomplete="off">
         
                 <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">  
                 <input type="hidden" name="notas_id" value="<?php echo $nota['notas_id']; ?>"> 
                 <input type="hidden" name="accion" value="actualizar">  

                 <div class="form-group">
                 <label for="Año Lectivo">Año Lectivo</label> <br>
                    <select name="rela_anolectivo_id">
                    <?php foreach ($anoslectivos as $anolectivo): ?>
                           
                            <option value = <?php echo $anolectivo['anolectivo_id']; ?> ><?php echo $anolectivo['ndescripcion_anolectivo']; ?></option>
                    <?php endforeach; ?><br>
                   </select>

                   <div class="form-group">
                    <label for="curso">Curso</label> <br>
                 <select name="rela_curso_id">
                    <?php foreach ($cursos as $curso): ?>
                           
                            <option value = <?php echo $curso['curso_id']; ?> ><?php echo $curso['cdescripcion_curso']; ?></option>
                    <?php endforeach; ?>
                    </select>

                 <div class="form-group">
                 <label for="alumno">Alumno</label> <br>
                    <select name="rela_alumno_id">
                    <?php foreach ($alumnos as $alumno): ?>
                           
                            <option value = <?php echo $alumno['alumno_id']; ?> ><?php echo $alumno['capellidos_persona'] . " " .$alumno['cnombres_persona']; ?></option>
                    <?php endforeach; ?><br>
                   </select>

                    
                    <div class="form-group">
                    <label for="nombre">Materia</label> <br>
                    <select name="rela_materia_id">
                    <?php foreach ($materias as $materia): ?>
                           
                            <option value = <?php echo $materia['materia_id']; ?> ><?php echo $materia['cnombre_materia']; ?></option>
                    <?php endforeach; ?>
                    </select>

                    <div class="form-group">
                    <label for="nombre">Etapa Escolar</label> <br>
                    <select name="rela_etapaescolar_id">
                    <?php foreach ($etapas as $etapa): ?>
                           
                            <option value = <?php echo $etapa['etapaescolar_id']; ?> ><?php echo $etapa['cdescripcion_etapa']; ?></option>
                    <?php endforeach; ?>
                    </select>

                    <div class="form-group">
                    <label for="calificacion">Calificacion</label>
                    <input type="text" class="form-control"  name="ncalificacion" placeholder="Ingrese la calificacion..." value ="<?php echo $nota['ncalificacion']; ?>" required>
                    </div>
                    
                <div class="form-group">
                    <div class="row">
                        <div class="col-6">
                                <input type="button" class="btn btn-info"
                                onClick = "window.location.href = '<?php echo $carpeta_trabajo;?>/controladores/notas/controller.notas.php';"
                                value=Volver>
                        </div>
                        <div class="text-right" >
                                <button class="btn btn-success" type="submit">Guardar</button>
                                <span class="input-group-btn">
                                    <button class="btn btn-danger" type="reset">Cancelar</button>  
                                </span>   
                        </div>
                    </div>
                </div>
            </form>
        </div>

    </div>

</div>

<?php

    include ($absolute_include."vistas/plantillas/footer.php"); 
?>    