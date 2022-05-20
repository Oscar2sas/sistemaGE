<?php
 
  include ($absolute_include."vistas/plantillas/head.php"); 
  include ($absolute_include."vistas/plantillas/sidebar.php"); 
  include ($absolute_include."vistas/plantillas/navbar.php"); 
 
?> 

<div class="container">
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-12">
            <h4>ERROR</h4>

            <!-- este div es para mostrar los errorres de validacion 
                si hay errorres se muestra el div 
                y se hace un foreach de la coleccion de errores y se muestra
                en una lista -->

            <div class="alert alert-danger text-center">
                <?php echo trim($validacion_errores['error']); ?>
            </div>

            <!-- formulario para llevar a crear de nuevo -->
            <form action="<?php echo $carpeta_trabajo;?>/controladores/paises/controller.paises.php" method="POST" autocomplete="off">
         
                 <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">  
                 <input type="hidden" name="accion" value="<?php if($validacion_errores['pais_id']<>0) {echo "editar";} else {echo "crear";} ?>">  
                 
                 <input type="hidden"  name="pais_id" value="<?php echo $validacion_errores['pais_id']; ?>">

                <div class="form-group">
                    <div class="row">
                       
                        <div class="text-right" >
                                <span class="input-group-btn">
                                    <button class="btn btn-info" type="submit">Volver</button>  
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
