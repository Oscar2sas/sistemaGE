<?php
 
  include ($absolute_include."vistas/plantillas/head.php"); 
  include ($absolute_include."vistas/plantillas/sidebar.php"); 
  include ($absolute_include."vistas/plantillas/navbar.php"); 
 
?> 

<div class="container">
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-12">
            <h4>Actulizar Examen</h4>

            <!-- este div es para mostrar los errorres de validacion 
                si hay errorres se muestra el div 
                y se hace un foreach de la coleccion de errores y se muestra
                en una lista -->

            <div class="alert alert-danger">
            
            </div>

            <!-- formulario para CARGA -->
            <form action="<?php echo $carpeta_trabajo;?>/controladores/examenes/controller.examenes.php" method="POST" autocomplete="off">
         
                 <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">  
                 <input type="hidden" name="accion" value="actualizar">  
                
                 <input type="hidden" name="examen_id" value="<?php echo $examenes['examen_id']; ?>"> 
               
                <div class="form-group">
                     <label for="fecha">Fecha de Examen </label>
                    <input type="date" class="form-control"  name="dfecha_examen" placeholder="Ingrese la fecha..." value="<?php echo $examenes['dfecha_examen']; ?>">
                    <label for="alumno">Alumno</label> <br>
                    <select name="rela_alumno_id" class="form-control"> 
                    <?php foreach ($alumnos as $alumno): ?>   
                            <option value = <?php echo $alumno['alumno_id']; ?> ><?php echo $alumno['capellidos_persona'] . " " .$alumno['cnombres_persona']; ?></option>
                    <?php endforeach; ?> </select> <br>
                    <label for="libro">Nº Libro</label>
                    <input type="number" class="form-control"  name="nnumlibro_examen" placeholder="Ingrese el Nº de Libro..." value="<?php echo $examenes['nnumlibro_examen']; ?>" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" type = "number" maxlength = "8">
                    <label for="ncalificacion">Calificacion</label>
                    <input type="number" class="form-control"  name="ncalificacion" placeholder="Ingrese la Calificacion..." value="<?php echo $examenes['ncalificacion']; ?>" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" type = "number" maxlength = "8">
                    <label for="folio">Nº Folio</label>
                    <input type="number" class="form-control"  name="nnumfolio_examen" placeholder="Ingrese el Nº de Folio..." value="<?php echo $examenes['nnumfolio_examen']; ?>" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" type = "number" maxlength = "11">
                    <label for="pagina">Pagina de Examen</label>
                    <input type="number" class="form-control"  name="nnumpagina_examen" placeholder="Ingrese el Nº de Pagina..." value="<?php echo $examenes['nnumpagina_examen']; ?>" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" type = "number" maxlength = "11">
                    <label for="nanoacta">Año Acta</label>
                    <input type="number" class="form-control"  name="nanoacta_examen" placeholder="Ingrese el Nº de Acta..." value="<?php echo $examenes['nanoacta_examen']; ?>" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" type = "number" maxlength = "8">
                    <label for="anolectivo">Año Lectivo</label> <br>
                    <select name="rela_anolectivo_id" class="form-control">
                    <?php foreach ($anolectivos as $anolectivo): ?>
                           
                            <option value = <?php echo $anolectivo['anolectivo_id']; ?>><?php echo $anolectivo['ndescripcion_anolectivo']; ?></option>

                    <?php endforeach; ?> </select> <br>

                    <label for="curso">Cursos</label> <br>
                    <select name="rela_curso_id" class="form-control">
                    <?php foreach ($curso as $cursos): ?>
                            <option value = <?php echo $cursos['curso_id']; ?>><?php echo $cursos['cdescripcion_curso']; ?></option>
                    <?php endforeach; ?> </select> <br>
            

                     <label for="nombre">Etapas Escolares</label> <br>
                    <select name="rela_etapaescolar_id" class="form-control">
                    <?php foreach ($etapas as $etapa): ?>
                            <option value = <?php echo $etapa['etapaescolar_id']; ?>><?php echo $etapa['cdescripcion_etapa']; ?></option>
                    <?php endforeach; ?> </select> <br>
                

                    <label for="materia">Materias</label> <br>
                    <select name="rela_materia_id" class="form-control">
                    <?php foreach ($materia as $materias): ?>
                            <option value = <?php echo $materias['materia_id']; ?>><?php echo $materias['cnombre_materia']; ?></option>
                    <?php endforeach; ?> </select> <br>
                </div>    

                <div class="form-group">
                    <div class="row">
                        <div class="col-7">
                                <input type="button" class="btn btn-info"
                                onClick = "window.location.href = '<?php echo $carpeta_trabajo;?>/controladores/examenes/controller.examenes.php';"
                                value=Volver> <br>
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