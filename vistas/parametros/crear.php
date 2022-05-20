<?php
 
  include ($absolute_include."vistas/plantillas/head.php"); 
  include ($absolute_include."vistas/plantillas/sidebar.php"); 
  include ($absolute_include."vistas/plantillas/navbar.php"); 
  
?> 

<div class="container">
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-12">
            <h4>Nuevo Parametro</h4>

            <!-- este div es para mostrar los errorres de validacion 
                si hay errorres se muestra el div 
                y se hace un foreach de la coleccion de errores y se muestra
                en una lista -->

            <div class="alert alert-danger">
            </div>

            <!-- formulario para CARGA -->
            <form action="<?php echo $carpeta_trabajo;?>/controladores/parametros/controller.parametros.php" method="POST" autocomplete="off">
         
                 <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">  
                 <input type="hidden" name="accion" value="insertar">  
                 
                <div class="form-group">
                    <label for="nombre">Nombre del parametro</label>
                    <input type="text" class="form-control"  name="descripcion" placeholder="Ingrese el Nombre...">
                </div>
                <div class="form-group">
                    <label for="nombre">Valor del parametro</label>
                    <input type="text" class="form-control"  name="valor" placeholder="Ingrese el valor...">
                </div>

                <div class="form-group">
                    <label for="nombre">Tipo</label>
                    <select class="form-control" name='parametro_tipo_id'>
                    <option value = '0'> Seleccione el tipo:</option>
                    <?php
                    foreach ($tipos_parametros as $tipos): 

                        echo "<option value='" . $tipos['parametro_tipo_id'] . "'>" .($tipos["tipo_parametro"]) . "</option>";
  
                    endforeach;
                    ?>
                    </select>
                </div>    

                <div class="form-group">
                    <div class="row">
                        <div class="col-6">
                                <input type="button" class="btn btn-info"
                                onClick = "window.location.href = '<?php echo $carpeta_trabajo;?>/controladores/parametros/controller.parametros.php';"
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
