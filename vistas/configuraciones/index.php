<?php 


  include ($absolute_include."vistas/plantillas/head.php"); 
  include ($absolute_include."vistas/plantillas/sidebar.php"); 
  include ($absolute_include."vistas/plantillas/navbar.php"); 
 
  ?> 



<h3 class="text-center">Configuraciones</h3>
  <!--Start Dashboard Content-->
<div class="card-columns">
  <div class="card bg-light">
    <div class="card-body text-center">
      <p class="card-text"><a href="<?php echo $carpeta_trabajo;?>/controladores/usuarios/controller.usuarios.php">Usuarios</a></p>
    </div>
  </div>

  <div class="card bg-light">
      <div class="card-body text-center">
        <p class="card-text"><a href="<?php echo $carpeta_trabajo;?>/controladores/log/controller.log.php">Log del Sistema</a></p>
      </div>
  </div>

  <div class="card bg-light">
    <div class="card-body text-center">
      <p class="card-text"><a href="<?php echo $carpeta_trabajo;?>/controladores/roles/controller.roles.php">Roles de Usuarios</a></p>
    </div>
  </div>

</div>

<hr>

<div class="card-columns">
    
   <div class="card bg-light">
      <div class="card-body text-center">
        <p class="card-text"><a href="<?php echo $carpeta_trabajo;?>/controladores/usuarios/controller.usuarios.php">Cambiar Clave de Usuario</a></p>
      </div>
    </div>    

   <div class="card bg-light">
      <div class="card-body text-center">
        <p class="card-text"><a href="<?php echo $carpeta_trabajo;?>/controladores/parametros/controller.parametros.php">Parametros del Sistema</a></p>
      </div>
    </div>
 

</div>
  
      <!--End Dashboard Content-->

<?php 

   include ($absolute_include."vistas/plantillas/footer.php"); 

?> 
 
 
 
