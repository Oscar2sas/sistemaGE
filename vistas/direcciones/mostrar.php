<?php
 
  include ($absolute_include."vistas/plantillas/head.php"); 
  include ($absolute_include."vistas/plantillas/sidebar.php"); 
  include ($absolute_include."vistas/plantillas/navbar.php"); 
 
?> 

<div class="container">
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-12">
            <h4>Eliminar Direccion</h4>

            <!-- este div es para mostrar los errorres de validacion 
                si hay errorres se muestra el div 
                y se hace un foreach de la coleccion de errores y se muestra
                en una lista -->

            <div class="alert alert-danger">
            </div>

            <!-- formulario para MOSTRAR -->
            <form action="<?php echo $carpeta_trabajo;?>/controladores/direcciones/controller.direcciones.php" method="POST" autocomplete="off">
         
                 <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">  
                 <input type="hidden" name="accion" value="eliminar">  
                 
                 <input type="hidden"  name="direccion_id" value="<?php echo $direccion['direccion_id']; ?>">

                <div class="form-group">
                    <label for="cdescripcion_direccion">Descripción</label>
                    <input type="text" class="form-control"  name="cdescripcion_direccion" value="<?php echo $direccion['cdescripcion_direccion']; ?>" readonly>
                    <label for="cmanzana_direccion">Manzana</label>
                    <input type="text" class="form-control"  name="cmanzana_direccion" value="<?php echo $direccion['cmanzana_direccion']; ?>" readonly>
                    <label for="ccasa_direccion">Casa</label>
                    <input type="text" class="form-control"  name="ccasa_direccion" value="<?php echo $direccion['ccasa_direccion']; ?>" readonly>
                    <label for="csector_direccion">Sector</label>
                    <input type="text" class="form-control"  name="csector_direccion" value="<?php echo $direccion['csector_direccion']; ?>" readonly>
                    <label for="clote_direccion">Lote</label>
                    <input type="text" class="form-control"  name="clote_direccion" value="<?php echo $direccion['clote_direccion']; ?>" readonly>
                    <label for="cparcela_direccion">Parcela</label>
                    <input type="text" class="form-control"  name="cparcela_direccion" value="<?php echo $direccion['cparcela_direccion']; ?>" readonly>
                    <label for="rela_calle_id">Calle</label>
                    <input type="text" class="form-control"  name="rela_calle_id" value="<?php echo $direccion['cnombre_calle']; ?>" readonly>
                    <label for="rela_barrio_id">Barrio</label>
                    <input type="text" class="form-control"  name="rela_barrio_id" value="<?php echo $direccion['cnombre_barrio']; ?>" readonly>
                    <label for="rela_localidad_id">Localidad</label>
                    <input type="text" class="form-control"  name="rela_localidad_id" value="<?php echo $direccion['cnombre_localidad']; ?>" readonly>
                    <label for="rela_persona_id">Nombre de la Persona</label>
                    <input type="text" class="form-control"  name="rela_persona_id" value="<?php echo $direccion['capellidos_persona'] . " " . $direccion['cnombres_persona']; ?>" readonly>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-6">
                                <input type="button" class="btn btn-info"
                                onClick = "window.location.href = '<?php echo $carpeta_trabajo;?>/controladores/direcciones/controller.direcciones.php';"
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
