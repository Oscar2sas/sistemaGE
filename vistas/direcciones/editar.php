<?php
 
  include ($absolute_include."vistas/plantillas/head.php"); 
  include ($absolute_include."vistas/plantillas/sidebar.php"); 
  include ($absolute_include."vistas/plantillas/navbar.php"); 
 
?> 

<div class="container">
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-12">
            <h4>Actualizar direccion</h4>

            <!-- este div es para mostrar los errorres de validacion 
                si hay errorres se muestra el div 
                y se hace un foreach de la coleccion de errores y se muestra
                en una lista -->

            <div class="alert alert-danger">
            </div>

            <!-- formulario para ACTUALIZACION -->
            <form action="<?php echo $carpeta_trabajo;?>/controladores/direcciones/controller.direcciones.php" method="POST" autocomplete="off">
         
                 <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">  
                 <input type="hidden" name="accion" value="actualizar">  
                 
                 <input type="hidden"  name="direccion_id" value="<?php echo $direccion['direccion_id']; ?>">

                <div class="form-group">
                <label for="cmanzana_direccion">Manzana</label>
                    <input type="text" class="form-control"  name="cmanzana_direccion" value="<?php echo $direccion['cmanzana_direccion']; ?>" >
                    <label for="ccasa_direccion">Casa</label>
                    <input type="text" class="form-control"  name="ccasa_direccion" value="<?php echo $direccion['ccasa_direccion']; ?>" >
                    <label for="csector_direccion">Sector</label>
                    <input type="text" class="form-control"  name="csector_direccion" value="<?php echo $direccion['csector_direccion']; ?>" >
                    <label for="clote_direccion">Lote</label>
                    <input type="text" class="form-control"  name="clote_direccion" value="<?php echo $direccion['clote_direccion']; ?>" >
                    <label for="cparcela_direccion">Parcela</label>
                    <input type="text" class="form-control"  name="cparcela_direccion" value="<?php echo $direccion['cparcela_direccion']; ?>" >
                    <label for="cdescripcion_direccion">Descripción</label>
                    <input type="text" class="form-control"  name="cdescripcion_direccion" value="<?php echo $direccion['cdescripcion_direccion']; ?>" >
                    <select name="rela_calle_id">
                    <?php foreach ($calles as $calle): ?>
                           
                            <option value = <?php echo $calle['calle_id']; ?> <?php if ($calle['calle_id']==$direccion['rela_calle_id']){echo "selected";}?>><?php echo $calle['cnombre_calle']; ?></option>

                    <?php endforeach; ?>
                    </select>          
                    <br>
                    <label for="nombre">Barrio</label>
                    <select name="rela_barrio_id">
                    <?php foreach ($barrios as $barrio): ?>
                           
                            <option value = <?php echo $barrio['barrio_id']; ?> <?php if ($barrio['barrio_id']==$direccion['rela_barrio_id']){echo "selected";}?>><?php echo $barrio['cnombre_barrio']; ?></option>

                    <?php endforeach; ?>
                    </select>
                    <br>
                    <label for="nombre">Localidad</label>
                    <select name="rela_localidad_id">
                    <?php foreach ($localidades as $localidad): ?>
                           
                            <option value = <?php echo $localidad['localidad_id']; ?> <?php if ($localidad['localidad_id']==$direccion['rela_localidad_id']){echo "selected";}?>><?php echo $localidad['cnombre_localidad']; ?></option>

                    <?php endforeach; ?>
                    </select>
                    <br>
                    <label for="nombre">Nombre de la persona</label>
                    <select name="rela_persona_id">
                    <?php foreach ($personas as $persona): ?>
                           
                            <option value = <?php echo $persona['persona_id']; ?> <?php if ($persona['persona_id']==$direccion['rela_persona_id']){echo "selected";}?>><?php echo $persona['cnombres_persona']; ?></option>

                    <?php endforeach; ?>

                    </select>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-6">
                                <input type="button" class="btn btn-info"
                                onClick = "window.location.href = '<?php echo $carpeta_trabajo;?>/controladores/direcciones/controller.direcciones.php';"
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
