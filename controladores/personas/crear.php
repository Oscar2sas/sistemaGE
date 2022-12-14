<?php
 
  include ($absolute_include."vistas/plantillas/head.php"); 
  include ($absolute_include."vistas/plantillas/sidebar.php"); 
  include ($absolute_include."vistas/plantillas/navbar.php"); 
 
?> 

<div class="container">
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-12">
            <h4>Nueva Persona</h4>

            <!-- este div es para mostrar los errorres de validacion 
                si hay errorres se muestra el div 
                y se hace un foreach de la coleccion de errores y se muestra
                en una lista -->

            <div class="alert alert-danger">
            </div>

            <!-- formulario para CARGA -->
            <form action="<?php echo $carpeta_trabajo;?>/controladores/personas/controller.personas.php" method="POST" autocomplete="off">
         
                 <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">  
                 <input type="hidden" name="accion" value="insertar">  
                 
                <div class="form-group">
                    <label for="apellido">Apellido de la Persona</label>
                    <input type="text" class="form-control"  name="capellidos_persona" placeholder="Ingrese el Apellido..." required>
                    <label for="nombre">Nombre de la Persona</label>
                    <input type="text" class="form-control"  name="cnombres_persona" placeholder="Ingrese el Nombre..." required>
                    <label for="dni">DNI de la Persona</label>
                    <input class="form-control" name="ndni_persona" placeholder="Ingrese el DNI..."  oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" type = "number" maxlength = "8"/>
                    <label for="cuil">CUIL de la Persona</label>
                    <input type="number" class="form-control"  name="ncuil_persona" placeholder="Ingrese el CUIL..." oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" type = "number" maxlength = "11">
                    <label for="email">Email de la Persona</label>
                    <input type="email" class="form-control"  name="cemail_persona" placeholder="Ingrese el EMAIL...">
                    <label for="fecha_nac">Fecha de nacimiento de la Persona</label>
                    <input type="date" class="form-control"  name="dfechanac_persona" placeholder="Ingrese la Fecha de Nacimiento..." required>
                    <label for="sexo">Sexo de la Persona</label>
                    <select type="select" class="form-control"  name="rela_sexo_id" placeholder="Ingrese el Sexo..." required>
                        <option value="1">Masculino</option>
                        <option value="2">Femenino</option>
                        <option value="3">Otros</option>
                    </select>
                </div>
                <h4>Telefonos</h4>
                    <div>
                        <label for="cnumero_telefono">Telefono:</label>
                        <input type="text" class="form-control"  name="cnumero_telefono" placeholder="Ingrese el N??mero de Tel??fono..." oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" type = "number" maxlength = "10" required>
                        <label for="sexo">Tipo del N??mero Telef??nico:</label>
                        <select type="select" class="form-control"  name="ntipo_telefono" placeholder="Ingrese el Tipo..." required>
                            <option value="1">Telefono Celular</option>
                            <option value="2">Telefono Fijo</option>
                            <option value="3">Otros</option>
                        </select>
                    </div>
                <h4>Direccion de la Persona</h4>
                <div class="form-group">
                    <label for="cmanzana_direccion">Manzana</label>
                    <input type="text" class="form-control"  name="cmanzana_direccion" placeholder = "Ingrese la Manzana">
                    <label for="ccasa_direccion">Casa</label>
                    <input type="text" class="form-control"  name="ccasa_direccion" placeholder = "Ingrese la Casa">
                    <label for="csector_direccion">Sector</label>
                    <input type="text" class="form-control"  name="csector_direccion" placeholder = "Ingrese la Sector">
                    <label for="clote_direccion">Lote</label>
                    <input type="text" class="form-control"  name="clote_direccion" placeholder = "Ingrese la Lote">
                    <label for="cparcela_direccion">Parcela</label>
                    <input type="text" class="form-control"  name="cparcela_direccion" placeholder = "Ingrese la Parcela">
                    <label for="cdescripcion_direccion">Descripci??n</label>
                    <input type="text" class="form-control"  name="cdescripcion_direccion" placeholder = "Ingrese la Descripcion">
                    <label for="nombre">Calle</label>
                    <select name="rela_calle_id" class="form-control">
                    <?php foreach ($calles as $calle): ?>
                           
                            <option value = <?php echo $calle['calle_id']; ?> ><?php echo $calle['cnombre_calle']; ?></option>

                    <?php endforeach; ?>
                    </select>          
                    <label for="nombre">Barrio</label>
                    <select name="rela_barrio_id" class="form-control">
                    <?php foreach ($barrios as $barrio): ?>
                           
                            <option value = <?php echo $barrio['barrio_id']; ?> ><?php echo $barrio['cnombre_barrio']; ?></option>

                    <?php endforeach; ?>
                    </select>
                    <label for="nombre">Localidad</label>
                    <select name="rela_localidad_id" class="form-control">
                    <?php foreach ($localidades as $localidad): ?>
                           
                            <option value = <?php echo $localidad['localidad_id']; ?> ><?php echo $localidad['cnombre_localidad']; ?></option>

                    <?php endforeach; ?>
                    </select>
                    <label for="nombre">Provincia</label>
                    <select name="rela_provincia_id" class="form-control">
                    <?php foreach ($provincias as $provincia): ?>
                           
                            <option value = <?php echo $provincia['provincia_id']; ?> ><?php echo $provincia['cnombre_provincia']; ?></option>

                    <?php endforeach; ?>
                </div>
                <br>
                <div class="form-group">
                    <div class="row">
                        <div class="col-6">
                                <input type="button" class="btn btn-info"
                                onClick = "window.location.href = '<?php echo $carpeta_trabajo;?>/controladores/personas/controller.personas.php';"
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
