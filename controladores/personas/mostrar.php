<?php
 
  include ($absolute_include."vistas/plantillas/head.php"); 
  include ($absolute_include."vistas/plantillas/sidebar.php"); 
  include ($absolute_include."vistas/plantillas/navbar.php"); 
 
?> 

<div class="container">
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-12">
            <h4>Eliminar Pais</h4>

            <!-- este div es para mostrar los errorres de validacion 
                si hay errorres se muestra el div 
                y se hace un foreach de la coleccion de errores y se muestra
                en una lista -->

            <div class="alert alert-danger">
            </div>

            <!-- formulario para MOSTRAR -->
            <form action="<?php echo $carpeta_trabajo;?>/controladores/personas/controller.personas.php" method="POST" autocomplete="off">
         
                 <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">  
                 <input type="hidden" name="accion" value="eliminar">  
                 
                 <input type="hidden"  name="persona_id" value="<?php echo $persona['persona_id']; ?>">

                <div class="form-group">
                    <label for="apellido">Apellido de la Persona</label>
                    <input type="text" class="form-control"  name="capellidos_persona" placeholder="Ingrese el Apellido..." value="<?php echo $persona['capellidos_persona']; ?>">
                    <label for="nombre">Nombre de la Persona</label>
                    <input type="text" class="form-control"  name="cnombres_persona" placeholder="Ingrese el Nombre..." value="<?php echo $persona['cnombres_persona']; ?>">
                    <label for="dni">DNI de la Persona</label>
                    <input type="number" class="form-control"  name="ndni_persona" placeholder="Ingrese el DNI..." value="<?php echo $persona['ndni_persona']; ?>">
                    <label for="cuil">CUIL de la Persona</label>
                    <input type="number" class="form-control"  name="ncuil_persona" placeholder="Ingrese el CUIL..." value="<?php echo $persona['ncuil_persona']; ?>">
                    <label for="email">Email de la Persona</label>
                    <input type="email" class="form-control"  name="cemail_persona" placeholder="Ingrese el Nombre..." value="<?php echo $persona['cemail_persona']; ?>">
                    <label for="fecha_nac">Fecha de nacimiento de la Persona</label>
                    <input type="date" class="form-control"  name="dfechanac_persona" placeholder="Ingrese el Nombre..." value="<?php echo $persona['dfechanac_persona']; ?>">
                    
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-6">
                                <input type="button" class="btn btn-info"
                                onClick = "window.location.href = '<?php echo $carpeta_trabajo;?>/controladores/personas/controller.personas.php';"
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
