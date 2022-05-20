<?php 

  include ($absolute_include."vistas/plantillas/head.php"); 
   
  
  
  if (isset($_GET['error'])) 
  {
  
    echo "<br><br>
    <div class='col-lg-12'>
     <div class='card alert-danger'>
      <div class='card-body text-center'>
       Usuario o Contraseña Incorrecta !</div>
     </div></div>";
   
  } 

  ?> 

  <br><br>

  <div class="col-lg-12">
         <div class="card">
           <div class="card-body">
           <div class="card-title">Registrarse</div>
           <hr>
            <form method="POST" action="<?php echo $carpeta_trabajo;?>/administracion/register.php" enctype="multipart/form-data" autocomplete="off">
            <input type="hidden" name="accion" value="registrar">  

            <div class="form-group">
                <label>Perfil</label><br>
                <label for="perfil">
                <img src="<?php echo $carpeta_trabajo;?>/storage/usuarios/default.png" style="width:120px; height:120px; border-radius: 100px;" id="vista_previa">
                </label>
                <label id="info"></label>
                    
                <input hidden type="file" id="perfil" class="form-control" name="cimg_usuario" accept="image/png, image/gif, image/jpeg">
            </div>
            
            <div class="form-group">
                <label for="nombre">Usuario</label>
                <input type="text" class="form-control"  name="cnombre_usuario" placeholder="Ingrese el Nombre..." required>
            </div>

            <div class="form-group">
              <label for="nombre">Correo</label>
              <input type="email" class="form-control"  name="cemail_usuario" placeholder="Ingrese el Email..." required>
            </div>

           <div class="form-group">
            <label for="input-1">Contraseña</label>
            <input type="password" class="form-control" name="cpassword_usuario" placeholder="Ingrese su password" required>
           </div>

            <div class="form-group">
              <button type="submit" class="btn btn-light btn-block"><i class="fa fa-plus"></i> Registrarme</button>
            </div>

          </form>
           </div>

         </div>
         </div>
         
         <div>
   
         </div>
  </div>

<?php 

  include ($absolute_include."vistas/plantillas/footer.php"); 

?> 

<script>
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