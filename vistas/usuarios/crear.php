<?php
 
  include ($absolute_include."vistas/plantillas/head.php"); 
  include ($absolute_include."vistas/plantillas/sidebar.php"); 
  include ($absolute_include."vistas/plantillas/navbar.php"); 
 
?> 

<div class="container">
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-12">
            <h4>Nuevo Usuario</h4>

            <!-- este div es para mostrar los errorres de validacion 
                si hay errorres se muestra el div 
                y se hace un foreach de la coleccion de errores y se muestra
                en una lista -->

            <div class="alert alert-danger">
            </div>

            <!-- formulario para CARGA -->
            <form action="<?php echo $carpeta_trabajo;?>/controladores/usuarios/controller.usuarios.php" method="POST" enctype="multipart/form-data" autocomplete="off">
         
                 <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">  
                 <input type="hidden" name="accion" value="insertar">  

                <div class="form-group">
                    <label>Perfil</label><br>
                    <label for="perfil">
                    <img src="<?php echo $carpeta_trabajo;?>/storage/usuarios/default.png" style="width:120px; height:120px; border-radius: 100px;" id="vista_previa">
                    </label>
                    <label id="info"></label>
                    
                    <input hidden type="file" id="perfil" class="form-control" name="cimg_usuario" accept="image/png, image/gif, image/jpeg">
                </div>

                <div id="derecha">
                 
                <div class="form-group">
                    <label for="nombre">Usuario</label>
                    <input type="text" class="form-control"  name="cnombre_usuario" placeholder="Ingrese el Nombre..." required>
                </div>

                <div class="form-group">
                    <label for="nombre">Correo</label>
                    <input type="email" class="form-control"  name="cemail_usuario" placeholder="Ingrese el Email..." required>
                </div>

                <div class="form-group">
                    <label for="nombre">Contraseña</label>
                    <input type="password" class="form-control"  name="cpassword_usuario" placeholder="Ingrese la Contraseña..." required>
                </div>

                <div class="form-group">
                    <label for="nombre">Rol</label>
                    <select class="form-control" name="rela_rol_id" required>
                        <option value="" selected>---</option>
                        <?php foreach ($roles as $rol): ?>
                            <option value=<?php echo $rol['rol_id']; ?> > <?php echo $rol['cdescripcion_rol']; ?> </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-6">
                                <input type="button" class="btn btn-info"
                                onClick = "window.location.href = '<?php echo $carpeta_trabajo;?>/controladores/usuarios/controller.usuarios.php';"
                                value=Volver>
                        </div>
                        <div class="text-right" >
                                <button class="btn btn-success" type="submit">Guardar</button>
                                <span class="input-group-btn">
                                    <button class="btn btn-danger" id="reset" type="reset">Cancelar</button>  
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

<script>

    $("#reset").click(function(){
        $('#vista_previa').attr("src","<?php echo $GLOBALS['carpeta_trabajo']."/storage/usuarios/default.png";?>");
    });

    $("#perfil").change(mostrarImagen);


    function mostrarImagen(event) {
        //console.log(event)

        if( $("#file_error").length != 0 ){
            $("#file_error").remove();
        }

        var file = event.target.files[0];
        var reader = new FileReader();
        $("#info").html("Subiendo...");
        reader.onload = function(event) {
            $('#vista_previa').attr("src",event.target.result);
            $("#info").html("");
        }
        reader.readAsDataURL(file);
    }
</script>