<?php
 
  include ($absolute_include."vistas/plantillas/head.php"); 
  include ($absolute_include."vistas/plantillas/sidebar.php"); 
  include ($absolute_include."vistas/plantillas/navbar.php"); 
 
?>

<div class="container">
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-12">
            <h4>Actualizar Persona</h4>

            <!-- este div es para mostrar los errorres de validacion 
                si hay errorres se muestra el div 
                y se hace un foreach de la coleccion de errores y se muestra
                en una lista -->

            <div class="alert alert-danger">
            </div>

            <!-- formulario para ACTUALIZACION -->
            <form action="<?php echo $carpeta_trabajo;?>/controladores/personas/controller.personas.php" method="POST"
                autocomplete="off">

                <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
                <input type="hidden" name="accion" value="actualizar">

                <input type="hidden" name="persona_id" value="<?php echo $persona['persona_id']; ?>">


                <div class="form-group">
                    <label for="apellido">Apellido de la Persona</label>
                    <input type="text" class="form-control" name="capellidos_persona"
                        placeholder="Ingrese el Apellido..." value="<?php echo $persona['capellidos_persona']; ?>">
                    <label for="nombre">Nombre de la Persona</label>
                    <input type="text" class="form-control" name="cnombres_persona" placeholder="Ingrese el Nombre..."
                        value="<?php echo $persona['cnombres_persona']; ?>">
                    <label for="dni">DNI de la Persona</label>
                    <input type="number" class="form-control" name="ndni_persona"
                        placeholder="Ingrese el DNI sin puntos..." value="<?php echo $persona['ndni_persona']; ?>"
                        oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                        type="number" maxlength="8" readonly>
                    <label for="cuil">CUIL de la Persona</label>
                    <input type="number" class="form-control" name="ncuil_persona" placeholder="Ingrese el CUIL..."
                        value="<?php echo $persona['ncuil_persona']; ?>"
                        oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                        type="number" maxlength="11" readonly>
                    <label for="email">Email de la Persona</label>
                    <input type="email" class="form-control" name="cemail_persona" placeholder="Ingrese el Nombre..."
                        value="<?php echo $persona['cemail_persona']; ?>">
                    <label for="fecha_nac">Fecha de nacimiento de la Persona</label>
                    <input type="date" class="form-control" name="dfechanac_persona" placeholder="Ingrese el Nombre..."
                        value="<?php echo $persona['dfechanac_persona']; ?>">
                </div>
                <h4>Telefonos</h4>
                <div>
                    <label for="cnumero_telefono">Telefono:</label>
                    <input type="text" class="form-control" name="cnumero_telefono"
                        placeholder="Ingrese el Número de Teléfono..."
                        oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                        type="number" maxlength="10" required>
                    <label for="sexo">Tipo del Número Telefónico:</label>
                    <select type="select" class="form-control" name="ntipo_telefono" placeholder="Ingrese el Tipo..."
                        required>
                        <option value="1">Telefono Celular</option>
                        <option value="2">Telefono Fijo</option>
                        <option value="3">Otros</option>
                    </select>
                
                </div>
                <h4>Direccion de la Persona</h4>

                <div class="form-group">
                    <label for="cmanzana_direccion">Manzana</label>
                    <input type="text" class="form-control" name="cmanzana_direccion"
                        value="<?php echo $persona['cmanzana_direccion']; ?>">
                    <label for="ccasa_direccion">Casa</label>
                    <input type="text" class="form-control" name="ccasa_direccion"
                        value="<?php echo $persona['ccasa_direccion']; ?>">
                    <label for="csector_direccion">Sector</label>
                    <input type="text" class="form-control" name="csector_direccion"
                        value="<?php echo $persona['csector_direccion']; ?>">
                    <label for="clote_direccion">Lote</label>
                    <input type="text" class="form-control" name="clote_direccion"
                        value="<?php echo $persona['clote_direccion']; ?>">
                    <label for="cparcela_direccion">Parcela</label>
                    <input type="text" class="form-control" name="cparcela_direccion"
                        value="<?php echo $persona['cparcela_direccion']; ?>">
                    <label for="cdescripcion_direccion">Descripción</label>
                    <input type="text" class="form-control" name="cdescripcion_direccion"
                        value="<?php echo $persona['cdescripcion_direccion']; ?>">
                    <select name="rela_calle_id">
                        <?php foreach ($calles as $calle): ?>

                        <option value=<?php echo $calle['calle_id']; ?>
                            <?php if ($calle['calle_id']==$persona['rela_calle_id']){echo "selected";}?>>
                            <?php echo $calle['cnombre_calle']; ?></option>

                        <?php endforeach; ?>
                    </select>
                    <br>
                    <label for="nombre">Barrio</label>
                    <select name="rela_barrio_id">
                        <?php foreach ($barrios as $barrio): ?>

                        <option value=<?php echo $barrio['barrio_id']; ?>
                            <?php if ($barrio['barrio_id']==$persona['rela_barrio_id']){echo "selected";}?>>
                            <?php echo $barrio['cnombre_barrio']; ?></option>

                        <?php endforeach; ?>
                    </select>
                    <br>
                    <label for="nombre">Localidad</label>
                    <select name="rela_localidad_id">
                        <?php foreach ($localidades as $localidad): ?>

                        <option value=<?php echo $localidad['localidad_id']; ?>
                            <?php if ($localidad['localidad_id']==$persona['rela_localidad_id']){echo "selected";}?>>
                            <?php echo $localidad['cnombre_localidad']; ?></option>

                        <?php endforeach; ?>
                    </select>
                </div>
                <br>
                <div class="form-group">
                    <div class="row">
                        <div class="col-6">
                            <input type="button" class="btn btn-info"
                                onClick="window.location.href = '<?php echo $carpeta_trabajo;?>/controladores/personas/controller.personas.php';"
                                value=Volver>
                        </div>
                        <div class="text-right">
                            <button class="btn btn-success" type="submit">Guardar</button>
                            <span class="input-group-btn">
                                <button class="btn btn-danger" type="reset">Cancelar</button>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-6">
                            <input type="button" class="btn btn-info"
                                onClick="window.location.href = '<?php echo $carpeta_trabajo;?>/controladores/personas/controller.personas.php';"
                                value=Volver>
                            <button class="btn btn-success" type="submit">Guardar</button>
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