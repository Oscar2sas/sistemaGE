<?php
 
  include ($absolute_include."vistas/plantillas/head.php"); 
  include ($absolute_include."vistas/plantillas/sidebar.php"); 
  include ($absolute_include."vistas/plantillas/navbar.php"); 
 
?> 

<div class="container">
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-12">
            <h4>Actualizar Pais</h4>

            <!-- este div es para mostrar los errorres de validacion 
                si hay errorres se muestra el div 
                y se hace un foreach de la coleccion de errores y se muestra
                en una lista -->

            <div class="alert alert-danger">
            </div>
           <?php foreach ($resultadoBusquedaCarrera as $rowcarreras) :?>
            <!-- formulario para ACTUALIZACION -->
            <form action="<?php echo $carpeta_trabajo;?>/controladores/carreras/controller.carreras.php" method="POST" autocomplete="off">
         
                 <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">  
                 <input type="hidden" name="accion" value="guardar_modificacion_carrera">  
                 <input type="hidden"  name="carrera_id" value="<?php echo $rowcarreras['carrera_id']; ?>">

                <div class="form-group">
                    <label for="nombre">Descripción</label>
                    <input type="text" class="form-control"  name="cdescripcion_carrera" placeholder="Ingrese el Nombre..." value="<?php  echo $rowcarreras['cdescripcion_carrera']; ?>" required >
                </div>
                <div class="form-group">
                    <select name = "semestre" class="form-control">
                        <option value="3">TRIMESTRE</option>
                        <option value="2">CUATRIMESTRE</option>
                    </select>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-6">
                                <input type="button" class="btn btn-info"
                                onClick = "window.location.href = '<?php echo $carpeta_trabajo;?>/controladores/paises/controller.carreras.php';"
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
        <?php endforeach; ?>
        </div>

    </div>

</div>

<?php

    include ($absolute_include."vistas/plantillas/footer.php"); 
?>    
