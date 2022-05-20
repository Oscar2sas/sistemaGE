<?php
include($absolute_include . "vistas/plantillas/head.php");
include($absolute_include . "vistas/plantillas/sidebar.php");
include($absolute_include . "vistas/plantillas/navbar.php");
?>
<div class="container">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-12">
            <h4>Nueva Carrera</h4>

            <!-- este div es para mostrar los errorres de validacion 
                si hay errorres se muestra el div 
                y se hace un foreach de la coleccion de errores y se muestra
                en una lista -->

            <!-- formulario para CARGA -->
            <form action="<?php echo $carpeta_trabajo;?>/controladores/carreras/controller.carreras.php" method="POST" autocomplete="off">
         
                 <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">  
                 <input type="hidden" name="accion" value="guardar_carrera_nueva">  
                 
                <div class="form-group">
                    <label for="cnombre_pais">Descripción:</label>
                    <input type="text" class="form-control"  name="descripcion" placeholder="Ingrese el Nombre..." required >
                </div>
                
                    <div class="form-group">
                        <label for="semestrals">Tipo:</label>
                        <select class="form-control" name="semestrals">
                            <option value="2">CUATRIMESTRAL</option>
                            <option value="3">TRIMESTRAL</option>
                        </select>
                    </div>
                <br>
                <div class="form-group">
                <a href="http://192.168.2.103/htdocs/controladores/carreras/controller.carreras.php"><button class="btn btn-success float-right" type="button">Cancelar</button></a>    
                <button class="btn btn-success float-left" type="submit">Agregar</button>
                </div> 
            </form>
        </div>

    </div>

</div>



<?php
    include ($absolute_include."vistas/plantillas/footer.php"); 
?> 