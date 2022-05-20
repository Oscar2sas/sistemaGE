<?php
 
  include ($absolute_include."vistas/plantillas/head.php"); 
  include ($absolute_include."vistas/plantillas/sidebar.php"); 
  include ($absolute_include."vistas/plantillas/navbar.php"); 
 
?> 

<div class="container">
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-12">
            <h4>Actualizar Personas</h4>

            <!-- este div es para mostrar los errorres de validacion 
                si hay errorres se muestra el div 
                y se hace un foreach de la coleccion de errores y se muestra
                en una lista -->

            <div class="alert alert-danger">
            </div>
          
            <h5>Datos B&aacute;sicos</h5>
            <hr>

            <!-- formulario para ACTUALIZACION -->
            <form id="formularioprincipal" action="<?php echo $carpeta_trabajo;?>/controladores/personas/controller.personas.php" method="POST" autocomplete="off">
         
                 <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">  
                 <input type="hidden" name="accion" value="actualizar" >  
                 
                 <input type="hidden"  name="persona_id" value="<?php echo $persona['persona_id']; ?>">

                <div class="form-group">
                    <label for="capellidos_persona">Apellido(s) de la Persona</label>
                    <input type="text" class="form-control"  name="capellidos_persona" placeholder="Ingrese el/los Apellido(s)..." value="<?php echo $persona['capellidos_persona']; ?>" required >
                </div>
               
                <div class="form-group">
                    <label for="cnombres_persona">Nombre(s) de la Persona</label>
                    <input type="text" class="form-control"  name="cnombres_persona" placeholder="Ingrese el/los Nombre(s)..." value="<?php echo $persona['cnombres_persona']; ?>" required >
                </div>
               
                <div class="form-group">
                    <label for="ndni_persona">D.N.I. de la Persona</label>
                    <input type="number" class="form-control"  name="ndni_persona" size=10 placeholder="Ingrese el DNI (sin puntos)..."  value="<?php echo $persona['ndni_persona']; ?>" required >
                </div>
                <div class="form-group">
                    <label for="ncuil_persona">CUIT/CUIL de la Persona</label>
                    <input type="number" class="form-control"  name="ncuil_persona" size=15 placeholder="Ingrese el CUIT/CUIL (sin puntos)..."  value="<?php echo $persona['ncuil_persona']; ?>" required >
                </div>
                
                <div class="form-group">
                    <label for="cemail_persona">Email de la Persona</label>
                    <input type="email" class="form-control"  name="cemail_persona" placeholder="Ingrese el Email..."  value="<?php echo $persona['cemail_persona']; ?>">
                </div>
 
                <div class="form-group">
                    <label for="dfechanac_persona">Fecha de Nacimiento de la Persona</label>
                    <input type="date" class="form-control"  name="dfechanac_persona" value="<?php echo $persona['dfechanac_persona']; ?>" >
                </div>
          
                <div class="form-group">
                    <label for="rela_sexo_id">Sexo</label><br>
                     <!-- select de sexos -->
                    <select class="select-dropdown-menu" name="rela_sexo_id" style="width:100%" >
                        <?php foreach ($sexos as $sexo): ?>
                            <option value="<?php echo $sexo['sexo_id']?>"<?php if( $sexo['sexo_id']==$persona['rela_sexo_id']){ echo "SELECTED" ;}?> ><?php echo $sexo['cdescripcion_sexo']?></option>
                        <?php endforeach; ?>
                    </select>

                </div>
            </form>

            <br><br>
            <div class="row  align-middle">
                <div class="title_left col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    <h5>Direcci&oacute;n(es)</h5>
                </div>

                <!-- boton  para agregar -->
                <div class="title_right col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    <form action="<?php echo $carpeta_trabajo;?>/controladores/personas/controller.personas.php" method="POST">
                      <input type="hidden" name="accion" value="creardireccion">  
                      <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">  
                      <input type="hidden" name="persona_id" value="<?php echo $persona['persona_id']; ?>">  
                      <button type="submit" class="btn btn-round btn-success btn-block"><i class="fa fa-plus" ></i> Agregar Direcci&oacute;n</button>
                    </form> 
                </div>
            </div>
            <hr>
        
            <!-- matriz de direcciones -->

            <?php foreach ($direcciones as $direccion): ?>
                <div class="form-group">
                    <label for="cdescripcion_direccion">Descripci&oacute;n de la direcci&oacute;n</label>
                    <input type="text" class="form-control"  name="cdescripcion_direccion" value="<?php echo $direccion['cdescripcion_direccion']; ?>" readonly >
                </div>          
                <div class="form-group">
                    <div class="row">
                        <div class="col-8">
                            <label for="rela_calle_id">Calle</label><br>
                            <input type="text" class="form-control"  name="rela_calle_id" value="<?php echo $direccion['cnombre_calle']; ?>" readonly >
                        </div>
                        <div class="col-4">
                            <label for="nnumero_direccion">Altura</label>
                            <input type="number" class="form-control"  name="nnumero_direccion" value="<?php echo $direccion['nnumero_direccion']; ?>" readonly >
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-4">
                            <label for="cmanzana_direccion">Manzana</label>
                            <input type="number" class="form-control"  name="cmanzana_direccion" value="<?php echo $direccion['cmanzana_direccion']; ?>" readonly>
                        </div>
                        <div class="col-4">
                            <label for="csector_direccion">Sector</label>
                            <input type="text" class="form-control"  name="csector_direccion" value="<?php echo $direccion['csector_direccion']; ?>" readonly>
                        </div>
                        <div class="col-4">
                            <label for="cparcela_direccion">Parcela</label>
                            <input type="number" class="form-control"  name="cparcela_direccion" value="<?php echo $direccion['cparcela_direccion']; ?>" readonly>
                        </div>
                    </div>
                </div>
                <div class="form-group">

                    <div class="row">
                        <div class="col-4">
                            <label for="clote_direccion">Lote</label>
                            <input type="number" class="form-control"  name="clote_direccion" value="<?php echo $direccion['clote_direccion']; ?>" readonly>
                        </div>
                        <div class="col-4">
                            <label for="ccasa_direccion">Casa</label>
                            <input type="text" class="form-control"  name="ccasa_direccion" value="<?php echo $direccion['ccasa_direccion']; ?>" readonly>
                        </div>
                    </div>
                </div>
            
                <div class="form-group">
                    <label for="rela_barrio_id">Barrio</label><br>
                    <input type="text" class="form-control"  name="rela_barrio_id" value="<?php echo $direccion['cnombre_barrio']; ?>" readonly>
                </div>
            
                <div class="form-group">
                    <label for="rela_localidad_id">Localidad / Provincia / Pais</label><br>
                    <input type="text" class="form-control"  name="rela_localidad_id" value="<?php echo $direccion['cnombre_localidad']; ?>" readonly>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-8">
                            Opciones
                        </div>
                        <div class="title_right col-lg-2 col-md-2 col-sm-2 col-xs-2">
                            <form action="<?php echo $carpeta_trabajo;?>/controladores/personas/controller.personas.php" method="POST">
                                <input type="hidden" name="accion" value="editardireccion">  
                                <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">  
                                <input type="hidden" name="direccion_id" value="<?php echo $direccion['direccion_id']; ?>">  
                                <button type="submit" class="btn btn-info "><i class="fa fa-pencil" ></i></button>
                            </form> 
                        </div>
                        <div class="title_right col-lg-1 col-md-1 col-sm-1 col-xs-1">
                        
                            <form action="<?php echo $carpeta_trabajo;?>/controladores/personas/controller.personas.php" method="POST">
                                <input type="hidden" name="accion" value="mostrardireccion">  
                                <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">  
                                <input type="hidden" name="direccion_id" value="<?php echo $direccion['direccion_id']; ?>">  
                                <button type="submit" class="btn btn-danger "><i class="fa fa-trash" ></i></button>
                            </form> 
                        </div>
                    </div>
                </div>   

            <?php endforeach; ?>

            <br><br>

            <div class="row  align-middle">
                <div class="title_left col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    <h5>Tel&eacute;fono(s)</h5>
                </div>
                <!-- boton  para agregar -->
                <div class="title_right col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    <form action="<?php echo $carpeta_trabajo;?>/controladores/personas/controller.personas.php" method="POST">
                      <input type="hidden" name="accion" value="creartelefono">  
                      <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">  
                      <input type="hidden" name="persona_id" value="<?php echo $persona['persona_id']; ?>">  
                      <button type="submit" class="btn btn-round btn-success btn-block"><i class="fa fa-plus" ></i> Agregar Tel&eacute;fono</button>
                    </form> 
                </div>
            </div>
            <hr>

            <!-- matriz de telefonos -->

            <?php foreach ($telefonos as $telefono): ?>

                <div class="form-group">
                    <label for="ntipo_telefono">Tipo</label><br>
                    <input type="text" class="form-control"  name="ntipo_telefono"  value="<?php 
                        if($telefono['ntipo_telefono']== 1) {  echo "Celular/Movil";}
                        elseif ($telefono['ntipo_telefono']== 2) {  echo "Tel&eacute;fono Fijo";}
                        else {  echo "Otros";}
                    ?>" readonly >
                 
                </div>

                <div class="form-group">
                    <label for="cnumero_telefono">N&uacute;mero</label>
                    <input type="text" class="form-control"  name="cnumero_telefono" value="<?php echo $telefono['cnumero_telefono']; ?>" readonly >
                </div>   

                <div class="form-group">
                    <div class="row">
                        <div class="col-8">
                            Opciones
                        </div>
                        <div class="title_right col-lg-2 col-md-2 col-sm-2 col-xs-2">
                            <form action="<?php echo $carpeta_trabajo;?>/controladores/personas/controller.personas.php" method="POST">
                                <input type="hidden" name="accion" value="editartelefono">  
                                <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">  
                                <input type="hidden" name="telefono_id" value="<?php echo $telefono['telefono_id']; ?>">  
                                <button type="submit" class="btn btn-info "><i class="fa fa-pencil" ></i></button>
                            </form> 
                        </div>
                        <div class="title_right col-lg-1 col-md-1 col-sm-1 col-xs-1">
                        
                            <form action="<?php echo $carpeta_trabajo;?>/controladores/personas/controller.personas.php" method="POST">
                                <input type="hidden" name="accion" value="mostrartelefono">  
                                <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">  
                                <input type="hidden" name="telefono_id" value="<?php echo $telefono['telefono_id']; ?>">  
                                <button type="submit" class="btn btn-danger "><i class="fa fa-trash" ></i></button>
                            </form> 
                        </div>
                    </div>
                </div>       
                
            <?php endforeach; ?>

            <br><br>
            <div class="form-group">
                <div class="row">
                    <div class="col-7">
                            <input type="button" class="btn btn-info"
                            onClick = "window.location.href = '<?php echo $carpeta_trabajo;?>/controladores/personas/controller.personas.php';"
                            value=Volver>
                    </div>
                    <div class="text-right" >
                        <input type="button" class="btn btn-success" 
                                onClick = "document.getElementById('formularioprincipal').submit();" value="Guardar"> 
                        <span class="input-group-btn">
                        <input type="button" class="btn btn-danger" 
                                onClick = "document.getElementById('formularioprincipal').reset();" value="Cancelar">
                        </span>   
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

<?php

    include ($absolute_include."vistas/plantillas/footer.php"); 
?>    
