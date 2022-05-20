<?php
 
  include ($absolute_include."vistas/plantillas/head.php"); 
  include ($absolute_include."vistas/plantillas/sidebar.php"); 
  include ($absolute_include."vistas/plantillas/navbar.php"); 
 
?> 

<div class="container">
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-12">
            <h4>Actualizar Estado</h4>

            <!-- este div es para mostrar los errorres de validacion 
                si hay errorres se muestra el div 
                y se hace un foreach de la coleccion de errores y se muestra
                en una lista -->

            <div class="alert alert-danger">
            </div>

            <!-- formulario para ACTUALIZACION -->
            <form action="<?php echo $carpeta_trabajo;?>/controladores/estadodocentes/controller.estadodocentes.php" method="POST" autocomplete="off">
         
                 <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">  
                 <input type="hidden" name="accion" value="actualizar">  
                 
                 <input type="hidden"  name="estadodocente_id" value="<?php echo $estadodocente['estadodocente_id']; ?>">

                <div class="form-group">
                    <label for="nombre">Descripci&oacute;n del Estado</label>
                    <input type="text" class="form-control"  name="cdescripcion_estadodocente" placeholder="Ingrese la Descripci&oacute;n..." value="<?php echo $estadodocente['cdescripcion_estadodocente']; ?>" required >
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-7">
                                <input type="button" class="btn btn-info"
                                onClick = "window.location.href = '<?php echo $carpeta_trabajo;?>/controladores/estadodocentes/controller.estadodocentes.php';"
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
