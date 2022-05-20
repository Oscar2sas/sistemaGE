<?php
 
  include ($absolute_include."vistas/plantillas/head.php"); 
  include ($absolute_include."vistas/plantillas/sidebar.php"); 
  include ($absolute_include."vistas/plantillas/navbar.php"); 

?> 

<div class="container">
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-12">
            <h4>Actualizar Parametro</h4>

            <!-- este div es para mostrar los errorres de validacion 
                si hay errorres se muestra el div 
                y se hace un foreach de la coleccion de errores y se muestra
                en una lista -->

            <div class="alert alert-danger">
            </div>

            <!-- formulario para ACTUALIZACION -->
            <form action="<?php echo $carpeta_trabajo;?>/controladores/parametros/controller.parametros.php" method="POST" autocomplete="off">
         
                 <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">  
                 <input type="hidden" name="accion" value="actualizar">  
                 
                 <input type="hidden"  name="id_parametro" value="<?php echo $parametro['id_parametro']; ?>">

                <div class="form-group">
                    <label for="nombre">Descripcion</label>
                    <input type="text" class="form-control"  name="descripcion" placeholder="Ingrese el Nombre..." value="<?php echo $parametro['descripcion']; ?>">
                </div>
                <div class="form-group">
                    <label for="nombre">Valor</label>
                    <input type="text" class="form-control"  name="valor" placeholder="Ingrese el valor..." 
                    value="<?php echo $parametro['valor']; ?>">
                </div>

                <div class="form-group">
                    <label for="nombre">Tipo Parametro</label>
                    <select class="form-control" name='parametro_tipo_id'>

                    <?php
                    foreach ($tipos_parametros as $tipos): 

                        if ($parametro[parametro_tipo_id] == $tipos[parametro_tipo_id] ){
                            echo "<option value='" . $tipos[parametro_tipo_id] . "' selected='selected'>" . utf8_encode($tipos["tipo_parametro"]) . "</option>";
                        }else {
                            echo "<option value='" . $tipos[parametro_tipo_id] . "'>" . ($tipos["tipo_parametro"]) . "</option>";
                        }
  
                        
                        
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
