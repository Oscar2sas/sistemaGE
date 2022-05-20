<?php
 
  include ($absolute_include."vistas/plantillas/head.php"); 
  include ($absolute_include."vistas/plantillas/sidebar.php"); 
  include ($absolute_include."vistas/plantillas/navbar.php"); 

  $cnombre_persona="";
 
?> 

<div class="container">
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-12">
            <h4>Actualizar Personal</h4>

            <!-- este div es para mostrar los errorres de validacion 
                si hay errorres se muestra el div 
                y se hace un foreach de la coleccion de errores y se muestra
                en una lista -->

            <div class="alert alert-danger">
            </div>

            <!-- formulario para ACTUALIZACION -->
            <form action="<?php echo $carpeta_trabajo;?>/controladores/personal/controller.personal.php" method="POST" autocomplete="off">
         
                 <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">  
                 <input type="hidden" name="accion" value="actualizar">  
                 
                 <input type="hidden"  name="personal_id" value="<?php echo $personal['personal_id']; ?>">
                 <input type="hidden"  name="rela_persona_id" value="<?php echo $personal['rela_persona_id']; ?>">

                 <div class="form-group">

                 <label for="observaciones">Observaciones</label>
                    <input type="text" class="form-control"  name="cobservaciones_personal" value="<?php echo $personal['cobservaciones_personal']; ?>">

                 <label for="legajo">Legajo Personal</label>
                    <input type="number" class="form-control"  name="cnumlegajo_personal" value="<?php echo $personal['cnumlegajo_personal']; ?>">

                    <label for="apellidos">Apellido de la Persona</label>
                        <input type="text" class="form-control"  name="capellidos_persona" value="<?php echo $personal['capellidos_persona']; ?>">

                    <label for="nombres">Nombre de la Persona</label>
                        <input type="text" class="form-control"  name="cnombres_persona" value="<?php echo $personal['cnombres_persona']; ?>">

                    <label for="dni">DNI de la Persona</label>
                        <input type="number" class="form-control"  name="ndni_persona" value="<?php echo $personal['ndni_persona']; ?>">  

                <div class="form-group">    
                    <div class="row">
                        <div class="col-6">
                                <input type="button" class="btn btn-info"
                                onClick = "window.location.href = '<?php echo $carpeta_trabajo;?>/controladores/personal/controller.personal.php';"
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
