<?php 


  include ($absolute_include."vistas/plantillas/head.php"); 
  include ($absolute_include."vistas/plantillas/sidebar.php"); 
  include ($absolute_include."vistas/plantillas/navbar.php"); 
 
  ?> 



        <h1 class="text-center">Inicio</h1>
  <!--Start Dashboard Content-->
<div class="card-columns">
  <div class="card bg-light">
    <div class="card-body text-center">
      <p class="card-text"><a href="<?php echo $carpeta_trabajo;?>/controladores/archivos/controller.archivos.php">Archivos</a></p>
    </div>
  </div>
  <div class="card bg-light">
    <div class="card-body text-center">
      <p class="card-text"><a href="<?php echo $carpeta_trabajo;?>/controladores/consultas/controller.consultas.php">Consultas</a></p>
    </div>
  </div>
  <div class="card bg-light">
    <div class="card-body text-center">
      <p class="card-text"><a href="<?php echo $carpeta_trabajo;?>/controladores/movimientos/controller.movimientos.php">Movimientos</a></p>
    </div>
  </div>

  <div class="card bg-light">
    <div class="card-body text-center">
      <p class="card-text"><a href="<?php echo $carpeta_trabajo;?>/controladores/fondos/controller.fondos.php">Fondos</a></p>
    </div>
  </div>
  <div class="card bg-light">
    <div class="card-body text-center">
      <p class="card-text"><a href="<?php echo $carpeta_trabajo;?>/controladores/reportes/controller.reportes.php">Reportes</a></p>
    </div>
  </div>
  <div class="card bg-light">
    <div class="card-body text-center">
      <p class="card-text"><a href="<?php echo $carpeta_trabajo;?>/controladores/configuraciones/controller.configuraciones.php">Configuraciones</a></p>
    </div>
  </div>
</div>

      <!--End Dashboard Content-->

<?php 

   include ($absolute_include."vistas/plantillas/footer.php"); 

?> 
 
 
 
