<?php
 
  include ($absolute_include."vistas/plantillas/head.php"); 
  include ($absolute_include."vistas/plantillas/sidebar.php"); 
  include ($absolute_include."vistas/plantillas/navbar.php"); 
 
?> 

<div class="container">
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-12">
            <h4>Eliminar Log</h4>

            <!-- este div es para mostrar los errorres de validacion 
                si hay errorres se muestra el div 
                y se hace un foreach de la coleccion de errores y se muestra
                en una lista -->

            <div class="alert alert-danger">
            </div>

            <!-- formulario para MOSTRAR -->
            <form action="<?php echo $carpeta_trabajo;?>/controladores/log/controller.log.php" method="POST" autocomplete="off">
         
                 <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">  
                 <input type="hidden" name="accion" value="eliminar">  
                 
                 <input type="hidden"  name="log_id" value="<?php echo $log['log_id']; ?>">

                <div class="form-group">
                    <label for="nombre">Usuario</label>
                    <input type="text" class="form-control" value="<?php echo $log['cnombre_usuario']; ?>" readonly>
                </div>

                <div class="form-group">
                    <label for="nombre">Descripción</label>
                    <input type="text" class="form-control" value="<?php echo $log['cdescripcion_log']; ?>" readonly>
                </div>

                <div class="form-group">
                    <label for="nombre">Fecha</label>
                    <input type="text" class="form-control" value="<?php echo $log['dfecha_log']; ?>" readonly>
                </div>

                <div class="form-group">
                    <label for="nombre">Hora</label>
                    <input type="text" class="form-control" value="<?php echo $log['chora_log']; ?>" readonly>
                </div>




                <div class="form-group">
                    <div class="row">
                        <div class="col-6">
                                <input type="button" class="btn btn-info"
                                onClick = "window.location.href = '<?php echo $carpeta_trabajo;?>/controladores/log/controller.log.php';"
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
