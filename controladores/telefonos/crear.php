<?php
 
  include ($absolute_include."vistas/plantillas/head.php"); 
  include ($absolute_include."vistas/plantillas/sidebar.php"); 
  include ($absolute_include."vistas/plantillas/navbar.php"); 
 
?> 

<div class="container">
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-12">
            <h4>Nuevo telefono</h4>

            <!-- este div es para mostrar los errorres de validacion 
                si hay errorres se muestra el div 
                y se hace un foreach de la coleccion de errores y se muestra
                en una lista -->

            <div class="alert alert-danger">
            </div>

            <!-- formulario para CARGA -->
            <form action="<?php echo $carpeta_trabajo;?>/controladores/telefonos/controller.telefonos.php" method="POST" autocomplete="off">
         
                 <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">  
                 <input type="hidden" name="accion" value="insertar">  
                 
                <div class="form-group">
                    <label for="numero">Numero de telefono</label>
                    <input type="number" class="form-control"  name="cnumero_telefono" placeholder="Ingrese el Numero..." oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" type = "number" maxlength = "10">
                    <label for="ntipo_telefono">Tipo de Telefono</label>
                    <select name="ntipo_telefono">
                           
                            <option value = 1 >Telefono Celular</option>
                            <option value = 2 >Telefono Fijo</option>
                            <option value = 3 >Otro</option>

                    </select>
                    <br>
                    <label for="persona">Persona</label>
                    <select name="rela_persona_id">
                    <?php foreach ($personas as $persona): ?>
                           
                            <option value = <?php echo $persona['persona_id']; ?>><?php echo $persona['cnombres_persona']; ?></option>

                    <?php endforeach; ?>

                    </select>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-6">
                                <input type="button" class="btn btn-info"
                                onClick = "window.location.href = '<?php echo $carpeta_trabajo;?>/controladores/telefonos/controller.telefonos.php';"
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
