<?php 


  include ($absolute_include."vistas/plantillas/head.php"); 
  include ($absolute_include."vistas/plantillas/sidebar.php"); 
  include ($absolute_include."vistas/plantillas/navbar.php"); 
 
  ?> 

<h3 class="text-center">Consultas</h3>
  <!--Start Dashboard Content-->
<div class="card-columns">
  
  <div class="card bg-light">
    <div class="card-body text-center">
      <p class="card-text"><a href="<?php echo $carpeta_trabajo;?>/controladores/consultas/legajos_alumnos/controller.legajos_alumnos.php">Legajos de Alumnos</a></p>
    </div>
  </div>
  <div class="card bg-light">
    <div class="card-body text-center">
      <p class="card-text"><a href="<?php echo $carpeta_trabajo;?>/controladores/consultas/historiales_alumnos/controller.historiales_alumnos.php">Historial de Alumnos</a></p>
    </div>
  </div>

  <div class="card bg-light">
    <div class="card-body text-center">
      <p class="card-text"><a href="<?php echo $carpeta_trabajo;?>/controladores/consultas/legajos_docentes/controller.legajos_docentes.php">Legajos de Docentes</a></p>
    </div>
  </div>

  <div class="card bg-light">
    <div class="card-body text-center">
      <p class="card-text"><a href="<?php echo $carpeta_trabajo;?>/controladores/consultas/historiales_docentes/controller.historiales_docentes.php">Historial de Docentes</a></p>
    </div>
  </div>

  <div class="card bg-light">
    <div class="card-body text-center">
      <p class="card-text"><a href="<?php echo $carpeta_trabajo;?>/controladores/consultas/legajos_personal/controller.legajos_personal.php">Legajos del Personal</a></p>
    </div>
  </div>

  <div class="card bg-light">
    <div class="card-body text-center">
      <p class="card-text"><a href="<?php echo $carpeta_trabajo;?>/controladores/consultas/historiales_personal/controller.historiales_personal.php">Historial del Personal</a></p>
    </div>
  </div>
</div>

 <hr>

<div class="card-columns">
  <div class="card bg-light">
      <div class="card-body text-center">
        <p class="card-text"><a href="<?php echo $carpeta_trabajo;?>/controladores/consultas/divisiones/controller.divisiones.php">Divisiones</a></p>
      </div>
   </div>

  <div class="card bg-light">
      <div class="card-body text-center">
        <p class="card-text"><a href="<?php echo $carpeta_trabajo;?>/controladores/documentos/controller.documentos.php">Documentos</a></p>
      </div>
  </div>

  <div class="card bg-light">
      <div class="card-body text-center">
        <p class="card-text"><a href="<?php echo $carpeta_trabajo;?>/controladores/log/controller.log.php">Log del Sistema</a></p>
      </div>
  </div>
</div>   
    

  <!--End Dashboard Content-->

<?php 

   include ($absolute_include."vistas/plantillas/footer.php"); 

?> 
 
 
 
