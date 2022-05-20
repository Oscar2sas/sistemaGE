<?php 
  include ($absolute_include."vistas/plantillas/head.php"); 
  include ($absolute_include."vistas/plantillas/sidebar.php"); 
  include ($absolute_include."vistas/plantillas/navbar.php"); 
 
  ?> 

<h3 class="text-center">Documentos</h3>
  <!--Start Dashboard Content-->
<div class="card-columns">
  <div class="card bg-light">
      <div class="card-body text-center">
        <p class="card-text"><a href="<?php echo $carpeta_trabajo;?>/controladores/documentos/controller.documentospersonas.php">Documentos Personales</a></p>
      </div>
  </div>

  <div class="card bg-light">
      <div class="card-body text-center">
        <p class="card-text"><a href="<?php echo $carpeta_trabajo;?>/controladores/documentosvarios/controller.elementos.php">Documentos Varios</a></p>
      </div>
  </div>
</div> 
  <!--End Dashboard Content-->

<?php 

   include ($absolute_include."vistas/plantillas/footer.php"); 

?> 