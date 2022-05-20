<?php 


  include ($absolute_include."vistas/plantillas/head.php"); 
  include ($absolute_include."vistas/plantillas/sidebar.php"); 
  include ($absolute_include."vistas/plantillas/navbar.php"); 
 
  ?> 



        <h3 class="text-center">Ubicaciones</h3>
  <!--Start Dashboard Content-->
<div class="card-columns">
  <div class="card bg-light">
    <div class="card-body text-center">
      <p class="card-text"><a href="<?php echo $carpeta_trabajo;?>/controladores/paises/controller.paises.php">Paises</a></p>
    </div>
  </div>
  <div class="card bg-light">
    <div class="card-body text-center">
      <p class="card-text"><a href="<?php echo $carpeta_trabajo;?>/controladores/provincias/controller.provincias.php">Provincias</a></p>
    </div>
  </div>
  <div class="card bg-light">
    <div class="card-body text-center">
      <p class="card-text"><a href="<?php echo $carpeta_trabajo;?>/controladores/localidades/controller.localidades.php">Localidades</a></p>
    </div>
  </div>

  <div class="card bg-light">
    <div class="card-body text-center">
      <p class="card-text"><a href="<?php echo $carpeta_trabajo;?>/controladores/barrios/controller.barrios.php">Barrios</a></p>
    </div>
  </div>
  
  <div class="card bg-light">
    <div class="card-body text-center">
      <p class="card-text"><a href="<?php echo $carpeta_trabajo;?>/controladores/calles/controller.calles.php">Calles</a></p>
    </div>
  </div>
  <div class="card bg-light">
    <div class="card-body text-center">
      <p class="card-text"><a href="<?php echo $carpeta_trabajo;?>/controladores/telefonos/controller.telefonos.php">Telefonos</a></p>
    </div>
  </div>
  <div class="card bg-light">
    <div class="card-body text-center">
      <p class="card-text"><a href="<?php echo $carpeta_trabajo;?>/controladores/direcciones/controller.direcciones.php">Direcciones</a></p>
    </div>
  </div>
</div>
  




      <!--End Dashboard Content-->

<?php 

   include ($absolute_include."vistas/plantillas/footer.php"); 

?> 
 
 
 
