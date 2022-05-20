<?php
 
  include ($absolute_include."vistas/plantillas/head.php"); 
  include ($absolute_include."vistas/plantillas/sidebar.php"); 
  include ($absolute_include."vistas/plantillas/navbar.php"); 
 
?> 

<div class="container">
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-12">
            <h4>Nuevo Alumno</h4>

            <!-- este div es para mostrar los errorres de validacion 
                si hay errorres se muestra el div 
                y se hace un foreach de la coleccion de errores y se muestra
                en una lista -->

            <div class="alert alert-danger">
            </div>

            <!-- formulario para busqueda -->
            <form action="<?php echo $carpeta_trabajo;?>/controladores/alumnos/controller.alumnos.php" method="POST" autocomplete="off">

            <?php
 
                include ($absolute_include."vistas/plantillas/personas/plantilla_buscarpersona_por_dniocuil.php"); 
            ?> 

            </form>
            <div class="col-7">
                    <input type="button" class="btn btn-info"
                    onClick = "window.location.href = '<?php echo $carpeta_trabajo;?>/controladores/alumnos/controller.alumnos.php';"
                    value=Volver>
            </div>
        </div>    
    </div>

</div>

<?php

    include ($absolute_include."vistas/plantillas/footer.php"); 
?>    
