<?php
 
  include ($absolute_include."vistas/plantillas/head.php"); 
  include ($absolute_include."vistas/plantillas/sidebar.php"); 
  include ($absolute_include."vistas/plantillas/navbar.php"); 
  include ($absolute_include."clases/conexion.php");
?> 

<div class="container">
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-12">
            <h4>Nuevo Personal</h4>

            <!-- este div es para mostrar los errorres de validacion 
                si hay errorres se muestra el div 
                y se hace un foreach de la coleccion de errores y se muestra
                en una lista -->

            <div class="alert alert-danger">
            </div>

            <!-- formulario para CARGA -->
            <form action="<?php echo $carpeta_trabajo;?>/controladores/personal/controller.personal.php" method="POST" autocomplete="off">
         
                 <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">  
                 <input type="hidden" name="accion" value="insertar">  
                 
                <div class="form-group">
                    <label for="observaciones">Observaciones</label>
                    <input type="text" class="form-control"  name="observaciones" placeholder="Ingrese..">
                </div>
                <div class="form-group">
                    <label for="legajo">Legajo</label>
                    <input type="text" class="form-control"  name="legajo" placeholder="Ingrese el legajo...">
                </div>
                <div class="form-group">
                    <label for="situacion"> Situacion</label>
                    <input type="text" class="form-control"  name="apellido" placeholder="Ingrese la situacion...">
                </div>
                <div class="form-group">
                    <label for="rela_persona">Persona</label> 
                    <Select class="form-control" name="rela_persona_id">
                    <option value="">Seleccione la Persona:</option>

                    <?php
                    $query = $conexion ->query("SELECT * from personas");
                    while ($pers = mysqli_fetch_array($query)){
                        echo "<option value='".$pers['persona_id']."'>".$pers['capellidos_persona'].' '.$pers['cnombres_persona'].'</option>';
                    }
                    ?>

                    </Select>
                <div class="form-group">
                    <label for="rela_cargo">Cargo</label>
                    <select class="form-control" name="tipo_cargo_id">
                        <option value='0'>Seleccione el cargo:</option>
                        <?php
                       $query = $conexion -> query("SELECT * FROM cargos");
                       while ($tipo_cargo = mysqli_fetch_array($query)){
                           echo '<option value=" '.$tipo_cargo['cargo_id'].'">'.$tipo_cargo['cdescripcion_cargo'].'</option>';
                       }
                        ?>
                    </select>
                </div>
                    </select>
                </div>    

                <div class="form-group">
                    <div class="row">
                        <div class="col-6">
                                <input type="button" class="btn btn-info"
                                onClick = "window.location.href = '<?php echo $carpeta_trabajo;?>/controladores/personal/controller.personal.php';"
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

