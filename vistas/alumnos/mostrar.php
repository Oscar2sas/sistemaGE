<?php
 
  include ($absolute_include."vistas/plantillas/head.php"); 
  include ($absolute_include."vistas/plantillas/sidebar.php"); 
  include ($absolute_include."vistas/plantillas/navbar.php"); 
 
?> 

<div class="container">
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-12">
            <h4>Ver / Eliminar Personas</h4>

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
                    <label for="capellidos_persona">Apellido(s) de la Persona</label>
                    <input type="text" class="form-control"  name="capellidos_persona" value="<?php echo $persona['capellidos_persona']; ?>" readonly >
                </div>

                <div class="form-group">
                    <label for="cnombres_persona">Nombre(s) de la Persona</label>
                    <input type="text" class="form-control"  name="cnombres_persona"  value="<?php echo $persona['cnombres_persona']; ?>" readonly >
                </div>

                <div class="form-group">
                    <label for="ndni_persona">D.N.I. de la Persona</label>
                    <input type="number" class="form-control"  name="ndni_persona" size=10  value="<?php echo $persona['ndni_persona']; ?>" readonly >

                <div class="form-group">
                    <label for="ncuil_persona">CUIT/CUIL de la Persona</label>
                    <input type="number" class="form-control"  name="ncuil_persona" size=15 value="<?php echo $persona['ncuil_persona']; ?>" readonly >
                </div>

                <div class="form-group">
                    <label for="cemail_persona">Email de la Persona</label>
                    <input type="email" class="form-control"  name="cemail_persona"  value="<?php echo $persona['cemail_persona']; ?>" readonly >
                </div>

                <div class="form-group">
                    <label for="dfechanac_persona">Fecha de Nacimiento de la Persona</label>
                    <input type="date" class="form-control"  name="dfechanac_persona" value="<?php echo $persona['dfechanac_persona']; ?>" readonly >
                </div>

                <div class="form-group">
                    <label for="rela_sexo_id">Sexo</label><br>
                    <input type="text" class="form-control"  name="rela_sexo_id"  value="<?php echo $persona['cdescripcion_sexo']; ?>" readonly >
                </div>


                <div class="form-group">
                    <div class="row">
                        <div class="col-4">
                                <input type="button" class="btn btn-info"
                                onClick = "window.location.href = '<?php echo $carpeta_trabajo;?>/controladores/personas/controller.personas.php';"
                                value=Volver>
                        </div>
                        <div class="col-5">
                            <button type="button" onclick="javascript:window.print();" class="btn btn-warning"><i class="fa fa-print"></i> Imprimir</button>
                        </div>

                        <div class="text-right">
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
