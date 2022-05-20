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

            <h5>Datos B&aacute;sicos</h5>
            <hr>

            <!-- formulario para CARGA -->
            <form action="<?php echo $carpeta_trabajo;?>/controladores/personas/controller.personas.php" method="POST" autocomplete="off">
         
                 <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">  
                 <input type="hidden" name="accion" value="insertar">  
                 
                <div class="form-group">
                    <label for="capellidos_persona">Apellido(s) de la Persona</label>
                    <input type="text" class="form-control"  name="capellidos_persona" placeholder="Ingrese el/los Apellido(s)..." required >
                </div>
               
                <div class="form-group">
                    <label for="cnombres_persona">Nombre(s) de la Persona</label>
                    <input type="text" class="form-control"  name="cnombres_persona" placeholder="Ingrese el/los Nombre(s)..." required >
                </div>
               
                <div class="form-group">
                    <label for="ndni_persona">D.N.I. de la Persona</label>
                    <input type="number" class="form-control"  name="ndni_persona" size=10 placeholder="Ingrese el DNI (sin puntos)..." required >
                </div>
                <div class="form-group">
                    <label for="ncuil_persona">CUIT/CUIL de la Persona</label>
                    <input type="number" class="form-control"  name="ncuil_persona" size=15 placeholder="Ingrese el CUIT/CUIL (sin puntos)..." required >
                </div>
                
                <div class="form-group">
                    <label for="cemail_persona">Email de la Persona</label>
                    <input type="email" class="form-control"  name="cemail_persona" placeholder="Ingrese el Email..." >
                </div>
 
                <div class="form-group">
                    <label for="dfechanac_persona">Fecha de Nacimiento de la Persona</label>
                    <input type="date" class="form-control"  name="dfechanac_persona" >
                </div>
          
                <div class="form-group">
                    <label for="rela_sexo_id">Sexo</label><br>
                     <!-- select de sexos -->
                    <select class="select-dropdown-menu" name="rela_sexo_id" style="width:100%">
                        <?php foreach ($sexos as $sexo): ?>
                            <option value="<?php echo $sexo['sexo_id']?>"><?php echo $sexo['cdescripcion_sexo']?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <br><br>
                <h5>Direcci&oacute;n</h5>
                <hr>

                <div class="form-group">
                    <label for="cdescripcion_direccion">Descripci&oacute;n de la direcci&oacute;n</label>
                    <input type="text" class="form-control"  name="cdescripcion_direccion" placeholder="Ingrese la descripci&oacute;n..." required >
                </div>          
                <div class="form-group">
                    <div class="row">
                        <div class="col-8">
                            <label for="rela_calle_id">Calle</label><br>
                            <!-- select de calles -->
                            <select class="select-dropdown-menu" name="rela_calle_id" style="width:100%">
                                <?php foreach ($calles as $calle): ?>
                                    <option value="<?php echo $calle['calle_id']?>"><?php echo $calle['cnombre_calle']?></option>
                                <?php endforeach; ?>
                            </select>

                        </div>
                        <div class="col-4">
                            <label for="nnumero_direccion">Altura</label>
                            <input type="number" class="form-control"  name="nnumero_direccion" >
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-4">
                            <label for="cmanzana_direccion">Manzana</label>
                            <input type="number" class="form-control"  name="cmanzana_direccion" >
                        </div>
                        <div class="col-4">
                            <label for="csector_direccion">Sector</label>
                            <input type="text" class="form-control"  name="csector_direccion" >
                        </div>
                        <div class="col-4">
                            <label for="cparcela_direccion">Parcela</label>
                            <input type="number" class="form-control"  name="cparcela_direccion" >
                        </div>
                    </div>
                </div>
                <div class="form-group">

                    <div class="row">
                        <div class="col-4">
                            <label for="clote_direccion">Lote</label>
                            <input type="number" class="form-control"  name="clote_direccion" >
                        </div>
                        <div class="col-4">
                            <label for="ccasa_direccion">Casa</label>
                            <input type="text" class="form-control"  name="ccasa_direccion" >
                        </div>
                    </div>
                </div>
               
                <div class="form-group">
                    <label for="rela_barrio_id">Barrio</label><br>
                    <!-- select de barrios -->
                    <select class="select-dropdown-menu" name="rela_barrio_id" style="width:100%">
                        <?php foreach ($barrios as $barrio): ?>
                            <option value="<?php echo $barrio['barrio_id']?>"><?php echo $barrio['cnombre_barrio']?></option>
                        <?php endforeach; ?>
                    </select>

                </div>

                <div class="form-group">
                    <label for="rela_localidad_id">Localidad / Provincia / Pais</label><br>
                     <!-- select de localidades -->
                    <select class="select-dropdown-menu" name="rela_localidad_id" style="width:100%">
                        <?php foreach ($localidades as $localidad): ?>
                            <option value="<?php echo $localidad['localidad_id']?>"><?php echo $localidad['cnombre_localidad']." | ".$localidad['cnombre_provincia']." | ".$localidad['cnombre_pais']?></option>
                        <?php endforeach; ?>
                    </select>

                </div>

                <br><br>
                <h5>Tel&eacute;fono</h5>
                <hr>

                <div class="form-group">
                    <label for="ntipo_telefono">Tipo</label><br>
                    <!-- select de barrios -->
                    <select class="select-dropdown-menu" name="ntipo_telefono" style="width:100%">
                       <option value="1">Celular/Movil</option>
                       <option value="2">Tel&eacute;fono Fijo</option>
                       <option value="3">Otros</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="cnumero_telefono">N&uacute;mero</label>
                    <input type="text" class="form-control"  name="cnumero_telefono" placeholder="Ingrese el numero de Tel&eacute;fono..." required >
                </div>          
          
                <div class="form-group">
                    <div class="row">
                        <div class="col-7">
                                <input type="button" class="btn btn-info"
                                onClick = "window.location.href = '<?php echo $carpeta_trabajo;?>/controladores/personas/controller.personas.php';"
                                value=Volver>
                        </div>
                        <div class="title-right" >
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
