<?php
 
  include ($absolute_include."vistas/plantillas/head.php"); 
  include ($absolute_include."vistas/plantillas/sidebar.php"); 
  include ($absolute_include."vistas/plantillas/navbar.php"); 
 
?> 

<div class="container">
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-12">
            <h4>Eliminar Telefono</h4>

            <!-- este div es para mostrar los errorres de validacion 
                si hay errorres se muestra el div 
                y se hace un foreach de la coleccion de errores y se muestra
                en una lista -->

            <div class="alert alert-danger">
            </div>

            <!-- formulario para MOSTRAR -->
            <form action="<?php echo $carpeta_trabajo;?>/controladores/telefonos/controller.telefonos.php" method="POST" autocomplete="off">
         
                 <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">  
                 <input type="hidden" name="accion" value="eliminar">  
                 
                 <input type="hidden"  name="telefono_id" value="<?php echo $telefono['telefono_id']; ?>">

                <div class="form-group">
                    <label for="cdescripcion_direccion">Numero de Telefono</label>
                    <input type="text" class="form-control"  name="cnumero_telefono" value="<?php echo $telefono['cnumero_telefono']; ?>" readonly>
                    <label for="cdescripcion_direccion">Tipo de telefono</label>
                    <input type="text" class="form-control"  name="ntipo_telefono" value="<?php echo $telefono['ntipo_telefono']; ?>" readonly>
                    <label for="cdescripcion_direccion">Dueño del Telefono</label>
                    <input type="text" class="form-control"  name="rela_persona_id" value="<?php echo $telefono['rela_persona_id']; ?>" readonly>

                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-6">
                                <input type="button" class="btn btn-info"
                                onClick = "window.location.href = '<?php echo $carpeta_trabajo;?>/controladores/telefonos/controller.telefonos.php';"
                                value=Volver>
                        </div>
                        <div class="text-right" >
                                <span class="input-group-btn">
                                    <button class="btn btn-danger" type="submit">Eliminar</button>  
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
