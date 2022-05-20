<?php 

  include ($absolute_include."vistas/plantillas/head.php"); 
   
  
  
  if (isset($_GET['error'])) 
  {
    $error = $_GET['error'];
    switch($error){
      case 1: $des_error = "Contraseña Incorrecta"; break;
      case 2: $des_error = "Usuario no encontrado"; break;
      case 3: $des_error = "Usuario inhabilitado"; break;
      case 4: $des_error = "Esperando aprobacion de un administrador"; break;
    }
  
    echo "<br><br>
    <div class='col-lg-12'>
     <div class='card alert-danger'>
      <div class='card-body text-center'>
      ".$des_error."</div>
     </div></div>";
   
  } 

  ?> 

  <br><br>

  <div class="col-lg-12">
         <div class="card">
           <div class="card-body">
           <div class="card-title">Iniciar Sesion</div>
           <hr>
            <form method="POST" action="<?php echo $carpeta_trabajo;?>/administracion/autenticar.php">
           <div class="form-group">
            <label for="input-1">Usuario</label>
            <input type="email" placeholder="Ingrese su Email"  autofocus class="form-control" name="usuario" required>
           </div>
           <div class="form-group">
            <label for="input-1">Contraseña</label>
            <input type="password" autofocus class="form-control" name="password" placeholder="Ingrese su password" required>
           </div>
            <div class="form-group">
              <button type="submit" class="btn btn-light btn-block"><i class="icon-lock"></i> Iniciar Sesion</button>
            </div>
          </form>
            <div class="form-group">
                <a href="<?php echo $carpeta_trabajo;?>/administracion/register.php"><button type="submit" class="btn btn-light btn-block"><i class="fa fa-plus"></i> Registrarse</button></a>
            </div>
           </div>

         </div>
         </div>
         
         <div>
   
         </div>
  </div>

<?php 

  include ($absolute_include."vistas/plantillas/footer.php"); 

?> 