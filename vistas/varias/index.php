<?php 


  include ($absolute_include."vistas/plantillas/head.php"); 
  include ($absolute_include."vistas/plantillas/sidebar.php"); 
  include ($absolute_include."vistas/plantillas/navbar.php"); 
 
  ?> 



<h3 class="text-center">Tablas Varias</h3>
  <!--Start Dashboard Content-->
<div class="card-columns">
  <div class="card bg-light">
    <div class="card-body text-center">
      <p class="card-text"><a href="<?php echo $carpeta_trabajo;?>/controladores/cargos/controller.cargos.php">Cargos</a></p>
    </div>
  </div>
  <div class="card bg-light">
    <div class="card-body text-center">
      <p class="card-text"><a href="<?php echo $carpeta_trabajo;?>/controladores/estadoalumnos/controller.estadoalumnos.php">Estado de Alumnos</a></p>
    </div>
  </div>
  <div class="card bg-light">
    <div class="card-body text-center">
      <p class="card-text"><a href="<?php echo $carpeta_trabajo;?>/controladores/esadodocentes/controller.esadodocentes.php">Estado de Docentes</a></p>
    </div>
  </div>

  <div class="card bg-light">
    <div class="card-body text-center">
      <p class="card-text"><a href="<?php echo $carpeta_trabajo;?>/controladores/tiposdocumentos/controller.tiposdocumentos.php">Tipos de Documentos</a></p>
    </div>
  </div>

  <div class="card bg-light">
    <div class="card-body text-center">
      <p class="card-text"><a href="<?php echo $carpeta_trabajo;?>/controladores/sexos/controller.sexos.php">Sexos</a></p>
    </div>
  </div>
  
   <div class="card bg-light">
      <div class="card-body text-center">
        <p class="card-text"><a href="<?php echo $carpeta_trabajo;?>/controladores/etapas/controller.etapas.php">Etapas del A&nacute;o</a></p>
      </div>
    </div>
    

 </div>

      <!--End Dashboard Content-->

<?php 

   include ($absolute_include."vistas/plantillas/footer.php"); 

?> 
 
 
 
