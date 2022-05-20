<?php
 
  include ($absolute_include."vistas/plantillas/head.php"); 
  include ($absolute_include."vistas/plantillas/sidebar.php"); 
  include ($absolute_include."vistas/plantillas/navbar.php"); 
 
?> 

<div class="container">
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-12">
            <h4>Cambiar Contraseña</h4>

            <!-- este div es para mostrar los errorres de validacion 
                si hay errorres se muestra el div 
                y se hace un foreach de la coleccion de errores y se muestra
                en una lista -->

            
                <?php
                if (isset($_GET['codigo'])){
                    switch ($_GET['codigo']){
                        case 0: $desc = "Contraseña Incorrecta"; $color = "danger"; break;
                        case 1: $desc = "Contraseña Moficada"; $color = "success"; break;
                        case 2: $desc = "La nueva contraseña es igual a la anterior"; $color = "warning"; break;
                    }
                    echo "<div class='text-center alert alert-".$color."'>".$desc."</div>";
                }
                ?>

            <!-- formulario para ACTUALIZACION -->
            <form action="<?php echo $carpeta_trabajo;?>/controladores/perfil/controller.perfil.php" method="POST" enctype="multipart/form-data" autocomplete="off">
         
                 <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">  
                 <input type="hidden" name="accion" value="cambiar">  


                <div class="form-group">
                    <label for="nombre">Contraseña Anterior</label>
                    <input type="password" class="form-control"  name="old_password" placeholder="Ingrese la contraseña actual..." required>
                </div>

                <div class="form-group">
                    <label for="nombre">Nueva Contraseña</label>
                    <input type="password" class="form-control"  name="new_password" placeholder="Ingrese la nueva contraseña..." required>
                </div>



                <div class="form-group">
                    <div class="row">
                        <div class="col-6">
                                <input type="button" class="btn btn-info"
                                onClick = "window.location.href = '<?php echo $carpeta_trabajo;?>/controladores/inicio/controller.inicio.php';"
                                value=Volver>
                        </div>
                        <div class="text-right" >
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

<script>

    $("#reset").click(function(){
        $('#vista_previa').attr("src","<?php echo $GLOBALS['carpeta_trabajo']."/storage/usuarios/".$usuario['cimg_usuario'];?>");
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